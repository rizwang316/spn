<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 */



class Show_core extends CI_controller {

	var $PER_PAGE;
	var $active_theme = '';

	public function __construct()
	{
		parent::__construct();
		

		//$this->PER_PAGE = get_per_page_value();#defined in auth helper
		
		$this->PER_PAGE = get_settings('business_settings', 'posts_per_page', 6);


		$this->active_theme = get_active_theme();
		$this->load->model('show_model');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
		//check for user online or not
		//$userdata['username'] = $this->session->userdata('user_name');
        //$userdata['id']= $this->session->userdata('user_id');
        //$this->onlineusers->set_data($userdata);
		$this->onlineusers;
		
	}

	public function index()
	{
		$this->home();	
	}

	public function home()
	{	
					
				
				
		/*$users_online = $this->onlineusers->get_info(); //prefer using reference to best memory usage				
		foreach($users_online as $user) 
		{
			if(is_array($user)) {
			  foreach($user as $usr){
				if(isset($usr['username'])) { echo $usr['username'];}
				
			   }
			}   
		}*/
		$value = array();
		$value['random_blogs'] = get_random_general_blog(3);
		$value['home_video'] = get_random_user_video(1);
		$value['recent_review'] = $this->show_model->get_recent_review();
		$data['content'] 	= load_view('home_view',$value,TRUE);
		$data['alias']	    = 'home';
		$data['sub_title']	= lang_key('home_page_title');
		
								
		load_template($data,$this->active_theme);
	}

	public function detail($unique_id='')
	{
	   	
		$value = array();
		$this->load->model('user/post_model');
		$value['post'] = $this->post_model->get_post_by_unique_id($unique_id);
		
		$value['random_business_blog']	= get_random_business_blog(4);
		
		
		$data['content'] 		= load_view('detail_view',$value,TRUE);
		
		$data['alias']	    = 'detail';
		$id = 0;
		$status = 1;
		if($value['post']->num_rows()>0)
		{			
			$row 	= $value['post']->row();
			$status = $row->status;	
			$id = $row->id;
			$seo['key_words'] 	= $row->tags;
			$title 				= $row->title;
			$description 		= $row->description;
			$this->post_model->inc_view_count_by_unique_id($unique_id);
		}

		if($status!=1)
		{
			$this->output->set_status_header('404');
			$data['content'] 	= load_view('404_view','',TRUE);
	        load_template($data,$this->active_theme,'template_view');			
		}
		else
		{

			$data['sub_title']			= $title;
			$description 	= strip_tags($description);
			$description 	= str_replace("'","",$description);
			$description 	= str_replace('"',"",$description);
			$seo['meta_description']	= $description;
			$data['seo']				= $seo;
			load_template($data,$this->active_theme);
		}
	}
	

	public function printview($unique_id='')
	{	
		$value['post']		= $this->show_model->get_post_by_unique_id($unique_id);
		$data['content'] 	= load_view('print_view',$value,TRUE);
		echo $data['content'];
	}

	public function embed($unique_id='')
	{	
		$value['post']		= $this->show_model->get_post_by_unique_id($unique_id);
		load_view('embed_view',$value);
	}


    public function terms()
    {
        $data['content'] 	= load_view('termscondition_view','',TRUE);
        $data['alias']	    = 'terms';
        load_template($data,$this->active_theme);
    }

    public function advfilter()
    {
    	$string = '';

    	foreach ($_POST as $key => $value) 
    	{
    		if(is_array($value))
    		{
    			$val = '';
    			foreach ($value as $row) {
    				$val .= $row.',';
    			}
    			$string .= $key.'='.$val.'+';	
    		}
    		else
			{
	    		$string .= $key.'='.$value.'+';			
			}    			
    	}
    	$string = rtrim($string,'+');

    	redirect(site_url('results/'.$string));
    }

