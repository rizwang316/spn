<link href="<?php echo theme_url();?>/assets/css/lightGallery.css" rel="stylesheet">
<script type="text/javascript">
    var switchTo5x=true;
    var pub_id = '<?php echo ($this->config->item("sharethis_publisher_id")!="")?$this->config->item("sharethis_publisher_id"):"d866253d-fd08-403f-a8d1-bcd324c8163c"?>';
    var url = "//w.sharethis.com/button/buttons.js";
    $.getScript( url, function() {
        stLight.options({publisher: pub_id, doNotHash: false, doNotCopy: true, hashAddressBar: false});
    });
</script>
<!-- Page heading two starts -->
<script src="<?php echo theme_url(); ?>/assets/js/jquery.lightSlider.min.js"></script>
<script src="<?php echo theme_url(); ?>/assets/js/lightGallery.min.js"></script>
 <link rel="stylesheet" href="<?php echo theme_url(); ?>/assets/css/swipebox.css">
<style>

    #details-map img { max-width: none; }
    .stButton .stFb, .stButton .stTwbutton, .stButton .stMainServices{
        height: 23px;
    }
    .stButton .stButton_gradient{
        height: 23px;
    }
    .map-wrapper{
        background: none repeat scroll 0 0 #f5f5f5;
        position: relative;
    }
    .map-wrapper #map_canvas_wrapper {
        overflow: hidden;
    }
    #map_street_view {
        height: 487px;
        width: 100%;
    }
