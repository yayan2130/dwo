<?php

include "koneksi.php";

// mengaktifkan session
session_start();

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login"){
	header("location:index.php");
}

//Query chart pertama

//query untuk tahu SUM(Amount) semuanya
$sql = "SELECT sum(amount) as tot from fakta_pendapatan";
$tot = mysqli_query($mysqli, $sql);
$tot_amount = mysqli_fetch_row($tot);

//echo $tot_amount[0]

//query untuk ambil penjualan berdasarkan kategori, query sudah dimodfikasi
//ditambahkan label variabel DATA.

$sql = "SELECT concat('name:',s.nama_kota) as name, concat('y:', sum(fp.amount)*100/" . $tot_amount[0] . ") as y, concat('drilldown:', s.nama_kota) as drilldown
        FROM store s
        JOIN fakta_pendapatan fp ON (s.store_id = fp.store_id)
        GROUP BY name
        ORDER BY y DESC";
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
            date_format(t.tanggallengkap, '%M') as bulan,
            sum(fp.amount) as pendapatan_kat
            FROM store s
            JOIN fakta_pendapatan fp ON (s.store_id = fp.store_id)
            JOIN time t ON (t.time_id = fp.time_id)
            GROUP BY store, bulan";
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

$result = mysqli_query($mysqli, "SELECT sum(amount) as tot from fakta_pendapatan");

while ($row = $result->fetch_assoc()) {
    $total_pendapatan[] = $row['tot'];
}

$result2 = mysqli_query($mysqli, "SELECT count(customer_id) as tot from fakta_pendapatan");

while ($row2 = $result2->fetch_assoc()) {
    $total_transaksi[] = $row2['tot'];
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Chart - Made from HighChart</title>
        <link rel="shortcut icon" href="lg.png">

        <!-- C3 charts css -->
        <link href="../plugins/c3/c3.min.css" rel="stylesheet" type="text/css"  />

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>

        <script src="https://code.highcharts.com/highcharts.js"></script>
	    <script src="https://code.highcharts.com/modules/data.js"></script>
	    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
	    <script src="https://code.highcharts.com/modules/exporting.js"></script>
	    <script src="https://code.highcharts.com/modules/export-data.js"></script>
	    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    </head>


    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo container-->
                    <div class="logo">
                        <a href="example.php" class="logo">
                            <img src="logo.png" alt="" height="24" class="logo-lg">
                        </a>
                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras topbar-custom">
                        <ul class="list-inline float-right mb-0">
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="user.png  " alt="user" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="text-overflow"><small>Welcome! <?php echo $_SESSION['username']; ?></small> </h5>
                                    </div>

                                    <!-- item-->
                                    <a href="logout.php" class="dropdown-item notify-item">
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- end menu-extras -->
                
                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                            <li class="has-submenu">
                                <a href="example.php"><i class="fi-air-play"></i>Example</a>
                            </li>

                            <li class="has-submenu">
                                <a href="chart_1.php"><i class="fi-briefcase"></i>Chart 1</a>
                            </li>

                            <li class="has-submenu">
                                <a href="chart_2.php"><i class="fi-box"></i>Chart 2</a>
                            </li>

                            <li class="has-submenu">
                                <a href="chart_3.php"><i class="fi-paper"></i>Chart 3</a>
                            </li>

                            <li class="has-submenu">
                                <a href="about.php"><i class="fi-briefcase"></i>About</a>
                            </li>
                        </ul>
                        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="btn-group pull-right">
                                <ol class="breadcrumb hide-phone p-0 m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Chart</a></li>
                                    <li class="breadcrumb-item"><a href="#">Chart 1</a></li>
                                </ol>
                            </div>
                            <h4 class="page-title">Chart Example</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->

                <div class="row">
                    
                    <div class="col-xl-6 col-lg-6">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Number of Transactions</h4>

                            <div class="widget-chart text-center">

                                <span class="highcharts-figure">
                                    <div id="container" style="height: 270px;">   
                                    <p class="highcharts-description"></p>
                                </span></div>

                                <div class="row text-center m-t-30">
                                <div class="col-6">
                                        <h3 data-plugin="counterup"><?php echo $total_pendapatan[0]; ?></h3>
                                        <p class="text-muted m-b-5">Total Penjualan ($)</p>
                                    </div>
                                    <div class="col-6">
                                        <h3 data-plugin="counterup"><?php echo $total_transaksi[0]; ?></h3>
                                        <p class="text-muted m-b-5">Total transaksi</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-6 col-lg-6">
                        <div class="card-box">
                            <div class="widget-chart text-center">
                                <iframe name="mondrian" src="http://localhost:8080/mondrian/index.html" style="height: 423px; width:100%; border:none; align-content:center">
                                </iframe>                                
                            </div>                            
                        </div>
                    </div>

                </div>
                <!--- end row -->

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="index.html" class="logo">
                            <img src="logo.png" alt="" height="24" class="logo-lg">
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- Counter js  -->
        <script src="../plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="../plugins/counterup/jquery.counterup.min.js"></script>

        <!--C3 Chart-->
        <script type="text/javascript" src="../plugins/d3/d3.min.js"></script>
        <script type="text/javascript" src="../plugins/c3/c3.min.js"></script>

        <!--Echart Chart-->
        <script src="../plugins/echart/echarts-all.js"></script>

        <!-- Dashboard init -->
        <script src="assets/pages/jquery.dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        
        
        <script type="text/javascript">
		// Create the chart
		Highcharts.chart('container', {
			chart: {
				type: 'pie'
			},
			title: {
				text: ''
			},

			accessibility: {
				announceNewData: {
					enabled: true
				},
				point: {
					valueSuffix: '%'
				}
			},



			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
			},

			series: [{
				name: "Pendapatan berdasarkan Toko",
				colorByPoint: true,
				data: <?php
						//TEKNIK GAK JELAS :D

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
					//TEKNIK CLEAN
					echo $string_data;

					?>



				]
			}
		});
	</script>
    </body>
</html>