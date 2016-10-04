<div class="show-image-comments">        
    <div class="comment-list add-scroll">  
    	
    <?php   
		if($post_comments->num_rows() > 0){
    foreach($post_comments->result() as $comment){	
    ?>
           <div class="col-sm-12">
           		 
                 <div class="col-sm-3 pull-left">
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
                 <div class="col-sm-9 pull-left">         	
                    <h6>
                    <a href="<?php  echo site_url('profile/'.get_user_slug_by_id($comment->user_id));?>">
					<?=$comment->comments_author?></a>
                    </h6> 
                    <p><?=$comment->comment_content?></p>                   
                 </div>
            
                
           </div>
           <div class="clear"></div>
         <div class="col-sm-12 reply-div show-comments-reply">
                   <table>
                   <tr> 
                                    
                    <td><a href="javascript:void(0)"  id="<?=$comment->id?>" post_id="<?=$comment->post_id?>" post_type="user_video" class="js-comments-reply btn-href" >Reply</a></td> 
                    <td>    
                      <?php if(is_loggedin() && is_personal()){ ?>  
                     	
                         <span>
                            <?php echo get_post_comments_count_likes($comment->post_id,$comment->id,'user_video'); ?>
                        </span>
                                       
                           <?php if(check_comments_already_given($comment->id,$this->session->userdata('user_id'),$comment->post_id,'user_video') == 0){ ?>
                        <a  href="javascript:void(0)"  id="<?=$comment->id?>" title="like" post_type="user_video" post_id="<?=$comment->post_id?>" class="set-like">
                            <img src="<?php echo theme_url();?>/assets/images/single_thumb2.png"> 
                        </a>
                        <?php }else{ ?>
                          <img src="<?php echo theme_url();?>/assets/images/single_thumb.png"> 
                        <?php } ?>                     
                        
                      <?php }else{ ?> 
                         <span>
                            <?php echo get_post_comments_count_likes($comment->post_id,$comment->id,'user_video'); ?>
                        </span>
                       <a  href="javascript:login_alert()">
                            <img src="<?php echo theme_url();?>/assets/images/single_thumb2.png"> 
                        </a>
                        
                      <?php } ?>                       
                      </td> 
                    <td><span><?php  echo time_elapsed_string(date('Y-m-d H:i:s',$comment->comment_date)); ?></span></td>              
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
             </div>
        </div>    
                   <div class="col-sm-12">
                    <p><?=$value['comment_content']?></p>    
                   </div>
                   <div class="col-sm-12 reply-div">
                    <table>
                   <tr> 
                     <td>
                       <a href="javascript:void(0)"  id="<?php echo $value['id']; ?>" post_type="user_video" post_id="<?php echo $value['post_id']; ?>" class="js-comments-reply btn-href" >Reply</a>
                     </td>
                    <td>    
                      <?php if(is_loggedin() && is_personal()){ ?>  
                         <span>
                            <?php echo get_post_comments_count_likes($value['post_id'],$value['id'],'user_video'); ?>
                         </span>                                         
                           <?php if(check_comments_already_given($value['id'],$this->session->userdata('user_id'),$value['post_id'],'user_video') == 0){ ?>
                        <a  href="javascript:void(0)"  id="<?=$value['id']?>" title="like" post_type="user_video" post_id="<?=$value['post_id']?>" class="set-like">
                            <img src="<?php echo theme_url();?>/assets/images/single_thumb2.png"> 
                        </a>
                        <?php }else{ ?>
                          <img src="<?php echo theme_url();?>/assets/images/single_thumb.png"> 
                        <?php } ?>                     
                        
                      <?php }else{ ?> 
                       <span>
                            <?php echo get_post_comments_count_likes($value['post_id'],$value['id'],'user_video'); ?>
                        </span>
                       <a  href="javascript:login_alert()">
                            <img src="<?php echo theme_url();?>/assets/images/single_thumb2.png"> 
                        </a>                       
                      <?php } ?>
                      </td>  
                      <td><span><?php  echo time_elapsed_string(date('Y-m-d H:i:s',$value['comment_date'])); ?></span></td> 
                   </tr>
                  </table>                 
                   
                </div>   
                </div>
                <div class="clear"></div>
                 
         <?php } ?>
       <?php } ?>
    <?php }
		}else{ ?> 
        	 <div class="col-sm-12"><p>No comments yet given!</p>  </div> 	
    <?php } ?>
    <div class="clear"></div>
    </div>
    <div class="col-xs-12">  
        <div class="pagination-wrapper" id="pagination-image-comments">
            <?php  echo $pagination_links->create_links();?>
        </div>
    </div>      
</div>


 