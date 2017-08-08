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
                            <h4 class="panel-title">Create Question</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form method="POST" name="createquestionmasterForm" id="createquestionmasterForm" class="form-horizontal form-bordered">
								<div class="form-group">
									<label class="control-label col-md-3">Question</label>
									<div class="col-md-6">
									    <input name="question" id="question" class="form-control" />   
									</div>
                                </div>
                                <div class="form-group">    
                                    <label class="control-label col-md-3">Question Type</label>
									<div class="col-md-3">
									   <select name="question_type" id="question_type" class="form-control" >
                                         <option value="-1"></option>
                                         <?php if($question_type_master){ ?>
                                          <?php foreach($question_type_master as $question_type): ?>
										    <option value="<?php echo $question_type['id']; ?>" ><?php echo $question_type['title']; ?></option>
                                          <?php endforeach; ?>
                                         <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
									<label class="control-label col-md-3">Options</label>
									<div class="col-md-6">
                                        <textarea name="question_option" id="question_option" class="form-control" ></textarea> 
									</div>
                                </div>
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
	
	  $('#createquestionmasterForm').submit(function(e){
		   e.preventDefault();
		   $('#page-loader').removeClass('hide');	 
		   dataString = $('form[name=createquestionmasterForm]').serialize();
		   $.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/admin/custom_ajax/createquestion',
					success:function(data) {
						  if (data.status=='success'){
							 window.location.href = "<?php echo base_url();?>index.php/admin/index/questions"; 			    				  
						  }
						 
					}
				  });	 	 		   
		     
	  });
	});

</script>				
       