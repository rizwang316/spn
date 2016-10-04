<?php 
$curr_page = $this->uri->segment(5);
if($curr_page=='')
  $curr_page = 0;
?>
        <table id="all-posts" class="table table-hover table-advance">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric"><?php echo lang_key('image');?></th>

                  <th class="numeric"><?php echo lang_key('title');?></th>

                  <th class="numeric"><?php echo lang_key('category');?></th>

                  <th class="numeric"><?php echo lang_key('email');?></th>
                  
                  <th class="numeric"><?php echo lang_key('city');?></th>

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

          <?php $i=1;foreach($posts->result() as $row):  ?>

               <tr>

                  <td data-title="#" class="numeric"><?php echo $i;?></td>

                  <td data-title="<?php echo lang_key('image');?>" class="numeric"><img class="thumbnail" style="width:50px;margin-bottom:0px;" src="<?php echo get_featured_photo_by_id($row->featured_img);?>" /></td>

                  <td data-title="<?php echo lang_key('title');?>" class="numeric"><?php echo $row->title;?></td>

                  <td data-title="<?php echo lang_key('category');?>" class="numeric">
				     <?php $categories = get_category_title_by_post_id($row->id);					 
					   $total = count($categories );
					   $j=0;
					   foreach($categories as $category){
						   $j++;
						    echo $category->title;
							if($j != $total) echo ',';
						   }
					 ?></td>

                  <td data-title="<?php echo lang_key('price');?>" class="numeric"><?php echo $row->email;?></td>
                  
                  <td data-title="<?php echo lang_key('city');?>" class="numeric"><?php echo get_location_name_by_id($row->city);?></td>
                

                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                    <div class="btn-group">

                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                      <ul class="dropdown-menu dropdown-info" style="min-width:110px;">

                          <li><a href="<?php echo site_url('edit-business/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('edit');?></a></li>
                          <li><a href="<?php echo site_url('admin/business/deletepost/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('delete');?></a></li>
                          
                                   

                      </ul>
                    </div>
                  </td>
               </tr>
               
               <tr>
               		<td colspan="2">
                    	 <a class="btn btn-info" target="_blank" href="<?=post_detail_url($row);?>">View Detail Business</a>
                    </td>
                    
                    <td colspan="3">
                    	 <a class="btn btn-info" href="<?php echo site_url('admin/business/view_all_reviews/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('view_all_reviews');?></a>
                          
                          <?php if(is_admin()){ ?>                          
                            <?php if($row->status==2){?>
                             <a class="btn btn-info" href="<?php echo site_url('admin/business/approvepost/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('approve');?></a>
                            <?php }?>                              
                          <?php }?>
                            <a class="btn btn-info" href="<?php echo site_url('admin/business/view_all_blogs/'.$curr_page.'/'.$row->id);?>">Add/Edit Blogs</a>
                             <a class="btn btn-info" href="<?php echo site_url('admin/business/view_all_video/'.$curr_page.'/'.$row->id);?>">Add/Edit Video</a>
                    </td>
                    <td colspan="2"></td>
               </tr>
               
            <?php $i++;endforeach;?>   

           </tbody>

        </table>

          <div class="pagination pull-right">
            <ul class="pagination pagination-colory"><?php echo $pages;?></ul>
          </div>
          <div class="pull-right">
            <img src="<?php echo base_url('assets/images/loading.gif');?>" style="width:20px;margin:5px;display:none" class="loading">
          </div>
          <div class="clearfix"></div>