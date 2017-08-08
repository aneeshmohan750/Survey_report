<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
        
    var $gen_contents = array();
        
    public function __construct() {
            parent::__construct();
			$this->load->library('form_validation');
			
        }
    	
	public function index() {
		 if($this->session->userdata('admin_logged_in')){
			 $this->gen_contents['current_controller'] = "index";
             $this->gen_contents['page_title'] = "Index";
			 $session_data=$this->session->userdata('admin_logged_in');
			 $this->gen_contents['display_name']  =  $session_data['ADMIN_NAME'];
			 $this->gen_contents['survey_details']=$this->common_model->get_data('survey_master','*',array("status"=>1),'start_date DESC');			
			 $this->load->view('admin/common/header',$this->gen_contents);			           
			 $this->load->view('admin/index',$this->gen_contents);
			 $this->load->view('admin/common/footer',$this->gen_contents);		     
		 }
		 else{
		    redirect('admin/index/login', 'refresh');
		 }  
		   		
   }
   

   
   public function create_survey() {
		 if($this->session->userdata('admin_logged_in')){
			 $this->gen_contents['current_controller'] = "create_survey";
             $this->gen_contents['page_title'] = "Create Survey";
			 $session_data=$this->session->userdata('admin_logged_in');
			 $this->gen_contents['display_name']  =  $session_data['ADMIN_NAME'];
			 $this->gen_contents['survey_master_data']=$this->common_model->get_data('survey_master','*',array("status"=>1),'start_date DESC');	
			 $this->gen_contents['survey_type_master_data']=$this->common_model->get_data('survey_type_master','*',array("status"=>1));	
			 $this->gen_contents['graph_master'] = $this->common_model->get_data('graph_master','*');
			 $this->load->view('admin/common/header',$this->gen_contents);			           
			 $this->load->view('admin/create_survey_report',$this->gen_contents);
			 $this->load->view('admin/common/footer',$this->gen_contents);		     
		 }
		 else{
		    redirect('admin/index/login', 'refresh');
		 }  
		   		
   }
   
   public function edit_survey($survey_id) {
		 if($this->session->userdata('admin_logged_in')){
			 $this->gen_contents['current_controller'] = "edit_survey";
             $this->gen_contents['page_title'] = "Edit Survey";
			 $session_data=$this->session->userdata('admin_logged_in');
			 $this->gen_contents['display_name']  =  $session_data['ADMIN_NAME'];
			 $this->gen_contents['company_details']=$this->common_model->get_data('company','*',array('id'=>$company_id));
			 $this->load->view('admin/common/header',$this->gen_contents);		           
			 $this->load->view('admin/edit_company',$this->gen_contents);
			 $this->load->view('admin/common/footer',$this->gen_contents);		     
		 }
		 else{
		    redirect('admin/index/login', 'refresh');
		 }  
		   		
   }
   
   
   public function questions() {
		 if($this->session->userdata('admin_logged_in')){
			 $this->gen_contents['current_controller'] = "questions";
             $this->gen_contents['page_title'] = "Questions";
			 $session_data=$this->session->userdata('admin_logged_in');
			 $this->gen_contents['display_name']  =  $session_data['ADMIN_NAME']; 
			 $this->gen_contents['question_details']=$this->common_model->get_data('questions_master','*');			
			 $this->load->view('admin/common/header',$this->gen_contents);			           
			 $this->load->view('admin/question_master',$this->gen_contents);
			 $this->load->view('admin/common/footer',$this->gen_contents);		     
		 }
		 else{
		    redirect('admin/index/login', 'refresh');
		 }  
		   		
   }
   
   public function create_question() {
		 if($this->session->userdata('admin_logged_in')){
			 $this->gen_contents['current_controller'] = "create_question";
             $this->gen_contents['page_title'] = "Create Question";
			 $session_data=$this->session->userdata('admin_logged_in');
			 $this->gen_contents['display_name']  =  $session_data['ADMIN_NAME']; 
			 $this->gen_contents['question_type_master']=$this->common_model->get_data('question_type_master','*');
			 $this->load->view('admin/common/header',$this->gen_contents);		           
			 $this->load->view('admin/create_question_master',$this->gen_contents);
			 $this->load->view('admin/common/footer',$this->gen_contents);		     
		 }
		 else{
		    redirect('admin/index/login', 'refresh');
		 }  
		   		
   }
   
   public function edit_question($question_id) {
		 if($this->session->userdata('admin_logged_in')){
			 $this->gen_contents['current_controller'] = "edit_question";
             $this->gen_contents['page_title'] = "Edit Question";
			 $session_data=$this->session->userdata('admin_logged_in');
			 $this->gen_contents['display_name']  =  $session_data['ADMIN_NAME']; 
			 $this->gen_contents['question_details']=$this->common_model->get_data('questions_master','*',array('q_id'=>$question_id));
			 $this->gen_contents['question_type_master']=$this->common_model->get_data('question_type_master','*');
			 $this->load->view('admin/common/header',$this->gen_contents);		           
			 $this->load->view('admin/edit_question_master',$this->gen_contents);
			 $this->load->view('admin/common/footer',$this->gen_contents);		     
		 }
		 else{
		    redirect('admin/index/login', 'refresh');
		 }  
		   		
   }
   
   public function survey_report() {
		 if($this->session->userdata('admin_logged_in')){
			 $this->gen_contents['current_controller'] = "setup_report";
             $this->gen_contents['page_title'] = "Setup report";
			 $session_data=$this->session->userdata('admin_logged_in');
			 $this->gen_contents['display_name']  =  $session_data['ADMIN_NAME']; 
			 $this->gen_contents['survey_user_map_details']=$this->common_model->get_survey_map_details();
			 $this->load->view('admin/common/header',$this->gen_contents);			           
			 $this->load->view('admin/survey_report',$this->gen_contents);
			 $this->load->view('admin/common/footer',$this->gen_contents);		     
		 }
		 else{
		    redirect('admin/index/login', 'refresh');
		 }  
		   		
   }
   
   public function edit_survey_report($survey_id,$survey_type_id) {
		 if($this->session->userdata('admin_logged_in')){
			 $this->gen_contents['current_controller'] = "edit_survey_report";
             $this->gen_contents['page_title'] = "Setup report";
			 $session_data=$this->session->userdata('admin_logged_in');
			 $this->gen_contents['display_name']  =  $session_data['ADMIN_NAME']; 
			 $this->gen_contents['survey_id'] = $survey_id;
			 $this->gen_contents['survey_type_id'] = $survey_type_id;
			 $this->gen_contents['survey_report_status'] = $this->common_model->get_survey_report_status($survey_id,$survey_type_id);
			 $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$survey_id,'survey_name','survey_id');
			 $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$survey_type_id,'title','survey_type_id');
			 $this->gen_contents['survey_map_details'] = $this->common_model->get_data('survey_type_question_map','*',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
			 $this->gen_contents['graph_master'] = $this->common_model->get_data('graph_master','*');
			 $this->load->view('admin/common/header',$this->gen_contents);			           
			 $this->load->view('admin/edit_survey_report',$this->gen_contents);
			 $this->load->view('admin/common/footer',$this->gen_contents);		     
		 }
		 else{
		    redirect('admin/index/login', 'refresh');
		 }  
		   		
   }	   
   		   
   	    
   public function login() {
	   if($this->session->userdata('admin_logged_in')){
	           redirect('admin/index', 'refresh');
	   }
	   else{
	         $this->gen_contents['current_controller'] = "login";
             $this->gen_contents['page_title'] = "Login"; 
			 $this->load->view('admin/common/login_header',$this->gen_contents);	        
			 $this->load->view('admin/login',$this->gen_contents);
			 $this->load->view('admin/common/login_footer',$this->gen_contents);	  				 
		 }
   }
   
    public function forgot_password() {
	   if($this->session->userdata('admin_logged_in')){
	           redirect('admin/index', 'refresh');
	   }
	   else{
	         $this->gen_contents['current_controller'] = "forgot_password";
             $this->gen_contents['page_title'] = "Forgot Password";         
			 $this->load->view('admin/forgot_password',$this->gen_contents);				 
		 }
   }
   
   public function resetpassword($reset_code)
	
	{
            $this->gen_contents['current_controller'] = "resetpassword";
            $this->gen_contents['page_title'] = "Reset Password";
			$this->gen_contents['user_id']=$this->common_model->fetch_admin_user_id_from_code($reset_code);
			if($this->gen_contents['user_id']){  
				$this->load->view('admin/reset_password', $this->gen_contents);
			}
			else
			{
			  redirect('admin/index/login');
			}	
		  
	
	}
   
   public function user_logout() {
	 $this->authentication->admin_logout();
     redirect('admin/index/login');
   
   }
  
   public function getSurveyquestionObjective($survey_id,$survey_type_id,$question_id){
	
	return $this->common_model->getSurveyQuestionobjective($survey_id,$survey_type_id,$question_id);  
	  
  } 	
   
  public function get_entity_field($model,$id,$field,$where_field='id'){
     $entity=$this->common_model->get_data($model,$field,array($where_field=>$id));
	 if($entity)
	   return $entity[0][$field];
	 else
	   return false;   
	 
   } 
       
        
}

/* End of file index.php */