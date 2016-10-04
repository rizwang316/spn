<?php 
$curr_page = $this->uri->segment(3);
if($curr_page=='')
  $curr_page = 0;
 $userID = $this->uri->segment(4);
 $causes = $causes->row();
 $bucket_list = $bucket_list->row();
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
      		
      		<form class="form-horizontal" id="addcategory" action="<?php echo site_url('admin/updatebucket/'.$curr_page.'/'.$userID);?>" method="post">
            
                    <div class="box">     
                       <div class="box-title">
                        <h3>Add Or Edit Causes</h3>
                        <div class="box-tool">
                        </div>
                      </div>
                    </div>            
                    
                      <div class="form-group">
                        <label class="col-sm-3 col-md-3 control-label">Add Causes:</label>
                        <div class="col-sm-4 col-md-4 controls">
                           <?php
							$causesval = '';
							if(set_value('causes')!='')
							{
								$causesval = set_value('causes');
							}elseif(isset($causes) && isset($causes->value))
							{								
								$causesval = $causes->value;
							}
						?>
                            <textarea placeholder="Causes" name="causes" class="form-control"><?php echo $causesval; ?></textarea>
                              <?php echo form_error('causes'); ?>   
                             
                        </div>                        
                    <div class="clearfix"></div>
                    </div>      
                    <div class="clearfix"></div>

						<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">&nbsp;</label>
					<div class="col-sm-4 col-md-4 controls">						
						<button class="btn btn-primary" type="submit" name="submit_causes" value="causes"><i class="fa fa-check"></i> <?php echo lang_key('save');?></button>
					</div>
				</div>        
                    <div class="clearfix"></div>
                    <div style="margin-top:20px"></div>
                    <div class="box">     
                       <div class="box-title">
                        <h3>Add Or Edit Bucket List </h3>
                        <div class="box-tool">
                        </div>
                      </div>
                    </div>            
                    
                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 control-label">Add Bucket List:</label>
                        <div class="col-sm-4 col-md-4 controls">
                             <input type="text" name="" value="" placeholder="Bucket List" class="form-control input-sm bucket-list" >
                            
                        </div>
                        <div class="col-sm-2 col-md-2 controls">
                            <a href="javascript:void(0)" class="add-bucket-list btn btn-primary" > Add Bucket List </a>
                        </div>
                    <div class="clearfix"></div>
                    </div>
                         
                    <div class="form-group">
                    <label class="col-sm-3 col-md-3 control-label"></label>
                    <div class="col-sm-4 col-md-4 controls">                         
                    <div class="show_bucket_list show_favrite">
                        <?php if(count($bucket_list)>0){ 	
								$j=0;											
							   if($bucket_list->value != 'null'){								
                              foreach(json_decode($bucket_list->value) as $bucket_list){
								   foreach( $bucket_list as $k => $v){  ?>
                           <fieldset>
                             <input type="checkbox" value="1" <?php if($v == 1){ echo 'checked="checked"';}else{} ?>  name="bucket_list_value[<?=$j?>]"/>  
                             <input type="hidden" value="<?=$k?>" name="bucket_list[]"/>  
                             <span class="endorse-item-name"><?=$k?> </span>                                     
                              <span class="remove-bucket-list remove-fav">×</span>                             
                         </fieldset>
                         <?php $j++; } } } ?>
                        <?php } ?>
                    </div>
                    <?php echo form_error('bucket_list[]'); ?>                        
                    </div>
                    </div>                    
                    <div class="clearfix"></div>
                   
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">&nbsp;</label>
					<div class="col-sm-4 col-md-4 controls">						
						<button class="btn btn-primary" type="submit" name="submit_bucket" value="bucket"><i class="fa fa-check"></i> <?php echo lang_key('save');?></button>
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
		jQuery('.add-bucket-list').click(function(){
		 var val = $('.bucket-list').val();
		 if(val != ''){
			 var field_count = $(".show_bucket_list>fieldset").length;	
			 //field_count = field_count+1;		 	
		     $('.show_bucket_list').append('<fieldset><input type="checkbox" value="1" name="bucket_list_value['+field_count+']"/><input type="hidden" value="'+val+'" name="bucket_list[]"/><span class="endorse-item-name">'+val+'</span><span class="remove-bucket-list remove-fav">×</span></fieldset>');
			 $('.bucket-list').val('');
		 }else{
			 alert('please Enter value!');
			 }
		});
		jQuery('.remove-bucket-list').live('click',function(){
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