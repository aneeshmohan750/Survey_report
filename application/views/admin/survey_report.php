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
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Survey Reports</h4>
                        </div>
                        <div class="panel-body paddingClass">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Survey</th>
                                            <th>Survey Type</th>
                                            <th>Report Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php if($survey_user_map_details){ ?>
                                      <?php foreach($survey_user_map_details as $user_map): ?>
                                        <tr class="odd gradeX">
                                            <td> <?php  $CI =& get_instance(); $survey =  $CI->get_entity_field('survey_master',$user_map->survey_id,'survey_name','survey_id'); echo $survey; ?>  </td>
                                            <td> <?php  $CI =& get_instance(); $survey_type =  $CI->get_entity_field('survey_type_master',$user_map->survey_type_id,'title','survey_type_id'); echo $survey_type; ?>  </td>
                                           <td> <?php if($user_map->report_status=='ongoing'){echo '<p style="color:blue">Ongoing</p>';} if($user_map->report_status=='completed'){echo '<p style="color:green">Completed</p>';}  ?>  </td>
                                          <td><a href="<?php echo base_url();?>index.php/admin/index/edit_survey_report/<?php echo $user_map->survey_id;?>/<?php echo $user_map->survey_type_id; ?>" class="btn btn-primary btn-xs m-r-5">Edit</a></td>
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
		
       