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
               <?php if(count($blogpost)<=0){ ?>
                    <div class="alert alert-danger"><p>No blog post!</p></div>
                <?php  }else{ ?>
                	<?php if($blogpost->featured_img != ''){ ?>
					 <img src="<?php echo base_url('uploads/images/' . $blogpost->featured_img); ?>" alt="">
                     <?php } ?>
                  <h4><?php echo $blogpost->title; ?> </h4>
                   <p><?php echo $blogpost->description;?></p>
				 <?php } ?>                  
                </div><!--blog-->                
                 
                 <div class="commintblog">
                     <div class="bloglikes">
                      <table class="ratingcls">
                        <tbody><tr>
                             <td><img src="<?php echo theme_url();?>/assets/images/single_thumb.png"> <span>12</span></td>
                             <td><img src="<?php echo theme_url();?>/assets/images/double_thumb.png"> <span>12</span></td>
                             <td><img src="<?php echo theme_url();?>/assets/images/trophy.png"> <span>12</span></td>
                            <td><img src="<?php echo theme_url();?>/assets/images/shareicon.png"> <span>2</span></td>
                            </tr>
                      </tbody></table>
                     </div><!---->
                 <form>
                    <textarea></textarea>
                    <input type="submit">
                 </form>
                 </div>
               
            
                
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