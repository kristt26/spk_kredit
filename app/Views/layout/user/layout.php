<!doctype html>
<html class="no-js" lang="en" ng-app="apps" ng-controller="indexController">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{titleHeader}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/metisMenu.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="/assets/css/typography.css">
    <link rel="stylesheet" href="/assets/css/default-css.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="/assets/js/vendor/modernizr-2.8.3.min.js"></script>

    <link href="https://opensource.propeller.in/components/card/css/card.css" type="text/css" rel="stylesheet" />

    <!-- Example docs (CSS for helping component example file)-->
    <link href="https://opensource.propeller.in/docs/css/example-docs.css" type="text/css" rel="stylesheet" />

    <!-- Propeller typography (CSS for helping component example file) -->
    <link href="https://opensource.propeller.in/components/typography/css/typography.css" type="text/css" rel="stylesheet" />

    <!-- Google Icon Font -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- <link href="css/google-icons.css" type="text/css" rel="stylesheet" /> -->

    <!-- Propeller Checkbox -->
    <link href="https://opensource.propeller.in/components/checkbox/css/checkbox.css" type="text/css" rel="stylesheet" />

    <!-- Propeller textfield -->
    <link href="https://opensource.propeller.in/components/textfield/css/textfield.css" type="text/css" rel="stylesheet" />

    <!-- Propeller Radio -->
    <link href="https://opensource.propeller.in/components/radio/css/radio.css" type="text/css" rel="stylesheet" />

    <!-- Propeller Toggle -->
    <link href="https://opensource.propeller.in/components/toggle-switch/css/toggle-switch.css" type="text/css" rel="stylesheet" />
    
</head>

<body class="body-bg">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- main wrapper start -->
    <div class="horizontal-main-wrapper">
        <!-- main header area start -->
        <div class="mainheader-area" style="background: #52b8eb;border-bottom: 1px solid #50a8d5;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="/"><img src="/assets/images/logo2.png" alt="logo" width="40%"></a>
                        </div>
                    </div>
                    <div class="col-md-9 clearfix text-right">
                        <div class="d-md-inline-block d-block mr-md-4">
                            <ul class="notification-area">
                                <li id="full-view"><i class="ti-fullscreen"></i></li>
                                <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= view('layout/user/menu'); ?>
        <div class="main-content-inner">
            <div class="container">
                <?= $this->renderSection("content") ?>
            </div>
        </div>
        <footer class="footer">
            <div class="footer-area">
                <p>© Copyright 2024. BAZNAS-BMFi by Oktagon Cendrawasih Solution</p>
            </div>
        </footer>
    </div>
    <script src="/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/metisMenu.min.js"></script>
    <script src="/assets/js/jquery.slimscroll.min.js"></script>
    <script src="/assets/js/jquery.slicknav.min.js"></script>
    <script src="/assets/js/plugins.js"></script>
    <script src="/assets/js/scripts.js"></script>

    <script src="/libs/angular/angular.min.js"></script>
    <script src="/js/apps.js"></script>
    <script src="/js/services/helper.services.js"></script>
    <script src="/js/services/auth.services.js"></script>
    <script src="/js/services/admin.services.js"></script>
    <script src="/js/services/pesan.services.js"></script>
    <script src="/js/controllers/admin.controllers.js"></script>
    <script src="/js/components/components.js"></script>
    <script src="/libs/angular-ui-select2/src/select2.js"></script>
    <script src="/libs/angular-datatables/dist/angular-datatables.js"></script>
    <script src="/libs/angular-locale_id-id.js"></script>
    <script src="/libs/input-mask/angular-input-masks-standalone.min.js"></script>
    <script src="/libs/jquery.PrintArea.js"></script>
    <script src="/libs/angular-base64-upload/dist/angular-base64-upload.min.js"></script>
    <script src="/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="/libs/datatables/btn.js"></script>
    <script src="/libs/datatables/print.js"></script>
    <script src="/libs/loading/dist/loadingoverlay.min.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    <!-- Propeller Global js -->
    <script src="https://opensource.propeller.in/components/global/js/global.js"></script>

    <!-- Propeller checkbox js -->
    <script type="text/javascript" src="https://opensource.propeller.in/components/checkbox/js/checkbox.js"></script>

    <!-- Propeller checkbox js -->
    <script type="text/javascript" src="https://opensource.propeller.in/components/textfield/js/textfield.js"></script>

    <!-- Propeller checkbox js -->
    <script type="text/javascript" src="https://opensource.propeller.in/components/radio/js/radio.js"></script>
</body>

</html>