<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory admin_model_core model
 *
 * This class handles admin_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model_core

 */

class Admin_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_user_profile($user_name)
	{
		$query = $this->db->get_where('users',array('user_name'=>$user_name));
		return $query->row();
	}

	function get_user_profile_by_id($user_id)
	{
		$query = $this->db->get_where('users',array('id'=>$user_id));
		return $query->row();
	}
	
	function update_profile($data,$id)
	{
		$this->db->update('users',$data,array('id'=>$id));
		if($id==$this->session->userdata('user_id'))
		$this->session->set_userdata('user_name',$data['user_name']);
	}
	//education
	// get all education.
	function get_all_educations_by_user_id_by_range($start,$userID)
	{
		$this->db->order_by('id', "desc");
		$this->db->where('status',1); 
		$query = $this->db->get('user_education');
		return $query;
	}
	#insert education
	function insert_education($data)
	{
		$this->db->insert('user_education',$data);
		return $this->db->insert_id();
	}
	#update education
	function update_education($data,$id)
	{
		$this->db->update('user_education',$data,array('id'=>$id));
	}
    #get education.
	function get_education_by_id($id)
	{
		$query = $this->db->get_where('user_education',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			echo 'Invalid Education id';die;
		}
		else
		{
			return $query->row();
		}
	}
	function delete_education_by_id($id)
	{		
		$this->db->delete('user_education',array('id'=>$id));
	}
	//experience
	// get all experience.
	function get_all_experiences_by_user_id_by_range($start,$userID)
	{
		$this->db->order_by('id', "desc");
		$this->db->where('status',1); 
		$query = $this->db->get('user_experience');
		return $query;
	}
	#insert education
	function insert_experience($data)
	{
		$this->db->insert('user_experience',$data);
		return $this->db->insert_id();
	}
	#update education
	function update_experience($data,$id)
	{
		$this->db->update('user_experience',$data,array('id'=>$id));
	}
    #get education.
	function get_experience_by_id($id)
	{
		$query = $this->db->get_where('user_experience',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			echo 'Invalid Experience id';die;
		}
		else
		{
			return $query->row();
		}
	}
	function delete_experience_by_id($id)
	{		
		$this->db->delete('user_experience',array('id'=>$id));
	}
	
	function get_all_blogs_based_on_user($post_id = 0)
	{
		$this->db->where('status',1);
		$this->db->where('key','blog');
		$this->db->where('user_id',$post_id);
		$query = $this->db->get('user_data');
		return $query;
	}
	function get_all_videos_based_on_user($post_id = 0)
	{
		$this->db->where('status',1);
		$this->db->where('key','video_url');
		$this->db->where('user_id',$post_id);
		$query = $this->db->get('user_data');
		return $query;
	}

}

/* End of file admin_model_core.php */
/* Location: ./system/application/models/admin_model_core.php */