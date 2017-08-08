<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v1.7/admin/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:50:18 GMT -->
<head>
	<meta charset="utf-8" />
	<title><?php echo $survey_name.' '.$survey_type_name; ?> Survey Report</title>
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
    <link href="<?php echo $this->config->item('assets_url')?>plugins/toastr/toastr.min.css" rel="stylesheet"  />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url')?>css/sweet-alert.css">
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
    <script src="<?php echo $this->config->item('assets_url')?>plugins/toastr/toastr.min.js"></script>
     <script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/sweet-alert.min.js"></script>
     <script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js"></script>
	<!-- ================== END BASE JS ================== -->
   <script>
  $(document).ready(function(){ 
   $('#survey_type_id').change(function(){
    
	var survey_type_id = $(this).val();
	if(survey_type_id!=-1){
	swal({   title: "Are you sure?",   text: "Do you want to switch the type!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes",   closeOnConfirm: true }, function(){ change_type_session(survey_type_id);   });
	}
 
 
 });
 
 });
 
 function change_type_session(survey_type_id){
  
    if(survey_type_id==-1)
	  return false;
    $('.loadings').show();
	$('#survey_type_id').attr('disabled',true);	
    $.ajax({   
                     	type:'POST',
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/change_survey_type',
						data:'survey_type_id='+survey_type_id,
						success: function(data){
							if(data.status=="success"){
								
							  $('.loadings').hide();	
							  window.location.href='<?php echo base_url(); ?>'; 
							}
							else {
							  $('.loadings').hide();
                            }
						   }					

					  });
 


}
 
   
   </script> 
    
</head>
<body>
	<!-- begin #page-loader -->
	
	<!-- end #page-loader -->
    
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
                   <div class="companylogoDiv">
					<a href="<?php echo base_url(); ?>" class="navbar-brand"><span > <img width="130" src="<?php echo $this->config->item('assets_url')?>img/pageLogo.png" /></span></a>
                   </div> 
                    <div class="surveylogoDiv">
					<a href="<?php echo base_url(); ?>" class="navbar-brand"><span > <img  src="<?php echo base_url(); ?>uploads/logo/<?php echo $survey_logo; ?>" /></span></a>
                   </div> 
                   <div style="float:left;margin-top:10px;width:200px;">
                    <select name="survey_type_id" id="survey_type_id" class="form-control">
                     <?php foreach($survey_types as $survey_type): ?>
                       <option value="<?php echo $survey_type['survey_type_id']; ?>" <?php if($survey_type['survey_type_id']==$survey_type_id) { echo 'selected="selected"'; } ?>   ><?php $CI =& get_instance(); $survey_type_name =  $CI->get_entity_field('survey_type_master',$survey_type['survey_type_id'],'title','survey_type_id'); echo $survey_type_name;   ?></option>
                     <?php endforeach; ?>
                    </select> 
                   </div>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<!--<img src="assets/img/user-13.jpg" alt="" /> -->
							<span class="hidden-xs"><?php echo $display_name; ?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="<?php echo base_url(); ?>index.php/index/logout">Log Out</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/index/change_password">Change Password</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				
				<!-- begin sidebar nav -->
                <?php if($survey_menuitems){ ?>
				<ul class="nav">
                   <?php foreach($survey_menuitems as $menu): ?>
                      
                      <li class="has-sub <?php if($current_controller==$menu->menu_controller) echo 'active';?>">
						<a href="<?php echo base_url();?>index.php/index/<?php echo $menu->menu_controller; ?>" <?php if($menu->id==9){ echo "target='_blank'";} ?> >
						    <i class="fa <?php echo $menu->menu_icon; ?>"></i>
						    <span><?php echo $menu->menu_name; ?></span>
					    </a>
					</li>
                  
                      
                   <?php endforeach; ?>
                   <?php if($survey_id==3 and $survey_type_id==1){ ?>
                   <li>
						<a target="_blank" href="<?php echo base_url();?>uploads/GITEX Shopper 2016 - Autumn Edition Exhibitors Survey Report.pdf">
						    <span>View Report</span>
					    </a>
					</li>
				  <?php } ?>
                  <?php if($survey_id==3 and $survey_type_id==2){ ?>
                   <li>
						<a target="_blank" href="<?php echo base_url();?>uploads/GITEX Shopper 2016 - Autumn Edition Visitors Survey Report.pdf">
						    <span>View Report</span>
					    </a>
					</li>
				  <?php } ?>	
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
                <?php } ?>	
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		
 