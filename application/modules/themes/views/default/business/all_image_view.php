<?php if($images->num_rows()>0){ ?>
 <div class="show-image  pos-relative">
<h3>Images</h3>
<?php if($created_by == $this->session->userdata('user_id')){ ?>
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php echo site_url('edit-business/0/'.$post_id);?>" class="">Add More Images</a>
            </div>        
        <?php } ?>
    <div class="col-sm-12">
    <div class="ajax-loading recent-image-loading">
        <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
    </div>
</div>	    
<?php   
$i=1;
 echo '<ul class="imagelist">';
foreach($images->result() as $img){
$i++;
 ?>
 <li class="box">
    <a href="<?php echo base_url('uploads/gallery/' .  $img->value); ?>" class="swipebox">
    <img src="<?php echo base_url('uploads/gallery/' .  $img->value); ?>" alt="" />
    </a>
</li>    
<?php } ?>
</ul>
    <div class="col-xs-12">  
        <div class="pagination-wrapper" id="pagination-image">
            <?php  echo $pagination_links->create_links();?>
        </div>
    </div>
</div>
<script src="<?php echo theme_url();?>/assets/js/ios-orientationchange-fix.js"></script>
<script src="<?php echo theme_url();?>/assets/js/jquery.swipebox.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
		/* Basic Gallery */
		$( '.swipebox' ).swipebox();

  });
</script>
<?php }else{ ?>
<?php if($created_by == $this->session->userdata('user_id')){ ?>
<div class="show-video pos-relative">
 		<h3> Images </h3>   
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php  echo site_url('edit-business/0/'.$post_id);?>" class="">Add More Images</a>
            </div> 
     </div>       
        <?php } ?>
<?php } ?>