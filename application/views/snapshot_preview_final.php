<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $survey_name.' '.$survey_type_name; ?> Survey Report</title>
 <link href="<?php echo $this->config->item('assets_url')?>plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" />
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
</head>
<style type="text/css">
body {
	-webkit-print-color-adjust: exact; 
	font-family: Arial,Helvetica,sans-serif;
}
.container{
	background-color: #ffffff;
	width: 1000px;
	margin: 10px auto;
}
h1, h2, h3{
	text-transform: uppercase;
	font-weight: normal;
	padding: 18px 30px;
	margin: 0px;
}
h1{
	color: #878787;
	font-size: 18px;
}
h2{
	color: #ffffff;
	font-size: 14px;
	padding: 14px 30px;
}
h3{
	color: #333333;
	font-size: 15px;
}
p,div{
	color: #707478;
	font-size: 13px;
}
.blue{
	background-color: #5b9bd5;
}
.grey{
	background-color: #f1f1f1;
}

.grey p{
	border-left: 75px solid #b0c7e1;
	line-height: 25px;
	padding: 6px 10px;
	text-transform: uppercase;
	margin: 0px;
}
.leftPanel{
	float:left;
	width: 68%;
}
.rightPanel{
	float:left;
	width: 30%;
	border-left: 1px solid #f1f1f1;
	padding-bottom: 900px;
	margin-bottom: -900px;
}

.graph{
	margin: 0 15px 15px;
}


.table {
    margin-bottom: 20px;
    max-width: 100%;
    width: 98%;
	font-family: Arial,Helvetica,sans-serif;
    font-size: 13px;
}
.table-striped > tbody > tr:nth-of-type(2n+1) {
    background-color: #f9f9f9;
}
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background: #f0f3f5 none repeat scroll 0 0;
}
.table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
    border-top: 0 none;
}
.table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
    border: 1px solid #ddd;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    border-top: 1px solid #ddd;
    line-height: 1.42857;
    padding: 8px;
    vertical-align: top;
}
.table > thead > tr > th {
    background: #e2e7eb none repeat scroll 0 0;
    border-bottom: 2px solid #e2e7eb !important;
    color: #242a30;
    font-weight: 600;
}.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    border-color: #e2e7eb;
    padding: 10px 15px;
}
.table > thead > tr > th {
    border-bottom: 2px solid #e2e7eb !important;
    color: #242a30;
    font-weight: 600;
}
.table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
    border-bottom-width: 2px;
}

div.table{
	margin: 15px;
	width:auto;
}
.table > .thead > tr > th {
    background: #e2e7eb !important;
    color: #242a30 !important;
	
}
.rightPanel h3 {
    color: #878787;
    font-size: 18px;
    font-family: Arial,Helvetica,sans-serif;
    font-weight: normal;
	text-transform: none;
	padding: 15px;
}

.rightPanel p{
	margin: 0 0 0 15px;
}

.col-md-4 {
    width: 25%;
	float: left;
}

.multichart {
    float: left;
    width: 50%;
    /*margin-right: 1%; */
}

.widget {
    border-radius: 3px;
    margin-bottom: 20px;
    color: #fff;
    padding: 15px;
    overflow: hidden;
}
.bg-green {
    background: #00acac!important;
}

.bg-blue {
    background: #348fe2!important;
}
.bg-purple {
    background: #727cb6!important;
}
.bg-orange {
    background: #f59c1a!important;
}
.widget-stats .stats-title {
    position: relative;
    line-height: 1.1;
    font-size: 12px;
    margin: 2px 0 7px;
}

.widget-stats .stats-number {
    font-size: 24px;
    font-weight: 300;
    margin-bottom: 10px;
}

.col-md-6 {
    width: 50%;
	float: left;
	overflow:hidden;
}
.clearFix { clear: both; font-size: 0em; line-height: 0px; height: 0; margin: 0; padding: 0;}

p.textTitle {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 18px;
    text-transform: uppercase;
    color: #828282;
    margin: 0 0 8px 0;
}
p.highLight {
    color: #ffffff;
    font-size: 32px;
    letter-spacing: 6px;
    z-index: 100;
	text-transform:uppercase;
}

.fourBoxes{
    margin-bottom: 10px;
    margin-left: 12px;
}

.fourBoxes .col-md-4 {
    width: 24%;
    float: left;
    margin: 8px 9px 0 0;
    color: #fff !important;
}

