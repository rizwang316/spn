<div class="commintblog" id="comments">
    <div class="col-sm-12">
        <div class="ajax-loading review-loading">
            <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
        </div>
        <div class="msg-img-comments"></div>
    </div>	    
    <div class="col-sm-12">
    	<p><?php echo $data_info->title; ?></p>
    </div>
    <?php if(is_loggedin() && is_personal()){ ?>
    <form action="<?php echo site_url("show/post_user_video_comments/");?>" class="comments-form"  method="post">  
     <input type="hidden" name="user_id" value="<?=$this->session->userdata('user_id')?>"  />
    <div class="form-group">  
    <label class="col-md-3 control-label">Comments:</label>
     <div  class="col-md-12">
      <?php $v = (set_value('content')!='')?set_value('content'):'';?>
     <textarea name="content"  class="textareafb comments-txt form-control" placeholder="Write a comment..."><?=$v?></textarea>
     <?php echo form_error('content');?>
     </div>                        
     <div class="clear"></div>
     </div>
     <div class="clear"></div>
     <div class="col-md-6">
      <?php $v = (set_value('thumb')!='')?set_value('thumb'):'';?>
      <label class="oneth">
        <input type="checkbox" name="thumb"  <?php echo  ($v == 1)?'checked="checked"':'' ?>  value="1">
        <span></span> 
      </label>                                    
     </div><!---->
      <?php echo form_error('thumb');?>
     <div class="col-md-6">
        <input type="hidden"  name="post_type" value="user_video" />
        <input type="hidden" name="comment_post_ID" value="<?=$image_id?>" />
        <input type="hidden" name="comment_parent" value="<?=$parent_id ?>" />            
        <input type="submit" value="Post Comment">
     </div>
     <div class="clearfix"></div>
  </form>
  <?php }else{ ?>
  	<strong>You Must Be Logged In To Write Comment </strong>
  <?php } ?>
</div>       

 <div class="view-all-video-comments"></div> 
  <div class="clearfix"></div>
  
         
