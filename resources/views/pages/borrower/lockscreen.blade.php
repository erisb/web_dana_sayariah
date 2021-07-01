<!doctype html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Dasbor - Penerima Dana &amp; LockScreen</title>

        <meta name="author" content="dsiteam">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="Dana Syariah - Dasbor Penerima Dana &amp; UI Framework V3">
        <meta property="og:site_name" content="Dana Syariah">
        <meta property="og:description" content="Dana Syariah - Dasbor Penerima Dana &amp; UI Framework V3">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="assetsBorrower/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assetsBorrower/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assetsBorrower/media/favicons/apple-touch-icon-180x180.png">
        <!-- END Icons -->

        <!-- Stylesheets -->

        <!-- Fonts and Codebase framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="assetsBorrower/css/codebase.min.css">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <link rel="stylesheet" id="css-theme" href="assetsBorrower/css/themes/flat.css">
        <!-- END Stylesheets -->
    </head>
    <body>
        <div id="page-container" class="main-content-boxed">

            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="bg-image" style="background-image: url('assetsBorrower/media/photos/photo6@2x.jpg');">
                    <div class="row mx-0 bg-primary-op">
                        <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                            <div class="p-30 invisible" data-toggle="appear">
                                <p class="font-size-h3 font-w600 text-white">
                                    <i class="fa fa-bell"></i> Anda memiliki <a class="link-effect text-white-op font-w700" href="javascript:void(0)">5 notifikasi baru</a>!
                                </p>
                                <p class="font-italic text-white-op">
                                    Unlock untuk melihat notifikasi.</span>
                                </p>
                            </div>
                        </div>
                        <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white text-center">
                            <div class="content content-full" style="padding: 14px 4px 1px;">
                                <!-- Header -->
                                <div class="px-30 pt-10 pb-30">
                                    <a class="link-effect text-primary font-w700" href="#">
                                        <span class="font-size-xl text-pulse-dark">DSI</span><span class="font-size-xl">Penerima Dana</span>
                                    </a>
                                    <h1 class="h3 font-w700 mt-30 mb-10">Welcome back, Dani A.</h1>
                                    <h2 class="h5 font-w400 text-muted mb-30">Please enter your password</h2>
                                    <!-- <img class="img-avatar img-avatar96" src="assetsBorrower/media/avatars/avatar1.jpg" alt=""> -->
                                </div>
                                <!-- END Header -->

                                <!-- Unlock Form -->
                                <!-- jQuery Validation functionality is initialized with .js-validation-lock class in js/pages/op_auth_lock.min.js which was auto compiled from _es6/pages/op_auth_lock.js -->
                                <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <form class="js-validation-lock px-30" action="/borrower" method="post">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="form-material floating">
                                                <input type="password" class="form-control" id="lock-password" name="lock-password">
                                                <label for="lock-password">Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-rounded btn-dsi text-white p-10 pl-30 pr-30">
                                            <i class="si si-lock-open mr-10"></i> Unlock
                                        </button>
                                        <div class="mt-30">
                                            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="/borrower">
                                                <i class="fa fa-user text-muted mr-5"></i> Not you? Sign In
                                            </a>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Unlock Form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <!--
            Codebase JS Core

            Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
            to handle those dependencies through webpack. Please check out assetsBorrower/_es6/main/bootstrap.js for more info.

            If you like, you could also include them separately directly from the assetsBorrower/js/core folder in the following
            order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

            assetsBorrower/js/core/jquery.min.js
            assetsBorrower/js/core/bootstrap.bundle.min.js
            assetsBorrower/js/core/simplebar.min.js
            assetsBorrower/js/core/jquery-scrollLock.min.js
            assetsBorrower/js/core/jquery.appear.min.js
            assetsBorrower/js/core/jquery.countTo.min.js
            assetsBorrower/js/core/js.cookie.min.js
        -->
        <script src="assetsBorrower/js/codebase.core.min.js"></script>

        <!--
            Codebase JS

            Custom functionality including Blocks/Layout API as well as other vital and optional helpers
            webpack is putting everything together at assetsBorrower/_es6/main/app.js
        -->
        <script src="assetsBorrower/js/codebase.app.min.js"></script>

        <!-- Page JS Plugins -->
        <script src="assetsBorrower/js/plugins/jquery-validation/jquery.validate.min.js"></script>

        <!-- Page JS Code -->
        <script src="assetsBorrower/js/pages/op_auth_lock.min.js"></script>
    </body>
</html>