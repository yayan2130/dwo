<?php

include "koneksi.php";

// mengaktifkan session
session_start();

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login"){
	header("location:index.php");
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
                                    <li class="breadcrumb-item"><a href="#">About</a></li>
                                </ol>
                            </div>
                            <h4 class="page-title">Our Team</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->

                <div class="row">
                    
                    <div class="col-sm">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Member</h4>

                            <div class="widget-chart text-center">

                            <img src="randi.jpg" alt="user" class="rounded-circle" style="height: 150px"><br>
                            <h4>Arrandi Muhamad Riesta</h4><br>

                                <div class="row text-center">
                                    <div class="col-sm">
                                        <p class="text-muted m-b-5">Nomor Induk Mahasiswa</p>
                                        <h4 data-plugin="counterup">18082010005</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Leader</h4>

                            <div class="widget-chart text-center">

                            <img src="januar.jpeg" alt="user" class="rounded-circle" style="height: 190px"><br>
                            <h4>Muhammad Januar Pribadi</h4><br>

                                <div class="row text-center">
                                    <div class="col-sm">
                                        <p class="text-muted m-b-5">Nomor Induk Mahasiswa</p>
                                        <h4 data-plugin="counterup">18082010027</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Member</h4>

                            <div class="widget-chart text-center">

                            <img src="carena.jpg" alt="user" class="rounded-circle" style="height: 150px"><br>
                            <h4>Carena Learns Prasetyo</h4><br>

                                <div class="row text-center">
                                    <div class="col-sm">
                                        <p class="text-muted m-b-5">Nomor Induk Mahasiswa</p>
                                        <h4 data-plugin="counterup">18082010042</h4>
                                    </div>
                                </div>
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
				name: "Pendapatan By Kategori",
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