	public function terms_check($str)
	{
		if (isset($_POST['terms_conditon'])==FALSE)
		{
			$this->form_validation->set_message('terms_check', lang_key('must_accept_terms'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


	public function sendemailtoagent($agent_id='0')
	{

		$this->form_validation->set_rules('sender_name', 'Name', 'required');
		$this->form_validation->set_rules('sender_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('msg', 'Message', 'required');
		$this->form_validation->set_rules('ans', 'Code', 'required|callback_check_code');
		$this->form_validation->set_rules('terms_conditon','Terms and condition','xss_clean|callback_terms_check');

		$unique_id 	= $this->input->post('unique_id');		
		$title 		= $this->input->post('title');		

		if ($this->form_validation->run() == FALSE)
		{
			$this->load_contact_agent_view($unique_id);
		}
		else
		{
			$detail_link = $this->input->post('url');

			$data['sender_email'] = $this->input->post('sender_email');
			$data['sender_name']  = $this->input->post('sender_name');
			$data['subject']  	  = $this->input->post('subject');
			$data['msg']  		  = $this->input->post('msg');
			
			$data['msg']		 .= "<br /><br /> This email was sent from the following page:<br /><a href=\"".$detail_link."\" target=\"_blank\">".site_url('ads/'.$unique_id.'/'.$title)."</a>";
			add_user_meta($agent_id,'query_email#'.time(),json_encode($data));

			$this->load->library('email');
			$config['mailtype'] = "html";
			$config['charset'] 	= "utf-8";
			$config['newline'] = '\r\n';

			$this->email->initialize($config);
			$this->email->from($this->input->post('sender_email'),$this->input->post('sender_name'));
			$this->email->to($this->input->post('to_email'));

			$msg = $this->input->post('msg');
			$msg .= "<br/><br/>Email sent from : ".'<a href="'.$detail_link.'">'.$detail_link.'</a>';
			$this->email->subject($this->input->post('subject'));
			$this->email->message($msg);
			$this->email->send();

			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('email_sent').'</div>');
			$this->load_contact_agent_view($unique_id);
		
		}

	}

	public function load_contact_agent_view($unique_id='')
	{
			$value = array();
			$a = rand (1,10);
			$b = rand (1,10);
			$c = rand (1,10)%3;
			if($c==0)
			{
				$operator = '+';
				$ans = $a+$b;
			}
			else if($c==1)
			{
				$operator = 'X';
				$ans = $a*$b;
			}
			else if($c==2)
			{
				$operator = '-';
				$ans = $a-$b;
			}

			$this->session->set_userdata('security_ans',$ans);

			$value['question']  = $a." ".$operator." ".$b." = ?";

			$this->load->model('user/post_model');
			$post = $this->post_model->get_post_by_unique_id($unique_id);
			$value['post'] = $post->row();
			load_view('agent_email_view',$value);
	}

	public function categoryposts($id='')
	{
		$value = array();    	
		$value['category_id'] = $id;
		$data['content'] 	= load_view('category_posts_view',$value,TRUE);
		$data['alias']	    = 'categoryposts';
		load_template($data,$this->active_theme);
	}

	
    #********* widget ajax functions ******************#
    function recentposts_ajax($limit=5,$view_type='grid')
    {
		$this->load->model('user/post_model');
		$value['posts'] = $this->post_model->get_recent_posts($limit);
    	load_view($view_type.'_view',$value);
    }

	function featuredposts_ajax($limit=5,$view_type='grid')
	{

		$this->load->model('user/post_model');
		$value['posts'] = $this->post_model->get_featured_posts($limit);
		load_view($view_type.'_view',$value);
	}

    function categoryposts_ajax($limit=5,$view_type='grid',$category_id='')
    {
		$this->load->model('user/post_model');
		$value['posts'] = $this->post_model->get_category_posts($limit,$category_id);
    	load_view($view_type.'_view',$value);
    }

    function memberposts_ajax($limit=5,$view_type='grid',$user_id='')
    {		
		$this->load->model('user/post_model');
		$value['posts'] = $this->post_model->get_member_posts($limit,$user_id);
    	load_view($view_type.'_view',$value);
    }

    public function result($string='',$limit='0',$redirect=TRUE,$view_type='grid')
    {
		
		
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

    	$value 	= array();
    	$value['data'] = $data;

    	 //echo "<pre>";
    	 //print_r($data);
    	// die;
    	#get estates based on the advanced search criteria
    	$value['query'] 		= $this->show_model->get_advanced_search_result($data,0,$limit);

        if($redirect==FALSE) {
        	$res = array();
        	$res['query'] = $value['query'];
        	$res['url']   = site_url('results/'.$string);
        	return $res;
        }

        $this->load->model('user/post_model');
        $value['categories'] = $this->post_model->get_all_categories();
    	$data 	= array();
    	$data['content'] 	= load_view('adsearch_view',$value,TRUE);
		$data['alias']	    = 'ad_search';
		load_template($data,$this->active_theme);
    }

    function getresult_ajax($view_type='list',$limit='0',$return_type='view')
    {

    	/*************************************
    	If this function is modified make sure
    	to replicate the changes in function
    	getpoppedresult_ajax() located further
    	down
    	**************************************/

    	$string = '';

    	foreach ($_POST as $key => $value) 
    	{
    		if(is_array($value))
    		{
    			$val = '';
    			foreach ($value as $row) {
    				$val .= $row.',';
    			}
    			$string .= $key.'='.$val.'+';	
    		}
    		else
			{
	    		$string .= $key.'='.$value.'+';			
			}    			
    	}
    	$string = rtrim($string,'+');

		$this->load->model('user/post_model');
		$result = $this->result($string,$limit,FALSE,$view_type);

		$value = array();		
		$value['posts'] = $result['query'];

		$output = array();
		if($return_type=='view')
		{
			
	    	$output['content'] 	= load_view($view_type.'_view',$value,TRUE);
	    	$output['url']		= $result['url'];			
		}
		else
		{
			
	    	$output['data'] 	= prepare_map_json_from_query($result['query']);
	    	$output['url']		= $result['url'];
		}

    	echo json_encode($output);
    	die;
    }


    function getpoppedresult_ajax($string='',$view_type='grid')
    {

    	$this->load->model('user/post_model');
		$result = $this->result($string,0,FALSE);

		$value = array();		
		$value['posts'] = $result['query'];

		$output = array();
    	$output['content'] 	= load_view($view_type.'_view',$value,TRUE);
    	$output['url']		= $result['url'];
    	$output['pages'] 	= $result['pages'];
    

    	echo json_encode($output);
    	die;
    }


    function plain()
    {
    	$this->load->model('user/post_model');
    	$value['categories'] = $this->post_model->get_all_categories();
    	$data 	= array();
    	$data['content'] 	= load_view('adsearch_view',$value,TRUE);
		$data['alias']	    = 'map_search';
		load_template($data,$this->active_theme);
    }

    function map()
    {
    	$this->load->model('user/post_model');
    	$value['categories'] = $this->post_model->get_all_categories();
    	$data 	= array();
    	$data['content'] 	= load_view('map_search_view',$value,TRUE);
		$data['alias']	    = 'map_search';
		load_template($data,$this->active_theme);
    }

    function toggle($type='plain')
    {
    	$this->session->set_userdata('search_view_type',$type);
    	redirect($this->input->post('url'));
    }


    #********** blog posts functions start**************#
	public function post($type='all',$start=0)
	{
		// category list.
		$value['get_all_blog_categories']	 = get_all_blog_categories();
		$value['posts']			= $this->show_model->get_all_active_blog_posts_by_range($start,$this->PER_PAGE,'id','desc',$type);
		$total 					= $this->show_model->count_all_active_blog_posts($type);
		$value['pages']			= configPagination('show/post/'.$type,$total,4,$this->PER_PAGE);
		$data['content'] 		= load_view('blog/blogs_view',$value,TRUE);
		load_template($data,$this->active_theme);

	}

	public function postdetail($id='')
	{
		if($id == ''){ die('Invalid post id');}
		$value['get_all_blog_categories']	 = get_all_blog_categories();	
			
		//$this->load->model('admin/blog_model');
		$value['blogpost']		= $this->show_model->get_blog_post_by_id($id);		
        //$data['blog_meta']		= $value['blogpost'];	
		$data['blog_meta']		= $value['blogpost']->row();		
		$data['content'] 		= load_view('blog/blog_detail_view',$value,TRUE);
		load_template($data,$this->active_theme);

	}
    #********** blog posts functions end**************#


    #********** location functions start**************#
    public function get_locations_by_parent_ajax($parent='')
    {
    	if($parent=='')
    	{
	    	echo '<option value="">'.lang_key('select_one').'</option>';
    	}
    	else
    	{
	    	$this->load->model('admin/business_model');
	    	$query = $this->business_model->get_all_locations_by_parent($parent);
	    	echo '<option value="">'.lang_key('select_one').'</option>';
	    	foreach ($query->result() as $row) 
	    	{
	    		echo '<option data-name="'.$row->name.'" value="'.$row->id.'">'.$row->name.'</option>';
	    	}    		
    	}

    	die;
    }

    /*This function sets city name as the value also*/
    public function get_city_dropdown_by_parent_ajax($parent='')
    {
    	if($parent=='')
    	{
	    	echo '<option value="">'.lang_key('select_one').'</option>';
    	}
    	else
    	{
	    	$this->load->model('admin/business_model');
	    	$query = $this->business_model->get_all_locations_by_parent($parent);
	    	echo '<option value="">'.lang_key('select_one').'</option>';
	    	foreach ($query->result() as $row) 
	    	{
	    		echo '<option data-name="'.$row->name.'" city_id="'.$row->id.'" value="'.$row->name.'">'.$row->name.'</option>';
	    	}    		
    	}

    	die;
    }
    #********** location functions end**************#



    #********** Other page functions start**************#

    public function contact()
	{
		$a = rand (1,10);
		$b = rand (1,10);
		$c = rand (1,10)%3;
		if($c==0)
		{
			$operator = '+';
			$ans = $a+$b;
		}
		else if($c==1)
		{
			$operator = 'X';
			$ans = $a*$b;
		}
		else if($c==2)
		{
			$operator = '-';
			$ans = $a-$b;
		}

		$this->session->set_userdata('security_ans',$ans);
		$value['question']  = $a." ".$operator." ".$b." = ?";

		$data['content'] 	= load_view('pages/contact_view',$value,TRUE);
		$data['alias']	    = 'contact';
		load_template($data,$this->active_theme);
	}

	public function page($alias='')
	{

		$value['alias']  = $alias;
		$value['query']  = $this->show_model->get_page_by_alias($alias);
		$data['content'] = load_view('page_view',$value,TRUE,$this->active_theme);
		$data['alias']   = $alias;
		load_template($data,$this->active_theme);
	}

	function check_code($str)
	{
		if ($str != $this->session->userdata('security_ans'))
		{
			$this->form_validation->set_message('check_code', 'The %s is not correct');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function sendcontactemail()
	{
		$this->form_validation->set_rules('sender_name', 'Name', 'required');
		$this->form_validation->set_rules('sender_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('msg', 'Message', 'required');
		$this->form_validation->set_rules('ans', 'Code', 'required|callback_check_code');

		if ($this->form_validation->run() == FALSE)
		{
			$this->contact();	
		}
		else
		{

			$this->load->library('email');
			$config['mailtype'] = "html";
			$config['charset'] 	= "utf-8";
			$this->email->initialize($config);
			$this->email->from($this->input->post('sender_email'),$this->input->post('sender_name'));
			$this->email->to(get_settings('webadmin_email','contact_email','support@example.com'));

			$this->email->subject(lang_key('contact_subject'));
			$this->email->message($this->input->post('msg').'<br/>'.lang_key('phone').': '.$this->input->post('phone'));
			$this->email->send();

			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('mail_sent').'</div>');
			redirect(site_url('show/contact/'));			

		}

	}

	public function rss()
	{
		$this->load->helper('xml');
		$curr_lang 	= get_current_lang();
		if($curr_lang=='')
		$curr_lang = default_lang();

		$value = array();	
		$value['curr_lang'] = $curr_lang;	
		$value['feed_name'] = translate(get_settings('site_settings','site_title','Whizbiz'));
        $value['encoding'] = 'utf-8';
        $value['feed_url'] = site_url('show/rss');
        $value['page_description'] = lang_key('your web description');
        $value['page_language'] = $curr_lang.'-'.$curr_lang;
        $value['creator_email'] = get_settings('webadmin_email','contact_email','');
        $value['posts']	=  $this->show_model->get_properties_by_range(0,$this->PER_PAGE,'id','desc');
       # header("Content-Type: application/rss+xml");
		load_view('rss_view',$value,FALSE,$this->active_theme);
	}

    public function sitemap(){
        $this->load->helper('xml');
        $this->load->helper('file');
        $xml = read_file('./sitemap.xml');

        $value['title']='site map';

        $value['links'] = simplexml_load_string($xml);

        $data['content'] = load_view('sitemap_view',$value,TRUE,$this->active_theme);

        $data['alias']   = 'sitemap';

        load_template($data,$this->active_theme);
    }

    #********** Other page functions end**************#

    public function members($start=0)
    {
    	$value['query']			= $this->show_model->get_users_by_range($start,$this->PER_PAGE,'id');
        $total 					= $this->show_model->get_users_by_range('total');

        $value['pages']			= configPagination('show/members/',$total,4,$this->PER_PAGE);
		$data['content'] 		= load_view('members_view',$value,TRUE);
		$data['alias']	    	= 'members';

		load_template($data,$this->active_theme);	
    }

    public function memberposts($user_id='0',$start=0)
	{	

		$value['user']		= $this->show_model->get_user_by_userid($user_id);	
		$value['query']		= $this->show_model->get_all_estates_agent($user_id,$start,$this->PER_PAGE,'id');
        $total 				= $this->show_model->count_all_estates_agent($user_id);
		$value['pages']		= configPagination('profile/'.$user_id,$total,5,$this->PER_PAGE);
		// get eduction by user id.
		$value['user_educations'] = get_all_education_by_user_id($user_id);
		$value['user_experiences'] = get_all_experience_by_user_id($user_id);
		
		$value['random_user_blog']	= get_random_user_blog(4);
		
		//$userId = get_id_by_username($this->session->userdata('user_name'));
		
        if(get_user_type_by_id(get_user_type_by_user_id($user_id)) == 'business'){ 
		$data['content'] 		= load_view('member_business_view',$value,TRUE);
		
		 }else{  
			$data['content'] 		= load_view('member_posts_view',$value,TRUE);
		 }
		$data['alias']	    	= 'member_posts';
		load_template($data,$this->active_theme,'user_template_view');

	}
	// member reviews.
	public function memberreviews($user_id='0',$start=0)
	{	

		$value['user']		= $this->show_model->get_user_by_userid($user_id);	
		
		
		//$userId = get_id_by_username($this->session->userdata('user_name'));
		
        if(get_user_type_by_id(get_user_type_by_user_id($user_id)) == 'business'){ 
		$data['content'] 		= load_view('member_business_view',$value,TRUE);
		
		 }else{  
			$data['content'] 		= load_view('member_reviews_view',$value,TRUE);
		 }
		$data['alias']	    	= 'member_posts';
		load_template($data,$this->active_theme,'user_template_view');

	}
	

	public function location()
	{

		$value = array();
		$value['countries'] = get_all_locations_by_type('country');

		$data['content'] 	= load_view('location_view',$value,TRUE);
		$data['alias']	    = 'location';
		load_template($data,$this->active_theme);
	}


	public function location_posts($id='', $type='country')
	{
		$value = array();
		$value['location_id'] = $id;
		$value['location_type'] = $type;
		$data['content'] 	= load_view('location_posts_view',$value,TRUE);
		$data['alias']	    = 'locationposts';
		load_template($data,$this->active_theme);
	}

	public function get_cities_ajax($term='')

	{

		if($term=='')

			$term = $this->input->post('term');


		$parent = $this->input->post('parent');

		$data = $this->show_model->get_locations_json($term,'city',$parent);

		echo json_encode($data);

	}

	function location_posts_ajax($limit=5,$view_type='grid',$location_id='', $location_type='country')
	{
		$this->load->model('user/post_model');
		$value['posts'] = $this->post_model->get_location_posts($limit,$location_id,$location_type);
		load_view($view_type.'_view',$value);
	}

	public function reviewdetail($id='')
	{
		$this->load->model('admin/business_model');
		$query = $this->business_model->get_review_by_id($id);
		if($query->num_rows()>0)
		{
			$value['review'] = $query->row();
			load_view('single_review_view',$value);
		}
	}


	public function load_claim_business_view($unique_id='',$msg='')
	{
			$value = array();
			$a = rand (1,10);
			$b = rand (1,10);
			$c = rand (1,10)%3;
			if($c==0)
			{
				$operator = '+';
				$ans = $a+$b;
			}
			else if($c==1)
			{
				$operator = 'X';
				$ans = $a*$b;
			}
			else if($c==2)
			{
				$operator = '-';
				$ans = $a-$b;
			}

			$this->session->set_userdata('security_ans',$ans);

			$value['question']  = $a." ".$operator." ".$b." = ?";

			$this->load->model('user/post_model');
			$post = $this->post_model->get_post_by_unique_id($unique_id);
			$value['post'] = $post->row();
			$value['msg'] = $msg;
			load_view('claim_business_view',$value);
	}

	public function sendclaimemail($agent_id='0')
	{

		$this->form_validation->set_rules('sender_name', 'Name', 'required');
		$this->form_validation->set_rules('sender_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('msg', 'Message', 'required');
		$this->form_validation->set_rules('ans', 'Code', 'required|callback_check_code');
		$this->form_validation->set_rules('terms_conditon','Terms and condition','xss_clean|callback_terms_check');

		$unique_id 	= $this->input->post('unique_id');		
		$post_id 	= $this->input->post('post_id');		
		$title 		= $this->input->post('title');		

		if ($this->form_validation->run() == FALSE)
		{
			$this->load_claim_business_view($unique_id);
		}
		else
		{
			$detail_link = $this->input->post('url');

			$data['sender_email'] = $this->input->post('sender_email');
			$data['sender_name']  = $this->input->post('sender_name');
			$data['phone']  	  = $this->input->post('phone');
			$data['subject']  	  = $this->input->post('subject');
			$data['msg']  		  = $this->input->post('msg');
			
			$data['msg']		 .= "<br /><br /> This email was sent from the following page:<br /><a href=\"".$detail_link."\" target=\"_blank\">".site_url('ads/'.$unique_id.'/'.$title)."</a>";

			add_post_meta($post_id,'claim_email#'.time(),json_encode($data));

			$this->load->library('email');
			$config['mailtype'] = "html";
			$config['charset'] 	= "utf-8";
			$config['newline'] = '\r\n';

			$this->email->initialize($config);
			$this->email->from($this->input->post('sender_email'),$this->input->post('sender_name'));
			$this->email->to(get_settings('webadmin_email','contact_email','support@example.com'));

			$msg = $this->input->post('msg');
			$msg .= "<br/><br/>Email sent from : ".'<a href="'.$detail_link.'">'.$detail_link.'</a>';
			$this->email->subject($this->input->post('subject'));
			$this->email->message($msg);
			$this->email->send();

			$msg = '<div class="alert alert-success">'.lang_key('email_sent').'</div>';
			$this->load_claim_business_view($unique_id,$msg);
		
		}

	}
	
	public function load_all_image_view($post_id)
	{	
		$url =  site_url("show/load_all_image_view/".$post_id);	
		$total_rows = get_post_data_count($post_id,'gallery_img');
		$segment = 4;	   
		$per_page =4;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["images"] =  get_post_data_pagination($post_id,'gallery_img',$per_page,$page);
		// get post create by .
		 $created_by  = get_post_data_by_id($post_id);
		 $value['created_by'] = $created_by->created_by;
		$value['post_id'] =  $post_id;
		load_view('business/all_image_view',$value);	
	}
	// load video.
	public function load_all_video_view($post_id)
	{	
		
		$url =  site_url("show/load_all_video_view/".$post_id);	
		$total_rows = get_post_data_count($post_id,'video_url');
		$segment = 4;	   
		$per_page =3;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["videos"] =  get_post_data_pagination($post_id,'video_url',$per_page,$page);	
		// get post create by .
		 $created_by  = get_post_data_by_id($post_id);
		 $value['created_by'] = $created_by->created_by;
						
		$value['post_id'] =  $post_id;
		load_view('business/all_video_view',$value);	
	}
	// load blog.
	public function load_all_blog_view($post_id)
	{	
		
		$url =  site_url("show/load_all_blog_view/".$post_id);	
		$total_rows = get_post_data_count($post_id,'blog');
		$segment = 4;	   
		$per_page =4;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["blogs"] =  get_post_data_pagination($post_id,'blog',$per_page,$page);
		
		// get post create by .
		 $created_by  = get_post_data_by_id($post_id);
		 $value['created_by'] = $created_by->created_by;
		
						
		$value['post_id'] =  $post_id;
		load_view('business/all_blog_view',$value);	
	}
	
	//load user review with base of user id.	
	public function load_all_user_review_view($user_id)
	{	
		// url
		$url = site_url("show/load_all_user_review_view/".$user_id);	
		$total_rows =get_all_review_by_user_id_count($user_id);
		$segment = 4;	   
		$per_page =2;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page);    
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;						
        $value["reviews"] =  get_all_reviews_by_user_id_pagination($user_id,$per_page,$page);			
		$value['user_id'] =  $user_id;
		load_view('user/all_user_reviews_view',$value);	
	}
	//load user trophy  with base of user id.	
	public function load_all_user_trophy_view($user_id)
	{	
		
		// url
		$url = site_url("show/load_all_user_trophy_view/".$user_id);	
		$total_rows =get_all_trophys_by_user_id_count($user_id);
		$segment = 4;	   
		$per_page =2;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page);    
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;						
        $value["trophys"] =  get_all_trophys_by_user_id_pagination($user_id,$per_page,$page);			
		$value['user_id'] =  $user_id;
		load_view('user/all_user_trophys_view',$value);	
	}
	//load user review with two thumbs up of user id.	
	public function load_all_user_two_thumbs_view($user_id)
	{	
		
		// url
		$url = site_url("show/load_all_user_two_thumbs_view/".$user_id);	
		$total_rows =get_all_two_thumbs_by_user_id_count($user_id);
		$segment = 4;	   
		$per_page =2;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page);    
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;						
        $value["two_thumbs"] =  get_all_two_thumbs_by_user_id_pagination($user_id,$per_page,$page);			
		$value['user_id'] =  $user_id;
		load_view('user/all_user_two_thumbs_view',$value);	
	}
	//load user review with two thumbs up of user id.	
	public function load_all_user_single_thumb_view($user_id)
	{	
		
		// url
		$url = site_url("show/load_all_user_single_thumb_view/".$user_id);	
		$total_rows =get_all_single_thumb_by_user_id_count($user_id);
		$segment = 4;	   
		$per_page =2;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page);    
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;						
        $value["two_thumbs"] =  get_all_single_thumb_by_user_id_pagination($user_id,$per_page,$page);			
		$value['user_id'] =  $user_id;
		load_view('user/all_user_single_thumb_view',$value);	
	}
	
	//images for user.
	public function load_all_user_image_view($user_id)
	{	
		$url =  site_url("show/load_all_user_image_view/".$user_id);	
		$total_rows = get_user_data_count($user_id,'gallery_img');
		$segment = 4;	   
		$per_page =4;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["images"] =  get_user_data_pagination($user_id,'gallery_img',$per_page,$page);	
						
		$value['user_id'] =  $user_id;
		load_view('user/all_image_view',$value);	
	}
	// load user video.
	public function load_all_user_video_view($user_id)
	{	
		
		$url =  site_url("show/load_all_user_video_view/".$user_id);	
		$total_rows = get_user_data_count($user_id,'video_url');
		$segment = 4;	   
		$per_page =3;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["videos"] =  get_user_data_pagination($user_id,'video_url',$per_page,$page);	
						
		$value['user_id'] =  $user_id;
		load_view('user/all_video_view',$value);	
	}
	// load user blog.
	public function load_all_user_blog_view($user_id)
	{	
		
		$url =  site_url("show/load_all_user_blog_view/".$user_id);	
		$total_rows = get_user_data_count($user_id,'blog');
		$segment = 4;	   
		$per_page =4;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["blogs"] =  get_user_data_pagination($user_id,'blog',$per_page,$page);	
						
		$value['user_id'] =  $user_id;
		load_view('user/all_blog_view',$value);	
	}
	//
	public function load_random_video_view()
	{
		$value['random_business_video']	= get_random_business_video(3);
		load_view('business/random_video_view',$value);	
		
	}
	//
	public function load_random_user_video_view()
	{
		$value['random_user_video']	= get_random_user_video(3);
		load_view('user/random_video_view',$value);	
		
	}
	// member blog detail.
	public function user_blog_detail($slug)
	{
		$value["blog"]     = get_user_blog_by_slug($slug);
		$value['random_user_blogs'] = get_random_user_blog(3);		 
		$data['content']  = load_view('user/blog_detail',$value,TRUE);
		$data['alias']	  = 'blog_detail';
		load_template($data,$this->active_theme);
				
	}
	// business blog detail.
	public function business_blog_detail($slug)
	{
		$value["blog"]     = get_business_blog_by_slug($slug);
		$value['random_business_blogs'] = get_random_business_blog(3);			 
		$data['content']  = load_view('business/blog_detail',$value,TRUE);
		$data['alias']	  = 'blog_detail';
		load_template($data,$this->active_theme);
				
	}
	// pages. 
	public function about_me()
	{		
		$value['alias']  = 'About Me';
		$data['content'] = load_view('pages/page_about_view',$value,TRUE);		
		load_template($data,$this->active_theme);
		
	}
	
	// blog Comments start.
	// comments. 
	 public function load_comment_form($post_id='',$parent_id=0)
	{
        $value['blog_id'] = $post_id;
		$value['parent_id'] =$parent_id ;
        load_view('blog/comment_form',$value);
    }
	// blog comments.
	function comments()
	{
		if(!$this->input->post('user_id')){
			$this->form_validation->set_rules('author', 'Name', 'required');	
	 		$this->form_validation->set_rules('author_email', 'Email', 'required|valid_email');
		}
		//$this->form_validation->set_rules('thumb', 'Thumb', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('comment_post_ID', 'Post ID', 'required');
        if ($this->form_validation->run() == FALSE)
        {			
            $this->load_comment_form($this->input->post('comment_post_ID'),$this->input->post('comment_parent'));
        }
        else
        {			
				 
		    $post_id = $this->input->post('comment_post_ID');
			//date.
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			
            $data 			        		= array();
			
            $data['comment_parent']         = $this->input->post('comment_parent');
            $data['post_id']        = $post_id;           
			$data['comment_date'] = $time;
			//ip address.
			
			
			$data['comment_author_IP'] =  $this->input->ip_address();;
			if($this->input->post('thumb')){	
				$data['thumb']  	    		= $this->input->post('thumb');
			}else{
				$data['thumb']  =0;
			}
			$data['post_type']  	    	= $this->input->post('post_type');
			$data['comment_content']  	    = $this->input->post('content');
			
			if($this->input->post('user_id')){							 	
					$user_data = get_user_by_id($this->session->userdata('user_id'));
					$data['user_id']  	    = $this->session->userdata('user_id');
					$data['comments_author']  	    = $user_data->first_name.' '.$user_data->last_name;
					$data['comments_author_email']  = $user_data->user_email;					
				 }else{  
					$data['comments_author']  	    = $this->input->post('author');
					$data['comments_author_email']  = $this->input->post('author_email');
				 }
			
			$comment_id = insert_comments_data($data);
			 if($comment_id != ''){
				 $comments_meta = array();
				 $comments_meta['comment_id']	= $comment_id;
				 $comments_meta['post_id']		= $data['post_id'];
				 $comments_meta['post_type']  	= $data['post_type'];
				 $comments_meta['thumb']  	    = $data['thumb'];
				 $comments_meta['status']  		= 1;
				 if($this->input->post('user_id')){	
				 	$comments_meta['user_id']	= $this->session->userdata('user_id');
				 }
				 $id = insert_comments_meta($comments_meta);
              echo '<div class="alert alert-success">Comments Submitted!</div>';
                $this->load_comment_form($this->input->post('comment_post_ID'));
            }
            else{
				// echo 'not insert';die;
                echo '<div class="alert alert-danger">Comments not submitted!</div>';
            }
			
		}	
		
	}
	 public function load_comment_form_reply($post_id='',$parent_id=0)
	{
        $value['blog_id'] = $post_id;
		$value['parent_id'] =$parent_id ;
        load_view('blog/comment_form_reply',$value);
    }
	
	function comments_reply()
	{
		if(!$this->input->post('user_id')){
			$this->form_validation->set_rules('author', 'Name', 'required');	
	 		$this->form_validation->set_rules('author_email', 'Email', 'required|valid_email');
		}
		//$this->form_validation->set_rules('thumb', 'Thumb', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('comment_post_ID', 'Post ID', 'required');
        if ($this->form_validation->run() == FALSE)
        {			
            $this->load_comment_form_reply($this->input->post('comment_post_ID'),$this->input->post('comment_parent'));
        }
        else
        {			
				 
		    $post_id = $this->input->post('comment_post_ID');
			//date.
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			
            $data 			        		= array();
			
            $data['comment_parent']         = $this->input->post('comment_parent');
            $data['post_id']        = $post_id;           
			$data['comment_date'] = $time;
			//ip address.
			
			
			$data['comment_author_IP'] =  $this->input->ip_address();;

			if($this->input->post('thumb')){	
				$data['thumb']  	    		= $this->input->post('thumb');
			}else{
				$data['thumb']  =0;
			}
			$data['post_type']  	    	= $this->input->post('post_type');
			$data['comment_content']  	    = $this->input->post('content');
			
			if($this->input->post('user_id')){							 	
					$user_data = get_user_by_id($this->session->userdata('user_id'));
					$data['user_id']  	    = $this->session->userdata('user_id');
					$data['comments_author']  	    = $user_data->first_name.' '.$user_data->last_name;
					$data['comments_author_email']  = $user_data->user_email;					
				 }else{  
					$data['comments_author']  	    = $this->input->post('author');
					$data['comments_author_email']  = $this->input->post('author_email');
				 }
			
			$comment_id = insert_comments_data($data);
			 if($comment_id != ''){
				 // 
				 $comments_meta = array();
				 $comments_meta['comment_id']	= $comment_id;
				 $comments_meta['post_id']		= $data['post_id'];
				 $comments_meta['post_type']  	= $data['post_type'];
				 $comments_meta['thumb']  	    = $data['thumb'];
				 $comments_meta['status']  		= 1;
				 if($this->input->post('user_id')){	
				 	$comments_meta['user_id']	= $this->session->userdata('user_id');
				 }
				 $id = insert_comments_meta($comments_meta);
				 
              echo '<div class="alert alert-success">Comments Submitted!</div>';
                $this->load_comment_form_reply($this->input->post('comment_post_ID'));
            }
            else{
				// echo 'not insert';die;
                echo '<div class="alert alert-danger">Comments not submitted!</div>';
            }
			
		}	
		
	}	
	// like comments.
	public function like_comments($post_id,$id,$post_type,$thumb)
	{
		$data 	  =  array();
		$data['post_type']  = $post_type;
		$data['post_id']  	= $post_id;
		$data['comment_id'] = $id;
		$data['thumb']  	= $thumb;
		$data['user_id']   = $this->session->userdata('user_id');
		$check = check_comments_like($data['user_id'],$data['post_id'],$data['comment_id'],$data['post_type']);
		if($check){
			$comment_id = insert_comments_meta($data);	
			echo 1;	
		}else{
			echo  0;		
		}
	}
	
	// blogs.
	public function load_all_blog_comments_view($post_id)
	{	
		
		$url =  site_url("show/load_all_blog_comments_view/".$post_id);	
		$total_rows = get_comments_data_count($post_id,'blog');
		$segment = 4;	   
		$per_page =4;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["post_comments"] =  get_comments_data_pagination($post_id,'blog',$per_page,$page);								
		$value['post_id'] =  $post_id;		
		load_view('blog/all_blog_comments_view',$value);	
	}

	// review detail.
	public function commentdetail($id='')
	{
			
			$query = get_comment_by_id($id);
			if($query->num_rows()>0)
			{
				$value['review'] = $query->row();
				load_view('blog/single_review_view',$value);
			}
		}
	// blog end
	
	// user blog start.
	// comments. 
	 public function load_user_comment_form($post_id='',$parent_id=0)
	{
        $value['blog_id'] = $post_id;
		$value['parent_id'] =$parent_id ;
        load_view('user/comment_form',$value);
    }
	// blog comments.
	function user_comments()
	{
		if(!$this->input->post('user_id')){
			$this->form_validation->set_rules('author', 'Name', 'required');	
	 		$this->form_validation->set_rules('author_email', 'Email', 'required|valid_email');
		}
		//$this->form_validation->set_rules('thumb', 'Thumb', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('comment_post_ID', 'Post ID', 'required');
        if ($this->form_validation->run() == FALSE)
        {			
            $this->load_user_comment_form($this->input->post('comment_post_ID'),$this->input->post('comment_parent'));
        }
        else
        {			
				 
		    $post_id = $this->input->post('comment_post_ID');
			//date.
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			
            $data 			        		= array();
			
            $data['comment_parent']         = $this->input->post('comment_parent');
            $data['post_id']        = $post_id;           
			$data['comment_date'] = $time;
			//ip address.
			
			
			$data['comment_author_IP'] =  $this->input->ip_address();;
			if($this->input->post('thumb')){	
				$data['thumb']  = $this->input->post('thumb');
			}else{
				$data['thumb']  = 0;
			}
			$data['post_type']  	    	= $this->input->post('post_type');
			$data['comment_content']  	    = $this->input->post('content');
			
			if($this->input->post('user_id')){							 	
					$user_data = get_user_by_id($this->session->userdata('user_id'));
					$data['user_id']  	    = $this->session->userdata('user_id');
					$data['comments_author']  	    = $user_data->first_name.' '.$user_data->last_name;
					$data['comments_author_email']  = $user_data->user_email;					
				 }else{  
					$data['comments_author']  	    = $this->input->post('author');
					$data['comments_author_email']  = $this->input->post('author_email');
				 }
			
			$comment_id = insert_comments_data($data);
			 if($comment_id != ''){
				 $comments_meta = array();
				 $comments_meta['comment_id']	= $comment_id;
				 $comments_meta['post_id']		= $data['post_id'];
				 $comments_meta['post_type']  	= $data['post_type'];
				 $comments_meta['thumb']  	    = $data['thumb'];
				 $comments_meta['status']  		= 1;
				 if($this->input->post('user_id')){	
				 	$comments_meta['user_id']	= $this->session->userdata('user_id');
				 }
				 $id = insert_comments_meta($comments_meta);
              echo '<div class="alert alert-success">Comments Submitted!</div>';
                $this->load_user_comment_form($this->input->post('comment_post_ID'));
            }
            else{
				// echo 'not insert';die;
                echo '<div class="alert alert-danger">Comments not submitted!</div>';
            }
			
		}	
		
	}
	
	// user blogs.
	public function load_all_user_blog_comments_view($post_id)
	{	
		
		$url =  site_url("show/load_all_user_blog_comments_view/".$post_id);	
		$total_rows = get_comments_data_count($post_id,'user_blog');
		$segment = 4;	   
		$per_page =4;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["post_comments"] =  get_comments_data_pagination($post_id,'user_blog',$per_page,$page);								
		$value['post_id'] =  $post_id;		
		load_view('user/all_blog_comments_view',$value);	
	}
	
	 public function load_user_comment_form_reply($post_id='',$parent_id=0)
	{
        $value['blog_id'] = $post_id;
		$value['parent_id'] =$parent_id ;
        load_view('user/comment_form_reply',$value);
    }
	
	function user_comments_reply()
	{
		if(!$this->input->post('user_id')){
			$this->form_validation->set_rules('author', 'Name', 'required');	
	 		$this->form_validation->set_rules('author_email', 'Email', 'required|valid_email');
		}
		//$this->form_validation->set_rules('thumb', 'Thumb', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('comment_post_ID', 'Post ID', 'required');
        if ($this->form_validation->run() == FALSE)
        {			
            $this->load_user_comment_form_reply($this->input->post('comment_post_ID'),$this->input->post('comment_parent'));
        }
        else
        {			
				 
		    $post_id = $this->input->post('comment_post_ID');
			//date.
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			
            $data 			        		= array();
			
            $data['comment_parent']         = $this->input->post('comment_parent');
            $data['post_id']        = $post_id;           
			$data['comment_date'] = $time;
			//ip address.
			
			
			$data['comment_author_IP'] =  $this->input->ip_address();;

			if($this->input->post('thumb')){	
				$data['thumb']  	    		= $this->input->post('thumb');
			}else{
				$data['thumb']  =0;
			}
			$data['post_type']  	    	= $this->input->post('post_type');
			$data['comment_content']  	    = $this->input->post('content');
			
			if($this->input->post('user_id')){							 	
					$user_data = get_user_by_id($this->session->userdata('user_id'));
					$data['user_id']  	    = $this->session->userdata('user_id');
					$data['comments_author']  	    = $user_data->first_name.' '.$user_data->last_name;
					$data['comments_author_email']  = $user_data->user_email;					
				 }else{  
					$data['comments_author']  	    = $this->input->post('author');
					$data['comments_author_email']  = $this->input->post('author_email');
				 }
			
			$comment_id = insert_comments_data($data);
			 if($comment_id != ''){
				 // 
				 $comments_meta = array();
				 $comments_meta['comment_id']	= $comment_id;
				 $comments_meta['post_id']		= $data['post_id'];
				 $comments_meta['post_type']  	= $data['post_type'];
				 $comments_meta['thumb']  	    = $data['thumb'];
				 $comments_meta['status']  		= 1;
				 if($this->input->post('user_id')){	
				 	$comments_meta['user_id']	= $this->session->userdata('user_id');
				 }
				 $id = insert_comments_meta($comments_meta);
				 
              echo '<div class="alert alert-success">Comments Submitted!</div>';
                $this->load_user_comment_form_reply($this->input->post('comment_post_ID'));
            }
            else{
				// echo 'not insert';die;
                echo '<div class="alert alert-danger">Comments not submitted!</div>';
            }
			
		}	
		
	}	
	
	// end 
	
	// business blog start.
	// comments. 
	 public function load_business_comment_form($post_id='',$parent_id=0)
	{
        $value['blog_id'] = $post_id;
		$value['parent_id'] =$parent_id ;
        load_view('business/comment_form',$value);
    }
	// blog comments.
	function business_comments()
	{
		if(!$this->input->post('user_id')){
			$this->form_validation->set_rules('author', 'Name', 'required');	
	 		$this->form_validation->set_rules('author_email', 'Email', 'required|valid_email');
		}
		//$this->form_validation->set_rules('thumb', 'Thumb', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('comment_post_ID', 'Post ID', 'required');
        if ($this->form_validation->run() == FALSE)
        {			
            $this->load_business_comment_form($this->input->post('comment_post_ID'),$this->input->post('comment_parent'));
        }
        else
        {			
				 
		    $post_id = $this->input->post('comment_post_ID');
			//date.
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			
            $data 			        		= array();
			
            $data['comment_parent']         = $this->input->post('comment_parent');
            $data['post_id']        = $post_id;           
			$data['comment_date'] = $time;
			//ip address.
			
			
			$data['comment_author_IP'] =  $this->input->ip_address();;
			if($this->input->post('thumb')){	
				$data['thumb']  = $this->input->post('thumb');
			}else{
				$data['thumb']  = 0;
			}
			$data['post_type']  	    	= $this->input->post('post_type');
			$data['comment_content']  	    = $this->input->post('content');
			
			if($this->input->post('user_id')){							 	
					$user_data = get_user_by_id($this->session->userdata('user_id'));
					$data['user_id']  	    = $this->session->userdata('user_id');
					$data['comments_author']  	    = $user_data->first_name.' '.$user_data->last_name;
					$data['comments_author_email']  = $user_data->user_email;					
				 }else{  
					$data['comments_author']  	    = $this->input->post('author');
					$data['comments_author_email']  = $this->input->post('author_email');
				 }
			
			$comment_id = insert_comments_data($data);
			 if($comment_id != ''){
				 $comments_meta = array();
				 $comments_meta['comment_id']	= $comment_id;
				 $comments_meta['post_id']		= $data['post_id'];
				 $comments_meta['post_type']  	= $data['post_type'];
				 $comments_meta['thumb']  	    = $data['thumb'];
				 $comments_meta['status']  		= 1;
				 if($this->input->post('user_id')){	
				 	$comments_meta['user_id']	= $this->session->userdata('user_id');
				 }
				 $id = insert_comments_meta($comments_meta);
              echo '<div class="alert alert-success">Comments Submitted!</div>';
                $this->load_business_comment_form($this->input->post('comment_post_ID'));
            }
            else{
				// echo 'not insert';die;
                echo '<div class="alert alert-danger">Comments not submitted!</div>';
            }
			
		}	
		
	}
	
	// user blogs.
	public function load_all_business_blog_comments_view($post_id)
	{	
		
		$url =  site_url("show/load_all_business_blog_comments_view/".$post_id);	
		$total_rows = get_comments_data_count($post_id,'business_blog');
		$segment = 4;	   
		$per_page =4;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page); 
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
        $value["post_comments"] =  get_comments_data_pagination($post_id,'business_blog',$per_page,$page);								
		$value['post_id'] =  $post_id;		
		load_view('business/all_blog_comments_view',$value);	
	}
	
	 public function load_business_comment_form_reply($post_id='',$parent_id=0)
	{
        $value['blog_id'] = $post_id;
		$value['parent_id'] =$parent_id ;
        load_view('business/comment_form_reply',$value);
    }
	
	function business_comments_reply()
	{
		if(!$this->input->post('user_id')){
			$this->form_validation->set_rules('author', 'Name', 'required');	
	 		$this->form_validation->set_rules('author_email', 'Email', 'required|valid_email');
		}
		//$this->form_validation->set_rules('thumb', 'Thumb', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('comment_post_ID', 'Post ID', 'required');
        if ($this->form_validation->run() == FALSE)
        {			
            $this->load_business_comment_form_reply($this->input->post('comment_post_ID'),$this->input->post('comment_parent'));
        }
        else
        {			
				 
		    $post_id = $this->input->post('comment_post_ID');
			//date.
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			
            $data 			        		= array();
			
            $data['comment_parent']         = $this->input->post('comment_parent');
            $data['post_id']        = $post_id;           
			$data['comment_date'] = $time;
			//ip address.
			
			
			$data['comment_author_IP'] =  $this->input->ip_address();;

			if($this->input->post('thumb')){	
				$data['thumb']  	    		= $this->input->post('thumb');
			}else{
				$data['thumb']  =0;
			}
			$data['post_type']  	    	= $this->input->post('post_type');
			$data['comment_content']  	    = $this->input->post('content');
			
			if($this->input->post('user_id')){							 	
					$user_data = get_user_by_id($this->session->userdata('user_id'));
					$data['user_id']  	    = $this->session->userdata('user_id');
					$data['comments_author']  	    = $user_data->first_name.' '.$user_data->last_name;
					$data['comments_author_email']  = $user_data->user_email;					
				 }else{  
					$data['comments_author']  	    = $this->input->post('author');
					$data['comments_author_email']  = $this->input->post('author_email');
				 }
			
			$comment_id = insert_comments_data($data);
			 if($comment_id != ''){
				 // 
				 $comments_meta = array();
				 $comments_meta['comment_id']	= $comment_id;
				 $comments_meta['post_id']		= $data['post_id'];
				 $comments_meta['post_type']  	= $data['post_type'];
				 $comments_meta['thumb']  	    = $data['thumb'];
				 $comments_meta['status']  		= 1;
				 if($this->input->post('user_id')){	
				 	$comments_meta['user_id']	= $this->session->userdata('user_id');
				 }
				 $id = insert_comments_meta($comments_meta);
				 
              echo '<div class="alert alert-success">Comments Submitted!</div>';
                $this->load_business_comment_form_reply($this->input->post('comment_post_ID'));
            }
            else{
				// echo 'not insert';die;
                echo '<div class="alert alert-danger">Comments not submitted!</div>';
            }
			
		}	
		
	}	
	
	// end 

}





/* End of file install.php */

/* Location: ./application/modules/show/controllers/show_core.php */