.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    transform: translate(0, 0);
}
.fa-arrow-down.red{    width: 15px;
    height: 15px; 
	background:url("../../assets/img/reddown.png") no-repeat;
}
.fa-arrow-up.red{    width: 15px;
    height: 15px; 
	background:url("../../assets/img/redup.png") no-repeat;
}
.fa-arrow-down.green{    width: 15px;
    height: 15px; 
	background:url("../../assets/img/greendown.png") no-repeat;
}
.fa-arrow-up.green{    width: 15px;
    height: 15px; 
	background:url("../../assets/img/greenup.png") no-repeat;
}
span.date {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    letter-spacing: 1px;
    font-weight: bold;
    text-transform: uppercase;
    color: #7b7b7b;
    margin: 0px;	
}
.snap-title{text-align:center;color:#000;}
.centerChart{text-align:center}
@media print {


tr.vendorListHeading {
    background-color: #5b9bd5 !important;
    -webkit-print-color-adjust: exact; 
}
    tr.vendorListHeading  {
    color: white !important;
}
.footer {page-break-after: always;}


/*table.table,table.table tr, table.table td, table.table th {
        page-break-inside: avoid;
    } */

/*thead {display: table-header-group !important;}
    tr {page-break-inside: avoid !important;}*/
thead {display: inline-table !important;}
td.midBg {
   content:url(images/imgBg.jpg);
   display: inline;
   z-index: 0;
   -webkit-print-color-adjust: exact !important;
  }			
	
}

</style>

<body style="background:#f1f1f1">
  <input type="button" name="btn" id="btn" onclick="print_fn()" value="print" style="display:none;" />
  <p id="warning">Print option Available on Chrome</p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top"><table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100" align="left" valign="top"><img src="<?php echo base_url(); ?>assets/img/spacer.gif" width="100" height="160" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td height="240" align="left" valign="top"><img width="250" src="<?php echo base_url(); ?>uploads/logo/<?php echo $survey_report_logo; ?>"  /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td height="165" align="left" valign="top">
            <p class="textTitle"><?php echo $survey_name.' '.$survey_type_name; ?> Survey Snapshot</p>
              <span class="date"><?php echo date("d M-Y",strtotime($survey_start_date)); ?> to  <?php echo date("d M-Y",strtotime($survey_end_date)); ?></span>
            </td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="194" align="left" valign="middle" style="background-color:#696969 !important;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" width="100" valign="top">&nbsp;</td>
            <td align="left" valign="top">

            <p class="highLight"><?php echo $survey_name.' '.$survey_type_name; ?> Survey</p>
            </td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
        
        </td>
      </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100" align="left" valign="top">&nbsp;</td>
            <td height="215" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td height="90" align="left" valign="top">
            <p class="textTitle">ANALYTICS BY <br />
			DATA ANALYSIS GROUP <br />
			TECHMART SOLUTIONS MIDDLE EAST DMCC </p>
            </td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><img src="<?php echo base_url(); ?>assets/img/logoTechmart.jpg" width="157" height="52" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="<?php echo base_url(); ?>assets/img/spacer.gif" width="100" height="100" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
 <div class="footer"></div>
 
 <div class="container">
    	<div>
       	  <h3><?php echo $survey_name.' '.$survey_type_name; ?> Survey Snapshot</h3>
        </div>
  <div class="blue">
        	<h2><strong>Snapshot</strong></h2>
        </div>
        
        <div class="row fourBoxes">
              <?php if($snapshot_widgets){ ?>
                
                <?php foreach($snapshot_widgets as $widget): ?>
                 
                  <div class="col-md-4">
			        <div class="widget widget-stats bg-<?php echo $widget['color']; ?>">
			            <div class="stats-icon stats-icon-lg"><i class="fa <?php echo $widget['icon']; ?> fa-fw"></i></div>
			            <div class="stats-title"><?php echo $widget['title']; ?></div>
			            <div class="stats-number"><?php echo $widget['value']; ?></div>
                        <div class="stats-desc"></div>
			        </div>
			    </div>
                
                <?php endforeach; ?>
                
              <?php } ?>
        </div>
        <div class="clearFix"></div>
       
        <div class="clearFix"></div>
        <div style="overflow: hidden">
         <?php if($snapshot_questions){ ?>              
                   <?php foreach($snapshot_questions as $snapshot): ?>
                  
                   <div class="snap_tile">
                    <div class="snap-heading">
                     <h1 class="snap-title"><strong><?php echo $snapshot->question ?></strong></h1> 
                    </div>                
                     <div class="chart_container centerChart" id="chart-container_default<?php echo $snapshot->survey_id.$snapshot->survey_type_id.$snapshot->question_id ?>">
                     </div> 
                     <div>
                    <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($snapshot->survey_id,$snapshot->survey_type_id,$snapshot->question_id,$snapshot->question_type_id,$snapshot->graph_id,$snapshot->snapshot_view_type); echo $survey_answers; ?>  
                    </div> 
                    </div> 
                     <?php if($snapshot->question_type_id==8){ ?><div class="clearfix"></div><?php } ?>    
                      <div class="footer"></div>          
                  <?php endforeach; ?>               
                 <?php } ?>
            
        </div>
 </div>
 


	 
  <div class="footer"></div>	
	 
	

  <script>
   
   $(document).ready(function(){
	
	var nAgt =navigator.userAgent;
	var browserName=''; 
	var verOffset;
	  if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
           browserName = "Chrome";
       } 
	 if(browserName=='Chrome'){
		
		$('#warning').hide();
		$('#btn').show();
		 
	 }
	 
	 $('.leftPanel').each(function(){
	    
		var $table = $(this).find('table');
		if($table!='undefined'){
			var currentWidth= $table.width();
			if(currentWidth > 700){
			   $(this).css("width",currentWidth+"px");
			   $(this).next('.rightPanel').css("width","100%");
			}
		}
	 
	 });
	 
   });
     
	function print_fn(){
	  document.getElementById('btn').style.visibility="hidden";
	  window.print();	
		
	}
   
  
  </script>  
            
</body>
</html>
