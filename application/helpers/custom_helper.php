<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(! function_exists('authAdmin')){	
	 function authAdmin(){
		$ci=& get_instance();
		if( $ci->session->userdata('logged_in') !== TRUE || $ci->session->userdata('is_admin') !== TRUE ) {
				redirect('admin/login');
		} 
	    return true;
	 }
}
if(! function_exists('authUser')){	
	 function authUser(){
		$ci=& get_instance();
		if( $ci->session->userdata('logged_in') !== TRUE || $ci->session->userdata('is_customer') !== TRUE ) {
				redirect('login');
		} 
	    return true;
	 }
}
if(! function_exists('printr')){	
	 function printr($string, $echo = true){
		 if($echo) 
		 	echo stripslashes(trim($string));
		 else 
		 	return stripslashes(trim($string));
	 }
}
if(! function_exists('printDate')){	
	 function printDate($date, $echo = true){
		 if($date != '0000-00-00'){
			 if($echo) 
				echo date("M d, Y", strtotime($date));
			 else 
				return date("M d, Y", strtotime($date));
		 }
		 else{
			 if($echo) 
				echo 'None';
			 else 
				return 'None';
		 }
	 }
}
if(! function_exists('printDateTime')){	
	 function printDateTime($date, $echo = true){
		 if($date != '0000-00-00 00:00:00'){
			 if($echo) 
				echo date("M d, Y - h:i A", strtotime($date));
			 else 
				return date("M d, Y - h:i A", strtotime($date));
		 }
		 else{
			 if($echo) 
				echo 'None';
			 else 
				return 'None';
		 }
	 }
}
if ( ! function_exists('NavMenus'))
{
	function NavMenus() {
		 $ci=& get_instance();
		 $ci->db->select('*');
		 $ci->db->from('pages'); 
		 $ci->db->where('status', 'Y');
		 $ci->db->where('page_type', 'page'); 
		 $ci->db->where('exclude_menu', 'N'); 
		 $ci->db->order_by('sort_order', 'ASC'); 
         $query = $ci->db->get();
         $results = $query->result();
		//echo "<pre>"; print_r($results); echo "</pre>"; 
		if($ci->uri->segment(1) == '' )
			$class = 'class="active" ';
		else 
			$class = '';
	    $html = "<ul>"; //init
		$html .= "<li ".$class.">";
		$html .= "<a href='".base_url()."'>Home</a>";
		$html .= "</li>";
		$m = 0;
		$class = '';
		$lt_class = '';
		$results = $query->result();
		foreach ($results as $row) {
			$m++;
				
			if ($row->parent_id == '0') {
				if($ci->uri->segment(1) == $row->page_name){
					$class = 'active';
				}
				
				
				$html .= "<li class='".$class."'>";
				$html .= "<a href='".base_url().$row->page_name."'>" . $row->page_title . "</a>";
				
				$html .= "<div class='dropdown'><ul>";
				foreach ($query->result() as $subcat) {
				
					if ($subcat->parent_id == $row->page_id) {
						if($ci->uri->segment(1) == $subcat->page_name )
							$class = ' ';//class="active"
						else 
							$class = '';
					
						//we have a subcategory
						$html .= "<li ".$class.">";
						$html .= "<a href='".base_url().$subcat->page_name."'>" . $subcat->page_title . "</a>";
						$html .= "</li>";
					}
				
				}
				$html .= "</ul></div>";
				$html .= "</li>";
			}
				
			
				
		}
		$html .= "</ul>";
		echo $html;  
	}
}
if ( ! function_exists('NavMenus_old'))
{
	function NavMenus_old() {
		 $ci=& get_instance();
		 $ci->db->select('*');
		 $ci->db->from('navmenus'); 
		 $ci->db->where('status', 'Y'); 
		 $ci->db->order_by('display_order', 'ASC'); 
         $query = $ci->db->get();
         $results = $query->result();
		//echo "<pre>"; print_r($results); echo "</pre>"; 
		if($ci->uri->segment(1) == '' )
			$class = 'class="active" ';
		else 
			$class = '';
	    $html = "<ul>"; //init
		$html .= "<li ".$class.">";
		$html .= "<a href='".base_url()."'>Home</a>";
		$html .= "</li>";
		$m = 0;
		$class = '';
		$lt_class = '';
		$results = $query->result();
		foreach ($results as $row) {
			$m++;
				
			if ($row->parent_id == '0') {
				if($ci->uri->segment(1) == $row->meu_type && $ci->uri->segment(2) == $row->menu_link ){
					$class = 'active';
				}
				
				
				$html .= "<li class='".$class."'>";
				//we have a category
				switch($row->meu_type){
					case 'page':
					$html .= "<a href='".base_url()."page/".$row->menu_link."'>" . $row->menu_title . "</a>";
					break;
					case 'category':
					
					break;
					case 'custom':
					default:
					$html .= "<a href='".$row->menu_link."'>" . $row->menu_title . "</a>";
					break;
				}
				
				$html .= "<div class='dropdown'><ul>";
				foreach ($query->result() as $subcat) {
				
					if ($subcat->parent_id == $row->menu_id) {
						if($ci->uri->segment(1) == $subcat->meu_type && $ci->uri->segment(2) == $subcat->menu_link )
							$class = 'class="active" ';
						else 
							$class = '';
					
						//we have a subcategory
						$html .= "<li ".$class.">";
						switch($subcat->meu_type){
							case 'page':
							$html .= "<a href='".base_url()."page/".$subcat->menu_link."'>" . $subcat->menu_title . "</a>";
							break;
							case 'category':
							
							break;
							case 'custom':
							default:
							$html .= "<a href='".$subcat->menu_link."'>" . $subcat->menu_title . "</a>";
							break;
						}
						$html .= "</li>";
					}
				
				}
				$html .= "</ul></div>";
				$html .= "</li>";
			}
				
			
				
		}
		$html .= "</ul>";
		echo $html;  
	}
}
if ( ! function_exists('send_email'))
{
    function send_email($email_id,$email_to, $vars,$email_cc='',$attachment='')
    {
		if(!$email_id) return false;
		if(!$email_to) return false;
		
        $ci=& get_instance();

        $ci->db->select('*');
		$ci->db->from('general_emails'); 
		$ci->db->where('email_id', $email_id); 
        $query = $ci->db->get();
        $row = $query->row();
		if($row->status == 'Y'){
			$email_subject 	 = $row->email_subject;
			$email_content 	 = $row->email_content;
			$email_variables = $row->email_variables?explode(',', $row->email_variables):array();
			
			foreach($email_variables as $variable){
				$email_content 	 = str_replace($variable, $vars[$variable], $email_content);
			}
			
			if(is_array($email_to))
				$email_to = implode(',', $email_to);
			
			if(is_array($email_cc))
				$email_cc = implode(',', $email_cc);
				
			$email_from = $ci->config->item('email_from');
			$email_from_name = $ci->config->item('email_from_name');
			//********* EMAIL*************//
			/*$config = Array(
			  'protocol' => 'smtp',
			  'smtp_host' => 'ssl://smtp.googlemail.com',
			  'smtp_port' => 465,
			  'smtp_user' => '', // change it to yours
			  'smtp_pass' => '', // change it to yours
			  'mailtype' => 'html',
			  'charset' => 'iso-8859-1',
			  'wordwrap' => TRUE
			);*/
			
			$ci->load->library('email');
			
			$config['protocol'] = 'mail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html'; // Append This Line
			$ci->email->initialize($config);

			$ci->email->from($email_from, $email_from_name);
			$ci->email->to($email_to); 
			
			if($email_cc)
				$ci->email->cc($email_cc); 
			//$ci->email->bcc('them@their-example.com'); 
			
			$ci->email->subject($email_subject);
			$ci->email->message($email_content);
			if($attachment != '' && file_exists($attachment)){	
				$ci->email->attach($attachment);
			}
			//echo "<pre>"; print_r($ci->email); exit;
			$send = $ci->email->send();
			
			
			if($send){
				return true;
			}
			else
				return false;
		}
    }
}

