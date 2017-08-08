<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles admin functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------

class Common_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	function safe_html($input_field)
	{ 
		return htmlspecialchars(trim(strip_tags($input_field)));
	}
	
	function safe_sql($input_field)
	{ 
		return mysql_real_escape_string(trim(strip_tags($input_field)));
	}
	
	
	/**
	 * to send emails to a given email address
	 *
	 * @param Sring $to_email
	 * @param Sring $from
	 * @param Sring $subject
	 * @param Sring $body_content
	 * @param Array $attachment
	 * @param Sring $from_mail
	 * @return Boolean
	 */
	
	
	
	function send_mail($to_email='', $from='', $subject, $body_content, $attachment = array(), $from_mail='', $cc=array(), $bcc=array(), $batch_mode=false, $batch_size=200)
	{
		$this->load->library ('email');
		$this->email->_smtp_auth	= FALSE; 	    
		$this->email->protocol		= "mail";
		//$this->email->smtp_host		= $this->config->item('smtp_host');
		//$this->email->smtp_user		= $this->config->item('smtp_from');
		//$this->email->smtp_pass		= $this->config->item('smtp_password');
		$this->email->mailtype		= $this->config->item('mailtype');
		
		//$this->email->smtp_timeout	= $this->config->item('smtp_timeout');
		//$this->email->smtp_port		= $this->config->item('smtp_port');
		//$this->email->smtp_crypto	= $this->config->item('smtp_crypto');
		$this->email->charset		= $this->config->item('charset');
 		
		$from_name					= ($from=='')?$this->config->item('smtp_from_name'):$from;
		$reply_mail					= ($from_mail=='')?$this->config->item('smtp_from'):$from_mail;
		$this->email->from($reply_mail, $from_name);
		$this->email->to($to_email);
		if(!empty($cc)){
			$this->email->cc($cc);
		}
		if(!empty($bcc)){
			$this->email->bcc($bcc);
		}
		$this->email->reply_to($reply_mail,$from_name);        
		//$this->email->set_mailtype('html');
		$this->email->subject($subject);
		$this->email->message($body_content);
		if($attachment !=''){
			foreach($attachment as $attach ){
				$this->email->attach($attach);
			}
		}
                
		if ($this->email->send ()){
			
 echo $this->email->print_debugger();exit;
		}
		else{
			
 echo $this->email->print_debugger();exit;
		}
	}
			
	/**
	 * get the config value
	 *
	 * @return unknown
	 */
	function get_config_item($conf_name){				
		$query = $this->db->query("SELECT config_value FROM ".$this->db->dbprefix."site_configuration WHERE config_name='".$conf_name."'");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			if($row->config_value){
				return $row->config_value;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	/**
	 * get the config value
	 *
	 * @return unknown
	 */
	function get_config_script($conf_name){				
		$query = $this->db->query("SELECT config_text FROM ".$this->db->dbprefix."site_configuration WHERE config_name='".$conf_name."'");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			if($row->config_text){
				return $row->config_text;			
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	/**
	 * to get the url of the post page
	 *
	 * @return String
	 */
	function get_post_url()
	{
		$postURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$postURL .= "s";}
		$postURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$postURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$postURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $postURL;
	}
	
	function prepare_select_box_data( $table, $fields, $where = array(), $insert_null = false,$order_by = '',$other_array = array()){
		
		list($key, $val) 	= explode(',',$fields);
		$key 				= trim($key);
		$val 				= trim($val);
		$order_by			= $order_by ? $order_by : $val;
		$input_array 		= $this->get_data( $table, $fields, $where, $order_by );

		$select_box_array 	= array();
		$total_records 		= count($input_array);
		if($insert_null) {
			$select_box_array[''] = $insert_null===true ? '' : $insert_null;
		}
		for($i = 0; $i < $total_records; $i++){
		 	$select_box_array[$input_array[$i][$key]] = $input_array[$i][$val];
		}
		if (is_array($other_array) and count($other_array) > 0){
			foreach ($other_array as $key => $val){
				$select_box_array[$key]				=	$val;
			}
		}
		return $select_box_array;
	}
	
    function record_count($table) {
        return $this->db->count_all($table);
     }
	
	function get_data( $table, $fields = '*', $where = array(),$order_by = '' ){
		if((is_array($where) && count($where)>0) or (!is_array($where) && trim($where) != '')) $this->db->where($where);
		if($order_by) $this->db->order_by($order_by);
		$this->db->select($fields);
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	function get_limit_data( $table, $fields = '*', $where = array(),$order_by = '',$start='',$limit=''){
		if((is_array($where) && count($where)>0) or (!is_array($where) && trim($where) != '')) $this->db->where($where);
		if($order_by) $this->db->order_by($order_by);
		$this->db->select($fields);
		$this->db->limit($start,$limit);
		$query = $this->db->get($table);
		$data_arr = $query->result_array();
		$data_html =$this->get_data_html($table,$data_arr);
		return $data_html;
	}
	
	function check_selectbox_values($aWhere=array(), $table_name=""){
		if($aWhere){
			$this->db->where($aWhere, "", false); 
		}
		$this->db->select('id');
		$this->db->from( $table_name ); 
		$result   = $this->db->get();
		$result = $result->result_array();
		$array_list = array();
		foreach ($result AS $res):
			$array_list[] = $res['id'];
		endforeach;
		return $array_list;
	}
	 
	function get_custom_data( $table, $fields = '*', $where = array(),$order_by = '' ){
		if((is_array($where) && count($where)>0) or (!is_array($where) && trim($where) != '')) 
		
		$this->db->where($where, "", false); 
		if($order_by) $this->db->order_by($order_by);
		$this->db->select($fields);
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	/**
	 * function to get the page titles and meta details
	 *
	 * @return unknown
	 */
	function get_page_meta($meta_id){
		$this->db->select('*');			
		$this->db->where('meta_id', $meta_id);			
		$query = $this->db->get("page_meta_details"); 			
		$result = array();
		if($query->row()) {	
			return $query->row();
		} 
		else return false;
	}
	 
	/**
	 * function for file_upload musik_track musik_mix_track
	 */  
	function file_upload($field_name = '',$upload_path = '',$allowed_type = '',$max_size = 1024){  
		if(@$_FILES[$field_name]['name']){
			$file  							=	explode('.', $_FILES[$field_name]['name']); 
			$name  							=	$file[0];
			$upload_path					=	upload_path().$upload_path; 
			
			if (!@$allowed_type){
				$config['allowed_types'] 	=   'gif|jpg|png|jpeg';
			}else{
				$config['allowed_types'] 	=   $allowed_type;
			}
			$config['upload_path'] 			=	$upload_path;
			$config['max_size'] 			=   $max_size;
			$config['remove_spaces'] 		=   TRUE; 
			$file_name						=	str_replace('(','_',$_FILES[$field_name]['name']);
			$file_name						=	str_replace(')','_',$file_name);
			$file_name						=	str_replace('-','_',$file_name);
			$config['file_name']	    	=   time().$file_name;
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			
			//$uplod_result					=	 ;
			$bStatus = false;
			$data = array();
			
			if( $this->upload->do_upload($field_name) ){
				
				$bStatus 	= true;
				
				//echoo('test 1');
				//_print_r($this->upload->data());
				$data 		= array('upload_data' => $this->upload->data());
				//return $data["upload_data"]["file_name"];
			}else{
				//echoo('test 1');
				$bStatus 	= false;
				$data['error_msg'] = $this->upload->display_errors();
			}
			
			return array($bStatus, $data);
			//return false; 
		} 
	}
 
	/**
	 * function to send email
	 *
	 * @return unknown
	 */
	function process_send_mail  ($email, $email_array, $title = '' ,$from_name ='',$from='',$attachment=array(), $mailsubject='')
	{
		$values_array		= array ();			
		$result_array       = $this->common_model->get_mail_content_and_title ($title);
		foreach ($result_array as $key=>$value)
		{
			$mail_subject   = ($mailsubject) ? $mailsubject : $key;
			$email_body     = $value;
		}
		$matches            = array();
		preg_match_all("/\{\%([a-z_A-Z0-9]*)\%\}/",$email_body, $matches);
		$variables_array    = $matches[1];
	
		if (count($variables_array) > 0) 
		foreach (@$variables_array as $key)
		{
			@$values_array[] = @$email_array[$key];
		}
	
		$new_variables_array    = array();
		foreach($variables_array as $variable)
		{
			$new_variables_array[] = '/\{\%'.$variable.'\%\}/';
		}
		$body_content ='';
		$body_content .= preg_replace ($new_variables_array, $values_array, $email_body);		
		
		if ($this->common_model->send_mail($email,$from_name, $mail_subject, $body_content,array(),$from))
			return TRUE;
		else
			return FALSE;
		
	}
	
	// function to get email title and content 
	function get_mail_content_and_title ($message_title = '')
	{
        $this->db->select('subject AS TITLE, content AS BODY_CONTENT');
        $this->db->from('email_templates');
        $this->db->where('title', $message_title);		
        $select_query   = $this->db->get ();
		if (0 < $select_query->num_rows ())
		{
            foreach ($select_query->result() as $row)
            {
                $result_array[$row->TITLE] = $row->BODY_CONTENT;
            }
            return $result_array;
		}
		else
		{
		    return FALSE;
		}
	}
	
	/**
	 * check any user exist
	 */
	function isUser($email)
	{
		$this->db->where('email', $email);
		$this->db->where('status','1');
		$this->db->select('*');
		$this->db->from('user_details');
		$result		= $this->db->get ();
		if ($result->row()){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * check any user exist
	 */
	function getUserbyEmail($email)
	{
		$this->db->where('email', $email);
		$this->db->select('*');
		$this->db->from('user_details');
		$result		= $this->db->get ();
		if ($result->row()){
			return $result->row();   
		}else{
			return false;
		}
	}
	
	/**
	 * get user details
	 *
	 * @return unknown
	 */
	function getCAProfileDetails($id){	
		if(isset ($id) && '' != $id){			
			$this->db->where('user_id',$id);
			$this->db->where('status','1');
			$this->db->select('*');
			$query	=	$this->db->get('user_profile');			
			if($query->row()){
				return $query->row();
			}else{
				return FALSE;
			}
		}else{ 
			return FALSE;
		}		
	}
	
	/**
	 * forgot password
	 */
	function forgot_password($email)
	{
		
		$this->db->where('email', $email);
		$this->db->where('status','1');
		$this->db->select('*');
		$this->db->from('user_details');
		$result_set   				= $this->db->get ();
		if (0 < $result_set->num_rows()){
			$row 					= $result_set->row();   
			
			$forgot_pwd				= random_string('alnum', 10);
			$ret_result['forgot_pwd']	= $forgot_pwd;
			$this->db->set('forgot_pwd', $forgot_pwd);
			$this->db->where('id', $row->id);
			$this->db->update('user_details'); 			
			$ret_result['first_name']	=	$row->first_name;
			$ret_result['last_name']	=	$row->last_name;
			$ret_result['id']		=	$row->id;
			$ret_result['email']	=	$row->email;
			return $ret_result;
		}else{
			return false;
		}
	}
	
	/**
	 * check any user exist
	 */
	function isPenindingUser($email)
	{
		$this->db->where('email', $email);
		$this->db->where('status','2');
		$this->db->select('*');
		$this->db->from('user_details');
		$result		= $this->db->get ();
		if ($result->row()){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * resend_link
	 */
	function resend_link($email)
	{
		$this->db->where('email', $email);
		$this->db->where('status','2');
		$this->db->select('*');
		$this->db->from('user_details');
		$result		= $this->db->get ();
		if ($result->row()){
			return $result->row();   
		}else{
			return false;
		}
		
	}
	
	// Common save
	function save($table, $data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	
	// Update
	function update($table, $data, $where){
		 if(!empty($data)){ 
			$this->db->where($where, "", true); 
			$this->db->set ($data);
			if($this->db->update ($table)){
				return TRUE;
			}else{
				return FALSE;
			}
        }
	}
	 
	// Common Delete function
  public function delete($table, $where=array()) {
		if(!empty($table)){  
			if( $this->db->delete($table, $where) ){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
  
  public function get_entity_field($model,$id,$field,$where_field='id'){
    
	 $entity=$this->common_model->get_data($model,$field,array($where_field=>$id));
	 if($entity)
	   return $entity[0][$field];
	 else
	   return false;   
	 
   }
   
  public function get_survey_map_details(){
	
	$query = $this->db->query("SELECT survey_id,survey_type_id,report_status FROM survey_user_map GROUP BY survey_id,survey_type_id ORDER BY survey_id DESC");
	return $query->result();  
	  
  }
  
  public function get_survey_report_status($survey_id,$survey_type_id){
	 
	 $survey_report=$this->get_data("survey_user_map",'report_status',array('survey_id'=>$survey_id,'survey_type_id'=>$survey_type_id));
	 if($survey_report)	  
	   return $survey_report[0]['report_status']; 
	 else
	   return false;   
  
  
  }
   
  public function getSurveyQuestions($survey_id,$survey_type_id,$page=-1){ 
   
    if($page >= 0 ){
	   $limit = 'LIMIT '.$page.',1';
	   
	}
	 else
	   $limit ='';  
 
    $query = $this->db->query("SELECT q.q_id as question_id,q.question as question,q.q_option,q.question_type_id,sq.survey_type_id,
	                            sq.survey_id,q.question_type_id,sq.graph_id,sq.map_id,sq.enable_comparison,sq.enable_graph,sq.enable_table,sq.enable_observation 
	                           FROM questions_master as q
                               LEFT JOIN survey_type_question_map as sq ON(q.q_id=sq.q_id)
					           WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." 
							   AND q.q_status='Y' AND sq.report_listing_status='Y' ORDER BY report_display_order ASC  ".$limit." "); 
	
    return $query->result();
  
  }
  
  public function getSurveyQuestionsCount($survey_id,$survey_type_id){ 
   
    $query = $this->db->query("SELECT q.q_id as question_id,q.question as question,sq.survey_type_id,sq.survey_id,q.question_type_id,sq.graph_id 
	                           FROM questions_master as q
                               LEFT JOIN survey_type_question_map as sq ON(q.q_id=sq.q_id)
					           WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." 
							   AND q.q_status='Y' AND sq.report_listing_status='Y' "); 
    return $query->num_rows();
  
  }
  
  
 public function getSurveyRespondants($survey_id,$survey_type_id,$comparison_type='default',$date=''){
    
    
	$comparison_where_condition = '';
	$comparison_left_join='';
	$date_where_condition = '';	
	if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $comparison_where_condition='AND qam.type="'.$comparison_type.'"'; 
	   
	}
	if($date!='')
	    $date_where_condition='AND qa.submitted_date="'.$date.'"';     
	
	$query = $this->db->query("SELECT qa.user_unique_id as survey_respondants FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id."
							   AND qm.q_status='Y' AND sq.report_listing_status='Y'  ".$comparison_where_condition." ".$date_where_condition."
							   GROUP BY qa.user_unique_id ");  
    $survey_respondants = $query->num_rows();
	return $survey_respondants;		
 
 }
 
 public function getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type='default',$date=''){
    
	$comparison_where_condition = '';
	$comparison_left_join='';
	$date_where_condition='';	
	if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $comparison_where_condition='AND qam.type="'.$comparison_type.'"'; 
	   
	} 
	if($date!='')   
	   $date_where_condition = 'AND qa.submitted_date="'.$date.'"';
    $query = $this->db->query("SELECT qa.user_unique_id as survey_respondants FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y'  ".$comparison_where_condition." ".$date_where_condition."
							   GROUP BY qa.user_unique_id ");   
    $survey_question_respondants = $query->num_rows();
	return $survey_question_respondants;		
 
 }
 
 public function get_appendix_questions($survey_id,$survey_type_id){ 
   
    $query = $this->db->query("SELECT q.q_id as question_id,q.question as question,sq.survey_type_id,
	                            sq.survey_id,q.question_type_id,sq.graph_id,sq.map_id,sq.enable_comparison,sq.enable_graph,sq.enable_table 
	                           FROM questions_master as q
                               LEFT JOIN survey_type_question_map as sq ON(q.q_id=sq.q_id)
					           WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." 
							   AND q.q_status='Y' AND sq.show_appendix='Y'"); 
    return $query->result();
  
  }
  
  public function getDemographicsQuestions($survey_id,$survey_type_id){ 
   
    $query = $this->db->query("SELECT q.q_id as question_id,q.question as question,sq.survey_type_id,
	                            sq.survey_id,q.question_type_id,sq.graph_id,sq.map_id,sq.enable_comparison,sq.enable_graph,sq.enable_table 
	                           FROM questions_master as q
                               LEFT JOIN survey_type_question_map as sq ON(q.q_id=sq.q_id)
					           WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." 
							   AND q.q_status='Y' AND sq.enable_demographics='Y'"); 
    return $query->result();
  
  }
  
   public function daywise_analysis_questions($survey_id,$survey_type_id){ 
   
    $query = $this->db->query("SELECT q.q_id as question_id,q.question as question,sq.survey_type_id,
	                            sq.survey_id,q.question_type_id,sq.graph_id,sq.map_id,sq.enable_comparison,sq.enable_graph,sq.enable_table 
	                           FROM questions_master as q
                               LEFT JOIN survey_type_question_map as sq ON(q.q_id=sq.q_id)
					           WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." 
							   AND q.q_status='Y' AND sq.enable_daily_analysis='Y'"); 
    return $query->result();
  
  }
 
 
 // *comparison_type, for overall and top 
 
 // *enable_comparison, flag for previous year ROI comparison
 
 // *return_percent, return percentage
 //$current_data= $this->getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type_id,0,'table',$comparison_type,$enable_comparison=1,$dat);
 public function getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type,$graph_id,$output_type,$comparison_type='default',$enable_comparison=0,$date='',$return_arr=0){

	switch($question_type) {	 
	 case 1:	 
	  return $this->getRadiobuttongraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison,$date,$return_arr);	 
	  break; 
	 case 2:	 
	  return $this->getMulticheckboxgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	 
	  break;
	 case 3:	 
	  return $this->getMapgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	 
	  break;
	 case 4:
	  return $this->getRankingWeightedgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	 
	  break;      
	 case 5:
	  return $this->getRatingWeightedgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	 
	  break;
	 case 7:  
	  return $this->getRadiobuttonindexgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison,$date,$return_arr);	 
	  break;   
	 case 8:
	  return $this->getRadiobuttonGridgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	 
	  break;
	 case 9:
	  return $this->getCheckboxGridgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	 
	  break;
	 case 10:
	  return $this->getOpenendedRadiobuttonGridgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break;
	 case 11:
	  return $this->getOpenendedRadiobuttonGridTitlegraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break;
	 case 12:
	  return $this->getOpenendedRankingWeightedGraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break; 
	 case 13:
	  return $this->getOpenendedRadiobuttongraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break;
	 case 14:
	  return $this->getOpenendedList($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break; 
	 case 15:
	  return $this->getOpenendedRadiobuttonGridUsername($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	  
	 case 16:
	  return $this->getOpenendedRadiobuttonGridgraphEntity($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break;  
	 case 17:
	  return $this->getOpenendedRadiobuttonGridCompanyNameFirstName($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break; 
	 case 18:
	  return $this->getOpenendedCheckboxGrid($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break;
	 case 19:
	   return $this->getRadiobuttonGridgraphWithoutRanking($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);
	  break;
	 case 20:
	  return $this->getOpenendedRadiobuttonGridCompanyNameJobTitle($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break;
	 case 21:
	  return $this->getOpenendedRadiobuttonGridUserNameJobTitle($survey_id,$survey_type_id,$question_id,$graph_id,$output_type,$comparison_type,$enable_comparison);	
	  break;                                   
	 default:
	  return "Unknown Question Type";
	  break;  
	     
	   
	
	}
	 
	  
 }
 
 public function getRadiobuttongraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$return_roi=false,$date='',$return_arr=false){

   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 $where_comparison_query = '';
	 $where_date_query ='';
	 $comparison_left_join='';
	 $output='';
	 if(!$option_arr)
	   return 'Unknown Json format';
	 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"'; 
	   
	 } 
     if($date!='')
	    $where_date_query = 'AND qa.submitted_date="'.$date.'"'; 	
	 $query = $this->db->query("SELECT qa.answer,count(qa.answer) as anwser_count  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." ".$where_date_query." GROUP BY qa.answer ");   
	$result=$query->result_array();
	$result_arr = $this->generate_option_arr($option_arr);
	$final_arr  = array();
	$result_arr_copy  = array();
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	foreach($result as $res){
	 
	 $result_arr[$res['answer']]=$res['anwser_count'];
	 
	}

	$map_data = $this->get_data('survey_type_question_map','enable_sorting',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"q_id"=>$question_id));
	if($map_data[0]['enable_sorting']=='Y')
	arsort($result_arr);
	else{
	 
	 $result_arr_copy = $result_arr;
	 arsort($result_arr_copy);
	 $highest_key = key($result_arr_copy);
		
	}
	if($output_type=='graph'){
		
	 foreach($option_arr as $opt){
	   if(isset($result_arr[$opt->text])){	
	      if(isset($opt->color))	  
		    $final_arr[] = array("label"=>$opt->text,"value"=>$result_arr[$opt->text],"color"=>$opt->color);
		  else
		    $final_arr[] = array("label"=>$opt->text,"value"=>$result_arr[$opt->text]);	
	   
	   }
	   else
	      $final_arr[] = array("label"=>$opt->text,"value"=>0); 
	  	   
	 }
	 if($return_arr)
	   return $result_arr;
	 
	 
	 if($graph_id==1){
		  $output = '<script>FusionCharts.ready(function () {
		   var ageGroupChart = new FusionCharts({
			type: "pie2d",
			renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
			width: "400",
			height: "390",
			dataFormat: "json",
			dataSource: {
				 "chart": {
					"caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"showPercentValues": "1",
					"showLabels" :"0",
					"showPercentInTooltip": "1",
					"paletteColors": "#00AF50,#FFC000,#6F2F9F,#8e0000,#C82020,#BF0EEF,#0E45EF,#EF0EE1,#EF0E3A",
					"decimals": "2",
					"showLegend": "1",
					"theme": "fint"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	  });</script>';
	  
	 
	  
	  					   
	}
	else if($graph_id==2){
	 
		 $output ='<script>FusionCharts.ready(function () {
		var revenueChart = new FusionCharts({
			type: "doughnut2d",
			renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
			width: "400",
			height: "390",
			dataFormat: "json",
			dataSource: {
				"chart": {
				   "caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"bgColor": "#ffffff",
					"showBorder": "0",
					"use3DLighting": "0",
					"showShadow": "0",
					"enableSmartLabels": "1",
					"startingAngle": "310",
					"paletteColors": "#00AF50,#C82020,#FFC000,#6F2F9F,#8e0000,#BF0EEF,#0E45EF,#EF0EE1,#EF0E3A",
					"showLabels": "0",
					"showPercentValues": "1",
					"showLegend": "1",
					"legendShadow": "0",
					"legendBorderAlpha": "0",
					"defaultCenterLabel": "",
					"centerLabel": "",
					"centerLabelBold": "1",
					"showTooltip": "1",
					"decimals": "2",
					"captionFontSize": "14",
					"subcaptionFontSize": "14",
					"subcaptionFontBold": "0"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	});</script>';
		 	 
	}
  
  }
  else if($output_type=='table'){
    
	$map_data = $this->get_data('survey_type_question_map','map_id,enable_sorting',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"q_id"=>$question_id));
	
    $prev_data = $this->get_data('survey_previous_backup','answer',array("map_id"=>$map_data[0]['map_id'],"value_type"=>"percentage","type"=>$comparison_type));
   
    $survey_data = $this->get_data('survey_master','start_date',array("survey_id"=>$survey_id));
	
	$survey_year = date('Y',strtotime($survey_data[0]['start_date'])); 
	
	$prev_year = $survey_year-1;
	
	if($prev_data){
	     $prev_data_arr = json_decode($prev_data[0]['answer']);
		 if(!$prev_data_arr)
		    return 'Wrong Format';     
	}
	   	    
	 if(isset($prev_data_arr)){  
	   
   $output = '<table class="table table-striped table-bordered table-hover">
                                  <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										<th>'.$prev_year.'</th>
										<th>'.$survey_year.'</th>
                                    </tr>
                                </tbody>
                                <tbody>';
  
 
	
    foreach($result_arr as $index=>$value){
		
		$current_ratio =round(($value/$question_response)*100,2);
		if(isset($prev_data_arr[0]->$index)){
			if($current_ratio > $prev_data_arr[0]->$index)
					$arrow_class = 'fa fa-arrow-up green';
			else
				   $arrow_class = 'fa fa-arrow-down red'; 
		
		   $prev_val =	$prev_data_arr[0]->$index.'%';	   
				   
		}
		else{
		  $prev_val ='-';	
		  $arrow_class ='';
		}
		 
		$output .='<tr>
		                       <td>'.$index.'</td>
							    <td align="right">'.number_format(intval($value)).'</td>
							   <td align="right">'.$prev_val.'</td>
							   <td align="right">'.$current_ratio.'% <i class="'.$arrow_class.'"></td>
							</tr>';   
		  
		  
	  }
   
   
   $output  .='</tbody></table>';
    
  
  
  } 
	 
    else{
  
   $output = '<table class="table table-striped table-bordered table-hover">
                                <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										<th>Percentage</th>
                                    </tr>
                                </tbody>
                                <tbody>';
								
    $i=1;					
   foreach($result_arr as $key=>$value){
	   
	 if($i==1 and $map_data[0]['enable_sorting']=='Y'){
	    $key_text = '<strong>'.$key.'</strong>';
		$value_text =  '<strong>'.number_format(intval($value)).'</strong>';
		$percent = '<strong>'.round((($value/$question_response)*100),2).'%</strong>';
	 }
	 else if($map_data[0]['enable_sorting']=='N' and $key==$highest_key){
		
		$key_text = '<strong>'.$key.'</strong>';
		$value_text =  '<strong>'.number_format(intval($value)).'</strong>';
		$percent = '<strong>'.round((($value/$question_response)*100),2).'%</strong>';
		 
	 }
	 else{
	  
	    $key_text = $key;
		$value_text =  number_format(intval($value));
		$percent = round((($value/$question_response)*100),2).'%';	 	 
	 }
	 $output  .='<tr>
	              <td>'.$key_text.'</td>
				  <td align="right">'.$value_text.'</td>
				  <td align="right">'.$percent.'</strong></td>
				</tr>'; 
    $i++;				
   } 
   $output  .='</tbody></table>';
    
  }
  
  }
 
   return $output;
 
 }
 
 public function getMulticheckboxgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){
	
	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join='';
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"'; 
	 }     	 
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
	 						     
	 $result=$query->result_array();
	 $output_arr = array();
	 $final_arr = array();
	 $result_arr_copy = array();
	 $output='';
	 $question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	 
	 foreach($result as $result_arr){	  
	     $answer_arr = json_decode($result_arr['answer']);
		  if(!$answer_arr)
	        return 'Unknown Json format';	  
	     foreach($answer_arr as $ans_arr ){
		   if(isset($output_arr[$ans_arr->id]))
		     $output_arr[$ans_arr->id] = $output_arr[$ans_arr->id]+1;
		   else
		     $output_arr[$ans_arr->id]=1;		
	     }	  	 
	   } 
	   
	 
	 if($output_type=='graph'){	  
	   
	  $table_arr =array();
	  foreach($option_arr as $opt_arr){
		 if(isset($output_arr[$opt_arr->id]))
		   $table_arr[$opt_arr->text] = $output_arr[$opt_arr->id];
	     else
		   $table_arr[$opt_arr->text] =0; 
		  
	   }
	   arsort($table_arr);
	  
	   foreach($table_arr as $index=>$value){
	    $percentage_val= ($value/$question_response)*100;
		if($value!=0)		
	    $final_arr[] = array("label"=>$index,"value"=>round($percentage_val,2));
	   
	   }
	  
	   if($enable_comparison==1)
	     
		 return $table_arr;
		 
	   if($comparison_type!='default'){
		  $paletteColors = $this->get_comparison_type_config($comparison_type,$survey_id,$survey_type_id,'color');
		  $paletteColors = ($paletteColors) ? $paletteColors : "#0075c2" ;
		}		
		else
		  $paletteColors ='#0075c2';	 
	   
	   if($graph_id==3){
	 
			 $output = '<script>FusionCharts.ready(function () {
			var revenueChart = new FusionCharts({
				type: "column2d",
				renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
				width: "650",
				height: "350",
				dataFormat: "json",
				dataSource: {
					"chart": {
						"caption": "",
						"subCaption": "",
						"xAxisName": "",
						"yAxisName": "",
						"numberPrefix": "",
						"numberSuffix": "%",
						"paletteColors": "'.$paletteColors.'",
						"bgColor": "#ffffff",
						"borderAlpha": "0",
						"canvasBorderAlpha": "0",
						"usePlotGradientColor": "0",
						"plotBorderAlpha": "10",
						"placevaluesInside": "1",
						"rotatevalues": "1",
						"valueFontColor": "#000",                
						"showXAxisLine": "1",
						"xAxisLineColor": "#999999",
						"divlineColor": "#999999",               
						"divLineIsDashed": "1",
						"showAlternateHGridColor": "0",
						"subcaptionFontBold": "0",
						"subcaptionFontSize": "14"
					},            
					"data": '.json_encode($final_arr).'
					
				}
			}).render();
		 });</script>'; 
	
	   }
	 
	 else if($graph_id==4){ 
	   
	   $output ='<script>FusionCharts.ready(function () {
        var topStores = new FusionCharts({
        type: "bar2d",
        renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "600",
        height: "400",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "yAxisName": "",
                "numberPrefix": "",
				"numberSuffix": "%",
                "paletteColors": "'.$paletteColors.'",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placeValuesInside": "1",
                "valueFontColor": "#000",
                "showAxisLines": "1",
                "axisLineAlpha": "25",
                "divLineAlpha": "10",
                "alignCaptionWithCanvas": "0",
                "showAlternateVGridColor": "0",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5"
            },
            
            "data": '.json_encode($final_arr).'
        }
    })
    .render();
  });</script>';
	   
	 }
	   
	 }
	 
	 if($output_type=='table'){
	    $table_arr =array();
		foreach($option_arr as $opt_arr){
		 if(isset($output_arr[$opt_arr->id]))
		   $table_arr[$opt_arr->text] = $output_arr[$opt_arr->id];
	     else
		   $table_arr[$opt_arr->text] =0; 
		  
	   }
	    
		$map_data = $this->get_data('survey_type_question_map','map_id,prev_data_comparison_factor,enable_sorting',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"q_id"=>$question_id));
	
		 $prev_data = $this->get_data('survey_previous_backup','answer',array("map_id"=>$map_data[0]['map_id'],"value_type"=>$map_data[0]['prev_data_comparison_factor'],"type"=>$comparison_type,"status"=>1));
	if($prev_data){
	     $prev_data_arr = json_decode($prev_data[0]['answer']);
		 if(!$prev_data_arr)
		    return 'Wrong Format';     
	}
	  if($map_data[0]['enable_sorting']=='Y')
	   arsort($table_arr); 	
	  else{
		$result_arr_copy =  $table_arr;
		arsort($result_arr_copy);
		$highest_key = key($result_arr_copy); 	 
	  }
	 if(isset($prev_data_arr)){  
	   
		$survey_data = $this->get_data('survey_master','start_date',array("survey_id"=>$survey_id));
		
		$survey_year = date('Y',strtotime($survey_data[0]['start_date'])); 
		
		$prev_year = $survey_year-1;
	   
   $output = '<table class="table table-striped table-bordered table-hover">
                               <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										<th>'.$prev_year.'</th>
										<th>'.$survey_year.'</th>
                                    </tr>
                                </tbody>
                                <tbody>';
  
 
	
    foreach($table_arr as $index=>$value){
		
		$current_ratio =round(($value/$question_response)*100,2);
		if(isset($prev_data_arr[0]->$index)){			
			if($current_ratio > $prev_data_arr[0]->$index)
					$arrow_class = 'fa fa-arrow-up green';
			else
				   $arrow_class = 'fa fa-arrow-down red'; 
		    $prev_data_val = $prev_data_arr[0]->$index.'%';		   
		}
		
		else{
		    $arrow_class ='';
			$prev_data_val ='-';
			   
		}
		if($value!=0){ 
		$output .='<tr>
		                       <td>'.$index.'</td>
							    <td align="right">'.number_format(intval($value)).'</td>
							   <td align="right">'.$prev_data_val.'</td>
							   <td align="right">'.$current_ratio.'% <i class="'.$arrow_class.'"></td>
							</tr>';  
		}
		  
		  
	  }
  
   $output  .='</tbody></table>';
    
  
  
  } 
		
   else{
		
	    $output = '<table class="table table-striped table-bordered table-hover">
                               <tbody class="thead">
                                    <tr>
                                      <th>Response</th>
									   <th>Count</th>
									   <th>Percentage</th></tr></tbody><tbody>';
		$i=1;							   
	    foreach($table_arr as $index=>$value){								   
	     if($i==1 and $map_data[0]['enable_sorting']=='Y'){
		   
		   $key_text = '<strong>'.$index.'</strong>';
		   $value_text = '<strong>'.number_format(intval($value)).'</strong>';
		   $percent = '<strong>'.round((($value/$question_response)*100),2).'%</strong>';
		   
		 }
		 else if($map_data[0]['enable_sorting']=='N' and $highest_key==$index){
		   
		   $key_text = '<strong>'.$index.'</strong>';
		   $value_text = '<strong>'.number_format(intval($value)).'</strong>';
		   $percent = '<strong>'.round((($value/$question_response)*100),2).'%</strong>';
		  	 
		 }
		 else{
		  
		   $key_text = $index;
		   $value_text = number_format(intval($value));
		   $percent = round((($value/$question_response)*100),2).'%';	 
			 			  
		 }
         if($value!=0){
			 $output .='<tr>
						   <td>'.$key_text.'</td>
						   <td align="right">'.$value_text.'</td>
						   <td align="right">'.$percent.'</td>
						 </tr>';
			  
			 $i++; 
		 }
		}
		
	  $output .='</tbody></table>';
	 
	 }
	 }
	 
   return $output;	
	 

 }
 
 public function getMapgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){
   	 
	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query= ''; 
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }       	
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." ");   
	 $result=$query->result_array();
	 $output_arr = array();
	 $final_arr = array();
	 $option_count = array();
	 $return_sorted_arr = array();
	 $output='';
	 $question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	 
	  foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	  
	  foreach($answer_arr as $ans_arr ){
	    $option_id =  $ans_arr->text;
		$option_rank = $ans_arr->rank;
		if(isset($output_arr[$option_id]) and $output_arr[$option_id]>0 ){
		  $output_arr[$option_id] = $output_arr[$option_id]+$option_rank;
		  $option_count[$option_id]	= $option_count[$option_id]+1;
		}
		else{
		  $output_arr[$option_id]=$ans_arr->rank;
		  $option_count[$option_id]	= 1;
		}
	  }	  	 
	 }
     
	 arsort($output_arr);
	 $conv_final =array();
	 $final_arr = array_slice($output_arr, 0, 10);
	 $conv_final =array();
	 $i=1;
	 foreach($final_arr as $index=>$value){
	  
	 $conv_final[$index] = $i;
	 
	 $i++;
	   
	 }
	 
	
    if($output_type=='graph'){
		
		  $output = '
                <div id="visitors-map_'.str_replace(' ', '',$comparison_type).'" class="bg-black" style="height: 560px;"></div>
                <div class="map-float-table width-sm hidden-xs p-15">
                    <div data-scrollbar="true" class="height-md">
                        <table class="table table-inverse">
                            <tbody class="thead">
                                <tr>
                                    <th>Country</th>
                                    <th>Rank</th>
                                </tr>
                            </tbody>
                            <tbody>';
				$rank =1;			
				foreach($conv_final as  $key=>$value){ 
				 if($rank==1)
				   $arrow_class = 'fa fa-arrow-up';
				 else
				   $arrow_class = 'fa fa-arrow-down';   			
                 $output     .= '<tr>
                                    <td>'.$key.'</td>
                                    <td><span class="text-success">'.$rank.'</span></td>
                                </tr>';
				 $rank = $rank+1;				
				}
              $output .= '</tbody>
                        </table>
                    </div>
                </div>
            ';
			 $i=0;
			 $country_arr = array();
			 $colors_arr = array("#FF9C33","#FF9C33","#BF0EEF","#33F9FF","#33B5FF","#33B5FF","#FF33CE","#FF333F","#D5696F","#1D8067","#FF333F");
			 foreach($conv_final as $key=>$value){
				 $i++;
				
				 $latitude = $this->get_entity_field('countries_master',$key,'latitude','country');
				 $longitude = $this->get_entity_field('countries_master',$key,'longitude','country');
				 $country_code = $this->get_entity_field('countries_master',$key,'country_code','country');
				// $final_arr[] = array("latLng"=>array($latitude,$longitude),"name"=>$key); 
				$final_arr[$country_code] = $colors_arr[$i];
		    
			 }
			 $final = (object)  array( 'regions' => array((object) array( 'values' => (object) $final_arr ) ) );
			 			
			$output .='<script>
var handleVisitorsVectorMap=function() {
    if($("#visitors-map_'.str_replace(' ', '',$comparison_type).'").length!==0) {
        map=new jvm.WorldMap( {
            map:"world_merc_en", scaleColors:["#e74c3c", "#0071a4"], container:$("#visitors-map_'.str_replace(' ', '',$comparison_type).'"), normalizeFunction:"linear", hoverOpacity:.5, hoverColor:false, markerStyle: {
                initial: {
                    fill: "#4cabc7", stroke: "transparent", r: 3
                }
            }
            , regions:[ {
                attribute: "fill"
            }
            ], regionStyle: {
                initial: {
                    fill: "rgb(97,109,125)", "fill-opacity": 1, stroke: "none", "stroke-width": .4, "stroke-opacity": 1
                }
                , hover: {
                    "fill-opacity": .8
                }
                , selected: {
                    fill: "yellow"
                }
                , selectedHover: {}
            }
            , series: '.json_encode($final).'
            , focusOn: {
                x: .5, y: .5, scale: 3
            }
            , backgroundColor:"#2d353c"
        }
        )
    }
}

;
var MapVector=function() {
    "use strict";
    return {
        init:function() {
            handleVisitorsVectorMap()
        }
    }
}

()
       $(document).ready(function() {
		  
		  MapVector.init(); 
		   
	   });
			  </script>'; 
		
		
		}
  
  else if($output_type=='table'){
	     
		 $output='<table class="table table-striped table-bordered table-hover"><tbody class="thead">
		          <tr><th style="width:20%">Rank</th><th style="width:80%">Country</th></tr></tbody><tbody>';
		 
		 foreach($conv_final as $key=>$value){
			
			$output .='<tr>
			               <td>'.$value.'</td>
						   <td>'.$key.'</td>
					</tr>';	    
			 
			 
		 }
	    
		$output .='</tbody></table>';
		
	  }

  
  return $output;	 
 	 
 }
 
 public function getRankingWeightedgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){
     
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query= ''; 
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"'; 
	   
	 }       	
	 $option_conv_arr = $this->convert_obj_arr($option_arr);  	 
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." ");   
	 $result=$query->result_array();
	 $output_arr = array();
	 $final_arr = array();
	 $option_count = array();
	 $return_ar = array();
	 $return_sorted_arr = array();
	 $output='';
	 $question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	 
	  foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	  
	  foreach($answer_arr as $ans_arr ){
	    $option_id =  $ans_arr->id;
		$option_rank = $ans_arr->rank;
		$option_text = $ans_arr->text;
		if(isset($output_arr[$option_id]) and $output_arr[$option_id]>0 ){
		  $output_arr[$option_id] = $output_arr[$option_id]+$option_rank;
		  $return_ar[$option_text]=$return_ar[$option_text]+$option_rank;
		  $option_count[$option_id]	= $option_count[$option_id]+1;
		}
		else{
		  $output_arr[$option_id]=$ans_arr->rank;
		  $return_ar[$option_text]=$ans_arr->rank;
		  $option_count[$option_id]	= 1;
		}
	  }	  	 
	 }
     
	 arsort($output_arr);
	
	 foreach($return_ar as $index=>$value){
		  $return_sorted_arr[$index] = round($value/$question_response,2);		 
	 }
	 arsort($return_sorted_arr);
	 
    if($output_type=='graph'){
			
	 
	 foreach($option_arr as $opt_arr){
		if(isset($output_arr[$opt_arr->id]))
		  $final_arr[] = array("label"=>$opt_arr->text,"value"=>round($output_arr[$opt_arr->id]/$question_response,1));
	   else
	      $final_arr[] = array("label"=>$opt_arr->text,"value"=>0);  		 
		  
	 }
	 
	 foreach ($final_arr as $key => $row) {
           $volume[$key]  = $row['label'];
           $edition[$key] = $row['value'];
        }
		
		array_multisort($edition, SORT_DESC, $volume, SORT_DESC, $final_arr);
	 
	 if($enable_comparison==1)
	     
		 return $return_sorted_arr;
		 
	 if($comparison_type!='default'){
		  $paletteColors = $this->get_comparison_type_config($comparison_type,$survey_id,$survey_type_id,'color');
		  $paletteColors = ($paletteColors) ? $paletteColors : "#0075c2" ;
		}		
		else
		  $paletteColors ='#0075c2';	 
	 
	if($graph_id==3){
	 
	 $output = '<script>FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: "column2d",
        renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "550",
        height: "350",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "xAxisName": "",
                "yAxisName": "",
                "numberPrefix": "",
                "paletteColors": "'.$paletteColors.'",
                "bgColor": "#ffffff",
                "borderAlpha": "0",
                "canvasBorderAlpha": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placevaluesInside": "1",
                "rotatevalues": "1",
                "valueFontColor": "#000",                
                "showXAxisLine": "1",
                "xAxisLineColor": "#999999",
                "divlineColor": "#999999",               
                "divLineIsDashed": "1",
                "showAlternateHGridColor": "0",
                "subcaptionFontBold": "0",
                "subcaptionFontSize": "14"
            },            
            "data": '.json_encode($final_arr).'
            
        }
    }).render();
});</script>'; 
	
	}
	
	else if($graph_id==4){ 
	   
	   $output ='<script>FusionCharts.ready(function () {
        var topStores = new FusionCharts({
        type: "bar2d",
        renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "400",
        height: "300",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "yAxisName": "",
                "numberPrefix": "",
                "paletteColors": "'.$paletteColors.'",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placeValuesInside": "1",
                "valueFontColor": "#000",
                "showAxisLines": "1",
                "axisLineAlpha": "25",
                "divLineAlpha": "10",
                "alignCaptionWithCanvas": "0",
                "showAlternateVGridColor": "0",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5"
            },
            
            "data": '.json_encode($final_arr).'
        }
    })
    .render();
  });</script>';
	   
	 }
	
   }
  
  else if($output_type=='table'){
	
   $rank_arr =array();
   $text_arr = array();
   $rank_index_arr =array();
   foreach($option_arr as $opt_arr){   
	   for($i=$option_arr[0]->min;$i<=$option_arr[0]->max;$i++){
		 $rank_arr[$opt_arr->id][$i]=0;
		  
	   }
	 }
   foreach($option_arr as $option){
	 $text_arr[$option->id] = $option->text;
   }

   foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	 
	  foreach($answer_arr as $index){
		 
	    if(isset($rank_arr[$index->id][$index->rank])){
			$k = $rank_arr[$index->id][$index->rank] +1;
		}
		else
			$k = 1;
		$rank_arr[$index->id][$index->rank] = $k;
	  }
	  
	 }
  
  $rank_sorted_arr = array();
  foreach($output_arr as $index=>$value){
	
	$rank_sorted_arr[$index] = $rank_arr[$index];
	   
	  
  }
 
	 
  $output = '<div class="scroll_table"><table class="table table-striped table-bordered table-hover">
                                <tbody class="thead">
                                    <tr>
                                      <th>Response</th>';
  for($i=$option_arr[0]->min;$i<=$option_arr[0]->max;$i++){
	$output .='<th>'.$i.'</th>';  
  }
  $output .='<th>Rating Index/'.$option_arr[0]->max.'</th>';  									
                                       
  $output .=  '</tr></tbody>
                                <tbody>';
   $j=1;								
   foreach($rank_sorted_arr as $key_id=>$rank_r){
	krsort($rank_r);
	 if($j==1)
	   $text_val= '<strong>'.$text_arr[$key_id].'</strong>';
	 else
	   $text_val = $text_arr[$key_id];   
	 $output .='<tr>
	              <td>'.$text_val.'</td>';
	 foreach($rank_r as $key=>$value){
		
		/*if($j==1)
		   $response_percent = '<strong>'.round((($value/$question_response)*100)).'%</strong>';
		 else
		   $response_percent =  round((($value/$question_response)*100)).'%';*/
		 
		 if($j==1)
		   $response_percent = '<strong>'.round((($value/$option_count[$key_id])*100),2).'%</strong>';
		 else
		   $response_percent =  round((($value/$option_count[$key_id])*100),2).'%';
		 
		 
		 
		/* if($j==1)
		   $response_percent = '<strong>'.$value.'</strong>';
		 else
		   $response_percent =  $value;  */
		   
		$output .='<td align="right">'.$response_percent.'</td>';
		 
	 }
	 
	 if($j==1)
	   $rating_index = '<strong>'.round((($output_arr[$key_id]/$question_response)),2).'</strong>';
	 else
	   $rating_index =  round((($output_arr[$key_id]/$question_response)),2); 
	 
	 $output .='<td align="right">'.$rating_index.'</td>';
	 
	 $output .='</tr>';
	 
	 $j++;
   } 
   $output  .='</tbody></table></div>';

  }
  
  return $output;	 
 	 
 }
 
 public function getRatingWeightedgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 $where_comparison_query ='';
	 $comparison_left_join=''; 
	 if(!$option_arr)
	   return 'Unknown Json format';
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"'; 
	   
	 }      	 
	 $option_conv_arr = $this->convert_obj_arr($option_arr);  
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query."  ");   
	 $result=$query->result_array();
	 $output_arr = array();
	 $final_arr = array();
	 $option_count =array();
	 $return_ar = array();
	 $return_sorted_arr = array();
	 $output='';
	 $question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
    if($output_type=='graph'){
			 
	 foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	  
	  foreach($answer_arr as $ans_arr ){
	    $option_id =  $ans_arr->id;
		$option_rank = $ans_arr->rank;
		$option_text = $ans_arr->text;
		if(isset($output_arr[$option_id]) and $output_arr[$option_id]>0){
		  $output_arr[$option_id] = $output_arr[$option_id]+$option_rank;
		  $option_count[$option_id]	= $option_count[$option_id]+1;
		}
		else{
		  $output_arr[$option_id]=$ans_arr->rank;
		  $option_count[$option_id]	= 1;
		}
		
	  }	  	 
	 }
      
	 $table_arr =array();
	 foreach($option_arr as $opt_arr){
		  
		 if(isset($output_arr[$opt_arr->id]) )
		   $table_arr[$opt_arr->text] = $output_arr[$opt_arr->id];
	     else
		   $table_arr[$opt_arr->text] =0; 
		  
	  }
	   
	   
	 foreach($table_arr as $index=>$value){
	    
		$opt_id = $option_conv_arr[$index];
		
		if(isset($option_count[$opt_id]))
		 
		  $indexing_val = round($value/$option_count[$opt_id],2);
		
		else
		
		  $indexing_val = 0;   
		
	    $final_arr[] = array("label"=>$index,"value"=>$indexing_val);
		
		$return_sorted_arr[$index]  = $indexing_val;
	   
	  }
	  foreach ($final_arr as $key => $row) {
           $volume[$key]  = $row['label'];
           $edition[$key] = $row['value'];
      }
		
	  array_multisort($edition, SORT_DESC, $volume, SORT_DESC, $final_arr);
	    
	  arsort($return_sorted_arr);
		 
	  if($enable_comparison==1)
	     
		 return $return_sorted_arr;
	  
	   if($comparison_type!='default'){
		  $paletteColors = $this->get_comparison_type_config($comparison_type,$survey_id,$survey_type_id,'color');
		  $paletteColors = ($paletteColors) ? $paletteColors : "#0075c2" ;
		}		
		else
		  $paletteColors ='#0075c2';	
	 
	 if($graph_id==3){
	 
	 $output = '<script>FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: "column2d",
        renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "550",
        height: "350",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "xAxisName": "",
                "yAxisName": "",
                "numberPrefix": "",
                "paletteColors": "'.$paletteColors.'",
                "bgColor": "#ffffff",
                "borderAlpha": "0",
                "canvasBorderAlpha": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placevaluesInside": "1",
                "rotatevalues": "1",
                "valueFontColor": "#000",                
                "showXAxisLine": "1",
                "xAxisLineColor": "#999999",
                "divlineColor": "#999999",               
                "divLineIsDashed": "1",
                "showAlternateHGridColor": "0",
                "subcaptionFontBold": "0",
                "subcaptionFontSize": "14"
            },            
            "data": '.json_encode($final_arr).'
            
        }
    }).render();
});</script>'; 
	
	}
	
	else if($graph_id==4){ 
	   
	   $output ='<script>FusionCharts.ready(function () {
        var topStores = new FusionCharts({
        type: "bar2d",
        renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "550",
        height: "350",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "yAxisName": "",
                "numberPrefix": "",
                "paletteColors": "'.$paletteColors.'",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placeValuesInside": "1",
                "valueFontColor": "#000",
                "showAxisLines": "1",
                "axisLineAlpha": "25",
                "divLineAlpha": "10",
                "alignCaptionWithCanvas": "0",
                "showAlternateVGridColor": "0",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5"
            },
            
            "data": '.json_encode($final_arr).'
        }
    })
    .render();
  });</script>';
	   
	 }
	
   }
  
  else if($output_type=='table'){
   $rank_arr =array();
   $text_arr = array();
   
   
   foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	  
	  foreach($answer_arr as $ans_arr ){
	    $option_id =  $ans_arr->id;
		$option_rank = $ans_arr->rank;
		$option_text = $ans_arr->text;
		if(isset($output_arr[$option_id]) and $output_arr[$option_id]>0){
		  $output_arr[$option_id] = $output_arr[$option_id]+$option_rank;
		  $option_count[$option_id]	= $option_count[$option_id]+1;
		}
		else{
		  $output_arr[$option_id]=$ans_arr->rank;
		  $option_count[$option_id]	= 1;
		}
		
	  }	  	 
	 }
     
	 
	 
	  $table_arr =array();
	  foreach($option_arr as $opt_arr){
		  
		 if(isset($output_arr[$opt_arr->id]) )
		   $table_arr[$opt_arr->id] = $output_arr[$opt_arr->id];
	     else
		   $table_arr[$opt_arr->id] =0; 
		  
	   }
	   
	   
	   foreach($table_arr as $index=>$value){
	    
		
		if(isset($option_count[$index]))
		 
		  $indexing_val = round($value/$option_count[$index],2);
		
		else
		
		  $indexing_val = 0;   
		
		
		$return_sorted_arr[$index]  = $indexing_val;
	   
	   }
  
   arsort($return_sorted_arr);

   foreach($option_arr as $opt_arr){   
	   for($i=$option_arr[0]->min;$i<=$option_arr[0]->max;$i++){
		 $rank_arr[$opt_arr->id][$i]=0;
		  
	   }
	 }
   foreach($option_arr as $option){
	 $text_arr[$option->id] = $option->text;
   }

   foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	 
	  foreach($answer_arr as $index){
		 
	    if(isset($rank_arr[$index->id][$index->rank])){
			$k = $rank_arr[$index->id][$index->rank] +1;
		}
		else
			$k = 1;
		$rank_arr[$index->id][$index->rank] = $k;
	  }
	  
	 }
  
  $rank_sorted_arr = array();
  foreach($return_sorted_arr as $index=>$value){
	
	$rank_sorted_arr[$index] = $rank_arr[$index];
	   
	  
  }
  	
  $output = '<div class="scroll_table"><table class="table table-striped table-bordered table-hover">
                                <tbody class="thead">
                                    <tr>
                                      <th>Response</th>';
  for($i=$option_arr[0]->min;$i<=$option_arr[0]->max;$i++){
	$output .='<th>'.$i.'</th>';  
  }
  $output .='<th>Rating Index/'.$option_arr[0]->max.'</th>'; 									                                
  $output .=  '</tr></tbody>
                                <tbody>';
   foreach($rank_sorted_arr as $key1=>$rank_r){
	 krsort($rank_r);
	 $output .='<tr>
	              <td>'.$text_arr[$key1].'</td>';
	 foreach($rank_r as $key=>$value){
		
		$output .='<td align="right">'.round((($value/$option_count[$key1])*100),2).'%</td>';
		 
	 }
	 $output .='<td>'.$return_sorted_arr[$key1].'</td>';
	 $output .='</tr>';
	 
	 
   } 
   $output  .='</tbody></table></div>';

  }

  
  return $output;	 
 	 
 }
  
 public function getRadiobuttonindexgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$return_roi=false,$date='',$return_arr=0){
      
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $where_date_query = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }      
     if($date!='')
	    $where_date_query = 'AND qa.submitted_date="'.$date.'"'; 	
		
	 $query = $this->db->query("SELECT qa.answer,count(qa.answer) as anwser_count  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." ".$where_date_query."  GROUP BY qa.answer "); 			   
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$total_count = 0;
	$result_arr = $this->generate_option_arr($option_arr);
	$rank_list = $this->convert_obj_arr_rank_index($option_arr);
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type,$date);
	foreach($result as $res){
	 
	 $result_arr[$res['answer']]=$res['anwser_count'];
	 
	}
	
	if($return_arr)	{ 
	  arsort($result_arr);   
	  return $result_arr;
	  
	}
	  
	if($output_type=='graph'){
	 	
	 foreach($option_arr as $opt){
	   if(isset($result_arr[$opt->text])){		  
		  $final_arr[] = array("label"=>$opt->text,"value"=>$result_arr[$opt->text],"color"=>$opt->color);
	      $total_count = $total_count+ ($result_arr[$opt->text]*$opt->rank);
	   }
	   else
	      $final_arr[] = array("label"=>$opt->text,"value"=>0,"color"=>$opt->color); 
	   
	   	  
	  	   
	 }
	 

	 $roi_index = round($total_count/$question_response,2);
	
	 if($return_roi)
	   return $roi_index;
	
	 $min_rank = $this->get_rank($option_arr,'min');
	 $max_rank = $this->get_rank($option_arr,'max');
	 $color_range=$this->get_color_range($option_arr,$min_rank,$max_rank);
	 $output ='<div id="roi_index_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'" style="float:left;"></div>
	          <script>FusionCharts.ready(function () {
    var cSatScoreChart = new FusionCharts({
        type: "angulargauge",
        renderAt: "roi_index_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "300",
        height: "200",
        dataFormat: "json",
        dataSource: {
            "chart": {                                
                "caption": "Rating Index  - '.$roi_index.'",
                "subcaption": "",
                "plotToolText": "",
                "theme": "fint",                              
                "chartBottomMargin": "50",
				"lowerLimitDisplay": "'.$min_rank.'",
                "upperLimitDisplay": "'.$max_rank.'",
				"lowerLimit": "'.$min_rank.'",
                "upperLimit": "'.$max_rank.'",                
                "showValue": "1"
            },
            "colorRange": {
                "color": '.json_encode($color_range).'
            },
            "dials": {
                "dial": [{
                    "value": "'.$roi_index.'"
                }]
            }
                     
        }
    }).render();
});</script>';	
	  
	   
	 if($graph_id==1){
		  $output .= '<script>FusionCharts.ready(function () {
		   var ageGroupChart = new FusionCharts({
			type: "pie2d",
			renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
			width: "450",
			height: "450",
			dataFormat: "json",
			dataSource: {                     

				 "chart": {
					"caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"showPercentValues": "1",
					"showPercentInTooltip": "1",
					"showLabels": "0",
					"decimals": "1",
					"showLegend": "1",
					"theme": "fint"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	  });</script>';					   
	}
	else if($graph_id==2){
	 
		 $output .='<script>FusionCharts.ready(function () {
		var revenueChart = new FusionCharts({
			type: "doughnut2d",
			renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
			width: "450",
			height: "450",
			dataFormat: "json",
			dataSource: {
				"chart": {
				   "caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"paletteColors": "#00AF50,#1aaf5d,#f2c500,#f45b00,#8e0000",
					"bgColor": "#ffffff",
					"showBorder": "0",
					"use3DLighting": "0",
					"showShadow": "0",
					"enableSmartLabels": "1",
					"startingAngle": "310",
					"showLabels": "0",
					"showPercentValues": "1",
					"showLegend": "1",
					"legendShadow": "0",
					"legendBorderAlpha": "0",
					"defaultCenterLabel": "",
					"centerLabel": "",
					"centerLabelBold": "1",
					"showTooltip": "0",
					"decimals": "0",
					"captionFontSize": "14",
					"subcaptionFontSize": "14",
					"subcaptionFontBold": "0"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	});</script>';
		 	 
	}
    
	
  
  }
  else if($output_type=='table'){
   
   $map_data = $this->get_data('survey_type_question_map','map_id,enable_sorting',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"q_id"=>$question_id));
   $prev_data = $this->get_data('survey_previous_backup','answer',array("map_id"=>$map_data[0]['map_id'],"value_type"=>"percentage","type"=>$comparison_type));
	if($prev_data){
	     $prev_data_arr = json_decode($prev_data[0]['answer']);
		 if(!$prev_data_arr)
		    return 'Wrong Format';     
	}
	   	  
	if($map_data[0]['enable_sorting']=='Y')
	arsort($result_arr);
	else{
	 
	 $result_arr_copy = $result_arr;
	 arsort($result_arr_copy);
	 $highest_key = key($result_arr_copy);
		
	}
	 if(isset($prev_data_arr)){  
	   
	    $survey_data = $this->get_data('survey_master','start_date',array("survey_id"=>$survey_id));	
		$survey_year = date('Y',strtotime($survey_data[0]['start_date'])); 		
		$prev_year = $survey_year-1;
	   
       $output = '<table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
                                        <th style="width:35%">Response</th>
                                        <th style="width:30%">Count</th>
										<th style="width:20%">'.$prev_year.'</th>
										<th style="width:25%">'.$survey_year.'</th>
                                    </tr>
                                </tbody>
                                <tbody>';
  
 
	
    foreach($result_arr as $index=>$value){
		
		$index_rank =$rank_list[$index];
		$current_ratio =round(($value/$question_response)*100,2);
		$arrow_class='';
		if(isset($prev_data_arr[0]->$index)){
			if($index_rank==1 or $index_rank==2){
				
			  if($current_ratio > $prev_data_arr[0]->$index)
				$arrow_class = 'fa fa-arrow-up red';
			else if($current_ratio < $prev_data_arr[0]->$index)
			   $arrow_class = 'fa fa-arrow-down green';
			else
			   $arrow_class='';      	
				
			}
			else{
				if($current_ratio > $prev_data_arr[0]->$index)
					$arrow_class = 'fa fa-arrow-up green';
			    else if($current_ratio < $prev_data_arr[0]->$index)
				   $arrow_class = 'fa fa-arrow-down red';
				else
				  $arrow_class='';    
			   
			}
			
			$prev_ratio =$prev_data_arr[0]->$index.'%';
			
		
		}
		else{
		 
		 $prev_ratio ='-';
		 $arrow_class='';	
		
		}
		 
		$output .='<tr>
		                       <td>'.$index.'</td>
							    <td align="right">'.number_format(intval($value)).'</td>
							   <td align="right">'.$prev_ratio.'</td>
							   <td align="right">'.$current_ratio.'% <i class="'.$arrow_class.'"></td>
							</tr>';   
		  
		  
	  }
   
   
   $output  .='</tbody></table>';
    
  
  
  }
  else{
	  
	  $output = '<table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										<th>Percentage</th>
										
                                    </tr>
                                </tbody>
                                <tbody>';
	
     $i=1;					
   foreach($result_arr as $key=>$value){
	if($i==1 and $map_data[0]['enable_sorting']=='Y'){
	    $key_text = '<strong>'.$key.'</strong>';
		$value_text =  '<strong>'.number_format(intval($value)).'</strong>';
		$percent = '<strong>'.round((($value/$question_response)*100),2).'%</strong>';
	 }
	 else if($map_data[0]['enable_sorting']=='N' and $key==$highest_key){
		
		$key_text = '<strong>'.$key.'</strong>';
		$value_text =  '<strong>'.number_format(intval($value)).'</strong>';
		$percent = '<strong>'.round((($value/$question_response)*100),2).'%</strong>';
		 
	 }
	 else{
	  
	    $key_text = $key;
		$value_text =  number_format(intval($value));
		$percent = round((($value/$question_response)*100),2).'%';	 	 
	 }
	 $output  .='<tr>
	              <td>'.$key_text.'</td>
				  <td align="right">'.$value_text.'</td>
				  <td align="right">'.$percent.'</strong></td>
				</tr>'; 
    $i++;				
   } 
   
   
   
   $output  .='</tbody></table>';
    
  }	  
	  
  }
 
   return $output;
 
 } 
 
  public function getRadiobuttonGridgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){
     	 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }    
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
					       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$return_arr = array();
	$text_arr = $this->convert_obj_arr_index($option_arr);
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   if(isset($output_arr[$ans_arr->id][$ans_arr->value])){
				   $output_arr[$ans_arr->id][$ans_arr->value] = $output_arr[$ans_arr->id][$ans_arr->value]+1;
				   
			   }
			   else{
				 $output_arr[$ans_arr->id][$ans_arr->value] = 1;
			   
			   }
			   
			  
				 
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
	}
	 $option_val = $option_arr[0]->values;	
	 foreach($option_arr as $option){
	     
		 $total_sum = 0;
		 $roi_index=0;
		 $total_count=0;
		 foreach($option_val as $index=>$value){
		  if(isset($output_arr[$option->id][$index])){
		   if($value!=0){
			 $val= $output_arr[$option->id][$index]; 
		     $total_sum = $total_sum + ($val*$value);
			 $total_count = $total_count + $val;
		   }
		  }
		  else 
		   $val=0;  
		  	
		}
	   if($total_count>0)	
	    $roi_index = round($total_sum/$total_count,2);
	  
	   $return_arr[$option->text] =$roi_index; 
	   
	   }
	
	if($enable_comparison==1){
	
	  return  $return_arr;
	}
	if($output_type=='graph'){
		 
		   $final_arr  = array();
		   foreach($return_arr as $key=>$val){
			 
				 $final_arr[] = array("label"=>$key,"value"=>$val);
			
			   }
		foreach ($final_arr as $key => $row) {
           $volume[$key]  = $row['label'];
           $edition[$key] = $row['value'];
        }
		
		array_multisort($edition, SORT_DESC, $volume, SORT_DESC, $final_arr);
		
		
		
		if($comparison_type!='default'){
		  $paletteColors = $this->get_comparison_type_config($comparison_type,$survey_id,$survey_type_id,'color');
		  $paletteColors = ($paletteColors) ? $paletteColors : "#0075c2" ;
		}
		
		else
		  $paletteColors ='#0075c2';
		 
		 if($graph_id==3){
	 
			 $output = '<script>FusionCharts.ready(function () {
			var revenueChart = new FusionCharts({
				type: "column2d",
				renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
				width: "650",
				height: "350",
				dataFormat: "json",
				dataSource: {
					"chart": {
						"caption": "",
						"subCaption": "",
						"xAxisName": "",
						"yAxisName": "",
						"numberPrefix": "",
						"numberSuffix": "",
						"paletteColors": "'.$paletteColors.'",
						"bgColor": "#ffffff",
						"borderAlpha": "0",
						"canvasBorderAlpha": "0",
						"usePlotGradientColor": "0",
						"plotBorderAlpha": "10",
						"placevaluesInside": "1",
						"rotatevalues": "1",
						"valueFontColor": "#000",                
						"showXAxisLine": "1",
						"xAxisLineColor": "#999999",
						"divlineColor": "#999999",               
						"divLineIsDashed": "1",
						"showAlternateHGridColor": "0",
						"subcaptionFontBold": "0",
						"subcaptionFontSize": "14"
					},            
					"data": '.json_encode($final_arr).'
					
				}
			}).render();
		 });</script>'; 
	
	   }
	 
	 else if($graph_id==4){ 
	   
	   $output ='<script>FusionCharts.ready(function () {
        var topStores = new FusionCharts({
        type: "bar2d",
        renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "600",
        height: "400",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "yAxisName": "",
                "numberPrefix": "",
				"numberSuffix": "",
                "paletteColors": "'.$paletteColors.'",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placeValuesInside": "1",
                "valueFontColor": "#000",
                "showAxisLines": "1",
                "axisLineAlpha": "25",
                "divLineAlpha": "10",
                "alignCaptionWithCanvas": "0",
                "showAlternateVGridColor": "0",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5"
            },
            
            "data": '.json_encode($final_arr).'
        }
    })
    .render();
  });</script>';
	   
	 }
		 
	 }
	 

   else if($output_type=='table'){
	   
	   $sum_arr = array();
	   
	   
	   
	   
	 $option_val = $option_arr[0]->values;	
	 
	 foreach($output_arr as $index=>$out){
		  
		  $sum_arr[$index] =0;
		 
		  foreach($out as $key=>$value ){
			
			$sum_arr[$index] = $sum_arr[$index] + $value;
			  
		  }
		
		
	   }
	
	 foreach($option_arr as $option){
	     
		 $total_sum = 0;
		 $total_count=0;
		 $roi_index=0;
		 foreach($option_val as $index=>$value){
		  if(isset($output_arr[$option->id][$index])){
	       if($value!=0){
			$val= $output_arr[$option->id][$index]; 
		     $total_sum = $total_sum + ($val*$value);
			$total_count = $total_count + $val;
		   }
		  
		  }
		  
		  else 
		   $val=0;  
		  	
		}
		
	  if($total_count>0)	
	   $roi_index = round($total_sum/$total_count,2);
	  
	   $roi_arr[$option->id] =$roi_index; 
	 }
       arsort($roi_arr); 
	  
	   $max_rank = $this->get_max_rank($option_arr[0]->values);
	  $output .=' <div class="scroll_table"><table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
								<tr>
								<th>Response</th>';
		$option_val = $option_arr[0]->values;
		
		foreach($option_val as $index=>$val){
		  $output .='<th>'.$index.'</th>';
		  	
		}
		$output .='<th>Rating Index/'.$max_rank.'</th></tr></tbody><tbody>';
	  
	   foreach($roi_arr as $rating_index=>$roi_val){
	     
		 $output .='<tr>
		                <td>'.$text_arr[$rating_index].'</td>';
		 $total_sum = 0;
		 $roi_index=0;
		 foreach($option_val as $index=>$value){
		  if(isset($output_arr[$rating_index][$index])){
		   $val= $output_arr[$rating_index][$index];
		   $total_sum = $total_sum + ($val*$value);
		  }
		  else 
		   $val=0;
		   if(isset($sum_arr[$rating_index]))
		    $percent = round((($val/$sum_arr[$rating_index])*100),2).'%';
		   else
		     $percent 	='0%'; 
		  $output .='<td align="right">'.$percent.'</td>';
		  	
		}
	
	    
				   
		$output .= '<td align="right">'.$roi_val.'</td></tr>'; 
	   
	   }
	   $output .='</tbody></table></div>';
    
  }
 
   return $output;
 
 }
 
  
  public function getCheckboxGridgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	  
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }      
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
					       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
	     foreach($answer_arr as $ans_arr ){
			 foreach($ans_arr->values as $value){
		      if(isset($output_arr[$ans_arr->id][$value])){
		      $output_arr[$ans_arr->id][$value] = $output_arr[$ans_arr->id][$value]+1;    
			   
		     }
		   else
		     $output_arr[$ans_arr->id][$value] = 1;
		 }
	     }	  	 
	}
	
	if($output_type=='graph'){
		 
	    foreach($option_arr as $option){
		 
		   $final_arr  = array();
		
		   foreach($output_arr[$option->id] as $key=>$val){
		 
		     $final_arr[] = array("label"=>$key,"value"=>$val);
		
		   }
		 
		  if($graph_id==1){
			  
		   $output .= '<div class="multichart" id="multiradioChart_'.$question_id.$option->id.'"></div><script>FusionCharts.ready(function () {
		    var ageGroupChart = new FusionCharts({
			type: "pie2d",
			renderAt: "multiradioChart_'.$question_id.$option->id.'",
			width: "450",
			height: "300",
			dataFormat: "json",
			dataSource: {
				 "chart": {
					"caption": "'.$option->text.'",
					"subCaption": "",
					"numberPrefix": "",
					"showPercentValues": "1",
					"showPercentInTooltip": "1",
					"paletteColors": "#00AF50,#FFC000,#6F2F9F,#C82020,#8e0000",
					"decimals": "1",
					"theme": "fint"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	  });</script>';
	  
	 
	  					   
	}
	else if($graph_id==2){
	 
		 $output ='<script>FusionCharts.ready(function () {
		var revenueChart = new FusionCharts({
			type: "doughnut2d",
			renderAt: "chart-container_'.$survey_id.$survey_type_id.$question_id.'",
			width: "450",
			height: "450",
			dataFormat: "json",
			dataSource: {
				"chart": {
				   "caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"paletteColors": "#00AF50,#1aaf5d,#f2c500,#f45b00,#8e0000",
					"bgColor": "#ffffff",
					"showBorder": "0",
					"use3DLighting": "0",
					"showShadow": "0",
					"enableSmartLabels": "1",
					"startingAngle": "310",
					"showLabels": "1",
					"showPercentValues": "1",
					"showLegend": "1",
					"legendShadow": "0",
					"legendBorderAlpha": "0",
					"defaultCenterLabel": "",
					"centerLabel": "",
					"centerLabelBold": "1",
					"showTooltip": "0",
					"decimals": "0",
					"captionFontSize": "14",
					"subcaptionFontSize": "14",
					"subcaptionFontBold": "0"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	});</script>';
		 	 
	
		
		}
		 
	 }
	 
  
  }
   else if($output_type=='table'){
   
	  $output = '<table class="table table-striped table-bordered table-hover">
	              <tbody class="thead">
				      <tr>
					    <th></th>';
	  foreach($option_arr[0]->values as $opt_val){
		 $output .='<th>'.$opt_val.'</th>';  
	  }
	  $output .='</tr></tbody><tbody>';
	  foreach($option_arr as $opt){
		 
		 $output .='<tr><td>'.$opt->text.'</td>';
		
		 foreach($opt->values as $value){
			$output_data = $output_arr[$opt->id][$value];
			
		    $output .='<td>'.round((($output_data/$question_response)*100),2).'%</td>';  
		 }
		 $output .='</tr>';
	  }
	  
	  $output .='</tbody></table>'; 
   
  }

   return $output;
 
 } 
 
 
  public function getOpenendedRadiobuttonGridgraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }     
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
					       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	$opt_arr = $this->convert_obj_arr_index($option_arr);
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   if(isset($output_arr[$ans_arr->id][$ans_arr->value])){
				   $output_arr[$ans_arr->id][$ans_arr->value] = $output_arr[$ans_arr->id][$ans_arr->value]+1;
			   }
			   else
				 $output_arr[$ans_arr->id][$ans_arr->value] = 1;
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
	}
	
	
   if($output_type=='graph'){	
   
   
   }
  
   else if($output_type=='table'){
	 
	 $sum_arr = array();
	   
	   foreach($output_arr as $index=>$out){
		  
		  $sum_arr[$index] =0;
		 
		  foreach($out as $key=>$value ){
			
			$sum_arr[$index] = $sum_arr[$index] + $value;
			  
		  }
		
		
	   }
	 
	
	  
	 foreach($opt_arr as $index=>$value){
	  
	  if(isset($output_arr[$index])){
	  
	  arsort($output_arr[$index]);
	   
	  $output .= '<div><h4>'.$value.'</h4>
	               <table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										 <th>Percentage</th>
                                    </tr>
                                </tbody>
                                <tbody>';
		 foreach($output_arr[$index] as $text=>$value ){
		  
		   $output .='<tr>
		                 <td>'.$text.'</td>
						 <td>'.number_format(intval($value)).'</td>
						 <td>'.round((($value/$sum_arr[$index])*100),2).'%</td>
					  </tr>';	 	 
			 
		 }
		  $output .='</tbody></table></div>';
	  }
	
	
	     
	 
     }
	   
	   
   }
  	   
 
   return $output;
 
 }
 
 
 public function getOpenendedRadiobuttonGridTitlegraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }         
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
					       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id][$ans_arr->text]['count']= array();
			   if(isset($output_arr[$ans_arr->id][$ans_arr->text][$ans_arr->value])){
				   $output_arr[$ans_arr->id][$ans_arr->text][$ans_arr->value] = $output_arr[$ans_arr->id][$ans_arr->text][$ans_arr->value]+1;
			   }
			   else
				 $output_arr[$ans_arr->id][$ans_arr->text][$ans_arr->value] = 1;
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
	}
	
   if($output_type=='graph'){	
   
   
   }
  
   else if($output_type=='table'){

	 
	foreach($option_arr as $opt){
	  
	  $output .= '<div><h4>'.$opt->text.'</h4><div class="row">';
	    
		foreach($opt->value as $opt_val){
	   
	         $output .='<div class="col-md-6"><table class="table table-striped table-bordered table-hover">
                                <tbody class="thead">
                                    <tr>
                                        <th>'.$opt_val.'</th>
                                        <th>Count</th>
                                    </tr>
                                </tbody>
                                <tbody>';
		    arsort($output_arr[$opt->id][$opt_val]);						
		 foreach($output_arr[$opt->id][$opt_val] as $title_text=>$count){
		      
			   $output .='<tr>
		                 <td>'.$title_text.'</td>
						 <td align="right">'.number_format(intval($count)).'</td>
					  </tr>';	 
			 	 
			 
		 }
		 
		 $output .='</tbody></table></div>';
								
		}
	  
	  $output .='<div class="clearfix"></div></div></div>';	
		
	}
	  
	   
	   
   }
  	   
 
   return $output;
 
 }
 
 
 
 public function getOpenendedRankingWeightedGraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){
   	 
	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query= '';  
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }           	
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." ");   
	 $result=$query->result_array();
	 $output_arr = array();
	 $final_arr = array();
	 $option_count = array();
	 $return_sorted_arr = array();
	 $output='';
	 $question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	 
	  foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	  
	  foreach($answer_arr as $ans_arr ){
	    $option_id =  $ans_arr->text;
		$option_rank = $ans_arr->rank;
		if(isset($output_arr[$option_id]) and $output_arr[$option_id]>0 ){
		  $output_arr[$option_id] = $output_arr[$option_id]+$option_rank;
		  $option_count[$option_id]	= $option_count[$option_id]+1;
		}
		else{
		  $output_arr[$option_id]=$ans_arr->rank;
		  $option_count[$option_id]	= 1;
		}
	  }	  	 
	 }
     
	 arsort($output_arr);
	 
	
	 
    if($output_type=='graph'){
			
	
	 
	 foreach($output_arr as $text=>$value){
		
		$final_arr[] = array("label"=>$text,"value"=>round($value/$question_response,1));
		$return_sorted_arr[$text] =  round($value/$question_response,2);
	 }
	 
	 
	 
	 foreach ($final_arr as $key => $row) {
           $volume[$key]  = $row['label'];
           $edition[$key] = $row['value'];
        }
		
		array_multisort($edition, SORT_DESC, $volume, SORT_DESC, $final_arr);
	 
	 if($enable_comparison==1){
	     arsort($return_sorted_arr);
		 return $return_sorted_arr;
	 
	 }
	
	 if($comparison_type!='default'){
		  $paletteColors = $this->get_comparison_type_config($comparison_type,$survey_id,$survey_type_id,'color');
		  $paletteColors = ($paletteColors) ? $paletteColors : "#0075c2" ;
	 }
		
	else
		$paletteColors ='#0075c2'; 
	 
	if($graph_id==3){
	 
	 $output = '<script>FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: "column2d",
        renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "550",
        height: "350",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "xAxisName": "",
                "yAxisName": "",
                "numberPrefix": "",
                "paletteColors": "'.$paletteColors.'",
                "bgColor": "#ffffff",
                "borderAlpha": "0",
                "canvasBorderAlpha": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placevaluesInside": "1",
                "rotatevalues": "1",
                "valueFontColor": "#000",                
                "showXAxisLine": "1",
                "xAxisLineColor": "#999999",
                "divlineColor": "#999999",               
                "divLineIsDashed": "1",
                "showAlternateHGridColor": "0",
                "subcaptionFontBold": "0",
                "subcaptionFontSize": "14"
            },            
            "data": '.json_encode($final_arr).'
            
        }
    }).render();
});</script>'; 
	
	}
	
	else if($graph_id==4){ 
	   
	   $output ='<script>FusionCharts.ready(function () {
        var topStores = new FusionCharts({
        type: "bar2d",
        renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
        width: "400",
        height: "300",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "yAxisName": "",
                "numberPrefix": "",
                "paletteColors": "'.$paletteColors.'",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placeValuesInside": "1",
                "valueFontColor": "#000",
                "showAxisLines": "1",
                "axisLineAlpha": "25",
                "divLineAlpha": "10",
                "alignCaptionWithCanvas": "0",
                "showAlternateVGridColor": "0",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5"
            },
            
            "data": '.json_encode($final_arr).'
        }
    })
    .render();
  });</script>';
	   
	 }
	
   }
  
  else if($output_type=='table'){
	
	$rank_arr = array(); 
	foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	 
	  foreach($answer_arr as $index){
		 
	    if(isset($rank_arr[$index->text][$index->rank])){
			$k = $rank_arr[$index->text][$index->rank] +1;
		}
		else
			$k = 1;
		$rank_arr[$index->text][$index->rank] = $k;
	  }
	  
	 }
    
	//
	
  foreach($result as $result_arr){	  
	  $answer_arr = json_decode($result_arr['answer']);	 
      foreach($answer_arr as $index){
	    for($i=$option_arr[0]->min;$i<=$option_arr[0]->max;$i++){
		
		if(!isset($rank_arr[$index->text][$i])){
			//echo $index->text.$i."value".$rank_arr[$index->text][$i];
		   $rank_arr[$index->text][$i]=0;
		   
		}
			
		 
	 }
	  
	  
  }
  }
  
 // exit;
   $rank_sorted_arr = array();
  foreach($output_arr as $index=>$value){
	
	$rank_sorted_arr[$index] = $rank_arr[$index];
	   
	  
  }
 
  $rank_val = array();
  $max_rank = $option_arr[0]->max;
  for($i=$option_arr[0]->min;$i<=$max_rank;$i++){
    $rank_val[$i]=$max_rank;	  
	$max_rank--;  
  }
   	
  $output = '<table class="table table-striped table-bordered table-hover">
                                <tbody class="thead">
                                    <tr>
                                      <th>Response</th>';
  for($i=$option_arr[0]->min;$i<=$option_arr[0]->max;$i++){
	$output .='<th>'.$i.'</th>';  
  }
  $output .='<th>Rating/'.$option_arr[0]->max.'</th>';  									
                                       
  $output .=  '</tr></tbody>
                                <tbody>';
   foreach($rank_sorted_arr as $key_id=>$rank_r){
	 krsort($rank_r);
	 $output .='<tr>
	              <td>'.$key_id.'</td>';
	 foreach($rank_r as $key=>$value){
		//$output .='<td align="right">'.round((($value/$question_response)*100),2).'%</td>';
		//$output .='<td align="right">'.round((($value/$question_response)*100),2).'%</td>'; 
		//$output .='<td align="right">'.$value.'</td>'; 
		$output .='<td align="right">'.round((($value/$option_count[$key_id])*100),2).'%</td>'; 
	 }
	 
	 $output .='<td align="right">'.round((($output_arr[$key_id]/$question_response)),2).'</td>';
	 
	 $output .='</tr>';
	 
	 
   } 
   $output  .='</tbody></table>';
	  
	  
	  }

  
  return $output;	 
 	 
 }
 
 public function getOpenendedRadiobuttongraph($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){

	 $where_comparison_query='';
	 $comparison_left_join='';
	 $result_arr =array(); 
	 $output='';
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }   

	 $query = $this->db->query("SELECT qa.answer,count(qa.answer) as anwser_count  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." GROUP BY qa.answer ");   
	$result=$query->result_array();
	$final_arr  = array();
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	
	foreach($result as $res){
	 
	 $result_arr[$res['answer']]=$res['anwser_count'];
	 
	}
	
	if($enable_comparison){
	 arsort($result_arr);
	 return $result_arr;
	}
	
	$map_data = $this->get_data('survey_type_question_map','enable_sorting',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"q_id"=>$question_id));
	if($map_data[0]['enable_sorting']=='Y')
	arsort($result_arr);
	
	if($output_type=='graph'){
	 
	 if($result_arr){	
		 foreach($result_arr as $text=>$value){  
			  $final_arr[] = array("label"=>$text,"value"=>$value);  
			   
		 }
	 }
	 if($graph_id==1){
		  $output = '<script>FusionCharts.ready(function () {
		   var ageGroupChart = new FusionCharts({
			type: "pie2d",
			renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
			width: "400",
			height: "390",
			dataFormat: "json",
			dataSource: {
				 "chart": {
					"caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"showPercentValues": "1",
					"showLabels" :"0",
					"showPercentInTooltip": "1",
					"paletteColors": "#00AF50,#FFC000,#6F2F9F,#C82020,#8e0000,#BF0EEF,#0E45EF,#EF0EE1,#EF0E3A",
					"decimals": "2",
					"showLegend": "1",
					"theme": "fint"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	  });</script>';
	  
	 
	  
	  					   
	}
	else if($graph_id==2){
	 
		 $output ='<script>FusionCharts.ready(function () {
		var revenueChart = new FusionCharts({
			type: "doughnut2d",
			renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
			width: "400",
			height: "390",
			dataFormat: "json",
			dataSource: {
				"chart": {
				   "caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"bgColor": "#ffffff",
					"showBorder": "0",
					"use3DLighting": "0",
					"showShadow": "0",
					"enableSmartLabels": "1",
					"startingAngle": "310",
					"paletteColors": "#00AF50,#C82020,#FFC000,#6F2F9F,#8e0000,#BF0EEF,#0E45EF,#EF0EE1,#EF0E3A",
					"showLabels": "0",
					"showPercentValues": "1",
					"showLegend": "1",
					"legendShadow": "0",
					"legendBorderAlpha": "0",
					"defaultCenterLabel": "",
					"centerLabel": "",
					"centerLabelBold": "1",
					"showTooltip": "1",
					"decimals": "2",
					"captionFontSize": "14",
					"subcaptionFontSize": "14",
					"subcaptionFontBold": "0"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	});</script>';
		 	 
	}
  
  }
 
  else if($output_type=='table'){
   
   
    $map_data = $this->get_data('survey_type_question_map','map_id',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"q_id"=>$question_id));
   
    $prev_data = $this->get_data('survey_previous_backup','answer',array("map_id"=>$map_data[0]['map_id'],"value_type"=>"percentage","type"=>$comparison_type));
   
    $survey_data = $this->get_data('survey_master','start_date',array("survey_id"=>$survey_id));
	
	$survey_year = date('Y',strtotime($survey_data[0]['start_date'])); 
	
	$prev_year = $survey_year-1;
	
	if($prev_data){
	     $prev_data_arr = json_decode($prev_data[0]['answer']);
		 if(!$prev_data_arr)
		    return 'Wrong Format';     
	}
	   	    
	 if(isset($prev_data_arr)){  
	   
   $output = '<table class="table table-striped table-bordered table-hover">
                                <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										<th>'.$prev_year.'</th>
										<th>'.$survey_year.'</th>
                                    </tr>
                                </tbody>
                                <tbody>';
  
 
	
    foreach($result_arr as $index=>$value){
		
		$current_ratio =round(($value/$question_response)*100,2);
		if(isset($prev_data_arr[0]->$index)){
			if($current_ratio > $prev_data_arr[0]->$index)
					$arrow_class = 'fa fa-arrow-up green';
			else
				   $arrow_class = 'fa fa-arrow-down red'; 
		
		   $prev_val =	$prev_data_arr[0]->$index.'%';	   
				   
		}
		else{
		  $prev_val ='-';	
		  $arrow_class ='';
		}
		 
		$output .='<tr>
		                       <td>'.$index.'</td>
							    <td align="right">'.number_format(intval($value)).'</td>
							   <td align="right">'.$prev_val.'</td>
							   <td align="right">'.$current_ratio.'% <i class="'.$arrow_class.'"></td>
							</tr>';   
		  
		  
	  }
   
   
   $output  .='</tbody></table>';
    
  
  
  } 
   
   else{
   
   $output = '<table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										<th>Percentage</th>
                                    </tr>
                                </tbody>
                                <tbody>';
								
    $i=1;
   if($result_arr){
	   						
	   foreach($result_arr as $key=>$value){
		 if($i==1){
			$key_text = '<strong>'.$key.'</strong>';
			$value_text =  '<strong>'.number_format(intval($value)).'</strong>';
			$percent = '<strong>'.round((($value/$question_response)*100),2).'%</strong>';
		 }
		 else{
		  
			$key_text = $key;
			$value_text =  number_format(intval($value));
			$percent = round((($value/$question_response)*100),2).'%';	 	 
		 }
		 $output  .='<tr>
					  <td>'.$key_text.'</td>
					  <td align="right">'.$value_text.'</td>
					  <td align="right">'.$percent.'</strong></td>
					</tr>'; 
		$i++;				
	   } 
   }
   else{
	 
	 $output  .='<tr><td colspan="3">No Data Found </td></tr>';
	    
   }
   $output  .='</tbody></table>';
    
  }
  
  }
  
  else if($output_type=='top_table'){
   
   arsort($result_arr);
   
    $map_data = $this->get_data('survey_type_question_map','map_id',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"q_id"=>$question_id));
   
    $prev_data = $this->get_data('survey_previous_backup','answer',array("map_id"=>$map_data[0]['map_id'],"value_type"=>"percentage","type"=>$comparison_type));
   
    $survey_data = $this->get_data('survey_master','start_date',array("survey_id"=>$survey_id));
	
	$survey_year = date('Y',strtotime($survey_data[0]['start_date'])); 
	
	$prev_year = $survey_year-1;
	
	if($prev_data){
	     $prev_data_arr = json_decode($prev_data[0]['answer']);
		 if(!$prev_data_arr)
		    return 'Wrong Format';     
	}
	   	    
	 if(isset($prev_data_arr)){  
	   
   $output = '<table class="table table-striped table-bordered table-hover">
                                <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										<th>'.$prev_year.'</th>
										<th>'.$survey_year.'</th>
                                    </tr>
                                </tbody>
                                <tbody>';
  
 
	$i=1;
    foreach($result_arr as $index=>$value){
		
		if($i==11)
		   continue;
		
		$current_ratio =round(($value/$question_response)*100,2);
		if(isset($prev_data_arr[0]->$index)){
			if($current_ratio > $prev_data_arr[0]->$index)
					$arrow_class = 'fa fa-arrow-up green';
			else
				   $arrow_class = 'fa fa-arrow-down red'; 
		
		   $prev_val =	$prev_data_arr[0]->$index.'%';	   
				   
		}
		else{
		  $prev_val ='-';	
		  $arrow_class ='';
		}
		 
		$output .='<tr>
		                       <td>'.$index.'</td>
							    <td align="right">'.number_format(intval($value)).'</td>
							   <td align="right">'.$prev_val.'</td>
							   <td align="right">'.$current_ratio.'% <i class="'.$arrow_class.'"></td>
							</tr>';   
		  
	  
	  $i++;	
		  
	  }
   
   
   $output  .='</tbody></table>';
    
  
  
  } 
   
   else{
   
   $output = '<table class="table table-striped table-bordered table-hover">
                                <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										<th>Percentage</th>
                                    </tr>
                                </tbody>
                                <tbody>';
								
    $i=1;
   if($result_arr){
	   						
	   foreach($result_arr as $key=>$value){
		 
		 if($i==11)
		   continue;
		   
		 if($i==1){
			$key_text = '<strong>'.$key.'</strong>';
			$value_text =  '<strong>'.number_format(intval($value)).'</strong>';
			$percent = '<strong>'.round((($value/$question_response)*100),2).'%</strong>';
		 }
		 else{
		  
			$key_text = $key;
			$value_text =  number_format(intval($value));
			$percent = round((($value/$question_response)*100),2).'%';	 	 
		 }
		 $output  .='<tr>
					  <td>'.$key_text.'</td>
					  <td align="right">'.$value_text.'</td>
					  <td align="right">'.$percent.'</strong></td>
					</tr>'; 
		$i++;				
	   } 
   }
   else{
	 
	 $output  .='<tr><td colspan="3">No Data Found </td></tr>';
	    
   }
   $output  .='</tbody></table>';
    
  }
 
  }
 
   return $output;
 
 }
 
 public function getOpenendedList($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){
 
	 $where_comparison_query='';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }   

	 $query = $this->db->query("SELECT qa.answer,count(qa.answer) as anwser_count  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." GROUP BY qa.answer ORDER BY qa.answer ASC  ");  
	
							   					   
							    
	$result=$query->result_array();
	$final_arr  = array();
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	foreach($result as $res){
	 
	 $result_arr[$res['answer']]=$res['anwser_count'];
	 
	}
	
	if($enable_comparison){
	 arsort($result_arr);
	 return $result_arr;
	}
	if($output_type=='graph'){
	 
	 
		
	 foreach($result_arr as $text=>$value){  
		  $final_arr[] = array("label"=>$text,"value"=>$value);  
	  	   
	 }
	 if($graph_id==1){
		  $output = '<script>FusionCharts.ready(function () {
		   var ageGroupChart = new FusionCharts({
			type: "pie2d",
			renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
			width: "400",
			height: "390",
			dataFormat: "json",
			dataSource: {
				 "chart": {
					"caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"showPercentValues": "1",
					"showLabels" :"0",
					"showPercentInTooltip": "1",
					"paletteColors": "#00AF50,#FFC000,#6F2F9F,#C82020,#8e0000,#BF0EEF,#0E45EF,#EF0EE1,#EF0E3A",
					"decimals": "2",
					"showLegend": "1",
					"theme": "fint"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	  });</script>';
	  
	 
	  
	  					   
	}
	else if($graph_id==2){
	 
		 $output ='<script>FusionCharts.ready(function () {
		var revenueChart = new FusionCharts({
			type: "doughnut2d",
			renderAt: "chart-container_'.$comparison_type.$survey_id.$survey_type_id.$question_id.'",
			width: "400",
			height: "390",
			dataFormat: "json",
			dataSource: {
				"chart": {
				   "caption": "",
					"subCaption": "",
					"numberPrefix": "",
					"bgColor": "#ffffff",
					"showBorder": "0",
					"use3DLighting": "0",
					"showShadow": "0",
					"enableSmartLabels": "1",
					"startingAngle": "310",
					"paletteColors": "#00AF50,#C82020,#FFC000,#6F2F9F,#8e0000,#BF0EEF,#0E45EF,#EF0EE1,#EF0E3A",
					"showLabels": "0",
					"showPercentValues": "1",
					"showLegend": "1",
					"legendShadow": "0",
					"legendBorderAlpha": "0",
					"defaultCenterLabel": "",
					"centerLabel": "",
					"centerLabelBold": "1",
					"showTooltip": "1",
					"decimals": "2",
					"captionFontSize": "14",
					"subcaptionFontSize": "14",
					"subcaptionFontBold": "0"
				},
				"data": '.json_encode($final_arr).'
			}
		}).render();
	});</script>';
		 	 
	}
  
  }
  else if($output_type=='table'){
   
   //arsort($result_arr);
   
   $output = '<table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                    </tr>
                                </tbody>
                                <tbody>';
								
    $i=1;					
   foreach($result_arr as $key=>$value){
	
	  
	    $key_text = $key;
			 
	 $output  .='<tr>
	              <td>'.$key_text.'</td>
				</tr>'; 
    $i++;				
   } 
   $output  .='</tbody></table>';
    
  }
 
   return $output;
 
 }
 
 public function getOpenendedRadiobuttonGridUsername($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }     
	 $query = $this->db->query("SELECT qa.answer,qa.user_unique_id  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
	
	$map_ar = $this->get_data('survey_type_question_map','map_id',array("q_id"=>291,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));	
		       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	$opt_arr = $this->convert_obj_arr_index($option_arr);
	$i=0;
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   
				 $output_arr[$ans_arr->id][$i]['value'] = $ans_arr->value;
				
				 $output_arr[$ans_arr->id][$i]['user'] = $this->get_company_name($result_arr['user_unique_id'],$map_ar[0]['map_id']);
				 
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
		$i++;
	}

        $final_arr =array();
		foreach($option_arr as $opt ){
			if(isset($output_arr[$opt->id])){
				$final_arr = $output_arr[$opt->id];
				$sorter=array();
				$ret=array();
				reset($final_arr);
				foreach ($final_arr as $ii => $va) {
					$sorter[$ii]=$va['user'];
				}
				asort($sorter);
				foreach ($sorter as $ii => $va) {
					$ret[$ii]=$final_arr[$ii];
				}
				$final_arr=$ret;
				$output_arr[$opt->id]=$final_arr;  
			}
			 
	 }
		 
	 	 
   if($output_type=='graph'){	
   
   
   }
  
   else if($output_type=='table'){
	
	 foreach($opt_arr as $index=>$value){
	  
	  if(isset($output_arr[$index])){
	  
	  $output .= '<div><h4>'.$value.'</h4>
	               <table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
									    <th>Company Name
                                        <th>Response</th>
                                        
                                    </tr>
                                </tbody>
                                <tbody>';
		 foreach($output_arr[$index] as $val){
		    
		   $output .='<tr>
		                 <td>'.$val['user'].'</td>
		                 <td>'.$val['value'].'</td>
					  </tr>';	 	 
			 
		 }
		  $output .='</tbody></table></div>';
	  }
	
	
	     
	 
     }
	   
	   
   }
  	   
 
   return $output;
 
 }

  public function getOpenendedRadiobuttonGridgraphEntity($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }     
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
					       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	$opt_arr = $this->convert_obj_arr_index($option_arr);
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   if(isset($output_arr[$ans_arr->id][$ans_arr->entity][$ans_arr->value])){
				   $output_arr[$ans_arr->id][$ans_arr->entity][$ans_arr->value] = $output_arr[$ans_arr->id][$ans_arr->entity][$ans_arr->value]+1;
			   }
			   else
				 $output_arr[$ans_arr->id][$ans_arr->entity][$ans_arr->value] = 1;
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
	}
	
	
   if($output_type=='graph'){	
   
   
   }
  
   else if($output_type=='table'){
	 
	 $sum_arr = array();
	   
	   foreach($output_arr as $index=>$out){
		
		  $sum_arr[$index] =0;
		 
		  foreach($out as $key=>$key_arr ){
			
			foreach($key_arr as $key_r=>$val_r)
			
			$sum_arr[$index] = $sum_arr[$index] + $val_r;
			  
		  }
		
		
	   }
	
	
	 foreach($opt_arr as $index=>$value){
	  
	  if(isset($output_arr[$index])){
	   
	  arsort($output_arr[$index]);
	     
	  $output .= '<div><h4>'.$value.'</h4>
	               <table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
                                        <th style="width:35%">Country</th>
										 <th style="width:35%">Response</th>
                                         <th style="width:15%">Count</th>
										 <th style="width:15%">Percentage</th>
                                    </tr>
                                </tbody>
                                <tbody>';
	   		 
			 				
		 foreach($output_arr[$index] as $text=>$value_arr){
		      
		   foreach($value_arr as $key=>$value){				 
						$output .='<tr>
		                 <td>'.$text.'</td><td>'.$key.'</td> 
						  <td>'.number_format(intval($value)).'</td>
						 <td>'.round((($value/$sum_arr[$index])*100),2).'%</td>';
		   }
		  $output .='</tr>';	 	 
		  
		
		  
			 
		 }
		  $output .='</tbody></table></div>';
	  }
	

	
	 
     }
		
	   
   }
  	   
 
   return $output;
 
 }
 
 public function getOpenendedRadiobuttonGridCompanyNameFirstName($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }     
	 $query = $this->db->query("SELECT qa.answer,qa.user_unique_id  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
	
	$map_ar = $this->get_data('survey_type_question_map','map_id',array("q_id"=>291,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
	$map_name_ar = $this->get_data('survey_type_question_map','map_id',array("q_id"=>1,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));	
		       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	$opt_arr = $this->convert_obj_arr_index($option_arr);
	$i=0;
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   
				 $output_arr[$ans_arr->id][$i]['value'] = $ans_arr->value;
				
				 $output_arr[$ans_arr->id][$i]['company'] = $this->get_company_name($result_arr['user_unique_id'],$map_ar[0]['map_id']);
				 
				 $output_arr[$ans_arr->id][$i]['user'] = $this->get_company_name($result_arr['user_unique_id'],$map_name_ar[0]['map_id']);
				 
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
		$i++;
	}

        $final_arr =array();
		foreach($option_arr as $opt ){
			if(isset($output_arr[$opt->id])){
				$final_arr = $output_arr[$opt->id];
				$sorter=array();
				$ret=array();
				reset($final_arr);
				foreach ($final_arr as $ii => $va) {
					$sorter[$ii]=$va['company'];
				}
				asort($sorter);
				foreach ($sorter as $ii => $va) {
					$ret[$ii]=$final_arr[$ii];
				}
				$final_arr=$ret;
				$output_arr[$opt->id]=$final_arr;  
			}
			 
	 }
		 
	 	 
   if($output_type=='graph'){	
   
   
   }
  
   else if($output_type=='table'){
	
	 foreach($opt_arr as $index=>$value){
	  
	  if(isset($output_arr[$index])){
	  
	  $output .= '<div><h4>'.$value.'</h4>
	               <table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
									    <th>Name</th>
									    <th>Company Name</th>
                                        <th>Response</th>
                                        
                                    </tr>
                                </tbody>
                                <tbody>';
		 foreach($output_arr[$index] as $val){
		    
		   $output .='<tr>
		                 <td>'.$val['user'].'</td>
						  <td>'.$val['company'].'</td>
		                 <td>'.$val['value'].'</td>
					  </tr>';	 	 
			 
		 }
		  $output .='</tbody></table></div>';
	  }
	
	
	     
	 
     }
	   
	   
   }
  	   
 
   return $output;
 
 }
 
 public function getOpenendedRadiobuttonGridCompanyNameJobTitle($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }     
	 $query = $this->db->query("SELECT qa.answer,qa.user_unique_id  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
	
	$map_ar = $this->get_data('survey_type_question_map','map_id',array("q_id"=>291,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
	$map_job_ar = $this->get_data('survey_type_question_map','map_id',array("q_id"=>108,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));	
		       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	$opt_arr = $this->convert_obj_arr_index($option_arr);
	$i=0;
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   
				 $output_arr[$ans_arr->id][$i]['value'] = $ans_arr->value;
				 
				 $company = $this->get_company_name($result_arr['user_unique_id'],$map_ar[0]['map_id']);
				  
				 $output_arr[$ans_arr->id][$i]['company'] = ($company!='') ? $company : 'Unidentified';
				 
				 $output_arr[$ans_arr->id][$i]['user'] = $this->get_company_name($result_arr['user_unique_id'],$map_job_ar[0]['map_id']);
				 
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
		$i++;
	}

        $final_arr =array();
		foreach($option_arr as $opt ){
			if(isset($output_arr[$opt->id])){
				$final_arr = $output_arr[$opt->id];
				$sorter=array();
				$ret=array();
				reset($final_arr);
				foreach ($final_arr as $ii => $va) {
					$sorter[$ii]=$va['company'];
				}
				asort($sorter);
				foreach ($sorter as $ii => $va) {
					$ret[$ii]=$final_arr[$ii];
				}
				$final_arr=$ret;
				$output_arr[$opt->id]=$final_arr;  
			}
			 
	 }
		 
	 	 
   if($output_type=='graph'){	
   
   
   }
  
   else if($output_type=='table'){
	
	 foreach($opt_arr as $index=>$value){
	  
	  if(isset($output_arr[$index])){
	  
	  $output .= '<div><h4>'.$value.'</h4>
	               <table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>									    
									    <th>Company Name</th>
										<th>Designation</th>
                                        <th>Response</th>
                                        
                                    </tr>
                                </tbody>
                                <tbody>';
		 foreach($output_arr[$index] as $val){
		    
		   $output .='<tr>
		                 <td>'.$val['company'].'</td>
		                 <td>'.$val['user'].'</td>					  
		                 <td>'.$val['value'].'</td>
					  </tr>';	 	 
			 
		 }
		  $output .='</tbody></table></div>';
	  }
	
	
	     
	 
     }
	   
	   
   }
  	   
 
   return $output;
 
 }
 
 public function getOpenendedRadiobuttonGridUserNameJobTitle($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }     
	 $query = $this->db->query("SELECT qa.answer,qa.user_unique_id  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
	
	$map_ar = $this->get_data('survey_type_question_map','map_id',array("q_id"=>1,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
	$map_job_ar = $this->get_data('survey_type_question_map','map_id',array("q_id"=>108,"survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));	
		       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	$opt_arr = $this->convert_obj_arr_index($option_arr);
	$i=0;
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   
				 $output_arr[$ans_arr->id][$i]['value'] = $ans_arr->value;
				
				 $output_arr[$ans_arr->id][$i]['name'] = $this->get_company_name($result_arr['user_unique_id'],$map_ar[0]['map_id']);
				 
				 $output_arr[$ans_arr->id][$i]['user'] = $this->get_company_name($result_arr['user_unique_id'],$map_job_ar[0]['map_id']);
				 
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
		$i++;
	}

       $final_arr =array();
		foreach($option_arr as $opt ){
			if(isset($output_arr[$opt->id])){
				$final_arr = $output_arr[$opt->id];
				$sorter=array();
				$ret=array();
				reset($final_arr);
				foreach ($final_arr as $ii => $va) {
					$sorter[$ii]=$va['name'];
				}
				asort($sorter);
				foreach ($sorter as $ii => $va) {
					$ret[$ii]=$final_arr[$ii];
				}
				$final_arr=$ret;
				$output_arr[$opt->id]=$final_arr;  
			}
			 
	 }
		 
	 	 
   if($output_type=='graph'){	
   
   
   }
  
   else if($output_type=='table'){
	
	 foreach($opt_arr as $index=>$value){
	  
	  if(isset($output_arr[$index])){
	  
	  $output .= '<div><h4>'.$value.'</h4>
	               <table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>									    
									    <th>Name</th>
										<th>Designation</th>
                                        <th>Response</th>
                                        
                                    </tr>
                                </tbody>
                                <tbody>';
		 foreach($output_arr[$index] as $val){
		    
		   $output .='<tr>
		                 <td>'.$val['name'].'</td>
		                 <td>'.$val['user'].'</td>					  
		                 <td>'.$val['value'].'</td>
					  </tr>';	 	 
			 
		 }
		  $output .='</tbody></table></div>';
	  }
	
	
	     
	 
     }
	   
	   
   }
  	   
 
   return $output;
 
 }
 
 public function getOpenendedCheckboxGrid($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type){
 
   	 
 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }     
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." ");
							   
				
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	$opt_arr = $this->convert_obj_arr_index($option_arr);
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   foreach($ans_arr->value as $opt_value){
				   if(isset($output_arr[$ans_arr->id][$opt_value])){
					   $output_arr[$ans_arr->id][$opt_value] = $output_arr[$ans_arr->id][$opt_value]+1;
				   }
				   else
					 $output_arr[$ans_arr->id][$opt_value] = 1;
				  }
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
	}
	
	
   if($output_type=='graph'){	
   
   
   }
  
   else if($output_type=='table'){
	 
	 $sum_arr = array();
	   
	   foreach($output_arr as $index=>$out){
		  
		  $sum_arr[$index] =0;
		 
		  foreach($out as $key=>$value ){
			
			$sum_arr[$index] = $sum_arr[$index] + $value;
			  
		  }
		
		
	   }
	 
	
	  
	 foreach($opt_arr as $index=>$value){
	  
	  if(isset($output_arr[$index])){
	  
	  arsort($output_arr[$index]);
	   
	  $output .= '<div><h4>'.$value.'</h4>
	               <table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										 <th>Percentage</th>
                                    </tr>
                                </tbody>
                                <tbody>';
		 foreach($output_arr[$index] as $text=>$value ){
		  
		   $output .='<tr>
		                 <td>'.$text.'</td>
						 <td>'.number_format(intval($value)).'</td>
						 <td>'.round((($value/$sum_arr[$index])*100),2).'%</td>
					  </tr>';	 	 
			 
		 }
		  $output .='</tbody></table></div>';
	  }
	
	
	     
	 
     }
	   
	   
   }
  	   
 
   return $output;
 
 
 
 } 
 
 public function getRadiobuttonGridgraphWithoutRanking($survey_id,$survey_type_id,$question_id,$graph_id,$output_type='graph',$comparison_type,$enable_comparison=0){
     	 
   	 $q_option=$this->get_entity_field('questions_master',$question_id,'q_option','q_id');
	 $option_arr = json_decode($q_option);
	 if(!$option_arr)
	   return 'Unknown Json format';
	 $where_comparison_query  = '';
	 $comparison_left_join=''; 
	 if($comparison_type!='default'){
	   $comparison_left_join = 'LEFT JOIN question_answers_type_map as qam ON(qa.user_unique_id=qam.user_unique_id)';	
	   $where_comparison_query='AND qam.type="'.$comparison_type.'"';    
	 }    
	 $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   ".$comparison_left_join."
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' ".$where_comparison_query." "); 
					       
	$result=$query->result_array();
	$result_arr = array();
	$final_arr  = array();
	$output_arr = array();
	$return_arr = array();
	$text_arr = $this->convert_obj_arr_index($option_arr);
	$output='';
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type);
	foreach($result as $result_arr){
	     $answer_arr = json_decode($result_arr['answer']);
		 if($answer_arr){
			 foreach($answer_arr as $ans_arr ){
				 $opt_count[$ans_arr->id]['count']= array();
			   if(isset($output_arr[$ans_arr->id][$ans_arr->value])){
				   $output_arr[$ans_arr->id][$ans_arr->value] = $output_arr[$ans_arr->id][$ans_arr->value]+1;
				   
			   }
			   else{
				 $output_arr[$ans_arr->id][$ans_arr->value] = 1;
			   
			   }
			   
			  
				 
			 }
		 }
		else{
		  return "Incorrect Answer Format";	
		}
	}
	
	
	
	$opt_arr = $this->convert_obj_arr_index($option_arr);
	 
    
   if($output_type=='table'){
	   
	   $sum_arr = array();
	   
	   
	   
	   
	 $option_val = $option_arr[0]->values;	
	 
	 foreach($output_arr as $index=>$out){
		  
		  $sum_arr[$index] =0;
		 
		  foreach($out as $key=>$value ){
			
			$sum_arr[$index] = $sum_arr[$index] + $value;
			  
		  }
		
		
	   }
	 
	
	  
	 foreach($opt_arr as $index=>$value){
	  
	  if(isset($output_arr[$index])){
	  
	  arsort($output_arr[$index]);
	   
	  $output .= '<div><h4>'.$value.'</h4>
	               <table class="table table-striped table-bordered table-hover">
                                 <tbody class="thead">
                                    <tr>
                                        <th>Response</th>
                                        <th>Count</th>
										 <th>Percentage</th>
                                    </tr>
                                </tbody>
                                <tbody>';
		 foreach($option_val as $opt_index=>$opt_value ){
		   if(isset($output_arr[$index][$opt_index]))	 						
		     $value = $output_arr[$index][$opt_index];
		   else
		     $value =0;	 
		   $output .='<tr>
		                 <td>'.$opt_index.'</td>
						 <td>'.number_format(intval($value)).'</td>
						 <td>'.round((($value/$sum_arr[$index])*100),2).'%</td>
					  </tr>';	 	 
			 
		 }
		  $output .='</tbody></table></div>';
	  }
	
	
	     
	 
     }
	   
	 
	 
	
   }
 
   return $output;
 
 }
  
 public function getTopcountries($survey_id,$survey_type_id,$question_id){
 
   $query = $this->db->query("SELECT qa.answer as country,count(qa.answer) as country_count  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' AND sq.report_listing_status='N' GROUP BY qa.answer ORDER BY country_count DESC LIMIT 0,10 ");
							    
  
   $output ='';
   
   if($query->num_rows()>0){
	   
     $result = $query->result_array();
	 $final_arr = array();
	 $colors_arr = array("#FF9C33","#1D8067","#BF0EEF","#33F9FF","#33B5FF","#33B5FF","#FF33CE","#FF333F","#D5696F","#1D8067");
	 $i=0;
	 $question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id);
	 $output .='<div class="list-group">';
	 foreach($result as $arr){
	   
		$country_code = $this->get_entity_field('countries_master',$arr['country'],'country_code','country');
		$final_arr[$country_code] = $colors_arr[$i];
		$i++; 
		$output .=' <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                                <span class="badge badge-success">'.round((($arr['country_count']/$question_response)*100),2).'%</span>
                                '.$i.'. '.$arr['country'].'
                            </a>';
		    
	 }
	 $final = (object)  array( 'regions' => array((object) array( 'values' => (object) $final_arr ) ) );
		 			
	 $output .='<script>
var handleVisitorsVectorMap=function() {
    if($("#visitors-map").length!==0) {
        map=new jvm.WorldMap( {
            map:"world_merc_en", scaleColors:["#e74c3c", "#0071a4"], container:$("#visitors-map"), normalizeFunction:"linear", hoverOpacity:.5, hoverColor:false, markerStyle: {
                initial: {
                    fill: "#4cabc7", stroke: "transparent", r: 3
                }
            }
            , regions:[ {
                attribute: "fill"
            }
            ], regionStyle: {
                initial: {
                    fill: "rgb(97,109,125)", "fill-opacity": 1, stroke: "none", "stroke-width": .4, "stroke-opacity": 1
                }
                , hover: {
                    "fill-opacity": .8
                }
                , selected: {
                    fill: "yellow"
                }
                , selectedHover: {}
            }
            , series: '.json_encode($final).'
            , focusOn: {
                x: .5, y: .5, scale: 3
            }
            , backgroundColor:"#2d353c"
        }
        )
    }
}

;
var MapVector=function() {
    "use strict";
    return {
        init:function() {
            handleVisitorsVectorMap()
        }
    }
}

()
       $(document).ready(function() {
		  
		  MapVector.init(); 
		   
	   });
			  </script>'; 
	 
	 
   }
   
   
   return $output;
 
 }
 
 public function gettotalcountries($survey_id,$survey_type_id,$question_id){
 
   $query = $this->db->query("SELECT qa.answer  FROM question_answers as qa 
	                           LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
							   LEFT JOIN questions_master as qm ON(qm.q_id=sq.q_id)
							   WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." AND sq.q_id=".$question_id."
							   AND qm.q_status='Y' AND sq.report_listing_status='N' GROUP BY qa.answer");
  
  return $query->num_rows();
	 
  							   
							   
 }
 
 public function getSurveyQuestionobjective($survey_id,$survey_type_id,$question_id){
	
	 $entity=$this->common_model->get_data('survey_question_observation','observation',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"question_id"=>$question_id));
	 if($entity)
	   return $entity[0]['observation'];
	 else
	   return 'No observations found';    
	 
 
 }
 
 public function getSurveyQuestionconclusion($survey_id,$survey_type_id,$question_id){
	
	 $entity=$this->common_model->get_data('survey_question_observation','conclusion',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"question_id"=>$question_id));
	 if($entity)
	   return $entity[0]['conclusion'];
	 else
	   return 'No conclusions found';    
	 
 
 }
 
 public function getSnapshotQuestions($survey_id,$survey_type_id){
	 
	  $query = $this->db->query("SELECT qm.q_id as question_id,qm.question,s.survey_id,
	                             s.survey_type_id,qm.question_type_id,s.graph_id,s.snapshot_view_type 
	                             FROM questions_master as qm 
	                             LEFT JOIN survey_type_question_map as s ON(qm.q_id=s.q_id)
								 WHERE s.survey_id=".$survey_id." AND s.survey_type_id=".$survey_type_id." AND s.snapshot_listing_status='Y' ORDER BY s.display_order ASC ");
	 
      return $query->result();
 
 }
 
 public function getPrevdataComparison($survey_id,$survey_type_id,$question_id,$question_type_id,$map_id,$comparison_type,$enable_comparison){
	
	$current_data= $this->getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type_id,0,'graph',$comparison_type,$enable_comparison=1);
	
   $prev_data = $this->get_data('survey_previous_backup','answer',array("map_id"=>$map_id,"value_type"=>"index","type"=>$comparison_type));
  if(!is_array($current_data)){	
    
	 if(!$prev_data)
	   return 'No Previous Data Found';     
	
	$arrow_class ='';
	
	if($current_data>$prev_data[0]['answer'])
	     $arrow_class = 'fa fa-arrow-up green';
	else if($current_data<$prev_data[0]['answer'])
	     $arrow_class = 'fa fa-arrow-down red';     
    
	$survey_data = $this->get_data('survey_master','start_date',array("survey_id"=>$survey_id));	
    $survey_year = date('Y',strtotime($survey_data[0]['start_date'])); 		
	$prev_year = $survey_year-1;
	
	$comparison_html = '<table class="table table-striped table-bordered table-hover">
	                        <tbody class="thead">
	                          <tr>
							   <th></th>
							   <th>'.$prev_year.'</th>
							   <th>'.$survey_year.'</th>
							  </tr>
						  </tbody>
						  <tbody>	  
							  <tr>
							   <td >Rating Index</td>
							   <td align="right">'.$prev_data[0]['answer'].'</td>
							   <td align="right">'.$current_data.' <i class="'.$arrow_class.'"></i></td>
							  </tr>
						  </tbody>	  
						</table>';
	
	}
	
	else{
	  if($prev_data){
	     $prev_data_arr = json_decode($prev_data[0]['answer']);
		 if(!$prev_data_arr)
		    return 'Wrong Format';     
	  }
	  else
	      return 'No Previous Data Found'; 
	  
	  $survey_data = $this->get_data('survey_master','start_date',array("survey_id"=>$survey_id));
	  $survey_year = date('Y',strtotime($survey_data[0]['start_date'])); 
	  $prev_year = $survey_year-1;
	  	      
	  $comparison_html = '<table class="table table-striped table-bordered table-hover">
	                        <tbody class="thead">
	                          <tr>
							   <th>Response</th> 
							   <th>'.$prev_year.'</th>
							   <th>'.$survey_year.'</th>
							  </tr>
						  </tbody>
						  <tbody>';
	  
	  /*foreach($current_data as $cur_data){
		
		if($cur_data['value'] > $prev_data_arr[0]->$cur_data['label'])
	        $arrow_class = 'fa fa-arrow-up green';
	    else
	       $arrow_class = 'fa fa-arrow-down red';   
		 
		$comparison_html .='<tr>
		                       <td>'.$cur_data['label'].'</td>
							   <td>'.$prev_data_arr[0]->$cur_data['label'].'</td>
							   <td>'.$cur_data['value'].'<i class="'.$arrow_class.'"></td>
							</tr>';   
		  
		  
	  }*/
	  
	  foreach($current_data as $index=>$value){
		$arrow_class ='';  
		if(isset($prev_data_arr[0]->$index)){
			if($value > $prev_data_arr[0]->$index)
				$arrow_class = 'fa fa-arrow-up green';
			else if($value < $prev_data_arr[0]->$index)
			   $arrow_class = 'fa fa-arrow-down red'; 
			   
		   $prev_value =$prev_data_arr[0]->$index; 	   
		}
		else{
		   
		   $prev_value ='-';
		   $arrow_class ='';	
		}
		 
		$comparison_html .='<tr>
		                       <td>'.$index.'</td>
							   <td>'.$prev_value.'</td>
							   <td>'.$value.'<i class="'.$arrow_class.'"></td>
							</tr>';   
		  
		  
	  }
	 
	  $comparison_html .='</tbody></table>';
	 	
	}
	
	
	
	
	
	
	return $comparison_html;
	
	
	 
	 
 }
 
 
 public function getDaily_data($survey_id,$survey_type_id,$question_id,$question_type_id,$map_id,$comparison_type,$enable_comparison){
	
	
	$date_arr = $this->get_survey_daily_date($survey_id,$survey_type_id);
	$day_wise_data_html='';
	 if(!$date_arr)
	    
		return false;
	
	/*if($survey_id==3)
	
	$date_arr = array("Day 1"=>"2016-10-01","Day 2"=>"2016-10-02","Day 3"=>"2016-10-03","Day 4"=>"2016-10-04","Day 5"=>"2016-10-05","Day 6"=>"2016-10-06","Day 7"=>"2016-10-07","Day 8"=>"2016-10-08");
	
	else
	 $date_arr = array("Day 1"=>"2016-10-16","Day 2"=>"2016-10-17","Day 3"=>"2016-10-18","Day 4"=>"2016-10-19","Day 5"=>"2016-10-20"); */
	
	if($question_type_id==7){
       
	   		
		foreach($date_arr as $dat_label=>$dat){
		 
		  $current_data= $this->getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type_id,0,'graph',$comparison_type='default',$enable_comparison=1,$dat);
		  
		  $question_arr = $this->get_data('questions_master','question',array("q_id"=>$question_id)); 
		  
		  $current_data_arr[] = array("value"=>$current_data);
		  
		  $survey_respondents = $this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type,$dat);
		  $respondents_arr[] =$survey_respondents;
		  $show_dat_arr[] = array("label"=>$dat_label);
		}
		$day_wise_data_html ='<div style="margin-left:30px;margin-top:20px"><table style="width:640px;"><tr><td align="center" colspan="'.sizeof($respondents_arr).'">Question Respondents</td></tr><tr>';
		$i=1;
		foreach($respondents_arr as $respondent){
		 
		  $day_wise_data_html .= '<td style="padding-left:22px;width:75px;background-color:#ccc;">Day-'.$i.': <br> '.$respondent.'</td>';
			
		 $i++;	
		}
	   $day_wise_data_html .='</tr></table></div>';
	   $day_wise_data_html .= '<div id="chart-container_'.$survey_id.$survey_type_id.$question_id.'"></div><script>FusionCharts.ready(function () {
        var revenueCompChart = new FusionCharts({
        type: "scrollcombi2d",
        renderAt: "chart-container_'.$survey_id.$survey_type_id.$question_id.'",
        width: "700",
        height: "400",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "xAxisname": "Days",
                "yAxisName": "Value",
                "numberPrefix": "",
                "numVisiblePlot" : "",
                
                //Cosmetics
                "paletteColors" : "#0075c2,#1aaf5d,#f2c500",
                "baseFontColor" : "#333333",
                "baseFont" : "Helvetica Neue,Arial",
                "captionFontSize" : "14",
                "subcaptionFontSize" : "14",
                "subcaptionFontBold" : "0",
                "showBorder" : "0",
                "bgColor" : "#ffffff",
                "showShadow" : "0",
                "canvasBgColor" : "#ffffff",
                "canvasBorderAlpha" : "0",
                "showValues" : "0",
                "divlineAlpha" : "100",
                "divlineColor" : "#999999",
                "divlineThickness" : "1",
                "divLineIsDashed" : "1",
                "divLineDashLen" : "1",
                "divLineGapLen" : "1",
                "usePlotGradientColor" : "0",
                "showplotborder" : "0",
                "showXAxisLine" : "1",
                "xAxisLineThickness" : "1",
                "xAxisLineColor" : "#999999",
                "showAlternateHGridColor" : "0",
                "showAlternateVGridColor" : "0",
                "legendBgAlpha" : "0",
                "legendBorderAlpha" : "0",
                "legendShadow" : "0",
                "legendItemFontSize" : "10",
                "legendItemFontColor" : "#666666",
                "scrollheight" : "10",
                "flatScrollBars" : "1",
                "scrollShowButtons" : "0",
                "scrollColor" : "#cccccc",
                "showHoverEffect" : "1",
            },
            "categories": [
                {
                    "category": '.json_encode($show_dat_arr).'
                }
            ],
            "dataset": [
                {
                    "seriesName": "'.$question_arr[0]['question'].'",
					"renderAs": "line",
                    "data": '.json_encode($current_data_arr).'
                }
                
                
            ]
        }
    });
    revenueCompChart.render();
});</script>';
	
  }
  else if($question_type_id==1  ){
	
	$dat_arr = array();
	$graph_out = array();
	
	foreach($date_arr as $dat_label=>$dat){
	 
	  $current_data= $this->getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type_id,0,'graph',$comparison_type='default',$enable_comparison=0,$dat,$return_arr=true);
	  
	  $survey_respondents = $this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison_type,$dat);
	    
	  foreach($current_data as $index=>$value){	
	    if($survey_respondents>0)
	     $percentage = round(($value/$survey_respondents)*100,2);
		else
		 $percentage =0; 
		$dat_arr[$index][]['value'] = $percentage;		  
	  }
	  
	 	  
	  $respondents_arr[] =$survey_respondents;
	  $show_dat_arr[] = array("label"=>$dat_label);
	}
	 
	 $j=0;
	 foreach($dat_arr as $out=>$arrval ){
		 $graph_out[$j]['seriesname'] = $out;
		 $graph_out[$j]['data'] = $arrval;
		 $j++;
	 }
	 
	  
	$day_wise_data_html ='<div style="margin-left:30px;margin-top:20px"><table style="width:640px;" ><tr><td align="center" colspan="'.sizeof($respondents_arr).'">Question Respondents</td></tr><tr>';
	$i=1;
	foreach($respondents_arr as $respondent){
	 
	  $day_wise_data_html .= '<td style="padding-left:22px;width:75px;background-color:#ccc;">Day-'.$i.': <br> '.$respondent.'</td>';
	 	
	 $i++;	
	}
	 $day_wise_data_html .='</tr></table></div>';
	 
	 $day_wise_data_html .= '<div id="chart-container_'.$survey_id.$survey_type_id.$question_id.'"></div><script>
	 FusionCharts.ready(function () {
    var visitChart = new FusionCharts({
        type: "msline",
        renderAt: "chart-container_'.$survey_id.$survey_type_id.$question_id.'",
        width: "650",
        height: "350",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
				"numberSuffix": "%",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#0075c2,#f442ad,#00AF50,#FFC000,#6F2F9F,#C82020,#8e0000",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
				"showPercentValues": "1",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Day",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": '.json_encode($show_dat_arr).'
                }
            ],
            "dataset": '.json_encode($graph_out).'
        }
    }).render();
});
	 </script>';
	  
  }
	
	
	return $day_wise_data_html;
	
	
	 
	 
 }
 
 
 public function getPrevdataPercentageComparison($survey_id,$survey_type_id,$question_id,$question_type_id,$map_id){
	
	$current_data= $this->getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type_id,0,'graph',$comparison_type='default',$enable_comparison=0,$percent_enable_comparison=true);
	$question_response =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id);
    arsort($current_data);
	$prev_data = $this->get_data('survey_previous_backup','answer',array("map_id"=>$map_id,"value_type"=>"percentage"));
	if($prev_data){
	     $prev_data_arr = json_decode($prev_data[0]['answer']);
		 if(!$prev_data_arr)
		    return 'Wrong Format';     
	}
	else
	 return 'No Previous Data Found';
	
	$survey_data = $this->get_data('survey_master','start_date',array("survey_id"=>$survey_id));	
	$survey_year = date('Y',strtotime($survey_data[0]['start_date'])); 	
	$prev_year = $survey_year-1;
	      
	$comparison_html = '<table class="table">
	                        <tbody class="thead">
	                          <tr>
							   <th>Response</th> 
							   <th>'.$prev_year.'</th>
							   <th>'.$survey_year.'</th>
							  </tr>
						  </tbody>
						  <tbody>';
	  
	  foreach($current_data as $index=>$value){
		$arrow_class='';
		if($value > $prev_data_arr[0]->$index)
	        $arrow_class = 'fa fa-arrow-up green';
	    else if($value < $prev_data_arr[0]->$index)
	       $arrow_class = 'fa fa-arrow-down red';   
		 
		$comparison_html .='<tr>
		                       <td>'.$index.'</td>
							   <td>'.$prev_data_arr[0]->$index.'</td>
							   <td>'.(round(($value/$question_response)*100)).'%<i class="'.$arrow_class.'"></td>
							</tr>';   
		  
		  
	  }
	 
	  $comparison_html .='</tbody></table>';
	 	
	
	return $comparison_html;
	
	
	 
	 
 }
 
 public function getCombinationdataComparison($survey_id,$survey_type_id,$question_id,$question_type_id,$map_id){
	
	$current_data['overall']= $this->getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type_id,0,'graph',$comparison_type='default',1,'',1);
	
	$question_response['overall'] =$this->getQuestionRespondants($survey_id,$survey_type_id,$question_id);
    //arsort($current_data);
	$comparison_data = $this->get_data('survey_comparison','comparison_type',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id));
	foreach($comparison_data as $comparison){
	  
	 $current_data[$comparison['comparison_type']]= $this->getSurveyQuestionAnswers($survey_id,$survey_type_id,$question_id,$question_type_id,0,'graph',$comparison['comparison_type'],1,'',1); 
	$question_response[$comparison['comparison_type']] = $this->getQuestionRespondants($survey_id,$survey_type_id,$question_id,$comparison['comparison_type']);	
	}
	
	$output = '<table class="table table-striped table-bordered table-hover"> <tbody class="thead">';
	$output .= '<tr>';
	$output .= '<th>Response</th>';
	foreach($current_data as $key => $data){
			$output .= '<th>'.ucfirst($key).'</th>';
	}
	$output .= '</tr></tbody><tbody>';
	foreach($current_data['overall'] as $key => $data){
		$output .= '<tr>';
		$output .= '<td>'.$key.'</td>';
		if($question_type_id==4 or $question_type_id==5 or $question_type_id==8 or $question_type_id==12)
		   $comp_val_default = $data;
		else
		   $comp_val_default =  round((($data/$question_response['overall'])*100),2).'%';   
		$output .= '<td align="right">'.$comp_val_default.'</td>';
		foreach($comparison_data as $comp){
			if($question_type_id==4 or $question_type_id==5 or $question_type_id==8 or $question_type_id==12 ){
				if(isset($current_data[$comp['comparison_type']][$key]))
				   $comp_val_type = $current_data[$comp['comparison_type']][$key];
				else
				   $comp_val_type =0;
			}
			else{
				if(isset($current_data[$comp['comparison_type']][$key]))
				   $comp_val_type = round((($current_data[$comp['comparison_type']][$key]/$question_response[$comp['comparison_type']])*100),2).'%';
				else
				   $comp_val_type ='0%';
			}
			
			   	   
			$output .= '<td align="right">'.$comp_val_type.'</td>';
		}
		$output .= '</tr>';
		
	}
	$output .='</tbody></table>';

	return $output;
	
	
	 
	 
 }
 
 
 public function getCorelationDataCollection($corelation_id,$answer_data,$type,$show_index,$rating_index_factor,$corelation_type){
	
	$corelation_data_html='';
	if($type=='graph'){
	  
	  if(!$answer_data)
	    return false;
	  
	  $corelation_data_html='<div id="chart-container_'.$corelation_id.'"></div><script>FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: "column2d",
        renderAt: "chart-container_'.$corelation_id.'",
        width: "550",
        height: "350",
        dataFormat: "json",
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "xAxisName": "",
                "yAxisName": "",
                "numberPrefix": "",
                "paletteColors": "#0075c2",
                "bgColor": "#ffffff",
                "borderAlpha": "0",
                "canvasBorderAlpha": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placevaluesInside": "1",
                "rotatevalues": "1",
                "valueFontColor": "#000",                
                "showXAxisLine": "1",
                "xAxisLineColor": "#999999",
                "divlineColor": "#999999",               
                "divLineIsDashed": "1",
                "showAlternateHGridColor": "0",
                "subcaptionFontBold": "0",
                "subcaptionFontSize": "14"
            },            
            "data": '.$answer_data.'
            
        }
    }).render();
});</script>';	
		
	}
  
  else if($type=='table'){

   if($corelation_type=='single'){	
	
	$answer_data_arr = json_decode($answer_data);
	
	if(!$answer_data_arr)
	   return 'Unknown Json format';
	$corelation_data_html = '<div class="scroll_table"><table class="table table-striped table-bordered table-hover">
	                          <tbody class="thead">
	                         <tr>
							   <th>Response</th>'; 
	foreach($answer_data_arr[0]->value as $data){
	  
	 $corelation_data_html .='<th>'.$data->text.'</th>';
	 
	}
	if($show_index=='Y'){
	 
	 if($rating_index_factor!=0)
	    $rating = '/'.$rating_index_factor;
	 else
	    $rating ='';	   
	  	
	 $corelation_data_html .='<th>Rating Index'.$rating.'</th>';
	 
	}
	 
	$corelation_data_html .='</tbody></tr><tbody>'; 
	
	foreach($answer_data_arr as $answer_data_val_arr){
     
	   $corelation_data_html .='<tr><td>'.$answer_data_val_arr->title.'</td>';
	   
	   foreach($answer_data_val_arr->value as $val_arr){
		    
			
		  $corelation_data_html .='<td style="text-align:right;">'.$val_arr->value.'</td>';    
		   
	   }
	   if($show_index=='Y')
	    $corelation_data_html .='<td style="text-align:right;">'.$answer_data_val_arr->index.'</td>';
	   
	  $corelation_data_html .= '</tr>';
	
	}
	
	$corelation_data_html .='</tbody></table></div>';  
	  
  }
  
  else if($corelation_type=='multiple'){	
	$corelation_data_html = '';
	$answer_data_arr = json_decode($answer_data);
	
	if(!$answer_data_arr)
	   return 'Unknown Json format';
	
	foreach($answer_data_arr as $data_arr){
	
	$corelation_data_html .='<h3 class="subTitle">'.$data_arr->main_title.'</h1>';
	   
	$corelation_data_html .= '<table class="table table-striped table-bordered table-hover">
	                         <tbody class="thead">
	                         <tr>
							   <th>Response</th>'; 
	foreach($data_arr->main_value[0]->value as $data){
	  
	 $corelation_data_html .='<th>'.$data->text.'</th>';
	 
	}
	if($show_index=='Y'){
	 
	 if($rating_index_factor!=0)
	    $rating = '/'.$rating_index_factor;
	 else
	    $rating ='';	   
	  	
	 $corelation_data_html .='<th>Rating Index'.$rating.'</th>';
	 
	}
	 
	$corelation_data_html .='</tr></tbody><tbody>'; 
	
	foreach($data_arr->main_value as $answer_data_val_arr){
     
	   $corelation_data_html .='<tr><td>'.$answer_data_val_arr->title.'</td>';
	   
	   foreach($answer_data_val_arr->value as $val_arr){
		    
			
		  $corelation_data_html .='<td style="text-align:right;">'.$val_arr->value.'</td>';    
		   
	   }
	   if($show_index=='Y')
	    $corelation_data_html .='<td style="text-align:right;">'.$answer_data_val_arr->index.'</td>';
	   
	  $corelation_data_html .= '</tr>';
	
	}
	
	$corelation_data_html .='</tbody></table>';  
	  
  }

  }
  }
  return $corelation_data_html;	 
	 
 }
 
 public function get_menu_items($survey_id,$survey_type_id){
	 
	 $query = $this->db->query("SELECT m.id,m.menu_name,m.menu_controller,m.menu_icon FROM survey_menu_map as sm 
	                            LEFT JOIN menu_items as m ON(sm.menu_id=m.id) 
								WHERE sm.survey_id=".$survey_id." AND sm.survey_type_id=".$survey_type_id." AND sm.status=1 GROUP BY m.id ORDER BY m.menu_order ASC "); 
	 
     return $query->result();
 }
 
 public function getDemographicsUsers($survey_id,$survey_type_id){ 
   
    $query = $this->db->query("SELECT qa.user_unique_id
	                           FROM question_answers as qa
                               LEFT JOIN survey_type_question_map as sq ON(qa.map_id=sq.map_id)
					           WHERE sq.survey_id=".$survey_id." AND sq.survey_type_id=".$survey_type_id." 
							   AND sq.enable_demographics='Y' GROUP BY qa.user_unique_id "); 
    return $query->result();
  
  }
 
 
  public function insert_query($subquery){
	
	$query = $this->db->query("INSERT INTO question_answers_type_map (user_unique_id,type,status) VALUES ".$subquery." ");
	 
	return $query; 
 }
 
 public function insert_answer($subquery){
	
	$query = $this->db->query("INSERT INTO question_answers (user_unique_id,answer,map_id) VALUES ".$subquery." ");
	 
	return $query; 
 }
 
 public function update_answer($subquery){
	
	
	$query = $this->db->query("UPDATE question_answers SET type ='top' WHERE user_unique_id in ('$subquery') ");
	 
	return $query; 
 }
 
 public function update_mutiple_answer($subquery,$arr){
	
	
	
	$query = $this->db->query("UPDATE question_answers SET submitted_date = CASE ".$subquery." ELSE submitted_date END  WHERE user_unique_id  IN  ('$arr') ");
	 
	return $query; 
 }
 
 public function get_data_filter($type){
	
	$query = $this->db->query("SELECT user_unique_id FROM question_answers WHERE type='".$type."' GROUP BY user_unique_id");
	
	return $query->result(); 
	 
 }
 
 public function get_company_name($user_unique_id,$map_id){
	
	$data = $this->get_data('question_answers','answer',array("user_unique_id"=>$user_unique_id,"map_id"=>$map_id));
    if($data)
	 return $data[0]['answer'];
	else
	 return false;  
	 
 }
 
 public function get_enable_export_status($survey_id,$survey_type_id,$user_id){
	
	$data = $this->get_data('survey_user_map','enable_export',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"user_id"=>$user_id));
    if($data)
	 return $data[0]['enable_export'];
	else
	 return false;   
 
 
 }
 
 public function get_survey_daily_date($survey_id,$survey_type_id){
	
	$query  = $this->db->query("SELECT submitted_date FROM question_answers as qa 
	                            LEFT JOIN survey_type_question_map as qm ON(qa.map_id=qm.map_id)
						        WHERE survey_id=".$survey_id." AND survey_type_id=".$survey_type_id." AND submitted_date!='0000-00-00' 
								GROUP BY submitted_date ORDER BY submitted_date ASC ");
	
	$date_arr =array();
								
	if($query->num_rows()>0){
		
	   $result = $query->result_array();
	   
	   $i=1;
	   
	  foreach($result as $res){
	    
		 $date_arr["Day ".$i.""]= $res['submitted_date'];
	     
		 $i++;
		 
	  }
	 	
		
	}
   
   return $date_arr;	 
 
 }
 
 public function get_color_code($option_arr,$rank){
	 
   foreach($option_arr as $opt){
	 
	  if($opt->rank==$rank)
	    return $opt->color;   
	   
   }
 
 }
 
 public function generate_option_arr($option_arr){
    
	$result_arr =array();
	foreach($option_arr as $opt){
      
	  $result_arr[$opt->text] = 0;
   
    }
	
	return $result_arr;
	
 }
 
 public function convert_obj_arr($option_arr){
	 
	 $result_arr = array();
	 
	 foreach($option_arr as $opt){
      
	  $result_arr[$opt->text] = $opt->id;
   
    }
	
	return $result_arr;

 }
 
 public function convert_obj_arr_index($option_arr){
	 
	 $result_arr = array();
	 
	 foreach($option_arr as $opt){
      
	  $result_arr[$opt->id] = $opt->text;
   
    }
	
	return $result_arr;

 }
 
 public function convert_obj_arr_rank_index($option_arr){
	 
	 $result_arr = array();
	 
	 foreach($option_arr as $opt){
      
	  $result_arr[$opt->text] = $opt->rank;
   
    }
	
	return $result_arr;

 }
 
 public function get_rank($option_arr,$pos){
  
  $rank_arr =array();
  
  foreach($option_arr as $opt){
	
	$rank_arr[]=$opt->rank;
	  
  }
  if($pos=='max')
   return max($rank_arr);
  else
   return min($rank_arr)-1;
 
 }
 
 public function get_color_range($option_arr,$min_rank,$max_rank){
	
	$color_arr =array();
	
	for($i=$min_rank;$i<$max_rank;$i++){
	  	
	 $color_code = $this->get_color_code($option_arr,$i+1);	
	 $min_value = $i;
	 $color_arr[]=array("minValue"=>$min_value,"maxValue"=>$i+1,"code"=>$color_code);	
		
	}
	return $color_arr;
   
 }
 
 public function get_comparison_type_config($comparison_type,$survey_id,$survey_type_id,$config_option){
	
	$data = $this->get_data('survey_comparison','config',array("survey_id"=>$survey_id,"survey_type_id"=>$survey_type_id,"comparison_type"=>$comparison_type));
	
	$config_option_arr= json_decode($data[0]['config']);
	if($config_option_arr)
	  $config_option_val = $config_option_arr[0]->$config_option;
	else
	  $config_option_val =false;  
	return $config_option_val;
	 
	
	 
  
 }
 
 public function get_max_rank($option_arr){
  $max_arr = array();
  foreach($option_arr as $key=>$value){
	$max_arr[]=$value;  
  }
  return  max($max_arr);
 
 }
 
 public  function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}
 
 
} 
?>