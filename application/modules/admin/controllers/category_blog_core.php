<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory Category Controller
 *
 * This class handles category management functionality
 *

 
 */


class Category_blog_core extends CI_Controller {
	
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

		$this->load->model('category_blog_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="margin:0">', '</div>');
		// unique slug.
		$config = array(
			'table' => 'categories_blog',
			'id' => 'id',
			'field' => 'slug',
			'title' => 'title',
			'replacement' => 'dash' // Either dash or underscore
		);
		$this->load->library('slug',$config);
	}
	
	public function index()
	{
		$this->all();
	}

	#load all services view with paging
	public function all($start='0')
	{
		$value['posts']  	 = $this->category_blog_model->get_all_categories_by_range($start,'id');

        $data['title'] = lang_key('all_categories');
        $data['content'] = load_admin_view('blog/categories/allcategories_view',$value,TRUE);
		 load_admin_view('template/template_view',$data);		
	}

	#load new service view
	public function newcategory()
	{
        $data['title'] = lang_key('new_category');
        $data['content'] = load_admin_view('blog/categories/newcategory_view','',TRUE);
		load_admin_view('template/template_view',$data);
	}
	
	#load edit service view
	public function edit($id='')
	{
		$value['post']  = $this->category_blog_model->get_category_by_id($id);
		$data['title'] = lang_key('edit_category');
		$data['content'] = load_admin_view('blog/categories/editcategory_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}
	
	#delete a service
	public function delete($id='',$confirmation='')
	{
		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/category_blog/delete')),TRUE);
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
					$this->category_blog_model->delete_category_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
				}
			}
			redirect(site_url('admin/category_blog/all'));		
			
		}		
	}

	#add a service
	public function addcategory()
	{	
		$this->form_validation->set_rules('title', lang_key('title'), 'required');	
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->newcategory();	
		}
		else
		{
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data 					= array();			
			$data['title'] 			= $this->input->post('title');
				
			$slug =$this->slug->create_uri(array('title' => $this->input->post('title')));
			$data['slug'] 			= $slug;			
			//$data['parent'] 		= $this->input->post('parent');			
			
			$data['create_time'] 	= $time;
			$data['created_by']		= get_id_by_username($this->session->userdata('user_name'));
			$data['status']			= 1;
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->category_blog_model->insert_category($data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_inserted').'</div>');				
			}
			redirect(site_url('admin/category_blog/newcategory'));		
		}
	}
	
	
	#update a service
	public function updatecategory()
	{
		$this->form_validation->set_rules('title', lang_key('title'), 'required');		
		

		if ($this->form_validation->run() == FALSE)
		{
			$id = $this->input->post('id');
			$this->edit($id);	
		}
		else
		{
			$id = $this->input->post('id');

			$data 					= array();
			$data['title'] 			= $this->input->post('title');			
			$data['slug'] = $this->slug->create_uri(array('title' =>  $this->input->post('title')), $id);
			
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->category_blog_model->update_category($data,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/category_blog/edit/'.$id));		
		}
	}

	public function featuredimguploader()

	{

		load_admin_view('blog/categories/featured_img_uploader_view');

	}

	public function uploadfeaturedfile()
	{
		$dir_name 					= 'images/';
		$config['upload_path'] 		= './uploads/'.$dir_name;
		$config['allowed_types'] 	= 'gif|jpg|png';
		$config['max_size'] 		= '5120';
		$config['min_width'] 		= '300';
		$config['min_height'] 		= '256';

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

/* End of file admin.php */
/* Location: ./application/modules/admin/controllers/admin.php */