<script type="text/javascript">
	$(document).ready(function() {
		<?php if(is_loggedin() && is_personal()){ ?>
			$('.textareafb').autoResize();
		<?php } ?>
	});    
	$('textarea.comments-txt').keydown(function (e) {		
    if (e.keyCode === 13 && e.ctrlKey) {
        //console.log("enterKeyDown+ctrl");
        $(this).val(function(i,val){
            return val + "\n";
        });
    }
	}).keypress(function(e){
		 if($('.comments-txt').val().trim() != ''){
		if (e.keyCode === 13 && !e.ctrlKey) {
			$(this).closest('form').submit(); 
			return false;  
		} 
	  }
	});
	 // comments form submit
	 jQuery('.comments-form').submit(function(e){
		  
		var data = jQuery(this).serializeArray();
		jQuery('.review-loading').show();
		e.preventDefault();
		var loadUrl = jQuery(this).attr('action');		
		 jQuery.ajax({
				type: "POST",
				url: loadUrl,
				data: data,
				dataType: "json",
				cache : false,				
				success: function(responseText){
					if(responseText.success == false){
						$('.msg-img-comments').html(responseText.msg);						
					}
					if(responseText.success == true){
					$('.msg-img-comments').html(responseText.msg);		
					jQuery('.comments-form-holder').html(responseText);
					jQuery('.alert-success').each(function(){
					jQuery('.comments-form input[type=text]').each(function(){
						jQuery(this).val('');
					});
					jQuery('.comments-form textarea').each(function(){
						jQuery(this).val('');
					});
					jQuery('.comments-form input[type=checkbox]').each(function(){
						//jQuery(this).attr('checked','');
						 jQuery(this).attr('checked', false)
					});
				});
				}
				jQuery('.review-loading').hide();  				                  
			}
			});				
	});       
	// load comments
	// laod all images comments.
	  var loadUrl = '<?php echo site_url("show/load_all_user_video_comments_view/".$image_id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-video-comments').html(responseText);
                init_load_more_video_comments_js();
            }
        );
		
		 function init_load_more_video_comments_js()
         {
		   jQuery("#pagination-image-comments a").live('click',function(e){
			 e.preventDefault();
			 jQuery('.recent-image-loading').show();
			 jQuery.ajax({
				type: "POST",
				url: jQuery(this).attr("href"),
				success: function(res){
				  jQuery('.show-image-comments').html(res);
				   jQuery('.recent-image-loading').hide();
				   init_load_more_image_comments_js();
				}
			});
			return false;
		});
		
		// reply comments submit
	$(function() {
        $(document).on('submit', '.comments-reply-form', function(e) {
            e.preventDefault();
		var $this = $(this);	
		var data = jQuery(this).serializeArray();
		jQuery('.review-loading').show();
		e.preventDefault();
		var loadUrl = jQuery(this).attr('action');		
		 jQuery.ajax({
				type: "POST",
				url: loadUrl,
				data: data,
				dataType: "json",
				cache : false,				
				success: function(responseText){
					if(responseText.success == false){
						$('.msg-img-comments').html(responseText.msg);						
					}
					if(responseText.success == true){
					$('.msg-img-comments').html(responseText.msg);		
					jQuery('.comments-form-holder').html(responseText);
					jQuery('.alert-success').each(function(){
					jQuery('.comments-reply-form input[type=text]').each(function(){
						jQuery(this).val('');
					});
					jQuery('.comments-reply-form textarea').each(function(){
						jQuery(this).val('');
					});
					jQuery('.comments-reply-form input[type=checkbox]').each(function(){
						//jQuery(this).attr('checked','');
						 jQuery(this).attr('checked', false)
					});
				});
				}
				jQuery('.review-loading').hide();  				                  
			}
			});	
            /*  do work */
			//$(this).closest('form').submit(); 
        })
 })
// add reply form click once time 
  $('.js-comments-reply').one('click',function(){  
             var post_id = jQuery(this).attr('post_id'); 
			 var parent_id = jQuery(this).attr('id');
			  var post_type = jQuery(this).attr('post_type'); 
			 
			 var html = '<div class="commintblog">'+
			 			<?php if(is_loggedin() && is_personal()){ ?>
			 			'<form action="<?php echo site_url("show/post_user_video_comments/");?>" class="comments-reply-form">'+	
							'<input type="hidden" name="user_id" value="<?=$this->session->userdata('user_id')?>"  />' +
						 '<div class="form-group">  '+
							 '<div class="col-md-12">'+
								   '<textarea  name="content"  rows="2" class="textareafb comments-reply-txt form-control" placeholder="Write a reply"></textarea>'+
								 '</div>'+          
							 '<div class="clear"></div>'+
							 '</div>'+						 
						 '<div class="clear"></div>'+
						 '<div class="col-md-6">'+
						  '<label class="oneth">'+
							'<input type="checkbox" name="thumb"   value="1">'+
							'<span></span> '+
						  '</label> '+                                   
						 '</div>'+						 
						 '<div class="col-md-6">'+
							'<input type="hidden"  name="post_type" value="'+post_type+'" />'+
							'<input type="hidden" name="comment_post_ID" value="'+post_id+'" />'+
							'<input type="hidden" name="comment_parent" value="'+parent_id+'" /> '+           
							'<input type="submit" value="Post Comment">'+
						 '</div>'+
						 '<div class="clearfix"></div>'+
					   '</form>'+
					   <?php }else{ ?>
					   		'<small>You Must Be Logged In To Reply Comment</small>'+
					   <?php } ?>
					   '</div>';					
				$(this).closest('table').after(html);
			//$(this).closest('table').after(html).appendTo(document.body).submit();		
	});	
 // comments pagination
}
</script>

