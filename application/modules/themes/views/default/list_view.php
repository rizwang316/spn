<?php $CI = get_instance();?>
<div class="blog-one">
	<?php
	if($posts->num_rows()<=0)
	{
		echo '<div class="alert alert-info">'.lang_key('no_posts').'</div>';
	}
	else
	{
    $i = 0;
    foreach($posts->result() as $post){		
        $i++;
        $detail_link = post_detail_url($post);
    ?>
    <div class="blog-one-item row">
		<!-- blog One Img -->
		<div class="blog-one-img col-md-3 col-sm-3 col-xs-12">
			<!-- Image -->
			<a href="<?php echo $detail_link;?>">
				<div class="image-style-one">				
				 <img class="img-responsive img-thumbnail" alt="<?php echo $post->title;?>" src="<?php echo get_featured_photo_by_id($post->featured_img);?>">
                </div>
			</a>
		</div>
		<!-- blog One Content -->
		<div class="blog-one-content col-md-9 col-sm-9 col-xs-12">
			<!-- Heading -->
			        <h3><a href="<?php echo $detail_link;?>"><?php echo $post->title;?></a> </h3>                       
				        <?php if(get_all_post_single_thumb_count($post->id) > 0){ ?>
                            <td><img src="<?php echo theme_url();?>/assets/images/single_thumb.png"><span><?=get_all_post_single_thumb_count($post->id)?></span></td>
                        <?php  } ?>
                        <?php if(get_all_post_double_thumb_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/double_thumb.png"><span><?=get_all_post_double_thumb_count($post->id)?></span></td> 
                        <?php } ?>
                        <?php if(get_all_post_trophy_count($post->id) > 0){ ?>
                        <td><img src="<?php echo theme_url();?>/assets/images/trophy.png"><span><?=get_all_post_trophy_count($post->id)?></span></td>
                        <?php } ?>
			
			<!-- Blog meta -->
			<div class="blog-meta">
				<!-- Date -->
                <?php if($post->website != ''){ ?>
				<a href="//<?php echo $post->website; ?>" target="_blank"><i class="fa fa-link"></i> &nbsp; <?php echo $post->website; ?></a> &nbsp; <?php } ?>
 				<!-- Author -->
                <?php $categories = get_category_title_by_post_id($post->id); $i=0; $total = count($categories); ?>
                <?php foreach($categories as $category){ $i++; ?>
				<a href="<?php  echo site_url('show/categoryposts/'.$category->id.'/'.dbc_url_title(get_category_title_by_id($category->id)));?>"><i class="glyphicon glyphicon-folder-open"></i> &nbsp; <?php echo get_category_title_by_id($category->id); ?></a>
                <?php // if($i < $total){ echo ',';} 
				} ?>&nbsp;
				<!-- Comments -->
				<a href="<?php  echo site_url('location-posts/'.$post->city.'/city/'.dbc_url_title(get_location_name_by_id($post->city)));?>"><i class="fa fa-map-marker"></i> &nbsp; <?php echo get_location_name_by_id($post->city);?></a> &nbsp;

				<i class="fa fa-phone"></i> &nbsp; <?php echo $post->phone_no; ?>
			</div>
			<!-- Paragraph -->
			<p><?php echo truncate(strip_tags($post->description),200,'',false);?></p>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php
		}
	}
	?>
</div>
<div class="clearfix"></div>
<?php echo (isset($pages))?'<ul class="pagination">'.$pages.'</ul>':'';?>