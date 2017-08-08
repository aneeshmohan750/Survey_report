<?php
//check box grid

 $dat_array  =array("Sharaf DG"=>"1","Jumbo"=>"2","Jackys"=>"3","EMAX"=>"4","Other"=>"5");
	 
	 $output = array();
	  foreach($content as $row=>$page_content){
		 $js_arr =array();
		 $arr = array();
		 $val_arr = array();
		 $old_retailer='';
		 foreach($page_content as $index=>$value){
			 if($index=='A')
			   $user = $value;
			 else if($index!='A' and $value){
				   if($header[1][$index]!= $old_retailer)
				   {
				       $val_arr = array();
					   
				   }
					$reatiler = $header[1][$index];
					$val_arr[] = $value; 
					$old_retailer=$reatiler;
					$arr = array("id"=>$dat_array[$reatiler],"text"=>$reatiler,"values"=>$val_arr);
					//$new_arr[$reatiler]=$arr;
					//$js_arr[]=(object)$arr;
					$js_arr[$reatiler]=(object)$arr;
			 }
		 }
		  $new_arr = array_values($js_arr);
		  if($new_arr)
	      $output[$user] = json_encode($new_arr);
		  
	     
	  }
	  
//

//rating

 $dat_array  =array("Generate sales"=>"1","Launch new products"=>"2","Evaluate competitors"=>"3","Meet agents and distributors"=>"4","Promote Brand"=>"5");
	 
	 $output = array();
	  foreach($content as $row=>$page_content){
		 $js_arr =array();
		 $arr = array();
		 foreach($page_content as $index=>$value){
			 if($index=='A')
			   $user = $value;
			 else if($index!='A' and $value){
				   
					$text = $header[1][$index];
				
					$arr = array("id"=>$dat_array[$text],"text"=>$text,"rank"=>$value);
					//$new_arr[$reatiler]=$arr;
					$js_arr[]=(object)$arr;
					//$js_arr[$reatiler]=(object)$arr;
			 }
		 }
		 
	      $output[$user] = json_encode($js_arr);
		  
	     
	  }
	  




?>