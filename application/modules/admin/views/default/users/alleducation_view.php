<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">
<?php 
$curr_page = $this->uri->segment(3);
if($curr_page=='')
  $curr_page = 0;
?>
<div class="row">
  <div class="col-md-12">
  	 <a href="<?php echo site_url('admin/neweducation/'.$curr_page.'/'.$userID);?>" class="btn btn-success add-location">Add New Education</a>
   <div style="clear:both;margin-top:20px;"></div>
   
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> All Education </h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">       
        <?php echo $this->session->flashdata('msg');?>
        <?php if($educations->num_rows()<=0){?>
        <div class="alert alert-info">No Education</div>
        <?php }else{?>
        <div id="no-more-tables">
        <table id="all-posts" class="table table-hover">
           <thead>
               <tr>
                  <th class="numeric">#</th>
                  <th class="numeric">School Name</th>                                
                  <th class="numeric"><?php echo lang_key('actions');?></th>
               </tr>
           </thead>
           <tbody>
        	<?php $i=1;foreach($educations->result() as $row):?>
               <tr>
                  <td data-title="#" class="numeric"><?php echo $i;?></td>
                  <td data-title="" class="numeric"><a href="<?php echo site_url('admin/editeducation/'. $curr_page.'/'.$row->id);?>"><?php echo $row->school_name;?></a></td>
                  
                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">
                    <div class="btn-group">
                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>
                      <ul class="dropdown-menu dropdown-info">
                          <li><a href="<?php echo site_url('admin/editeducation/'. $curr_page.'/'.$row->id);?>"><?php echo lang_key('edit');?></a></li>
                          <li><a href="<?php echo site_url('admin/deleteeducation/'.$row->id);?>"><?php echo lang_key('delete');?></a></li>
                      </ul>
                    </div>
                  </td>
               </tr>
            <?php $i++;endforeach;?>   
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