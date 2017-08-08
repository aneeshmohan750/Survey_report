<?php


defined('BASEPATH') OR exit('No direct script access allowed');
 
 
class Index  extends CI_Controller {

	/** 
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name> 
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	var $gen_contents = array();
        
    public function __construct() {
		
            parent::__construct();
			
    }
	
   public function index(){

	   if($this->session->userdata('is_login')){
          
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='index';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  if($this->gen_contents['survey_type_id']==9)
		    redirect('index/gitexshopper_cati_july_2017', 'refresh');
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');		
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  
		  $this->gen_contents['enable_export'] = $this->common_model->get_enable_export_status($session_data['survey_id'],$session_data['survey_type_id'],$session_data['USER_ID']);
		  $this->gen_contents['top_countries'] = $this->common_model->getTopcountries($session_data['survey_id'],$session_data['survey_type_id'],5);
		  $this->gen_contents['total_countries'] = $this->common_model->gettotalcountries($session_data['survey_id'],$session_data['survey_type_id'],2);
		  $this->gen_contents['snapshot_questions'] = $this->common_model->getSnapshotQuestions($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['snapshot_widgets'] = $this->common_model->get_data('snapshot_widgets','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('index',$this->gen_contents);
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }	 
	
   
   public function survey_report(){

	   if($this->session->userdata('is_login')){
		  
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='survey_report';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');		
		  //$arr = array("1"=>"Excellent","2"=>"Good","3"=>"Average","4"=>"Poor");		  
		  $this->gen_contents['survey_questions']   = $this->common_model->getSurveyQuestions($session_data['survey_id'],$session_data['survey_type_id'],$page=0);
		  $this->gen_contents['all_survey_questions']   = $this->common_model->getSurveyQuestions($session_data['survey_id'],$session_data['survey_type_id']);
		  
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);		
		  $this->gen_contents['total_survey_questions'] = $this->common_model->getSurveyQuestionsCount($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  $this->gen_contents['survey_comparison_type'] = $this->common_model->get_data('survey_comparison','comparison_type',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id'])); 
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('survey_report',$this->gen_contents);
		 
		  
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function appendix(){

	   if($this->session->userdata('is_login')){
		  
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='appendix';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');				          $this->gen_contents['appendix_questions'] = $this->common_model->get_appendix_questions($session_data['survey_id'],$session_data['survey_type_id']);
		
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);		
		  $this->gen_contents['total_survey_questions'] = $this->common_model->getSurveyQuestionsCount($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  $this->gen_contents['survey_comparison_type'] = $this->common_model->get_data('survey_comparison','comparison_type',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id'])); 
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('appendix',$this->gen_contents);
		 
		  
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function daywise_analysis(){

	   if($this->session->userdata('is_login')){
		  
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='daywise_analysis';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');				          $this->gen_contents['daywise_analysis_questions'] = $this->common_model->daywise_analysis_questions($session_data['survey_id'],$session_data['survey_type_id']);
		 
		  
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);		
		  $this->gen_contents['total_survey_questions'] = $this->common_model->getSurveyQuestionsCount($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  $this->gen_contents['survey_comparison_type'] = $this->common_model->get_data('survey_comparison','comparison_type',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id'])); 
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('daywise_analysis',$this->gen_contents);
		 
		  
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function co_relation(){

	   if($this->session->userdata('is_login')){
		  
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='co_relation';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');				          $this->gen_contents['co_relations'] = $this->common_model->get_data('survey_corelations','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));	
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);		
		  $this->gen_contents['total_survey_questions'] = $this->common_model->getSurveyQuestionsCount($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  $this->gen_contents['survey_comparison_type'] = $this->common_model->get_data('survey_comparison','comparison_type',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id'])); 
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('corelations',$this->gen_contents);
		 
		  
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
    public function demographics(){

	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='demographics';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');		
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  
		  $this->gen_contents['top_countries'] = $this->common_model->getTopcountries($session_data['survey_id'],$session_data['survey_type_id'],5);
		 
		  $this->gen_contents['total_countries'] = $this->common_model->gettotalcountries($session_data['survey_id'],$session_data['survey_type_id'],2);
		  $this->gen_contents['snapshot_questions'] = $this->common_model->getSnapshotQuestions($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['snapshot_widgets'] = $this->common_model->get_data('snapshot_widgets','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));
		  $this->gen_contents['demographics_questions'] = $this->common_model->getDemographicsQuestions($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('demographics',$this->gen_contents);
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function survey_insights(){

	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='survey_insights';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');		
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  $this->gen_contents['survey_insights'] = $this->common_model->get_data('survey_further_insights','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('survey_insights',$this->gen_contents);
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function looking_forward(){

	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='looking_forward';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');		
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  $this->gen_contents['survey_looking_forward'] = $this->common_model->get_data('survey_looking_forward','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('survey_looking_forward',$this->gen_contents);
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function gitexshopper_cati_july_2017(){

	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='power_bi';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');		
		 
		  $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		   $this->load->view('common/cati_header',$this->gen_contents);
		   $this->load->view('power_bi_page',$this->gen_contents);
		   $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }				 
   
   public function snapshot(){

	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='snapshot';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');		
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($session_data['survey_id'],$session_data['survey_type_id']);		
		  $this->gen_contents['snapshot_questions'] = $this->common_model->getSnapshotQuestions($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['top_countries'] = $this->common_model->getTopcountries($session_data['survey_id'],$session_data['survey_type_id'],1012);
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('snapshot_view',$this->gen_contents);
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
  
  public function change_password(){

	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='survey_report';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['user_id'] = $session_data['USER_ID'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');  
		   $this->gen_contents['survey_types']  =  $this->common_model->get_data('survey_user_map','survey_type_id',array("user_id"=>$session_data['USER_ID'],"survey_id"=>$session_data['survey_id']));
		  $this->gen_contents['survey_menuitems'] = $this->common_model->get_menu_items($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('change_password',$this->gen_contents);
		 
		  
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }  
  
  public function generate_report_preview(){
       
	    if($this->session->userdata('is_login')){
     
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='generate_report_preview';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_report_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_report_logo','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_start_date'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'start_date','survey_id');
		  $this->gen_contents['survey_end_date'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'end_date','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');	
		  $this->gen_contents['top_countries'] = $this->common_model->getTopcountries($session_data['survey_id'],$session_data['survey_type_id'],5);		
		  //$arr = array("1"=>"Excellent","2"=>"Good","3"=>"Average","4"=>"Poor");
		  $this->gen_contents['snapshot_widgets'] = $this->common_model->get_data('snapshot_widgets','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));
		  $this->gen_contents['demographics_questions'] = $this->common_model->getDemographicsQuestions($session_data['survey_id'],$session_data['survey_type_id']);		  
		  $this->gen_contents['survey_questions']   = $this->common_model->getSurveyQuestions($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['daywise_analysis_questions'] = $this->common_model->daywise_analysis_questions($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['co_relations'] = $this->common_model->get_data('survey_corelations','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));
		  $this->gen_contents['survey_insights'] = $this->common_model->get_data('survey_further_insights','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));	
		     $this->gen_contents['survey_looking_forward'] = $this->common_model->get_data('survey_looking_forward','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));	
		   $this->gen_contents['appendix_questions'] = $this->common_model->get_appendix_questions($session_data['survey_id'],$session_data['survey_type_id']);
			
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($this->gen_contents['survey_id'],$this->gen_contents['survey_type_id']);		
		  $this->gen_contents['survey_comparison_type'] = $this->common_model->get_data('survey_comparison','comparison_type',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id'])); 
		  $this->load->view('survey_report_preview_final',$this->gen_contents);
		
		 }
	   else{

	          redirect('index/login', 'refresh');

	   }	 
	   
   }
   
    public function generate_snapshot_preview(){
       
	    if($this->session->userdata('is_login')){
     
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
          $this->gen_contents['current_controller']='generate_report_preview';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['display_name']  =  $session_data['NAME'];
		  $this->gen_contents['survey_id'] = $session_data['survey_id'];
		  $this->gen_contents['survey_type_id'] = $session_data['survey_type_id'];
		  $this->gen_contents['survey_name'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_name','survey_id');
		  $this->gen_contents['survey_report_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_report_logo','survey_id');
		  $this->gen_contents['survey_logo'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'survey_logo','survey_id');
		  $this->gen_contents['survey_start_date'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'start_date','survey_id');
		  $this->gen_contents['survey_end_date'] = $this->get_entity_field('survey_master',$session_data['survey_id'],'end_date','survey_id');
		  $this->gen_contents['survey_type_name'] = $this->get_entity_field('survey_type_master',$session_data['survey_type_id'],'title','survey_type_id');	
		  $this->gen_contents['top_countries'] = $this->common_model->getTopcountries($session_data['survey_id'],$session_data['survey_type_id'],5);		
		  //$arr = array("1"=>"Excellent","2"=>"Good","3"=>"Average","4"=>"Poor");
		  $this->gen_contents['snapshot_widgets'] = $this->common_model->get_data('snapshot_widgets','*',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id']));
		 
		  $this->gen_contents['snapshot_questions'] = $this->common_model->getSnapshotQuestions($session_data['survey_id'],$session_data['survey_type_id']);
		  $this->gen_contents['survey_respondants'] = $this->common_model->getSurveyRespondants($this->gen_contents['survey_id'],$this->gen_contents['survey_type_id']);		
		  $this->gen_contents['survey_comparison_type'] = $this->common_model->get_data('survey_comparison','comparison_type',array("survey_id"=>$session_data['survey_id'],"survey_type_id"=>$session_data['survey_type_id'])); 
		  $this->load->view('snapshot_preview_final',$this->gen_contents);
		
		 }
	   else{

	          redirect('index/login', 'refresh');

	   }	 
	   
   } 
   
   public function import_excel_file(){
     
	  $uploaded_file_name ='ex-01.xlsx';
	  $data_segment= array();
	  $contact_segmentation='';
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/sample_excel/'.$uploaded_file_name;
	  //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
	  
	       if($row==1){
	       $header[$row][$column] = $data_value;
	      }	 
	      if ($row >1) {
	       $content[$row][$column] = $data_value;
	      }		
	   }
	
	$query=''; 
	 $output = array();
	  foreach($content as $row=>$page_content){
		 foreach($page_content as $index=>$value){
			 //$this->common_model->update('question_answers',array('type'=>'international'),array('user_unique_id'=>$value));
			 
			 if($index=='A')
			    $user = $value;  
			else{	
			   if($value)	
			   $query .='("'.$user.'","'.$value.'","1"),' ;
			   
			}
			/*else{
			  
			   
			  
		      $dat='international';
			  
			  
			 $query .=' WHEN user_unique_id = "'.$user_id.'" THEN "'.$dat.'"';
			   
			   
			  }*/
			 
			  
		 }

	  }
	   
	  $query = rtrim($query, ",");
   
	$this->common_model->insert_query($query);
	
   echo "completed Insertion !!!!!";
	  
	
	//$this->write_excel($output);
 
}

