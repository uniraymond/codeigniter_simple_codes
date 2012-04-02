<?php

/**
* blog model part 
*/
class Content_blog_model extends Model
{
	
	function __construct()
	{
		parent::Model();
				
	}    
	    
		function get_blogcategory()
		{
			$query = $this->db->get('blog_category');          
			
			return $query;
			
		}  
		
		function blog_insert($table, $data) //create a new blog
		{
			if(!$this->db->insert($table, $data))
			{
				return false;
			}
		} 
		
		function blog_update($table, $data, $id)
		{                         
			$this->db->where('id', $id);   
			if(!$this->db->update($table, $data))
			{
				return false;
			} 
		}
		
		function get_blog()
		{   
			$this->db->orderby('id', 'desc');  
			$this->db->where('public', 1);
			$query = $this->db->get('blog');          
			
			return $query;
			
		} 
				
		function get_blog_ajax($id)
		{   
			$this->db->where('id', $id);
			$query = $this->db->get('blog');          
			
			return $query->row();
			
		}  
		
		function blog_edit($id)
		{    
			$this->db->where('id', $id);
			$query = $this->db->get('blog');          
			
			return $query->row();       
		}         
		
		function get_comment($blog_id)
		{                      
			$this->db->where('blog_id', $blog_id); 
			$this->db->where('is_publiced', 1);
			$querycom = $this->db->get('blog_comment');          
			
			return $querycom;      
		}  
		
		function get_all_comment($blog_id)
		{                      
			$this->db->where('blog_id', $blog_id); 
			$querycom = $this->db->get('blog_comment');          
			
			return $querycom;      
		}        
		 
		function get_my_blog($user_id)
		{
			$this->db->where('created_by', $user_id);
			$this->db->orderby('id', 'desc');
			$query = $this->db->get('blog');
			
			return $query;
		}     
		
		function get_category($category_id)
		{
			$this->db->where('id', $category_id);
			$query = $this->db->get('blog_category');
			
			return $query;
		}  
		
		function get_category_name($category_id)
		{
			$this->db->where('id', $category_id);
			$query = $this->db->get('blog_category');
			
			return $query->row();
		}		
		
		function get_all_category($category_id)
		{
			$this->db->where('category_id', $category_id);   
			$this->db->where('public', 1); 
			$query = $this->db->get('blog');
			
			return $query; 
		}
		
		function get_one_blog($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->get('blog');
			
			return $query;
		}                     
		
		function get_com_blog($id)
		{   
			$this->db->where('id', $id);
			$blog_id = $this->db->get('blog_id');       
			
			$query = $this->db->get_where('blog', array('id' => $blog_id));
			return $query;
		}       
		
		function comment_insert($table, $data)    //create a new comment
		{
			 if ( ! $this->db->insert($table, $data))
			   	{
					return false;
			   	} 
		}
		
		function comment_update($table, $data, $follow, $id)
		{   
			foreach($data as $key => $com_public)
			{   
				$ispublic 	= array(
					 'is_publiced' 	=> $com_public,
					 'followup'		=> $follow[$key] 
				);  
			    //print_r($ispublic);exit;
				$this->db->where('id', $key);                             
				$this->db->update($table, $ispublic);  
			}   
		}
		
		function get_blog_header($blog_id)
		{
			$this->db->where('id', $blog_id);
			$blog_header = $this->db->get('blog');    
			
			return $blog_header->row();    
		}   
		
		function get_author($auth_id)
		{
			$this->db->where('id', $auth_id);
			$query = $this->db->get('config_user');
			
			return $query->row();
		}
	
	
}
