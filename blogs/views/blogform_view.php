<?=script_tag('assets/includes/js/jquery-1.5.2.min.js')?>      
<?=script_tag('assets/includes/tiny_mce/tiny_mce.js')?> 
<script type="text/javascript" charset="utf-8">
	tinyMCE.init({      
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		theme_advanced_resizing : true,

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		},

		// Enable translation mode
		translate_mode : true,
		language : "en"     
	});
</script>
<?=@$menu?>
<div id="contentRight">
    <div id="header">
    	<?=$header?>
        <div id="navCrumb">
            <span class="bold">YOU ARE HERE //</span> <a href="<?=site_url('blog')?>">NEW BLOG</a>
        </div>
    </div>
    <div class="cls">&nbsp;</div>
    <div id="contentRightInner">
        <img src="<?=@$image?>" width="700" height="150" align="right"/>
        <div class="clear-both"></div>
        <div id="navProjectsContainer">
            <ul id="navProjects">
                <li><a href="<?=site_url('blog')?>">NEW BLOG</a> //</li>
            </ul>
        </div>  
		     
		<div id="form_error"><?php echo validation_errors();?></div>
		<div id="content">
			<div class="float-left blog">   
			    <div id="comment_form_body" class="blog">  
					<?php $attributes = array('onsubmit'=>'return checkform()');?>         
					<?=form_open('blog/blog_insert', $attributes);?>  
					<div class="cls"> 
						<lable for="title" class="com_input" id="blog_title">Blog Title*</lable>
						<lable class="com_input" id="errortitle" style="display:none">Title is Requird!</lable>          
						<?php echo form_error('title', '<span class="valid_error"> ','</span>'); ?>
						<div class='cls'></div>  
				 		<?php echo form_input('title', $title, 'class="com_input" id="title"')?>   
			        </div>
				  
					<div class="cls">
					 	<lable for="category" class="com_input" id="blog_category">Blog category</lable>  
						<?php echo form_error('category', '<span class="valid_error"> ','</span>'); ?> 
						<div class='cls'></div>
						<?php echo form_dropdown('category', $category, $category_select, 'class="com_input" id="category"');?>   
			        </div>
				  
					<div class="cls">  
					 	<lable for="blog" class="com_input" id="blog_body">Blog Content* </lable> 
						<lable class="com_input" id="errorbody" style="display:none">Content is Requird!</lable>        
					    <?php echo form_error('blog', '<span class="valid_error"> ','</span>'); ?>  
						<div class='cls'></div>
						<div class="niceditor"> 
							<script type="text/javascript">//bkLib.onDomLoaded(nicEditors.allTextAreas);</script>               
							<?php echo form_textarea('blog', $blog, 'class="com_input comment_body" id="bkLib"')?> 
					    </div>
				    </div> 
					 	<div class="cls">
						 	<lable for="blogpublic" class="com_input" id="blog_public">Public</lable>  
							<?php echo form_error('blogpublic', '<span class="valid_error"> ','</span>'); ?>
							<?php //echo form_checkbox('blogpublic', $blogpublic, TRUE, 'class="com_input blog_public"')?>
							<?php $blog_public = $blogpublic?True:False; ?>  
							    
							<input type="checkbox" name="blogbepublic" class="com_input blog_public" <?php if($blog_public): ?>checked="checked"<?php endif; ?> />
						</div>
						   	
					  	<p><input type="submit" value="Add Blog" class="com_sub" /></p>
					</form> 
					<div class="cls"></div>
				</div>        
	       </div>
       </div>
        
    </div>
</div> 
<?=script_tag('assets/includes/js/checkform.js')?>
<?php
/* End of file who.php */
/* Location: ./system/application/views/blog.php */