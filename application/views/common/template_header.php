<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v1.7/admin/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:50:18 GMT -->
<head>
	<meta charset="utf-8" />
	<title><?php echo $page_title; ?></title>
    <link rel="icon" href="<?php echo $this->config->item('assets_url')?>favicon.png" type="image/png" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>css/animate.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>css/style.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>css/style-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?php echo $this->config->item('assets_url')?>plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
    <link href="<?php echo $this->config->item('assets_url')?>plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?php echo $this->config->item('assets_url')?>plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/jquery.cslide.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/pace/pace.min.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.charts.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.powercharts.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.widgets.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.gantt.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.zoomscatter.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.treemap.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.theme.fint.js"></script>
	<!-- ================== END BASE JS ================== -->
    
    <script src="<?php echo $this->config->item('assets_url')?>plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="assets/crossbrowserjs/html5shiv.js"></script>
		<script src="assets/crossbrowserjs/respond.min.js"></script>
		<script src="assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo $this->config->item('assets_url')?>plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo $this->config->item('assets_url')?>plugins/gritter/js/jquery.gritter.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/flot/jquery.flot.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/flot/jquery.flot.time.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/flot/jquery.flot.resize.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/sparkline/jquery.sparkline.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>js/dashboard.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			/*Dashboard.init();*/
		});
	</script>
</head>
<body>
	