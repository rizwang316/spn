<?php 
$curr_page = $this->uri->segment(3);
if($curr_page=='')
  $curr_page = 0;
 $userID = $this->uri->segment(4);
 $fav_activities = $fav_activities->row();
 $fav_sports = $fav_sports->row();
  $fav_foods = $fav_foods->row();
?>
<div class="row">	
  <div class="col-md-12">
  	<?php echo $this->session->flashdata('msg');?>
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> Edit Favorite </h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">
      		
      		<form class="form-horizontal" id="addcategory" action="<?php echo site_url('admin/updatefavorite/'.$curr_page.'/'.$userID);?>" method="post">
            
                    <div class="box">     
                       <div class="box-title">
                        <h3>Add Or Edit Favorite Activities </h3>
                        <div class="box-tool">
                        </div>
                      </div>
                    </div>            
                    
                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 control-label">Add Favorite Activities:</label>
                        <div class="col-sm-4 col-md-4 controls">
                             <input type="text" name="" value="" placeholder="Favorite Activities" class="form-control input-sm favorite-activities" >
                             
                        </div>
                        <div class="col-sm-2 col-md-2 controls">
                            <a href="javascript:void(0)" class="add-favorite-activities btn btn-primary" > Add Activities </a>
                        </div>
                    <div class="clearfix"></div>
                    </div>
                         
                    <div class="form-group">
                    <label class="col-sm-3 col-md-3 control-label"></label>
                    <div class="col-sm-4 col-md-4 controls">                         
                    <div class="show_favrite_activities show_favrite">
                        <?php if(count($fav_activities)>0){ 						            
								 if($fav_activities->value != 'null'){	
                              foreach(json_decode($fav_activities->value) as $fav_activitie){	?>
                           <fieldset>
                             <span class="endorse-item-name"><?=$fav_activitie?> </span>                                      <span class="remove-fav-activities remove-fav">×</span>
                              <input type="hidden" value="<?=$fav_activitie?>" name="fav_activities[]"/>
                         </fieldset>
                         <?php } } ?>
                        <?php } ?>
                    </div>
                    <?php echo form_error('fav_activities[]'); ?>                        
                    </div>
                    </div>                    
                     <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">&nbsp;</label>
					<div class="col-sm-4 col-md-4 controls">						
						<button class="btn btn-primary" name="submit_activities" value="submit_activities" type="submit"><i class="fa fa-check"></i> <?php echo lang_key('save');?></button>
					</div>
				</div>
                    <div class="clearfix"></div>
                    <div style="margin-top:20px"></div>
                    
                    <div class="box">     
                       <div class="box-title">
                        <h3>Add Or Edit Favorite Sports </h3>
                        <div class="box-tool">
                        </div>
                      </div>
                    </div>            
                    
                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 control-label">Add Favorite Sports:</label>
                        <div class="col-sm-4 col-md-4 controls">
                             <input type="text" name="" value="" placeholder="Favorite Sports" class="form-control input-sm favorite-sports" >
                            
                        </div>
                        <div class="col-sm-2 col-md-2 controls">
                            <a href="javascript:void(0)" class="add-favorite-sports btn btn-primary" > Add Sports </a>
                        </div>
                    <div class="clearfix"></div>
                    </div>
                         
                    <div class="form-group">
                    <label class="col-sm-3 col-md-3 control-label"></label>
                    <div class="col-sm-4 col-md-4 controls">                         
                    <div class="show_favrite_sports show_favrite">
                        <?php if(count($fav_sports)>0){ 								
							   if($fav_sports->value != 'null'){								
                              foreach(json_decode($fav_sports->value) as $fav_sport){	?>
                           <fieldset>
                             <span class="endorse-item-name"><?=$fav_sport?> </span>                                     
                              <span class="remove-fav-sports remove-fav">×</span>
                              <input type="hidden" value="<?=$fav_sport?>" name="fav_sports[]"/>
                         </fieldset>
                         <?php } } ?>
                        <?php } ?>
                    </div>
                    <?php echo form_error('fav_sports[]'); ?>                        
                    </div>
                    </div>   
                     <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">&nbsp;</label>
					<div class="col-sm-4 col-md-4 controls">						
						<button class="btn btn-primary" name="submit_sports" value="submit_sports" type="submit"><i class="fa fa-check"></i> <?php echo lang_key('save');?></button>
					</div>
				</div>
                                 
                    <div class="clearfix"></div>
                    <div style="margin-top:20px"></div>
                    <div class="box">     
                       <div class="box-title">
                        <h3>Add Or Edit Favorite Foods </h3>
                        <div class="box-tool">
                        </div>
                      </div>
                    </div>            
                    
                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 control-label">Add Favorite Foods:</label>
                        <div class="col-sm-4 col-md-4 controls">
                             <input type="text" name="" value="" placeholder="Favorite Foods" class="form-control input-sm favorite-foods" >
                             
                        </div>
                        <div class="col-sm-2 col-md-2 controls">
                            <a href="javascript:void(0)" class="add-favorite-foods btn btn-primary" > Add Foods </a>
                        </div>
                    <div class="clearfix"></div>
                    </div>
                         
                    <div class="form-group">
                    <label class="col-sm-3 col-md-3 control-label"></label>
                    <div class="col-sm-4 col-md-4 controls">                         
                    <div class="show_favrite_foods show_favrite">
                        <?php if(count($fav_foods)>0){ 
								if($fav_foods->value != 'null'){	
                              foreach(json_decode($fav_foods->value) as $fav_food){	?>
                           <fieldset>
                             <span class="endorse-item-name"><?=$fav_food?> </span>                                     
                              <span class="remove-fav-foods remove-fav">×</span>
                              <input type="hidden" value="<?=$fav_food?>" name="fav_foods[]"/>
                         </fieldset>
                         <?php } } ?>
                        <?php } ?>
                    </div>
                    <?php echo form_error('fav_foods[]'); ?>                        
                    </div>
                    </div>                    
                    <div class="clearfix"></div>
                    
                 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">&nbsp;</label>
					<div class="col-sm-4 col-md-4 controls">						
						<button class="btn btn-primary" name="submit_foods" value="submit_foods" type="submit"><i class="fa fa-check"></i> <?php echo lang_key('save');?></button>
					</div>
				</div>


			</form>

	  </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('keyup keypress', 'form input[type="text"]', function(e) {
  if(e.which == 13) {
    e.preventDefault();
    return false;
  }
});

