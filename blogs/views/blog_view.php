<?=@$menu?>    
<?php $this->load->helper('text');?>
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
	 	<?php if($this->session->flashdata('success')): ?>
			<div id="feedback" class="notification success">                   
				 <?php
					 echo $this->session->flashdata('success');
				 ?>
			</div>
		<?php endif; ?>   
		<div class="cls"></div>
		
        <div id="content">
           	 <?php foreach($query->result() as $blogrow) : ?>
	            <div class="float-left blog">   
					<div class="blog_date_month">
						<span class="month"><?php echo mdate("%M", mysql_to_unix($blogrow->created_at))?></span>
						<span class="date"><?php echo mdate("%d", mysql_to_unix($blogrow->created_at))?></span>
					</div> 
					<div class="blog_title">
	            		<h2 class="blog_title pepper bold"><?=@$blogrow->title?></h2>  
						<span><?php echo mdate("%d %M, %Y", mysql_to_unix($blogrow->created_at))?></span> 
						<span class="shuxian">|</span>
						<span>
						      <?php
						       $auth_name =  $this->content_blog_model->get_author($blogrow->created_by);    
								
								echo 'Author: '.$auth_name->name;
						      ?>
						</span>
						<span class="shuxian">|</span>
						<span class="comments">
							<?php $comments = array(); ?>   
							<?php $comments = $this->content_blog_model->get_comment($blogrow->id);?>
							<?php if($comments->num_rows() == 1): ?>
								<?php echo anchor('comment/comments/'.$blogrow->id, '1 Comment')?>
						   	<?php elseif($comments->num_rows() > 1): //if comment equal to one display 1 comment ?>                      
								<?php echo anchor('comment/comments/'.$blogrow->id, $comments->num_rows().' Comments')?>
							<?php else: ?>
								<?php echo anchor('comment/comments/'.$blogrow->id, 'Leave a Comment')?>  
							<?php endif; ?>							  
						</span>    
					</div>
					<div class="cls"></div>  
					<div id="blogview_<?=$blogrow->id?>" >
	                	<div class="cls"><?=@word_limiter($blogrow->body, 100)?></div>
	  					<div class="cls">
							<span class="readmore">
								<a herf="#" id="readmore_<?=$blogrow->id?>" class="readmore">Read More</a>
							</span>
						</div>   
					</div>
					<div class="cls"></div>
	            	<div class="sepa_blog"></div> 
	            </div>   
<script type="text/javascript"> 
<?php $blogurl =  'blog/blogajax/'.$blogrow->id; ?>
$('#readmore_<?=$blogrow->id?>').click(function(){
jQuery.ajax({
	type: "POST",
	url: "<?=site_url($blogurl)?>", 
	 beforeSend: function(){
		$("#blogview_<?=$blogrow->id?>").html("Please wait...").show(); 
	 },  
	success:function(msg){
		$("#blogview_<?=$blogrow->id?>").html(msg);
	}                      
}); 
})
</script> 	                     
	         <?php endforeach; ?>
            <div class="clear-both"></div>
        </div>
    </div>
</div>

<?php
/* End of file who.php */
/* Location: ./system/application/views/blog.php */