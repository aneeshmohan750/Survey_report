<div id="content" class="content">
			<!-- begin page-header -->
			<h1 class="page-header"><?php echo $survey_name; ?> <small><?php echo $survey_type_name; ?> Report</small></h1>
			<!-- end page-header -->
            	<div class="row">
			    <!-- begin col-3 -->
			    <div class="col-md-3 col-sm-6">
			        <div class="widget widget-stats bg-green">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
			            <div class="stats-title">Total <?php echo $survey_type_name; ?></div>
			            <div class="stats-number">15</div>
                        <div class="stats-desc">Better than last year(100%)</div>
			        </div>
			    </div>
			    <!-- end col-3 -->
			    <!-- begin col-3 -->
			    <div class="col-md-3 col-sm-6">
			        <div class="widget widget-stats bg-blue">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-fw"></i></div>
			            <div class="stats-title">Total <?php echo $survey_type_name; ?> Surveyed</div>
			            <div class="stats-number"><?php echo $survey_respondants; ?></div>
                        <div class="stats-desc">Better than last year(100%)</div>
			        </div>
			    </div>
			    <!-- end col-3 -->
			   
               
			</div>
			<!-- end row -->
			
			<!-- begin row -->
            <?php if(!empty($top_countries)){ ?>
			<div class="row">
			    <div class="col-md-12">
			        <div class="panel panel-inverse" data-sortable-id="index-1">
			            <div class="panel-heading">
			                <h4 class="panel-title">
			                    Top 10 Exhibitors Countries
			                </h4>
			            </div>
			            <div id="visitors-map" class="bg-black" style="height: 281px;"></div>
                        <?php echo $top_countries; ?>
			        </div>
			    </div>
			</div>
			<!-- end row -->
		<?php } ?>	
			<!-- begin row -->
			<div class="row">
			  <div class="col-md-12"> 
                 <!-- begin panel -->
                <div class="panel panel-inverse"> 
                   <div class="panel-heading">
                            <h4 class="panel-title"><?php echo $survey_type_name; ?> Survey Snapshot</h4>                           
                   </div>
			     <?php if($snapshot_questions){ ?>              
                   <?php foreach($snapshot_questions as $snapshot): ?>
                    <div class="snap-heading">
                     <h4 class="snap-title"><?php echo $snapshot->question ?></h4> 
                    </div>                
                     <div class="chart_container" id="chart-container_default<?php echo $snapshot->survey_id.$snapshot->survey_type_id.$snapshot->question_id ?>">
                     </div> 
                    <?php  $CI =& get_instance(); $survey_answers =  $CI->getSurveyAnswers($snapshot->survey_id,$snapshot->survey_type_id,$snapshot->question_id,$snapshot->question_type_id,$snapshot->graph_id,'graph'); echo $survey_answers; ?>               
                  <?php endforeach; ?>               
                 <?php } ?>
			   </div>
            </div>
           </div> 
			<!-- end row -->		
		</div>
  <style>
  .map-float-table {
    position:none !important;
    right: 30px;
    bottom: 30px;
    background: rgba(0,0,0,.6);
  </style>      