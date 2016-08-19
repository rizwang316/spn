<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin_model_core model
 *
 * This class handles admin_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model_core

 */



class Blog_model_core extends CI_Model 

{

	var $pages,$menu;



	function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->pages = array();

	}

    function get_all_categories()
	{
		$this->db->order_by('title','asc');
		$query = $this->db->get_where('categories_blog',array('parent'=>0,'status'=>1));
		$categories = array();
		foreach ($query->result() as $row) {
			array_push($categories,$row);
			$this->db->order_by('title','asc');
			$child_query = $this->db->get_where('categories_blog',array('parent'=>$row->id,'status'=>1));
			foreach ($child_query->result() as $child) {
				array_push($categories,$child);
			}

		}
		return $categories;
	}

	function get_all_parent_categories()
	{
		$this->db->order_by('title','asc');
		$this->db->where('status',1);
		$this->db->where('parent',0);
		$query = $this->db->get('categories_blog');
		return $query;
	}

	function get_all_child_categories($id, $limit = 'all')
	{
		$this->db->order_by('title','asc');
		$this->db->where('status',1);
		$this->db->where('parent',$id);
		if($limit!= 'all')
			$this->db->limit($limit);
		$query = $this->db->get('categories_blog');
		return $query;
	}

	function count_post_by_category_id($cat_id)
	{
		$cat_id = $this->db->escape($cat_id ) ;
		$this->db->where("(category_blog_relationships.category_id = $cat_id)");		
		$this->db->join('category_blog_relationships', 'category_blog_relationships.post_id = posts.id');		
		$this->db->where('blog.status',1);			
		$query = $this->db->get('blog');		
		return $query->num_rows();
	}
	 function get_categories_id_by_post_id($id)
	{
		$query = $this->db->get_where('spn_category_blog_relationships',array('post_id'=>$id));
		if($query->num_rows()<=0)
		{
			echo 'Invalid post id';
			die;
		}
		else
		{
			return $query;
		}
	}


	function get_all_posts_by_range($start,$limit='',$sort_by='')

	{

		$this->db->order_by($sort_by, "asc");

		$this->db->where('status !=',0); 

		if($start=='all')
		{
			$query = $this->db->get('blog');
			
		}
		elseif($statr=='total')
		{
			$query = $this->db->get('blog');
			return $query->num_rows();
		}
		else
		{
			$query = $this->db->get('blog',$limit,$start);
		}

		return $query;

	}

	

	function count_all_posts()

	{

		$this->db->where('status',1); 

		$query = $this->db->get('blog');

		return $query->num_rows();

	}

	

	function delete_post_by_id($id)

	{

		$data['status'] = 0;

		$this->db->update('blog',$data,array('id'=>$id));

	}



	function insert_post($data)

	{

		$this->db->insert('blog',$data);

		return $this->db->insert_id();

	}



	function update_post($data,$id)

	{

		$this->db->update('blog',$data,array('id'=>$id));

	}



	function get_post_by_id($id)

	{

		$query = $this->db->get_where('blog',array('id'=>$id));

		if($query->num_rows()<=0)

		{
			$res = new stdClass();
			return $res;

		}

		else

		{

			return $query->row();

		}

	}

}



/* End of file page_model_core.php */

/* Location: ./system/application/models/page_model_core.php */