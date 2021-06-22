<?php
$dbHost = "localhost";
$dbDatabase = "whsakila2021";
$dbUser = "root";
$dbPassword = "";

$mysqli = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbDatabase);

//Query chart pertama

//query untuk tahu SUM(Amount) semuanya
$sql = "SELECT sum(amount) as tot from fakta_pendapatan";
$tot = mysqli_query($mysqli, $sql);
$tot_amount = mysqli_fetch_row($tot);

//echo $tot_amount[0]

//query untuk ambil penjualan berdasarkan kategori, query sudah dimodfikasi
//ditambahkan label variabel DATA.

$sql = "SELECT concat('name:',t.time_id) as name, concat('y:', sum(fp.amount)) as y, concat('drilldown:', t.time_id) as drilldown
FROM time t
JOIN fakta_pendapatan fp ON (t.time_id = fp.time_id)
GROUP BY name
ORDER BY name asc";
//echo $sql;
$all_kat = mysqli_query($mysqli, $sql);

while ($row = mysqli_fetch_all($all_kat)) {
    $data[] = $row;
}

$json_all_kat = json_encode($data);

//chart kedua (drill down)

//query untuk tahu SUM(amount) semua store
$sql = "SELECT s.nama_kota store, sum(fp.amount) as tot_kat
        FROM fakta_pendapatan fp
        JOIN store s ON (s.store_id = fp.store_id)
        GROUP BY store";
$hasil_kat = mysqli_query($mysqli, $sql);

while ($row = mysqli_fetch_all($hasil_kat)) {
    $tot_all_kat[] = $row;
}

//print_r($tot_all_kat);
//function untuk mencari total_per_kat

//echo count($tot_per_kat[0]);
//echo $tot_per_kat[0][0][1];

function cari_tot_kat($kat_dicari, $tot_all_kat)
{
    $counter = 0;
    //echo $tot_all_kat[0];
    while ($counter < count($tot_all_kat[0])) {
        if ($kat_dicari == $tot_all_kat[0][$counter][0]) {
            $tot_kat = $tot_all_kat[0][$counter][1];
            return $tot_kat;
        }
        $counter++;
    }
}

//query untuk ambil penjualan dii store  berdasarkan bulan (clean)
$sql = "SELECT s.nama_kota store,
            f.kategori kategori,
            sum(fp.amount) as pendapatan_kat
            FROM store s
            JOIN fakta_pendapatan fp ON (s.store_id = fp.store_id)
            JOIN film f ON (f.film_id = fp.film_id)
            GROUP BY store, kategori";
$det_kat = mysqli_query($mysqli, $sql);
$i = 0;
while ($row = mysqli_fetch_all($det_kat)) {
    //echo $row;
    $data_det[] = $row;
}

//print_r($data_det);

//persiapan data drill down clean
$i = 0;

//inisiasi string data
$string_data = "";
$string_data .= '{name :"' . $data_det[0][$i][0] . '", id:"' . $data_det[0][$i][0] . '", data: [';


//echo cari tot_kat ("action", $tot_all_kat);
foreach ($data_det[0] as $a) {
    //echo cari_tot_kat($a[0], $tot_all_kat);

    if ($i < count($data_det[0]) - 1) {
        if ($a[0] != $data_det[0][$i + 1][0]) {
            $string_data .= '["' . $a[1] . '", ' . $a[2] * 100 / cari_tot_kat($a[0], $tot_all_kat) . ']]},';

            $string_data .= '{name:"' . $data_det[0][$i + 1][0] . '", id:"' . $data_det[0][$i + 1][0]   . '", data: [';
        } else {
            $string_data .= '["' . $a[1] . '", ' .
                $a[2] * 100 / cari_tot_kat($a[0], $tot_all_kat) . '], ';
        }
    } else {

        $string_data .= '["' . $a[1] . '", ' .
            $a[2] * 100 / cari_tot_kat($a[0], $tot_all_kat) . ']]}';
    }
    $i = $i + 1;
}




?>

<html>

<head>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessbility.js"></script>
    <link rel="stylesheet" href="/drilldown.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js">

    </script>

</head>

<body>
    <figure class="highcharts-figure">
        <div id="container"></div>
        <p class="hiighcharts-description">
        </p>
    </figure>
    <script type="text/javascript">
        //create chart
        Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'persentase nilai penjualan (wh sakila) - semua kategori'
            },
            subtitle: {
                text: 'klik di potongan kue untuk melihat detil nilai penjualan kategori berdasarkan bulan'
            },

            accessbility: {
                announceNewDate: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <br>{point.y:.2f}%</b> of total<br/>'
            },

            series: [{
                name: "pendapatan by kategori",
                colorByPoint: true,
                data: <?php
                        $datanya = $json_all_kat;
                        $data1 = str_replace('["', '{"', $datanya);
                        $data2 = str_replace('"]', '"}', $data1);
                        $data3 = str_replace('[[', '[', $data2);
                        $data4 = str_replace(']]', ']', $data3);
                        $data5 = str_replace(':', '" : "', $data4);
                        $data6 = str_replace('"name"', 'name', $data5);
                        $data7 = str_replace('"drilldown"', 'drilldown', $data6);
                        $data8 = str_replace('"y"', 'y', $data7);
                        $data9 = str_replace('",', ',', $data8);
                        $data10 = str_replace(',y', '",y', $data9);
                        $data11 = str_replace(',y : "', ',y : ', $data10);
                        echo $data11;

                        ?>
            }],
            drilldown: {
                series: [

                    <?php
                    //teknik clean
                    echo $string_data;

                    ?>
                ]
            }
        });
    </script>
    <br>
    <iframe name="mondrian" src="http://localhost:8080/mondrian/testpage.jsp?query=whsakila" style="height:100%; width:100%; border:none; align-content:center">
    </iframe>
</body>

</html>