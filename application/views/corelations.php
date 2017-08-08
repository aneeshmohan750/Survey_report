<div id="content" class="content">
			
			<h1 class="page-header greenHeading"><bluefont><?php echo $survey_name; ?></bluefont> - <?php echo $survey_type_name; ?> Survey Correlation</h1>
           

			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                    
                        <div class="panel-heading">
                            
                            <div class="panel-heading-btn">
                                
                               
                                
                                
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            </div>
                            <h4 class="panel-title"><?php echo $survey_type_name; ?> Survey  Correlation</h4>
                           
                        </div>
                        
                        <div class="panel-body">
                        <div id="page-loader" class="fade in"><span class="spinner"></span></div>
                        <section id="cslide-slides" class="cslide-slides-master clearfix">
                       
                           <div class="cslide-slides-container1 clearfix" style="visibility:visible;width:1200%; max-width: 100%" >
                              <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
                             <div class="panel-heading p-0">
                            <!-- begin nav-tabs -->
                            <?php if($co_relations){ ?>
                            <div class="tab-overflow">
                                <ul class="nav nav-tabs nav-tabs-inverse">
                                    <li class="prev-button"><a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a></li>
                                     <?php $i=1; ?>
                                      <?php foreach($co_relations as $co_relation): ?>
                                       <li class="<?php if($i==1){ echo 'active'; } ?>"  ><a href="#nav-tab-<?php echo $i; ?>" data-toggle="tab"><?php echo $co_relation['title'];  ?></a></li>
                                     <?php $i++; ?>
                                      <?php endforeach; ?>
                                    <li class="next-button"><a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a></li>

                                </ul>
                            </div>
                            <?php } ?>  
                        </div> 
                             
                             
                            <!-- begin nav-tabs -->
                           <div class="tab-content">
                          <?php $j=1; ?> 
                           <?php if($co_relations){ ?>
                              <?php foreach($co_relations as $co_relation): ?>
                               <div class="tab-pane fade <?php if($j==1){ echo 'active'; } ?> in" id="nav-tab-<?php echo $j; ?>">
                             <div class="row"> 
                                <div class="col-md-8">
                                  <div class="cslide-slide cslide-first cslide-active"  style="width: 100%;" rel=1>
                                     <h4><?php echo $co_relation['title'];  ?> </h4>
                                        
                                         <?php  $CI =& get_instance(); $corelation_data =  $CI->getCorelationData($co_relation['id'],$co_relation['answer_data_table'],'table',$co_relation['show_index'],$co_relation['rating_index_factor'],$co_relation['type']); echo $corelation_data; ?>
                                        
                                        <?php  $CI =& get_instance(); $corelation_data =  $CI->getCorelationData($co_relation['id'],$co_relation['answer_data'],'graph',$co_relation['show_index'],$co_relation['rating_index_factor']); echo $corelation_data; ?>                                    
                                     
                                     </div>
                              </div>
                              <div class="col-md-4">
                                
                                <div class="observationDiv">
                                   <h3>Observation</h3>
                                   <p><?php echo $co_relation['observations']; ?></p>
                                </div>
                                
                              </div>
                             </div> 
                            </div>    
                            <?php $j++; ?>
                              <?php endforeach; ?>
                           <?php } ?>   
                       
                           </div>
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
	
	


});
</script>       