<?php if($post_comments->num_rows()>0){ ?>
 <div class="show-blog  pos-relative">
<h3>Comments</h3>    
    <div class="col-sm-12">
    <div class="ajax-loading recent-blog-loading">
        <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
    </div>
</div>	
<div class="comment-list">    
<?php   
foreach($post_comments->result() as $comment){	
?>
   <div class="col-sm-12">
   		 <div class="col-sm-3">
         <?php
		 $user_data_img =get_user_by_id($comment->user_id);
		if(count($user_data_img) > 0){
		?>
		<img class="blog-user-thumb" src="<?php echo get_profile_photo_by_id($comment->user_id,'thumb');?>" alt="" />
		<?php				
		}else{	
		?>
        <img class="blog-user-thumb" src="<?php echo theme_url(); ?>/assets/images/nophoto.jpg" alt="" />
        <?php		
		}
		?>        
         </div>   
         <div class="col-sm-9">         	
         	<h6><?=$comment->comments_author?></h6>
            <div><?php echo date('g:ia \o\n l jS F Y', $comment->comment_date);?></div>
         </div>
    </div>    
       <div class="col-sm-12">
        <p><?=$comment->comment_content?></p>    
       </div>
       <div class="clear"></div>
     <div class="col-sm-12 reply-div">
     	       <table>
               <tr> 
                 <td>    
                  <?php if(is_loggedin() && is_personal()){ ?>                   
                       <?php if(check_comments_already_given($comment->id,$this->session->userdata('user_id'),$comment->post_id,'business_blog') == 0){ ?>
                    <a  href="javascript:void(0)"  id="<?=$comment->id?>" title="like" post_id="<?=$comment->post_id?>" class="set-like">
                    	<img src="<?php echo theme_url();?>/assets/images/single_thumb2.png"> 
                    </a>
                    <?php }else{ ?>
                      <img src="<?php echo theme_url();?>/assets/images/single_thumb.png"> 
                    <?php } ?>                     
                    <span>
                    	<?php echo get_post_comments_count_likes($comment->post_id,$comment->id,'business_blog'); ?>
                    </span>
                  <?php }else{ ?> 
                   <a  href="javascript:login_alert()">
                    	<img src="<?php echo theme_url();?>/assets/images/single_thumb2.png"> 
                    </a>
                    <span>
                    	<?php echo get_post_comments_count_likes($comment->post_id,$comment->id,'business_blog'); ?>
                    </span>
                  <?php } ?>
                  </td>               
               	<td><a href="javascript:void(0)"  id="<?=$comment->id?>" post_id="<?=$comment->post_id?>" class="js-comments-reply btn-href" >Reply</a></td>
               </tr>
              </table>
    	
    </div>
    <?php  $child_contents = getCommentsArray($comment->id); ?>   
    <?php if(count( $child_contents) > 0){?>
    <?php foreach($child_contents as $value){		 
		    ?>
             <div class="children" style="margin-left:<?=$value['padding'];?>px">
               <div class="col-sm-12">
   		 <div class="col-sm-3">
         <?php
		 $user_data_img =get_user_by_id($value['user_id']);
		if(count($user_data_img) > 0){
		?>
		<img class="blog-user-thumb" src="<?php echo get_profile_photo_by_id($value['user_id'],'thumb');?>" alt="" />
		<?php				
		}else{	
		?>
        <img class="blog-user-thumb" src="<?php echo theme_url(); ?>/assets/images/nophoto.jpg" alt="" />
        <?php		
		}
		?>        
         </div>   
         <div class="col-sm-9">         	
         	<h6><?php echo $value['comments_author']; ?></h6>
            <div><?php echo date('g:ia \o\n l jS F Y', $value['comment_date']);?></div>
         </div>
    </div>    
               <div class="col-sm-12">
                <p><?=$value['comment_content']?></p>    
               </div>
               <div class="col-sm-12 reply-div">
                <table>
               <tr> 
               	<td>    
                  <?php if(is_loggedin() && is_personal()){ ?>                   
                       <?php if(check_comments_already_given($value['id'],$this->session->userdata('user_id'),$value['post_id'],'business_blog') == 0){ ?>
                    <a  href="javascript:void(0)"  id="<?=$value['id']?>" title="like" post_id="<?=$value['post_id']?>" class="set-like">
                    	<img src="<?php echo theme_url();?>/assets/images/single_thumb2.png"> 
                    </a>
                    <?php }else{ ?>
                      <img src="<?php echo theme_url();?>/assets/images/single_thumb.png"> 
                    <?php } ?>                     
                    <span>
                    	<?php echo get_post_comments_count_likes($value['post_id'],$value['id'],'business_blog'); ?>
                    </span>
                  <?php }else{ ?> 
                   <a  href="javascript:login_alert()">
                    	<img src="<?php echo theme_url();?>/assets/images/single_thumb2.png"> 
                    </a>
                    <span>
                    	<?php echo get_post_comments_count_likes($value['post_id'],$value['id'],'business_blog'); ?>
                    </span>
                  <?php } ?>
                  </td>      
                  
                 <?php /*?><td><img src="<?php echo theme_url();?>/assets/images/single_thumb.png">
                 	<span>
                    <?php echo get_post_comments_count_likes($value['post_id'],$value['id'],'blog'); ?>
                    </span>    
                  <?php if(is_loggedin() && is_personal()){ ?>              		
                 	<a  href="javascript:void(0)"  id="<?=$value['id']?>" post_id="<?=$value['post_id']?>" class="set-like">
                   	  <span>Like</span> 
                   </a>
                  <?php } ?> 
                  </td>   <?php */?>            
               	<td>
                 <a href="javascript:void(0)"  id="<?php echo $value['id']; ?>" post_id="<?php echo $value['post_id']; ?>" class="js-comments-reply btn-href" >Reply</a></td>
               </tr>
              </table>
              
               
            </div>   
            </div>
            <div class="clear"></div>
             
   	 <?php } ?>
   <?php } ?>
<?php } ?>
<div class="clear"></div>
</div>
    <div class="col-xs-12">  
        <div class="pagination-wrapper" id="pagination-blog">
            <?php  echo $pagination_links->create_links();?>
        </div>
    </div>
    
    <div id="contactModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel">Reply</h4>

            </div>

            <div class="modal-body">            
                         

                    <div class="rs-enquiry">
                        
                        <div class="ajax-loading recent-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>
                        <div class="clearfix"></div>
                                    <span class="agent-email-form-holder"></span>
                    </div>


            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>

</div>
	<script type="text/javascript">
			function login_alert()
			{
				alert('you must login first!');
			}
            jQuery(document).ready(function(){
             jQuery('.js-comments-reply').on('click',function(e){
                e.preventDefault();
				var id =$(this).attr('id');
				var post_id =$(this).attr('post_id');
                var loadUrl = '<?php echo site_url()?>/show/load_business_comment_form_reply/'+post_id+'/'+id;
                jQuery.post(
                    loadUrl,
                    {},
                    function(responseText){					
                        jQuery('#contactModal .modal-body').html(responseText);
                        jQuery('#contactModal').modal('show');
                        init_send_comment_reply_js();
                    }
                );
    
    
            });
     function init_send_comment_reply_js()
        {
            jQuery('.comments-form-reply').submit(function(e){
                var data = jQuery(this).serializeArray();
                jQuery('.recent-loading-reply').show();
                e.preventDefault();
                var loadUrl = jQuery(this).attr('action');
                jQuery.post(
                    loadUrl,
                    data,
                    function(responseText){
                        jQuery('#contactModal .modal-body').html(responseText);
                        jQuery('.alert-success').each(function(){
                            jQuery('.comments-form-reply input[type=text]').each(function(){
                                jQuery(this).val('');
                            });
                            jQuery('.comments-form-reply textarea').each(function(){
                                jQuery(this).val('');
                            });
                            jQuery('.comments-form-reply input[type=checkbox]').each(function(){
                               // jQuery(this).attr('checked','');
							       jQuery(this).attr('checked', false)
                            });
    
                        });
                        jQuery('.recent-loading-reply').hide();
                        init_send_comment_reply_js();
                    }
                );
            });    
        }
		
		// like btn
	  jQuery('.set-like').on('click',function(e){		
                e.preventDefault();
				var $this = $(this);
				var id =$(this).attr('id');
				var post_id =$(this).attr('post_id');
				var post_type='business_blog';
				var thumb =1;
                var loadUrl = '<?php echo site_url()?>/show/like_comments/'+post_id+'/'+id+'/'+post_type+'/'+thumb;
                jQuery.post(
                    loadUrl,
                    {},
                    function(responseText){					
                       // ale
					   if(responseText == 1){						  
						    $this.html('done!');
					    }else{							
							 $this.html('Already!');
						}
					  // alert(responseText);
                    }
                );
    
    
            });
       });			
    </script>
    
</div> 
<?php }else{} ?>