</style>
<?php $post = $post->row(); ?>
<?php //echo '<pre>';print_r($post); echo '</pre>'; ?>
<?php
$fa_icon        = get_category_fa_icon($post->category);
$category_title = get_category_title_by_id($post->category);
$address = $post->address;
$full_address = get_formatted_address($address, $post->city, $post->state, $post->country, $post->zip_code); 
?>
<!-- Page heading two starts -->
<div class="container rs-property">
    <div class="single-property">
      <!-- Nav tabs -->
       <section class="businesstop">
        <div class="col-sm-2">
        <img src="<?php echo base_url('uploads/images/' . $post->featured_img); ?>" alt="" class="img-responsive " />
           
          <!-- <img src="<?php echo theme_url();?>/assets/images/businesimg.png"> -->
        </div>
        <div class="col-sm-10">		
				<div class="col-sm-8">
					<h2 class="business-title-detail"><?php echo $post->title; ?> 
					<?php /* ?>
					<small><?php 
						$this->load->model('user/post_model');						
						$post_categories = $this->post_model->get_categories_id_by_post_id($post->id);
						foreach($post_categories->result() as $cate){	?>
								<a><i class="glyphicon glyphicon-folder-open"></i> <?=get_category_title_by_id($cate->id)?>	</a>							
							<?php }		?>
					</small><?php */ ?>
					</h2>
                </div>
				<div class="col-sm-4">
					<div class="s-widget">
                        <a class="btn-green" type="button" href="<?php echo site_url('show/review/write/'.$post->unique_id)?>">Submit Review</a>
                    </div>  					
				</div>
			<div class="col-sm-12">
            <table class="ratingcls">
                <tr><td><img src="<?php echo theme_url();?>/assets/images/single_thumb.png"> <span><?php echo get_all_post_single_thumb_count($post->id); ?></span></td>
				<td><img src="<?php echo theme_url();?>/assets/images/double_thumb.png"> <span><?php echo get_all_post_double_thumb_count($post->id); ?></span></td> 
				<td><img src="<?php echo theme_url();?>/assets/images/trophy.png"> <span><?php echo get_all_post_trophy_count($post->id); ?></span></td></tr>
            </table>
			</div>
            <div class="col_1">
                <p><span><?php echo lang_key('address'); ?>:</span><?php echo $full_address; ?></p>                
                <p><span><?php echo lang_key('website'); ?>:</span> <?php echo $post->website; ?></p>
                <p><span>Accepted Payment Method: </span> <img src="<?php echo theme_url();?>/assets/images/payment.png"></p>
            </div>
            <div class="col_2 bordercls">
                <table>
                    <tr>
                        <td class="labcl"> <i class="glyphicon glyphicon-phone  color"></i>  </td>
                        <td><span><?php echo $post->phone_no; ?></span>
                            </td>
                    </tr>
                    <tr>
                        <td class="labcl"> <i class="glyphicon  glyphicon-exclamation-sign  color"></i> </td>
                        <td><span><a href="mailto:<?php echo $post->email; ?>" target="_top"><?php echo $post->email; ?></a></span> </td>
                    </tr>
					<tr>
                        <td class="labcl"> <i class="glyphicon glyphicon glyphicon-pencil color"></i></td>
						<td><span><a class="js-write" type="button" href="javascript:void(0)">Write Review</a></span></td>
                    </tr>                              
                     <tr>
                        <td class="labcl"> <i class="glyphicon glyphicon-hand-right color"></i> </td>
						<td><span><a class="js-claim" type="button" href="javascript:void(0)"><?php echo lang_key('claim_the_business');?></a></span></td>
                    </tr>
                    <tr>
                        <td class="labcl"> <i class="fa fa-flag color"></i> </td>
           			   <td><span><a class="js-report" type="button" href="javascript:void(0)"><?php echo lang_key('report_the_business');?></a></span></td>
                    </tr>
                    <tr>
                        <td class="labcl"> <i class="glyphicon glyphicon-envelope color"></i> </td>
						<td><span><a class="js-contact" type="button" href="javascript:void(0)">Send Email to business</a></span></td>
                    </tr>
                </table>
            </div>
            <div class="col_3">  
			<?php if($this->config->item('hide_opening_hours')==0){?>
                    <?php if($post->opening_hour != ''){ ?>
                        <h4 class="info-subtitle"><i class="fa fa-list-ul"></i> <?php echo lang_key('opening_hour'); ?></h4>
                        <?php $opening_hours = json_decode($post->opening_hour); ?>
                        <?php //print_r($opening_hours); die; ?>
                        <ul class="list-6">
                            <?php foreach($opening_hours as $value){ ?>
                                <li><span><?php echo lang_key($value->day); ?></span><?php echo $value->closed == 1 ? lang_key('closed') : $value->start_time.'-'.$value->close_time ; ?></li>
                            <?php } ?>
                        </ul>
                        <div class="clearfix"></div>
                    <?php } ?>
                <?php }?>				
          
               
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </section>
                <div class="about_business">
                <h3>About Business <?php echo lang_key('details') ?></h3>
                <p><?php echo $post->description; // get_post_data_by_lang($post,'description'); ?></p>
    </div><!--about-->
          

    <div class="coupencode">
        <div class="col-sm-6">
            <div class="webpart">
                <div class="col-sm-6">
                	<?php if($post->website != ''){ ?>
                   <a href="<?=$post->website?>" target="_blank">
						<?=$post->website?></a>
                    <?php } ?>
						<?php 
                        $business_logo = get_post_meta($post->id,'business_logo','');
                        if($business_logo!='' && $business_logo!='no-image.png')
                        {
                            ?>
                            <span class="business-logo-detail">
                                <img src="<?php echo base_url('uploads/logos/'.$business_logo);?>" class="pull-left" />
                            </span>
                            <?php
                        }
                        ?>
			
            
                   <!--
                    <img src="<?php echo theme_url();?>/assets/images/webimg.png">
                    -->
                </div>
                <div class="col-sm-6">
                     <p> <?php if(!empty($post->coupon_code)){ ?> COUPON Code is
                        <br><span><?=$post->coupon_code?> </span><br> <?php } ?>
                        Please call to <?php echo $post->phone_no; ?>
                        <?php if(!empty($post->get_off)){ ?>
                        and
                        get<span> <?=$post->get_off?> %</span> off on
                        <b>total Purchase</b>
                        <?php } ?>
                        </p></div>
                <div class="clear"></div>
                
            </div>
        </div>
        <div class="col-sm-6">
            <?php
            $address = $post->address;
            $full_address = get_formatted_address($address, $post->city, $post->state, $post->country, $post->zip_code);

            ?>
            <div id="ad-address"><span><?php echo $full_address; ?></span></div>

            <h4 class="info-subtitle"><i class="fa fa-map-marker"></i> <?php echo lang_key('location_on_map'); ?></h4>
            <div class="gmap" id="details-map"></div>
            <div class="clearfix"></div>
            <a href="javascript:void(0);" onclick="calcRoute()" class="pull-right btn btn-info" style="width:100%"><?php echo lang_key('get_directions'); ?></a>
            <div class="clearfix"></div>

        </div>
        <div class="clear"></div>
    </div><!--coupen--->
    
    <?php if(!empty(get_post_meta($post->id,'bbb_profile','')) || !empty(get_post_meta($post->id,'yelp_profile','')) || !empty(get_post_meta($post->id,'facebook_profile','')) || !empty(get_post_meta($post->id,'twitter_profile','')) || !empty(get_post_meta($post->id,'angle_list_profile','')) || !empty(get_post_meta($post->id,'linkedin_profile','')) || !empty(get_post_meta($post->id,'googleplus_profile','')) || !empty(get_post_meta($post->id,'ebay_profile',''))){ ?>
    <div class="business_social">
        <h3>Social Media</h3>        
		<?php
        $profile_link = get_post_meta($post->id,'bbb_profile','');
        if($profile_link!=''){?>
            <a class="" href="<?php echo $profile_link;?>">
            	<img src="<?php echo theme_url();?>/assets/images/social1.png">
            </a>
        <?php }?>
        <?php
        $profile_link = get_post_meta($post->id,'yelp_profile','');
        if($profile_link!=''){?>
            <a class="" href="<?php echo $profile_link;?>">
            	<img src="<?php echo theme_url();?>/assets/images/social2.png">
            </a>
        <?php }?>
        <?php
        $profile_link = get_post_meta($post->id,'facebook_profile','');
        if($profile_link!=''){?>
            <a class="" href="<?php echo $profile_link;?>">
            	<img src="<?php echo theme_url();?>/assets/images/social3.png">
            </a>
        <?php }?>
        <?php
        $profile_link = get_post_meta($post->id,'twitter_profile','');
        if($profile_link!=''){?>
            <a class="" href="<?php echo $profile_link;?>">
            	<img src="<?php echo theme_url();?>/assets/images/social4.png">
            </a>
        <?php }?>
        <?php
        $profile_link = get_post_meta($post->id,'angle_list_profile','');
        if($profile_link!=''){?>
            <a class="" href="<?php echo $profile_link;?>">
            	<img src="<?php echo theme_url();?>/assets/images/social5.png">
            </a>
        <?php }?>
        <?php
        $profile_link = get_post_meta($post->id,'linkedin_profile','');
        if($profile_link!=''){?>
            <a class="" href="<?php echo $profile_link;?>">
            	<img src="<?php echo theme_url();?>/assets/images/social6.png">
            </a>
        <?php }?>
        <?php
        $profile_link = get_post_meta($post->id,'googleplus_profile','');
        if($profile_link!=''){?>
            <a class="" href="<?php echo $profile_link;?>">
            	<img src="<?php echo theme_url();?>/assets/images/social7.png">
            </a>
        <?php }?>
        <?php
        $profile_link = get_post_meta($post->id,'ebay_profile','');
        if($profile_link!=''){?>
            <a class="" href="<?php echo $profile_link;?>">
            	<img src="<?php echo theme_url();?>/assets/images/social8.png">
            </a>
        <?php }?>                           
        	
        
    </div><!--social-->
    <?php } ?>
                      <?php
                        $area_serveds = $post->area_served;                       
                        ?>
                        <?php if($area_serveds != 'n/a' && $area_serveds != ''){
								
							 ?>
                        <div class="business_area">
     					   <h3>Area Served</h3>
                                <?php $area_serveds = explode(',',$area_serveds);
								 $i=0;
								 echo '<p>';
								$total = count($area_serveds);
                                foreach ($area_serveds as $area_served) {  $i++; ?>
                                    <?php echo $area_served; if($i != $total) echo ' - '; ?>
                                <?php } echo '</p>'; ?>
                            </div><!--area-->
                        <?php } ?>
   
                       
					<div class="reviews_new">						
						<div id="" class="view-all-review"></div>        
						 <div class="clear"></div>
					</div><!---->
    
	<div class="mediacls">
    	<div id="" class="view-all-video"></div>			
        <div class="clear"></div>		
    </div>


    <div class="mediacls">
        <div id="" class="view-all-image"></div>			
        <div class="clear"></div>       
    </div>


    <div class="mediacls">
   		<div id="" class="view-all-blog"></div>			
        <div class="clear"></div>               
    </div><!--blog-->

    <div class="ads2">
        <img src="<?php echo theme_url();?>/assets/images/ad_2.png">
    </div>

  <!--random video-->
	<div class="mediacls">
    	<div id="" class="view-random-video"></div>			
        <div class="clear"></div>		
    </div>
    
    
    <div class="mediacls">
        <h3>Random Blogs</h3>
        <ul class="bloglist">
            <?php foreach($random_business_blog->result() as $blog_business ){ ?>	
            	<li>
               		 <?php if($blog_business->value != ''){ ?>
   	 				<img src="<?php echo base_url('uploads/business/blog/'.$blog_business->value); ?>">
    			 <?php }else{ ?>
    	   			<img src="<?php echo base_url('assets/admin/img/preview.jpg'); ?>">
     			<?php } ?>
                <h4><a href="<?php echo site_url().'business/blog/'.$blog_business->slug;?>"><?=$blog_business->title;?></a></h4>

            </li>
			
            <?php } ?>

            

            <div class="clear"></div>
        </ul>
        <div class="clear"></div>
        
    </div><!--blog-->


   

    <div class="connectimglove">
        <h3><a href="#">Connecting With Love</a> <img src="<?php echo theme_url();?>/assets/images/connectlove.png"></h3>
    </div>
    </div>
