<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		User
 * @subpackage	UserCore
 */

class User_core extends CI_Controller {
	
	var $active_theme = '';
	var $per_page = 2;
	public function __construct()
	{
		parent::__construct();
		
		
		if(!is_loggedin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('account/trylogin'));
		}
		

		$this->per_page = get_per_page_value();

		$this->load->database();
		$this->active_theme = get_active_theme();
		$this->load->model('user/post_model');
		$this->load->model('user/user_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger form-error">', '</div>');
		// unique slug.
		$config = array(
			'table' => 'posts',
			'id' => 'id',
			'field' => 'slug',
			'title' => 'title',
			'replacement' => 'dash' // Either dash or underscore
		);
		$this->load->library('slug',$config);

	}
	
	public function index()
	{
		$this->post();	
	}

	function create_post_validation()
	{

	}

	function before_post_creation()
	{

	}	

	function after_post_creation($post_id)
	{

			if(get_settings('business_settings','publish_directly','Yes')=='Yes') {

				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_created_and_published').'</div>');
			}
			else {

				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_created_approval').'</div>');
			}
			redirect(site_url('edit-business/0/'.$post_id));
		
	}

	function update_post_validation()
	{

	}

	function before_post_update()
	{

	}	

	function after_post_update($post_id)
	{

	}

	public function new_ad($msg='')
	{


		$value = array();
		$value['categories'] = $this->post_model->get_all_categories();
		$value['msg']		 = $msg;
		$data['content'] 		= load_view('post_ad_view',$value,TRUE);		
		load_template($data,$this->active_theme);
	}

	public function create_ad()
	{
		$state_active = get_settings('business_settings', 'show_state_province', 'yes');

		$this->form_validation->set_rules('category[]', lang_key('category'), 'required');
		$this->form_validation->set_rules('phone_no', lang_key('phone'), 'required');
		$this->form_validation->set_rules('email', lang_key('email'), 'required');
		$this->form_validation->set_rules('country', 			lang_key('country'), 			'required');
		if($state_active == 'yes')
			$this->form_validation->set_rules('state', 			lang_key('state'), 				'required');
		$this->form_validation->set_rules('selected_city', 		lang_key('city'), 				'xss_clean');
		$this->form_validation->set_rules('city', 				lang_key('city'), 				'required');
		$this->form_validation->set_rules('zip_code', 			lang_key('zip_code'), 			'xss_clean');
		$this->form_validation->set_rules('latitude', 			lang_key('latitude'), 			'required');
		$this->form_validation->set_rules('longitude', 			lang_key('longitude'), 			'required');
		$this->form_validation->set_rules('title', 				lang_key('title'), 				'required');
		$this->form_validation->set_rules('address', 				lang_key('address'), 				'required');
		$this->form_validation->set_rules('description', 		lang_key('description'), 		'required');		
		$this->form_validation->set_rules('featured_img', 		lang_key('featured_img'), 		'required');
		$this->create_post_validation();
		if ($this->form_validation->run() == FALSE)
		{
			$msg = '<div class="alert alert-danger form-error">'.lang_key('ad_creation_error').'</div>';
			$this->new_ad($msg);	
		}
		else
		{
			$meta_search_text = '';		//meta information for simple searching

			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data 						= array();		
			$data['unique_id']			= uniqid();	


			//$data['category'] 			= $this->input->post('category');
			foreach($this->input->post('category') as $k) {
				$meta_search_text .= get_category_title_by_id($k) . ' ';
			}
		   //	$data['parent_category'] 	= get_category_parent_by_id($data['category']);
		   //	$meta_search_text .= get_category_title_by_id($data['parent_category']).' ';


			$data['phone_no'] 			= $this->input->post('phone_no');
			$data['email'] 				= $this->input->post('email');
			$data['website'] 			= $this->input->post('website');

			$data['founded'] 			= $this->input->post('founded');
			$meta_search_text .= $data['founded'].' ';

			$data['country'] 			= $this->input->post('country');
			$meta_search_text .= get_location_name_by_id($data['country']).' ';

			$data['state'] 				= $state_active == 'yes' ? $this->input->post('state') : 0;
			$meta_search_text .= get_location_name_by_id($data['state']).' ';

			$selected_city = $this->input->post('selected_city');
			$city = $this->input->post('city');
			if($selected_city == ''){
				$new_city_id = $this->post_model->get_location_id_by_name($city, 'city', $data['state'], $data['country']);
			}
			else{
				$new_city_id = $selected_city;
			}

			$data['city'] 				= $new_city_id;
			$meta_search_text .= get_location_name_by_id($data['city']).' ';

			$data['zip_code'] 			= $this->input->post('zip_code');
			$meta_search_text .= $data['zip_code'].' ';

			// $data['address'] 			= $this->input->post('address');
			// $meta_search_text .= $data['address'].' ';

			$data['latitude'] 			= $this->input->post('latitude');
			$data['longitude'] 			= $this->input->post('longitude');

			$this->load->model('admin/system_model');
            $langs = $this->system_model->get_all_langs();
            $titles = array();
            $descriptions = array();
            $addresses = array();
			
			$titles = $this->input->post('title');
			$addresses = $this->input->post('address');
			$meta_search_text .= $titles.' ';
			$meta_search_text .= $addresses.' ';
			
			$descriptions = $this->input->post('description');

			$slug =$this->slug->create_uri(array('title' => $this->input->post('title')));
			$data['slug'] 		= $slug;		
			//search	
			$meta_search_text	.=  $data['slug'].' ';

			$data['title'] 			= $titles;
			$data['description'] 	= $descriptions;
			$data['address'] 		= $addresses;

			//$data['tags'] 				=  implode(",",$this->input->post('tags'));

			$data['area_served'] 				=  implode(",",$this->input->post('area_served'));
			//$data['tags'] 				= $this->input->post('tags');

			//$meta_search_text		.=  $data['tags'].' ';

			$meta_search_text		.=  $data['area_served'].' ';

			$data['featured_img'] 		= $this->input->post('featured_img');


			$data['created_by']			= $this->session->userdata('user_id');
			$data['create_time'] 		= $time;
			$data['publish_time'] 		= $time;
			$data['last_update_time'] 	= $time;
			
			$publish_directly 			= get_settings('business_settings','publish_directly','Yes');
			$enable_pricing				= get_settings('package_settings','enable_pricing','Yes');
			
			/**************************
				status=0: post is deleted
				status=1: post is active
				status=2: post requires admin approval
				status=3: post requires payment
				status=4: post is expired	
			**************************/

			
			$data['status']	= ($publish_directly=='Yes')?1:2; // 2 = pending
			
			
			$data['featured'] 			= 0;
			$data['report'] 			= 0;
			$data['total_view'] 		= 0;
			$data['total_view'] 		= 0;
			$data['search_meta'] = $meta_search_text;

			$this->before_post_creation();

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$post_id = $this->post_model->insert_post($data);
				// inset category
				add_post_category($post_id,$this->input->post('category'));

				$this->after_post_creation($post_id);

				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('ad_created').'</div>');
			}
			redirect(site_url('list-business'));
		}
	}

	function checkpermission($id)
	{
		$post = $this->post_model->get_post_by_id($id);
		if($post->num_rows()>0)
		{

			$row = $post->row();

			if(is_admin())
				return TRUE;
			else if($this->session->userdata('user_id')==$row->created_by)
			{
				return TRUE;
			}
		}

		return FALSE;
	}
	/*

	public function editpost($page='0',$id='')
	{
		if(!$this->checkpermission($id))
		{
			$this->session->set_flashdata('<div class="alert alert-danger">'.lang_key('dont_have_permission').'</div>');
			redirect(site_url('admin/business/allposts'));
		}

		$value = array();
		$value['categories'] 	      = $this->post_model->get_all_categories();
		$value['post']			      = $this->post_model->get_post_by_id($id);
		$value['post_categories']	  = $this->post_model->get_categories_id_by_post_id($id);
		$value['page']			= $page;
		$data['content'] 		= load_view('edit_ad_view',$value,TRUE);
		load_template($data,$this->active_theme);
	}

	public function updatepost()
	{
		$state_active = get_settings('business_settings', 'show_state_province', 'yes');
		$id 	= $this->input->post('id');
		$page 	= $this->input->post('page');

		if(!$this->checkpermission($id))
		{
			$this->session->set_flashdata('<div class="alert alert-danger">'.lang_key('dont_have_permission').'</div>');
			redirect(site_url('admin/business/allposts'));
		}


		$this->form_validation->set_rules('category[]', lang_key('category'), 'required');
		$this->form_validation->set_rules('phone_no', lang_key('phone'), 'required');
		$this->form_validation->set_rules('email', lang_key('email'), 'required');


		$this->form_validation->set_rules('country', 			lang_key('country'), 			'required');
		if($state_active == 'yes')
			$this->form_validation->set_rules('state', 				lang_key('state'), 				'required');

		$this->form_validation->set_rules('selected_city', 		lang_key('city'), 				'xss_clean');
		$this->form_validation->set_rules('city', 				lang_key('city'), 				'required');
		$this->form_validation->set_rules('zip_code', 			lang_key('zip_code'), 			'xss_clean');
		$this->form_validation->set_rules('latitude', 			lang_key('latitude'), 			'required');
		$this->form_validation->set_rules('longitude', 			lang_key('longitude'), 			'required');

		$this->form_validation->set_rules('title', 				lang_key('title'), 				'required');
		$this->form_validation->set_rules('address', 			lang_key('address'), 		'required');
		$this->form_validation->set_rules('description', 		lang_key('description'), 		'required');

		$this->form_validation->set_rules('get_off', 		lang_key('get_off'), 		'numeric|xss_clean');

		$this->form_validation->set_rules('featured_img', 		lang_key('featured_img'), 		'required');
		$this->update_post_validation();



		if ($this->form_validation->run() == FALSE)
		{
			$this->editpost($page,$id);	
		}
		else
		{
			$meta_search_text = '';		//meta information for simple searching

			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data 						= array();		


			//$data['category'] 			= $this->input->post('category');
			foreach($this->input->post('category') as $k) {
				$meta_search_text .= get_category_title_by_id($k) . ' ';
			}

		//	$data['parent_category'] 	= get_category_parent_by_id($data['category']);
		//	$meta_search_text .= get_category_title_by_id($data['parent_category']).' ';
			

			$data['phone_no'] 			= $this->input->post('phone_no');
			$data['email'] 			= $this->input->post('email');
			$data['website'] 			= $this->input->post('website');

			$data['founded'] 			= $this->input->post('founded');
			$meta_search_text .= $data['founded'].' ';
			
			$data['country'] 			= $this->input->post('country');
			$meta_search_text .= get_location_name_by_id($data['country']).' ';

			$data['state'] 				= $state_active == 'yes' ? $this->input->post('state') : 0;
			$meta_search_text .= get_location_name_by_id($data['state']).' ';

			$selected_city = $this->input->post('selected_city');
			$city = $this->input->post('city');
			if($selected_city == ''){
				$new_city_id = $this->post_model->get_location_id_by_name($city, 'city', $data['state'], $data['country']);
			}
			else{
				$new_city_id = $selected_city;
			}

			$data['city'] 				= $new_city_id;
			$meta_search_text .= get_location_name_by_id($data['city']).' ';

			$data['zip_code'] 			= $this->input->post('zip_code');
			$meta_search_text .= $data['zip_code'].' ';

			// $data['address'] 			= $this->input->post('address');
			// $meta_search_text .= $data['address'].' ';

			$data['latitude'] 			= $this->input->post('latitude');
			$data['longitude'] 			= $this->input->post('longitude');


            $titles = array();
            $descriptions = array();
            $addresses = array();

			$titles = $this->input->post('title');
			$addresses = $this->input->post('address');
			$meta_search_text .= $titles.' ';
			$meta_search_text .= $addresses.' ';

			$descriptions = $this->input->post('description');


			$data['title'] 			= $titles;
			$data['description'] 	= $descriptions;
			$data['address'] 		= $addresses;
			//slug
			$data['slug'] = $this->slug->create_uri(array('title' =>  $this->input->post('title')), $id);
			
			$meta_search_text		.=  $data['slug'].' ';

			//$data['tags']           = implode(",",$this->input->post('tags'));
			$data['area_served'] 	=  implode(",",$this->input->post('area_served'));
			$data['coupon_code'] 	= $this->input->post('coupon_code');
			$data['get_off'] 		= $this->input->post('get_off');
			//$data['tags'] 				= $this->input->post('tags');
			//$meta_search_text		.=  $data['tags'].' ';
			$meta_search_text		.=  $data['area_served'].' ';

			$data['featured_img'] 		= $this->input->post('featured_img');
			//$data['video_url'] 			= $this->input->post('video_url');
			// insert data in gallery.
			if(($this->input->post('gallery')!=false)){				     				
				add_post_data($id,'gallery_img',$this->input->post('gallery'));				 
			}else{
				  // delete post data if already exist, and post empty.
				delete_post_data($id,'gallery_img',$this->input->post('gallery'));
			 }
			//$data['gallery'] 			= ($this->input->post('gallery')!=false)?json_encode($this->input->post('gallery')):'[]';

			if($this->input->post('assigned_to')!='')
			$data['created_by'] 		= $this->input->post('assigned_to');

			$opening_hours = array();
			$days = $this->input->post('days');
			$opening_times = $this->input->post('opening_hour');
			$closing_times = $this->input->post('closing_hour');
			foreach($days as $key=>$day)
			{
				$opening_hour = array();
				if ($opening_times[$key] == 'Closed')
				{
					$opening_hour['day'] = $day;
					$opening_hour['closed'] = 1;
					$opening_hour['start_time'] = '';
					$opening_hour['close_time'] = '';
				}
				else
				{
					$opening_hour['day'] = $day;
					$opening_hour['closed'] = 0;
					$opening_hour['start_time'] = $opening_times[$key];
					$opening_hour['close_time'] = $closing_times[$key];
				}
				array_push($opening_hours,$opening_hour);
			}			

			$data['opening_hour'] = json_encode($opening_hours);
			$data['additional_features'] = ($this->input->post('additional_features') != '') ? json_encode(array_filter($this->input->post('additional_features'))) : '[]';
			$data['last_update_time'] 	= $time;

			$data['search_meta'] = $meta_search_text;

			$this->before_post_update();

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$post_id = $id;
				$this->post_model->update_post($data,$id);
				add_post_meta($post_id,'bbb_profile',$_POST['bbb_profile']);
				add_post_meta($post_id,'yelp_profile',$_POST['yelp_profile']);
				add_post_meta($post_id,'facebook_profile',$_POST['facebook_profile']);
				add_post_meta($post_id,'twitter_profile',$_POST['twitter_profile']);
				add_post_meta($post_id,'angle_list_profile',$_POST['angle_list_profile']);
				add_post_meta($post_id,'linkedin_profile',$this->input->post('linkedin_profile'));
				add_post_meta($post_id,'googleplus_profile',$this->input->post('googleplus_profile'));
				add_post_meta($post_id,'ebay_profile',$this->input->post('ebay_profile'));
				//  upload logo
				//add_post_meta($post_id,'business_logo',$this->input->post('business_logo'));
				// update category.
				add_post_category($post_id,$this->input->post('category'));						
				
				$this->after_post_update($post_id);

				 $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_updated').'</div>');

			}

			redirect(site_url('edit-business/'.$page.'/'.$id));
		}
	}
*/
	public function uploadfeaturedfile()
    {

        $dir_name 					= 'images/';
        $config['upload_path'] 		= './uploads/'.$dir_name;
        $config['allowed_types'] 	= 'gif|jpg|png';
        $config['max_size'] 		= '5120';
        $config['min_width'] 		= '175';
        $config['min_height'] 		= '175';


        $this->load->library('upload', $config);

        $this->upload->display_errors('', '');

        if($this->upload->do_upload('photoimg'))
        {

            $data = $this->upload->data();
            $this->load->helper('date');
            $format = 'DATE_RFC822';
            $time = time();
            create_rectangle_thumb('./uploads/'.$dir_name.$data['file_name'],'./uploads/thumbs/');
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

    public function uploadlogofile()
    {

        $dir_name 					= 'logos/';
        $config['upload_path'] 		= './uploads/'.$dir_name;
        $config['allowed_types'] 	= 'gif|jpg|png';
        $config['max_size'] 		= '3320';
        // $config['min_width'] 		= '300';
        // $config['max_height'] 		= '70';

        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');

        if($this->upload->do_upload('photoimg'))
        {

            $data = $this->upload->data();
            $this->load->helper('date');
            $format = 'DATE_RFC822';
            $time = time();
            //create_rectangle_thumb('./uploads/'.$dir_name.$data['file_name'],'./uploads/thumbs/');
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

    public function uploadgalleryfile()
	{

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

    public function reportpost($post_id=''){

        $report_response = $this->post_model->report_post($post_id);

        if($report_response == 'TRUE'){
            echo 'TRUE';
        }
        else{
            echo 'FALSE';
        }

    }
	// add contact 	
	public function add_conversation()
	{ 
	    
		if(count($_POST) > 0){
			$value['users'] = $this->user_model->get_all_users_type_by_range('all',$this->session->userdata('user_id'),$this->input->post('search_value'));
		}else{		
			$value['users'] = $this->user_model->get_all_users_type_by_range('all',$this->session->userdata('user_id'));
		}
		//$value['friend_lists'] = $this->user_model->get_user_friend_list($this->session->userdata('user_id'));
		$value['alias']  = 'Add Contact';
		$data['content'] = load_view('user/add_conversation_view',$value,TRUE);		
		load_template($data,$this->active_theme,'user_template_view');
	}
	// user request.
	public function add_user_request()
	{
		$this->form_validation->set_rules('userID', '<b>User ID</b>', 'trim|required');
		if ($this->form_validation->run() == FALSE) {

			$arr['success'] = false;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . validation_errors() . '</div>';

		} else {
			
			if($this->user_model->check_user_conversation($this->session->userdata('user_id'),$this->input->post('userID')) == true){
				
				$data['user_one'] = $this->session->userdata('user_id');			
				$data['user_two'] = $this->input->post('userID');
				$data['status'] = 2;
				$this->load->helper('date');
				$format = 'DATE_RFC822';
				$time = time();
				$data['request_date'] = $time;
				
				 $this->user_model->insert_user_conversation_data($data);			
				
				$arr['success'] = true;
				$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your friend request sent ...</div>';
		
			}else{
			
			$arr['success'] = false;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>User Already in your list.</div>';
			}
			
		}
		
		echo json_encode($arr);
	}
     // respond user request.
	 function respond_user_request()
	 {
		 $this->form_validation->set_rules('userID', '<b>User ID</b>', 'trim|required');
		if ($this->form_validation->run() == FALSE) {

			$arr['success'] = false;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . validation_errors() . '</div>';

		} else {
			
			 $res = $this->user_model->check_user_respond($this->session->userdata('user_id'),$this->input->post('userID'));
			
			if($res->num_rows() > 0){
				
				
				$data['status'] = 1;
				$this->load->helper('date');
				$format = 'DATE_RFC822';
				$time = time();
				$data['confirmed_date'] = $time;
				
				 $this->user_model->update_user_conversation_data($data,$this->session->userdata('user_id'),$this->input->post('userID'));			
				
				$arr['success'] = true;
				$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Successfully added!</div>';
		
			}else{
			
			$arr['success'] = false;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Invalid Information.</div>';
			}
			
		}
		
		echo json_encode($arr);
		 
	 }
	 // delete  function respond_user_request()
	 function delete_user_request(){
		 $this->form_validation->set_rules('userID', '<b>User ID</b>', 'trim|required');
		if ($this->form_validation->run() == FALSE) {

			$arr['success'] = false;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . validation_errors() . '</div>';

		} else {
			
			 $res = $this->user_model->check_user_respond($this->session->userdata('user_id'),$this->input->post('userID'));
			
			if($res->num_rows() > 0){
				
				
				
				
				 $this->user_model->delete_user_conversation_data($this->session->userdata('user_id'),$this->input->post('userID'));			
				
				$arr['success'] = true;
				$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Successfully deleted!</div>';
		
			}else{
			
			$arr['success'] = false;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Invalid Information.</div>';
			}
			
		}
		
		echo json_encode($arr);
		 
	 }
	 
	 
	 // openchat box.
	function open_chat_box()
	{
		$user_one = $this->session->userdata('user_id');
		$user_two = $this->input->post('userID');	
		if($user_one!=$user_two)
		{
			$c_id = $this->user_model->creating_conversation($user_one,$user_two);
			if($c_id != 0){
				$arr['success'] = true;
				$arr['notif'] = '';
				$value['user_one'] = $user_one;
				$value['user_two'] = $user_two;
				$value['user_data'] = get_user_by_id($user_two);
				$value['c_id'] = $c_id;
				$value['conversation'] = $this->user_model->conversation($c_id);
				// update  un read messages.
				$frnd_list_msgs = get_friend_list_msg($this->session->userdata('user_id')); 
				 foreach ($frnd_list_msgs->result() as $row){	
				 $this->load->helper('date');
					$format = 'DATE_RFC822';
					$time = time();
					$data['read_date'] = $time;
					$data['read']=0;			
					$this->user_model->update_read($data,$row->id);	
				 }
				
				$arr['content'] = load_view('user/chat_box',$value,true);				
				echo json_encode($arr);
			}			 
		}
						
	}
	
	 // send message.
	 function send_user_message(){
		 
		 $this->form_validation->set_rules('c_id', '<b>User ID</b>', 'trim|required');
		if ($this->form_validation->run() == FALSE) {

			$arr['success'] = false;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . validation_errors() . '</div>';

		} else {
			$arr['success'] = true;
			
			//data
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			
			$data['date'] = $time;
			//
			$data['user_id_fk'] = $this->session->userdata('user_id');
			$data['c_id_fk'] = $this->input->post('c_id');
			$data['reply'] = $this->input->post('reply');
			
			$arr['insert_id'] = $this->user_model->insert_user_conversation_reply_data($data);		
			
			// for node js.
			
					
			
			//$q= mysqli_query("INSERT INTO user_conversation_reply (user_id_fk,reply,ip,time,c_id_fk) VALUES ('$uid','$reply','$ip','$time','$cid')") or die(mysqli_error());
		}
		
		echo json_encode($arr);
		}
	 

	// friend list.
	function friends_list()
	{
		
		//$value['friend_lists'] = $this->user_model->get_friend_list($this->session->userdata('user_id'));
		
		$value['alias']  = 'Friends List';
		$data['content'] = load_view('user/friends_list_view',$value,TRUE);		
		load_template($data,$this->active_theme,'user_template_view');
		
	}
	//get user 
	function get_user_request_data()
	{
		
		$userID = $this->input->post('user_id');	
		$arr['success'] = true;
		$arr['notif'] = '';		
		$value['user_data'] = get_user_by_id($userID);
		$arr['content'] = load_view('user/user_request_notify',$value,true);
		echo json_encode($arr);
			
	}
	//get_user_send_one_msg
	function get_user_send_one_msg()
	{		
		//
		$insert_id 			= $this->input->post('insert_id');
		$value['conversation'] = $this->user_model->conversation_reply_by_id($insert_id);
		//$value['user_data'] = get_user_by_id($this->input->post('userid_one'));
		$arr['content'] 	= load_view('user/get_user_send_one_msg',$value,true);
		echo json_encode($arr);
		
	}
	
	 public function header_notify()
	{
        $value[''] = '';		
        load_view('user/header_message_notify',$value);
    }
	// update  seen
	public function update_seen()
	{
		$unseen = count_friend_unseen_msg($this->session->userdata('user_id')); 
		foreach($unseen->result() as $row){
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			$data['seen_date'] = $time;
			$data['seen']=0;			
			$this->user_model->update_seen($data,$row->cr_id);						
		}
	}
	
	
	
	




}

/* End of file install.php */
/* Location: ./application/modules/user/controllers/user_core.php */