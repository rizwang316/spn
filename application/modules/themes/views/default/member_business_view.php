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
          </div>
            
          <div class="clear"></div>
          </section>
       <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">            
           
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




<?php }else{ ?>
	<div class="container">
     <div class="alert alert-danger"><p>Invalid User</p></div>
    </div>
<?php } ?>