</div>

<div id="claimModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel"><?php echo lang_key('claim_the_business'); ?></h4>

            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>

</div>

<div id="contactModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel"><?php echo lang_key('send_email_to_business'); ?></h4>

            </div>

            <div class="modal-body">            
                         

                    <div class="rs-enquiry">
                        
                        <div class="ajax-loading recent-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>
                        <div class="clearfix"></div>
                                    <span class="agent-email-form-holder"></span>
                    </div>


            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>

</div>

<div id="reviewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel">Review Detail <?php //echo lang_key('claim_the_business'); ?></h4>

            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>

</div>

<div id="writeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel">Write Review</h4>

            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>

</div>

<script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script src="<?php echo theme_url();?>/assets/js/markercluster.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map-icons.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map_config.js"></script>

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

            var code = '<iframe class="thumbnail" width="100%" height="420" src="'+src+'" frameborder="0" allowfullscreen></iframe>';

            jQuery('#video_preview').html(code);

        }

        else if(url.search("vimeo.com")!=-1)

        {

            //http://vimeo.com/64547919

            var segments = url.split("/");

            var length = segments.length;

            length--;

            var video_id = segments[length];

            var src  = url.replace("vimeo.com","player.vimeo.com/video");

            var code = '<iframe class="thumbnail" src="//player.vimeo.com/video/'+video_id+'" width="100%" height="420" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

            jQuery('#video_preview').html(code);

        }

        else

        {


        }

    }

    $(document).ready(function() {
/*
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
*/
        jQuery('#video_url').change(function(){

            var url = jQuery(this).val();

            showVideoPreview(url);

        }).change();

        <?php
        $CI = get_instance();
      ?>
        var rtl = false;
        
        $('#imageGallery').lightSlider({
            gallery:false,
            item:1,
            speed:1000,
            rtl:rtl,
            auto:true,
            loop: true,
            thumbItem:9,
            slideMargin:0,
            currentPagerPosition:'left',
            onSliderLoad: function(plugin) {
                plugin.lightGallery();
            }
        });
    });

    var myLatitude = parseFloat('<?php echo $post->latitude; ?>');

    var myLongitude = parseFloat('<?php echo $post->longitude; ?>');

    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();


    function initialize() {

        directionsDisplay = new google.maps.DirectionsRenderer();

        var zoomLevel = parseInt('<?php echo get_settings('banner_settings','map_zoom',8); ?>');

        var myLatlng = new google.maps.LatLng(myLatitude,myLongitude);
        var map_data = <?php echo get_business_map_data_single($post); ?>;
		
        var mapOptions = {
            scrollwheel: false,
            zoom: zoomLevel,
            center: myLatlng,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            panControl: true,
            panControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: MAP_STYLE
        }
        map = new google.maps.Map(document.getElementById('details-map'), mapOptions);

        directionsDisplay.setMap(map);

        var contentString = '<div class="img-box-4 text-center map-grid"><div class="img-box-4-item"><div class="image-style-one"><img class="img-responsive" alt="" src="'+ map_data.posts[0].featured_image_url + '"></div>'
            + '<div class="img-box-4-content"><h4 class="item-title"><a href="#">'+ map_data.posts[0].post_title + '</a></h4><div class="bor bg-red"></div><div class="row"></div><div class="row"><div class="info-dta info-price">'+ map_data.posts[0].post_short_address + '</div></div>' + '</div></div></div>';



        var infowindow = new google.maps.InfoWindow({

            content: contentString

        });

        var marker, i;

        var markers = [];

        marker = new Marker({

            position: myLatlng,

            map: map,

            title: '<?php echo addslashes($post->title); ?>',
            zIndex: 9,
            icon: {
                path: SQUARE_PIN,
                fillColor: '#ed5441',
                fillOpacity: 1,
                strokeColor: '',
                strokeWeight: 0,
                scale: 1/3
            },
            label: '<i class="glyphicon glyphicon-map-marker"></i>'


        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {

            return function() {

                infowindow.open(map, marker);

            }

        })(marker, i));

        markers.push(marker);

    }


    function calcRoute() {
        if(!!navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function(position) {

                var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                var start = geolocate;
                var end = new google.maps.LatLng(myLatitude,myLongitude);
                var request = {
                    origin:start,
                    destination:end,
                    travelMode: google.maps.TravelMode.DRIVING
                };
                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                    }
                });


            });

        } else {
            alert('No Geolocation Support.');
        }
    }


    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- Main content ends -->