if ( ! function_exists('deleteImage'))
{
	function deleteImage($img,$folder=''){
		if(empty($img)) return false;
		$folder .= ($folder!='')?'/':'';
		if(file_exists($folder. $img)){
			unlink($folder. $img);
		}
		return true;
	} 
}
if ( ! function_exists('deleteFolder'))
{
	function deleteFolder($folder){
		if(empty($folder)) return false;
		
		recursiveRemoveDirectory($folder);
		
		return true;
	} 
}
if ( ! function_exists('createSlug'))
{
	function createSlug($string){
		   $slug=preg_replace('/[^A-Za-z0-9-]+/', '_', $string);
		   return $slug;
	} 
}
if ( ! function_exists('pageSlug'))
{
	function pageSlug($string, $id = ''){
		   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
		   
		    $ci=& get_instance();
			$ci->db->select('page_id');
			$ci->db->from('pages'); 
		 	$ci->db->where('page_name', $slug); 
			if($id)
				$ci->db->where('page_id !=',$id, true);
         	$query = $ci->db->get();
			$pages = $query->num_rows();
        	if($pages > 0 )
				return $slug.'-'.$pages;
			else
		   		return $slug;
	} 
}
if ( ! function_exists('recursiveRemoveDirectory'))
{
	function recursiveRemoveDirectory($directory)
	{
		foreach(glob("{$directory}/*") as $file)
		{
			if(is_dir($file)) { 
				recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		rmdir($directory);
	} 
}
if ( ! function_exists('ttruncat'))
{
	function ttruncat($text,$numb) {
		if (strlen($text) > $numb) { 
		  $text = substr($text, 0, $numb); 
		  $text = substr($text,0,strrpos($text," ")); 
		  $etc = " ...";  
		  $text = $text.$etc; 
		}
		return $text; 
	}
}
if ( ! function_exists('pagebreadcrumb'))
{
	function pagebreadcrumb() {
		$ci =& get_instance();
		$page = $ci->uri->segment(2);
		//echo $page;
		$output = '';
		if($page != '' ){
		 	$ci->db->select('nv1.menu_title as current_menu, nv2.menu_title as parent_menu, nv2.menu_link as parent_link');
			$ci->db->from('navmenus nv1');
			$ci->db->join('navmenus nv2','nv1.parent_id = nv2.menu_id', 'left'); 
		 	$ci->db->where('nv1.menu_link', $page); 
		 	$ci->db->where('nv1.meu_type', 'page'); 
			
         	$query  = $ci->db->get();
			//echo $ci->db->last_query(); exit;
        	$result = $query->row();
			
			
			$output .= '<div class="breadCrumb">';
			$output .= '<a href="'.base_url().'">home</a>';
			if($result->parent_link)
				$output .= ' / <a href="'.base_url().'page/'.$result->parent_link.'">'.$result->parent_menu.'</a> ';			
			$output .=' /  '.$result->current_menu;
			$output .= '</div>';
		}
		
		echo $output ;
	}
}