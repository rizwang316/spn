<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">

<div class="row">

  <div class="col-md-12">
  
    <a href="<?php echo site_url('admin/blog/manage'); ?>" class="btn btn-success add-location">
		New Post
    </a>
<div style="clear:both;margin-top:20px;"></div>

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_posts');?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>


        </div>

      </div>

      <div class="box-content">

        <?php $this->load->helper('text');?>

        <?php echo $this->session->flashdata('msg');?>

        <?php if($posts->num_rows()<=0){?>

        <div class="alert alert-info"><?php echo lang_key('no_posts');?></div>

        <?php }else{?>

        <div id="no-more-tables">

        <table id="all-posts" class="table table-hover">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric"><?php echo lang_key('categories');?></th>

                  <th class="numeric"><?php echo lang_key('title');?></th>

                  <th class="numeric"><?php echo lang_key('description');?></th>

                  <th class="numeric"><?php echo lang_key('status');?></th>
                   
                   <th class="numeric">View Comments</th>

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php $i=1;foreach($posts->result() as $row):?>

               <tr>

                  <td data-title="#" class="numeric"><?php echo $i;?></td>

                  <td data-title="<?php echo lang_key('type');?>" class="numeric">
				   <?php $categories = get_category_title_by_blog_id($row->id);					 
					   $total = count($categories);
					   $j=0;
					   foreach($categories as $category){
						   $j++;
						    echo $category->title;
							if($j != $total) echo ',';
						   }
					 ?></td>

                  <td data-title="<?php echo lang_key('title');?>" class="numeric"><a href="<?php echo site_url('admin/blog/manage/'.$row->id);?>"><?php echo $row->title;?></a></td>

                  <td data-title="<?php echo lang_key('description');?>" class="numeric"><?php echo truncate(encode_html($row->description),30,'...',false);?></td>

                  <td data-title="<?php echo lang_key('status');?>" class="numeric">

                    <?php if($row->status==1)

                          $status = '<span class="label label-success">'.lang_key('published').'</span>';

                          else if($row->status==2)

                          $status = '<span class="label label-warning">'.lang_key('drafted').'</span>';

                        echo $status;

                    ?>
                  </td>
                  
                  <td>
                   <a class="btn btn-info" href="<?php echo site_url('admin/blog/view_all_reviews/0/'.$row->id);?>"><?php echo lang_key('view_all_reviews');?></a>
                  </td>

                  

                   <?php $curr_page = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;?>

                   <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                       <div class="btn-group">

                           <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                           <ul class="dropdown-menu dropdown-info">

                               <li><a href="<?php echo site_url('admin/blog/manage/'.$row->id);?>" class="edit-location"><?php echo lang_key('edit');?></a></li>

                               <li><a href="<?php echo site_url('admin/blog/delete/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('delete');?></a></li>

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
});
</script>