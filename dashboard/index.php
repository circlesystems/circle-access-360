<?php
	
session_start();

if ($_REQUEST["logout"] == "1"){
	session_destroy();
	unset($_SESSION["userID"]);
	unset($_SESSION["isAdmin"]);
}
	
if (!isset($_SESSION["userID"]) || !isset($_SESSION["isAdmin"])) {
	unset($_SESSION["userID"]);
	unset($_SESSION["isAdmin"]);
	header("Location: ../");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Logged In Page</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container">
                <a class="navbar-brand" href="#!">Circle 360 - Demo</a>
                <a class="btn btn-primary" href="#" onclick="logout();" style="background-color: #3EBAB6; border: #3EBAB6;">Logout</a>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center text-white">
                            <!-- Page heading-->
                            <h1 class="mb-5">Admin successfully logged in!</h1>
                                                       
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <br><br>
     <footer style="background-color: white;">
      <section>
        <div class="container text-center">
          <div class="row">
            <div class="col-md-8 mx-auto">
              <ul class="list-inline list-unstyled">
              </ul>
              <a href="https://dev.gocircle.ai/developer-hub/demos/">
              <img src="https://circleauth.gocircle.ai/img/circle-logo-nocompromise.svg" alt="">
              </a>
              <p class="small text-muted mb-0">
                ©2022 Circle Systems, Inc. All rights reserved.
              </p>
              <a class="small text-muted" href="https://circleauth.gocircle.ai/legal">Privacy Policy and Terms of Use</a>
            </div>
          </div>
        </div>
      </section>
    </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
<script>
function logout() {
	location.href = "./?logout=1";
}
</script>
