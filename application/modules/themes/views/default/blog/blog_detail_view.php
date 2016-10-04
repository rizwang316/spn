<div class="container">
           <div class="blogmain">
              <div class="col-sm-2 blogleft">
              
              	 <?php include('blog-sidebar-left.php'); ?>      
               
              </div>
              <div class="col-sm-7">
              <div class="blogdearch">
                <input type="text" placeholder="Blog Search"> <input type="submit" value="search">
              </div>
                <div class="blogsingle">
                
                
               <?php /*?> <?php
class Comments{
      function getCommentsArray($parent_id = 0, $padding=0, $prefix="&raquo;"){
             $return = array();
             $return = $this->getSubCommentsArray($parent_id, $padding, $prefix);
             return $return;
      }
      function getSubCommentsArray($parent_id, $padding, $prefix){
             static $i=0;
             $resource = $this->getAllSubComments($parent_id);
			
             static $return = array();
             //if (@is_resource($resource)){
                 // while ($records_array = mysql_fetch_assoc($resource)) {
					 foreach($resource->result_array() as $records_array){
                        $return['id'][$i] = $records_array['id'];
                        if(is_int($padding)){
                              $return['comment_content'][$i] = "<div style='padding-left:".$padding."px'>".
                                            $prefix ." &nbsp;".$records_array['comment_content']."</div>";
                        }else{
                              $return['comment_content'][$i] = $padding. $prefix .$records_array['comment_content'];
                        }
                        $i++;
                        if(is_int($padding)){
                            $this->getSubCommentsArray($records_array['id'], ($padding+15), $prefix);
                        }else{
                            static $pad ="";
                            if($pad == ""){
                                 $pad = $padding;
                            }
                            $this->getSubCommentsArray($records_array['id'], $padding.$pad, $prefix);
                        }
                 }
            //}
            return $return;
     }
     function getAllSubComments($parent_id=0) {
		 $CI = get_instance();
		$CI->load->database();
           $result = $CI->db->query("SELECT * FROM spn_comments WHERE comment_parent='" . $parent_id . "'");
		
           return $result;
     }

     
}
$cat_obj = new Comments();
$cat_array =$cat_obj->getCommentsArray(3);
echo '<pre>';
print_r($cat_array );
echo '</pre>';

?><?php */?>
                
                
               <?php if($blogpost->num_rows()<=0){ ?>
                    <div class="alert alert-danger"><p>No blog post!</p></div>
                <?php  }else{  $blogpost = $blogpost->row(); ?>
                	<?php if($blogpost->featured_img != ''){ ?>
					 <img src="<?php echo base_url('uploads/images/' . $blogpost->featured_img); ?>" alt="">
                     <?php } ?>
                  <h4><?php echo $blogpost->title; ?> </h4>
                  
                  <table class="ratingcls">                      
                        <tbody><tr>
                             <td><img src="<?php echo theme_url();?>/assets/images/single_thumb.png">
                             	<span><?php echo get_post_count_likes($blogpost->id,'blog'); ?></span>
                             </td><?php /*?>
                             <td><img src="<?php echo theme_url();?>/assets/images/double_thumb.png"> <span>12</span></td>
                             <td><img src="<?php echo theme_url();?>/assets/images/trophy.png"> <span>12</span></td><?php */?>
                            <td><img src="<?php echo theme_url();?>/assets/images/shareicon.png"> <span>2</span></td>
                            </tr>
                      </tbody>
                 </table>
                   <p><?php echo $blogpost->description;?></p>
                                      
                   <div class="view-all-comments"></div>
                   <div class="clearfix"></div>
                   
                   <div class="comments-form-holder"></div>                   
                   
				 <?php } ?>                                   
                </div><!--blog-->                                
              </div>
               <div class="col-sm-3 homeright">
                   <h4><img src="<?php echo theme_url();?>/assets/images/logos.png">Advertise</h4>
                 <div class="addbox">
                <img src="<?php echo theme_url();?>/assets/images/ad1.png">
               </div><!--adds-->
               </div>
              <div class="clear"></div>
           </div><!--blog-->
        </div>
        
        
   <script type="text/javascript">
        jQuery(document).ready(function(){
            var loadUrl = '<?php echo site_url("show/load_comment_form/".$blogpost->id);?>';
            jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery('.comments-form-holder').html(responseText);
                    init_create_comments_js();
                }
            );
        });

        function init_create_comments_js()
        {
            jQuery('.comments-form').submit(function(e){
                var data = jQuery(this).serializeArray();
                jQuery('.review-loading').show();
                e.preventDefault();
                var loadUrl = jQuery(this).attr('action');
                jQuery.post(
                    loadUrl,
                    data,
                    function(responseText){
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
                        jQuery('.review-loading').hide();  
						 init_create_comments_js();                     
                    }
                );
            });

        }
    </script>     
     
<script type="text/javascript">
    jQuery(document).ready(function(){ 
	     
	   //load all blog.
	    var loadUrl = '<?php echo site_url("show/load_all_blog_comments_view/".$blogpost->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-comments').html(responseText);
                init_load_more_blog_comments_js();
				
            }
        );
		 function init_load_more_blog_comments_js()
        {
		jQuery("#pagination-blog a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-blog-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.view-all-comments').html(res);
			   jQuery('.recent-blog-loading').hide();
			}
			});
			
			return false;
		});
		
	 }   
	 
	 
});
</script> 

 
