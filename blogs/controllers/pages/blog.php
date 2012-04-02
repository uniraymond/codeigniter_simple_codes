<?php
class Blog extends Controller{
	
	var $data;
	
	function Blog()
	{
		parent::Controller();                         
		
		date_default_timezone_set('Pacific/Auckland');                              
		$this->load->helper('date');    
		$this->load->helper('getcode');
		$this->load->model('content/content_blog_model');  
		
		$this->data['header'] = print_header('blog');
	   	$this->data['menu']   = print_nav_main(10);  
		                                   
		$this->load->library('form_validation');      
		                                              
		$this->form_validation->set_message('required', 'The field is required!'); 
		
		//new blog form   
		$this->form_validation->set_rules('title', 'Title', 'trim|required');  
		$this->form_validation->set_rules('blog', 'Blog', 'trim|required');                                         
	}                                            
	
	function index()
	{         
		$page = $this->page_model->get_page(5);   
		if($page->image){
		$blogdata['image'] 	= $page->image; }else{$blogdata['image']='';}
		$blogdata['query']  = $this->content_blog_model->get_blog(); 
		
		$this->load->view('common/header', $this->data);
		$this->load->view('blog_view', $blogdata);
		$this->load->view('common/footer');
		
	} 	
	
	function blog_ajax()
	{    
		$blog  = $this->content_blog_model->get_blog_ajax($this->uri->segment(3));     
		$blogdata['blog'] = $blog->body;
		
		//$this->load->view('common/header', $this->data);
		$this->load->view('blog_view_ajax', $blogdata);
		//$this->load->view('common/footer');
		
	}  

	function newblog()
	{   
		$blogcate = '';    
		$page = $this->page_model->get_page(5); 
		$blogdata['image'] 	= $page->image; 
		$blogcate = $this->content_blog_model->get_blogcategory(); 
		$blogdate['query'] = $blogcate;     
		
		if($blogcate->num_rows() > 0)
		{
			foreach($blogcate->result() as $caterow)
			{
				$cate[$caterow->id] =  $caterow->name; 
				$category_select = $caterow->id;
			}
		}else{
			$cate[] = '';
			$category_select = 0;
		}
		$blogdata['title'] = 'Title';
		$blogdata['category'] = $cate;
		$blogdata['blog'] = 'Blog';
		$blogdata['blogpublic'] = TRUE; 
		$blogdata['category_select'] = $category_select;
		$this->load->view('common/header_editor', $this->data);
		$this->load->view('blogform_view', $blogdata);
		$this->load->view('common/footer');
	}      
	
	function editblog()
	{   
		$blogcate = '';    
		$page = $this->page_model->get_page(5); 
		$blogdata['image'] 	= $page->image; 
		$blogcate = $this->content_blog_model->get_blogcategory(); 
		$blogdate['query'] = $blogcate;      
		
		$blog = $this->content_blog_model->blog_edit($this->uri->segment(3));
		
		if($blogcate->num_rows() > 0)
		{
			foreach($blogcate->result() as $caterow)
			{
				$cate[$caterow->id] =  $caterow->name; 
				$category_select = $caterow->id;
			}
		}else{
			$cate[] = '';
			$category_select = 0;
		}  
		
		$blogdata['id'] = $blog->id;
		$blogdata['title'] = $blog->title;
		$blogdata['category'] = $cate;
		$blogdata['blog'] = $blog->body;
		$blogdata['blogpublic'] = $blog->public; 
		$blogdata['category_select'] = $category_select;    
		
		$this->load->view('common/header_editor', $this->data);
		$this->load->view('blogform_edit', $blogdata);
		$this->load->view('common/footer');
	}
	
	function myblog()
	{
		 $page = $this->page_model->get_page(5);   
		 if($page->image){
			$blogdata['image'] 	= $page->image; 
		 }else{
			$blogdata['image']='';
		 }  
			$user_id = $this->session->userdata('auth');
			
			$blogdata['query']  = $this->content_blog_model->get_my_blog($user_id); 

			$this->load->view('common/header', $this->data);
			$this->load->view('my_blog_list', $blogdata);
			$this->load->view('common/footer');  
	}  
	
	function blog_category()
	{
		$page = $this->page_model->get_page(5);
		if($page->image){
			$blogdata['image'] 	= $page->image; 
		 }else{
			$blogdata['image']='';
		 }
		
		$blogdata['query']	=	$this->content_blog_model->get_category_blog($cate_id);
		
		$this->load->view('common/header', $this->data);
		$this->load->view('blog_category', $blogdata);
		$this->load->view('common/footer');
	} 
	
