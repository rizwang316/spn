<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory page Controller
 *
 * This class handles page management related functionality
 *
 * @package		Admin
 * @subpackage	Page

 */

class Blog_core extends CI_Controller {
	
	var $per_page = 10;
	
	public function __construct()
	{
		parent::__construct();
		
		checksavedlogin(); #defined in auth helper
		
		if(!is_admin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper

		$this->load->model('blog_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
		
	}
	
	public function index()
	{
		$this->all();
	}

	#load all services view with paging
	public function all($start='0')
	{
		$value['posts']  	= $this->blog_model->get_all_posts_by_range('all',$this->per_page,'create_time');
        $data['title'] 		= lang_key('all_posts');
        $data['content'] 	= load_admin_view('blog/allposts_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}


	public function manage($id='')
	{
		$values 			= array();
		$values['title'] 	= lang_key('new_post');
		if($id!='')
		{
			$values['title']  		= lang_key('update_post');
			$values['action_type']  = 'update';
			$values['page'] 		= $this->blog_model->get_post_by_id($id);
						
			$values['categories'] 	      = $this->blog_model->get_all_categories();		
		   $values['post_categories']	  = $this->blog_model->get_categories_id_by_post_id($id);
		}
		
		$values['categories'] = $this->blog_model->get_all_categories();

        $data['content'] = load_admin_view('blog/post_view',$values,TRUE);
		load_admin_view('template/template_view',$data);			
	}


	public function add()
	{

		$this->form_validation->set_rules('title', lang_key('title'), 'required');
		$this->form_validation->set_rules('category[]', lang_key('category'), 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			if($this->input->post('action_type')=='update')
				$this->manage($this->input->post('id'));
			else
				$this->manage();	
		}
		else
		{
			$data['featured_img'] 	= $this->input->post('featured_img');
			//$data['type'] 			= $this->input->post('type');

			$this->load->model('admin/system_model');
            $titles = array();
            $descriptions = array();
            
			$titles = $this->input->post('title');
			$descriptions = $this->input->post('description');
                 	

			
			$data['title'] 			=  $titles;
			$data['description'] 	= $descriptions;
			$data['created_by']		= $this->session->userdata('user_id');
			$data['create_time']	= time();
			$data['status']			= $this->input->post('action');
			

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				if($this->input->post('action_type')=='update')
				{
					$id = $this->input->post('id');
					$this->blog_model->update_post($data,$id);
					// update category
					add_blog_category($id,$this->input->post('category'));
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_updated').'</div>');
				}
				else
				{
					$id = $this->blog_model->insert_post($data);
					// inset category
					add_blog_category($id,$this->input->post('category'));
				
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_created').'</div>');
				}				
			}	

			redirect(site_url('admin/blog/manage/'.$id));		
		}

	}
	

	public function delete($page='0',$id='',$confirmation='')
	{
		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/blog/delete/'.$page)),TRUE);
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
					$this->blog_model->delete_post_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_deleted').'</div>');
				}
			}
			redirect(site_url('admin/blog/all/'.$page));		
			
		}		
	}


	public function featuredimguploader()

	{

		 load_admin_view('blog/featured_img_uploader_view');

	}

	public function uploadfeaturedfile()
	{
		$dir_name 					= 'images/';
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



}

/* End of file page_core.php */
/* Location: ./application/modules/admin/controllers/page_core.php */