<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location:pages/login.php");
    }
?>

<!DOCTYPE html>

<html lang="en" class="default-style">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

  <title>'Lytic</title>

  <!-- Main font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <!-- Icons. Uncomment required icon fonts -->
  <!-- <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css"> -->
  <link rel="stylesheet" href="assets/vendor/fonts/ionicons.css">
  <link rel="stylesheet" href="assets/vendor/fonts/linearicons.css">
  <!-- <link rel="stylesheet" href="assets/vendor/fonts/open-iconic.css"> -->
  <!-- <link rel="stylesheet" href="assets/vendor/fonts/pe-icon-7-stroke.css"> -->

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="assets/vendor/css/bootstrap.css">
  <link rel="stylesheet" href="assets/vendor/css/appwork.css">
  <link rel="stylesheet" href="assets/vendor/css/theme-corporate.css">
  <link rel="stylesheet" href="assets/vendor/css/colors.css">
  <link rel="stylesheet" href="assets/vendor/css/uikit.css">

  <!-- Layout helpers -->
  <script src="assets/vendor/js/layout-helpers.js"></script>

  <!-- Libs -->

  <!-- `perfect-scrollbar` library required by SideNav plugin -->
  <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">

</head>
<body>

  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-1">
    <!-- Layout inner -->
    <div class="layout-inner">


      <!-- Layout navbar -->
      <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-navbar-theme container-p-x bg-dark" id="layout-navbar">
        <a href="index.html" class="navbar-brand"><img src="pics/logo.png" style="width: 40px;"/></a>

        <!-- Sidenav toggle -->
        <div class="layout-sidenav-toggle navbar-nav align-items-lg-center mr-auto mr-lg-4">
          <a class="nav-item nav-link px-0 ml-2" href="javascript:void(0)">
            <i class="ion ion-md-menu text-large align-middle"></i>
          </a>
        </div>

        <div class="mr-lg-4">
          <a class="nav-item nav-link px-0 ml-2" href="pages/logout.php">Logout</a>
        </div>

        <!-- Navbar toggle -->
        <button class="navbar-toggler" id="toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="layout-navbar-collapse">
          <div class="navbar-nav align-items-lg-center">
          </div>
        </div>
      </nav>
      <!-- / Layout navbar -->

      <div class="layout-container">

        <!-- Layout sidenav -->
        <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-sidenav-theme">
          <ul class="sidenav-inner py-1">
            <li class="sidenav-item active">
              <a href="index.html" class="sidenav-link"><i class="sidenav-icon ion ion-ios-contact"></i><div>Dashboard</div></a>
            </li>
          </ul>
        </div>
        <!-- / Layout sidenav -->

        <div class="layout-content">
          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <h4 class="font-weight-bold py-3 mb-4">
                  <span id="stckName"></span>
                  <div class="text-muted text-tiny mt-1">
                    <small class="font-weight-normal"><span id="symbol"></span><span id="sector"></span></small>
                  </div>
                  <div class="form-group" style="padding-top: 20px;">
                    <div class="input-group">
                      <input type="text" class="form-control" id="srchbx" placeholder="Search by symbol...">
                      <span class="input-group-prepend">
                        <button class="btn btn-secondary" type="button" id="srchbtn" onclick="search();">Go!</button>
                      </span>
                    </div>
                  </div>
                  <div class="mt-3">
                    <button type="button" id="newStockBtn" class="btn btn-lg btn-primary" onclick="addStock();" style="margin-top: 25%;">Add Stock</button>
                  </div>
                </h4>
              </div>
              <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
              </div>
              <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="card mb-4">
                  <a id="twitter" class="twitter-timeline" data-lang="en" data-width="2600" data-height="290" data-theme="light" data-link-color="#2B7BB9" data-chrome="nofooter" href="#">
                  </a>
                </div>
              </div>
            </div>
            <hr class="border-light container-m--x my-0">
            <div class="row no-gutters row-bordered row-border-light container-m--x">
              <div class="col-sm-6 col-md-3 col-lg-6 col-xl-3">
                <div class="d-flex align-items-center container-p-x py-4">
                  <div class="ion ion-md-book display-4 text-primary"></div>
                  <div class="ml-3">
                    <div class="text-muted small">Stock Price</div>
                    <div class="text-large">$<span id="closing"></span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-lg-6 col-xl-3">
                <div class="d-flex align-items-center container-p-x py-4">
                  <div class="ion ion-md-arrow-dropup-circle display-4 text-primary" id="arrow"></div>
                  <div class="ml-3">
                    <div class="text-muted small">Movement</div>
                    <div class="text-large" id="txtColor"><span id="pointChng"></span> / <span id="percChng"></span>%</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-lg-6 col-xl-3">
                <div class="d-flex align-items-center container-p-x py-4">
                  <div class="ion ion-md-calendar display-4 text-primary"></div>
                  <div class="ml-3">
                    <div class="text-muted small">YTD</div>
                    <div class="text-large" id="ytdColor"><span id="ytd"></span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-lg-6 col-xl-3">
                <div class="d-flex align-items-center container-p-x py-4">
                  <div class="ion ion-md-alarm display-4 text-primary"></div>
                  <div class="ml-3">
                    <div class="text-muted small">Previous Close</div>
                    <div class="text-large">$<span id="preClose"></span></div>
                  </div>
                </div>
              </div>
            </div>
            <hr class="border-light container-m--x my-0">
            <div class="row container-m--x" style="height: 100%; max-height: 400px;">
              <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <div class="card mb-4" style="height: 95%;">
                  <h6 class="card-header">Pick a Stock</h6>
                  <div class="table-responsive">
                    <table class="table card-table" >
                      <tbody>
                        <?php
                            require_once "php/quer_stocks.php"    
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                <div class="card mb-4" style="height: 85%; max-height: 400px;">
                  <div id="curve_chart" style="height: 90%; max-height: 400px;"></div>
                </div>
              </div>

            </div>
            <hr class="border-light container-m--x my-0">
            <!-- Page content -->
          </div>
          <!-- / Page content -->

        </div>
      </div>

    </div>
    <!-- Layout inner -->

    <div class="layout-overlay layout-sidenav-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core scripts -->
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="assets/vendor/libs/popper/popper.js"></script>
  <script src="assets/vendor/js/bootstrap.js"></script>
  <script src="assets/vendor/js/sidenav.js"></script>
  <!-- `perfect-scrollbar` library required by SideNav plugin -->
  <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <!-- Main script -->
  <script src="assets/js/main.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="stocks/stocks.js"></script>
</body>
</html>