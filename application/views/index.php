 <div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="content" class="content">
			<!-- begin page-header -->
			<h1 class="page-header greenHeading"><bluefont><?php echo $survey_name; ?></bluefont> - <?php echo $survey_type_name; ?> SURVEY SNAPSHOT  <?php if($enable_export and $enable_export=='Y'){ ?> <a class="btn btn-success export_link" target="_blank" href="<?php echo base_url(); ?>index.php/index/generate_snapshot_preview">Export Pdf</a><?php } ?></h1>
          
			<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
              <?php if($snapshot_widgets){ ?>
                
                <?php foreach($snapshot_widgets as $widget): ?>
                 
                  <div class="col-md-3 col-sm-6">
			        <div class="widget widget-stats bg-<?php echo $widget['color']; ?>">
			            <div class="stats-icon stats-icon-lg"><i class="fa <?php echo $widget['icon']; ?> fa-fw"></i></div>
			            <div class="stats-title"><?php echo $widget['title']; ?></div>
			            <div class="stats-number"><?php echo $widget['value']; ?></div>
                        <div class="stats-desc"></div>
			        </div>
			    </div>
                
                <?php endforeach; ?>
                
              <?php } ?>
			    
		<!-- begin row -->
	    <div class="row">
			  <div class="col-md-12"> 
                 <!-- begin panel -->
                <div class="panel panel-inverse"> 
                   <div class="panel-heading">
                            <h4 class="panel-title"><?php echo $survey_type_name; ?> Survey Snapshot</h4>                           
                   </div>
				   <div class="panel-body extraPadding">
                   <?php if($top_countries){?>
                   <div >
                      <div class="snap-heading">
                     <h4 class="snap-title">Top <?php echo $survey_type_name; ?> Countries</h4> 
                    </div>
                   
                    <div style="width:50%;margin-left:25%">
                    <?php echo $top_countries;  ?>
                    </div>
                   </div> 
                   <div class="clearfix"></div>
                   <?php } ?>
			     <?php if($snapshot_questions){ ?>              
                   <?php foreach($snapshot_questions as $snapshot): ?>
                  
                   <div class="snap_tile">
                    <div class="snap-heading">
                     <h4 class="snap-title"><?php echo $snapshot->question ?></h4> 
                    </div>                
                     <div class="chart_container centerChart" id="chart-container_default<?php echo $snapshot->survey_id.$snapshot->survey_type_id.$snapshot->question_id ?>">
                     </div> 
                     <div>
                    <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($snapshot->survey_id,$snapshot->survey_type_id,$snapshot->question_id,$snapshot->question_type_id,$snapshot->graph_id,$snapshot->snapshot_view_type); echo $survey_answers; ?>  
                    </div> 
                    </div> 
                     <?php if($snapshot->question_type_id==8){ ?><div class="clearfix"></div><?php } ?>            
                  <?php endforeach; ?>               
                 <?php } ?>
                  <div class="clearfix"></div>
                 	<div class="moveTop">
                    	<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                    </div>
                   
				 </div>
			   </div>
                
            </div>
           </div> 
          
			<!-- end row -->		
		</div>
<script>  
  $(document).ready(function(){
	 
	 $('.scroll_table').css("width","auto");
	 $(".moveTop").click(function() {
       $("html, body").animate({ scrollTop: 0 }, "slow");
       return false;
     });
	 
	 
	  
  });
  $(window).scroll(function() {
   if($(window).scrollTop() > $(window).height() ) {
       $('.moveTop').show();
   }
   else{
	    $('.moveTop').hide();  
   }
});
</script>   