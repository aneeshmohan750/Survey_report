<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_ajax extends CI_Controller {

 public function __construct()
 {
   parent::__construct();
  
 }

 public function verifylogin()
 {
        $this->mcontents = array();
        if (!empty($_POST)) {
            $this->load->library('form_validation');
            $this->_init_login_validation_rules(); //server side validation of input values
            if ($this->form_validation->run() == FALSE) {// form validation
                $arr = array('status' =>'failed','message'=>'Invalid Username or Password');
            } else {
                $this->_init_login_details();
                $login_details['username'] = $this->username;
                $login_details['password'] = $this->password;
                if ($this->authentication->process_login($login_details) == 'success') {
				    $session_data=$this->session->userdata('logged_in');
					$log_data =array('ip_address' =>$_SERVER['REMOTE_ADDR'],
	                    'attempt' =>'success',
						'username' => $this->username,
						'log_date' =>  date("Y-m-d H:i:s"));
	                $this->common_model->save('user_logs',$log_data);
                    $arr = array('status' =>'success');
                } else {
					$log_data =array('ip_address' =>$_SERVER['REMOTE_ADDR'],
	                    'attempt' =>'failure',
						'username' => $this->username,
						'log_date' =>  date("Y-m-d H:i:s"));
	                $this->common_model->save('user_logs',$log_data);
                    sf('error_message', 'Invalid Username or Password');
                    $arr = array('status' =>'failed','message'=>'Invalid Username or Password');
                }
            }
		 echo json_encode($arr); 
	     exit;	
        }
   
 }
 
 public function change_password()
  {
	 
	if (!empty($_POST)) {
		
		    $password=$this->input->post('current_password');
			$confirm_password = $this->input->post('confirm_password');
			$user_id = $this->input->post('user_id');
			$query = $this->db->query("SELECT * FROM users WHERE user_id=".$user_id." AND  password=LEFT(MD5(CONCAT(MD5('$password'), 'cloud')), 50)");
			if ($query->num_rows() > 0) {
			 
			 $this->db->query("UPDATE users SET password=LEFT(MD5(CONCAT(MD5('$confirm_password'), 'cloud')), 50) WHERE user_id=".$user_id."");
			 $arr = array("status"=>"success");
			}
			else{
			   $arr = array("status"=>"failed"); 
			}		
	}
	  
	echo json_encode($arr);
	exit;    	  
	  
  }
 
  public function paginate_survey(){
    
	$session_data=$this->session->userdata('logged_in');
	$page = $this->input->post('page');
	$style ='';
	$current_page = $page+1;
	$observation_div ='';
	$comparison_div='';
	$conclusion_div='';
	$survey_answers_graph='';
	$survey_comparison_answers_graph='';
	$survey_answers_table='';
	$survey_comparison_answers_table='';
	$total_survey_questions = $this->common_model->getSurveyQuestionsCount($session_data['survey_id'],$session_data['survey_type_id']);
	$survey_respondants = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);
    $survey_questions = $this->common_model->getSurveyQuestions($session_data['survey_id'],$session_data['survey_type_id'],$page);
	$survey_type_name = $this->common_model->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');
	$survey_comparison_type = $this->common_model->get_data('survey_comparison','comparison_type',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id'])); 
	foreach($survey_questions as $survey_question){
	   
	  $question_type_id = $survey_question->question_type_id; 
	  $survey_question_respondants = $this->common_model->getQuestionRespondants($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id);
	  if($survey_question->enable_graph=='Y'){
	   $survey_answers_graph =  $this->common_model->getSurveyQuestionAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'graph');
	  }
	 if($survey_question->enable_table=='Y'){
	   $survey_answers_table =  $this->common_model->getSurveyQuestionAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'table');
	 }
	  if($survey_question->question_type_id==7){
	     $style = "style='float:left;'";  
	  }
	  if( $survey_question->enable_observation=='Y'){
		$objective = $this->common_model->getSurveyQuestionobjective($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id);
		$observation_div = '<div class="observationDiv"><h3>Observation</h3><p>'.$objective.' </p>';
		
		//$conclusion = $this->common_model->getSurveyQuestionconclusion($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id);
		//$conclusion_div = '<div class="observationDiv"><h3>Conclusion</h3><p>'.$conclusion.' </p></div>';
		  
	  }
	  else
	    $observation_div='<div>';
	  if($survey_question->enable_comparison==1){
	    
		$comparison_data = $this->common_model->getPrevdataComparison($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->map_id,'default',$survey_question->enable_comparison);
		
		$comparison_div ='<h3>Comparison With Previous Show</h3>'.$comparison_data.'</div>'; 
		   
	  }
	  else
	    
		$comparison_div ='</div>';
	    

	  $data_html ='<div class="newTabItem active" id="overall"><div class="cslide-slide cslide-first cslide-active" id="question_'.$survey_question->question_id.'" style="width: 100%;" rel="'.$current_page.'">
                                 <h4>'.$survey_question->question.'</h4>
                                 <div class="respondants">
                                  <p>Total survey respondents: '.number_format(intval($survey_respondants)).'</p>
                                  <p>No. of respondents to this question: '.number_format(intval($survey_question_respondants)).' ('.round((($survey_question_respondants/$survey_respondants)*100),2).'%)</p></div>
                                <div class="resultContainer"> 
								<div class="row">
								  <div class="col-md-8">
								 
								  '.$survey_answers_table.' 
                            
                               <div class="clearfix"></div>
							    '.$survey_answers_graph.'
							    <div class="chart_container" id="chart-container_default'.$survey_question->survey_id.$survey_question->survey_type_id.$survey_question->question_id.'" '.$style.'></div> 
							     
							   </div>
							   <div class="col-md-4">
                                '.$observation_div.' 
							   	'.$comparison_div.'
							   </div>
							   </div>	                         
                               
                                </div>
                               </div>
							   </div>';
	  
	  if($survey_comparison_type){
	   foreach($survey_comparison_type as $comparison_type){
	       
		     $survey_comparison_repondants =  $this->common_model->getSurveyRespondants($survey_question->survey_id,$survey_question->survey_type_id,$comparison_type['comparison_type']); 
	
		   $survey_comparison_question_repondants = $this->common_model->getQuestionRespondants($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$comparison_type['comparison_type']); 
		   if($survey_question->enable_graph=='Y'){
		   $survey_comparison_answers_graph =  $this->common_model->getSurveyQuestionAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'graph',$comparison_type['comparison_type']);
		   }
		   if($survey_question->enable_table=='Y'){
		   $survey_comparison_answers_table =  $this->common_model->getSurveyQuestionAnswers($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->graph_id,'table',$comparison_type['comparison_type']);
		   }
		  if($survey_question->question_type_id==7)
			 $style = "style='margin-top:55px;'"; 
		  if($survey_question->question_type_id!=3 and $survey_question->enable_observation=='Y'){
			$objective = $this->common_model->getSurveyQuestionobjective($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id);
			$observation_div = '<div class="observationDiv">';
			  
		  }
		  
		  if($survey_question->enable_comparison==1){
	    
		$comparison_data = $this->common_model->getPrevdataComparison($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->map_id,$comparison_type['comparison_type'],$survey_question->enable_comparison);
		
		$comparison_div ='<h3>Comparison With Previous Show</h3>'.$comparison_data.'</div>'; 
		   
	  }
	  else
	    
		$comparison_div ='</div>';
	       
		  $data_html .='<div class="newTabItem" id="'.str_replace(' ', '',$comparison_type['comparison_type']).'">
		   <div class="cslide-slide cslide-first cslide-active" id="question_'.$survey_question->question_id.'" style="width: 100%;" rel="'.$current_page.'">
									 <h4>'.$survey_question->question.'</h4>
									 <div class="respondants">
									  <p>'.ucfirst($comparison_type['comparison_type']).' '.$survey_type_name.' respondents: '.number_format(intval($survey_comparison_repondants)).'</p>
									  <p>No. of  '.ucfirst($comparison_type['comparison_type']).' '.$survey_type_name.' respondents to this question: '.number_format(intval($survey_comparison_question_repondants)).' ('.round((($survey_comparison_question_repondants/$survey_comparison_repondants)*100),2).'%)</p></div>
									<div class="resultContainer"> 
									 <div class="row">
								      <div class="col-md-8">
									  
								      '.$survey_comparison_answers_table.'
								         <div class="clearfix"></div>
										 '.$survey_comparison_answers_graph.'
										   <div class="chart_container" id="chart-container_'.$comparison_type['comparison_type'].$survey_question->survey_id.$survey_question->survey_type_id.$survey_question->question_id.'" '.$style.'></div> 										
										 
										</div> 
								     <div class="col-md-4">		
									   '.$observation_div.'
									   '.$comparison_div.'
									 </div>
									 </div>                            
									
									</div>
								   </div>
								   </div>';
	     				   
								   
	    }
	    if($survey_question->question_type_id!=3  and $survey_question->question_type_id!=9 and $survey_question->question_type_id!=10 and  $survey_question->question_type_id!=11 and $survey_question->question_type_id!=14 and $survey_question->question_type_id!=15 and $survey_question->question_type_id!=16 and $survey_question->question_type_id!=17 and $survey_question->question_type_id!=18 and $survey_question->question_type_id!=19 and $survey_question->question_type_id!=20 and $survey_question->question_type_id!=21){  
	       $compare_content = $this->common_model->getCombinationdataComparison($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id,$survey_question->question_type_id,$survey_question->map_id);
		   $data_html .='<div class="newTabItem" id="comparison">
                                 <div class="cslide-slide cslide-first cslide-active"  style="width: 100%;" rel=1>
								  <h4>'.$survey_question->question.'</h4>
                                  <div class="resultContainer"> 
                                 <div class="row">
                                 <div class="col-md-8">'.$compare_content.'
								  </div>
								  <div class="col-md-4">';
			if($survey_question->enable_observation=='Y'){					  
			  $data_html .='<div class="observationDiv">
								   <h3>Observation</h3>
								  <p>'.$this->common_model->getSurveyQuestionobjective($survey_question->survey_id,$survey_question->survey_type_id,$survey_question->question_id).'</p>
								  </div>';
			}
			$data_html .='</div>
                                   </div>
                                  </div> 
                                </div>
                                </div>';
	  
	     }
	  /* else{
		  
		  $compare_content ='No Comparison Data Found';
		     
	   }*/
		
		
		 
	  }
	  
	  
	
	}
		
	$output = array("status"=>"success","data_html"=>$data_html,"survey_question_count"=>$total_survey_questions,"current_page"=>$current_page,"question_type_id"=>$question_type_id);
	echo json_encode($output);
    exit;
  
  }
  
  public function change_survey_type() {
   
     $survey_type_id = $this->input->post('survey_type_id'); 
	 $session_data = $this->session->userdata('logged_in');
	 $session_data['survey_type_id'] 	= $survey_type_id;
	 $this->session->set_userdata ('logged_in',$session_data); 
	 $arr= array("status"=>"success");	 		
	 echo json_encode($arr);
	 exit; 
  } 

  public function toNum($data) {
    $alphabet = array( 'A', 'B', 'C', 'D', 'E',
                       'F', 'G', 'H', 'I', 'J',
                       'K', 'L', 'M', 'N', 'O',
                       'P', 'Q', 'R', 'S', 'T',
                       'U', 'V', 'W', 'X', 'Y',
                       'Z');
    $alpha_flip = array_flip($alphabet);
    $return_value = -1;
    $length = strlen($data);
    for ($i = 0; $i < $length; $i++) {
        $return_value +=
            ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
    }
    return $return_value+1;;
}

 function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return $this->getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
 }

 
 
  
  public function rand_string($length) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

  }
 
 /**
     * validating the form elemnets
     */
  public function _init_login_validation_rules() {
        $this->form_validation->set_rules('username', 'username', 'required|max_length[50]');
        $this->form_validation->set_rules('password', 'password', 'required|max_length[20]');
    }

  public function _init_login_details() {
        $this->username = $this->input->post("username");
        $this->password = $this->input->post("password");
    }
 

}



?>