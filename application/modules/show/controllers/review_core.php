<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Show
 * @subpackage	ReviewCore

 */



class Review_core extends CI_controller {

    var $PER_PAGE;
    var $active_theme = '';

    public function __construct()
    {
        parent::__construct();
        

        //$this->PER_PAGE = get_per_page_value();#defined in auth helper

        $this->PER_PAGE = get_settings('business_settings', 'posts_per_page', 6);


        $this->active_theme = get_active_theme();
        $this->load->model('review_model');

        $this->load->helper('array');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }

    public function index()
    {
//        $this->home();
    }	
	public function write($unique_id='')
	{	
	    if(!is_loggedin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());			
		}		
	    $value = array();
		$this->load->model('user/post_model');
		$value['post'] = $this->post_model->get_post_by_unique_id($unique_id);		
        $data['content']  = load_view('load_write_review',$value,TRUE);		   	
		$data['alias']	  = 'writereview';
		load_template($data,$this->active_theme);
	}

    public function load_review_form($post_id='')
	{
        $value['post_id'] = $post_id;
		$this->load->model('user/post_model');
		$value['blogpost']	= $this->post_model->get_post_by_id($post_id);
        load_view('review_form',$value);
    }
    public function create_review()
    {
        $this->form_validation->set_rules('comment', lang_key('comment'), 'required');
        if ($this->form_validation->run() == FALSE)
        {			
            $this->load_review_form($this->input->post('post_id'));
        }
        else
        {

            $post_id = $this->input->post('post_id');
            $data 			        = array();
            $data['comment']        = $this->input->post('comment');
            $data['post_id']        = $post_id;
            $data['rating']  	    = $this->input->post('rating');
			//$data['thumb']  	    = $this->input->post('thumb');
			//$data['trophy']  	    = $this->input->post('trophy');
			//$data['shrug']  	    = $this->input->post('shrug');
			$data['type']  	        = 'business';
			$data['right_location'] = $this->input->post('right_location');
			$data['emotions']       = json_encode($this->input->post('emotions'));
            $data['created_by']	    = get_id_by_username($this->session->userdata('user_name'));
            $time = time();
            $data['status']  	    = 1;
            $data['create_time']    = $time;;

            $pre_review = $this->review_model->already_given_review($data);
            if($pre_review == 'TRUE'){
//                echo 'insert';die;
                $review_id = $this->review_model->insert_review($data);
             //   $average_rating = get_post_average_rating($post_id);
               // $this->review_model->update_post_average_rating($post_id, $average_rating);

                echo '<div class="alert alert-success">'.lang_key('review_submitted').'</div>';
                $this->load_review_form($post_id);
            }
            else{
//                echo 'not insert';die;
                echo '<div class="alert alert-danger">'.lang_key('review_not_submitted').'</div>';
            }

           // $this->single_review_view($review_id);

        }
    }

    public function load_all_reviews($post_id)
    {
        $value['post_id'] = $post_id;
        load_view('all_reviews_view',$value);
    }

    public function single_review_view($review_id='')
    {
        $review = $this->review_model->get_review_by_id($review_id);
        $value['review'] = $review->row();
        load_view('single_review_view',$value);
    }

// load all review
	function load_all_post_review_view($post_id)
	{	
		// url
		$url = site_url("show/review/load_all_post_review_view/".$post_id);	
		$total_rows =get_all_review_count($post_id);
		$segment = 5;	   
		$per_page =2;
		$value['pagination_links'] = paginationConfig($url,$total_rows,$segment,$per_page);    
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;				
        $value["reviews"] =  get_all_post_reviews_pagination($post_id,$per_page,$page);			
		$value['post_id'] =  $post_id;
		load_view('all_post_reviews_view',$value);	
	
	}


}





/* End of file review_core.php */

/* Location: ./application/modules/show/controllers/review_core.php */