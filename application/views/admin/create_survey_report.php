	<!-- begin #content -->
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Survey Report Settings</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="form-plugins-6">
                        <div class="panel-heading">
                            <h4 class="panel-title">Create Survey Report Settings</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form method="POST" name="createsurveyForm" id="createsurveyForm" class="form-horizontal form-bordered">
								<div class="form-group">
									<label class="control-label col-md-3">Survey Details</label>
									<div class="col-md-3">
									    <p>Survey</p>
									     <select name="survey" id="survey" class="form-control" >
                                         <option value="-1"></option>
                                         <?php if($survey_master_data){ ?>
                                          <?php foreach($survey_master_data as $survey_master): ?>
										    <option value="<?php echo $survey_master['survey_id']; ?>" ><?php echo $survey_master['survey_name']; ?></option>
                                          <?php endforeach; ?>
                                         <?php } ?>
                                        </select>  
                                        <p></p>
                                        <p>Survey Type</p>
                                        <select name="survey_type" id="survey_type" class="form-control" >
                                         <option value="-1"></option>
                                         <?php if($survey_type_master_data){ ?>
                                          <?php foreach($survey_type_master_data as $survey_type_master): ?>
										    <option value="<?php echo $survey_type_master['survey_type_id']; ?>" ><?php echo $survey_master['title']; ?></option>
                                          <?php endforeach; ?>
                                         <?php } ?>
                                        </select>  
                                       
									</div>
								</div>
                           
                                <div class="form-group">
									<label class="control-label col-md-3">Question Details</label>
									<div class="col-md-8">
									    <p>Question</p>
									    
                                        
                                    
                                        <p></p>
                                        <p>Graph Type</p>
                                        <select name="graph_type[]" id="graph_type" class="form-control" style="width:150px">
                                         <option value="-1"></option>
                                         <?php if($graph_master){ ?>
                                          <?php foreach($graph_master as $graph): ?>
										    <option value="<?php echo $graph['id']; ?>" ><?php echo $graph['title']; ?></option>
                                          <?php endforeach; ?>
                                         <?php } ?>
                                        </select>
                                         <p></p>
                                         <p>Snapshot View Type</p> 
                                          <select name="snapshot_view_type[]" id="snapshot_view_type" class="form-control" style="width:100px">
                                           <option value="-1"></option>
                                           <option value="table" >Table</option>
                                           <option value="graph">Graph</option>
                                          </select>
                                         <p></p>
                                         <p>Snapshot Display Order</p>   
                                         <input type="text" name="display_order[]" class="form-control" id="display_order" style="width:75px">
                                          <p></p> 
                                         <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_comparison[]"  id="enable_comparison" value="1" >
                                            Enable Previour Year Comparison
                                        </label>
                                         <p></p> 
                                         <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_graph[]"  id="enable_graph" value="1"  >
                                            Enable Graph view in report
                                        </label>
                                        <p></p> 
                                        <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_table[]"  id="enable_table" value="1" >
                                            Enable Table view in report
                                        </label>
                                        <p></p> 
                                        <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="show_appendix[]"  id="show_appendix" value="1" >
                                           Show in Appendix
                                        </label>  
                                         <p></p> 
                                        <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_daily_analysis[]"  id="enable_daily_analysis" value="1" >
                                           Enable Daily Analysis
                                        </label> 
                                        <p></p> 
                                        <p></p>   
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_demographics[]"  id="enable_demographics" value="1" >
                                            Enable Demographics
                                        </label>  
                                       <p></p> 
                                       <p></p>    
                                          <label class="checkbox-inline">
                                           <input type="checkbox" name="enable_observation[]"  id="enable_observation" value="1" >
                                           Enable Observation
                                        </label> 
                                        <p></p>
                                         <p>Report Display Order</p>   
                                         <input type="text" name="report_display_order[]" class="form-control" id="report_display_order" style="width:75px">             
									</div>
								</div>
                              
                              <div class="form-group">
                                   
                                    <div class="col-md-9">
                                         <a class="btn btn-primary m-r-5" href="<?php base_url();?>index.php/admin/index/survey_report">Add Question</a>
                                    </div>
                            </div>    
								
                             <div class="form-group">
                                   
                                    <div class="col-md-9">
                                         <a class="btn btn-sm" href="<?php base_url();?>index.php/admin/index/survey_report">Cancel</a>
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
       