<script type="text/javascript">
    jQuery(document).ready(function(){
       // $("#reviews-holder").mCustomScrollbar();
	   //load all blog.
	    var loadUrl = '<?php echo site_url("show/load_all_blog_view/".$post->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-blog').html(responseText);
                init_load_more_blog_js();
            }
        );
		 function init_load_more_blog_js()
        {
		jQuery("#pagination-blog a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-blog-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-blog').html(res);
			   jQuery('.recent-blog-loading').hide();
			}
			});
			return false;
		});
	 }
	  
       //load all video.
	    var loadUrl = '<?php echo site_url("show/load_all_video_view/".$post->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-video').html(responseText);
                init_load_more_video_js();
            }
        );
		 function init_load_more_video_js()
        {
		jQuery("#pagination-video a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-video-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-video').html(res);
			   jQuery('.recent-video-loading').hide();
			}
			});
			return false;
		});
	 }
	  
	   //load all review.
	    var loadUrl = '<?php echo site_url("show/review/load_all_post_review_view/".$post->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-review').html(responseText);
                init_load_more_review_js();
            }
        );
		 function init_load_more_review_js()
        {
		jQuery("#pagination a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-review-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-reviews').html(res);
			   jQuery('.recent-review-loading').hide();
			}
			});
			return false;
		});
	 }
	 //end
	 // laod all images.
	  var loadUrl = '<?php echo site_url("show/load_all_image_view/".$post->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-image').html(responseText);
                init_load_more_image_js();
            }
        );
		 function init_load_more_image_js()
        {
		jQuery("#pagination-image a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-image-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-image').html(res);
			   jQuery('.recent-image-loading').hide();
			}
			});
			return false;
		});
	 }
		
		
        var loadUrl = '<?php echo site_url("show/load_contact_agent_view/".$post->unique_id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.agent-email-form-holder').html(responseText);
                init_send_contact_email_js();
            }
        );

        jQuery('.js-claim').on('click',function(e){
            e.preventDefault();
            var loadUrl = '<?php echo site_url("show/load_claim_business_view/".$post->unique_id);?>';
            jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery('#claimModal .modal-body').html(responseText);
                    jQuery('#claimModal').modal('show');
                    init_claim_business_js();
                }
            );


        });
		//
		
       //load all video.
	    var loadUrl = '<?php echo site_url("show/load_random_video_view/");?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-random-video').html(responseText);                
            }
        );
		 
		
		//
		
		jQuery('.js-contact').on('click',function(e){
            e.preventDefault();
            var loadUrl = '<?php echo site_url("show/load_contact_agent_view/".$post->unique_id);?>';
            jQuery.post(
                loadUrl,
                {},
                function(responseText){					
                    jQuery('#contactModal .modal-body').html(responseText);
                    jQuery('#contactModal').modal('show');
                    init_send_contact_email_js();
                }
            );


        });
		// write a review.
			jQuery('.js-write').on('click',function(e){
            e.preventDefault();
            var loadUrl = '<?php echo site_url("show/review/load_review_form/".$post->id);?>';
            jQuery.post(
                loadUrl,
                {},
                function(responseText){					
                    jQuery('#writeModal .modal-body').html(responseText);
                    jQuery('#writeModal').modal('show');
                    init_create_review_js();
                }
            );


        }); 

    });

    function init_claim_business_js()
    {
        jQuery('#claim-business-form').submit(function(e){
            e.preventDefault();
            var data = jQuery(this).serializeArray();
            var loadUrl = jQuery(this).attr('action');
            jQuery.post(
                loadUrl,
                data,
                function(responseText){
                    jQuery('#claimModal .modal-body').html(responseText);
                    jQuery('.alert-success').each(function(){
                        jQuery('#claim-business-form input[type=text]').each(function(){
                            jQuery(this).val('');
                        });
                        jQuery('#claim-business-form textarea').each(function(){
                            jQuery(this).val('');
                        });
                    });

                    init_claim_business_js();
                }
            );
        });

    }

    function init_send_contact_email_js()
    {
        jQuery('#message-form').submit(function(e){
            var data = jQuery(this).serializeArray();
           // jQuery('.recent-loading').show();
            e.preventDefault();
            var loadUrl = jQuery(this).attr('action');
            jQuery.post(
                loadUrl,
                data,
                function(responseText){
                    jQuery('#contactModal .modal-body').html(responseText);
                    jQuery('.alert-success').each(function(){
                        jQuery('#message-form input[type=text]').each(function(){
                            jQuery(this).val('');
                        });
                        jQuery('#message-form textarea').each(function(){
                            jQuery(this).val('');
                        });
                        jQuery('#message-form input[type=checkbox]').each(function(){
                            jQuery(this).attr('checked','');
                        });

                    });
                  //  jQuery('.recent-loading').hide();
                    init_send_contact_email_js();
                }
            );
        });

    }
