<div class="row">
<?php
$curr_page = $this->uri->segment(3);
if($curr_page=='')
  $curr_page = 0;
?>
<?php if(isset($video)){ 	$video = $video->row(); }	 ?>
  <div class="col-md-12">
  
  <a href="<?php echo site_url('admin/view_all_video');?>" class="btn btn-success add-location">View Video</a>
  <?php if(isset($id)){?>
 	 <a href="<?php echo site_url('admin/add_video');?>" class="btn btn-success add-location">Add Video</a>
  <?php }?>
   <div style="clear:both;margin-top:20px;"></div>
   

	<form action="<?php echo site_url('admin/add_video');?>" method="post">

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
        <input type="hidden" name="current_page" value="<?php echo $curr_page; ?>">

        <?php if(isset($id)){?>
		<input type="hidden" name="id" value="<?php echo $id ;?>">
		<?php }?>
        

		<?php echo $this->session->flashdata('msg');?>

		<div class="form-group">
			<div class="col-sm-12 col-md-12 col-lg-12">

				<input type="submit" value="Publish" class="btn btn-success submit" action="1">
				
			</div>
		</div>	

		<div style="margin-bottom:20px;"></div>		

		<div style="clear:both"></div>
        			<div class="form-group">

							<label class="col-sm12 col-lg-12 control-label"><?php echo lang_key('title');?></label>

							<div class="col-sm-12 col-lg-12 controls">
							<?php 

									$v = '';

									if(set_value('title')!='')

										$v = set_value('title');

									else if(isset($video) && isset($video->title))
									{
										$v = $video->title;
									}

								?>	 
								 <input type="text" name="title" placeholder="<?php echo lang_key('title');?>" value="<?php echo $v;?>" class="form-control">                         
                           

								<span class="help-inline">&nbsp;</span>

								<?php echo form_error('title'); ?>

							</div>

						</div>

						<div style="clear:both"></div>
                        

				<div class="form-group">

							<label class="col-sm12 col-lg-12 control-label"><?php echo lang_key('video_url');?></label>

							<div class="col-sm-12 col-lg-12 controls">
							<?php 

									$v = '';

									if(set_value('video_url')!='')

										$v = set_value('video_url');

									else if(isset($video) && isset($video->value))
									{
										$v = $video->value;
									}

								?>	
								 <span id="video_preview"></span>
                            <input id="video_url" type="text" name="video_url" placeholder="<?php echo lang_key('video_url');?>" value="<?php echo $v;?>" class="form-control">
                            <span class="help-inline"><?php echo lang_key('video_notes');?></span>
                            <?php echo form_error('video_url');?>
							</div>
						</div>
                   
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




<script type="text/javascript">


var base_url = '<?php echo base_url();?>';
jQuery(document).ready(function(){	

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

<script type="text/javascript">
    function getUrlVars(url) {
        var vars = {};
        var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

    function showVideoPreview(url)
    {
        if(url.search("youtube.com")!=-1)
        {
            var video_id = getUrlVars(url)["v"];
            //https://www.youtube.com/watch?v=jIL0ze6_GIY
            var src = '//www.youtube.com/embed/'+video_id;
            //var src  = url.replace("watch?v=","embed/");
            var code = '<iframe class="thumbnail" width="80%" height="400" src="'+src+'" frameborder="0" allowfullscreen></iframe>';
            jQuery('#video_preview').html(code);
        }
		/*
        else if(url.search("vimeo.com")!=-1)
        {
            //http://vimeo.com/64547919
            var segments = url.split("/");
            var length = segments.length;
            length--;
            var video_id = segments[length];
            var src  = url.replace("vimeo.com","player.vimeo.com/video");
            var code = '<iframe class="thumbnail" src="//player.vimeo.com/video/'+video_id+'" width="80%" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            jQuery('#video_preview').html(code);
        }*/
        else
        {
           // alert("only youtube and video url is valid");
        }
    }

    jQuery(document).ready(function(){
    jQuery('#video_url').change(function(){
        var url = jQuery(this).val();
        showVideoPreview(url);
    }).change();

});
</script>

