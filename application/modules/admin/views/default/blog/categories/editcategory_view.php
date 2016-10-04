<div class="row">	
  <div class="col-md-12">
  	<?php echo $this->session->flashdata('msg');?>
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo lang_key('edit_category');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">
      		
      		<form class="form-horizontal" id="addcategory" action="<?php echo site_url('admin/category_blog/updatecategory');?>" method="post">
      			<input type="hidden" name="id" value="<?php echo $post->id;?>"/>
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label"><?php echo lang_key('name');?>:</label>
					<div class="col-sm-4 col-md-4 controls">
						<input type="text" name="title" value="<?php echo(set_value('fa_icon')!='')?set_value('fa_icon'):$post->title;?>" placeholder="<?php echo lang_key('type_something');?>" class="form-control input-sm" >
						<?php echo form_error('title'); ?>
					</div>
				</div>				
			

				
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
<script type="text/javascript">
	var base_url = '<?php echo base_url();?>';
	jQuery(document).ready(function(){
		jQuery('#featured_photo_input').change(function(){
			var val = jQuery(this).val();
			if(val!='')
			{
				var src = base_url+'uploads/thumbs/'+val;
			}
			else
			{
				var src = base_url+'assets/admin/img/preview.jpg'
			}
			jQuery('#featured_photo').attr('src',src);
		}).change();

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