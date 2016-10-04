<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">
<?php 
$curr_page = $this->uri->segment(4);
if($curr_page=='')
  $curr_page = 0;
?>
<div class="row">
  

  <div class="col-md-12">
  
   <a href="<?php echo site_url('admin/add_blog/'.$curr_page);?>" class="btn btn-success add-location">Add New Blog Post</a>
   <div style="clear:both;margin-top:20px;"></div>

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_posts');?></h3>

        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>

      <div class="box-content">


        <?php echo $this->session->flashdata('msg');?>

        <?php if($blogs->num_rows()<=0){?>

        <div class="alert alert-info"><?php echo lang_key('no_posts_found');?></div>

        <?php }else{?>
        
        <div id="no-more-tables" class="table-responsive" style="border:0">

        <table id="all-posts" class="table table-hover table-advance">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric">Title</th>

                  <th class="numeric">Description </th>
                  
                   <th class="numeric">Comments</th>                 

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php $i=1;foreach($blogs->result() as $row):  ?>
            

               <tr>

                  <td data-title="#" class="numeric"><?php echo $i;?></td>

                  <td data-title="" class="numeric"><?php echo $row->title;?>      </td>

                  <td data-title="<?php echo lang_key('description');?>" class="numeric"><?php echo truncate(strip_tags($row->description),400,'',false);?></td>
                  
                   <td>
                   <a class="btn btn-info" href="<?php echo site_url('admin/view_all_reviews/0/'.$row->id);?>"><?php echo lang_key('view_all_reviews');?></a>
                  </td>

                  

                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                    <div class="btn-group">

                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                      <ul class="dropdown-menu dropdown-info">
                          <li><a class="" href="<?php echo site_url('admin/blog_manage/'.$row->id);?>"><?php echo lang_key('Edit');?></a></li>
                                                                           
                            
                          <li><a href="<?php echo site_url('admin/deleteblog/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('delete');?></a></li>                          
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
jQuery(document).ready(function(){
    jQuery('#all-posts').dataTable();   

    jQuery('.review-detail').click(function(e){
        e.preventDefault();
        var loadUrl = jQuery(this).attr('href');
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('#reviewModal .modal-body').html(responseText);
                jQuery('#reviewModal').modal('show');
            }
        );

    }); 
});
</script>

<div id="reviewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel"><?php echo lang_key('review'); ?></h4>

            </div>

            <div class="modal-body">


            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>

</div>