<div class="container">
<div class="creat_account">
             <div class="col-sm-5">
              <h4>Service Professionals Network</h4>
              <p>is the best way to find great local businesses</p>
              <p>People use SPN to search for everything from the city's tastiest 
burger to the most  renowned cardiologist. What will you uncover
in your neighborhood?</p>
             </div>
              <div class="col-sm-6">
                   
               		  <a href="<?php if(!is_loggedin()){ echo site_url('account/login'); }else{ echo site_url('admin'); }?>">Create Your <span>Free</span> Account</a>
              </div>
              <div class="clear"></div>
          </div><!--creat-->
<div class="homebody">
        
          <div class="col-sm-8">          
           <div class="searcchox">
           		<?php require 'home_custom_search.php';  ?>           
           <div class="clear"></div>
           </div><!--searchbox-->
           <div class="servic">
           <h6>Claim your business and advertise on the</h6>
           <h4>Service Professionals Network</h4>
           <h3>FOR FREE TODAY!!</h3>
           <p>Respond to reviews. Post picture & videos. Get serious SEO value with a 2,000-word description of your business. Post all of your social media and other review site links in one convenient spot</p>
            
           </div><!--service-->
           
           <?php if($recent_review->num_rows() > 0){ ?>
           		<div class="recent_review">
                <h4>New Reviews</h4>
              <?php  $this->load->model('user/post_model');?>
              <?php foreach($recent_review->result() as $review){
					    $postdata = $this->post_model->get_post_by_id($review->post_id); 
						$post =$postdata->row();
						$detail_link = post_detail_url($post);
				?>
                <div class="reviewbox">
               <div class="rewimg">
               	<a href="<?php echo site_url('profile/'.$review->created_by.'/'.get_user_fullname_by_id($review->created_by));?>">
             <img alt="user-image" src="<?php echo get_profile_photo_by_id($review->created_by); ?>" class="img-responsive user-img">
         </a>
               </div>
               <div class="reviedetail">
               
                  <table class="revi_title">
                    <tbody>
                      <tr>
                        <td> <a href="<?php  echo site_url('profile/'.$review->created_by.'/'.get_user_fullname_by_id($review->created_by));?>"> <?php echo get_user_fullname_by_id($review->created_by); ?> </a>  wrote a review for 
                        	<a href="<?=$detail_link?>"><?=$post->title?></a> </td>
                        <td><?php echo time_elapsed_string(date('Y-m-d H:i:s', $review->create_time)); ?></td>
                      </tr>                     
                    </tbody>
                  </table>
              <table class="ratingcls">
                        <tr>
                        <?php if(get_all_post_single_thumb_count($post->id) > 0){ ?>
                            <td><img src="<?php echo theme_url();?>/assets/images/single_thumb.png"><span><?=get_all_post_single_thumb_count($post->id)?></span></td>
                        <?php  } ?>
                        <?php if(get_all_post_double_thumb_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/double_thumb.png"><span><?=get_all_post_double_thumb_count($post->id)?></span></td> 
                        <?php } ?>
                        <?php if(get_all_post_trophy_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/trophy.png"><span><?=get_all_post_trophy_count($post->id)?></span></td>
                        <?php } ?>
                        </tr>
                    </table>
      <p class="ra-date">  <?php echo date('m/d/Y', $review->create_time); ?> </p> 
      
                  <p><?php echo truncate(strip_tags($review->comment),200,'&nbsp;',false);?></p>
                                     
                     <?php $emotions =  json_decode($review->emotions); ?>
                   	 <?php if(!empty($emotions)){  foreach($emotions as $emotion){ ?>
                    	 <span><img src="<?php echo theme_url();?>/assets/images/<?=$emotion?>_1.png" /></span>
						<?php }  }?>	
                   
                      <p class="review_was"><span>Was this review …?</span>
                        <a href="#" class="infocls">Informative</a>
                        <a href="#" class="funcls">Funny</a>
                        <a href="#" class="awecls">Awesome</a>
                        <a href="#" class="suscls">Suspect</a>
                        <a href="#" class="buscls">Business Reply</a>
                    </p>
               </div>
               <div class="clear"></div>
             </div><!--reviewbox-->
                <?php 	} ?>             
           </div><!--recent-->
           <?php }else{ ?>
           <div class="recent_review">
                <h4>New Reviews</h4>
                <div class="alert alert-info" role="alert">There is no review given.</div>
                <div class="clear"></div>
             </div><!--reviewbox-->
           <?php } ?>
           
           <div class="connectlove">
              <div class="clove1"><img src="<?php echo theme_url();?>/assets/images/connectlove.png"></div>
              <div class="clove2"><img src="<?php echo theme_url();?>/assets/images/connectloveimg.png"></div>
              <div class="clove3"><h3>Connecting With Love</h3>
              <p>While our goal is certainly to help you grow your business and allow consumers to review your business in a more fair manner than other review sites, we also want to help those in the greatest need. So a portion of every dollar that the Service Professionals Network generates will be donated to CONNECTING with Love to insure the kids under their care get access to fresh water, food, clothing, education, housing, and a chance to learn how to take care of themselves through entrepreneur training.</p>
              </div>
              <div class="clear"></div>
           </div><!--connectlove-->
          </div><!--8-->
          
          <?php include('includes/home_right_sidebar.php'); ?>
          
          
          
          <div class="clear"></div>
          </div><!--homebody-->
</div>

<link rel="stylesheet" href="<?php echo theme_url(); ?>/assets/css/swipebox.css">        
 <script src="<?php echo theme_url();?>/assets/js/ios-orientationchange-fix.js"></script>
	<script src="<?php echo theme_url();?>/assets/js/jquery.swipebox.js"></script>
	<script type="text/javascript">
	jQuery( document ).ready(function() {
			/* Video */
	  jQuery( '.swipebox-video-home' ).swipebox();
		/* Dynamic Gallery */
	 jQuery( ".videoimg-home" ).each(function( i ) {
	 var  url =jQuery(this).find('a').attr("href");
     var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
     var match = url.match(regExp);
    if (jQuery(match&&match[7].length==11)){ 
	jQuery(this).find('img').attr('src','http://img.youtube.com/vi/' + match[7] + '/0.jpg')   
    }
  });

      });
	</script>
