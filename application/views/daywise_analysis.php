<div id="content" class="content">
			<!-- begin breadcrumb -->
			<!--<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Tables</a></li>
				<li class="active">Managed Tables</li>
			</ol>-->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header greenHeading"><bluefont><?php echo $survey_name; ?></bluefont> - <?php echo $survey_type_name; ?> Survey Daywise Analysis</h1>
           

			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                    
                        <div class="panel-heading">
                            
                            <div class="panel-heading-btn">
                                
                               
                                
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            </div>
                            <h4 class="panel-title"><?php echo $survey_type_name; ?> Survey  Daily Analysis Report</h4>
                           
                        </div>
                        
                        <div class="panel-body">
                        <div id="page-loader" class="fade in"><span class="spinner"></span></div>
                        <section id="cslide-slides" class="cslide-slides-master clearfix">
                       
                           <div class="cslide-slides-container1 clearfix" style="visibility:visible;width:1200%; max-width: 100%" >
                             
                             
                             
                            <!-- begin nav-tabs -->
                           <?php if($daywise_analysis_questions){ ?>
                              <?php foreach($daywise_analysis_questions as $analysis_question): ?>
                              <div class="cslide-slide cslide-first cslide-active" id="question_<?php echo $analysis_question->question_id; ?>" style="width: 100%;" rel=1>
                                 <h4><?php echo $analysis_question->question;  ?> </h4>
                                <?php  $CI =& get_instance(); $daywise_analysis =  $CI->getSurveyDailyAnalysis($analysis_question->survey_id,$analysis_question->survey_type_id,$analysis_question->question_id,$analysis_question->question_type_id,$analysis_question->graph_id,'table'); echo $daywise_analysis; ?>
                                 
                                 </div>
                              <?php endforeach; ?>
                           <?php } ?>   
                       
                           
                      
                            </div>
                          </section>  
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
		</div>
 
 <script>
 var page ;
$(document).ready(function(){
    //$("#cslide-slides").cslide();
	
	


});
</script>       