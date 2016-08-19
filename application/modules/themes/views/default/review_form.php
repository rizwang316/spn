<?php $blogpost = $blogpost->row(); ?>
<?php if(is_loggedin() && is_personal()){ ?>
<div class="review-panel">
  <div class="writereview">
    <form id="review-form" method="post" action="<?php echo site_url('show/review/create_review');?>" role="form">
      <input type="hidden" value="<?php echo $post_id; ?>" name="post_id">
      <div class="col-sm-4 buimg"> <img src="<?php echo base_url('uploads/images/' . $blogpost->featured_img); ?>" alt="" class="img-responsive " /> </div>
      <div class="col-sm-8 buright">
        <h4>WRITE YOUR REVIEW </h4>
        <div class="ratingcl">
          <?php $v = (set_value('thumb')!='')?set_value('thumb'):'';?>
          <label class="oneth">
            <input type="radio" name="thumb"  <?php echo  ($v == 1)?'checked="checked"':'' ?>  value="1">
            <span></span> </label>
          <label class="twoth">
            <input type="radio" name="thumb" <?php echo  ($v == 2)?'checked="checked"':'' ?>   value="2">
            <span></span> </label>
          <label class="trophy">
            <?php $v = (set_value('trophy')!='')?set_value('trophy'):'';?>
            <input type="checkbox" name="trophy"  <?php echo ($v == 1)?'checked="checked"':'' ?>  value="1">
            <span></span> </label>
        </div>
        <div class="form-group">
          <label for="enquiryInput4"><?php echo lang_key('comment');?></label>
          <textarea class="form-control" id="comment" name="comment" placeholder="<?php echo lang_key('comment');?>" rows="7"></textarea>
          <?php echo form_error('comment');?> </div>
          
          
        <div class="emo">
            <label class="emo1"><i>Blushing</i>            
             <?php  $v = (set_value("emotions[]")!='')?set_value("emotions[]"):'';?>                       
            <input type="checkbox" name="emotions[]"  <?php if(!empty($v)){ foreach($v as $value){ echo ($value == 'blushing')?'checked="checked"':''; }} ?>   value="blushing">
            <span></span></label>
            <label class="emo2"><i>Laugh</i>           
            <input type="checkbox" name="emotions[]" <?php if(!empty($v)){ foreach($v as $value){ echo ($value == 'laugh')?'checked="checked"':''; } } ?> value="laugh">
            <span></span></label>
          <label class="emo3"><i>Surprised </i>           
            <input type="checkbox" name="emotions[]" <?php if(!empty($v)){ foreach($v as $value){ echo ($value == 'surprised')?'checked="checked"':''; }} ?> value="surprised">
            <span></span></label>
          <label class="emo4"><i>Cheeky </i>         
            <input type="checkbox" name="emotions[]" <?php if(!empty($v)){ foreach($v as $value){ echo ($value == 'cheeky')?'checked="checked"':''; }} ?> value="cheeky">
            <span></span></label>
            <label class="emo5"><i>Sad</i>             
            <input type="checkbox" name="emotions[]"  <?php if(!empty($v)){ foreach($v as $value){ echo ($value == 'sad')?'checked="checked"':''; }} ?>  value="sad">
            <span></span></label>
        </div>
      </div>
      <div class="clear"></div>
      <div class="reviewdetail">
      <div class="col-sm-12">
        <div class="form-group">
          <h2>
            <?=$blogpost->title; ?>
          </h2>
        </div>
        <div class="form-group">
          <?php $address = $blogpost->address;
				$full_address = get_formatted_address($address, $blogpost->city, $blogpost->state, $blogpost->country, $blogpost->zip_code); ?>
          <p><span>Address </span> <?php echo  '<p>'.$full_address .'</p>'; ?> </p>
        </div>
        <div class="form-group">
          <p>
            <label class="surecls">
               <?php  $v = (set_value("right_location")!='')?set_value("right_location"):'';?>              
              <input type="checkbox" value="1" id="aresure"  name="right_location" <?php echo ($v == '1')?'checked="checked"':'' ?>>
              <span></span> </label>
            <label for="aresure">Are you sure this is the right location</label>
          </p>
        </div>
      </div>
      <p>Read our review guidlines <a href="#">here</a></p>
      <p><a href="#"><i class="fa fa-share-alt"></i></a> Share your review</p>
      <!-- <p class="editcls">*reviews can be edited or deleted at anytime</p> -->
      <div class="clear"></div>
      <button type="submit" class="btn btn-color">Post Review</button>
    </form>
  </div>
</div>
<?php }elseif(is_loggedin() && is_business()){ ?>
	<div class="alert alert-info" role="alert"><?php echo lang_key('review_business_alert'); ?></div>
 <?php	}else { ?>
<div class="alert alert-info" role="alert"><?php echo lang_key('review_alert'); ?></div>
<?php } ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.rating-input > li').hover(function(e){
            e.preventDefault();
            var curr_li = parseInt(jQuery(this).attr('star'));
            jQuery('#rating').val(curr_li);

            jQuery('.rating-input > li').each(function(){
                if(parseInt(jQuery(this).attr('star'))<=curr_li)
                {
                    jQuery(this).addClass('active');
                }
                else
                {
                    jQuery(this).removeClass('active');
                }
            });
        });
    });
</script>