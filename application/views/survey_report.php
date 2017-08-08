<div id="content" class="content">
  
   <!-- Pop up box starts -->
    <div class="overlay"></div>
    <div id="popup_box">
      <div class="popInner">
        <h2>Choose Question</h2>
        <div class="question_content">
        <?php if($all_survey_questions){ ?>
        <?php $i=1;  ?> 
         <?php foreach($all_survey_questions as $survey_question): ?>
         <p><a href="javscript:void(0)" rel="<?php echo $i;?>"><?php echo $i.". ".$survey_question->question;?></a></p>
         <?php $i++; ?>
         <?php endforeach; ?>
       <?php } ?>  
        </div>
      </div>
      <a id="popupBoxClose"></a>  
    </div>
     <!-- Pop up box ends -->

			<!-- begin breadcrumb -->
			<!--<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Tables</a></li>
				<li class="active">Managed Tables</li>
			</ol>-->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
            <div class="headerDiv">
			<h1 class="page-header greenHeading"><bluefont><?php echo $survey_name; ?></bluefont> - <?php echo $survey_type_name; ?> Survey Report</h1>
            <span class="questionPicker"><a href="javascript:void(0);">Choose Question</a></span>
            </div>
           <div id="myProgress">
             <div id="myBar">
               <div id="progresslabel"><?php echo '1/'.$total_survey_questions; ?></div>
             </div>
           </div>

			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                     <div style="float:right;margin-right:10px;margin-left:10px"><select name="question_number" id="question_number">
                           <?php for($i=1;$i<=$total_survey_questions;$i++): ?>
                             <option value="<?php echo $i; ?>" <?php if($i==1){ echo "selected=selected"; } ?> >Q<?php echo $i; ?></option>
                            <?php endfor; ?>
                            </select></div>
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
                        <div class="cslide-prev-next clearfix">
                           <span class="cslide-prev cslide-disabled">Prev Question</span>
                           <span class="cslide-next" rel="1">Next Question</span>
                        </div>
                     <div class="cslide-slides-container1 clearfix" style="visibility:visible;width:1200%; max-width: 100%" >
                             <div style="margin: 54px 30px 0;">                            
                              <div class="newTabMenuHolder">
                                 <a href="javascript:void" rel="#overall">Overall <?php echo $survey_type_name; ?></a>
                                 <?php if($survey_comparison_type){ ?>
							      <?php foreach($survey_comparison_type as $comparison): ?>
                                    <a href="javascript:void" rel="#<?php echo str_replace(' ', '',$comparison['comparison_type']); ?>"><?php echo ucfirst($comparison['comparison_type']).' '.$survey_type_name; ?></a>
                                  <?php endforeach; ?>
                               
                                    <a href="javascript:void(0);" rel="#comparison" id="comparison_tab">Comparison</a>
                                
                                <?php } ?>    
                       	 	</div>  
                          </div>                    
                          <div class="newTabItemHolder" id="question_container">
                           <?php if($survey_questions){ ?>
                              <?php foreach($survey_questions as $survey_question): ?>
                              <div class="newTabItem" id="overall">
                               <div class="cslide-slide cslide-first cslide-active" id="question_<?php echo $survey_question->question_id; ?>" style="width: 100%;" rel=1>
                                 <h4><?php echo $survey_question->question; ?> </h4>
                                 <div class="respondants">
                                  <p>Total survey respondents: <?php echo number_format(intval($survey_respondants)); ?></p>
                                  <p>No. of respondents to this question: <?php $CI =& get_instance(); $survey_question_repondants =  $CI->getSurveyQuestionRespondants($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id); echo number_format(intval($survey_question_repondants));  ?> (<?php echo round((($survey_question_repondants/$survey_respondants)*100),2); ?>%)</p></div>
                                 <div class="resultContainer">                                 
                                    <div class="row">
                                        <div class="col-md-8">
                                          <?php if($survey_question->enable_table=='Y'){ ?>                    
                                <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'table'); echo $survey_answers; ?>
                                   <?php } ?>
                                        <?php if($survey_question->enable_graph=='Y'){ ?>
                                             <div class="chart_container" id="chart-container_default<?php echo $survey_question->survey_id.$survey_question->survey_type_id.$survey_question->question_id ?>"  <?php if($survey_question->question_type_id==7){ echo "style='float:left;'"; } ?>></div> 
                               <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'graph'); echo $survey_answers; ?>
                               <div class="clearfix"></div>
                                   <?php } ?>  
                                  
                                        </div>
                                        <div class="col-md-4">
                                          <?php if($survey_question->question_type_id!=3 and $survey_question->enable_observation=='Y'){?>  <div class="observationDiv">
                                          <h3>Observation</h3>
                                            <p><?php $CI =& get_instance(); $question_objective =  $CI->getSurveyquestionObjective($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id); echo $question_objective; ?></p>
                                            <?php if($survey_question->enable_comparison){ ?>
                                            <h3>Comparison With Previous Show</h3>
                                            <?php $CI =& get_instance(); $question_comparison =  $CI->getPreviousdataComparison($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->map_id,'default',$survey_question->enable_comparison); echo $question_comparison;  ?>
                                            <?php } ?> 
                                          </div>
										     
										  <?php } ?>    
                                        </div>
                                    </div>
                 
                                </div>
                               </div>
                             </div> <!-- tab close -->  
							  <!-- <div class="clearfix"></div>-->
							    <?php if($survey_comparison_type){ ?>
							    <?php foreach($survey_comparison_type as $comparison): ?>
                               
                                <div class="newTabItem" id="<?php echo str_replace(' ', '',$comparison['comparison_type']); ?>">
							    <div class="cslide-slide cslide-first cslide-active" id="question_<?php echo $survey_question->question_id; ?>" style="width: 100%;" rel=1>
                                 <h4><?php echo $survey_question->question; ?>  </h4>
                                 <div class="respondants">
                                  <p><?php echo ucfirst($comparison['comparison_type'])." ".$survey_type_name; ?>  respondents: <?php $CI =& get_instance(); $survey_comparison_repondants =  $CI->getSurveyRespondants($survey_question->survey_id,$survey_question->survey_type_id,$comparison['comparison_type']); echo number_format(intval($survey_comparison_repondants));  ?></p>
                                  <p>No. of <?php echo ucfirst($comparison['comparison_type'])." ".$survey_type_name; ?> respondents to this question: <?php $CI =& get_instance(); $survey_comparison_question_repondants =  $CI->getSurveyQuestionRespondants($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$comparison['comparison_type']); echo number_format(intval($survey_comparison_question_repondants));  ?> (<?php echo round((($survey_comparison_question_repondants/$survey_comparison_repondants)*100),2); ?>%)</p></div>
                                <div class="resultContainer"> 
                                 <div class="row">
                                        <div class="col-md-8">
                                         <?php if($survey_question->enable_table=='Y'){ ?>    
                                         <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'table',$comparison['comparison_type']); echo $survey_answers; ?>
                               
                               <div class="clearfix"></div>
                               <?php } ?>
                               <?php if($survey_question->enable_graph=='Y'){ ?> 
                                
                                 <div class="chart_container" id="chart-container_<?php echo $comparison['comparison_type'].$survey_question->survey_id.$survey_question->survey_type_id.$survey_question->question_id ?>"  <?php if($survey_question->question_type_id==7){ echo "style='float:left;'"; } ?>></div>
                               
                                <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'graph',$comparison['comparison_type']); echo $survey_answers; ?>                             
                               <?php } ?>
                               </div>
                                <div class="col-md-4">
                              <?php if($survey_question->question_type_id!=3 and $survey_question->enable_observation=='Y'){?>  <div class="observationDiv">
                              
                               <?php if($survey_question->enable_comparison){ ?>
                                            <h3>Comparison With Previous Show</h3>
                                            <?php $CI =& get_instance(); $question_comparison =  $CI->getPreviousdataComparison($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->map_id,$comparison['comparison_type'],$survey_question->enable_comparison); echo $question_comparison;  ?>
                                            <?php } ?> 
                              
                              </div><?php } ?>  
                              
                              </div>
                              </div>                            
                               
                                </div>
                               </div>
                               </div>
							   <?php endforeach; ?>
                               <?php  if($survey_question->question_type_id!=3  and $survey_question->question_type_id!=9 and $survey_question->question_type_id!=10 and  $survey_question->question_type_id!=11 and $survey_question->question_type_id!=14 and $survey_question->question_type_id!=15 and $survey_question->question_type_id!=16 and $survey_question->question_type_id!=17 and $survey_question->question_type_id!=18 and $survey_question->question_type_id!=19 and $survey_question->question_type_id!=20 and $survey_question->question_type_id!=21){ ?>
                                <div class="newTabItem" id="comparison">
                                 <div class="cslide-slide cslide-first cslide-active"  style="width: 100%;" rel=1>
                                    <h4><?php echo $survey_question->question; ?> </h4>
                                  <div class="resultContainer"> 
                                 <div class="row">
                                 <div class="col-md-8">
                                   <?php $CI =& get_instance(); $question_combination_comparison =  $CI->getCombinationdataComparison($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->map_id); echo $question_combination_comparison;  ?>
                                   </div>
								 <div  class="col-md-4">  
                                  <?php if($survey_question->enable_observation=='Y'){?> 
								  <div class="observationDiv">
                                          <h3>Observation</h3>
                                            <p><?php $CI =& get_instance(); $question_objective =  $CI->getSurveyquestionObjective($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id); echo $question_objective; ?></p>
                                            
                                          </div> 
                                  <?php } ?>        
								</div>		  
                                   </div>
                                  </div> 
                                </div>
                                </div>
                              <?php } ?>  
							  <?php } ?> 
                              <?php endforeach; ?>
                           <?php } ?>  
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
	
	$(".newTabMenuHolder a").first().addClass("active");
	$(".newTabItemHolder .newTabItem").first().addClass("active");
	
	$('.newTabMenuHolder a').click(function(){
		if($(this).hasClass("active")) {
		} else {
			$(".newTabMenuHolder a").removeClass("active");
			$(this).addClass("active");
			$(".newTabItem").removeClass("active");        
			var toShowTab = $(this).attr("rel")
			$(toShowTab).addClass("active");
		}
	});
	
	var progress_barwidth = <?php echo round((1/$total_survey_questions)*100); ?>;
	$('#myBar').css('width',progress_barwidth+'%'); 
	
	
	
	$("#question_number").change(function(){
	   
	   var question_number = $("#question_number").val();
	   var slidesContainerId='#cslide-slides';
	    var i = $(".cslide-slide.cslide-active").index();
	    var  j =$('#question_'+question_number).index();
		
		var n =j;

		var slideLeft = "-"+n*100+"%";
		$(".newTabMenuHolder a").removeClass("active");
		$(".newTabMenuHolder a").first().addClass("active");
        if(i<j){
			if (!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-last")) {
						$(slidesContainerId+" .cslide-slide.cslide-active").removeClass("cslide-active").next(".cslide-slide").addClass("cslide-active");
						$(slidesContainerId+" .cslide-slides-container").animate({
							marginLeft : slideLeft
						},450);
						if ($(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-last")) {
							$(slidesContainerId+" .cslide-next").addClass("cslide-disabled");
						}
			}
			if ((!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-first")) && $(".cslide-prev").hasClass("cslide-disabled")) {
					$(slidesContainerId+" .cslide-prev").removeClass("cslide-disabled");
			}
		}		
		else{
		   
		   if (!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-first")) {
                    $(slidesContainerId+" .cslide-slide.cslide-active").removeClass("cslide-active").prev(".cslide-slide").addClass("cslide-active");
                    $(slidesContainerId+" .cslide-slides-container").animate({
                        marginLeft : slideRight
                    },250);
                    if ($(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-first")) {
                        $(slidesContainerId+" .cslide-prev").addClass("cslide-disabled");
                    }
           }
           if ((!$(slidesContainerId+" .cslide-slide.cslide-active").hasClass("cslide-last")) && $(".cslide-next").hasClass("cslide-disabled")) {
                    $(slidesContainerId+" .cslide-next").removeClass("cslide-disabled");
           }	
			
		}
		
                  
	 
	
	});
 
 $('.questionPicker a').click(function(){
   $('#popup_box').show();
   $('.overlay').addClass('show');	 
	  
 });
 $('#popupBoxClose,.overlay').click(function(){
	  $('#popup_box').hide();
      $('.overlay').removeClass('show');	  
 });

 $('#question_number').change(function(){
	$(".newTabMenuHolder a").removeClass("active");
    $(".newTabMenuHolder a").first().addClass("active");
	var ques_num = $(this).val();
	var current_page = $('.cslide-slide').attr('rel');
	if(ques_num > current_page){
		 var page = ques_num-1;
		 
		 change_next_slide(page);
	}
	else{
	  
	     var page = ques_num-1;
		 change_prev_slide(page);
		
	}
	
	
  
 });
 
 $('.question_content a ').click(function(){
	 
	$(".newTabMenuHolder a").removeClass("active");
    $(".newTabMenuHolder a").first().addClass("active");
	var ques_num = $(this).attr('rel');
	var current_page = $('.cslide-slide').attr('rel');
	$('#popup_box').hide();
    $('.overlay').removeClass('show');
	if(ques_num > current_page){
		 var page = ques_num-1;
		 
		 change_next_slide(page);
	}
	else{
	  
	     var page = ques_num-1;
		 change_prev_slide(page);
		
	}
	
	
  
 });
	 
 
 $('.cslide-next').click(function(){
	page = $(this).attr('rel');
	$(".newTabMenuHolder a").removeClass("active");
	$(".newTabMenuHolder a").first().addClass("active");
	change_next_slide(page);
		 
 });
 
 $('.cslide-prev').click(function(){
	page = $(this).attr('rel');
	$(".newTabMenuHolder a").removeClass("active");
	$(".newTabMenuHolder a").first().addClass("active");
	change_prev_slide(page);
		 
 });	
		
});

function change_next_slide(page){
  $('#page-loader').removeClass('hide');
  $.ajax({
					type:'POST',
					data:'page='+page,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/paginate_survey',
					success:function(data) {
						
						if(data.status=='success'){
						  
						  $('#question_container').html(data.data_html);
						  if(data.question_type_id==3 || data.question_type_id==9  || data.question_type_id==10 || data.question_type_id==11 || data.question_type_id==14 || data.question_type_id==15 || data.question_type_id==16 || data.question_type_id==17 || data.question_type_id==18 || data.question_type_id==19 || data.question_type_id==20 || data.question_type_id==21){
						    $('#comparison_tab').hide();
						  }
						  else{
							 $('#comparison_tab').show();  
						  }
						  $('#page-loader').addClass('hide');
						  $('.cslide-prev').removeClass('cslide-disabled');
						  $("#question_number").val(data.current_page);
						  var progress_barwidth = (data.current_page/data.survey_question_count)*100;						 
	                      $('#myBar').css('width',Math.round(progress_barwidth)+'%'); 
						  $('#progresslabel').html(data.current_page+'/'+data.survey_question_count); 
						  if(page < data.survey_question_count-1){
							
							page = parseInt(page) + 1; 
							
							
							$('.cslide-prev').attr('rel',page-2);
							$('.cslide-next').attr('rel',page);
							  
						  }
						  else{
							$('.cslide-next').addClass('cslide-disabled');
							$('.cslide-prev').attr('rel',page-1); 
						  }
						  	
						}
						  
					}
				  });

}

function change_prev_slide(page){
  $('#page-loader').removeClass('hide');
  $.ajax({
					type:'POST',
					data:'page='+page,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/paginate_survey',
					success:function(data) {
						
						if(data.status=='success'){
						  
						  $('#question_container').html(data.data_html);
						   if(data.question_type_id==3 || data.question_type_id==9  || data.question_type_id==10 || data.question_type_id==11 || data.question_type_id==14 || data.question_type_id==15 || data.question_type_id==16 || data.question_type_id==17 || data.question_type_id==18 || data.question_type_id==19 || data.question_type_id==20 || data.question_type_id==21){
						    $('#comparison_tab').hide();
						  }
						  else{
							 $('#comparison_tab').show();  
						  }
						  $('#page-loader').addClass('hide');
						  $('.cslide-next').removeClass('cslide-disabled');
						  $("#question_number").val(data.current_page);
						  var progress_barwidth = (data.current_page/data.survey_question_count)*100;						 
	                      $('#myBar').css('width',Math.round(progress_barwidth)+'%');
						  $('#progresslabel').html(data.current_page+'/'+data.survey_question_count); 
						  if(page != 0){
							
							page = parseInt(page) - 1; 
													
							$('.cslide-prev').attr('rel',page);
							$('.cslide-next').attr('rel',page+2);
							
							  
						  }
						  else{
							
							$('.cslide-prev').addClass('cslide-disabled');
							$('.cslide-next').attr('rel',page+1);
							  
						  }
						  	
						}
						  
					},
				     error: function(jqXHR, textStatus, errorThrown) {
						window.location='<?php echo base_url(); ?>index.php/index/survey_report'; 	  
                     }
				  });

}


</script>       