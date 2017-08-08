<div id="content" class="content">
			<!-- begin breadcrumb -->
			<!--<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Tables</a></li>
				<li class="active">Managed Tables</li>
			</ol>-->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><?php echo $survey_name; ?></h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                     <div style="float:right;margin-right:10px;margin-left:10px"><select name="question_number" id="question_number">
                          <?php $i=1; ?>
                           <?php foreach($survey_questions as $survey_question): ?>
                             <option value="<?php echo $survey_question->question_id; ?>" <?php if($i==1){ echo "selected=selected"; } ?> >Q<?php echo $i; ?></option>                  
                             <?php $i= $i+1; ?>
                            <?php endforeach; ?>
                            </select></div>
                        <div class="panel-heading">
                            
                            <div class="panel-heading-btn">
                                
                               
                                
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            </div>
                            <h4 class="panel-title"><?php echo $survey_type_name; ?> Survey Report</h4>
                           
                        </div>
                        <div class="panel-body">
                        <section id="cslide-slides" class="cslide-slides-master clearfix">
                          <div >
                           <?php if($survey_questions){ ?>
                              <?php foreach($survey_questions as $survey_question): ?>
                               <div class="cslide-slide cslide-active" id="question_<?php echo $survey_question->question_id; ?>">
                                 <h4><?php echo $survey_question->question; ?> </h4>
                                 <div class="respondants">
                                  <p>Total survey respondants: <?php echo $survey_respondants; ?></p>
                                  <p>No. of respondants to this question: <?php $CI =& get_instance(); $survey_question_repondants =  $CI->getSurveyQuestionRespondants($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id); echo $survey_question_repondants;  ?> (<?php echo round((($survey_question_repondants/$survey_respondants)*100)); ?>%)</p></div>
                                <div class="resultContainer"> <div class="chart_container" id="chart-container_<?php echo $survey_question->survey_id.$survey_question->survey_type_id.$survey_question->question_id ?>"  <?php if($survey_question->question_type_id==7){ echo "style='float:left;'"; } ?>></div> 
                               <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'graph','pdf'); echo $survey_answers; ?>
                               <div class="clearfix"></div>
                              <?php if($survey_question->question_type_id!=3){?>  <div class="observationDiv"><h3>Observation</h3><p><?php $CI =& get_instance(); $question_objective =  $CI->getSurveyquestionObjective($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id); echo $question_objective; ?></p></div><?php } ?>                              
                                <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'table'); echo $survey_answers; ?>
                                </div>
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
 
