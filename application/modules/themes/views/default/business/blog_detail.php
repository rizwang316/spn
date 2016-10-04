<?php $blog= $blog->row(); ?>
<div class="container">

<div class="homebody">
        
          <div class="col-sm-8">  
          		 <?php if(count($blog)<=0){ ?>
                    <div class="alert alert-danger"><?php echo lang_key('post_not_found'); ?></div>
                <?php  }else{ ?> 
                        <?php if($blog->value != ''){ ?>
                		 	<img src="<?php echo base_url('uploads/business/blog/' . $blog->value); ?>" alt=""> 
                         <?php } ?>        	
            		  <h1><?php echo  $blog->title; ?></h1> 
                      <p><?php echo $blog->description;?></p>
                      
                       <!-- comments .-->
                       <div class="view-all-comments"></div>
                      <div class="clearfix"></div>
                      <div style="margin-top:20px;"></div>
                   
                   <div class="comments-form-holder"></div>    
                       
            <?php } ?>
           
          </div><!--8-->
          
          <div class="col-sm-4 homeright">
             <h4><img src="<?php echo theme_url();?>/assets/images/logos.png">Blogs</h4>
             
             <div class="bloghome">
             <?php foreach($random_business_blogs->result() as $blog_list){?>
            
              <div class="blog_in">
              <?php if($blog_list->value != ''){ ?>
                	<img src="<?php echo base_url('uploads/business/blog/' . $blog_list->value); ?>" alt=""> 
              <?php }else{ ?>
             	 <img src="<?php echo site_url(); ?>/assets/admin/img/preview.jpg" alt=""> 
              <?php } ?>   
              <h4><a href="<?=site_url();?>business/blog/<?=$blog->slug?>"><?=$blog_list->slug?></a></h4></div>
            	
           <?php } ?>
           
             </div><!--blog-->
          </div>
          <div class="clear"></div>
          </div><!--homebody-->
</div>

<script type="text/javascript">
        jQuery(document).ready(function(){
            var loadUrl = '<?php echo site_url("show/load_business_comment_form/".$blog->id);?>';
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
	    var loadUrl = '<?php echo site_url("show/load_all_business_blog_comments_view/".$blog->id);?>';
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