public function import_excel_file_date(){
     
	  $uploaded_file_name ='ex-01.xlsx';
	  $data_segment= array();
	  $contact_segmentation='';
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/sample_excel/'.$uploaded_file_name;
	  //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
	  
	       if($row==1){
	       $header[$row][$column] = $data_value;
	      }	 
	      if ($row >1) {
	       $content[$row][$column] = $data_value;
	      }		
	   }
	
	$query=''; 
	 $output = array();
	  foreach($content as $row=>$page_content){
		 foreach($page_content as $index=>$value){
			 //$this->common_model->update('question_answers',array('type'=>'international'),array('user_unique_id'=>$value));
			 
			 if($index=='A'){
			  
			   $user_id = $value;
			   $output[]=$user_id;
			 }
			else{
			  
			   
			  if($value){
		      $arr_dat=explode('.',$value);
			  
		      $dat=$arr_dat[2].'-'.$arr_dat[0].'-'.$arr_dat[1];
			  
			  $query .= "WHEN user_unique_id='".$user_id."' THEN '".$dat."'";
			 
			  }
			   
			  }
			 
			  
		 }

	  }
	   
	  $ex= implode("','",$output);
	
	 $this->common_model->update_mutiple_answer($query,$ex);
	echo "success";
	
	//$this->write_excel($output);
 
}
   
  public function import_excel_file_json(){
     
	  $uploaded_file_name ='ex-01.xlsx';
	  $data_segment= array();
	  $contact_segmentation='';
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/sample_excel/'.$uploaded_file_name;
	  //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
	  
	       if($row==1){
	       $header[$row][$column] = $data_value;
	      }	 
	      if ($row >1) {
	       $content[$row][$column] = $data_value;
	      }		
	   }
	   
	  /* foreach($header as $head){
		$i=1;
		foreach($head as $index=>$value){
		  
		  $arr = array("id"=>$i,"text"=>$value);
					
		   $js_arr[]=(object)$arr;	
		  
		  $i++;	
		}
		   
	   }
	   echo json_encode($js_arr);
	 exit;*/
	 
	 
	 $text ='[{"id":1,"text":"GISEC Conference (Paid)"},{"id":2,"text":"IoTx Conference (Paid)"},{"id":3,"text":"Market Labs (Free)"},{"id":4,"text":"(ISC)2 Workshop (Free)"}]';
	 
	$arr= json_decode($text);
   
	$dat_array= array();
	foreach($arr as $key=>$arr1){
	  
	 $dat_array[$arr1->text] = $arr1->id;
	
	}
	
	 $output = array();
	  foreach($content as $row=>$page_content){
		 $js_arr =array();
		 $arr = array();
		 $new_arr=array();
		 $counter=0;
		 $prev = $cur= '';
		 
		  
		 foreach($page_content as $index=>$value){
			 if($index=='A')
			   $user = $value;
			 else if($index!='A' and  $value){
				    

					$text = $header[1][$index];
					
				//$arr = array("id"=>$dat_array[$text],"text"=>$text);
				//$arr = array("text"=>$value,"rank"=>$text);
					//$arr = array("text"=>$value,"rank"=>$text);
					
					  
						 
					    $arr = array("id"=>$dat_array[$text],"text"=>$text);
						
						
						
						
						$js_arr[]=(object)$arr;	
						
					
					//$arr[] = $value;
					//$js_arr[$retailer]=(object)$arr;
			 }
			
			
		 }
		
		  if($js_arr)
	       $output[$user] = json_encode($js_arr);
		  
	     
	  }
	
	$this->write_excel($output);
 
} 




