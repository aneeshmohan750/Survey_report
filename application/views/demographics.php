 <div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="content" class="content">
			<!-- begin page-header -->
			<h1 class="page-header greenHeading"><bluefont><?php echo $survey_name; ?></bluefont> - <?php echo $survey_type_name; ?> Survey Demographics</bluefont></h1>
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
                <div class="panel panel-inverse"> 
               <div class="panel-body">
               
                 <div class="snap-heading">
                    <?php if($top_countries){ ?> <h4 class="snap-title">Top <?php echo $survey_type_name; ?> Countries</h4> <?php } ?>
                    </div>     
             <?php if($top_countries){ ?>  <div id="visitors-map" class="height-sm width-full"></div><?php } ?>
               <div class="row"> 
                <?php echo $top_countries; ?> 
                <?php if($demographics_questions){ ?>
                   <?php $j=1; ?>
                   <?php foreach($demographics_questions as $demographics_question):?>
                   
                     <div class="col-md-6" > 
                      <div class="snap-heading" >
                     <h4 class="snap-title"><?php echo $demographics_question->question ?></h4> 
                    </div>    
					  <div style="margin-left:10px">
                      <?php  if($demographics_question->question_type_id==13)
					           $output_type = 'top_table';
						     else
							    $output_type = 'table';  
					  
					   ?>
                            
                      <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($demographics_question->survey_id,$demographics_question->survey_type_id,$demographics_question->question_id,$demographics_question->question_type_id,$demographics_question->graph_id,$output_type); echo $survey_answers; ?>        
					  </div>           
                       </div>
                      <?php if($j==2){ ?> 
                      <div class="clearfix visible-lg visible-md"> </div>
                      <?php $j=0; ?>
					  <?php }  ?>
					   <?php if($j!=2){ ?> 
                        <?php $j++; ?>
                       <?php } ?>
                   <?php endforeach; ?>
                <?php } ?>   
                 </div>
              </div>
             </div> 
             </div>
           </div> 
			<!-- end row -->		
		</div>