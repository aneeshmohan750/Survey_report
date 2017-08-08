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
                if ($this->authentication->process_auto_admin_login($login_details) == 'success') {
				    $session_data=$this->session->userdata('logged_in');
                    $arr = array('status' =>'success');
                } else {
                    
                    $arr = array('status' =>'failed','message'=>'Invalid Username or Password');
                }
            }
		 echo json_encode($arr); 
	     exit;	
        }
   
 }
 
 public function savesurveyForm(){
	
	if (!empty($_POST)) { 
	  
	  $survey_id = $this->input->post('survey_id');
	  $survey_type_id = $this->input->post('survey_type_id');
	  $report_status = $this->input->post('report_status'); 
	  $questions = $this->input->post('questions');
	  $graph_type = $this->input->post('graph_type');
	  $snapshot_view_type = $this->input->post('snapshot_view_type');
	  $display_order = $this->input->post('display_order');
	  $enable_comparison = $this->input->post('enable_comparison');
	  $enable_graph = $this->input->post('enable_graph');
	  $enable_table = $this->input->post('enable_table');
	  $show_appendix = $this->input->post('show_appendix');
	  $enable_daily_analysis = $this->input->post('enable_daily_analysis');
	  $enable_demographics = $this->input->post('enable_demographics');
	  $enable_observation = $this->input->post('enable_observation');
	  $enable_snapshot = $this->input->post('enable_snapshot_status');
	  $enable_report = $this->input->post('enable_report_status');
	  $report_display_order = $this->input->post('report_display_order');
	  $question_observation = $this->input->post('report_question_observation');
	  if($questions){
	   
		foreach($questions as $question_id){
	      $question_id=(integer)$question_id;
		  $graph_id = $graph_type[$question_id];
		  $snapshot_view = $snapshot_view_type[$question_id];    
	      $snapshot_display_order =  $display_order[$question_id];
		  $re_display_order =  $report_display_order[$question_id];
		  if(isset($enable_comparison[$question_id]))
	         $comparison = 1;
	      else
	         $comparison  = 0; 		  
		  if(isset($enable_graph[$question_id]))	 
		 	$enable_graph_status ='Y';
		  else
		    $enable_graph_status ='N';
	      if(isset($enable_table[$question_id]))	 
		 	$enable_table_status ='Y';
		  else
		    $enable_table_status ='N';
		  if(isset($show_appendix[$question_id]))	 
		 	$show_appendix_status ='Y';
		  else
		    $show_appendix_status ='N';
		  if(isset($enable_daily_analysis[$question_id]))	 
		 	$enable_daily_analysis_status ='Y';
		  else
		    $enable_daily_analysis_status ='N';
		  if(isset($enable_demographics[$question_id]))	 
		 	$enable_demographics_status ='Y';
		  else
		    $enable_demographics_status ='N';
		  if(isset($enable_observation[$question_id]))	 
		 	$enable_observation_status ='Y';
		  else
		    $enable_observation_status ='N';
		  if(isset($enable_snapshot[$question_id]))	 
		 	$enable_snapshot_status ='Y';
		  else
		    $enable_snapshot_status ='N';
		  if(isset($enable_report[$question_id]))	 
		 	$enable_report_status ='Y';
		  else
		    $enable_report_status ='N';		
			
		  if($question_observation[$question_id]!='No observations found'){
			 
			 $observation_data = $this->common_model->get_data("survey_question_observation",'observation',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"question_id"=>$question_id));
			 if($observation_data)
			 $this->common_model->update("survey_question_observation",array("observation"=>$question_observation[$question_id]),array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"question_id"=>$question_id));
			 else
			   $this->common_model->save("survey_question_observation",array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"question_id"=>$question_id,"observation"=>$question_observation[$question_id]));	 
			   
		  }
		 
		  $update_arr=array("graph_id"=>$graph_id,
		                    "snapshot_view_type"=>$snapshot_view,
							"display_order"=>$snapshot_display_order,
							"report_display_order"=>$re_display_order,
							"enable_comparison"=>$comparison,
							"enable_graph"=>$enable_graph_status,
							"enable_table"=>$enable_table_status,
							"show_appendix"=>$show_appendix_status,
							"enable_daily_analysis"=>$enable_daily_analysis_status,
							"enable_demographics"=>$enable_demographics_status,
							"enable_observation"=>$enable_observation_status,
							"snapshot_listing_status"=>$enable_snapshot_status,
							"report_listing_status"=>$enable_report_status
							);
		  $this->common_model->update("survey_type_question_map",$update_arr,array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"q_id"=>$question_id));					  
		  
		}
	  
	  }
     $this->common_model->update("survey_user_map",array("report_status"=>$report_status),array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
	 $arr = array("status"=>"success");
	 
	}
   
   echo json_encode($arr);
   exit;   
   	 
 }
 
  public function createquestion(){
	
	if (!empty($_POST)) { 
	   
	   $question = $this->input->post('question');
	   $question_type = $this->input->post('question_type');
	   $question_option = $this->input->post('question_option');
	   $this->common_model->save("questions_master",array("question"=>$question,"question_type_id"=>$question_type,"q_option"=>$question_option));	 	
	   $arr = array("status"=>"success");	 	 	 
	 
	}
   
   echo json_encode($arr);
   exit;  	
 
 }
 
 public function savequestionForm(){
	
	if (!empty($_POST)) { 
	   
	   $question = $this->input->post('question');
	   $question_type = $this->input->post('question_type');
	   $question_id = $this->input->post('question_id');
	   $question_option = $this->input->post('question_option');
	   $this->common_model->update("questions_master",array("question"=>$question,"question_type_id"=>$question_type,"q_option"=>$question_option),array("q_id"=>$question_id));	 
	
	$arr = array("status"=>"success");	 	 	 
	 
	}
   
   echo json_encode($arr);
   exit;  	
 
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