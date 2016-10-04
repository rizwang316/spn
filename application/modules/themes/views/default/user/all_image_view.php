<?php if($images->num_rows()>0){ ?>
 <div class="show-image pos-relative">
 	 <h3>Images</h3>
	 <?php if($user_id == $this->session->userdata('user_id')){ ?>
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php echo site_url('admin/editimages');?>" class="">Add User Images</a>
            </div>        
        <?php } ?>
    <div class="col-sm-12">
    <div class="ajax-loading recent-image-loading">
        <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
    </div>
</div>	    
<!--start -->
<ul class="imagelist">
	<?php  foreach($images->result() as $img){ ?>
         <li class="photo">
            <img src="<?php echo base_url('uploads/gallery/' .  $img->value); ?>" id="<?=$img->id?>" alt="" />       
        </li>    
    <?php } ?>
</ul>
<!--  end-->
    <div class="col-xs-12">  
        <div class="pagination-wrapper" id="pagination-image">
            <?php  echo $pagination_links->create_links();?>
        </div>
    </div>
    
</div>
<?php }else{ ?>
<?php if($user_id == $this->session->userdata('user_id')){ ?>
<div class="show-video pos-relative">
 		<h3> Images </h3>   
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php  echo site_url('admin/editimages');?>" class="">Add User Images</a>
            </div> 
     </div>       
        <?php } ?>
<?php } ?>

    

<script type="text/javascript">
// init
$(function(){   
	// on click photo. 
    $('.photo img').live('click',function (event) {
        if (event.preventDefault) event.preventDefault();	
		   var id = $(this).attr('id');
		   var action = 'get_images';
		   var action_url = '<?php echo base_url('show/load_user_images_popup');?>';	 
        	getPhotoPreviewAjx(id,action,action_url);
    });	
})
</script>
