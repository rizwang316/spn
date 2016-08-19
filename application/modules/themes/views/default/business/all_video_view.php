<?php if($videos->num_rows()>0){  ?>
 <div class="show-video pos-relative">
 		<h3> Video </h3>        
        	<?php if($created_by == $this->session->userdata('user_id')){ ?>
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php echo site_url('admin/business/manage_video/0/'.$post_id);?>" class="">Add More Video</a>
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
   	<a href="<?php echo $video->value;?>" class="swipebox-video" title="<?php echo $video->title;?>">
        <img src="<?php echo theme_url();?>/assets/images/videoimg.png" alt="Video images">
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
 <script src="<?php echo theme_url();?>/assets/js/ios-orientationchange-fix.js"></script>
	<script src="<?php echo theme_url();?>/assets/js/jquery.swipebox.js"></script>
	<script type="text/javascript">
	$( document ).ready(function() {
			/* Video */
			$( '.swipebox-video' ).swipebox();
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
	</script>
<?php }else{ ?>
<?php if($created_by == $this->session->userdata('user_id')){ ?>
<div class="show-video pos-relative">
 		<h3> Video </h3>   
            <div class="add-more-btn btn-green"><i class="glyphicon glyphicon-plus"></i>        	
                <a href="<?php echo site_url('admin/business/manage_video/0/'.$post_id);?>" class="">Add More Video</a>
            </div> 
     </div>       
        <?php } ?>
<?php } ?>