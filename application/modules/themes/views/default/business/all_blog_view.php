<?php if($blogs->num_rows()>0){ ?>
 <div class="show-blog  pos-relative">
<h3>Blogs</h3>
    <?php if($created_by == $this->session->userdata('user_id')){ ?>
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php echo site_url('admin/business/blog_manage/'.$post_id);?>" class="">Add More Blog Post</a>
            </div>        
        <?php } ?>
    <div class="col-sm-12">
    <div class="ajax-loading recent-blog-loading">
        <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
    </div>
</div>	    
<?php   
$i=1;
 echo '<ul class="bloglist">';
foreach($blogs->result() as $blog){
$i++;
 ?>
   <li>  
     <?php if($blog->value != ''){ ?>
   	 		<img src="<?php echo base_url('uploads/business/blog/'.$blog->value); ?>">
     <?php }else{ ?>
    	   <img src="<?php echo base_url('assets/admin/img/preview.jpg'); ?>">
     <?php } ?>
     <h4>
     	<a href="<?php echo site_url().'business/blog/'.$blog->slug;?>"><?php echo $blog->title;?></a>
     </h4>
</li>    
<?php } ?>
</ul>
    <div class="col-xs-12">  
        <div class="pagination-wrapper" id="pagination-blog">
            <?php  echo $pagination_links->create_links();?>
        </div>
    </div>
</div> 
<?php }else{ ?>
<?php if($created_by == $this->session->userdata('user_id')){ ?>
<div class="show-video pos-relative">
 		<h3> Blogs </h3>   
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php  echo site_url('admin/business/blog_manage/'.$post_id);?>" class="">Add Blog Post</a>
            </div> 
     </div>       
        <?php } ?>
<?php } ?>