<?php 
$curr_page = $this->uri->segment(3);
if($curr_page=='')
  $curr_page = 0;
 $userID = $this->uri->segment(4);
?>
<div class="row">	
  <div class="col-md-12">
   <a href="<?php echo site_url('admin/newexperience/'.$curr_page.'/'.$userID);?>" class="btn btn-success add-location">Add New Experience</a>
   
     <a href="<?php echo site_url('admin/allexperience/'.$curr_page);?>" class="btn btn-success add-location">Experience List</a>
   <div style="clear:both;margin-top:20px;"></div>
   
  	<?php echo $this->session->flashdata('msg');?>
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> Edit Experience </h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">
      		
      		<form class="form-horizontal" id="addcategory" action="<?php echo site_url('admin/updateexperience/'.$curr_page.'/'.$userID);?>" method="post">
      			<input type="hidden" name="id" value="<?php echo $experience->id;?>"/>
                
				 
                 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Company Name:</label>
					<div class="col-sm-4 col-md-4 controls">
						<input type="text" name="company_name" value="<?php echo(set_value('company_name')!='')?set_value('company_name'):$experience->company_name;?>" placeholder="Company Name" class="form-control input-sm" >
						<?php echo form_error('company_name'); ?>
					</div>
				</div>
                 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Title:</label>
					<div class="col-sm-4 col-md-4 controls">
						<input type="text" name="title" value="<?php echo(set_value('title')!='')?set_value('title'):$experience->title;?>" placeholder="Title" class="form-control input-sm" >
						<?php echo form_error('title'); ?>
					</div>
				</div>
				 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Location:</label>
					<div class="col-sm-4 col-md-4 controls">
						<input type="text" name="location" value="<?php echo(set_value('location')!='')?set_value('location'):$experience->location;?>" placeholder="Location" class="form-control input-sm" >
						<?php echo form_error('location'); ?>
					</div>
				</div> 
                <div class="form-group">
                
					<label class="col-sm-3 col-md-3 control-label">Time Period:</label>
					<div class="col-sm-8 col-md-8 controls">
                    	<div class="col-md-5">  
                              <div class="col-md-6">             	
                       <?php $start_month=(set_value('start_month')!='')?set_value('start_month'):$experience->start_month;?>
					  	<select   class="input-sm" name="start_month">
                      	<option selected="selected" value="">Start Month..</option>
                            <option value="1" <?php if($start_month == '1'){ echo 'selected="selected"';} ?> >January</option>
                            <option value="2" <?php if($start_month == '2'){ echo 'selected="selected"';} ?>>February</option>
                            <option value="3" <?php if($start_month == '3'){ echo 'selected="selected"';} ?>>March</option>
                            <option value="4" <?php if($start_month == '4'){ echo 'selected="selected"';} ?>>April</option>
                            <option value="5" <?php if($start_month == '5'){ echo 'selected="selected"';} ?>>May</option>
                            <option value="6" <?php if($start_month == '6'){ echo 'selected="selected"';} ?>>June</option>
                            <option value="7" <?php if($start_month == '7'){ echo 'selected="selected"';} ?>>July</option>
                            <option value="8" <?php if($start_month == '8'){ echo 'selected="selected"';} ?>>August</option>
                            <option value="9" <?php if($start_month == '9'){ echo 'selected="selected"';} ?>>September</option>
                            <option value="10" <?php if($start_month == '10'){ echo 'selected="selected"';} ?>>October</option>
                            <option value="11" <?php if($start_month == '11'){ echo 'selected="selected"';} ?>>November</option>
                            <option value="12" <?php if($start_month == '12'){ echo 'selected="selected"';} ?>>December</option>
                        </select>
                       	</div>
                        
                        <div class="col-md-6"> 
                        <input type="text" name="start_year" value="<?php echo(set_value('start_year')!='')?set_value('start_year'):$experience->start_year;?>" placeholder="Start year"   class="form-control input-sm"  style="width:100px;" />
                      
                       </div>
                       </div>
                       <div class="col-md-1"> - </div>
                       <?php $current = (set_value('current')!='')?set_value('current'):$experience->present;?>
                       <div class="col-md-6">  
                       		 <div class="col-md-12">
                       		<div class="end_date" style=" <?php if($current == 'on' || $current == 1){ ?> display:none <?php }else{ ?>  <?php } ?>" > 
                        	<?php $end_month=(set_value('end_month')!='')?set_value('end_month'):$experience->end_month;?>
                        	<select name="end_month" class="input-sm" style="float:left">
                        	<option selected="selected" value="">End Month..</option>
                            <option value="1" <?php if($end_month == '1'){ echo 'selected="selected"';} ?> >January</option>
                            <option value="2" <?php if($end_month == '2'){ echo 'selected="selected"';} ?>>February</option>
                            <option value="3" <?php if($end_month == '3'){ echo 'selected="selected"';} ?>>March</option>
                            <option value="4" <?php if($end_month == '4'){ echo 'selected="selected"';} ?>>April</option>
                            <option value="5" <?php if($end_month == '5'){ echo 'selected="selected"';} ?>>May</option>
                            <option value="6" <?php if($end_month == '6'){ echo 'selected="selected"';} ?>>June</option>
                            <option value="7" <?php if($end_month == '7'){ echo 'selected="selected"';} ?>>July</option>
                            <option value="8" <?php if($end_month == '8'){ echo 'selected="selected"';} ?>>August</option>
                            <option value="9" <?php if($end_month == '9'){ echo 'selected="selected"';} ?>>September</option>
                            <option value="10" <?php if($end_month == '10'){ echo 'selected="selected"';} ?>>October</option>
                            <option value="11" <?php if($end_month == '11'){ echo 'selected="selected"';} ?>>November</option>
                            <option value="12" <?php if($end_month == '12'){ echo 'selected="selected"';} ?>>December</option>
                        </select>                            
                        <input type="text"  name="end_year" value="<?php echo(set_value('end_year')!='')?set_value('end_year'):$experience->end_year;?>" placeholder="End year"   class="form-control input-sm"  style="width:100px; float:left; margin-right:10px;" />
                        </div>
                        <div class="end_date_txt" style=" <?php if($current == 'on' || $current == 1){ ?><?php }else{ ?> display:none <?php } ?>"> 
                        	Present
                        </div>
                        <div  style="clear:both"></div>
                        </div>
                         <div class="col-md-12">
                        
                        <input type="checkbox" id="present" name="current" <?php if($current == 'on' || $current ==1){ ?>  checked="checked" <?php } ?>  /> I currently work here 
                       </div>
                       
                       	
						</div>
                        
					</div>
				</div>
                    
                 
				 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Description:</label>
					<div class="col-sm-4 col-md-4 controls">
                    <textarea name="description" placeholder="Description" class="form-control input-sm"><?php echo(set_value('description')!='')?set_value('description'):$experience->description;?></textarea>                    						
						<?php echo form_error('description'); ?>
					</div>
				</div>
				<div class="clearfix"></div>


				

				
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
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
				jQuery('.end_date').hide();
				jQuery('.end_date_txt').show();
				
               // alert("Checkbox is checked.");
            }
            else if($(this).prop("checked") == false){
				jQuery('.end_date_txt').hide();
				jQuery('.end_date').show();
				
                //alert("Checkbox is unchecked.");
            }
        });
    });
</script>
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