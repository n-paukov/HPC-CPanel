<?php defined('SC_PANEL') or die; ?><!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>VSU HPC Panel</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo innoTemplateUrl(); ?>/assets/img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/font-awesome.min.css">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/owl.theme.css">
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/owl.transitions.css">
    <!-- meanmenu CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/meanmenu/meanmenu.min.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/normalize.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- jvectormap CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/jvectormap/jquery-jvectormap-2.0.3.css">
    <!-- notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/notika-custom-icon.css">
    <!-- wave CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/wave/waves.min.css">
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/jquery.dataTables.min.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/main.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo innoTemplateUrl(); ?>/assets/css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="<?php echo innoTemplateUrl(); ?>/assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Start Header Top Area -->
<div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area">
                    <a href="<?php echo innoUrl(['index', 'index']); ?>">VSU HPC Panel</a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="header-top-menu">
                    <ul class="nav navbar-nav notika-top-nav">
                        <li class="nav-item">
                            <a href="<?php echo innoUrl(['support', 'index']); ?>" role="button" aria-expanded="false" class="nav-link"><span><i class="notika-icon notika-mail"></i></span></a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo innoUrl(['support', 'index']); ?>" role="button" aria-expanded="false" class="nav-link"><span><i class="notika-icon notika-alarm"></i></span></a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo innoUrl(['account', 'logout']); ?>" role="button" aria-expanded="false" class="nav-link">
                                <span><i class="fa fa-sign-out"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Header Top Area -->
<!-- Mobile Menu start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">
                            <li<?php if ($page['controllerName'] == 'index') echo ' class="active"'; ?>><a href="<?php echo innoUrl(['index', 'index']); ?>"><i class="notika-icon notika-house"></i> Главная</a>
                            </li>
                            <li<?php if ($page['controllerName'] == 'queue') echo ' class="active"'; ?>><a href="<?php echo innoUrl(['queue', 'index']); ?>"><i class="notika-icon notika-form"></i> Задачи</a>
                            </li>
                            <li<?php if ($page['controllerName'] == 'account' && $page['actionName'] == 'settings') echo ' class="active"'; ?>><a href="<?php echo innoUrl(['account', 'settings']); ?>"><i class="notika-icon notika-support"></i> Настройки</a>
                            </li>
                            <li<?php if ($page['controllerName'] == 'support') echo ' class="active"'; ?>><a href="<?php echo innoUrl(['support', 'index']); ?>"><i class="notika-icon notika-mail"></i> Поддержка</a>
                            </li>
                            <li><a href="<?php echo innoUrl(['account', 'logout']); ?>"><i class="fa fa-sign-out"></i> Выход</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu end -->
<!-- Main Menu area start-->
<div class="main-menu-area mg-tb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    <li<?php if ($page['controllerName'] == 'index') echo ' class="active"'; ?>><a href="<?php echo innoUrl(['index', 'index']); ?>"><i class="notika-icon notika-house"></i> Главная</a>
                    </li>
                    <li<?php if ($page['controllerName'] == 'queue') echo ' class="active"'; ?>><a href="<?php echo innoUrl(['queue', 'index']); ?>"><i class="notika-icon notika-form"></i> Задачи</a>
                    </li>
                    <li<?php if ($page['controllerName'] == 'account' && $page['actionName'] == 'settings') echo ' class="active"'; ?>><a href="<?php echo innoUrl(['account', 'settings']); ?>"><i class="notika-icon notika-support"></i> Настройки</a>
                    </li>
                    <li<?php if ($page['controllerName'] == 'support') echo ' class="active"'; ?>><a href="<?php echo innoUrl(['support', 'index']); ?>"><i class="notika-icon notika-mail"></i> Поддержка</a>
                    </li>
                    <li><a href="<?php echo innoUrl(['account', 'logout']); ?>"><i class="fa fa-sign-out"></i> Выход</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="alert-area">
<?php if (!empty($page['alerts'])) : ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert-inner">
    <?php foreach ($page['alerts'] as $alert) : ?>
        <div class="alert alert-<?php echo $alert['type']; ?>" role="alert"><?php echo $alert['text']; ?></div>
    <?php endforeach; ?>
                    </div>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br></div>
</div>

<?php echo $content; ?>

<!-- Start Footer area-->
<div class="footer-copyright-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="footer-copy-right">
                    <p>Copyright © 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Footer area-->
<!-- jquery
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/vendor/jquery-1.12.4.min.js"></script>
<!-- bootstrap JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/bootstrap.min.js"></script>
<!-- wow JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/wow.min.js"></script>
<!-- price-slider JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/jquery-price-slider.js"></script>
<!-- owl.carousel JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/owl.carousel.min.js"></script>
<!-- scrollUp JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/jquery.scrollUp.min.js"></script>
<!-- meanmenu JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/meanmenu/jquery.meanmenu.js"></script>
<!-- counterup JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/counterup/jquery.counterup.min.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/counterup/waypoints.min.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/counterup/counterup-active.js"></script>
<!-- mCustomScrollbar JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- jvectormap JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/jvectormap/jvectormap-active.js"></script>
<!-- sparkline JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/sparkline/sparkline-active.js"></script>
<!-- sparkline JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/flot/jquery.flot.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/flot/jquery.flot.resize.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/flot/curvedLines.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/flot/flot-active.js"></script>
<!-- knob JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/knob/jquery.knob.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/knob/jquery.appear.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/knob/knob-active.js"></script>
<!--  wave JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/wave/waves.min.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/wave/wave-active.js"></script>
<!--  todo JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/todo/jquery.todo.js"></script>
<!-- plugins JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/plugins.js"></script>

<script src="<?php echo innoTemplateUrl(); ?>/assets/js/data-table/jquery.dataTables.min.js"></script>
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/data-table/data-table-act.js"></script>
<!-- Input Mask JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/jasny-bootstrap.min.js"></script>


<!-- main JS
    ============================================ -->
<script src="<?php echo innoTemplateUrl(); ?>/assets/js/main.js"></script>
</body>

</html>