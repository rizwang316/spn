<?php 
$per_page = get_settings('business_settings', 'posts_per_page', 6);
$user = $user->row();
?>
<?php if(count($user)>0){ ?>
<!-- Page heading two starts -->
<script src="<?php echo theme_url(); ?>/assets/js/jquery.lightSlider.min.js"></script>
<script src="<?php echo theme_url(); ?>/assets/js/lightGallery.min.js"></script>
 <link rel="stylesheet" href="<?php echo theme_url(); ?>/assets/css/swipebox.css">
    
<!-- Container -->
<div class="container">
		
		<section class="userrtop">
          <div class="col-sm-2">
              <a href="<?php echo site_url('profile/'.$user->id.'/'.get_user_fullname_by_id($user->id));?>">
                  <img class="img-responsive" src="<?php echo get_profile_photo_by_id($user->id,'thumb');?>" alt="" />
              </a>
          </div>  
          <div class="col-sm-7">
             <h2><?php echo $user->first_name.' '.$user->last_name; ?></h2>
			<?php if(get_user_meta($user->id, 'company_name')!=''){?>
                <p class="contact-types">
                    <strong><?php echo lang_key('company_name'); ?>:</strong> <?php echo get_user_meta($user->id, 'company_name'); ?></a>
                </p>
            <?php }?>
            <?php if(get_user_meta($user->id, 'about_me')!=''){?>
            <!-- Para -->
            <p><?php echo get_user_meta($user->id, 'about_me'); ?></p>
            <?php }?>
            <p class="contact-types">
                <?php if(get_user_meta($user->id, 'hide_phone',0)==0) {?>
                <strong><?php echo lang_key('phone'); ?>:</strong> <?php echo get_user_meta($user->id, 'phone'); ?> <br />
                <?php }?>
                <?php if(get_user_meta($user->id, 'hide_email',0)==0) {?>
                <strong>Email:</strong> <a href="mailto:<?php echo $user->user_email; ?>"><?php echo $user->user_email; ?></a>
                <?php }?>
            </p>
            <!-- Social -->
            <?php $fb_profile = get_user_meta($user->id, 'fb_profile'); ?>
            <?php $gp_profile = get_user_meta($user->id, 'gp_profile'); ?>
            <?php $twitter_profile = get_user_meta($user->id, 'twitter_profile'); ?>
            <?php $li_profile = get_user_meta($user->id, 'li_profile'); ?>
            <div class="brand-bg">
                                        <?php if($fb_profile != ''){?>
                                        <a class="facebook" href="https://<?php echo $fb_profile; ?>"><i class="fa fa-facebook circle-3"></i></a>
                                        <?php }?>
                                        <?php if($gp_profile != ''){?>
                                        <a class="google-plus" href="https://<?php echo $gp_profile; ?>"><i class="fa fa-google-plus circle-3"></i></a>
                                        <?php }?>
                                        <?php if($twitter_profile != ''){?>
                                        <a class="twitter" href="https://<?php echo $twitter_profile; ?>"><i class="fa fa-twitter circle-3"></i></a>
                                        <?php }?>
                                        <?php if($li_profile != ''){?>
                                        <a class="linkedin" href="https://<?php echo $li_profile; ?>"><i class="fa fa-linkedin circle-3"></i></a>
                                        <?php }?>
                                    </div>
             
          </div>
          
          <div class="col-sm-3">
             <div class="reviews">
                <p><span>Overall profile views </span> <span class="countc">100</span></p>
                <label></label>
                <p><span>Profile views last days</span> <span class="countc">20</span></p>
                 <label></label>
                <p><span>Profile views this week</span> <span class="countc">30</span></p>
                 <label></label>
                <p><span>Profile views today</span>  <span class="countc">50</span></p>
                 <label></label>

             </div>
          </div>
            
          <div class="clear"></div>
          </section>
       <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">            
            <!--recent review-->
            <div class="recent_review">
            	<div id="" class="view-all-user-review"></div>			
        		<div class="clear"></div>
            </div>
			
			 <!--recent trophy-->
            <div class="recent_trophys">
            	<div id="" class="view-all-user-trophys"></div>			
        		<div class="clear"></div>
            </div>
			 <!--recent two thumbs-->
            <div class="recent_two_thumbs">
            	<div id="" class="view-all-user-two-thumbs"></div>			
        		<div class="clear"></div>
            </div>
			 <!--recent single thumb-->
            <div class="recent_single_thumb">
            	<div id="" class="view-all-user-single-thumb"></div>			
        		<div class="clear"></div>
            </div>
            
          <div class="mediacls">
            <div id="" class="view-all-video"></div>			
            <div class="clear"></div>		
        </div>
    
    
        <div class="mediacls">
            <div id="" class="view-all-image"></div>			
            <div class="clear"></div>       
        </div>
    
    
        <div class="mediacls">
            <div id="" class="view-all-blog"></div>			
            <div class="clear"></div>               
        </div><!--blog-->
        
        <?php if($user_educations != ''){ ?>
           <div class="mediacls">
            <div class="show-blog pos-relative">
                <h3>Education:</h3>
                  <?php if($user->id == $this->session->userdata('user_id')){ ?>
                    <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                        <a href="<?php echo site_url('admin/neweducation/0/'.$user->id);?>" class="">Add More Education</a>
                    </div>        
                  <?php } ?>
                  	
                 
                <?php foreach($user_educations->result() as $education){ ?>
                <div class="col-sm-3 educationcls">
                <ul>
                	  	<?php if($education->school_name !='' ){ ?>
                        <li><span>School Name:</span> <?php echo $education->school_name; ?></li>
                        <?php } ?>
                        <?php if($education->start_year !='' ){ ?>
                        <li><span>Year:</span> <?php echo $education->start_year.' '.$education->end_year; ?></li>
                        <?php } ?>
                        <?php if($education->degree !='' ){ ?>
                        <li><span>Degree:</span> <?php echo $education->degree; ?></li>
                        <?php } ?>
                        <?php if($education->study_field !='' ){ ?>
                        <li><span>Study Field:</span> <?php echo $education->study_field; ?></li>
                        <?php } ?>
                        <?php if($education->grad !='' ){ ?>
                        <li><span>Grad:</span> <?php echo $education->grad; ?></li>
                        <?php } ?>
                        <?php if($education->activities !='' ){ ?>
                        <li><span>Activities:</span> <?php echo $education->activities; ?></li>
                        <?php } ?>
                        <?php if($education->description !='' ){ ?>
                        <li><span>Description:</span> <?php echo $education->description; ?></li>
                        <?php } ?>
                       </ul>
                       </div>
                <?php } ?>
               <div class="clear"></div>
                  </div>
             </div>  
             </div> 
        <div class="clear"></div>
		<?php }else{ ?>
        	<?php if($user->id == $this->session->userdata('user_id')){ ?>
            <div class="show-video pos-relative">
            <h3> Education </h3>   
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/neweducation/0/'.$user->id);?>" class="">Add Education</a>
                </div> 
            </div>       
        <?php } ?>        
       <?php } ?>
        
         <?php if($user_experiences != ''){ ?>
         <div class="mediacls">
            <div class="show-blog pos-relative">
                <h3>Experience:</h3>
                <?php if($user->id == $this->session->userdata('user_id')){ ?>
                    <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                        <a href="<?php echo site_url('admin/newexperience/0/'.$user->id);?>" class="">Add More Experience</a>
                    </div>        
                  <?php } ?>		
                
                <?php foreach($user_experiences->result() as $experience){ ?>
                 <div class="col-sm-3 educationcls">
                <ul>
                	  	<?php if($experience->company_name !='' ){ ?>
                        <li><span>Company Name:</span> <?php echo $experience->company_name; ?></li>
                        <?php } ?>
                        <?php if($experience->title !='' ){ ?>
                        <li><span>Job Title:</span> <?php echo $experience->title; ?></li>
                        <?php } ?>
                        <?php if($experience->location !='' ){ ?>
                        <li><span>Location:</span> <?php echo $experience->location; ?></li>
                        <?php } ?>
                        <?php if($experience->start_month !='' ){ ?>
                        <li><span>Start Date:</span> <?php echo $experience->start_month.' '.$experience->start_year; ?></li>
                        <?php } ?>
                        <?php if($experience->present == 0){ ?>
                         <?php if($experience->end_month !='' ){ ?>
                        <li><span>End Date:</span> <?php echo $experience->end_month.' '.$experience->end_year; ?></li>
                        <?php } ?>
                        <?php } ?>
                        <?php if($experience->present == 1){ ?>
                        	<li><span></span> present </li>
                        <?php } ?>
                        <?php if($experience->description !='' ){ ?>
                        <li><span>Description:</span> <?php echo $experience->description; ?></li>
                        <?php } ?>
                       </ul>
                       </div>
                       
                <?php } ?>
                <div class="clear"></div>
                
             </div>   
            </div>
		<?php }else{ ?>
        	<?php if($user->id == $this->session->userdata('user_id')){ ?>
            <div class="show-video pos-relative">
            <h3> Experience </h3>   
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/newexperience/0/'.$user->id);?>" class="">Add Experience</a>
                </div> 
            </div>       
        <?php } ?>        
       <?php } ?>
        
         <?php 
		 	$causes = get_user_meta($user->id, 'causes'); 
		 if($causes != ''){ ?>
           <div class="mediacls">
            <div class="show-blog pos-relative">
                <h3>Causes:</h3>	
                <?php if($user->id == $this->session->userdata('user_id')){ ?>
                    <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                        <a href="<?php echo site_url('admin/editbucket/0/'.$user->id);?>" class="">Edit Causes</a>
                    </div>        
                  <?php } ?>	
                  
                <p><?=$causes?></p>
             </div>   
             </div>
		<?php }else{ ?>
        	<?php if($user->id == $this->session->userdata('user_id')){ ?>
            <div class="mediacls">
            <div class="show-video pos-relative">
            <h3> Causes </h3>   
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/editbucket/0/'.$user->id);?>" class="">Add Causes</a>
                </div> 
            </div>
           </div>       
        <?php } ?>        
       <?php } ?>
        
        <?php
			$bucket_lists = get_user_meta($user->id, 'bucket_list');
			//print_r($bucket_lists);			 
			 if(($bucket_lists) != ''){ ?>
             <div class="mediacls">
            <div class="show-blog pos-relative">
                <h3>Bucket List:</h3>	
                 <?php if($user->id == $this->session->userdata('user_id')){ ?>
                    <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                        <a href="<?php echo site_url('admin/editbucket/0/'.$user->id);?>" class="">Edit or Add More Bucket List</a>
                    </div>        
                  <?php } ?>
                  
                <ul class="bucktcls">
                	 <?php  $j=0;											
						 foreach(json_decode($bucket_lists) as $bucket_list){
								   foreach( $bucket_list as $k => $v){  ?>
                            <li>
                           <fieldset>
                             <input type="checkbox" value="1" <?php if($v == 1){ echo 'checked="checked"';}else{} ?>  name="bucket_list_value[<?=$j?>]"/>   <span></span>
                             <label class="endorse-item-name lab"><?=$k?> </label>                                     
                                                       
                         </fieldset>
                         </li>
                         <?php $j++; } } ?>
                     <div class="clear"></div>   
                </ul>
             </div>  
            </div>  
		<?php }else{ ?>
        	<?php if($user->id == $this->session->userdata('user_id')){ ?>
            <div class="mediacls">
            <div class="show-video pos-relative">
            <h3> Bucket List </h3>   
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/editbucket/0/'.$user->id);?>" class="">Add Bucket List</a>
                </div> 
            </div>   
           </div>     
        <?php } ?>        
       <?php } ?>
       
         <?php
			$fav_activities = get_user_meta($user->id, 'fav_activities');			 
			 if(($fav_activities) != ''){ ?>
             <div class="mediacls">
            <div class="show-blog pos-relative">
                <h3>Favorite Activities:</h3>	
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/editfavorite/0/'.$user->id);?>" class="">Add Or Edit Favorite Activities</a>
                </div> 
                <ul>
                	 <?php 
					     foreach(json_decode($fav_activities) as $fav_activitie){ ?>
                             -<span class="endorse-item-name"><?=$fav_activitie?> </span>    
                         <?php } ?>
                </ul>
             </div> 
            </div>   
		<?php }else{ ?>
        	<?php if($user->id == $this->session->userdata('user_id')){ ?>
            <div class="mediacls">
            <div class="show-video pos-relative">
            <h3> Favorite Activities </h3>   
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/editfavorite/0/'.$user->id);?>" class="">Add Favorite Activitie</a>
                </div> 
            </div> 
           </div>       
        <?php } ?>        
       <?php } ?>
        <?php
			$fav_sports = get_user_meta($user->id, 'fav_sports');			 
			 if(($fav_sports) != ''){ ?>
            <div class="mediacls"> 
            <div class="show-blog pos-relative">
                <h3>Favorite Sports:</h3>	
                 <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/editfavorite/0/'.$user->id);?>" class="">Add Or Edit Favorite Sports</a>
                </div> 
                <ul>
                	 <?php 
					     foreach(json_decode($fav_sports) as $fav_sport){ ?>
                             -<span class="endorse-item-name"><?=$fav_sport?> </span>    
                         <?php } ?>
                </ul>
             </div>  
           </div>   
		<?php }else{ ?>
        	<?php if($user->id == $this->session->userdata('user_id')){ ?>
            <div class="mediacls">
            <div class="show-video pos-relative">
            <h3>Favorite Sports </h3>   
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/editfavorite/0/'.$user->id);?>" class="">Add Favorite Sports</a>
                </div> 
            </div>     
           </div>  
        <?php } ?>        
       <?php } ?>
        <?php
			$fav_foods = get_user_meta($user->id, 'fav_foods');			 
			 if(($fav_foods) != ''){ ?>
             <div class="mediacls">
            <div class="show-blog pos-relative">
                <h3>Favorite Foods:</h3>	
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/editfavorite/0/'.$user->id);?>" class="">Add Or Edit Favorite Foods</a>
                </div> 
                <ul>
                	 <?php 
					     foreach(json_decode($fav_foods) as $fav_food){ ?>
                             -<span class="endorse-item-name"><?=$fav_food?> </span>    
                         <?php } ?>
                </ul>
             </div>
           </div>     
		<?php }else{ ?>
        	<?php if($user->id == $this->session->userdata('user_id')){ ?>
            <div class="mediacls">
            <div class="show-video pos-relative">
            <h3>Favorite Foods </h3>   
                <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                    <a href="<?php echo site_url('admin/editfavorite/0/'.$user->id);?>" class="">Add Favorite Foods</a>
                </div> 
            </div>     
            </div>  
        <?php } ?>        
       <?php } ?>
       
       <div class="ads2">
        <img src="<?php echo theme_url();?>/assets/images/ad_2.png">
    </div>

  <!--random video-->
	<div class="mediacls">
    	<div id="" class="view-random-video"></div>			
        <div class="clear"></div>		
    </div>
    
    
    <div class="mediacls">
        <h3>Random Blogs</h3>
        <ul class="bloglist">
            <?php foreach($random_user_blog->result() as $blog_user ){ ?>	
            	<li>
               		 <?php if($blog_user->value != ''){ ?>
   	 				<img src="<?php echo base_url('uploads/users/blog/'.$blog_user->value); ?>">
    			 <?php }else{ ?>
    	   			<img src="<?php echo base_url('assets/admin/img/gallery-preview.jpg'); ?>">
     			<?php } ?>
                <h4><a href="<?php echo site_url().'profile/blog/'.$blog_user->slug;?>"><?=$blog_user->title;?></a></h4>

            </li>
			
            <?php } ?>

            

            <div class="clear"></div>
        </ul>
        <div class="clear"></div>
        
    </div><!--blog-->
       
        
          <?php /*?>
			
            <div class="block-heading-two">
                <h3><span><i class="fa fa-user"></i> <?php echo lang_key('posts_by');?> : <?php echo get_user_fullname_by_id($user->id);?> (<?php echo get_user_properties_count($user->id);?>)</span>
                    <div class="pull-right list-switcher">                        
                        <a target="recent-posts" href="<?php echo site_url('show/memberposts_ajax/'.$per_page.'/list/'.$user->id);?>"></a>
                    </div>
                </h3>   
            </div>
            <span class="recent-posts">
            </span>
            <div class="ajax-loading recent-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>
            <a href="" class="load-more-recent btn btn-blue" style="width:100%"><?php echo lang_key('load_more_posts');?></a>

            <script type="text/javascript">
            var per_page = '<?php echo $per_page;?>';
            var recent_count = '<?php echo $per_page;?>';

            jQuery(document).ready(function(){
                jQuery('.list-switcher a').click(function(e){
                    jQuery('.list-switcher a').removeClass('selected');
                    jQuery(this).addClass('selected');
                    e.preventDefault();
                    var target = jQuery(this).attr('target');
                    var loadUrl = jQuery(this).attr('href');
                    jQuery('.recent-loading').show();
                    jQuery.post(
                        loadUrl,
                        {},
                        function(responseText){
                            jQuery('.'+target).html(responseText);
                            jQuery('.recent-loading').hide();
                            if(jQuery('.recent-posts > div').children().length<recent_count)
                            {
                                jQuery('.load-more-recent').hide();
                            }
                            fix_grid_height();
                        }
                    );
                });

                jQuery('.load-more-recent').click(function(e){
                        e.preventDefault();
                        var next = parseInt(recent_count)+parseInt(per_page);
                        jQuery('.list-switcher a').each(function(){
                            var url = jQuery(this).attr('href');
                            url = url.replace('/'+recent_count+'/','/'+next+'/');
                            jQuery(this).attr('href',url);
                        });
                        recent_count = next;
                        jQuery('.list-switcher > .selected').trigger('click');
                    });
            });
            </script>
            <?php */?>
        </div>


    </div>
</div>

<div id="reviewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel">Review Detail</h4>

            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
		 //load all video.
	    var loadUrl = '<?php echo site_url("show/load_random_user_video_view/");?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-random-video').html(responseText);                
            }
        );
		
		//load all review.
	    var loadUrl = '<?php echo site_url("show/load_all_user_review_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-review').html(responseText);
                init_load_more_user_review_js();
            }
        );
		 function init_load_more_user_review_js()
        {
		jQuery("#pagination-review a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-user-review-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-user-reviews').html(res);
			   jQuery('.recent-user-review-loading').hide();
			}
			});
			return false;
		});
	 }
	 // Load all user trophys	
	    var loadUrl = '<?php echo site_url("show/load_all_user_trophy_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-trophys').html(responseText);
                init_load_more_user_trophy_js();
            }
        );
		 function init_load_more_user_trophy_js()
        {
		jQuery("#pagination-trophy a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-user-trophy-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-user-trophys').html(res);
			   jQuery('.recent-user-trophy-loading').hide();
			}
			});
			return false;
		});
	 }
	 // Load all user two thumb	
	    var loadUrl = '<?php echo site_url("show/load_all_user_two_thumbs_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-two-thumbs').html(responseText);
                init_load_more_user_two_thumbs_js();
            }
        );
		 function init_load_more_user_two_thumbs_js()
        {
		jQuery("#pagination-two-thumbs a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-user-two-thumbs-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-user-two-thumbs').html(res);
			   jQuery('.recent-user-two-thumbs-loading').hide();
			}
			});
			return false;
		});
	 }
	 // Load all user single thumb	
	    var loadUrl = '<?php echo site_url("show/load_all_user_single_thumb_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-single-thumb').html(responseText);
                init_load_more_user_single_thumb_js();
            }
        );
		 function init_load_more_user_single_thumb_js()
        {
		jQuery("#pagination-single-thumb a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-user-single-thumb-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-user-single-thumb').html(res);
			   jQuery('.recent-user-single-thumb-loading').hide();
			}
			});
			return false;
		});
	 }
	 
	 
	});	 
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
       // $("#reviews-holder").mCustomScrollbar();
	   //load all blog.
	    var loadUrl = '<?php echo site_url("show/load_all_user_blog_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-blog').html(responseText);
                init_load_more_blog_js();
            }
        );
		 function init_load_more_blog_js()
        {
		jQuery("#pagination-blog a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-blog-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-blog').html(res);
			   jQuery('.recent-blog-loading').hide();
			}
			});
			return false;
		});
	 }
	  
       //load all video.
	    var loadUrl = '<?php echo site_url("show/load_all_user_video_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-video').html(responseText);
                init_load_more_video_js();
            }
        );
		 function init_load_more_video_js()
        {
		jQuery("#pagination-video a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-video-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-video').html(res);
			   jQuery('.recent-video-loading').hide();
			}
			});
			return false;
		});
	 }  
	   
	 // laod all images.
	  var loadUrl = '<?php echo site_url("show/load_all_user_image_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-image').html(responseText);
                init_load_more_image_js();
            }
        );
		 function init_load_more_image_js()
        {
		jQuery("#pagination-image a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-image-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-image').html(res);
			   jQuery('.recent-image-loading').hide();
			}
			});
			return false;
		});
	 }
    });   
</script>
<?php }else{ ?>
	<div class="container">
     <div class="alert alert-danger"><p>Invalid User</p></div>
    </div>
<?php } ?>


<script type="text/javascript">
    jQuery(document).ready(function(){
		jQuery('.bucktcls').find('input[type=checkbox]:checked').parent().parent().addClass('iamdone')
		  });   
		
		</script>