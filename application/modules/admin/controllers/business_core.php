<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * classified classified Controller
 *
 * This class handles only classified related functionality
 *
 * @package		Admin
 * @subpackage	business

 */

//require_once'translate.php';
class Business_core extends MX_Controller {

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
		$this->load->helper('text');
		$this->load->model('admin/business_model');
		$this->load->model('user/post_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		// unique slug.
		$config = array(
			'table' => 'post_data',
			'id' => 'id',
			'field' => 'slug',
			'title' => 'title',
			'replacement' => 'dash' // Either dash or underscore
		);
		$this->load->library('slug',$config);
	}

	#****************** post function start *********************#
	public function index()
	{
		if(is_admin())
		{
			redirect(site_url('admin/dashboard'));
		}
		else
		{
			redirect(site_url('admin/business/allposts'));
		}
	}

	public function allposts($start='0')
	{
		$value 				= array();
        $data['title'] 		= lang_key('all_posts');
		$data['content'] 	= load_admin_view('business/all_posts_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}

	public function allposts_ajax($start='0')
	{
		$value['posts']  	= $this->business_model->get_all_post_based_on_user_type($start,$this->per_page,'create_time','desc');
		$total  			= $this->business_model->get_all_post_based_on_user_type('total',$this->per_page,'create_time','desc');
		$value['pages']		= configPagination('admin/business/allposts_ajax',$total,5,$this->per_page);
		load_admin_view('business/all_posts_ajax_view',$value);
	}

	#delete a post
	public function deletepost($page='0',$id='',$confirmation='')
	{
		if(!is_admin() && !is_agent())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if($confirmation=='')
		{						
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/business/deletepost/'.$page)),TRUE);
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
					if(is_agent())
					{
						$post = $this->business_model->get_post_by_id($id);
						if($post->created_by != $this->session->userdata('user_id')){

							$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key('invalid_post_id').'</div>');
						}
						else
						{
							$this->business_model->delete_post_by_id($id);
							$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_deleted').'</div>');

						}

					}
					else
					{
						$this->business_model->delete_post_by_id($id);
						$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_deleted').'</div>');

					}
				}
			}
			redirect(site_url('admin/business/allposts/'.$page));
		}		
	}


	#feature a post
	public function featurepost($page='0',$id='',$confirmation='')
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
			$days = $this->input->post('no_of_days');

			if($days==FALSE || !((int)$days == $days && (int)$days > 0)) 
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">001 : Error occured!</div>');			
			}
			else 
			{

				$this->load->helper('date');
				$datestring = "%Y-%m-%d";
				$time = time();
				$request_date = mdate($datestring, $time);

				$activation_date = mdate($datestring, $time);
				$expiration_date  = strtotime('+'.$days.' days',$time);
				$expiration_date = mdate($datestring, $expiration_date);


				$data = array();
				$data['featured'] 		 			= 1;
				$data['featured_expiration_date'] 	= $expiration_date;

				$this->business_model->update_post_by_id($data,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_featured').'</div>');
			}

		}
		redirect(site_url('admin/business/allposts/'.$page));
	}


	public function renewfeatured($page='0',$id='')
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
			$days = $this->input->post('no_of_days');

			if($days==FALSE || !((int)$days == $days && (int)$days > 0)) 
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">001 : Error ocured!</div>');
			}
			else 
			{
				$this->load->model('user/post_model');

				if($this->post_model->increment_featured_date($days,$id)==TRUE)
					$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('feature_renewed').'</div>');
				else
					$this->session->set_flashdata('msg','<div class="alert alert-danger">002 : Error ocured!.</div>');
			}

		}
		redirect(site_url('admin/business/allposts/'.$page));
	}

	#unfeature a post
	public function removefeaturepost($page='0',$id='',$confirmation='')
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

			$data = array();
			$data['featured']	= 0;
			$data['featured_expiration_date'] = null;
			$this->business_model->update_post_by_id($data,$id);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_feature_removed').'</div>');
		}
		redirect(site_url('admin/business/allposts/'.$page));
	}

	#approve a post
	public function approvepost($page='0',$id='',$confirmation='')
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
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data = array();

			$data['publish_time'] 		= $time;
			$data['last_update_time'] 	= $time;
			$data['status'] 			= 1;

			$this->business_model->update_post_by_id($data,$id);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_approved').'</div>');
		}
		redirect(site_url('admin/business/allposts/'.$page));
	}


	#****************** post functions end *********************#
	public function choosefeaturepackage($feature_post_id)
	{

		$this->session->set_userdata('feature_post_id',$feature_post_id);
		$value = array();
		$this->load->model('admin/package_model');
		$value['packages']		= $this->package_model->get_all_packages_by_type('featured_package');
		$data['content'] 		= load_admin_view('packages/choose_feature_package_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	public function choosefeaturepackagerenew($feature_post_id)
	{
		$this->session->set_userdata('feature_post_id',$feature_post_id);
		$this->session->set_userdata('feature_post_type','renew');
		$value = array();
		$this->load->model('admin/package_model');
		$value['packages']		= $this->package_model->get_all_packages_by_type('featured_package');
		$data['content'] 		= load_admin_view('packages/choose_feature_package_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	public function featurepayment($page='0',$id='')
	{

		$this->load->helper('date');
		$datestring = "%Y-%m-%d";
		$time = time();

		$request_date = mdate($datestring, $time);
		$package_id		= $this->input->post('package_id');
		$this->load->model('admin/package_model');
		$package 		= $this->package_model->get_package_by_id($package_id);

		$post_id = $this->session->userdata('feature_post_id');

		if($post_id==FALSE) 
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger">'.lang_key('invalid_post').'</div>');
			redirect(site_url('admin/business/allposts'));
		}



		$payment_data 					= array(); 
		$payment_data['unique_id'] 		= uniqid();
		$payment_data['post_id']		= $post_id;
		$payment_data['package_id'] 	= $package_id;
		$payment_data['amount'] 		= $package->price;
		$payment_data['request_date'] 	= $request_date;
		$payment_data['is_active'] 		= 2; #pending
		$payment_data['status'] 		= 1; #active

		if($this->session->userdata('feature_post_type')=='renew')
			$payment_data['payment_type'] 	= 'feature_renew';
		else
			$payment_data['payment_type'] 	= 'feature';

		$payment_data['payment_medium']	= 'paypal';

		$this->load->model('user/payment_model');
		$unique_id = $this->payment_model->insert_property_payment_data($payment_data);

		$this->session->set_userdata('invoice_id',$unique_id);
		$this->session->set_userdata('amount',$package->price);

		$value['package'] = $package;
		if($this->session->userdata('feature_post_type')=='renew')
			$value['renew'] = 'renew';

		$value['unique_id'] = $payment_data['unique_id'];

		if($value['package']->price<=0)
		{

			$activation_date = mdate($datestring, $time);
			$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);
			$expirtion_date = mdate($datestring, $expirtion_date);

			$data = array();
			$data['is_active'] 		 	= 1;
			$data['activation_date'] 	= $activation_date;
			$data['expiration_date'] 	= $expirtion_date;
			$data['response_log']		= 'Success with free featured package';

			$this->payment_model->update_post_payment_data_by_unique_id($data,$unique_id);
			$this->load->model('user/post_model');

			if(isset($value['renew']) && $value['renew']=='renew') 
			{

				if($this->post_model->increment_featured_date($package->expiration_time,$post_id)==TRUE)
					$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('feature_renewed').'</div>');
				else
					$this->session->set_flashdata('msg','<div class="alert alert-danger">Error! Feature not renewed.</div>');

			}
			else 
			{
				$data = array();
				$data['featured_expiration_date'] 	= $expirtion_date;
				$data['featured']					= 1;
				$this->post_model->update_post($data,$post_id);
				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_featured').'</div>');
			}

			$this->session->unset_userdata('feature_post_id');
			$this->session->unset_userdata('feature_post_type');
			redirect(site_url('admin/business/allposts'));
		}
		else
		{
			$email_info = array();
			$email_info['user_name'] = $this->session->userdata('user_name');
			$email_info['user_email'] = $this->session->userdata('user_email');
			if(isset($value['renew']) && $value['renew']=='renew')
				$email_info['link'] = site_url('admin/business/resume_feature_payment/'.'u_id='.$unique_id.'+renew=renew');
			else
				$email_info['link'] = site_url('admin/business/resume_feature_payment/'.'u_id='.$unique_id);
			
			send_payment_confirmation_email($email_info);

			$data['content'] 		= load_admin_view('packages/feature_payment_confirmation_view',$value,TRUE);
			load_admin_view('template/template_view',$data);
		}	
	}

	public function resume_feature_payment($string) {

		$string = rawurldecode($string);
    	$data = array();
    	$values = explode("+",$string);

    	foreach ($values as $value) 
    	{
    		$get 	= explode("=",$value);
    		$s 		= (isset($get[1]))?$get[1]:'';
    		$val 	= explode(",",$s);

    		if(count($val)>1)
    		{
	    		$data[$get[0]] = $val;
    		}
    		else
	    		$data[$get[0]] = (isset($get[1]))?$get[1]:'';
    	}
    	if(is_array($data) && isset($data['u_id']) && $data['u_id']!='') {
    		$value = array();
    		$value['unique_id'] = $data['u_id'];
    		
	    	$this->load->model('user/payment_model');
	    	$payment_data = $this->payment_model->get_post_payment_data_by_unique_id($data['u_id']);
	    	if($payment_data->num_rows()>0){
	    		
		    	$this->load->model('admin/package_model');
				$package = $this->package_model->get_package_by_id($payment_data->row()->package_id);
				$value['package'] = $package;
				if(isset($data['renew']) && $data['renew']=='renew')
					$value['renew'] = 'renew';
				
				$data['content'] 		= load_admin_view('packages/feature_payment_confirmation_view',$value,TRUE);
				load_admin_view('template/template_view',$data);
	    	}
	    	else {
	    		$this->session->set_flashdata('msg','<div class="alert alert-danger">Error! Invalid URL!</div>');
	    		$data['content'] 	= load_view('msg_view','',TRUE,$this->active_theme);
	    		load_template($data,$this->active_theme);
	    	}
    	}
    	else {
    		$this->session->set_flashdata('msg','<div class="alert alert-danger">Error! Invalid URL!</div>');
    		$data['content'] 	= load_view('msg_view','',TRUE,$this->active_theme);
    		load_template($data,$this->active_theme);
    	}

	}


	#********************Email function start**********************#
	public function claimedposts($start='0')
	{
		$value['posts']  	= $this->business_model->get_all_claim_emails_admin($start,$this->per_page);
		$total 				= $this->business_model->get_all_claim_emails_admin('total');

		$value['pages']		= configPagination('admin/business/claimedposts',$total,5,$this->per_page);
		$value['start']     = $start;
        $data['title'] 		= lang_key('claimed_business');
		$data['content'] 	= load_admin_view('business/all_claimed_email_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}


	public function emailtracker($start='0')
	{

		$value['posts']  	= $this->business_model->get_all_emails_admin($start,$this->per_page);
		$total 				= $this->business_model->get_all_emails_admin('total');

		$value['pages']		= configPagination('admin/business/emailtracker',$total,5,$this->per_page);
		$value['start']     = $start;
        $data['title'] 		= lang_key('email_tracker');
		$data['content'] 	= load_admin_view('business/all_emails_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}


	public function bulkemailform()
	{

		$value['posts']  	= $this->business_model->get_all_emails_admin('all',$this->per_page);
		$total 				= $this->business_model->get_all_emails_admin('total');

		$data['title'] 		= lang_key('bulk_email');
		$data['content'] 	= load_admin_view('business/bulk_email_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	public function sendbulkemail($agent_id='0')
	{

		$this->form_validation->set_rules('to', 'To', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->bulkemailform();	
		}
		else
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$to 		= (isset($_POST['to']) && is_array($_POST['to']))?$_POST['to']:array();
				$subject 	= $this->input->post('subject');
				$message 	= $this->input->post('message');
				
				$this->load->library('email');
				$config['mailtype'] = "html";
				$config['charset'] 	= "utf-8";
				$this->email->initialize($config);

				$this->email->from($this->session->userdata('user_email'),$this->session->userdata('user_name'));
				$this->email->to($to);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('email_sent').'</div>');
			}
			redirect(site_url('admin/business/bulkemailform'));
		}
	}
	#****************** email function end **********************#

	#****************** location function start **********************#
	public function locations($start='0')
	{
        $data['title'] 		= lang_key('all_locations');
        $value['posts'] 	= $this->business_model->get_all_locations($start,10);
        $total 				= $this->business_model->get_all_locations('total',$this->per_page);
        $value['pages']		= configPagination('admin/business/locations',$total,5,$this->per_page);

        $data['content'] 	= load_admin_view('business/all_locations_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}

	public function newlocation($type='country')
	{
		$value['type'] 		= $type;
		$value['countries'] = $this->business_model->get_locations_by_type('country');
		$value['states'] 	= $this->business_model->get_locations_by_type('state');
		load_admin_view('business/new_location_view',$value);
	}

	public function savelocation()
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->form_validation->set_rules('type', 'Type', 'required');
		$type = $this->input->post('type');

		if($type=='state' || $type=='city')
		$this->form_validation->set_rules('country', 'Country', 'required');

		$state_active = get_settings('business_settings', 'show_state_province', 'yes');
		if($type=='city')
		{
			$this->form_validation->set_rules('country', 'Country', 'required');
			if($state_active == 'yes')
			{
				$this->form_validation->set_rules('state', 'State', 'required');
			}

		}
		$this->form_validation->set_rules('locations', 'Names', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->newlocation($type);	
		}
		else
		{

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$locations = $this->input->post('locations');
				$locations_array = explode(',',$locations);
				if($type=='country')
				{
					$parent = 0;
					$parent_country = 0;
				}
				elseif($type=='state')
				{
					$parent = $this->input->post('country');
					$parent_country = $this->input->post('country');
				}
				elseif($type=='city')
				{
					if($state_active == 'yes'){
						$parent = $this->input->post('state');
					}
					else{
						$parent = $this->input->post('country');
					}
					$parent_country = $this->input->post('country');
				}

				foreach ($locations_array as $location)
				{
					$data = array();			
					$data['name'] 	= $location;
					$data['type'] 	= $type;
					$data['parent'] = $parent;
					$data['parent_country'] = $parent_country;
					$data['status']	= 1;
					$this->business_model->insert_location($data);
				}
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_inserted').'</div>');
			}
			redirect(site_url('admin/business/newlocation'));
		}
	}

	public function editlocation($type='country',$id='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$value['type'] = $type;
		$value['editlocation'] 	= $this->business_model->get_location_by_id($id);
		$value['countries'] 	= $this->business_model->get_locations_by_type('country');
		$value['states'] 		= $this->business_model->get_locations_by_type('state');
		load_admin_view('business/edit_location_view',$value);
	}

	public function updatelocation()
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->form_validation->set_rules('type', 'Type', 'required');
		$id 	= $this->input->post('id');
		$type   = $this->input->post('type');

		if($type=='state' || $type=='city')
		$this->form_validation->set_rules('country', 'Country', 'required');

		$state_active = get_settings('business_settings', 'show_state_province', 'yes');
		if($type=='city')
		{
			$this->form_validation->set_rules('country', 'Country', 'required');
			if($state_active == 'yes')
			{
				$this->form_validation->set_rules('state', 'State', 'required');				
			}
		}

		$this->form_validation->set_rules('location', 'Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->editlocation($type,$id);	
		}
		else
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{

				if($type=='country')
				{
					$parent = 0;
					$parent_country = 0;
				}
				elseif($type=='state')
				{
					$parent = $this->input->post('country');
					$parent_country = $this->input->post('country');
				}
				elseif($type=='city')
				{
					if($state_active == 'yes'){
						$parent = $this->input->post('state');
					}
					else{
						$parent = $this->input->post('country');
					}
					$parent_country = $this->input->post('country');
				}

				$data = array();			
				$data['name'] 	= $this->input->post('location');
				$data['type'] 	= $type;
				$data['parent'] = $parent;
				$data['status']	= 1;
				$this->business_model->update_location($data,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/business/editlocation/'.$type.'/'.$id));
		}
	}

	#delete a location
	public function deletelocation($page='0',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/business/deletelocation/'.$page)),TRUE);
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
					$this->business_model->delete_location_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_deleted').'</div>');
				}
			}
			redirect(site_url('admin/business/locations/'.$page));
		}		
	}
	#****************** location function end **********************#

	#****************** settings function start **********************#
	#load site settings , settings are saved as json data

	public function businesssettings($key='business_settings')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('admin/system_model');
		$this->load->model('options_model');

		$settings = $this->options_model->getvalues($key);
		$settings = json_encode($settings);		
		$value['settings'] 	= $settings;
	    $data['title'] 		= lang_key('business_directory_settings');
        $data['content']  	= load_admin_view('business/settings_view',$value,TRUE);
		load_admin_view('template/template_view',$data);			
	}

	#save site settings
	public function savebusinesssettings($key='business_settings')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('admin/system_model');
		$this->load->model('options_model');

		foreach($_POST as $k=>$value)
		{
			$rules = $this->input->post($k.'_rules');
			if($rules!='')
			$this->form_validation->set_rules($k,$k,$rules);
		}

		if ($this->form_validation->run() == FALSE)
		{
			$this->businesssettings($key);
		}
		else
		{	
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$data['values'] 	= json_encode($_POST);		
				$res = $this->options_model->getvalues($key);

				if($res=='')
				{
					$data['key']	= $key;			
					$this->options_model->addvalues($data);
				}
				else
					$this->options_model->updatevalues($key,$data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/business/businesssettings/'.$key));
		}			
	}

	#load site settings , settings are saved as json data
	public function paypalsettings($key='paypal_settings')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('admin/system_model');
		$this->load->model('options_model');

		$settings = $this->options_model->getvalues($key);
		$settings = json_encode($settings);		
		$value['settings'] 	= $settings;
	    $data['title'] 		= lang_key('paypal_settings');
        $data['content']  	= load_admin_view('business/paypalsettings_view',$value,TRUE);
		load_admin_view('template/template_view',$data);			
	}

	#save site settings
	public function savepaypalsettings($key='paypal_settings')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('admin/system_model');
		$this->load->model('options_model');

		foreach($_POST as $k=>$value)
		{
			$rules = $this->input->post($k.'_rules');
			if($rules!='')
			$this->form_validation->set_rules($k,$k,$rules);
		}

		if ($this->form_validation->run() == FALSE)
		{
			$this->paypalsettings($key);	
		}
		else
		{	
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$data['values'] 	= json_encode($_POST);		
				$res = $this->options_model->getvalues($key);

				if($res=='')
				{
					$data['key']	= $key;			
					$this->options_model->addvalues($data);
				}
				else
					$this->options_model->updatevalues($key,$data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/business/paypalsettings/'.$key));
		}			
	}

	#****************** settings function end **********************#
	public function bannersettings()
	{
		$data['title'] 		= lang_key('banner_settings');
		$data['content'] 	= load_admin_view('business/banner_settings_view','',TRUE);
		load_admin_view('template/template_view',$data);
	}

	public function savebannersettings($key='banner_settings')
	{
		$this->form_validation->set_rules('banner_type', lang_key('banner_type'), 'required');
		$this->form_validation->set_rules('search_bg', lang_key('bg_image'), 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->bannersettings();
		}
		else
		{
			$data = array();
			$data['top_bar_bg_color'] 		= $this->input->post('top_bar_bg_color');
			$data['menu_bg_color'] 			= $this->input->post('menu_bg_color');
			$data['menu_text_color'] 		= $this->input->post('menu_text_color');
			$data['active_menu_text_color'] = $this->input->post('active_menu_text_color');
			$data['banner_type'] 			= $this->input->post('banner_type');
			$data['search_panel_bg_color'] 	= $this->input->post('search_panel_bg_color');
			$data['show_bg_image'] 			= $this->input->post('show_bg_image');
			$data['search_bg'] 				= $this->input->post('search_bg');
			$data['map_latitude'] 				= $this->input->post('map_latitude');
			$data['map_longitude'] 				= $this->input->post('map_longitude');
			$data['map_zoom'] 				= $this->input->post('map_zoom');

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				add_option('banner_settings',json_encode($data));
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('settings_updated').'</div>');
			}
			redirect(site_url('admin/business/bannersettings'));
		}
	}

	public function searchbguploader()
	{
		load_admin_view('business/searchbg_uploader_view');
	}

	public function uploadsearchbgfile()
	{
		$config['upload_path'] = './uploads/banner/';
		$config['allowed_types'] = 'gif|jpg|JPG|png';
		$config['max_size'] = '5120';
		$config['min_width'] = '1024';
		$config['min_height'] = '600';

		$this->load->library('upload', $config);
		$this->upload->display_errors('', '');
		if($this->upload->do_upload('photoimg'))
		{
			$data = $this->upload->data();
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/banner/'.$data['file_name'];
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

	public function payments($start=0)
	{
		if(!is_admin()) 
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$value['trans']  	= $this->business_model->get_all_transaction();
        $data['title'] 		= lang_key('payment_history');
		$data['content'] 	= load_admin_view('business/approve_payment_view',$value,TRUE);
		load_admin_view('template/template_view',$data);

	}

	public function approveposttransaction($unique_id) 
	{
		if(!is_admin()) 
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			$value['trans']  	= $this->business_model->get_all_transaction();
	        $data['title'] 		= lang_key('transaction');

			$data['content'] 	= load_admin_view('business/approve_payment_view',$value,TRUE);
			load_admin_view('template/template_view',$data);
		}
		else 
		{
			$this->load->model('user/payment_model');
			$order = $this->payment_model->get_post_payment_data_by_unique_id($unique_id);
			if($order->num_rows()>0) 
			{
				$order 		= $order->row();
		    	$order_id 	= $order->id;
		    	$post_id 	= $order->post_id;

		    	$this->load->model('admin/package_model');
		    	$package 	= $this->package_model->get_package_by_id($order->package_id);

		    	$this->load->helper('date');
    			$datestring = "%Y-%m-%d";
				$time = time();
				$activation_date = mdate($datestring, $time);
				$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);
    			$expirtion_date = mdate($datestring, $expirtion_date);

    			$data = array();
    			$data['is_active'] 		 	= 1;
    			$data['activation_date'] 	= $activation_date;
    			$data['expiration_date'] 	= $expirtion_date;
    			$data['response_log']		= 'Approved by admin';
    			$this->payment_model->update_post_payment_data_by_unique_id($data,$unique_id);

    			$data = array();
    			$data['expirtion_date']		= $expirtion_date;
    			$data['activation_date'] 	= $activation_date;
    			$data['last_update_time'] 	= $time;
    			$data['status'] 			= 1;

    			$this->load->model('admin/business_model');
    			$this->business_model->update_post_by_id($data,$post_id);

    			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('payment_approved').'</div>');
			}
			else 
			{
    			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Error!</div>');
			}

			$value['trans']  	= $this->business_model->get_all_transaction();
	        $data['title'] 		= lang_key('transaction');

			$data['content'] 	= load_admin_view('business/approve_payment_view',$value,TRUE);
			load_admin_view('template/template_view',$data);
		}
	}

	public function approvefeaturetransaction($unique_id) 
	{
		if(!is_admin()) 
		{
			echo lang_key('dont_have_permission');
			die;
		}
		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			$value['trans']  	= $this->business_model->get_all_transaction();
	        $data['title'] 		= lang_key('transaction');

			$data['content'] 	= load_admin_view('business/approve_payment_view',$value,TRUE);
			load_admin_view('template/template_view',$data);
		}
		else 
		{
			$this->load->model('user/payment_model');
			$order = $this->payment_model->get_post_payment_data_by_unique_id($unique_id);
			if($order->num_rows()>0)
			{
				$order 		= $order->row();
		    	$order_id 	= $order->id;
		    	$post_id 	= $order->post_id;

		    	$this->load->model('admin/package_model');
		    	$package 	= $this->package_model->get_package_by_id($order->package_id);

		    	$this->load->helper('date');
    			$datestring = "%Y-%m-%d";
				$time = time();
				$activation_date = mdate($datestring, $time);
				$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);
    			$expirtion_date = mdate($datestring, $expirtion_date);

    			$data = array();
    			$data['is_active'] 		 	= 1;
    			$data['activation_date'] 	= $activation_date;
    			$data['expiration_date'] 	= $expirtion_date;
    			$data['response_log']		= 'Approved by admin';
    			$this->payment_model->update_post_payment_data_by_unique_id($data,$unique_id);

    			$this->load->model('user/post_model');

    			$data = array();
    			$data['featured_expiration_date'] 	= $expirtion_date;
    			$data['featured']					= 1;
    			$this->post_model->update_post($data,$post_id);

    			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('payment_approved').'</div>');
			}
			else 
			{
    			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Error!</div>');
			}

			$value['trans']  	= $this->business_model->get_all_transaction();
	        $data['title'] 		= lang_key('transaction');

			$data['content'] 	= load_admin_view('business/approve_payment_view',$value,TRUE);
			load_admin_view('template/template_view',$data);
		}
	}

	public function approvefeaturerenewtransaction($unique_id) 
	{
		if(!is_admin()) 
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			$value['trans']  	= $this->business_model->get_all_transaction();
	        $data['title'] 		= lang_key('transaction');

			$data['content'] 	= load_admin_view('business/approve_payment_view',$value,TRUE);
			load_admin_view('template/template_view',$data);
		}
		else 
		{
			$this->load->model('user/payment_model');
			$order = $this->payment_model->get_post_payment_data_by_unique_id($unique_id);
			if($order->num_rows()>0) 
			{
				$order 		= $order->row();
		    	$order_id 	= $order->id;
		    	$post_id 	= $order->post_id;

		    	$this->load->model('admin/package_model');
		    	$package 	= $this->package_model->get_package_by_id($order->package_id);

		    	$this->load->helper('date');
    			$datestring = "%Y-%m-%d";
				$time = time();
				$activation_date = mdate($datestring, $time);
				$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);
    			$expirtion_date = mdate($datestring, $expirtion_date);

    			$data = array();
    			$data['is_active'] 		 	= 1;
    			$data['activation_date'] 	= $activation_date;
    			$data['expiration_date'] 	= $expirtion_date;
    			$data['response_log']		= 'Approved by admin';
    			$this->payment_model->update_post_payment_data_by_unique_id($data,$unique_id);

    			$this->load->model('user/post_model');

    			if($this->post_model->increment_featured_date($package->expiration_time,$post_id)==TRUE)
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('payment_approved').'</div>');
				else
					$this->session->set_flashdata('msg','<div class="alert alert-danger">Error!</div>');
			}
			else 
			{
    			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Error!</div>');
			}

			$value['trans']  	= $this->business_model->get_all_transaction();
	        $data['title'] 		= lang_key('transaction');

			$data['content'] 	= load_admin_view('business/approve_payment_view',$value,TRUE);
			load_admin_view('template/template_view',$data);
		}
	}

	public function deletetransaction($unique_id,$confirmation='') 
	{
		if(!is_admin()) 
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$unique_id,'url'=>site_url('admin/business/deletetransaction/')),TRUE);
			load_admin_view('template/template_view',$data);
		}
		else if($confirmation=='yes') 
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->business_model->delete_transaction($unique_id);
		        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('transaction_deleted').'</div>');
			}

			$value['trans']  	= $this->business_model->get_all_transaction();
	        $data['title'] 		= lang_key('transaction');

			$data['content'] 	= load_admin_view('business/approve_payment_view',$value,TRUE);
			load_admin_view('template/template_view',$data);
		}
	}

	public function view_all_reviews($page='0',$post_id='')
	{
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($post_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}

		$value['post_id']	= $post_id;
		$value['reviews']  	= $this->business_model->get_all_reviews_based_on_post($post_id);
		$data['title'] 		= lang_key('all_reviews');

		$data['content'] 	= load_admin_view('business/all_reviews_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	#delete a post
	public function deletereview($page='0',$post_id='',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($post_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/business/deletereview/'.$page.'/'.$post_id)),TRUE);
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
					
					$this->business_model->delete_review_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('review_deleted').'</div>');

					
				}
			}
			redirect(site_url('admin/business/view_all_reviews/'.$page.'/'.$post_id));
		}		
	}

    public function translate_title_description_ajax(){
        /*during creating property*/
        $title = $this->input->post('title');
        $desc = $this->input->post('desc');
        $lang = $this->input->post('lang');
        $lang = trim($lang);
        $translator = new Translate();
        $translator->setLangFrom($lang);
        $array = array();
        $this->load->model('system_model');
        $value['result'] = $this->system_model->get_all_langs();

        foreach($value['result'] as $va=>$long_name){

            if($va!=$lang){
                $title1='';
                $description1 = '';
                $translator->setLangTo($va);
                $title1 =  $translator->mm_translate($title);
                $description1 = $translator->mm_translate($desc);
                array_push($array,array('lang'=>$va,'title'=>$title1,'description'=>$description1));
            }
        }
        echo json_encode($array);
    }

    public function reportedpost($start='0')
    {
        $value 				= array();
        $data['title'] 		= lang_key('reported_post');
        $data['content'] 	= load_admin_view('business/all_reported_posts_view',$value,TRUE);
        load_admin_view('template/template_view',$data);
    }

    public function allreported_posts_ajax($start='0')
    {
        $value['posts']  	= $this->business_model->get_all_reported_post_based_on_user_type($start,$this->per_page,'create_time','desc');
        $total  			= $this->business_model->get_all_reported_post_based_on_user_type('total',$this->per_page,'create_time','desc');
        $value['pages']		= configPagination('admin/business/allreported_posts_ajax',$total,5,$this->per_page);
        load_admin_view('business/all_reported_posts_ajax_view',$value);
    }

	public function migrate_address()
	{
		$option = get_option('migrate_1_3');
		if(isset($option['error']))
		{

			$this->load->database();

			$sql = "ALTER TABLE `".$this->db->dbprefix('categories')."` ADD `parent` INT(11) NOT NULL DEFAULT '0' AFTER `id`;";
			$this->db->query($sql);
			
			$sql = "ALTER TABLE `".$this->db->dbprefix('posts')."` ADD `parent_category` INT(11) NOT NULL DEFAULT '0' AFTER `category`;";
			$this->db->query($sql);

			$sql ="update `".$this->db->dbprefix('posts')."` set parent_category=category;";
			$this->db->query($sql);

			$sql = "ALTER TABLE `".$this->db->dbprefix('posts')."` CHANGE `address` `address` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;";
			$this->db->query($sql);

			$query = $this->db->get('posts');
			
			$this->load->model('admin/system_model');
	        $langs = $this->system_model->get_all_langs();

	        $default_lang =  default_lang();


	        $flag = 1;
			foreach($query->result() as $row)
			{
				$add = array();

				foreach ($langs as $lang=>$full_name) 
				{
					$add[$lang] = '';
				}

				$add[$default_lang] = $row->address;

				$this->db->update('posts',array('address'=>json_encode($add)),array('id'=>$row->id));
				echo 'Done row : '.$flag.'<br/>';
				$flag++;
			}

			echo '<h4>Complete</h4>';
			add_option('migrate_1_3','yes');

		}
		else
			echo '<h4>Already migrated</h4>';

	}
	
	// blog.
	
	public function blog_manage($business_id='',$id='')
	{
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($business_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}
				
		$values 			= array();
		$values['title'] 	= 'New Blog';
		if($business_id!=''){
			$values['business_id']  = $business_id;
		}
		if($id!='')
		{
			
			$values['id']  		= $id;
			$values['title']  		= 'Update Blog';
			$values['action_type']  = 'update';
			$values['blog']    = get_post_data($business_id,'blog');			
		}

        $data['content'] = load_admin_view('business/blog/blog_view',$values,TRUE);
		load_admin_view('template/template_view',$data);			
	}
	public function add_blog($business_id='',$id='')
	{
		$business_id = $this->input->post('business_id');
		
		//check permission.
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($business_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}
		 
		
		$this->form_validation->set_rules('title', lang_key('title'), 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			if($this->input->post('action_type')=='update')
				$this->blog_manage($this->input->post('business_id'),$this->input->post('id'));
			else
				$this->blog_manage($this->input->post('business_id'));	
		}
		else
		{
			$data = array();
			$data['key'] =  'blog';
			$data['value'] = $this->input->post('featured_img');	
			$data['title'] = $this->input->post('title');		
			
			$data['description'] = $this->input->post('description');
			$data['create_time'] = time();
			$data['post_id'] = $this->input->post('business_id');
			

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				if($this->input->post('action_type')=='update')
				{
					$id = $this->input->post('id');
					// update slug.
					$data['slug'] = $this->slug->create_uri(array('title' =>  $this->input->post('title')), $id);
					
					update_post_data_gen($id,$data);	
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Blog Updated</div>');
				}else{								
					// blog slug.
					$slug =$this->slug->create_uri(array('title' => $this->input->post('title')));
					$data['slug'] 			= $slug;
					// insert.					
					$id = add_post_data_gen($data);	
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Blog Created</div>');
				}				
			}	

			redirect(site_url('admin/business/blog_manage/'.$business_id.'/'.$id));		
		}

	}
	public function view_all_blogs($page='0',$post_id='')
	{
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($post_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}

		$value['post_id']	= $post_id;
		$value['blogs']  	= $this->business_model->get_all_blogs_based_on_post($post_id);
		$data['title'] 		= lang_key('all_reviews');
		$data['content'] 	= load_admin_view('business/blog/all_blogs_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}
		// delete video
	public function deleteblog($page='0',$post_id='',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($post_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/business/deleteblog/'.$page.'/'.$post_id)),TRUE);
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
					delete_post_data_gen($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Video Deleted</div>');

					
				}
			}
			redirect(site_url('admin/business/view_all_blogs/'.$page.'/'.$post_id));
		}		
	}
	
	public function featuredimguploader()

	{

		 load_admin_view('business/blog/featured_img_uploader_view');

	}

	public function uploadblogfeaturedfile()
	{
		$dir_name 					= 'business/blog/';
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
	public function view_all_video($page='0',$post_id='')	
	{
		
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($post_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}

		$value['post_id']	= $post_id;
		$value['blogs']  	= get_post_data($post_id,'video_url');
		$data['title'] 		= 'All Video';
		$data['content'] 	= load_admin_view('business/all_videos_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
		
	}
	
	public function add_video($currentpage='',$business_id='',$id='')
	{ 
	    $business_id = $this->input->post('business_id');
		
		//check permisssion	
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($business_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}
	
		
		$currentpage = $this->input->post('current_page');
		$this->form_validation->set_rules('video_url', 'Video URL', 'required');		
		
		if ($this->form_validation->run() == FALSE)
		{
			if($this->input->post('action_type')=='update')
				$this->manage_video($currentpage,$this->input->post('business_id'),$this->input->post('id'));
			else
				$this->manage_video($currentpage,$this->input->post('business_id'));	
		}else{
			$data = array();
			$data['key'] =  'video_url';			
			$data['value'] = $this->input->post('video_url');
			$data['title'] = $this->input->post('title');
			$data['create_time'] = time();
			$data['post_id'] = $this->input->post('business_id');
			

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				if($this->input->post('action_type')=='update')
				{
					$id = $this->input->post('id');
					update_post_data_gen($id,$data);	
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Video updated</div>');
				}else{													
					$id = add_post_data_gen($data);	
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Video Created</div>');
				}				
			}	

			redirect(site_url('admin/business/manage_video/'.$currentpage.'/'.$business_id.'/'.$id));		
		}

	}
	public function manage_video($currentpage='',$business_id='',$id='')
	{
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($business_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}
					 
		$values 			= array();
		$values['title'] 	= 'New Video';
		if($business_id!=''){
			$values['business_id']  = $business_id;
		}
		if($id!='')
		{			
			$values['id']  		= $id;
			$values['title']  		= 'Update Blog';
			$values['action_type']  = 'update';
			$values['video']    = get_post_data($business_id,'video_url');			
		}
        $data['content'] = load_admin_view('business/video_view',$values,TRUE);
		load_admin_view('template/template_view',$data);			
	}
	// delete video
	public function deletevideo($page='0',$post_id='',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($post_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/business/deletevideo/'.$page.'/'.$post_id)),TRUE);
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
					delete_post_data_gen($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Video Deleted</div>');

					
				}
			}
			redirect(site_url('admin/business/view_all_video/'.$page.'/'.$post_id));
		}		
	}
	
	// edit post.
	
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
		$data['content'] 		= load_admin_view('business/edit_ad_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
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
		//$this->update_post_validation();



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

			//$this->before_post_update();

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
				add_post_meta($post_id,'business_logo',$this->input->post('business_logo'));
				// update category.
				add_post_category($post_id,$this->input->post('category'));						
				
				//$this->after_post_update($post_id);

				 $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_updated').'</div>');

			}

			redirect(site_url('edit-business/'.$page.'/'.$id));
		}
	}

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
	
	// comments.
	
	public function view_all_comments($page='0',$business_id,$post_id='')
	{
		
		
		if(!is_admin())
		{
			$post =$this->business_model->get_post_by_id($post_id);
			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}					

		$value['post_id']	= $post_id;
		$value['reviews']  	= get_all_comments($post_id,'business_blog');
		$data['title'] 		= lang_key('all_reviews');
		$data['content'] 	= load_admin_view('business/blog/all_reviews_view',$value,TRUE);
		
		
		load_admin_view('template/template_view',$data);
	}
	
	#delete a post
	public function deletecomment($page='0',$business_id,$post_id='',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			$post = $this->business_model->get_post_by_id($post_id);

			if($post->created_by != $this->session->userdata('user_id'))
			{
				echo lang_key('dont_have_permission');
				die;
			}

		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/business/deletecomment/'.$page.'/'.$business_id.'/'.$post_id)),TRUE);
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
			redirect(site_url('admin/business/view_all_comments/'.$page.'/'.$business_id.'/'.$post_id.'/'.$id));
		}		
	}



}

/* End of file business_core.php */
/* Location: ./application/modules/admin/controllers/business_core.php */