public function import_excel_file_answers(){
     
	 
	  $uploaded_file_name ='ex-01.xlsx';
	  $data_segment= array();
	  $contact_segmentation='';
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;More live demonstrations\/display of products at the counters
	  $uploaded_file = FCPATH.'uploads/sample_excel/'.$uploaded_file_name;
	  //read file from pathDfbfh%fg3940BDG54H53hY
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
	  
	      if($row==1){
	       $header[$row][$column] = $data_value;
	      }	 
	      if ($row >1) {
	       $content[$row][$column] = $data_value;
	      }		
	   }
	  
	 
	  foreach($content as $page_content){
		$query='';
		$h=1;
		
		foreach($page_content as $index=>$value){
			
			if($index=='A')
			   $user_id = $value;
			else{
			  
			    if($value)
			   //$arr = array("user_unique_id"=>$user_id,"answer"=>$value,"map_id"=>$header[1][$index]);
			   $query .="('".$user_id."','".$value."','".$header[1][$index]."')";
			      
			//$query .='("'.$user_id.'","'.$value.'","'.$header[1][$index].'")';
			   if($h < count($page_content) ) 
						$query .= ",";
			   
			  }
			
			
		  $h++;	
			
		}
		
		if($query)
		$this->common_model->insert_answer($query);
		
	  }
	   
	echo "success";
	exit; 
 
}

