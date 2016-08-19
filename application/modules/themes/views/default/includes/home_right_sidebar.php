<div class="col-sm-4 homeright">
		<?php if($home_video->num_rows()>0){ ?>	
 		
         <h4><img src="<?php echo theme_url();?>/assets/images/logos.png">Review of the Day</h4>
         		<?php foreach($home_video->result() as $video){ ?>
               <div class="homevideo videoimg-home">                    
                    <a href="<?php echo $video->value;?>" class="swipebox-video-home" title="<?php echo $video->title;?>">
                        <img src="<?php echo theme_url();?>/assets/images/videoimg.png">
                    </a>                
              
             </div><!--video-->
             <?php } ?>
         <?php } ?>
         
         <h4><img src="<?php echo theme_url();?>/assets/images/logos.png">Partner</h4>
         <div class="partnerbox">
         <div class="owl-carousel">
                            <div class="item">
                            <p><img src="<?php echo theme_url();?>/assets/images/taskpapa.png"></p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et ma. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. </p>
                                
                            </div>
                                <div class="item">
                            <p><img src="<?php echo theme_url();?>/assets/images/taskpapa2.png"></p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et ma. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. </p>
                                
                            </div>
                            


                        </div>
         
         </div><!--partner-->
         <h4><img src="<?php echo theme_url();?>/assets/images/logos.png">Advertise</h4>
         <div class="addbox">
            <img src="<?php echo theme_url();?>/assets/images/ad1.png">
         </div><!--adds-->
         <h4><img src="<?php echo theme_url();?>/assets/images/logos.png">Blogs</h4>
         <div class="bloghome">
           <?php foreach($random_blogs->result() as $blog){?>
            	<div class="blog_in"><img src="<?php echo get_featured_photo_by_id($blog->featured_img);?>">
                <h4><a href="<?php echo site_url('blog-detail/'.$blog->id.'/'.dbc_url_title($blog->title));?>">
				<?php echo $blog->title; ?></a></h4></div>
           <?php } ?>
           
         </div><!--blog-->
      </div>