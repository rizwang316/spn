<div class="row">

    <div class="col-md-2">
        <a href="<?php echo site_url('profile/'.$review->created_by.'/'.get_user_fullname_by_id($review->created_by));?>">
            <img alt="user-image" src="<?php echo get_profile_photo_by_id($review->created_by); ?>" class="img-responsive user-img">
        </a>
    </div>
    <div class="col-md-10">
    	<div class="col-md-8">
        <h4><a href="<?php // echo site_url('profile/'.$review->created_by.'/'.get_user_fullname_by_id($review->created_by));?>"> <?php echo get_user_fullname_by_id($review->created_by); ?> </a></h4>
        </div>
        <div class="col-md-4">
        	<?php echo time_elapsed_string(date('Y-m-d H:i:s', $review->create_time)); ?>
        </div>
         <div class="clearfix"></div>
        <p class="contact-types">                      
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
        <div class="clearfix"></div>
        <strong><?php echo date('m/d/Y', $review->create_time); ?></strong>
        </p>
        <p><?php echo $review->comment; ?></p>
        <?php $emotions =  json_decode($review->emotions); ?>
            <?php if(!empty($emotions)){  foreach($emotions as $emotion){ ?>
             <span><img src="<?php echo theme_url();?>/assets/images/<?=$emotion?>_1.png" /></span>
       <?php }  }?>	
    </div>

</div>
<hr/>