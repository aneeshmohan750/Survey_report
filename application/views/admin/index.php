	<!-- begin #content -->
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Survey Master</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Survey Master</h4>
                        </div>
                        <div class="panel-body paddingClass">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Survey Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Logo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php if($survey_details){ ?>
                                      <?php foreach($survey_details as $survey): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $survey['survey_name']; ?></td>
                                            <td><?php echo $survey['start_date']; ?></td>
                                            <td><?php echo $survey['end_date']; ?></td>
                                            <td><?php if($survey['survey_logo']){ ?><img src="<?php echo base_url();?>uploads/logo/<?php echo $survey['survey_logo']; ?>"><?php } ?></td>
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
		
       