</script>


    <script type="text/javascript">        

        function init_create_review_js()
        {
            jQuery('#review-form').submit(function(e){
                var data = jQuery(this).serializeArray();
                jQuery('.review-loading').show();
                e.preventDefault();
                var loadUrl = jQuery(this).attr('action');
                jQuery.post(
                    loadUrl,
                    data,
                    function(responseText){
                        jQuery('#writeModal .modal-body').html(responseText);
                        jQuery('.alert-success').each(function(){
                            jQuery('#review-form input[type=text]').each(function(){
                                jQuery(this).val('');
                            });
                            jQuery('#review-form textarea').each(function(){
                                jQuery(this).val('');
                            });
                        }); 
                        jQuery('.review-loading').hide();
                        init_create_review_js();
                    }
                );
            });

        }
    </script>
    <?php if(is_loggedin()){?>    
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.js-report').on('click',function(e){
                e.preventDefault();
                var load_url = $('.js-report').attr('href');
                jQuery.post(
                    load_url,
                    {},
                    function(responseText){
                        if(responseText == 'TRUE')
                            jQuery('.js-report').html('<?php echo lang_key('reported')?>');
                        else
                            jQuery('.js-report').html('<?php echo lang_key('already_reported')?>');
                    }
                );
            });
        });
    </script>
<?php } ?>

<!--
    <script src="<?php echo theme_url();?>/assets/js/ios-orientationchange-fix.js"></script>
	<script src="<?php echo theme_url();?>/assets/js/jquery.swipebox.js"></script>
	<script type="text/javascript">
	$( document ).ready(function() {

			/* Basic Gallery */
			$( '.swipebox' ).swipebox();
			
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
	</script>-->