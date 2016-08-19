<?php $blog= $blog->row(); ?>
<div class="container">

<div class="homebody">
        
          <div class="col-sm-8">  
          		 <?php if(count($blog)<=0){ ?>
                    <div class="alert alert-danger"><?php echo lang_key('post_not_found'); ?></div>
                <?php  }else{ ?>
                		  <?php if($blog->value != ''){ ?>	                
                			<img src="<?php echo base_url('uploads/users/blog/' . $blog->value); ?>" alt="">    
                          <?php } ?>	
            		  <h1><?php echo  $blog->title; ?></h1> 
                      <p><?php echo $blog->description;?></p>                       
            <?php } ?>           
          </div><!--8-->
          
          <div class="col-sm-4 homeright">
             <h4><img src="<?php echo theme_url();?>/assets/images/logos.png">Blogs</h4>
             <div class="bloghome">
             <?php foreach($random_user_blogs->result() as $blog){?>             
             	<div class="blog_in">
                		<?php if($blog->value != ''){ ?>	                
                			<img src="<?php echo base_url('uploads/users/blog/' . $blog->value); ?>" alt="">    
                          <?php }else{ ?>	
                          <img src="<?php echo site_url(); ?>/assets/admin/img/gallery-preview.jpg" alt=""> 
                          <?php } ?>
                <h4>
                <a href="<?=site_url();?>profile/blog/<?=$blog->slug?>">
					<?php echo $blog->title; ?></a>
                </h4></div>
                         	
           <?php } ?>
               
             </div><!--blog-->
          </div>
          <div class="clear"></div>
          </div><!--homebody-->
</div>