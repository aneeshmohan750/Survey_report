 <div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="content" class="content">
			<!-- begin page-header -->
			<h1 class="page-header greenHeading"><bluefont><?php echo $survey_name; ?></bluefont> - <?php echo $survey_type_name; ?> Survey Field Observations</h1>
			<!-- end page-header -->
			<!-- begin row -->
			
			    
		<!-- begin row -->
	    <div class="row">
			  <div class="col-md-12">
                <div class="panel panel-inverse"> 
               <div class="panel-body">
                 <div class="snap-heading">
                     <h4 class="snap-title"></h4> 
                    </div>  
                <?php if($survey_insights){ ?>       
                <?php foreach($survey_insights as $survey_insight): ?>
                 
                <p style="padding:10px;"> <?php  echo $survey_insight['insights']; ?></p>
                
                <?php endforeach; ?>
               <?php } ?>
              </div>
             </div> 
             </div>
           </div> 
			<!-- end row -->		