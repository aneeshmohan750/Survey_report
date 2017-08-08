	<!-- begin #content -->
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Survey Reports</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="form-plugins-6">
                        <div class="panel-heading">
                            <h4 class="panel-title">Edit Survey Report</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form method="POST" name="editsurveyForm" id="editsurveyForm" class="form-horizontal form-bordered">
                             <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>" />
                             <input type="hidden" name="survey_type_id" id="survey_type_id" value="<?php echo $survey_type_id; ?>" />
								<div class="form-group">
									<label class="control-label col-md-3">Survey Details</label>
									<div class="col-md-3">
									    <p>Survey</p>
									    <input name="survey_name" id="survey_name" class="form-control" value="<?php echo $survey_name; ?>" disabled="disabled"/>   
                                        <p></p>
                                        <p>Survey Type</p>
                                        <input name="survey_type_name" id="survey_type_name" class="form-control" value="<?php echo $survey_type_name; ?>" disabled="disabled"/>
                                        <p></p>
                                        <p>Report Status</p>
                                        <select name="report_status" id="report_status" class="form-control" style="width:150px">
                                           <option value="-1"></option>
                                           <option value="ongoing" <?php if($survey_report_status=='ongoing') echo 'selected="selected"'; ?>>Ongoing</option>
                                           <option value="completed" <?php if($survey_report_status=='completed') echo 'selected="selected"'; ?>>Completed</option>
                                        </select> 
									</div>
								</div>
                              <?php if($survey_map_details){ ?>
                                
                                <?php foreach($survey_map_details as $survey_map): ?>
                                  <div class="form-group">
									<label class="control-label col-md-3">Question Details</label>
									<div class="col-md-8">
									    <p>Question</p>
									    
                                        <h5><strong><?php  $CI =& get_instance(); $question =  $CI->get_entity_field('questions_master',$survey_map['q_id'],'question','q_id'); echo $question; ?>  - #<?php echo $survey_map['q_id']; ?></strong></h5>
                                        <input type="hidden" name="questions[]" id="questions" value="<?php echo $survey_map['q_id']; ?> " /> 
                                        <p></p>
                                        <p>Graph Type</p>
                                        <select name="graph_type[<?php echo $survey_map['q_id']; ?>]" id="graph_type" class="form-control" style="width:150px">
                                         <option value="-1"></option>
                                         <?php if($graph_master){ ?>
                                          <?php foreach($graph_master as $graph): ?>
										    <option value="<?php echo $graph['id']; ?>" <?php if($graph['id']==$survey_map['graph_id']) echo 'selected="selected"'; ?> ><?php echo $graph['title']; ?></option>
                                          <?php endforeach; ?>
                                         <?php } ?>
                                        </select>
                                         <p></p>
                                         <p>Snapshot View Type</p> 
                                          <select name="snapshot_view_type[<?php echo $survey_map['q_id']; ?>]" id="snapshot_view_type" class="form-control" style="width:100px">
                                           <option value="-1"></option>
                                           <option value="table" <?php if($survey_map['snapshot_view_type']=='table') echo 'selected="selected"'; ?>>Table</option>
                                           <option value="graph" <?php if($survey_map['snapshot_view_type']=='graph') echo 'selected="selected"'; ?>>Graph</option>
                                          </select>
                                         <p></p>
                                         <p>Snapshot Display Order</p>   
                                         <input type="text" name="display_order[<?php echo $survey_map['q_id']; ?>]" class="form-control" id="display_order" value="<?php echo $survey_map['display_order']; ?>" style="width:75px">
                                          <p></p> 
                                         <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_comparison[<?php echo $survey_map['q_id']; ?>]"  id="enable_comparison" value="1" <?php if($survey_map['enable_comparison']==1) echo 'checked="checked"'; ?> >
                                            Enable Previour Year Comparison
                                        </label>
                                         <p></p> 
                                         <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_graph[<?php echo $survey_map['q_id']; ?>]"  id="enable_graph" value="1" <?php if($survey_map['enable_graph']=='Y') echo 'checked="checked"'; ?> >
                                            Enable Graph view in report
                                        </label>
                                        <p></p> 
                                        <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_table[<?php echo $survey_map['q_id']; ?>]"  id="enable_table" value="1" <?php if($survey_map['enable_table']=='Y') echo 'checked="checked"'; ?> >
                                            Enable Table view in report
                                        </label>
                                        <p></p> 
                                        <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="show_appendix[<?php echo $survey_map['q_id']; ?>]"  id="show_appendix" value="1" <?php if($survey_map['show_appendix']=='Y') echo 'checked="checked"'; ?> >
                                           Show in Appendix
                                        </label>  
                                         <p></p> 
                                        <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_daily_analysis[<?php echo $survey_map['q_id']; ?>]"  id="enable_daily_analysis" value="1" <?php if($survey_map['enable_daily_analysis']=='Y') echo 'checked="checked"'; ?> >
                                           Enable Daily Analysis
                                        </label> 
                                        <p></p> 
                                        <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_demographics[<?php echo $survey_map['q_id']; ?>]"  id="enable_demographics" value="1" <?php if($survey_map['enable_demographics']=='Y') echo 'checked="checked"'; ?> >
                                            Enable Demographics
                                        </label>  
                                       <p></p> 
                                       <p></p>    
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_observation[<?php echo $survey_map['q_id']; ?>]"  id="enable_observation" value="1" <?php if($survey_map['enable_observation']=='Y') echo 'checked="checked"'; ?> >
                                           Enable Observation
                                        </label> 
                                        <p></p> 
                                       <p></p>    
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_snapshot_status[<?php echo $survey_map['q_id']; ?>]"  id="enable_snapshot_status" value="1" <?php if($survey_map['snapshot_listing_status']=='Y') echo 'checked="checked"'; ?> >
                                           Enable in Snapshot
                                        </label> 
                                         <p></p> 
                                       <p></p>    
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_report_status[<?php echo $survey_map['q_id']; ?>]"  id="enable_report_status" value="1" <?php if($survey_map['report_listing_status']=='Y') echo 'checked="checked"'; ?> >
                                           Enable in Reports
                                        </label> 
                                        <p></p>
                                         <p>Report Display Order</p>   
                                         <input type="text" name="report_display_order[<?php echo $survey_map['q_id']; ?>]" class="form-control" id="report_display_order" value="<?php echo $survey_map['report_display_order']; ?>" style="width:75px"> 
                                         
                                         <p></p>
                                         <p>Observation</p>   
                                         <textarea name="report_question_observation[<?php echo $survey_map['q_id']; ?>]" class="form-control" id="report_question_observation"><?php $CI =& get_instance(); $question_objective =  $CI->getSurveyquestionObjective($survey_id,$survey_type_id,$survey_map['q_id']); echo $question_objective; ?></textarea>
                                                     
									</div>
								</div>
                                 
								<?php endforeach; ?>
								
							 <?php } ?>	
                             <div class="form-group">
                                   
                                    <div class="col-md-9">
                                         <a class="btn btn-white btn-sm" href="<?php base_url();?>index.php/admin/index/survey_report">Cancel</a>
                                        <button type="submit" id="submit_form" name="submit_form" class="btn btn-sm btn-success">Save</button>
                                    </div>
                            </div>
					    </form>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->
<script>
	$(document).ready(function(){
	  $('#editsurveyForm').submit(function(e){
		   e.preventDefault();
		   $('#page-loader').removeClass('hide');	 
		   dataString = $('form[name=editsurveyForm]').serialize();
		   $.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/admin/custom_ajax/savesurveyForm',
					success:function(data) {
						  if (data.status=='success'){
							 window.location.href = "<?php echo base_url();?>index.php/admin/index/survey_report"; 			    				  
						  }
						 
					}
				  });	 	 		   
		     
	  });
	});

</script>				
       