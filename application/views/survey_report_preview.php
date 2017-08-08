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
<style>
body {
	-webkit-print-color-adjust: exact; 
	font-family: Arial,Helvetica,sans-serif;
}
.vendorListHeading {
  background-color: #5b9bd5;
  color: white;

}
.resultContainer {
    font-size: 13px;
	margin-top:20px;
}
.observationDiv > h3 {
    color: #878787;
    font-size: 18px;
	font-family: Arial,Helvetica,sans-serif;
	font-weight: normal;
    padding: 0;
	margin: 0;
}

.col-md-4 {
    width: 25%;
	float: left;
}
.col-md-8 {
    width: 75%;
	float: left;
}

.col-md-7 {
    width: 58.3333%;
	float: left;
}
.col-md-5 {
    width: 41.6667%;
	float: left;
}
.col-md-6 {
    width: 50%;
	float: left;
}
.col-md-12 {
    width: 100%;
	
}

.multichart {
    float: left;
    width: 42%;
    margin-right: 5%;
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

.observationDiv {
    border-left: 1px solid #f1f1f1;
    min-height: 300px;
    margin: 0px 0 10px 10px;
	padding: 0 0 0 10px;
}
.table {
    margin-bottom: 20px;
    max-width: 100%;
    width: 100%;
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
.resultContainer .table > thead > tr > th {
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

p.highLight{ color: #ffffff; font-size: 32px; letter-spacing: 6px; z-index:100;text-transform: uppercase;}
span{ font-family:Arial, Helvetica, sans-serif; font-size: 14px; letter-spacing: 1px; font-weight: bold; text-transform: uppercase; color: #7b7b7b; margin: 0px;}
td.midBg{ background:url(images/imgBg.jpg) no-repeat; }

@media print {


tr.vendorListHeading {
    background-color: #5b9bd5 !important;
    -webkit-print-color-adjust: exact; 
}
    tr.vendorListHeading  {
    color: white !important;
}
.footer {page-break-after: always;}


table.table tr, table.table td, table.table th {
        page-break-inside: avoid;
    }

td.midBg {
   content:url(images/imgBg.jpg);
   display: inline;
   z-index: 0;
   -webkit-print-color-adjust: exact !important;
  }			
	
}
</style>
<body style="background:#f1f1f1">
  <input type="button" name="btn" id="btn" onclick="print_fn()" value="print" />
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
            <p style="text-transform:uppercase;"><?php echo $survey_name.' '.$survey_type_name; ?> Survey Report</p>
           <!-- <span>10 - 14 NOVEMBER 2015 </span>-->
            </td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="194" align="left" valign="top" style="background-color: #e79432 !important;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100" align="left" valign="top"><img src="<?php echo base_url(); ?>assets/img/spacer.gif" width="100" height="60" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td width="100" align="left" valign="top"><img src="<?php echo base_url(); ?>assets/img/spacer.gif" width="100" height="50" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
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
            <td height="315" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td height="90" align="left" valign="top">
            <p>ANALYTICS BY <br />
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
     <?php $CI =& get_instance(); $show_menu =  $CI->menu_visiblity(2,$survey_id,$survey_type_id);   ?>
     <?php if($show_menu){ ?>
    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
        <tr>
        	<td width="3%">&nbsp;</td>
            <td>
                <img style="float:left;"  src="<?php echo base_url(); ?>uploads/logo/<?php echo $survey_logo; ?>" />
            	<p style="color:#333333;text-transform:uppercase;font-size:15px;font-family:Arial, Helvetica, sans-serif;margin-left:20px;margin-top:20px"><?php echo $survey_name.' '.$survey_type_name; ?> Survey Report</p>
                
            </td>
        </tr>
        <tr  bgcolor="#dddddd">
        	<td width="3%">&nbsp;</td>
            <td>&nbsp;
                
            </td>
        </tr>
        <tr class="vendorListHeading">
        	<td width="1%">&nbsp;</td>
            <td>
            	<p style="color:#ffffff;text-transform:uppercase;font-size:14px;font-family:Arial, Helvetica, sans-serif;"><strong> Demographics</strong></p>
            </td>
        </tr>
        
       
        
        <tr>
        	<td>
            </td>
            <td>
           	
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
            	
                 <div class="resultContainer">
                 
                  <div class="row" style="margin-bottom:10px;">
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
                  
                <?php if($demographics_questions){ ?>
                <?php foreach($demographics_questions as $demographics_question): ?>
                   <h4 style="margin-top:10px;"><?php echo $demographics_question->question; ?></h4>
                    <div class="col-md-6">
                  
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="50%">
                            <?php  $CI =& get_instance(); $demographics_answers =  $CI->getSurveyAnswers($demographics_question->survey_id,$demographics_question->survey_type_id,$demographics_question->question_id,$demographics_question->question_type_id,$demographics_question->graph_id,'table'); echo $demographics_answers; ?>                             
                        </td>
                        <td>
                        </td>
                    </tr>
                </table> 
               
                      </div>
                      
                 <?php endforeach; ?>
         <?php } ?>          
                  </div>
                
            </td>
        </tr>
     
        <tr>
        	<td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    <div class="footer"></div>
    <?php } ?>
      <?php $CI =& get_instance(); $show_menu =  $CI->menu_visiblity(3,$survey_id,$survey_type_id);   ?>
     <?php if($show_menu){ ?>
    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
       
        <tr  bgcolor="#dddddd">
        	<td width="3%">&nbsp;</td>
            <td>&nbsp;
                
            </td>
        </tr>
        <tr class="vendorListHeading">
        	<td width="1%">&nbsp;</td>
            <td>
            	<p style="color:#ffffff;text-transform:uppercase;font-size:14px;font-family:Arial, Helvetica, sans-serif;"><strong><?php echo $survey_type_name; ?> Survey  Daily Analysis Report</strong></p>
            </td>
        </tr>
        <?php if($daywise_analysis_questions){?>
        <?php foreach($daywise_analysis_questions as $daywise_analysis_question): ?>
        <tr>
        	<td width="3%">&nbsp;</td>
            <td>
            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr height="60">
                    	<td width="2%"><img src="<?php echo base_url();?>assets/img/bgheadingArrow.png" /></td>
                    	<td>
                        	<p style="color:#878787;text-transform:uppercase;font-size:18px;font-family:Arial, Helvetica, sans-serif;"><?php echo $daywise_analysis_question->question; ?></p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
        
        <tr>
        	<td>
            </td>
            <td>
           	
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
            	
                <div class="resultContainer">
                    <div class="col-md-8">
                  
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="60%">
                              <?php  $CI =& get_instance(); $daywise_analysis =  $CI->getSurveyDailyAnalysis($daywise_analysis_question->survey_id,$daywise_analysis_question->survey_type_id,$daywise_analysis_question->question_id,$daywise_analysis_question->question_type_id,$daywise_analysis_question->graph_id,'table'); echo $daywise_analysis; ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                </table> 
               
                      </div>
                      <div class="col-md-4">
                      	<div class="observationDiv">
                        	
                        </div>
                      </div>
                  </div>
                  
            </td>
        </tr>
       <?php endforeach; ?>
       <?php } ?> 
        <tr>
        	<td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
     <div class="footer"></div>
    <?php } ?>
      <?php $CI =& get_instance(); $show_menu =  $CI->menu_visiblity(4,$survey_id,$survey_type_id);   ?>
     <?php if($show_menu){ ?> 
    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
        <tr>
        	<td width="3%">&nbsp;</td>
            <td>
            	<p style="color:#333333;text-transform:uppercase;font-size:15px;font-family:Arial, Helvetica, sans-serif;"><?php echo $survey_name.' '.$survey_type_name; ?> Survey Report</p>
            </td>
        </tr>
        <tr  bgcolor="#dddddd">
        	<td width="3%">&nbsp;</td>
            <td>&nbsp;
                
            </td>
        </tr>
        <tr class="vendorListHeading">
        	<td width="1%">&nbsp;</td>
            <td>
            	<p style="color:#ffffff;text-transform:uppercase;font-size:14px;font-family:Arial, Helvetica, sans-serif;"><strong><?php echo $survey_type_name; ?> Survey Report</strong></p>
            </td>
        </tr>
        <?php if($survey_questions){?>
        <?php foreach($survey_questions as $survey_question): ?>
        <tr>
        	<td width="3%">&nbsp;</td>
            <td>
            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr height="60">
                    	<td width="2%"><img src="<?php echo base_url();?>assets/img/bgheadingArrow.png" /></td>
                    	<td>
                        	<p style="color:#878787;text-transform:uppercase;font-size:18px;font-family:Arial, Helvetica, sans-serif;"><?php echo $survey_question->question; ?> - Overall</p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
        <tr height="60">
        	<td bgcolor="#b0c7e1"></td>
        	<td>
            	<table width="100%" cellpadding="0" cellspacing="0" border="0" height="60">
                	<tr>
                    	<td width="5%" bgcolor="#b0c7e1">
                        </td>
                        <td bgcolor="#f1f1f1"><p style="color:#707478; margin:0;text-transform:uppercase;font-size:13px;font-family:Arial, Helvetica, sans-serif;">&nbsp; Total survey respondants: <?php $CI =& get_instance(); $survey_respondants =  $CI->getSurveyRespondants($survey_question->survey_id,$survey_question->survey_type_id); echo $survey_respondants ?></p></td>
                    </tr>
                    <tr>
                    	<td width="5%" bgcolor="#b0c7e1">
                        </td>
                        <td bgcolor="#f1f1f1"><p style="color:#707478; margin:0;text-transform:uppercase;font-size:13px;font-family:Arial, Helvetica, sans-serif;">&nbsp; No. of respondants to this question: <?php $CI =& get_instance(); $survey_question_repondants =  $CI->getSurveyQuestionRespondants($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id); echo number_format(intval($survey_question_repondants));  ?> (<?php echo round((($survey_question_repondants/$survey_respondants)*100),2); ?>%)</p></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
           	
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
            	<?php if($survey_question->survey_type_id==3){ ?>
                  <?php echo "sdasd"; exit; ?>
                 <?php } ?>
                <div class="resultContainer">
                    <div class="col-md-8">
                      <?php if($survey_question->enable_table=='Y'){ ?>    
             <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'table'); echo $survey_answers; ?>
            <?php } ?>          
                   <?php if($survey_question->enable_graph=='Y'){ ?>
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="100%">
                             <div class="chart_container" id="chart-container_default<?php echo $survey_question->survey_id.$survey_question->survey_type_id.$survey_question->question_id ?>"></div> 
                        	<?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'graph'); echo $survey_answers; ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                </table> 
                <?php } ?>   
                      </div>
                      <div class="col-md-4">
                      	<div class="observationDiv">
                        	<h3>Observation</h3>
                              <p><?php $CI =& get_instance(); $question_objective =  $CI->getSurveyquestionObjective($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id); echo $question_objective; ?></p>
                        </div>
                      </div>
                  </div>
                 
            </td>
        </tr>
         <div class="footer" ></div>
         <?php if($survey_comparison_type){ ?>
			<?php foreach($survey_comparison_type as $comparison): ?>
             
             <tr>
        	<td width="3%">&nbsp;</td>
            <td>
            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr height="60">
                    	<td width="2%"><img src="<?php echo base_url();?>assets/img/bgheadingArrow.png" /></td>
                    	<td>
                        	<p style="color:#878787;text-transform:uppercase;font-size:18px;font-family:Arial, Helvetica, sans-serif;"><?php echo $survey_question->question; ?> - <?php echo ucfirst($comparison['comparison_type']); ?></p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
        <tr height="60">
        	<td bgcolor="#b0c7e1"></td>
        	<td>
            	<table width="100%" cellpadding="0" cellspacing="0" border="0" height="60">
                	<tr>
                    	<td width="5%" bgcolor="#b0c7e1">
                        </td>
                        <td bgcolor="#f1f1f1"><p style="color:#707478; margin:0;text-transform:uppercase;font-size:13px;font-family:Arial, Helvetica, sans-serif;">&nbsp; Total survey respondants: <?php $CI =& get_instance(); $survey_respondants =  $CI->getSurveyRespondants($survey_question->survey_id,$survey_question->survey_type_id,$comparison['comparison_type']); echo $survey_respondants ?></p></td>
                    </tr>
                    <tr>
                    	<td width="5%" bgcolor="#b0c7e1">
                        </td>
                        <td bgcolor="#f1f1f1"><p style="color:#707478; margin:0;text-transform:uppercase;font-size:13px;font-family:Arial, Helvetica, sans-serif;">&nbsp; No. of respondants to this question: <?php $CI =& get_instance(); $survey_question_repondants =  $CI->getSurveyQuestionRespondants($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$comparison['comparison_type']); echo number_format(intval($survey_question_repondants));  ?> (<?php echo round((($survey_question_repondants/$survey_respondants)*100),2); ?>%)</p></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
           	
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
            	
                <div class="resultContainer">
                    <div class="col-md-8">
                      <?php if($survey_question->enable_table=='Y'){ ?>    
             <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'table',$comparison['comparison_type']); echo $survey_answers; ?>
            <?php } ?>          
                   <?php if($survey_question->enable_graph=='Y'){ ?>
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="100%">
                             <div class="chart_container" id="chart-container_<?php echo $comparison['comparison_type'].$survey_question->survey_id.$survey_question->survey_type_id.$survey_question->question_id ?>"></div> 
                        	<?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'graph',$comparison['comparison_type']); echo $survey_answers; ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                </table> 
                <?php } ?>   
                      </div>
                      <div class="col-md-4">
                      	
                      </div>
                  </div>
                 
            </td>
        </tr>
         <div class="footer" ></div>
             
            
            <?php endforeach; ?>
       
       <?php  if($survey_question->question_type_id!=3 and $survey_question->question_type_id!=8 and $survey_question->question_type_id!=9 and $survey_question->question_type_id!=10 and  $survey_question->question_type_id!=11 and $survey_question->question_type_id!=14 and $survey_question->question_type_id!=15){ ?> 
         <tr>
        	<td width="3%">&nbsp;</td>
            <td>
            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr height="60">
                    	<td width="2%"><img src="<?php echo base_url();?>assets/img/bgheadingArrow.png" /></td>
                    	<td>
                        	<p style="color:#878787;text-transform:uppercase;font-size:18px;font-family:Arial, Helvetica, sans-serif;"><?php echo $survey_question->question; ?> - Comparison</p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
        
        <tr>
        	<td>
            </td>
            <td>
           	
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
            	
                <div class="resultContainer">
                    <div class="col-md-12"> 
               
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="100%">
                              <?php $CI =& get_instance(); $question_combination_comparison =  $CI->getCombinationdataComparison($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->map_id); echo $question_combination_comparison;  ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                </table> 
                
                      </div>
                      
                  </div>
                 
            </td>
        </tr>
         <div class="footer" ></div>
         <?php } ?>    
         <?php } ?>    
       <?php endforeach; ?>
       <?php } ?> 
        <tr>
        	<td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    <div class="footer"></div>
    <?php } ?>
      <?php $CI =& get_instance(); $show_menu =  $CI->menu_visiblity(5,$survey_id,$survey_type_id);   ?>
     <?php if($show_menu){ ?>
    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
       
        <tr class="vendorListHeading">
        	<td width="1%">&nbsp;</td>
            <td>
            	<p style="color:#ffffff;text-transform:uppercase;font-size:14px;font-family:Arial, Helvetica, sans-serif;"><strong><?php echo $survey_type_name; ?> Survey Correlations</strong></p>
            </td>
        </tr>
        <?php if($co_relations){?>
        <?php foreach($co_relations as $co_relation): ?>
        <tr>
        	<td width="3%">&nbsp;</td>
            <td>
            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr height="60">
                    	<td width="2%"><img src="<?php echo base_url();?>assets/img/bgheadingArrow.png" /></td>
                    	<td>
                        	<p style="color:#878787;text-transform:uppercase;font-size:18px;font-family:Arial, Helvetica, sans-serif;"><?php echo $co_relation['title']; ?></p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
        
        <tr>
        	<td>
            </td>
            <td>
           	
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
            	
                <div class="resultContainer">
                    <div class="col-md-7">
                       <?php  $CI =& get_instance(); $corelation_data =  $CI->getCorelationData($co_relation['id'],$co_relation['answer_data_table'],'table',$co_relation['show_index']); echo $corelation_data; ?>
                                        
                                        <?php  $CI =& get_instance(); $corelation_data =  $CI->getCorelationData($co_relation['id'],$co_relation['answer_data'],'graph',$co_relation['show_index']); echo $corelation_data; ?>      
                      </div>
                      <div class="col-md-5">
                      	<div class="observationDiv">
                        	<h3>Observation</h3>
                            <p><?php echo $co_relation['observations']; ?></p>
                        </div>
                      </div>
                  </div>
                  
            </td>
        </tr>
       <?php endforeach; ?>
       <?php } ?> 
        <tr>
        	<td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    <div class="footer"></div>
    <?php } ?>
      <?php $CI =& get_instance(); $show_menu =  $CI->menu_visiblity(6,$survey_id,$survey_type_id);   ?>
     <?php if($show_menu){ ?>
    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
       
        <tr class="vendorListHeading">
        	<td width="1%">&nbsp;</td>
            <td>
            	<p style="color:#ffffff;text-transform:uppercase;font-size:14px;font-family:Arial, Helvetica, sans-serif;"><strong><?php echo $survey_type_name; ?> Survey Field Observations</strong></p>
            </td>
        </tr>
        <?php if($survey_insights){?>
        <?php foreach($survey_insights as $survey_insight): ?>
        
        
        
        <tr>
        	<td>
            </td>
            <td>
            	
                <div class="resultContainer">
                    <div class="col-md-12">
                        <p style="padding:10px;"> <?php  echo $survey_insight['insights']; ?></p>   
                      </div>
                  </div>
                  
            </td>
        </tr>
       <?php endforeach; ?>
       <?php } ?> 
        <tr>
        	<td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    <div class="footer"></div>
    <?php } ?>
      <?php $CI =& get_instance(); $show_menu =  $CI->menu_visiblity(7,$survey_id,$survey_type_id);   ?>
     <?php if($show_menu){ ?>
    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
       
        <tr class="vendorListHeading">
        	<td width="1%">&nbsp;</td>
            <td>
            	<p style="color:#ffffff;text-transform:uppercase;font-size:14px;font-family:Arial, Helvetica, sans-serif;"><strong><?php echo $survey_type_name; ?> Survey Appendix</strong></p>
            </td>
        </tr>
        <?php if($appendix_questions){?>
        <?php foreach($appendix_questions as $appendix_question): ?>
        <tr>
        	<td width="3%">&nbsp;</td>
            <td>
            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr height="60">
                    	<td width="2%"><img src="<?php echo base_url();?>assets/img/bgheadingArrow.png" /></td>
                    	<td>
                        	<p style="color:#878787;text-transform:uppercase;font-size:18px;font-family:Arial, Helvetica, sans-serif;"><?php echo $appendix_question->question; ?></p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
        
        <tr>
        	<td>
            </td>
            <td>
           	
            </td>
        </tr>
        <tr>
        	<td>
            </td>
            <td>
            	
                <div class="resultContainer">
                    <div class="col-md-8">
                       <?php  $CI =& get_instance(); $appendix_survey_answers =  $CI->getSurveyAnswers($appendix_question->survey_id,$appendix_question->survey_type_id,$appendix_question->question_id,$appendix_question->question_type_id,$appendix_question->graph_id,'table'); echo $appendix_survey_answers; ?>
                      </div>
                      <div class="col-md-4">
                      
                      </div>
                  </div>
                  
            </td>
        </tr>
       <?php endforeach; ?>
       <?php } ?> 
        <tr>
        	<td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    <?php } ?>
  
  <script>
    
	function print_fn(){
	  document.getElementById('btn').style.visibility="hidden";
	  window.print();	
		
	}
   
  
  </script>  
            
</body>
</html>
