<?=script_tag('assets/includes/js/jquery-1.5.2.min.js')?>
<?=@$menu?>
<div id="contentRight">
    <div id="header">
    	<?=$header?>
        <div id="navCrumb">
            <span class="bold">YOU ARE HERE //</span> <a href="<?=site_url('blog')?>">BLOG</a>
        </div>
    </div>
    <div class="cls">&nbsp;</div>
    <div id="contentRightInner">
        <img src="<?=@$image?>" width="700" height="150" align="right"/>
        <div class="clear-both"></div>
        <div id="navProjectsContainer">
            <ul id="navProjects">
                <li><a href="<?=site_url('blog')?>">BLOG</a> //</li>
            </ul>
        </div>  
		      
		<?php if(form_error('fullname')||form_error('email')||form_error('body')): ?> 
			<div id="feedback" class="notification error" >
				 <?php 
					 echo form_error('fullname', '<div class="valid_error_top"> ','</div>');
					 echo form_error('email', '<div class="valid_error_top"> ','</div>');
					 echo form_error('body', '<div class="valid_error_top"> ','</div>');
				 ?> 
				<div class="cls"></div>
			</div>
		<?php elseif($this->session->flashdata('success')):?>
			<div id="feedback" class="notification success">                   
				 <?php
					 echo $this->session->flashdata('success');
				 ?>
			 </div>
		<?php endif;?>   
		<div class="cls"></div>
				
				
		<div id="content">
			<div class="float-left blog">   
			    <div class="blog_date_month">
					<span class="month"><?php echo date("M", strtotime($blogrow->created_at))?></span>
					<span class="date"><?php echo date("d", strtotime($blogrow->created_at))?></span>
				</div> 
				<div class="blog_title">
		          		<h2 class="blog_title pepper bold"><?=@$blogrow->title?></h2>  
					<span><?php echo date("d M, Y", strtotime($blogrow->created_at))?></span>  
					<span>
					      <?php
					       $auth_name =  $this->content_blog_model->get_author($blogrow->created_by);    
							
							echo 'Author: '.$auth_name->name;
					      ?>
					</span>
					<!-- <span>Edit</span><span>delete</span> -->  
				</div>
				<div class="cls"></div>
		            <p><?=@$blogrow->body?></p>  
		          	<div class="sepa_blog"></div>
                    <div class="comment_title"><h2><?=@$querycom->num_rows()?> Comments</h2></div>
					<div class="comment_form">    
					<?php if($querycom->num_rows() > 0): ?>
		         	 	 <?php foreach($querycom->result() as $comrow) : ?> 
							<div class="combody cls">
								<span>By: <?=@$comrow->fullname?>; </span> 
								<span>On: <?php echo date("d M, Y H:i:s", strtotime($comrow->created_at))?></span> 
				                <p><?=@$comrow->body?></p>
							</div>
							<div class="followup"> 
								<div class="cls">
									<span class="followup_title">Follow Up:</span>
								</div>
								<div class="cls followup_body">
							    	<span class=""><?=@$comrow->followup?> </span>
								</div>
							</div> 
							<hr> 
				         <?php endforeach; ?>   
				    <?php endif;?>  
		            <div class="clear-both"></div> 
					<div id="comment_form_body">  
						<?php $attributes = array('onsubmit'=>'return checkform()');?>
		          		<?=form_open('comment/comment_insert/'.$this->uri->segment(3), $attributes );?>
						<?=form_hidden('blog_id', $this->uri->segment(3));?> 
						<div class="form_comment">
						<lable for="fullname" class="com_input" id="com_fullname">Name*</lable>
						<lable class="com_input" id="errorfullname" style="display:none">Name is Requird!</lable> 
						<?php echo form_error('fullname', '<span class="valid_error"> ','</span>'); ?>  
					 	<?php echo form_input('fullname', $fullname, 'class="com_input" id="fullname"')?>   
						</div>
					           
					<div class="form_comment">
						 <lable for="email" class="com_input" id="com_email">Email Address*</lable>
						<lable class="com_input" id="erroremail" style="display:none">Email address is Requird!</lable> 
						<lable class="com_input" id="errorformatemail" style="display:none">Email format is wrong!</lable>   
						<?php echo form_error('email', '<span class="valid_error"> ','</span>'); ?>
						<?php echo form_input('email', $email, 'class="com_input" id="email"')?> 
					</div> 
						      
					<div class="form_comment">
						 <lable for="url" class="com_input" >Website</lable>  
						<?php echo form_input('url', '', 'class="com_input" id="website"' )?>   
					</div>    
						 
					<div class="form_comment">
						 <lable for="body" class="com_input" id="com_comment">Comments* </lable> 
						 <lable class="com_input" id="errorcomment" style="display:none">Comment is Requird!</lable> 
						<?php echo form_error('body', '<span class="valid_error"> ','</span>'); ?>                
						<?php echo form_textarea('body', $comment, 'class="com_input comment_body" id="comment"')?> 
					</div>  
					
					<div class="form_comment">
						<lable for="body" class="com_input" id="com_captchas">
						<?php if(!$captcha):?>
							<span class="valid_error">Captcha Not Match!</span>  
						<?php else: ?>
							<span>Captcha</span>
						<?php endif;?>  
						</lable> 
						<?php if($captcha): ?>
					   		<?php echo form_input('captcha', '', 'class="com_captcha com_input" id="captcha"')?>
						<?php else: ?>
							 <?php echo form_input('captcha', '', 'class="com_captcha com_input com_error" id="captcha"')?>
						<?php endif; ?>
					<span class="captcha"><?=img('comment/captcha',TRUE)?>  </span>
					</div> 
						 
					<div class="form_comment">
						  <p><input type="submit" value="Submit Comment" class="com_sub" /></p>    
						</div>
						</form> 
						<div class="cls"></div>   
					</div>
				</div>
	       </div>
       </div>
        
    </div>
</div>
<?=script_tag('assets/includes/js/checkform.js')?>   
<?php
/* End of file who.php */
/* Location: ./system/application/views/blog.php */