public function import_excel_file_json_new(){
     
	  $uploaded_file_name ='ex-01.xlsx';
	  $data_segment= array();
	  $contact_segmentation='';
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/sample_excel/'.$uploaded_file_name;
	  //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
	  
	       if($row==1){
	       $header[$row][$column] = $data_value;
	      }	 
	      if ($row >1) {
	       $content[$row][$column] = $data_value;
	      }		
	   }
	   
	  /* foreach($header as $head){
		$i=1;
		foreach($head as $index=>$value){
		  
		  $arr = array("id"=>$i,"text"=>$value);
					
		   $js_arr[]=(object)$arr;	
		  
		  $i++;	
		}
		   
	   }
	   echo json_encode($js_arr);
	 exit;*/
	 
	 
	 $text ='[{"id":1,"text":"English Newspaper"},{"id":2,"text":"Arabic Newspaper"},{"id":3,"text":"Industry Magazine"},{"id":4,"text":"Consumer Magazine"},{"id":5,"text":"Business Magazine"},{"id":6,"text":"Radio"}]';
	 
	$arr= json_decode($text);
   
	$dat_array= array();
	foreach($arr as $key=>$arr1){
	  
	 $dat_array[$arr1->text] = $arr1->id;
	
	}
	
	 $output = array();
	  foreach($content as $row=>$page_content){
		 $js_arr =array();
		 $arr = array();
		 $new_arr=array();
		 $counter=0;
		 $prev = $cur= '';
		 
		  
		 foreach($page_content as $index=>$value){
			 if($index=='A')
			   $user = $value;
			 else if($index!='A' and  $value){
				    
					
					$counter++;
					$text = $header[1][$index];
					$row_count = sizeof($page_content)-1;
				//$arr = array("id"=>$dat_array[$text],"text"=>$text);
				//$arr = array("text"=>$value,"rank"=>$text);
					//$arr = array("text"=>$value,"rank"=>$text);
					
					    $cur = $text;
						 if($counter==$row_count){
						   $prev=$cur;
						    $new_arr[] = $value; 
						 }
					    if(($prev!='' and $cur!=$prev) || ($counter==$row_count)  ){
						 	
						 
					     $arr = array("id"=>$dat_array[$prev],"text"=>$prev,"value"=>$new_arr);
						 unset($new_arr);
						 $new_arr = array();
						 $new_arr[] = $value; 
						
						}
						else
						 $new_arr[] = $value;
						
						
						
						$prev = $text;
						if($arr)
						$js_arr[]=(object)$arr;	
						
					
					//$arr[] = $value;
					//$js_arr[$retailer]=(object)$arr;
			 }
			
			
		 }
		
		  if($js_arr)
	       $output[$user] = json_encode($js_arr);
		  
	     
	  }
	
	$this->write_excel($output);
 
} 
/*public function import_excel_file(){
     
	 
	  $uploaded_file_name ='book1.xlsx';
	  $data_segment= array();
	  $contact_segmentation='';
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/sample_excel/'.$uploaded_file_name;
	  //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
	  
	      if($row==1){
	       $header[$row][$column] = $data_value;
	      }	 
	      if ($row >1) {
	       $content[$row][$column] = $data_value;
	      }		
	   }
	  
	  $query='';
	  foreach($content as $page_content){
		
		foreach($page_content as $index=>$value){
			
			if($index=='A')
			   $user_id = $value;
			else{
			  
			   
			   $arr_dat=explode('.',$value);
		      $dat=$arr_dat[2].'-'.$arr_dat[0].'-0'.$arr_dat[1];
			  
			  
			 $query .=' WHEN user_unique_id = "'.$user_id.'" THEN "'.$dat.'"';
			   
			   
			  }
			
			
		 
			
		}
		
		
	  }
	   $this->common_model->update_answer($query);
	echo "success";
	exit; 
 
}*/

 public function create_answer_map_table(){
	
	$query ='';
	
    $answers = $this->common_model->get_data_filter('local');
    
	foreach($answers as $answer){
	 
	  $map_answers=$this->common_model->get_data('question_answers_type_map','*',array('user_unique_id'=>$answer->user_unique_id));
	  
	  if(!$map_answers) 
	     
		 $query .='("'.$answer->user_unique_id.'","local","1"),';
		 
		 
	}
	
	$query = rtrim($query, ",");
    
	$this->common_model->insert_query($query);
	
   echo "completed Insertion !!!!!";
 
 }

 public function create_json(){
     
	  $uploaded_file_name ='ex-01.xlsx';
	  $data_segment= array();
	  $contact_segmentation='';
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/sample_excel/'.$uploaded_file_name;
	  //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
	  
	       if($row==1){
	       $header[$row][$column] = $data_value;
	      }	 
	      if ($row >1) {
	       $content[$row][$column] = $data_value;
	      }		
	   }
	   

	 $output = array();
	 $js_arr =array();
	$arr = array();
	  foreach($content as $row=>$page_content){
		 
		 $i=0;
		 foreach($page_content as $index=>$value){
			 $i++;
			 if($index=='A')
			   $text = $value;
			 else{
				   
					$string = round($value*100,2).'%';
					$arr = array("text"=>$text,"value"=>$string);
					//$new_arr[$reatiler]=$arr;
					
					$js_arr[]=(object)$arr;
					//$js_arr[$reatiler]=(object)$arr;
			 }
		 }
		
		  
		  
	     
	  }
	 
	   echo  json_encode($js_arr);
		 exit;
	 
	$this->write_excel($output);
 
} 




