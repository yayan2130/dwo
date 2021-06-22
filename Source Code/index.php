<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Chart - Made from HighChart</title>
      <link rel="shortcut icon" href="lg.png">

      <!-- C3 charts css -->
      <link href="../plugins/c3/c3.min.css" rel="stylesheet" type="text/css"  />

      <!-- App css -->
      <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
      <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

      <script src="assets/js/modernizr.min.js"></script>

      <script src="https://code.highcharts.com/highcharts.js"></script>
	    <script src="https://code.highcharts.com/modules/data.js"></script>
	    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
	    <script src="https://code.highcharts.com/modules/exporting.js"></script>
	    <script src="https://code.highcharts.com/modules/export-data.js"></script>
	    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
      <link rel="stylesheet" href="assets/css/login.css">

    </head>


    <body>
      <main class="d-flex align-items-center min-vh-100 py-3">
        <div class="container ">
          <div class="card login-card ">
            <div class="row no-gutters ">
              <div class="col-md-5">
                <img src="login bg.jpg" alt="login" class="login-card-img">
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <div class="brand-wrapper">
                    <img src="logo.png" alt="logo" class="logo">
                  </div>
                  <p class="login-card-description">Sign into your account</p>
                  
                    <form action="login.php" method="post" onSubmit="return validasi()">
                      <div class="form-group">
                        <label for="username" class="sr-only">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                      </div>
                      <div class="form-group mb-4">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                      </div>
                      <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
                    </form>

                      <a href="#!" class="forgot-password-link">Forgot password?</a>
                      <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>

                    <nav class="login-card-footer-nav">
                      <a href="#!">Terms of use.</a>
                      <a href="#!">Privacy policy</a>
                    </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

      <script type="text/javascript">
	      function validasi() {
		        var username = document.getElementById("username").value;
		        var password = document.getElementById("password").value;	

		      if (username != "" && password!="") {
			    return true;
		      }else{
			      alert('Username dan Password harus di isi !');
			      return false;
		      }
	      }
 
</script>
  </body>
</html>