<div class="show-user-reviews mediacls">
<h3>Reviews</h3>
<div class="col-sm-12">
 <div class="ajax-loading recent-user-review-loading">
    <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
</div>
</div>
<div class="col-sm-2">
	  <strong>Filter Review By:</strong>
</div>
  <form action="<?php echo site_url('show/load_all_user_review_filter_view')?>" method="post" class="form-filter-review">
<div class="col-sm-3">  
         <div class="col-sm-3">                 
            <strong>Category</strong>
        </div>
         <div class="col-sm-9">    
        <?php
        $CI = get_instance();
        $CI->load->model('user/post_model');
        $categories = $CI->post_model->get_all_categories();
        ?>
        <select id="input-14" name="category" class="form-control chosen-select category filter-review-information ">
            <option value="any"><?php echo lang_key('any_category');?></option>
              <?php foreach ($categories as $row) {
                  $sub = ($row->parent!=0)?'--':'';
                  $sel = ($category ==$row->id)?'selected="selected"':'';
              ?>
                  <option value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $sub.lang_key($row->title);?></option>
              <?php
              }?>
        </select>   
     </div>               
</div>
<div class="col-sm-3">  
     <div class="col-sm-3">               
       <strong>City</strong>  
    </div>
    <div class="col-sm-9">  
    <select id="input-11" name="city" class="form-control chosen-select city filter-review-information">
        <option data-name="" value="any"><?php echo lang_key('any_city');?></option>
          <?php foreach (get_all_cities_by_use()->result() as $row) {
              $sel = ($row->id==$city)?'selected="selected"':'';
              ?>
              <option data-name="<?php echo $row->name;?>" class="cities city-<?php echo $row->parent;?>" value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo lang_key($row->name);?></option>
          <?php }?>
    </select>      
    
    </div>          
 </div>
<?php /*?> <div class="col-sm-2">  
  <input type="submit" value="filter"  />
 </div><?php */?>
 <div class="col-sm-4">  
 <div class="col-sm-3">               
       <strong>Type</strong>  
    </div>
    <div class="col-sm-9">
<select name="review_information" class="filter-review-information information form-control chosen-select">
	<option value="any">Any Type</option>
	<option value="informative" <?php if($information == 'informative'){ ?> selected="selected" <?php } ?>>Informative</option>
    <option value="funny" <?php if($information == 'funny'){ ?> selected="selected" <?php } ?>>funny</option>
    <option value="awesome" <?php if($information == 'awesome'){ ?> selected="selected" <?php } ?>>awesome</option>
    <option value="suspect" <?php if($information == 'suspect'){ ?> selected="selected" <?php } ?>>suspect</option>
    <option value="business-reply" <?php if($information == 'business-reply'){ ?> selected="selected" <?php } ?>>Business reply</option>    
</select>
</div>
</div>

</form>

<div class="clear-fix"></div>

<?php
if($reviews->num_rows()>0){ ?>

<?php
$i=1;
foreach($reviews->result() as $review){
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
           
             <td> <a href="<?php  echo site_url('profile/'.get_user_slug_by_id($review->created_by));?>"> 
			 <?php echo get_user_fullname_by_id($review->created_by); ?> </a> 
            wrote a review for <a href="<?=$detail_link?>"><?=$post->title?></a> 
                            
            </td>
            <td><?php echo time_elapsed_string(date('Y-m-d H:i:s', $review->create_time)); ?></td>
          </tr>
        </tbody>
      </table>
      <table class="ratingcls">
                    <tr>
                        <?php if(get_all_post_single_thumb_count($post->id) > 0){ ?>
                            <td><img src="<?php echo theme_url();?>/assets/images/single_thumb.png"><span><?=get_all_post_single_thumb_count($post->id)?></span></td>
                        <?php  } ?>
                        <?php if(get_all_post_double_thumb_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/double_thumb.png"><span><?=get_all_post_double_thumb_count($post->id)?></span></td> 
                        <?php } ?>
                        <?php if(get_all_post_trophy_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/trophy.png"><span><?=get_all_post_trophy_count($post->id)?></span></td>
                        <?php } ?>
                        <?php if(get_all_post_shrug_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/shrug.png"><span><?=get_all_post_shrug_count($post->id)?></span></td>
                        <?php } ?>
                   </tr>
            </table>
      <p class="ra-date">  <?php echo date('m/d/Y', $review->create_time); ?> </p>     
     <?php
		 $string =  strip_tags($review->comment);
		$string = convertHashtags($string);	
	 ?>     
      <p><?php echo truncate($string,200,'&nbsp;<a class="review-detail" href="'.site_url('show/reviewdetail/'.$review->id).'">'.lang_key('review_detail').'</a>',false);?></p>
      
      
			<?php $emotions =  json_decode($review->emotions); ?>
            <?php if(!empty($emotions)){  foreach($emotions as $emotion){ ?>
             <span><img src="<?php echo theme_url();?>/assets/images/<?=$emotion?>_1.png" /></span>
            <?php }  }?>	
      
      
      <p class="review_was"><span>Was this review …?</span>
                        <a href="javascript:void(0)" title="<?php echo count_review_information($review->id,'informative'); ?>" review_id="<?=$review->id?>" value="informative"   class="infocls review-information">Informative</a>
                        <a href="javascript:void(0)" title="<?php echo count_review_information($review->id,'funny'); ?>" review_id="<?=$review->id?>" value="funny" class="funcls review-information">Funny</a>
                        <a href="javascript:void(0)" title="<?php echo count_review_information($review->id,'awesome'); ?>" review_id="<?=$review->id?>" value="awesome" class="awecls review-information">Awesome</a>
                        <a href="javascript:void(0)" title="<?php echo count_review_information($review->id,'suspect'); ?>" review_id="<?=$review->id?>" value="suspect" class="suscls review-information">Suspect</a>
                        <a href="javascript:void(0)" title="<?php echo count_review_information($review->id,'business reply'); ?>" review_id="<?=$review->id?>" value="business reply" class="buscls review-information">Business Reply</a>
                    </p>
    </div>        
    
       <div class="clear"></div>    
    
    </div>
  </div>  
<?php } ?>
<div class="col-xs-12">  
    <div class="pagination-wrapper" id="pagination-review">
        <?php  echo $pagination_links->create_links();?>
    </div>
</div>
<?php }else{ ?>
	<p>No result found.</p>
<?php } ?>


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
<!--start review information-->
<script>
jQuery( document ).ready(function() {
		$('.review-information').live('click',function(){
		  var review_id = jQuery(this).attr('review_id');
		  var review_value = jQuery(this).attr('value');
		  var current_userid =  "<?=$this->session->userdata('user_id')?>";	
		  if(current_userid > 0){   
		  var dataString = {review_id:review_id,review_value:review_value,user_id:current_userid}
		$.ajax({
				type: "POST",
				url: "<?php echo base_url('show/review/create_information/');?>",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){
					if(data.success == true){
							 alert(data.notif);
					 }else{
						 alert(data.notif);
					}					
					} ,
					error: function(xhr, status, error) {
				       alert(error);
				   },
			});
			 }else{ alert('you must be logged in for this!');}		
		});		
 });
</script>
<!-- end -->
</div>
