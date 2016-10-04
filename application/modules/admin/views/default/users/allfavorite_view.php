<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">
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
  	 <a href="<?php echo site_url('admin/editfavorite/'.$curr_page.'/'.$userID);?>" class="btn btn-success add-location">Add New Favorite</a>
   <div style="clear:both;margin-top:20px;"></div>
   
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> All Favorite </h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">       
        <?php echo $this->session->flashdata('msg');?>
        <?php if(count($fav_activities)<=0 || count($fav_sports)<=0 || count($fav_foods)<=0 ){ ?>
        <div class="alert alert-info">No Favorite</div>
        <?php }else{?>
        <div id="no-more-tables">
        <table id="all-posts" class="table table-hover">
           <thead>
               <tr>                 
                  <th class="numeric">Favorite Activities</th>            
                  <th class="numeric">Favorite Sports</th>            
                  <th class="numeric">Favorite Foods</th>                                
                  <th class="numeric"><?php echo lang_key('actions');?></th>
               </tr>
           </thead>
           <tbody>        	
               <tr>                  
                  <td data-title="" class="numeric">
					 <?php if(count($fav_activities->value)>0){ 
                             if($fav_activities->value != 'null'){	
                             $ac=1;  $total_acts=count(json_decode($fav_activities->value));
                          foreach(json_decode($fav_activities->value) as $fav_activitie){								  
                              echo $fav_activitie; if($total_acts > $ac ){ echo ',';} 	?>                              
                           <?php  $ac++; } } ?>
                    <?php } ?>                  
				   </td>
                    <td data-title="" class="numeric">
					 <?php if(count($fav_sports->value)>0){ 
                             if($fav_sports->value != 'null'){	
                             $ac=1;  $total_acts=count(json_decode($fav_sports->value));
                          foreach(json_decode($fav_sports->value) as $fav_sports){								  
                              echo $fav_sports; if($total_acts > $ac ){ echo ',';} 	?>                              
                           <?php  $ac++; } } ?>
                    <?php } ?>                  
				   </td>
                   <td data-title="" class="numeric">
					 <?php if(count($fav_foods->value)>0){ 
                             if($fav_foods->value != 'null'){	
                             $ac=1;  $total_acts=count(json_decode($fav_foods->value));
                          foreach(json_decode($fav_foods->value) as $fav_foods){								  
                              echo $fav_foods; if($total_acts > $ac ){ echo ',';} 	?>                              
                           <?php  $ac++; } } ?>
                    <?php } ?>                  
				   </td>
                  
                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">
                    <div class="btn-group">
                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>
                      <ul class="dropdown-menu dropdown-info">
                          <li><a href="<?php echo site_url('admin/editfavorite/'. $curr_page.'/'.$userID);?>"><?php echo lang_key('edit');?></a></li>
                         
                      </ul>
                    </div>
                  </td>
               </tr>
           
           </tbody>
        </table>
        </div>

        <?php }?>
        </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#all-posts').dataTable();
    });
</script>