jQuery(document).ready(function(){
	
	    // add favorite activities.
		jQuery('.add-favorite-activities').click(function(){
		 var val = $('.favorite-activities').val();
		 if(val != ''){
		     $('.show_favrite_activities').append(' <fieldset><span class="endorse-item-name">'+val+'</span><span class="remove-fav-activities remove-fav">×</span><input type="hidden" value="'+val+'" name="fav_activities[]"/></fieldset>');
			 $('.favorite-activities').val('');
		 }else{
			 alert('please Enter value!');
			 }
		});
		jQuery('.remove-fav-activities').live('click',function(){
			$(this).parent().remove();
			});
			// sports
			jQuery('.add-favorite-sports').click(function(){
			 var val = $('.favorite-sports').val();
			 if(val != ''){
				 $('.show_favrite_sports').append(' <fieldset><span class="endorse-item-name">'+val+'</span><span class="remove-fav-sports remove-fav">×</span><input type="hidden" value="'+val+'" name="fav_sports[]"/></fieldset>');
				 $('.favorite-sports').val('');
			 }else{
				 alert('please Enter value!');
				 }
		});
		jQuery('.remove-fav-sports').live('click',function(){
			$(this).parent().remove();
			});
			// foods
			jQuery('.add-favorite-foods').click(function(){
			 var val = $('.favorite-foods').val();
			 if(val != ''){
				 $('.show_favrite_foods').append(' <fieldset><span class="endorse-item-name">'+val+'</span><span class="remove-fav-foods remove-fav">×</span><input type="hidden" value="'+val+'" name="fav_foods[]"/></fieldset>');
				 $('.favorite-foods').val('');
			 }else{
				 alert('please Enter value!');
				 }
		});
		jQuery('.remove-fav-foods').live('click',function(){
			$(this).parent().remove();
			});
	
	
	
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
	.endorse-item-name{ background:#f0f0f0; padding:5px;}
	.remove-fav{  background:#f0f0f0; padding:5px;  cursor:pointer}
	.show_favrite fieldset{ display:inline-block; margin:5px; margin-top:10px }
</style>