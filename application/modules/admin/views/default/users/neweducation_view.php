<?php 
$curr_page = $this->uri->segment(3);
if($curr_page=='')
  $curr_page = 0;
 $userID = $this->uri->segment(4);
?>
<div class="row">	
  <div class="col-md-12">
     <a href="<?php echo site_url('admin/alleducation/'.$curr_page);?>" class="btn btn-success add-location">Education List</a>
      <div style="clear:both;margin-top:20px;"></div>
      
  	<?php echo $this->session->flashdata('msg');?>
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> New Education </h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">
      		
      		<form class="form-horizontal" id="addcategory" action="<?php echo site_url('admin/addeducation/'.$curr_page.'/'.$userID);?>" method="post">
				 
                 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">School Name:</label>
					<div class="col-sm-4 col-md-4 controls">
						<input type="text" name="school_name" value="<?php echo(set_value('school_name')!='')?set_value('school_name'):'';?>" placeholder="School Name" class="form-control input-sm" >
						<?php echo form_error('school_name'); ?>
					</div>
				</div>
                 <div class="form-group">
                
					<label class="col-sm-3 col-md-3 control-label">Dates Attended:</label>
					<div class="col-sm-4 col-md-4 controls">
					  <?php
					  	  $selected_s = (set_value('start_year')!='')?set_value('start_year'):'';
						  $currently_selected = date('Y');                   
						  $earliest_year = 1930;                  
						  $latest_year = date('Y');                 
						  echo '<select name="start_year" class="input-sm">'; 
						  echo '<option value="">-</option>';                
							  foreach ( range( $latest_year, $earliest_year ) as $i ) {                   
								echo '<option value="'.$i.'"'.($i == $selected_s ? ' selected="selected"' : '').'>'.$i.'</option>';
							  }
						  echo  '</select>';
                      ?>  
                       <?php
					     $selected = (set_value('end_year')!='')?set_value('end_year'):'';
						  $currently_selected = date('Y');                   
						  $earliest_year = 1950;                  
						  $latest_year = 2030;                 
						  echo '<select name="end_year" class="input-sm">'; 
						  echo '<option value="">-</option>';                
							  foreach ( range( $latest_year, $earliest_year ) as $i ) {                   
								echo '<option value="'.$i.'"'.($i == $selected ? ' selected="selected"' : '').'>'.$i.'</option>';
							  }
						  echo  '</select>';
                      ?>  						
						<?php echo form_error('start_year'); ?>
                        <?php echo form_error('end_year'); ?>
					</div>
				</div>				
				 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Degree:</label>
					<div class="col-sm-4 col-md-4 controls">
						<input type="text" name="degree" value="<?php echo(set_value('degree')!='')?set_value('degree'):'';?>" placeholder="Degree" class="form-control input-sm" >
						<?php echo form_error('degree'); ?>
					</div>
				</div>
				 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Field of Study:</label>
					<div class="col-sm-4 col-md-4 controls">
						<input type="text" name="study_field" value="<?php echo(set_value('study_field')!='')?set_value('study_field'):'';?>" placeholder="Field of Study" class="form-control input-sm" >
						<?php echo form_error('study_field'); ?>
					</div>
				</div>
				 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Grade:</label>
					<div class="col-sm-4 col-md-4 controls">
						<input type="text" name="grad" value="<?php echo(set_value('grad')!='')?set_value('grad'):'';?>" placeholder="Grade" class="form-control input-sm" >
						<?php echo form_error('grad'); ?>
					</div>
				</div>
				 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Activities and Societies:</label>
					<div class="col-sm-4 col-md-4 controls">
                    	<textarea name="activities"  placeholder="Activities" class="form-control input-sm"><?php echo(set_value('activities')!='')?set_value('activities'):'';?></textarea>
						<?php echo form_error('activities'); ?>
					</div>
				</div>
				 <div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">Description:</label>
					<div class="col-sm-4 col-md-4 controls">
                    <textarea name="description" placeholder="Description" class="form-control input-sm"><?php echo(set_value('description')!='')?set_value('description'):'';?></textarea>                    						
						<?php echo form_error('description'); ?>
					</div>
				</div>
				<div class="clearfix"></div>
                

				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label">&nbsp;</label>
					<div class="col-sm-4 col-md-4 controls">
						<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo lang_key('save');?></button>
					</div>
				</div>
				<div class="clearfix"></div>

			</form>

	  </div>
    </div>
  </div>
</div>
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