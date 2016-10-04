<?php 
$curr_page = $this->uri->segment(3);
if($curr_page=='')
  $curr_page = 0;
 $userID = $this->uri->segment(4);  

?>
<div class="row">	
  <div class="col-md-12">
  	<?php echo $this->session->flashdata('msg');?>
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> Add Or Edit </h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">
      		
      		<form class="form-horizontal"  action="<?php echo site_url('admin/updateimages/'.$curr_page);?>" method="post">            
                                
                    
                                    
                     <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo lang_key('gallery');?></label>
                    <div class="col-md-8">                        
						   <ul class="multiple-uploads">
						    <?php if(isset($_POST['gallery'])){ 
								$gallery = $_POST['gallery']; ?>							
								<?php foreach ($gallery as $item) { ?>
								<li class="gallery-img-list">
								  <input type="hidden" name="gallery[]" value="<?php echo $item;?>" />
								  <img src="<?php echo base_url('uploads/gallery/'.$item);?>" />
								  <div class="remove-image" onclick="jQuery(this).parent().remove();">X</div>
								</li>
								<?php }?>
						<?php }else{ ?>
							<?php 							 
							$tem_gallery = $images_list; ?>
                            <?php //$tem_gallery = (get_post_data($post->id,'gallery_img')); ?>
							 <?php if(count($tem_gallery)>0){ ?>							   
								<?php foreach ($tem_gallery->result() as $item) {  ?>
								<li class="gallery-img-list">
								  <input type="hidden" name="gallery[]" value="<?php echo $item->value;?>" />
								  <img src="<?php echo base_url('uploads/gallery/'.$item->value);?>" />
								  <div class="remove-image" onclick="jQuery(this).parent().remove();">X</div>
								</li>
								<?php }?>
								
							 <?php } ?>
						<?php } ?>		
							<li class="add-image" id="dragandrophandler">+</li>
							</ul>						
                        <div class="clearfix"></div>
                        <span class="gallery-upload-instruction"><?php echo lang_key('gallery_notes');?></span>
                        <div class="clearfix clear-top-margin"></div>
                    </div>
                </div>                    
                    <div class="clearfix"></div>
                    <div style="margin-top:20px"></div>
                    
                <hr/>

				
				<div class="clearfix"></div>

				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">&nbsp;</label>
					<div class="col-sm-4 col-md-4 controls">						
						<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo lang_key('save');?></button>
					</div>
				</div>


			</form>

	  </div>
    </div>
  </div>
</div>
<script src="<?php echo theme_url();?>/assets/js/jquery.form.js"></script>
<?php require'multiple-uploader.php';?>
<?php require'bulk_uploader_view.php';?>
<script type="text/javascript">

jQuery(document).ready(function(){
    
    jQuery('#photoimg').attr('target','.multiple-uploads');
    jQuery('#photoimg').attr('input','gallery');
    var obj = $("#dragandrophandler");
    obj.on('dragenter', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', '2px solid #0B85A1');
    });

    obj.on('dragover', function (e)
    {
         e.stopPropagation();
         e.preventDefault();
    });

    obj.on('drop', function (e)
    {
     
         $(this).css('border', '2px dotted #0B85A1');
         e.preventDefault();
         var files = e.originalEvent.dataTransfer.files;
         //console.log(files);
         //We need to send dropped files to Server
         handleFileUpload(files,obj);
    });

    $(document).on('dragenter', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
    });

    $(document).on('dragover', function (e)
    {
      e.stopPropagation();
      e.preventDefault();
      obj.css('border', '2px dotted #0B85A1');
    });
    
    $(document).on('drop', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
    });

    jQuery('.multiple-uploads > .add-image').click(function(){
        jQuery('#photoimg').attr('target','.multiple-uploads');
        jQuery('#photoimg').attr('input','gallery');
        jQuery('#photoimg').click();
    });

    jQuery( ".multiple-uploads" ).sortable();
});
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
	
	    
			
	
	
	
	jQuery('#parent').change(function(){
		var val = jQuery(this).val();
		if(val==0)
		{
			jQuery('.icon-class-holder').show();
		}
		else
		{
			jQuery('.icon-class-holder').hide();
		}

	}).change();
});
</script>
<style>
	

.gallery-img-list{
    margin:10px 10px 0 0;overflow:hidden;
}

.gallery-img-list img{
    height: 100%;
}
.gallery-upload-instruction{
    font-size:14px;font-style: italic;
}

.align-centre{
    text-align:center
}

.multiple-uploads{
    list-style: none;
    margin:0;
    padding: 0px;
}
.multiple-uploads li{
    width: 100px;
    height: 100px;
    float: left;
    margin-right: 10px;
    margin-top: 10px;
    cursor: move;
}
.multiple-uploads .add-image{
    border: 3px dashed #aaa;
    height: 100px;
    
    text-align: center;
    width: 100px;
    cursor: pointer !important;
    font-size: 65px;
    color: #aaa;
}
.multiple-uploads .add-image:hover{
    border: 3px dashed #78a;
    color: #78a;
}

.multiple-uploads .remove-image{
    color: red;
    cursor: pointer;
    float: right;
    font-size: 17px;
    font-weight: bold;
    left: -6px;
    position: relative;
    top: -102px;
    width: 10px;
}
</style>