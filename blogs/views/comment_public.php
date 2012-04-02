<?=@$menu?>
<div id="contentRight">
    <div id="header">
    	<?=$header?>
        <div id="navCrumb">
            <span class="bold">YOU ARE HERE //</span> <a href="<?=site_url('blog')?>">Public Comment</a>
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
	   
		<?php if($this->session->flashdata('success')):?>
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
					<span>Edit</span><span>delete</span>  
				</div>
				<div class="cls"></div>
		            <p><?=@$blogrow->body?></p>  
		          	<div class="sepa_blog"></div>
                    <div class="comment_title"><h2><?=@$querycom->num_rows()?> Comments</h2></div>
					<div class="comment_form">    
					<?php if($querycom->num_rows() > 0): ?> 
				 		 <?=form_open('blog/comment_update/'.$this->uri->segment(3) );?> 
		         	 	 <?php foreach($querycom->result() as $comrow) : ?> 
							<div class="cls">
								<span>By: <?=@$comrow->fullname?>; </span> 
								<span>On: <?php echo date("d M, Y H:i:s", strtotime($comrow->created_at))?></span> 
				                <p><?=@$comrow->body?></p> 
								<lable for="compublic_<?=$comrow->id?>" class="com_input blog_public" id="com_public<?=$comrow->id?>">Public</lable>
				                <?php $com_public = $comrow->is_publiced?True:False; ?>  
								<input type="checkbox" name="compublic_<?=$comrow->id?>" class="com_input blog_public" <?php if($com_public): ?>checked="checked"<?php endif; ?> />  
								 
								<?php $com_followup=$comrow->id; ?>
								<div class="cls">
									<lable for="com_followup_<?=$com_followup?>" class="com_input blog_public com_followup">Follow Up</lable>	                
									<?=form_textarea('com_followup_'.$com_followup, $comrow->followup, 'class="com_input comment_body"' )?> 
								</div>
								           
							</div> 
							<div class="cls"></div>
							<hr> 
				         <?php endforeach; ?> 
						 <?php echo form_hidden('blog_id', $blogrow->id)?> 
				   		<p><input type="submit" value="Public Comments" class="com_sub" /></p>  
						</form> 
				    <?php endif;?>  
		            <div class="clear-both"></div>
				</div>
	       </div>
       </div>
        
    </div>
</div>
<?=script_tag('assets/includes/js/checkform.js')?>   
<?php
/* End of file who.php */
/* Location: ./system/application/views/blog.php */