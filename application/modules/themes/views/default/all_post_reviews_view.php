<?php
if($reviews->num_rows()>0){ ?>
<div class="show-reviews">
<h3> <?php echo lang_key('recent_reviews');?></h3>
    <div class="col-sm-12">
     <div class="ajax-loading recent-review-loading">
        <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
    </div>
</div>
<?php
$i=1;
foreach($reviews->result() as $review){
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
            <td> <a href="<?php // echo site_url('profile/'.$review->created_by.'/'.get_user_fullname_by_id($review->created_by));?>"> <?php echo get_user_fullname_by_id($review->created_by); ?> </a></td>
            <td><?php echo time_elapsed_string(date('Y-m-d H:i:s', $review->create_time)); ?></td>
          </tr>
        </tbody>
      </table>
      <table class="ratingcls">
                <tr>
          		<?php if(get_all_review_single_thumb_count($review->id) > 0){ ?>
                	<td><img src="<?php echo theme_url();?>/assets/images/single_thumb.png"></td>
                <?php  } ?>
                <?php if(get_all_review_double_thumb_count($review->id) > 0){ ?>
				<td><img src="<?php echo theme_url();?>/assets/images/double_thumb.png"></td> 
                <?php } ?>
                <?php if(get_all_review_trophy_count($review->id) > 0){ ?>
				<td><img src="<?php echo theme_url();?>/assets/images/trophy.png"></td>
                <?php } ?>
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
    
    
    
    
    
    
    </div>
  </div>  
<?php } ?>
<div class="col-xs-12">  
    <div class="pagination-wrapper" id="pagination">
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
