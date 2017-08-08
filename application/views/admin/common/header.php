<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v1.7/admin/html/table_manage.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:58:22 GMT -->
<head>
	<meta charset="utf-8" />
	<title>Survey Admin</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="<?php echo $this->config->item('assets_url')?>plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>css/animate.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>css/style.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>css/style-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo $this->config->item('assets_url')?>css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?php echo $this->config->item('assets_url')?>plugins/DataTables/css/data-table.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo $this->config->item('assets_url')?>plugins/pace/pace.min.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>plugins/jquery/jquery-1.9.1.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="index.html" class="navbar-brand">Survey Admin</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<span class="hidden-xs"><?php echo $display_name; ?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/index/user_logout">Log Out</a></li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="has-sub <?php if($current_controller=='index') echo 'active';?>">
						<a href="<?php echo base_url(); ?>index.php/admin">
						    <i class="fa fa-laptop"></i>
						    <span>Survey Master</span>
					    </a>
					</li>
                    <li class="has-sub <?php if($current_controller=='questions' or  $current_controller=='edit_question') echo 'active';?>">
						<a href="<?php echo base_url(); ?>index.php/admin/index/questions">
						    <i class="fa fa-book"></i>
						    <span>Question Master</span>
					    </a>
					</li>
					<li class="has-sub <?php if($current_controller=='setup_report' or  $current_controller=='edit_survey_report') echo 'active';?>">
						<a href="<?php echo base_url(); ?>index.php/admin/index/survey_report">
						    <i class="fa fa-bar-chart"></i>
						    <span>Survey Report Settings</span>
					    </a>
					</li>
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->