public function write_excel($output)
   {
     
	
$this->load->library('excel');
// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 
// Initialise the Excel row number
$rowCount = 1; 
// Iterate through each result from the SQL query in turn
// We fetch each database result row into $row in turn
   
    $ews = $objPHPExcel->getSheet(0);
	//$ews->setCellValue('g1', 'Sell in / Sell out Details of '.$retailer_name.' from '.$start_date.' to '.$end_date.'');

$style = array(
    'font' => array('bold' => true, 'size' => 13,),
    'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
);



	
	
		   $row_count=1; 
	       foreach($output as $index=>$out){
		          
				   $ews->setCellValue('a'.$rowCount, $index);
				   $ews->setCellValue('b'.$rowCount, $out);
		           $rowCount++; 
				  
		   }
	
	
	
	
   $file_name=' Report.xlsx';

// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
// Write the Excel file to filename some_excel_file.xlsx in the current directory
//$objWriter->save('some_excel_file.xlsx');

// We'll be outputting an excel file
   header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
   header('Content-Disposition: attachment; filename="'.$file_name.'"');

// Write file to the browser
   $objWriter->save('php://output'); 


   
   
   }
   
   public function export_survey_data_report($survey_id='',$survey_type_id='')
   {
        $survey_id=11;
		$survey_type_id=1;
		$this->load->library('excel');
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$row = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		$ews = $objPHPExcel->getSheet(0);
		
		
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		$row = 1;
		
		
          $style = array(
		'font' => array('bold' => true, 'size' => 11,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
		 $ews->setCellValue('A'.$row,'QID');		 
		 $ews->getStyle('A'.$row)->applyFromArray($style);
		 $ews->setCellValue('B'.$row,'Questions');		 
		 $ews->getStyle('B'.$row)->applyFromArray($style);
		 
		
		
		$row++; 
		$survey_question_data = $this->common_model->getSurveyQuestions($survey_id,$survey_type_id);
		$i=1;   
	    foreach($survey_question_data as $data){
		   
		   if($data->question_type_id==1 or $data->question_type_id==13 or $data->question_type_id==3 or $data->question_type_id==7 ){
		    $ews->setCellValue('A'.$row,$i);
			$ews->setCellValue('B'.$row,$data->question);
		}
		else if($data->question_type_id!=12 or $data->question_type_id!=3){
		   if($data->q_option){
			   $option_arr = json_decode($data->q_option);
			   $opt_count = sizeof($option_arr);
			   $j=0;
			   foreach($option_arr as $opt){
				$ews->setCellValue('A'.$row,$i.'.'.$this->getNameFromNumber($j));				
				$ews->setCellValue('B'.$row,$opt->text.':'.$data->question);
				$j++;
				if($j<$opt_count)
				$row++;     
				   
			   }
		   }
		   else{
			 $ews->setCellValue('A'.$row,$i);
			$ews->setCellValue('B'.$row,$data->question);   
			   
		   }
		  	
		}
		
		    
			$i++;
            $row++;  
	   }
		
		$file_name='Questions.xlsx';
		
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$file_name.'"');
		
		// Write file to the browser
		$objWriter->save('php://output'); 

   
   }
   
   public function export_survey_answers_data_report($survey_id='',$survey_type_id='')
   {
        $survey_id=11;
		$survey_type_id=1;
		$this->load->library('excel');
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$row = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		$ews = $objPHPExcel->getSheet(0);
		
		
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		$row = 1;
		
		
          $style = array(
		'font' => array('bold' => true, 'size' => 11,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
		 $ews->setCellValue('A'.$row,'Response ID');		 
		 $ews->getStyle('A'.$row)->applyFromArray($style);
		 $ews->setCellValue('B'.$row,'Exhibitor');		 
		 $ews->getStyle('B'.$row)->applyFromArray($style);
		 $ews->setCellValue('C'.$row,'Stand Number');		 
		 $ews->getStyle('C'.$row)->applyFromArray($style);
		 $ews->setCellValue('D'.$row,'QID');		 
		 $ews->getStyle('D'.$row)->applyFromArray($style);
		 $ews->setCellValue('E'.$row,'Answer');		 
		 $ews->getStyle('E'.$row)->applyFromArray($style);
		
		$company_map_ar = $this->common_model->get_data('survey_type_question_map','map_id',array("q_id"=>291,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
		$stand_map_ar = $this->common_model->get_data('survey_type_question_map','map_id',array("q_id"=>533,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
		$row++; 
		$survey_question_data = $this->common_model->getSurveyQuestions($survey_id,$survey_type_id);
		$i=1;   
	    foreach($survey_question_data as $data){
		  
		  $map_id = $data->map_id;
		  if($data->question_type_id==2){
		     $option_arr = json_decode($data->q_option);
		  }
		  $survey_answer_data = $this->common_model->get_data('question_answers','*',array("map_id"=>$map_id));
		  
		  foreach($survey_answer_data as $answer_data){
			if($data->question_type_id==1 or $data->question_type_id==13  or $data->question_type_id==12 or $data->question_type_id==3 or $data->question_type_id==7){
			    $company = $this->common_model->get_company_name($answer_data['user_unique_id'],$company_map_ar[0]['map_id']);
				$stand =   $this->common_model->get_company_name($answer_data['user_unique_id'],$stand_map_ar[0]['map_id']);
				$ews->setCellValue('A'.$row,$answer_data['user_unique_id']);
				$ews->setCellValue('B'.$row,$company);
				$ews->setCellValue('C'.$row,$stand);
				$ews->setCellValue('D'.$row,$i);
				$ews->setCellValue('E'.$row,$answer_data['answer']);
				$row++;
			}
			else if($data->question_type_id==2 or $data->question_type_id==15  ){
			  
			  $answer_option_arr = json_decode($answer_data['answer']);
			 
			  foreach($answer_option_arr as $ans_opt){
				$company = $this->common_model->get_company_name($answer_data['user_unique_id'],$company_map_ar[0]['map_id']);
				$stand =   $this->common_model->get_company_name($answer_data['user_unique_id'],$stand_map_ar[0]['map_id']); 
				$ews->setCellValue('A'.$row,$answer_data['user_unique_id']);
				$ews->setCellValue('B'.$row,$company);
				$ews->setCellValue('C'.$row,$stand);
				$ews->setCellValue('D'.$row,(string)$i.'.'.$this->getNameFromNumber(($ans_opt->id)-1));	
				if($data->question_type_id!=15)			
				$ews->setCellValue('E'.$row,$ans_opt->text);
				else
				 $ews->setCellValue('E'.$row,$ans_opt->value);
				$row++; 
				  
			  }
			  	
				
			}
			  
		  }
		  $i++;	
		}
		
		$file_name='Answers.xlsx';
		
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$file_name.'"');
		
		// Write file to the browser
		$objWriter->save('php://output'); 

   
   } 
   
   public function export_survey_demographics_data_report($survey_id='',$survey_type_id='')
   {
        $survey_id=11;
		$survey_type_id=1;
		$this->load->library('excel');
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$row = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		$ews = $objPHPExcel->getSheet(0);
		
		
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		$row = 1;
		
		
          $style = array(
		'font' => array('bold' => true, 'size' => 11,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
		 $ews->setCellValue('A'.$row,'Response ID');		 
		 $ews->getStyle('A'.$row)->applyFromArray($style);
		 $ews->setCellValue('B'.$row,'Company Name');		 
		 $ews->getStyle('B'.$row)->applyFromArray($style);
		 $ews->setCellValue('C'.$row,'Stand Number');		 
		 $ews->getStyle('C'.$row)->applyFromArray($style);
		 $ews->setCellValue('D'.$row,'Country');		 
		 $ews->getStyle('D'.$row)->applyFromArray($style);
		 $ews->setCellValue('E'.$row,'Full Name');		 
		 $ews->getStyle('E'.$row)->applyFromArray($style);
		 
		 $demographics_questions = $this->common_model->getDemographicsQuestions($survey_id,$survey_type_id);
		 $j=5;
		 foreach($demographics_questions as $demographic_question){
			
			 $ews->setCellValue($this->getNameFromNumber($j).$row,$demographic_question->question);
			 $ews->getStyle($this->getNameFromNumber($j).$row)->applyFromArray($style);
			 $j++;
		 }
		$row++; 
		$company_map_ar = $this->common_model->get_data('survey_type_question_map','map_id',array("q_id"=>291,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
		$stand_map_ar = $this->common_model->get_data('survey_type_question_map','map_id',array("q_id"=>533,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
		$name_ar = $this->common_model->get_data('survey_type_question_map','map_id',array("q_id"=>1,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
		$country_ar = $this->common_model->get_data('survey_type_question_map','map_id',array("q_id"=>5,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
		$demographics_user_list = $this->common_model->getDemographicsUsers($survey_id,$survey_type_id);
		foreach($demographics_user_list as $demographics_user){
		   $company = $this->common_model->get_company_name($demographics_user->user_unique_id,$company_map_ar[0]['map_id']);
		   $stand =   $this->common_model->get_company_name($demographics_user->user_unique_id,$stand_map_ar[0]['map_id']); 
		   $name =   $this->common_model->get_company_name($demographics_user->user_unique_id,$name_ar[0]['map_id']); 	
		   $country =   $this->common_model->get_company_name($demographics_user->user_unique_id,$country_ar[0]['map_id']); 	
		   $ews->setCellValue('A'.$row,$demographics_user->user_unique_id);
		   $ews->setCellValue('B'.$row,$company);
		   $ews->setCellValue('C'.$row,$stand);
		   $ews->setCellValue('D'.$row,$name);
		   $ews->setCellValue('E'.$row,$country);
		  
		   $row++;   
		}
		$row=2;
		foreach($demographics_user_list as $demographics_user){
		$j=5;
		 foreach($demographics_questions as $question){
		   
		   $survey_answers = $this->common_model->get_data('question_answers','answer',array('map_id'=>$question->map_id,'user_unique_id'=>$demographics_user->user_unique_id));	           if($survey_answers)
		    $ews->setCellValue($this->getNameFromNumber($j).$row,$survey_answers[0]['answer']);
		   $j++;	 
		 }
		 
		 $row++;
		 
		}
		
		$file_name='Demographics.xlsx';
		
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$file_name.'"');
		
		// Write file to the browser
		$objWriter->save('php://output'); 

   
   }   
   
   public function update_survey_status(){
	 
	 $survey_id=6;
	 $survey_type_id=2;
	 $survey_questions=$this->common_model->getSnapshotQuestions($survey_id,$survey_type_id);
	 foreach($survey_questions as $snap){
		
		
		$this->common_model->update('survey_type_question_map',array("snapshot_listing_status"=>"Y"),array("q_id"=>$snap->question_id,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
		 
	 }
	 
	$survey_questions=$this->common_model->getSurveyQuestions($survey_id,$survey_type_id);
	 foreach($survey_questions as $snap){
		
		
		$this->common_model->update('survey_type_question_map',array("report_listing_status"=>"Y"),array("q_id"=>$snap->question_id,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
		 
	 } 
	 
	 
	   echo "success";
	   exit;
   }
   
   public function getSurveyRespondants($survey_id,$survey_type_id,$comparison_type='default'){
  
   $survey_respondants = $this->common_model->getSurveyRespondants($survey_id,$survey_type_id,$comparison_type); 
   return $survey_respondants; 
	
  }
   
   
  public function getSurveyQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type='default'){
  
   $survey_question_respondants = $this->common_model->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type); 
   return $survey_question_respondants; 
	
  }
  
  public function getSurveyAnswers($survey_id,$survey_type_id,$question_id,$question_type,$graph_id,$output_type,$comparison_type='default')
  
  {
	 
	return $this->common_model->getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type,$graph_id,$output_type,$comparison_type); 
  
  }
  
  public function getSurveyDailyAnalysis($survey_id,$survey_type_id,$question_id,$question_type,$graph_id,$output_type,$comparison_type='default')
  
  {
	 
	return $this->common_model->getDaily_data($survey_id,$survey_type_id,$question_id,$question_type,$graph_id,$output_type,$comparison_type,1); 
  
  }
  
  public function getSurveyquestionObjective($survey_id,$survey_type_id,$question_id){
	
	return $this->common_model->getSurveyQuestionobjective($survey_id,$survey_type_id,$question_id);  
	  
  }
  
  public function getSurveyquestionConclusion($survey_id,$survey_type_id,$question_id){
	
	return $this->common_model->getSurveyQuestionconclusion($survey_id,$survey_type_id,$question_id);  
	  
  }
  
  public function getPreviousdataComparison($survey_id,$survey_type_id,$question_id,$question_type_id,$map_id,$comparison_type,$enable_comparison){
  
    return $this->common_model->getPrevdataComparison($survey_id,$survey_type_id,$question_id,$question_type_id,$map_id,$comparison_type,$enable_comparison);
  
  }
  
  public function getCombinationdataComparison($survey_id,$survey_type_id,$question_id,$question_type_id,$map_id){
  
    return $this->common_model->getCombinationdataComparison($survey_id,$survey_type_id,$question_id,$question_type_id,$map_id);
  
  }
  
  public function getCorelationData($corelation_id,$answer_data,$type,$show_index,$rating_index_factor,$corelation_type='single'){
   
   return $this->common_model->getCorelationDataCollection($corelation_id,$answer_data,$type,$show_index,$rating_index_factor,$corelation_type);   
   
  
  }
 
 
  public function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return $this->getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
  } 	  
  public function convert_date($string){
    
	$arr = explode('T',$string);	
	$format_date =  date('d-m-Y',strtotime($arr[0]));
	return $format_date;
  
  
  }	
  
  public function get_entity_field($model,$id,$field,$where_field='id'){
     $entity=$this->common_model->get_data($model,$field,array($where_field=>$id));
	 if($entity)
	   return $entity[0][$field];
	 else
	   return false;   
	 
   }
   
  public function get_client_logo($client_id){ 		
  
     $client=$this->common_model->get_data('clients','logo',array('id'=>$client_id)); 
	 if($client)
	   return $client[0]['logo'];
	 else
	   return false; 
   

  }
  
  public function menu_visiblity($menu_id,$survey_id,$survey_type_id){
   
    $menu = $this->common_model->get_data('survey_menu_map','*',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"menu_id"=>$menu_id,"status"=>1));
	if($menu)
	 return true;
	else
	 return false;
	
   
  }
   
  public function login() {

	   if($this->session->userdata('is_login')){
	           redirect('index', 'refresh');

	   }

	   else{

		     $this->gen_contents['page_title'] = 'Techmart Solutions - Survey Report';
		     $this->load->view('common/login_header',$this->gen_contents); 
	         $this->load->view('login');
			 $this->load->view('common/login_footer');			 

		}

  }
  public function logout() {

	 $this->authentication->user_logout();
     redirect('index/login');

   

   }	
}
	

