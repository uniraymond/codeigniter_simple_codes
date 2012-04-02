<?php
class Comment extends Controller{
	
	var $data;
	
	function Comment()
	{
		parent::Controller();
		
		$this->load->model('content/content_blog_model');  
		 
		date_default_timezone_set('Pacific/Auckland');
		$this->data['header'] = print_header('blog');
		$this->data['menu']   = print_nav_main();  
		
		$this->load->library('form_validation');      
		                                              
		$this->form_validation->set_message('required', 'The field is required!');     
		$this->form_validation->set_message('valid_email', 'Please Check your email format!');     
		
		//new comment form 
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');                      
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');                   
		$this->form_validation->set_rules('body', 'Comments', 'trim|required');                                     
	}                                            
	
	function index()
	{                           
		$page = $this->page_model->get_page(6);
		$comdata['querycom']  = $this->content_blog_model->get_comment($this->uri->segment(3));    
		$header = $this->content_blog_model->get_blog_header($this->uri->segment(3));       
		$comdata['image'] 	= $page->image;
		$comdata['blogrow'] = $header;      
		$comdata['fullname']  = 'Fullname';
		$comdata['email']	=	'Email';
		$comdata['comment']	=	'Comment...';
		      
   		$this->load->view('common/header', $this->data);
		$this->load->view('comment_view', $comdata);
	    $this->load->view('common/footer');
		
	}  
	    
	function comments()
	{       
		$page = $this->page_model->get_page(6);     
		$comdata['image'] 	= $page->image;  
	    $comdata['querycom']  = $this->content_blog_model->get_comment($this->uri->segment(3));    
		$header = $this->content_blog_model->get_blog_header($this->uri->segment(3)); 
		$comdata['blogrow'] = $header;      
		$comdata['fullname']  = 'Fullname';
		$comdata['email']	=	'Email';
		$comdata['comment']	=	'Comment...';  
		$comdata['captcha'] = true;
		         
   		$this->load->view('common/header', $this->data);
		$this->load->view('comment_view', $comdata);
	    $this->load->view('common/footer');   
	} 
	
	function check_captcha()
	{
		$this->load->helper('getcode');  
		$captcha	 =	$this->input->post('captcha');
		
		if(!chk_code(strtoupper($captcha)))
		{                                                                              
		    $this->load->view('captchaerror');
		}
	   $this->load->view('captchaerror');  
		
	}      
	
	function comment_insert()
	{                               
		$this->load->helper('getcode');
		$blog_id = $body = $fullname = $email = $url = $created_at = false;
	   
		$blog_id   	 = 	$this->input->post('blog_id');
	    $body  		 = 	$this->input->post('body');
		$fullname  	 = 	$this->input->post('fullname');
		$staff_email = 	$this->input->post('email'); 
		$email		 =	str_replace("learningworks", "wintec", $staff_email); 
		$url		 =  $this->input->post('url');
		$created_at	 = 	date("Y-m-d H:i:s");        
		$captcha	 =	$this->input->post('captcha');
		
		if(chk_code(strtoupper($captcha)))
		{                                                                              
			$data = array(  
						'blog_id' 		=> 	$blog_id,
					    'body'			=>	$body,
					   	'fullname' 	    =>	$fullname, 
					   	'email'			=>	$email,
					   	'url'			=>	$url,
					   	'created_at'	=>	$created_at 
				 );    

			if($this->form_validation->run()==FALSE){   
			   // exit('failed');  
				$page = $this->page_model->get_page(6);     
				$comdata['image'] 	= $page->image;
				$comdata['querycom']  = $this->content_blog_model->get_comment($this->uri->segment(3));    
				$header = $this->content_blog_model->get_blog_header($this->uri->segment(3));  
				$comdata['blogrow'] = $header; 
				$comdata['fullname']  = $fullname;
				$comdata['email']	=	$email;
			   	$comdata['comment']	=	$body;
			 	$comdata['captcha']	=	$captcha;
			
		   		$this->load->view('common/header', $this->data);
				$this->load->view('comment_view', $comdata);
			    $this->load->view('common/footer'); 
			}else{  
				$this->content_blog_model->comment_insert('blog_comment', $data); 
				    
				//setup email server configuration
				 	$config['protocol']		=	'smtp';               
				 	$config['smtp_host']	=	'mail.elearningworks.ac.nz';         
				 	$config['smtp_user']	=	'info@elearningworks.ac.nz';
					$config['smtp_pass']	=	'Elearn$^$';   
					$config['smtp_port']	=	'25';                                     
				 	$config['infomail']		=	'raymond.feng@wintec.ac.nz';
				//end setup email server configuration	    
				//send a email after insert a new comment   
					$this->load->library('email', $config);
				   	$this->load->library('email', $config);
					$this->load->model('admin/settings_model');  
					$blog_id = $data['blog_id'];

					$address = $this->settings_model->get_auth_email($blog_id);  
					$receiver_email = $address->email;   
					$receiver_email_wintec = str_replace("learningworks", "wintec", $receiver_email); 
					$lw_noreply = 'commentnoreply@learningworks.ac.nz';   
					$lw_name = 'Learningworks New Comment'; 
					$message = 'A New Blog Comment is Coming';

					$this->email->from($lw_noreply, $lw_name);   

					$this->email->to($receiver_email_wintec);

					$this->email->subject('Learningworks New Comment');
					$this->email->message($message);    
					if($this->email->send()) 
						
					//end send a email  
				{$this->session->set_flashdata('success', 'Your comment has been successfully submitted, we will check and public shortly.');    
			    redirect('comment/comments/'.$blog_id);}  
				}
		}else{
			 $page = $this->page_model->get_page(6);     
				$comdata['image'] 	= $page->image;
				$comdata['querycom']  = $this->content_blog_model->get_comment($this->uri->segment(3));    
				$header = $this->content_blog_model->get_blog_header($this->uri->segment(3));  
				$comdata['blogrow'] = $header; 
				$comdata['fullname']  = $fullname;
				$comdata['email']	=	$email;
				$comdata['comment']	=	$body;   
				$comdata['captcha'] = 	false;

		   		$this->load->view('common/header', $this->data);
				$this->load->view('comment_view', $comdata);
			    $this->load->view('common/footer');
		}                    
	}   
	
	function show_img()
	{
		$this->load->helper('getcode');
		code();
	}          
	
	
}