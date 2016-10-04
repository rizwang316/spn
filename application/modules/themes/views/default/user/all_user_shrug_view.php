<?php
if($shrugs->num_rows()>0){ ?>
<div class="show-user-shrug mediacls">
<h3>Shrug</h3>
    <div class="col-sm-12">
     <div class="ajax-loading recent-user-shrug-loading">
        <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
    </div>
</div>
<?php
$i=1;
foreach($shrugs->result() as $review){
	 $postdata = get_post_by_id($review->post_id); 
	 $post =$postdata->row();
	 $detail_link = post_detail_url($post);
$i++;
 ?>
  <div class="col-xs-6">  
   <div class="reviewbox">   
     <div class="rewimg">
      <a href="<?php // echo site_url('profile/'.$review->created_by.'/'.get_user_fullname_by_id($review->created_by));?>">
       <img alt="user-image" src="<?php echo get_profile_photo_by_id($review->created_by); ?>" class="img-responsive user-img"> </a> 
     </div>
     <div class="reviedetail">
      <table class="revi_title">
        <tbody>
          <tr>
            <td> <a href="<?php // echo site_url('profile/'.$review->created_by.'/'.get_user_fullname_by_id($review->created_by));?>"> <?php echo get_user_fullname_by_id($review->created_by); ?> </a> 
            wrote a review for <a href="<?=$detail_link?>"><?=$post->title?></a> 
                            
            </td>
            <td><?php echo time_elapsed_string(date('Y-m-d H:i:s', $review->create_time)); ?></td>
          </tr>
        </tbody>
      </table>
      <table class="ratingcls">
                 <tr>
                        <?php if(get_all_post_shrug_count($post->id) > 0){ ?>
                            <td><img src="<?php echo theme_url();?>/assets/images/shrug.png"><span><?=get_all_post_shrug_count($post->id)?></span></td>
                        <?php  } ?>
                       <?php /*?> <?php if(get_all_post_double_thumb_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/double_thumb.png"><span><?=get_all_post_double_thumb_count($post->id)?></span></td> 
                        <?php } ?>
                        <?php if(get_all_post_trophy_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/trophy.png"><span><?=get_all_post_trophy_count($post->id)?></span></td>
                        <?php } ?><?php */?>
                        </tr>
            </table>
      <p class="ra-date">  <?php echo date('m/d/Y', $review->create_time); ?> </p>     
     
      <p><?php echo truncate(strip_tags($review->comment),200,'&nbsp;<a class="review-detail" href="'.site_url('show/reviewdetail/'.$review->id).'">'.lang_key('review_detail').'</a>',false);?></p>
      
			<?php $emotions =  json_decode($review->emotions); ?>
            <?php if(!empty($emotions)){  foreach($emotions as $emotion){ ?>
             <span><img src="<?php echo theme_url();?>/assets/images/<?=$emotion?>_1.png" /></span>
            <?php }  }?>	
      
      
      <p class="review_was"><span>Was this review …?</span>
                        <a href="#" class="infocls">Informative</a>
                        <a href="#" class="funcls">Funny</a>
                        <a href="#" class="awecls">Awesome</a>
                        <a href="#" class="suscls">Suspect</a>
                        <a href="#" class="buscls">Business Reply</a>

                    </p>
    </div>    
    
    
    
    <div class="clear"></div>
    
    
    </div>
  </div>  
<?php } ?>
<div class="col-xs-12">  
    <div class="pagination-wrapper" id="pagination-single-thumb">
        <?php  echo $pagination_links->create_links();?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {	
jQuery('.review-detail').live('click',function(e){	
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
</div>

<?php } ?>
