<div id="content" class="content">
			<!-- begin breadcrumb -->
			<!--<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Tables</a></li>
				<li class="active">Managed Tables</li>
			</ol>-->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header greenHeading"><bluefont><?php echo $survey_name; ?></bluefont> - <?php echo $survey_type_name; ?> Survey Appendix</h1>
           

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
                            <h4 class="panel-title"><?php echo $survey_type_name; ?> Survey Report</h4>
                           
                        </div>
                        
                        <div class="panel-body">
                        <div id="page-loader" class="fade in"><span class="spinner"></span></div>
                        <section id="cslide-slides" class="cslide-slides-master clearfix">
                       
                           <div class="cslide-slides-container1 clearfix" style="visibility:visible;width:1200%; max-width: 100%" >
                             
                             
                             <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
                        <div class="panel-heading p-0">
                            <!-- begin nav-tabs -->
                            <?php if($appendix_questions){ ?>
                            <div class="tab-overflow">
                                <ul class="nav nav-tabs nav-tabs-inverse">
                                    <li class="prev-button"><a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a></li>
                                    
                                      <?php for($i=1;$i<=count($appendix_questions);$i++): ?>
                                       <li class="<?php if($i==1){ echo 'active'; } ?>"  ><a href="#nav-tab-<?php echo $i; ?>" data-toggle="tab">Appendix<?php echo $i; ?></a></li>
                                      <?php endfor; ?>
                                    <li class="next-button"><a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a></li>

                                </ul>
                            </div>
                            <?php } ?>  
                        </div>
                        <div class="tab-content">
                        <?php $j=1; ?>
                        <?php if($appendix_questions){ ?>
                          <?php foreach($appendix_questions as $appendix_question): ?>
                           
                            <div class="tab-pane fade <?php if($j==1){ echo 'active'; } ?> in" id="nav-tab-<?php echo $j; ?>">
                             <h4><?php echo $appendix_question->question; ?>  </h4>
                             <div class="row">
                              <div class="col-md-7">
                                <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($appendix_question->survey_id,$appendix_question->survey_type_id,$appendix_question->question_id,$appendix_question->question_type_id,$appendix_question->graph_id,'table'); echo $survey_answers; ?>
                             </div>
                            </div>    
                            </div>
                            <?php $j++; ?>
                        <?php endforeach; ?>
                      <?php } ?>      
                        </div>
                    </div>
                             
                           
                      
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