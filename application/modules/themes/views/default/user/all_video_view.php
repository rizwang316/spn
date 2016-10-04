<?php if($videos->num_rows()>0){ ?>
 <div class="show-video pos-relative">
<h3>Video</h3>
	<?php if($user_id == $this->session->userdata('user_id')){ ?>
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php echo site_url('admin/add_video/0');?>" class="">Add User Video</a>
            </div>        
        <?php } ?>
    <div class="col-sm-12">
    <div class="ajax-loading recent-video-loading">
        <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
    </div>
</div>	    
<?php   
$i=1;
 echo '<ul class="videolist">';
foreach($videos->result() as $video){
$i++;
 ?>
   <li class="box videoimg">   
    <a href="<?php echo $video->value;?>" class="" id="<?=$video->id?>" title="<?php echo $video->title;?>">
        <img src="<?php echo theme_url();?>/assets/images/videoimg.png" alt="image">
    </a>
    <p><?php echo $video->title;?></p>
</li>    
<?php } ?>
</ul>
    <div class="col-xs-12">  
        <div class="pagination-wrapper" id="pagination-video">
            <?php  echo $pagination_links->create_links();?>
        </div>
    </div>
</div>

<?php }else{ ?>
<?php if($user_id == $this->session->userdata('user_id')){ ?>
<div class="show-video pos-relative">
 		<h3> Video </h3>   
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php  echo site_url('admin/add_video/0');?>" class="">Add User Video</a>
            </div> 
     </div>       
        <?php } ?>
<?php } ?>
<script type="text/javascript">
	$( document ).ready(function() {
		/* Dynamic Gallery */
	 $( ".videoimg" ).each(function( i ) {
		 var  url =$(this).find('a').attr("href");
		 var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		 var match = url.match(regExp);
		if ($(match&&match[7].length==11)){ 
		$(this).find('img').attr('src','http://img.youtube.com/vi/' + match[7] + '/0.jpg')   
		}
		});
	});
	$('.videoimg a').live('click',function (event) {
		if (event.preventDefault) event.preventDefault();	
		   var id = $(this).attr('id');
		   var action = 'get_videos';
		   var action_url = '<?php echo base_url('show/load_user_video_popup');?>';	 
			getPhotoPreviewAjx(id,action,action_url);
	});	
</script>