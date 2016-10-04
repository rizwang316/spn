<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Admin
 * @subpackage	Admin

 *
 */


class Admin_core extends CI_Controller {

	var $per_page = 10;

	

	public function __construct()
	{
		parent::__construct();

		
		checksavedlogin(); #defined in auth helper

		if(!is_admin() && !is_agent())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper
		$this->load->model('admin_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		// unique slug.
		$config = array(
			'table' => 'user_data',
			'id' => 'id',
			'field' => 'slug',
			'title' => 'title',
			'replacement' => 'dash' // Either dash or underscore
		);
		$this->load->library('slug',$config);
	}

	public function index()
	{
		if(!is_admin())
		{
			redirect(site_url('admin/business'));
		}

		$this->home();	
	}

	

	public function home($start=0,$sort_by='add_time')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

        $data['title'] 		= lang_key('dashboard');
		$data['content'] 	= load_admin_view('template/dashboard_view','',TRUE);
		load_admin_view('template/template_view',$data);

	}

	# load profile edit view
	public function editprofile()
	{
		$value['profile']	= $this->admin_model->get_user_profile($this->session->userdata('user_name'));

		$data['title']		= lang_key('edit_profile');
		$data['content'] 	= load_admin_view('profile/editprofile_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	public function edituser($user_id='')
	{

		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$value['action']	= 'edituser';

		$value['profile']	= $this->admin_model->get_user_profile_by_id($user_id);
		$data['title']		= lang_key('edit_user');
		$data['content'] 	= load_admin_view('profile/editprofile_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	
	#recovery email validation function
	public function useremail_check($str)
	{
		$this->load->model('account/auth_model');
		$id = $this->input->post('id');
		$res = $this->auth_model->is_email_exists_for_edit($str,$id);
		if ($res>0)
		{
			$this->form_validation->set_message('useremail_check', lang_key('email_allready_in_use'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	#username validation function
	public function username_check($str)
	{
		$this->load->model('account/auth_model');
		$id 	= $this->input->post('id');
		$res 	= $this->auth_model->is_username_exists_for_edit($str,$id);

		if ($res>0)
		{
			$this->form_validation->set_message('username_check', lang_key('username_allready_in_use'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


	#update profile 
	public function updateprofile()
	{

        $this->form_validation->set_rules('first_name',	'First Name', 		'required|xss_clean');
        $this->form_validation->set_rules('last_name',	'last Name', 		'required|xss_clean');
        $this->form_validation->set_rules('gender',		'Gender', 			'xss_clean');


		$this->form_validation->set_rules('user_name', 	'Username', 		'required|callback_username_check|xss_clean');
        $this->form_validation->set_rules('user_email', 	'Email', 		'required|valid_email|callback_useremail_check|xss_clean');

        if($this->input->post('password')!='' || $this->input->post('confirm_password')!='')
		   {
        	$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]');
		    $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
			//$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]|min_length[5]|xss_clean');
		   }


		if ($this->form_validation->run() == FALSE)
		{
			$action = $this->input->post('action');
			$id = $this->input->post('id');

			if($action=='editprofile')
			$this->editprofile($id);	
			else
			$this->edituser($id);	
		}
		else
		{
			$id = $this->input->post('id');
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				redirect(site_url('admin/editprofile/'.$id));	
			}
			else
			{
				$userdata['profile_photo'] 	= $this->input->post('profile_photo');
	            $userdata['first_name'] 	= $this->input->post('first_name');
	            $userdata['last_name'] 		= $this->input->post('last_name');
	            $userdata['gender'] 		= $this->input->post('gender');
	            $userdata['user_name'] 		= $this->input->post('user_name');
                $userdata['user_email'] 	= $this->input->post('user_email');
				
				if($this->input->post('user_type')!='') {
					 $userdata['user_type']    = $this->input->post('user_type');
					 $this->session->set_flashdata('msg_usertype', '<div class="alert alert-success">Please logout your account and login again, Because your account type changed!</div>');
				}
                if($this->input->post('password')!='') 
                {                	
                	$userdata['password'] 	= md5($this->input->post('password'));
                }


	            add_user_meta($id,'company_name',$this->input->post('company_name'));
				add_user_meta($id,'phone',$this->input->post('phone'));	
				
				if(get_user_type_by_id($this->input->post('user_type_id')) != 'business'){
								
					add_user_meta($id,'about_me',$this->input->post('about_me'));
					add_user_meta($id,'fb_profile',$this->input->post('fb_profile'));
					add_user_meta($id,'twitter_profile',$this->input->post('twitter_profile'));
					add_user_meta($id,'li_profile',$this->input->post('li_profile'));
					add_user_meta($id,'gp_profile',$this->input->post('gp_profile'));
				}
				if($this->input->post('hide_email') == 1){
	            	add_user_meta($id,'hide_email',$this->input->post('hide_email'));
				}
				if($this->input->post('hide_email') == 1){
	            	add_user_meta($id,'hide_phone',$this->input->post('hide_phone'));
				}
				$this->admin_model->update_profile($userdata,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_updated').'</div>');

				$action = $this->input->post('action');

				if($action=='editprofile')
					redirect(site_url('admin/editprofile/'.$id));		
				else
					redirect(site_url('admin/edituser/'.$id));		
			}
		}

	}
	
	#add profile education.
	public function alleducation($start=0)
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}		
		$userID = $this->session->userdata('user_id');
		$value['userID'] 		= $userID; 	
		$value['educations']  	= $this->admin_model->get_all_educations_by_user_id_by_range($start,$userID);
        $data['title'] 		= 'All Education';
        $data['content'] 	= load_admin_view('users/alleducation_view',$value,TRUE);
		load_admin_view('template/template_view',$data);	
		
	} 
	#load new service view
	public function neweducation()
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
        $data['education'] = 'New Education';
        $data['content'] = load_admin_view('users/neweducation_view','',TRUE);
		load_admin_view('template/template_view',$data);
	}
	#add a service
	public function addeducation($curr_page,$userID)
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}		
		$this->form_validation->set_rules('school_name', 'School Name', 'required');			
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->neweducation($curr_page,$userID);	
		}
		else
		{
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			$data 					= array();			
			$data['school_name'] 	= $this->input->post('school_name');
			$data['start_year'] 	= $this->input->post('start_year');
			$data['end_year'] 		= $this->input->post('end_year');
			$data['degree'] 		= $this->input->post('degree');
			$data['study_field'] 	= $this->input->post('study_field');
			$data['grad'] 			= $this->input->post('grad');
			$data['activities'] 	= $this->input->post('activities');
			$data['description'] 	= $this->input->post('description');
			
			$data['create_time'] 	= $time;
			$data['user_id']		= get_id_by_username($this->session->userdata('user_name'));
			$data['status']			= 1;
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->admin_model->insert_education($data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_inserted').'</div>');				
			}
			redirect(site_url('admin/neweducation/'.$curr_page.'/'.$userID));		
		}
	}
	#load edit service view
	public function editeducation($curr_page='',$id='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$value['education']  = $this->admin_model->get_education_by_id($id);
		$data['title'] = 'Edit Education';
		$data['content'] = load_admin_view('users/editeducation_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}
	
	#update a service
	public function updateeducation($curr_page='',$id='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$this->form_validation->set_rules('school_name', 'School Name', 'required');		
		

		if ($this->form_validation->run() == FALSE)
		{
			//$id = $this->input->post('id');
			$this->editeducation($curr_page,$id);	
		}
		else
		{

			$data 					= array();			
			$data['school_name'] 	= $this->input->post('school_name');
			$data['start_year'] 	= $this->input->post('start_year');
			$data['end_year'] 		= $this->input->post('end_year');
			$data['degree'] 		= $this->input->post('degree');
			$data['study_field'] 	= $this->input->post('study_field');
			$data['grad'] 			= $this->input->post('grad');
			$data['activities'] 	= $this->input->post('activities');
			$data['description'] 	= $this->input->post('description');			
			$data['create_time'] 	= $time;
			$data['user_id']		= get_id_by_username($this->session->userdata('user_name'));
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->admin_model->update_education($data,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/editeducation/'.$curr_page.'/'.$id));		
		}
	}
		
	#delete a service
	public function deleteeducation($id='',$confirmation='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		
		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/deleteeducation')),TRUE);
			 load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					$this->admin_model->delete_education_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
				}
			}
			redirect(site_url('admin/alleducation'));		
			
		}		
	}
	
	
	#add profile experience.
	public function allexperience($start=0)
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$userID = $this->session->userdata('user_id');
		$value['userID'] 		= $userID; 	
		$value['experiences']  	= $this->admin_model->get_all_experiences_by_user_id_by_range($start,$userID);
        $data['title'] 		= 'All Experience';
        $data['content'] 	= load_admin_view('users/allexperience_view',$value,TRUE);
		load_admin_view('template/template_view',$data);	
		
	} 
	#load new service view
	public function newexperience()
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
        $data['experience'] = 'New Experience';
        $data['content'] = load_admin_view('users/newexperience_view','',TRUE);
		load_admin_view('template/template_view',$data);
	}
	#add a service
	public function addexperience($curr_page,$userID)
	{	
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');			
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->newexperience($curr_page,$userID);	
		}
		else
		{
			
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			$data 					= array();			
			$data['company_name'] 	= $this->input->post('company_name');
			$data['title'] 			= $this->input->post('title');
			$data['location'] 		= $this->input->post('location');
			$data['start_month'] 		= $this->input->post('start_month');
			$data['start_year'] 	= $this->input->post('start_year');
			
			
			if($this->input->post('current') == 'on'){ 
			   $data['end_year'] 	='';
			   $data['end_month']   = '';
			   $data['present']   = 1;
			}else{ 
				$data['end_year'] 		= $this->input->post('end_year');
				$data['end_month'] 		= $this->input->post('end_month');
				$data['present']   = 0;
			}
			
			$data['description'] 	= $this->input->post('description');
			
			$data['create_time'] 	= $time;
			$data['user_id']		= get_id_by_username($this->session->userdata('user_name'));
			$data['status']			= 1;
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->admin_model->insert_experience($data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_inserted').'</div>');				
			}
			redirect(site_url('admin/newexperience/'.$curr_page.'/'.$userID));		
		}
	}
	#load edit service view
	public function editexperience($curr_page='',$id='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$value['experience']  = $this->admin_model->get_experience_by_id($id);
		$data['title'] = 'Edit Experience';
		$data['content'] = load_admin_view('users/editexperience_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}
	
	#update a service
	public function updateexperience($curr_page='',$id='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');		
		

		if ($this->form_validation->run() == FALSE)
		{
			//$id = $this->input->post('id');
			$this->editexperience($curr_page,$id);	
		}
		else
		{

			$data 					= array();			
			$data['company_name'] 	= $this->input->post('company_name');
			$data['title'] 			= $this->input->post('title');
			$data['location'] 		= $this->input->post('location');
			$data['start_month'] 		= $this->input->post('start_month');
			$data['start_year'] 	= $this->input->post('start_year');
			$data['end_month'] 			= $this->input->post('end_month');
			
			if($this->input->post('current') == 'on'){ 
			   $data['end_year'] 	='';
			   $data['end_month']   = '';
			   $data['present']   = 1;
			}else{ 
				$data['end_year'] 		= $this->input->post('end_year');
				$data['end_month'] 		= $this->input->post('end_month');
				$data['present']   = 0;
			}
			
						
			//$data['create_time'] 	= $time;
			$data['user_id']		= get_id_by_username($this->session->userdata('user_name'));
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->admin_model->update_experience($data,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/editexperience/'.$curr_page.'/'.$id));		
		}
	}
		
	#delete a service
	public function deleteexperience($id='',$confirmation='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/deleteexperience')),TRUE);
			 load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					$this->admin_model->delete_experience_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
				}
			}
			redirect(site_url('admin/allexperience'));		
			
		}		
	}
	
	//add
	#add profile favorite.
	public function allfavorite($start=0)
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$userID = $this->session->userdata('user_id');
		$value['userID'] 		= $userID; 			
		$value['fav_activities']  = get_user_meta_gen($userID,'fav_activities');
		$value['fav_sports']  = get_user_meta_gen($userID,'fav_sports');
		$value['fav_foods']  = get_user_meta_gen($userID,'fav_foods');
		
        $data['title'] 		= 'All Experience';
        $data['content'] 	= load_admin_view('users/allfavorite_view',$value,TRUE);
		load_admin_view('template/template_view',$data);	
		
	} 
	
	#load edit service view
	public function editfavorite($curr_page='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$userID=get_id_by_username($this->session->userdata('user_name'));
		$value['fav_activities']  = get_user_meta_gen($userID,'fav_activities');
		$value['fav_sports']  = get_user_meta_gen($userID,'fav_sports');
		$value['fav_foods']  = get_user_meta_gen($userID,'fav_foods');
		
		$data['title'] = 'Edit Experience';
		$data['content'] = load_admin_view('users/editfavorite_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}
	
	#update a service
	public function updatefavorite($curr_page='',$id='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		 
		if(isset($_POST['submit_activities']) && $_POST['submit_activities'] == 'submit_activities'){			
	  		 $this->form_validation->set_rules('fav_activities[]',	'Favorite Activities', 		'required');
		}
		
		if(isset($_POST['submit_sports']) && $_POST['submit_sports'] == 'submit_sports'){			
	  		 $this->form_validation->set_rules('fav_sports[]',	'Favorite Sports', 		'required');
		}
		
		if(isset($_POST['submit_foods']) && $_POST['submit_foods'] == 'submit_foods'){			
	  		 $this->form_validation->set_rules('fav_foods[]',	'Favorite Foods', 		'required');
		}

		if ($this->form_validation->run() == FALSE)
		{
			//$id = $this->input->post('id');
			$this->editfavorite($curr_page);	
		}
		else
		{
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data_activities 		 = array();			
			$data_activities['key'] =  'fav_activities';
			$data_activities['value'] = json_encode($this->input->post('fav_activities'));						
			$data_activities['create_time'] 	= $time;
			$data_activities['user_id']		= get_id_by_username($this->session->userdata('user_name'));						
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				add_user_meta_gen($data_activities['user_id'],$data_activities['key'],$data_activities);					
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			// sports.
			$data_sports 		 = array();			
			$data_sports['key'] =  'fav_sports';
			$data_sports['value'] = json_encode($this->input->post('fav_sports'));						
			$data_sports['create_time'] 	= $time;
			$data_sports['user_id']		= get_id_by_username($this->session->userdata('user_name'));						
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				add_user_meta_gen($data_sports['user_id'],$data_sports['key'],$data_sports);					
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			// foods.
			$data_foods 		 = array();			
			$data_foods['key'] =  'fav_foods';
			$data_foods['value'] = json_encode($this->input->post('fav_foods'));						
			$data_foods['create_time'] 	= $time;
			$data_foods['user_id']		= get_id_by_username($this->session->userdata('user_name'));						
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				add_user_meta_gen($data_foods['user_id'],$data_foods['key'],$data_foods);					
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			
			
			redirect(site_url('admin/editfavorite/'.$curr_page.'/'.$id));		
		}
	}
	
	#add profile bucket list.
	public function allbucket($start=0)
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$userID = $this->session->userdata('user_id');
		$value['userID'] 		= $userID; 			
		$value['bucket_list']  = get_user_meta_gen($userID,'bucket_list');
		$value['causes']  = get_user_meta_gen($userID,'causes');
		
        $data['title'] 		= 'All List';
        $data['content'] 	= load_admin_view('users/allbucketlist_view',$value,TRUE);
		load_admin_view('template/template_view',$data);	
		
	} 
	
	#load edit service view
	public function editbucket($curr_page='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$userID=get_id_by_username($this->session->userdata('user_name'));
		$value['bucket_list']  = get_user_meta_gen($userID,'bucket_list');
		
		$value['causes']  = get_user_meta_gen($userID,'causes');
		
		$data['title'] = 'Edit';
		$data['content'] = load_admin_view('users/editbucketlist_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}
	
	#update a service
	public function updatebucket($curr_page='')
	{	
	   // check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
	
	
		if(isset($_POST['submit_bucket']) && $_POST['submit_bucket'] == 'bucket'){			
	  		 $this->form_validation->set_rules('bucket_list[]',	'Bucket List', 		'required');
		}
		
		if(isset($_POST['submit_causes']) && $_POST['submit_causes'] == 'causes'){			
	  		 $this->form_validation->set_rules('causes',	'Causes', 		'required');
		}
		
	   	
		if ($this->form_validation->run() == FALSE)
		{			
			$this->editbucket();	
			
		}else{  			
	       
			foreach($_POST["bucket_list"] as $k => $v){				
			  //echo $this->input->post("bucket_list_value[$k]");			
				        if($this->input->post("bucket_list_value[$k]")!= ''){							   
								$setvalue = $this->input->post("bucket_list_value[$k]");
							}else{								
								$setvalue = 'null';
							}									
				$bucket_list[] = array($v =>$setvalue);					
			}			
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data_bucket_list 		 = array();			
			$data_bucket_list['key'] =  'bucket_list';
			$data_bucket_list['value'] = json_encode($bucket_list);						
			$data_bucket_list['create_time'] 	= $time;
			$data_bucket_list['user_id']		= get_id_by_username($this->session->userdata('user_name'));						
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				add_user_meta_gen($data_bucket_list['user_id'],$data_bucket_list['key'],$data_bucket_list);					
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			// sports.
			$data_causes 		 = array();			
			$data_causes['key'] =  'causes';
			$data_causes['value'] = $this->input->post('causes');						
			$data_causes['create_time'] 	= $time;
			$data_causes['user_id']		= get_id_by_username($this->session->userdata('user_name'));						
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{				
				add_user_meta_gen($data_causes['user_id'],$data_causes['key'],$data_causes);					
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/editbucket/'.$curr_page));	
		}
				
		
	}
	
  // edit photo images.  
	public function editimages($curr_page='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		$userID = get_id_by_username($this->session->userdata('user_name'));
		
		$value['images_list']  = get_user_data_gen($userID,'gallery_img');
		
		$data['title'] = 'Edit';
		$data['content'] = load_admin_view('users/editimages_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}	
	// upldate.
	public function updateimages($curr_page='')
	{
			// check permission.
			if(is_business()){
				echo lang_key('dont_have_permission');
				die;			
			}	
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			$data 		 = array();			
			$data['key'] =  'gallery_img';
			$data['value'] = $this->input->post('gallery');						
			$data['create_time'] 	= $time;
			$data['user_id']=get_id_by_username($this->session->userdata('user_name'));
		
		// insert data in gallery.
			if(($this->input->post('gallery')!=false)){	
				$this->db->delete('user_data',array('user_id'=>$data['user_id'],'key'=>'gallery_img'));					
				foreach($this->input->post('gallery') as $val){	
			   		$this->db->insert('user_data',array('user_id'=>$data['user_id'],'create_time'=>$data['create_time'],'key'=>$data['key'],'value'=>$val));
				}		 
			}else{
				  // delete post data if already exist, and post empty.
				  $this->db->delete('user_data',array('user_id'=>$data['user_id'],'key'=>$data['key']));
				
			 }
			 redirect(site_url('admin/editimages/'.$curr_page));		
	}
	 public function uploadgalleryfile()
	{
			// check permission.
			if(is_business()){
				echo lang_key('dont_have_permission');
				die;			
			}	
		

		$config['upload_path'] = './uploads/gallery/';
		$config['allowed_types'] = 'gif|jpg|JPG|png';
		$config['max_size'] = '5120';

		$this->load->library('upload', $config);
		$this->upload->display_errors('', '');	

		if($this->upload->do_upload('photoimg'))
		{

			$data = $this->upload->data();
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/gallery/'.$data['file_name'];
			$media['create_time'] 		= standard_date($format, $time);
			$media['status']			= 1;

			$status['error'] 	= 0;
			$status['name']	= $data['file_name'];
		}
		else
		{

			$errors = $this->upload->display_errors();
			$errors = str_replace('<p>','',$errors);
			$errors = str_replace('</p>','',$errors);
			$status = array('error'=>$errors,'name'=>'');
		}

		echo json_encode($status);
		die;
	}



	#users functions
	public function allusers($start=0)
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('user/user_model');
		$value['users']  	= $this->user_model->get_all_users_by_range($start,$this->per_page,'id');
		$total 				= $this->user_model->count_all_users();
		$value['pages']		= configPagination('admin/allusers',$total,3,$this->per_page);	
		$data['content'] 	= load_admin_view('users/allusers_view',$value,TRUE);		
		load_admin_view('template/template_view',$data);

	}



	public function userdetail($id='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('user/user_model');
		$value['total_posts'] 	= $this->user_model->count_all_user_posts($id);
		$value['profile']		= $this->user_model->get_user_profile_by_id($id);  
		$data['content'] 		= load_admin_view('users/detail_view',$value,TRUE);
		load_admin_view('template/template_view',$data);

	}

	#delete a user
	public function deleteuser($page='0',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}
		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/deleteuser/'.$page)),TRUE);
			load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					$this->load->model('user/user_model');
					$this->user_model->delete_user_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_deleted').'</div>');
				}
			}
			redirect(site_url('admin/users/all/'.$page));		
		}		

	}



	#make moderator a user

	public function makemoderator($page='0',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->load->model('user/user_model');

			$this->user_model->update_user_by_id(array('user_type'=>3),$id);

			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_updated').'</div>');
		}				

		redirect(site_url('admin/users/all/'.$page));				

	}



	#make moderator a user

	public function removemoderator($page='0',$id='',$confirmation='')
	{

		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->load->model('user/user_model');

			$this->user_model->update_user_by_id(array('user_type'=>2),$id);

			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_updated').'</div>');
		}		

		redirect(site_url('admin/users/all/'.$page));				

	}



	#confirm a user

	public function confirmuser($page='0',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->load->model('user/user_model');
			$this->user_model->confirm_user_by_id($id);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_confirmed').'</div>');
		}		
		redirect(site_url('admin/users/all/'.$page));				
	}


	public function banuser($id='',$limit='')
	{

		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}
		
		$this->load->model('user/user_model');

		if($limit=='forever')
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->user_model->banuser($id,$limit);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_banned').'</div>');
			}	
			redirect(site_url('admin/userdetail/'.$id));			
		}

		$this->form_validation->set_rules('limit',	'Limit', 'required|numeric|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$this->userdetail($id);	
		}
		else
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$limit = $this->input->post('limit');
				$this->user_model->banuser($id,$limit);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_banned').'</div>');
			}	
			redirect(site_url('admin/userdetail/'.$id));
		}
	}
	
	// blog.	
	public function blog_manage($id='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		
		$values 			= array();
		$values['title'] 	= 'New Blog';		
		if($id!='')
		{
			$user_id = get_id_by_username($this->session->userdata('user_name'));			
			$values['id']  		= $id;
			$values['title']  		= 'Update Blog';
			$values['action_type']  = 'update';
		//	$values['blog']    = get_user_data($user_id,'blog');	
		   $values['blog']    = get_user_data_by_id($id);		
		}

        $data['content'] = load_admin_view('users/blog/blog_view',$values,TRUE);
		load_admin_view('template/template_view',$data);			
	}
	public function add_blog($id='')
	{ 
			// check permission.
			if(is_business()){
				echo lang_key('dont_have_permission');
				die;			
			}	

		
		$this->form_validation->set_rules('title', lang_key('title'), 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			if($this->input->post('action_type')=='update')
				$this->blog_manage($this->input->post('id'));
			else
				$this->blog_manage();	
		}
		else
		{
			$data = array();
			$data['key'] =  'blog';
			$data['value'] = $this->input->post('featured_img');	
			$data['title'] = $this->input->post('title');
			
			
			$data['description'] = $this->input->post('description');
			$data['create_time'] = time();
			$data['user_id'] = get_id_by_username($this->session->userdata('user_name'));
			

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				if($this->input->post('action_type')=='update')
				{					
					$id = $this->input->post('id');
					// slug update.
					$data['slug'] = $this->slug->create_uri(array('title' =>  $this->input->post('title')), $id);
					
					update_user_data_gen($id,$data);	
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_updated').'</div>');
				}else{
					// add slug
					$slug =$this->slug->create_uri(array('title' => $this->input->post('title')));
					$data['slug'] 			= $slug;
															
					$id = add_user_data_gen($data);	
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_created').'</div>');
				}				
			}	

			redirect(site_url('admin/blog_manage/'.$id));		
		}

	}
	public function view_all_blogs($page='0')
	{
			// check permission.
			if(is_business()){
				echo lang_key('dont_have_permission');
				die;			
			}	
		

		$value['user_id']	= get_id_by_username($this->session->userdata('user_name'));
		$value['blogs']  	= $this->admin_model->get_all_blogs_based_on_user($value['user_id']);
		$data['title'] 		= lang_key('all_reviews');
		$data['content'] 	= load_admin_view('users/blog/all_blogs_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}
		// delete video
	public function deleteblog($page='0',$id='',$confirmation='')
	{
			// check permission.
			if(is_business()){
				echo lang_key('dont_have_permission');
				die;			
			}
		

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/deleteblog/'.$page)),TRUE);
			load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					//delete 					
					delete_user_data_gen($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Video Deleted</div>');

					
				}
			}
			redirect(site_url('admin/view_all_blogs/'.$page.'/'.$post_id));
		}		
	}
	
	public function featuredimguploader()

	{

		 load_admin_view('users/blog/featured_img_uploader_view');

	}

	public function uploadfeaturedfile()
	{
			// check permission.
			if(is_business()){
				echo lang_key('dont_have_permission');
				die;			
			}	


		$dir_name 					= 'users/blog/';
		$config['upload_path'] 		= './uploads/'.$dir_name;
		$config['allowed_types'] 	= 'gif|jpg|png';
		$config['max_size'] 		= '5120';
		$config['min_width'] 		= '250';
		$config['min_height'] 		= '180';

		$this->load->library('upload', $config);
		$this->upload->display_errors('', '');	

		if($this->upload->do_upload('photoimg'))
		{
			$data = $this->upload->data();
			$this->load->helper('date');

			$format = 'DATE_RFC822';
			$time = time();
			create_rectangle_thumb('./uploads/'.$dir_name.$data['file_name'],'./uploads/'.$dir_name.'thumbs/');

			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/'.$dir_name.$data['file_name'];
			$media['create_time'] 		= standard_date($format, $time);
			$media['status']			= 1;

			$status['error'] 	= 0;
			$status['name']	= $data['file_name'];
		}

		else

		{

			$errors = $this->upload->display_errors();

			$errors = str_replace('<p>','',$errors);

			$errors = str_replace('</p>','',$errors);

			$status = array('error'=>$errors,'name'=>'');

		}



		echo json_encode($status);

		die;

	}
	
	
	// upload videos
	public function view_all_video($page='0')	
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
		

		$value['user_id']	= get_id_by_username($this->session->userdata('user_name'));
		$value['blogs']  	= get_user_data($value['user_id'],'video_url');
		$data['title'] 		= 'All Video';
		$data['content'] 	= load_admin_view('users/all_videos_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
		
	}
	
	public function add_video($currentpage='')
	{ 
			// check permission.
			if(is_business()){
				echo lang_key('dont_have_permission');
				die;			
			}	

		$user_id	= get_id_by_username($this->session->userdata('user_name'));
		
		$currentpage = $this->input->post('current_page');
		$this->form_validation->set_rules('video_url', 'Video URL', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			if($this->input->post('action_type')=='update')
				$this->manage_video($currentpage,$this->input->post('id'));
			else
				$this->manage_video($currentpage);	
		}else{
			$data = array();
			$data['key'] =  'video_url';			
			$data['value'] = $this->input->post('video_url');
			$data['title'] = $this->input->post('title');
			$data['create_time'] = time();
			$data['user_id'] = get_id_by_username($this->session->userdata('user_name'));
			

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				if($this->input->post('action_type')=='update')
				{
					$id = $this->input->post('id');
					update_user_data_gen($id,$data);	
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Video updated</div>');
				}else{													
					$id = add_user_data_gen($data);	
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Video Created</div>');
				}				
			}	

			redirect(site_url('admin/manage_video/'.$currentpage.'/'.$id));		
		}

	}
	public function manage_video($currentpage='',$id='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
			 
		$values 			= array();
		$values['title'] 	= 'New Video';
		$user_id	= get_id_by_username($this->session->userdata('user_name'));		
		if($id!='')
		{			
			$values['id']  		= $id;
			$values['title']  		= 'Update Blog';
			$values['action_type']  = 'update';
			 $values['video']    = get_user_data_by_id($id);	
			//$values['video']    = get_user_data($user_id,'video_url');			
		}
        $data['content'] = load_admin_view('users/video_view',$values,TRUE);
		load_admin_view('template/template_view',$data);			
	}
	// delete video
	public function deletevideo($page='0',$post_id='',$confirmation='')
	{
		// check permission.
		if(is_business()){
			echo lang_key('dont_have_permission');
			die;			
		}	
	

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$post_id,'url'=>site_url('admin/deletevideo/'.$page)),TRUE);
			load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					//delete 					
					delete_user_data_gen($post_id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Video Deleted</div>');

					
				}
			}
			redirect(site_url('admin/view_all_video/'.$page));
		}		
	}
  // comments
  
	public function view_all_reviews($page='0',$post_id='')
	{
		
		if(!is_admin())
		{
			$post = get_user_data_by_id($post_id)->row();
			if($post->user_id != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}				

		$value['post_id']	= $post_id;
		$value['reviews']  	= get_all_comments($post_id,'user_blog');
		$data['title'] 		= lang_key('all_reviews');
		$data['content'] 	= load_admin_view('users/blog/all_reviews_view',$value,TRUE);
		
		load_admin_view('template/template_view',$data);
	}
	
	#delete a post
	public function deletecomment($page='0',$post_id='',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			$post = get_user_data_by_id($post_id)->row();

			if($post->user_id != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/deletecomment/'.$page.'/'.$post_id)),TRUE);
			load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					  // delete commentd 
					 delete_comment_by_id($id);
					 // delete comments meta.
					  delete_comment_meta_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Comments Deleted</div>');

					
				}
			}
			redirect(site_url('admin/view_all_reviews/'.$page.'/'.$post_id));
		}		
	}

	
	

}



/* End of file admin_core.php */
/* Location: ./application/modules/admin/controllers/admin_aore.php */