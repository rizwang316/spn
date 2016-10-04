<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">
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
  	 <a href="<?php echo site_url('admin/editbucket/'.$curr_page.'/'.$userID);?>" class="btn btn-success add-location">Add Or Edit New Bucket</a>
   <div style="clear:both;margin-top:20px;"></div>
   
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> All Bucket </h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">       
        <?php echo $this->session->flashdata('msg');?>
        <?php if(count($bucket_list)<=0 || count($causes)<=0 ){ ?>
        <div class="alert alert-info">No Bucket and causes</div>
        <?php }else{?>
        <div id="no-more-tables">
        <table id="all-posts" class="table table-hover">
           <thead>
               <tr>                             
                  <th class="numeric">Causes</th>            
                  <th class="numeric">Bucket List</th>                                
                  <th class="numeric"><?php echo lang_key('actions');?></th>
               </tr>
           </thead>
           <tbody>        	
               <tr>                  
                  <td data-title="" class="numeric">
					 <?php if(count($causes->value)>0){ 
                             if($causes->value != 'null'){	
                             $ac=1;  $total_acts=count(json_decode($causes->value));
                          foreach(json_decode($causes->value) as $causes){								  
                              echo $causes; if($total_acts > $ac ){ echo ',';} 	?>                              
                           <?php  $ac++; } } ?>
                    <?php } ?>                  
				   </td>
                    <td data-title="" class="numeric">
					 <?php if(count($bucket_list->value)>0){ 
                             if($bucket_list->value != 'null'){	
                             $ac=1;  $total_acts=count(json_decode($bucket_list->value));
                          foreach(json_decode($bucket_list->value) as $bucket_list){								  
                              echo $bucket_list; if($total_acts > $ac ){ echo ',';} 	?>                              
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