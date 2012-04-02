<?=@$menu?>
<div id="contentRight">
    <div id="header">
    	<?=@$header?>
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
        <!--if submit a blog successful this message will be display-->
	 	<?php if($this->session->flashdata('success')):?>
			<div id="feedback" class="notification success">                   
				 <?php
					 echo $this->session->flashdata('success');
				 ?>
			 </div>
		<?php endif;?>   
		<div class="cls"></div>
		<?php $i = 1; ?>
		<div id="blog_list">   
			<ul class="blog_list_title">
				<li class="blog_list_no">No.</li>
				<li>Blog Nmae</li>
				<li>Blog Category</li>
				<li>Blog Body</li>
				<li class="commentnum">Comment No. (Unpublic Comment)</li>  
				<li class="ispubliced">Publiced</li>
			</ul> 
			<?php $this->load->helper('text');?>  
			<?php foreach($query->result() as $key=>$blogrow): ?> 
				<?php 
					$mykey = ($key+1) % 2;
					if($mykey == 1)
					{
						$ulcolor = 'even';
					}else{
						$ulcolor = 'odd';
					}
				 ?>
			<ul class="blog_list_body <?=$ulcolor?>">
				<li class="blog_list_no"><a href="<?=site_url('blog/editblog/'.$blogrow->id)?>"><?=$i++?></a></li>
				<li><a href="<?=site_url('blog/editblog/'.$blogrow->id)?>"><?php echo character_limiter($blogrow->title, 16); ?></a></li> 
				<?php $category = $this->content_blog_model->get_category_name($blogrow->category_id); ?>
				<li><?php echo character_limiter($category->name, 15); ?></li>
				<li><?php echo character_limiter($blogrow->body, 20); ?></li>  
				<?php $comments = $this->content_blog_model->get_all_comment($blogrow->id);?>
				<?php $uncomments = $this->content_blog_model->get_comment($blogrow->id)?$this->content_blog_model->get_comment($blogrow->id):'0';?>
				<li class="commentnum">
					<?php if($comments->num_rows()): ?>
						<a href="<?=site_url('blog/comment_public/'.$blogrow->id)?>"> 
							<?=$comments->num_rows()?>(<?php echo ($comments->num_rows()-$uncomments->num_rows()); ?>)
						</a>
					 <?php else :?>
						None
					 <?php endif; ?>
				 </li>
				<li class="ispubliced"><?php if($blogrow->public): ?>Publiced<?php else: ?>Unpublic<?php endif; ?></li>
			</ul>                                         
			<?php endforeach; ?>
		</div>    
		       
     </div>
</div>
<?php //script_tag('assets/includes/js/changeulcolor.js')?>   
<?php
/* End of file who.php */
/* Location: ./system/application/views/blog.php */