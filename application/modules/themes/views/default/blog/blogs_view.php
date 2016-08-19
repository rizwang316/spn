<div class="container">
           <div class="blogmain">
              <div class="col-sm-2 blogleft">
              
              	<?php include('blog-sidebar-left.php'); ?>              
               
              </div>
              <div class="col-sm-7">
              <div class="blogdearch">
                <input type="text" placeholder="Blog Search"> <input type="submit" value="search">
              </div>
              	<?php
                if($posts->num_rows()<=0){
                    ?>
                    <div class="alert alert-warning"><p>No blog post!</p></div>
                <?php
                }
                else
                    foreach($posts->result() as $post){ 					  
                        $title = $post->title;
                        $desc =  $post->description;
                        ?>
                        <div class="blogdiv">
                          <a href="<?php echo site_url('blog-detail/'.$post->id.'/'.dbc_url_title($title));?>">
                          <img src="<?php echo get_featured_photo_by_id($post->featured_img);?>" alt="" class="img-responsive img-thumbnail" /></a>
                        <h4><a href="<?php echo site_url('blog-detail/'.$post->id.'/'.dbc_url_title($title));?>"><?php echo $title;?></a></h4>
                        <p><?php echo truncate(strip_tags($desc),400,'',false);?></p>
                                        
                        <a class="blogmore" href="<?php echo site_url('blog-detail/'.$post->id.'/'.dbc_url_title($title));?>">Read more...</a>
                </div><!--blog-->
                        
                         <?php } ?>
                <ul class="pagination">
                    <?php echo (isset($pages))?$pages:'';?>
                </ul>

             
                
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