	function blog_insert()
	{
	   	$category = $title = $blog = $blogpublic =  $created_by = $created_at = false;
        if($this->session->userdata('auth')){
			$created_by	 =	$this->session->userdata('auth');
		}else{
			$created_by	 = '';
		}                                       
		
	    $title  	 = 	$this->input->post('title');
		$category  	 = 	$this->input->post('category');
		$blog		 = 	$this->input->post('blog');  
		$blogpublic		 =  $this->input->post('blogbepublic');
		$created_at	 = 	mdate("%Y-%m-%d %H:%i:%s", now());  

		$data = array(                          
				   	'category_id' 	=>	$category,  
				    'title'			=>	$title, 
				   	'body' 	   		=>	$blog,    
					'created_by' 	=> 	$created_by, 
				   	'created_at'	=>	$created_at, 
				   	'public'		=>	$blogpublic?True:False 
			 ); 
		if($this->form_validation->run()==FALSE){ 
			  
		   	$blogcate = $this->content_blog_model->get_blogcategory(); 
			$blogdate['query'] = $blogcate;  

			if($blogcate->num_rows() > 0)
			{
				foreach($blogcate->result() as $caterow)
				{
					$cate[$caterow->id] =  $caterow->name;
				}
			}else{
				$cate[] = '';
			}
			
			$page = $this->page_model->get_page(56); 
			$comdata['image'] 	= $page->image;
			$comdata['created_by']  = $created_by;                                         
			$comdata['title'] 		= $title; 
			$comdata['category']  	= $cate; 
			$comdata['category_select'] = $category;
			$comdata['blog']		= $blog;
			$comdata['blogpublic']	= $blogpublic?True:False;

	   		$this->load->view('common/header_editor', $this->data);
			$this->load->view('blogform_view', $comdata);
		    $this->load->view('common/footer'); 
		}else{               
			 $this->content_blog_model->blog_insert('blog', $data); 
		     $this->session->set_flashdata('success', 'Your comment has been successfully submitted');      
		     redirect('blog');  
		} 
		
	}    
	
	function blog_update()
	{
	   	$category = $title = $blog = $blogpublic =  $created_by = $created_at = false;
        if($this->session->userdata('auth')){
			$updated_by	 =	$this->session->userdata('auth');
		}else{
			$updated_by	 = '';
		}                              
	
	    $id  	 	 = 	$this->input->post('id');
	    $title  	 = 	$this->input->post('title');
		$category  	 = 	$this->input->post('category');
		$blog		 = 	$this->input->post('blog');    
		$blogpublic	 =  $this->input->post('blogbepublic');
		$updated_at	 = 	mdate("%Y-%m-%d %H:%i:%s", now()); 

		$data = array(                     
				   	'category_id' 	=>	$category,  
				    'title'			=>	$title, 
				   	'body' 	   		=>	$blog,    
					'updated_by' 	=> 	$updated_by, 
				   	'updated_at'	=>	$updated_at, 
				   	'public'		=>	$blogpublic?True:False
			 );  
		
		if($this->form_validation->run()==FALSE){ 
			  
		   	$blogcate = $this->content_blog_model->get_blogcategory(); 
			$blogdate['query'] = $blogcate;  

			if($blogcate->num_rows() > 0)
			{
				foreach($blogcate->result() as $caterow)
				{
					$cate[$caterow->id] =  $caterow->name;
				}
			}else{
				$cate[] = '';
			}
			
			$page = $this->page_model->get_page(56);   
			
			$comdata['image'] 			= $page->image;
			$comdata['id']     		    = $id;                                         
			$comdata['updated_by']  	= $updated_by;                                         
			$comdata['title'] 			= $title; 
			$comdata['category']   		= $cate; 
			$comdata['category_select'] = $category;
			$comdata['blog']	   	    = $blog;
			$comdata['blogpublic']		= $blogpublic;

	   		$this->load->view('common/header_editor', $this->data);
			$this->load->view('blogform_edit', $comdata);
		    $this->load->view('common/footer'); 
		}else{                     
			 $this->content_blog_model->blog_update('blog', $data, $id); 
		     $this->session->set_flashdata('success', 'Your comment has been successfully submitted'.$blog);      
		     redirect('blog');  
		} 
		
	}
	
	function comment_public()
	{                               
		$page = $this->page_model->get_page(6);     
		$comdata['image'] 	= $page->image;  
	    $comdata['querycom']  = $this->content_blog_model->get_all_comment($this->uri->segment(3));    
		$header = $this->content_blog_model->get_blog_header($this->uri->segment(3)); 
		$comdata['blogrow'] = $header;      
		$comdata['fullname']  = 'Fullname';
		$comdata['email']	=	'Email';
		$comdata['comment']	=	'Comment...';  
		$comdata['captcha'] = true;
		         
   		$this->load->view('common/header', $this->data);
		$this->load->view('comment_public', $comdata);
	    $this->load->view('common/footer');
	}     
	
	function comment_update()
	{
	   	$compublic;
        if($this->session->userdata('auth')){
			$updated_by	 =	$this->session->userdata('auth');
		}else{
			$updated_by	 = '';
		} 
	    $blog_id  	 = 	$this->input->post('blog_id');   
	    $comment 	 = $this->content_blog_model->get_all_comment($blog_id);   
		 
		foreach($comment->result() as $com)
		{
			$data[$com->id]		=	$this->input->post('compublic_'.$com->id)?True:False; 
			$follow[$com->id]	=	$this->input->post('com_followup_'.$com->id);
		} 
	   // print_r($data); //exit;
		$this->content_blog_model->comment_update('blog_comment', $data,$follow, $blog_id); 
		$this->session->set_flashdata('success', 'Your comment has been successfully submitted');      
		redirect('blog/myblog');
	    
	}       
	
	function category()
	{
		$page = $this->page_model->get_page(5);   
		if($page->image){
		$blogdata['image'] 	= $page->image; }else{$blogdata['image']='';} 
		
		$category_id	=	$this->uri->segment(3);  
		if($category_id)
		{$blogdata['query']  = $this->content_blog_model->get_all_category($category_id);  }
		else{
			$blogdata['query']  =  $this->content_blog_model->get_blog();
		}
		
		$this->load->view('common/header', $this->data);
		$this->load->view('blog_category_view', $blogdata);
		$this->load->view('common/footer');
	}
	   
}