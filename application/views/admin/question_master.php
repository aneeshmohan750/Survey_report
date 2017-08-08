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
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Question Master</h4>
                            <a href="<?php echo base_url(); ?>index.php/admin/index/create_question" style="float:right;margin-top:-17px;color:#fff;">Create</a>
                        </div>
                        <div class="panel-body paddingClass">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Question ID</th>
                                            <th>Question</th>
                                            <th>Question Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php if($question_details){ ?>
                                      <?php foreach($question_details as $question): ?>
                                        <tr class="odd gradeX">
                                            <td>#<?php echo $question['q_id']; ?></td>
                                            <td><a href="<?php echo base_url(); ?>index.php/admin/index/edit_question/<?php echo $question['q_id']; ?>"><?php echo $question['question']; ?></a></td>
                                            <td><?php  $CI =& get_instance(); $question_type =  $CI->get_entity_field('question_type_master',$question['question_type_id'],'title','id'); echo $question_type; ?></td>
                                           
                                        </tr>
                                     <?php endforeach; ?>
                                   <?php } ?>     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->
		
       