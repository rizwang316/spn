<?php if($random_user_video->num_rows()>0){  ?>
 <div class="show-video pos-relative">
 		<h3> Random Videos </h3>  
<?php   
$i=1;
 echo '<ul class="videolist">';
foreach($random_user_video->result() as $video){
$i++;
 ?>
   <li class="box videoimg-random">
   	<a href="<?php echo $video->value;?>" id="<?=$video->id?>" title="<?php echo $video->title;?>">
        <img src="<?php echo theme_url();?>/assets/images/videoimg.png" alt="Video images">
    </a>
    <p><?php echo $video->title;?></p>
</li>    
<?php } ?>
</ul>    
</div>
 
	<script type="text/javascript">
	$( document ).ready(function() {
			/* Video */
			
	 /* Dynamic Gallery */
	 $( ".videoimg-random" ).each(function( i ) {
		 var  url =$(this).find('a').attr("href");
		 var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		 var match = url.match(regExp);
		if ($(match&&match[7].length==11)){ 
		$(this).find('img').attr('src','http://img.youtube.com/vi/' + match[7] + '/0.jpg')   
		}
	  });
	  $('.videoimg-random a').live('click',function (event) {
		if (event.preventDefault) event.preventDefault();	
		   var id = $(this).attr('id');
		   var action = 'get_videos';
		   var action_url = '<?php echo base_url('show/load_user_random_video_popup');?>';	 
			getPhotoPreviewAjx(id,action,action_url);
	});

      });
	</script>
<?php } ?>