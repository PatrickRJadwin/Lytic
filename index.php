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

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css">  
  <link rel="stylesheet" href="assets/vendor/fonts/ionicons.css">
  <link rel="stylesheet" href="assets/vendor/fonts/linearicons.css">

  <link rel="stylesheet" href="assets/vendor/css/bootstrap.css">
  <link rel="stylesheet" href="assets/vendor/css/appwork.css">
  <link rel="stylesheet" href="assets/vendor/css/theme-corporate.css">
  <link rel="stylesheet" href="assets/vendor/css/colors.css">
  <link rel="stylesheet" href="assets/vendor/css/uikit.css">

  <script src="assets/vendor/js/layout-helpers.js"></script>

  <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">

  <link rel="stylesheet" href="css/loader.css" />

</head>
<div id="preloader">
  <div id="status">&nbsp;</div>
</div>
<body>
  <div class="layout-wrapper layout-1">
    <div class="layout-inner">
      <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-navbar-theme container-p-x bg-dark" id="layout-navbar">
        <a href="index.php" class="navbar-brand"><img src="pics/logo.png" style="width: 40px;"/></a>
        <div class="navbar-nav align-items-lg-center mr-auto">
            <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-2 ml-1">|</div>
              <div class="demo-navbar-user nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                  <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                    <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?php require_once "php/username.php"?></span>
                  </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="php/logout.php" class="dropdown-item" onclick="sessionStorage.clear();">
                    <i class="ion ion-ios-log-out text-danger"></i> &nbsp; Log Out</a>
                </div>
              </div>
        </div>
      </nav>
      <div class="layout-container">
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
                  <a class="twitter-timeline" data-lang="en" data-width="2600" data-height="350" data-theme="light" data-link-color="#2B7BB9" data-chrome="nofooter" href="https://twitter.com/WSJmarkets">
                  </a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 col-xl-3">
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="ion ion-md-book display-4 text-primary"></div>
                      <div class="ml-3">
                        <div class="text-muted small">Stock Price</div>
                        <div class="text-large">$<span id="closing"></span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3">
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="ion ion-md-arrow-dropup-circle display-4 text-primary" id="arrow"></div>
                      <div class="ml-3">
                        <div class="text-muted small">Movement</div>
                        <div class="text-large" id="txtColor"><span id="pointChng"></span> / <span id="percChng"></span>%</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3">
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="ion ion-md-calendar display-4 text-primary"></div>
                      <div class="ml-3">
                        <div class="text-muted small">YTD</div>
                        <div class="text-large" id="ytdColor"><span id="ytd"></span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3">
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="ion ion-md-alarm display-4 text-primary"></div>
                      <div class="ml-3">
                        <div class="text-muted small">Previous Close</div>
                        <div class="text-large">$<span id="preClose"></span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mb-5">
              <h6 class="card-header with-elements">
                <div class="card-header-title">Pick a stock, or search for a symbol</div>
                <div class="card-header-elements ml-auto">
                  <label class="text m-0">
                    <span class="text-light text-tiny font-weight-semibold align-middle">
                      <div class="btn-toolbar">
                        <div class="btn-group">
                          <button id="changestockbtn" type="button" onclick="showDelete();" class="btn btn-default"><i class="fas fa-cog"></i></button>
                        </div> 
                        <div class="btn-group">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Time-Span</button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0)" onclick="timeChng(1, 'day')">1 minute</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="timeChng(10, 'day')">10 minute</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="timeChng(30, 'day')">30 minute</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="timeChng(60, 'day')">1 hour</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="timeChng(1, 'month')">Month</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="timeChng(1, 'year')">Year</a>
                          </div>
                        </div>
                        
                      </div>
                    </span>
                  </label>
                </div>
              </h6>
              <div class="row no-gutters no-bordered" id="refresh">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                  <div class="card-body" style="height: 100%; max-height: 400px; overflow: scroll; overflow-x: hidden;">
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
                  <div class="card-body">
                    <div id="curve_chart" style="height: 95%; min-height: 400px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-sidenav-toggle"></div>
  </div>
  <footer>
    <nav class="layout-footer footer bg-dark">
      <div class="container text-center py-4">
        <div class="pb-3">
          <p style="color: rgb(200, 200, 200)" class="footer-text font-weight-normal">Data provided for free by <a href="https://iextrading.com/developer/">IEX</a>. View IEX’s <a href="https://iextrading.com/api-exhibit-a/">Terms of Use.</a></p>
        </div>
      </div>
    </nav>
  </footer>
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="assets/vendor/libs/popper/popper.js"></script>
  <script src="assets/vendor/js/bootstrap.js"></script>
  <script src="assets/vendor/js/sidenav.js"></script>
  <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="assets/js/main.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="stocks/stocks.js"></script>
</body>
</html>
