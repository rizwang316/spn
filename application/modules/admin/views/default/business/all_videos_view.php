<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">
<?php 
$curr_page = $this->uri->segment(4);
if($curr_page=='')
  $curr_page = 0;
?>
<div class="row">
  

  <div class="col-md-12">
  <a href="<?php echo site_url('admin/business/allposts/'. $curr_page);?>" class="btn btn-success add-location"> << Back to business list</a>
  
  
  <a href="<?php echo site_url('admin/business/manage_video/'. $curr_page.'/'.$post_id);?>" class="btn btn-success add-location">Add Video</a>
     
   <div style="clear:both;margin-top:20px;"></div>

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> All Videos </h3>

        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>

      <div class="box-content">


        <?php echo $this->session->flashdata('msg');?>

        <?php if($blogs->num_rows()<=0){?>

        <div class="alert alert-info">No video upload yet.</div>

        <?php }else{?>
        
        <div id="no-more-tables" class="table-responsive" style="border:0">

        <table id="all-posts" class="table table-hover table-advance">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric">Video</th>

                 
                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php $i=1;foreach($blogs->result() as $row):  ?>
           
               <tr>

                  <td data-title="#" class="numeric"><?php echo $i;?></td>

                  <td data-title="" class="numeric">
                  <span id="<?=$row->id?>"></span>
                    <script type="text/javascript">
						jQuery(document).ready(function(){							
                            $("#<?=$row->id?>").html(showVideoPreview("<?=$row->value?>"));
                        });                    	
                    </script>                  	
                  	
                   </td>

                  
                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                    <div class="btn-group">

                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                      <ul class="dropdown-menu dropdown-info">
                          <li><a class="" href="<?php echo site_url('admin/business/manage_video/'.$curr_page.'/'.$row->post_id.'/'.$row->id);?>"><?php echo lang_key('edit');?></a></li>                                                                         
                            
                          <li><a href="<?php echo site_url('admin/business/deletevideo/'.$curr_page.'/'.$post_id.'/'.$row->id.'/');?>"><?php echo lang_key('delete');?></a></li>                          
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

<script type="text/javascript">
    function getUrlVars(url) {
        var vars = {};
        var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

    function showVideoPreview(url)
    {
        if(url.search("youtube.com")!=-1)
        {
            var video_id = getUrlVars(url)["v"];
            //https://www.youtube.com/watch?v=jIL0ze6_GIY
            var src = '//www.youtube.com/embed/'+video_id;
            //var src  = url.replace("watch?v=","embed/");
            var code = '<iframe class="thumbnail" width="40%" height="400" src="'+src+'" frameborder="0" allowfullscreen></iframe>';
           return code;
        }
        else if(url.search("vimeo.com")!=-1)
        {
            //http://vimeo.com/64547919
            var segments = url.split("/");
            var length = segments.length;
            length--;
            var video_id = segments[length];
            var src  = url.replace("vimeo.com","player.vimeo.com/video");
            var code = '<iframe class="thumbnail" src="//player.vimeo.com/video/'+video_id+'" width="40%" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
           return code;
        }
        else
        {
           // alert("only youtube and video url is valid");
        }
    }    
</script>