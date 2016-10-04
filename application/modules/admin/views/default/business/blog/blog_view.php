<div class="row">

<?php if(isset($blog)){ 	$blog = $blog->row(); }	 ?>

  <div class="col-md-12">
  
   <a href="<?php echo site_url('admin/business/view_all_blogs/0/'.$business_id);?>" class="btn btn-success add-location">Blog List</a>
    <?php if(isset($blog)){?>
    <a href="<?php echo site_url('admin/business/blog_manage/'.$business_id);?>" class="btn btn-success add-location">Add New Blog Post</a>
    <?php } ?>
   <div style="clear:both;margin-top:20px;"></div>

	<form action="<?php echo site_url('admin/business/add_blog');?>" method="post">

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo $title;?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>



        </div>

      </div>

      <div class="box-content">

		<input type="hidden" id="action" name="action" value="1">

		<input type="hidden" name="action_type" value="<?php echo (isset($action_type))?$action_type:'insert';?>">

		<?php if(isset($business_id)){?>
		<input type="hidden" name="business_id" value="<?php echo $business_id;?>">
		<?php }?>
        <?php if(isset($blog)){?>
		<input type="hidden" name="id" value="<?php echo $blog->id ;?>">
		<?php }?>
        

		<?php echo $this->session->flashdata('msg');?>

		<div class="form-group">
			<div class="col-sm-12 col-md-12 col-lg-12">

				<input type="submit" value="Publish" class="btn btn-success submit" action="1">
				
			</div>
		</div>	

		<div style="margin-bottom:20px;"></div>		
		<div style="clear:both"></div>
              		<?php 	
							
							$title = '';

							if(set_value('title')!=''){
								$title = set_value('title');
							}
							else if(isset($blog) && isset($blog->title))
							{
								$title = $blog->title;
							}

						?>

						<div class="form-group">

							<label class="col-sm12 col-lg-12 control-label"><?php echo lang_key('title');?></label>

							<div class="col-sm-12 col-lg-12 controls">

								<input type="text" class="form-control" name="title" id="title" value="<?php echo $title;?>" placeholder="<?php echo lang_key('type_something');?>" />

								<span class="help-inline">&nbsp;</span>

								<?php echo form_error('title'); ?>

							</div>

						</div>

						<div style="clear:both"></div>

						<div class="form-group">

							<label class="col-sm-12 col-lg-12 control-label"><?php echo lang_key('content');?></label>

							<div class="col-sm-12 col-lg-12 controls">

								<?php 

									$description = '';

									if(set_value('description')!='')

										$description = set_value('description');

									else if(isset($blog) && isset($blog->description))
									{
										$description = $blog->description;
									}

								?>		

								<textarea name="description" class="rich" style="height:434px"><?php echo $description;?></textarea>

								<span class="help-inline">&nbsp;</span>

								<?php echo form_error('description'); ?>

							</div>

						</div>



		<div style="clear:both"></div>	
            
        <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>
            <div class="col-sm-4 col-lg-5 controls">
                <img class="thumbnail" id="featured_photo" src="<?php echo get_featured_photo_by_id('');?>" style="width:256px;">
            </div>
            <div class="clearfix"></div>                   
            <span id="featured-photo-error"></span> 
        </div>

        <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('featured_image');?>:
            	<br/> <small>Min(250*180)</small>
            </label>
            
            <div class="col-sm-4 col-lg-5 controls">                    
            	<?php $featured_img = (isset($blog->value))?$blog->value:'';?>
            	<?php $v = (set_value('featured_img')!='')?set_value('featured_img'):$featured_img;?>
                <input type="hidden" name="featured_img" id="featured_photo_input" value="<?php echo $v;?>">                    
                <iframe src="<?php echo site_url('admin/business/featuredimguploader');?>" style="border:0;margin:0;padding:0;height:130px;"></iframe>
                <span class="help-inline">&nbsp;</span>
            </div>          
        </div>
        <div class="clearfix"></div>


		<div style="margin-bottom:20px;"></div>
		<div class="form-group">
			<div class="col-sm-12 col-md-12 col-lg-12">
				
				<input type="submit" value="<?php echo lang_key('publish'); ?>" class="btn btn-success submit" action="1">
				
			</div>
		</div>	


	 </div>

    </div>



	</form>

  </div>

</div>



<script type="text/javascript" src="<?php echo base_url('assets/tinymce/tinymce.min.js');?>"></script>

<script type="text/javascript">

tinymce.init({
	convert_urls : 0,
    selector: ".rich",

    plugins: [

         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",

         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",

         "save code table contextmenu directionality emoticons template paste textcolor"

   ]

 });

var base_url = '<?php echo base_url();?>';
jQuery(document).ready(function(){

	jQuery('#featured_photo_input').change(function(){
        var val = jQuery(this).val();
        if(val!='')
        {
          var src = base_url+'uploads/business/blog/thumbs/'+val;            
        }
        else
        {
          var src = base_url+'assets/admin/img/preview.jpg'
        }
        jQuery('#featured_photo').attr('src',src);
    }).change();

	jQuery('#layout').trigger('change');

	jQuery('.submit').click(function(e){

		jQuery('#action').val(jQuery(this).attr('action'));

	});



	jQuery('#content_from').change(function(){

		var content_from = jQuery(this).val();

		if(content_from=='Manual')

		{

			jQuery('.manual').show();

			jQuery('.url').hide();

		}

		else

		{

			jQuery('.manual').hide();

			jQuery('.url').show();			

		}

	}).change();



	jQuery('#title').keyup(function(e){

		makealias(jQuery(this).val());

	});



	jQuery('#title').change(function(e){

		makealias(jQuery(this).val());

	}).change();

});



function makealias(val)

{

	val = val.toLowerCase();

	val = val.replace(/\s/g, '');

	val = val.replace('[', '');

	val = val.replace(']', '');

	jQuery('#alias').val(val);

}



jQuery('#layout').change(function(){

	var val = jQuery(this).val();

	if(val==2)

	{

		jQuery('.left-bar').hide();

		jQuery('.right-bar').hide();

		jQuery('.main-content').css('width','100%');

	}

	else if(val==0)

	{

		jQuery('.left-bar').show();

		jQuery('.right-bar').hide();

		jQuery('.main-content').css('width','75%');

		

	}

	else if(val==1)

	{

		jQuery('.left-bar').hide();

		jQuery('.right-bar').show();

		jQuery('.main-content').css('width','75%');		

	}		

});

</script>

