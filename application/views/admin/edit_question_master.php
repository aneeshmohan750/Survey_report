	<!-- begin #content -->
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Question Master</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="form-plugins-6">
                        <div class="panel-heading">
                            <h4 class="panel-title">Edit Question</h4>
                        </div>
                        <div class="panel-body panel-form">
                          <?php if($question_details){ ?>                                
                           <?php foreach($question_details as $question): ?>
                            <form method="POST" name="editquestionmasterForm" id="editquestionmasterForm" class="form-horizontal form-bordered">
                             <input type="hidden" name="question_id" id="question_id" value="<?php echo $question['q_id']; ?>" />
								<div class="form-group">
									<label class="control-label col-md-3">Question</label>
									<div class="col-md-6">
									    <input name="question" id="question" class="form-control" value="<?php echo $question['question']; ?>" />   
                                       
									</div>
                                </div>
                                <div class="form-group">    
                                    <label class="control-label col-md-3">Question Type</label>
									<div class="col-md-3">
									   <select name="question_type" id="question_type" class="form-control" >
                                         <option value="-1"></option>
                                         <?php if($question_type_master){ ?>
                                          <?php foreach($question_type_master as $question_type): ?>
										    <option value="<?php echo $question_type['id']; ?>" <?php if($question_type['id']==$question['question_type_id']) echo 'selected="selected"'; ?> ><?php echo $question_type['title']; ?></option>
                                          <?php endforeach; ?>
                                         <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
									<label class="control-label col-md-3">Options</label>
									<div class="col-md-6">
                                        <textarea name="question_option" id="question_option" class="form-control" ><?php echo $question['q_option']; ?></textarea> 
									</div>
                                </div>
                                
                                                      
								<?php endforeach; ?>
								
							 <?php } ?>	
                             <div class="form-group">
                                   
                                    <div class="col-md-9">
                                         <a class="btn btn-white btn-sm" href="<?php echo base_url();?>index.php/admin/index/questions">Cancel</a>
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
	  $('#editquestionmasterForm').submit(function(e){
		   e.preventDefault();
		   $('#page-loader').removeClass('hide');	 
		   dataString = $('form[name=editquestionmasterForm]').serialize();
		   $.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/admin/custom_ajax/savequestionForm',
					success:function(data) {
						  if (data.status=='success'){
							 window.location.href = "<?php echo base_url();?>index.php/admin/index/questions"; 			    				  
						  }
						 
					}
				  });	 	 		   
		     
	  });
	});

</script>				
       