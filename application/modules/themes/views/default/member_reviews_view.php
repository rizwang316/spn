<?php 
$per_page = get_settings('business_settings', 'posts_per_page', 6);
$user = $user->row();
?>
<?php if(count($user)>0){ ?>
<!-- Page heading two starts -->
<script src="<?php echo theme_url(); ?>/assets/js/jquery.lightSlider.min.js"></script>
<script src="<?php echo theme_url(); ?>/assets/js/lightGallery.min.js"></script>
 <link rel="stylesheet" href="<?php echo theme_url(); ?>/assets/css/swipebox.css">
    
<!-- Container -->
<div class="container">
		<section class="userrtop" style="margin-bottom:0;">
          <div class="col-sm-2">
              <a href="<?php echo site_url('profile/'.$user->id.'/'.get_user_fullname_by_id($user->id));?>">
                  <img class="img-responsive cir" src="<?php echo get_profile_photo_by_id($user->id,'thumb');?>" alt="" />
              </a>             
          </div>  
          <div class="col-sm-7">
             <h2><?php echo $user->first_name.' '.$user->last_name; ?></h2>
			<?php if(get_user_meta($user->id, 'company_name')!=''){?>
                <p class="contact-types">
                    <strong><?php echo lang_key('company_name'); ?>:</strong> <?php echo get_user_meta($user->id, 'company_name'); ?></a>
                </p>
            <?php }?>
            <?php if(get_user_meta($user->id, 'about_me')!=''){?>
            <!-- Para -->
            <p><?php echo get_user_meta($user->id, 'about_me'); ?></p>
            <?php }?>
            <p class="contact-types">
                <?php if(get_user_meta($user->id, 'hide_phone',0)==0) {?>
                <strong><?php echo lang_key('phone'); ?>:</strong> <?php echo get_user_meta($user->id, 'phone'); ?> <br />
                <?php }?>
                <?php if(get_user_meta($user->id, 'hide_email',0)==0) {?>
                <strong>Email:</strong> <a href="mailto:<?php echo $user->user_email; ?>"><?php echo $user->user_email; ?></a>
                <?php }?>
            </p>
            <!-- Social -->
            <?php $fb_profile = get_user_meta($user->id, 'fb_profile'); ?>
            <?php $gp_profile = get_user_meta($user->id, 'gp_profile'); ?>
            <?php $twitter_profile = get_user_meta($user->id, 'twitter_profile'); ?>
            <?php $li_profile = get_user_meta($user->id, 'li_profile'); ?>
            <div class="brand-bg">
                <?php if($fb_profile != ''){?>
                <a class="facebook" href="https://<?php echo $fb_profile; ?>"><i class="fa fa-facebook circle-3"></i></a>
                <?php }?>
                <?php if($gp_profile != ''){?>
                <a class="google-plus" href="https://<?php echo $gp_profile; ?>"><i class="fa fa-google-plus circle-3"></i></a>
                <?php }?>
                <?php if($twitter_profile != ''){?>
                <a class="twitter" href="https://<?php echo $twitter_profile; ?>"><i class="fa fa-twitter circle-3"></i></a>
                <?php }?>
                <?php if($li_profile != ''){?>
                <a class="linkedin" href="https://<?php echo $li_profile; ?>"><i class="fa fa-linkedin circle-3"></i></a>
                <?php }?>
            </div>             
            </div>
            
            
          
          <div class="col-sm-3">
          
          <div class="reviews">
            <p><span>Informative</span> <span class="countc"><?php echo count_total_review_information_by_user($user->id,'informative');?></span></p><label></label>
            
             
             
              <p><span>Funny</span> <span class="countc"><?php echo count_total_review_information_by_user($user->id,'funny');?></span></p>
              <label></label>
               <p><span>Awesome</span> <span class="countc"><?php echo count_total_review_information_by_user($user->id,'awesome');?></span></p><label></label>
                <p><span>Suspect</span> <span class="countc"><?php echo count_total_review_information_by_user($user->id,'suspect');?></span></p><label></label>
                
                  <a style="background: #80b13f; color:#fff; padding: 10px 16px;display: inline-block;" data-toggle="modal"  href="#login"> View Review Chart </a>
          </div>
             
          </div>
                      
          <div class="clear-fix"></div>
          </section>
          <div class="row">
         <!-- <div class="col-sm-12">
         <table width="100%" class="re_response">
         <tr>
          <td><h6>Informative</h6><?php echo count_total_review_information_by_user($user->id,'informative');?></td>
          <td><h6>Funny</h6>
					<?php echo count_total_review_information_by_user($user->id,'funny');?></td>
          <td><h6>Awesome</h6>
					<?php echo count_total_review_information_by_user($user->id,'awesome');?></td>
          <td><h6>Suspect</h6>
					<?php echo count_total_review_information_by_user($user->id,'suspect');?></td>
         </tr>
         </table>
			 
               </div>-->
              
             
            
          <div class="clear-fix"></div>
       <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">            
            <!--recent review-->
            <div class="recent_review">
            	<div id="" class="view-all-user-review"></div>			
        		<div class="clear"></div>
            </div>
			<!--recent shrug-->
            <div class="recent_shrug">
            	<div id="" class="view-all-user-shrug"></div>			
        		<div class="clear"></div>
            </div>
             <!--recent single thumb-->
            <div class="recent_single_thumb">
            	<div id="" class="view-all-user-single-thumb"></div>			
        		<div class="clear"></div>
            </div>
             <!--recent two thumbs-->
            <div class="recent_two_thumbs">
            	<div id="" class="view-all-user-two-thumbs"></div>			
        		<div class="clear"></div>
            </div>
			 <!--recent trophy-->
            <div class="recent_trophys">
            	<div id="" class="view-all-user-trophys"></div>			
        		<div class="clear"></div>
            </div>
			
			
            
             
            
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


    
    
        </div>


    </div>
</div>

<div id="reviewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel">Review Detail</h4>

            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>

</div>


<!-- pie data-->
      
<script type="text/javascript">
	jQuery(document).ready(function() {
		
		var options = {
			chart: {
				renderTo: 'show_pie',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: {
				text: 'Review chart'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				/*formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+  this.percentage  +' %';
					
				}*/
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',											
						/*formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
						}*/
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Browser share',
				data: []
			}]
		}
		
		jQuery.getJSON('<?php echo site_url("show/pie_data/".$user->id);?>', function(json) {
			options.series[0].data = json;
			chart = new Highcharts.Chart(options);
		});
		
		
		
	});   
</script>
<script src="<?php echo theme_url();?>/assets/js/highcharts.js"></script>
<script src="<?php echo theme_url();?>/assets/js/exporting.js"></script>
<!-- end pie-->
        

<script type="text/javascript">
    jQuery(document).ready(function(){
		
		
		//load all review.
	    var loadUrl = '<?php echo site_url("show/load_all_user_review_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-review').html(responseText);
                init_load_more_user_review_js();
            }
        );
		 function init_load_more_user_review_js()
        {
			jQuery("#pagination-review a").live('click',function(e){
				e.preventDefault();
				 jQuery('.recent-user-review-loading').show();
				jQuery.ajax({
				type: "POST",
				url: jQuery(this).attr("href"),
				success: function(res){
				  jQuery('.show-user-reviews').html(res);
				   jQuery('.recent-user-review-loading').hide();
				}
				});
				return false;
			});
	   }
	   // filter revies.
	   jQuery(".filter-review-information").live('change',function(e){
				e.preventDefault();		
				review_filter();				 
			});
			// filter.
		function review_filter()
		{
						
			 jQuery('.recent-user-review-loading').show();
			// var dataString = $('.form-filter-review').serializeArray();
			 var $filter_form = $('.form-filter-review');
			 var category = $filter_form.find('.category').val();
			 var city = $filter_form.find('.city').val();
			 var information = $filter_form.find('.information').val();
			  
			 var URL = '<?php echo site_url("show/load_all_user_review_filter_view/".$user->id);?>/'+category+'/'+city+'/'+information;		
			jQuery.ajax({
				type: "POST",				
				url: URL,
				success: function(res){
				  jQuery('.show-user-reviews').html(res);
				   jQuery('.recent-user-review-loading').hide();
				}
			});
			return false;
			
		}	
			
	   // end filter.
	   
	 // Load all user trophys	
	    var loadUrl = '<?php echo site_url("show/load_all_user_trophy_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-trophys').html(responseText);
                init_load_more_user_trophy_js();
            }
        );
		 function init_load_more_user_trophy_js()
        {
		jQuery("#pagination-trophy a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-user-trophy-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-user-trophys').html(res);
			   jQuery('.recent-user-trophy-loading').hide();
			}
			});
			return false;
		});
	 }
	 // Load all user two thumb	
	    var loadUrl = '<?php echo site_url("show/load_all_user_two_thumbs_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-two-thumbs').html(responseText);
                init_load_more_user_two_thumbs_js();
            }
        );
		 function init_load_more_user_two_thumbs_js()
        {
		jQuery("#pagination-two-thumbs a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-user-two-thumbs-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-user-two-thumbs').html(res);
			   jQuery('.recent-user-two-thumbs-loading').hide();
			}
			});
			return false;
		});
	 }
	 // Load all user single thumb	
	    var loadUrl = '<?php echo site_url("show/load_all_user_single_thumb_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-single-thumb').html(responseText);
                init_load_more_user_single_thumb_js();
            }
        );
		 function init_load_more_user_single_thumb_js()
        {
		jQuery("#pagination-single-thumb a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-user-single-thumb-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-user-single-thumb').html(res);
			   jQuery('.recent-user-single-thumb-loading').hide();
			}
			});
			return false;
		});
	 }
	 // Load all user shrug	
	    var loadUrl = '<?php echo site_url("show/load_all_user_shrug_view/".$user->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.view-all-user-shrug').html(responseText);
                init_load_more_user_shrug_js();
            }
        );
		function init_load_more_user_shrug_js()
        {
		jQuery("#pagination-shrug a").live('click',function(e){
			e.preventDefault();
			 jQuery('.recent-user-shrug-loading').show();
			jQuery.ajax({
			type: "POST",
			url: jQuery(this).attr("href"),
			success: function(res){
			  jQuery('.show-user-shrug').html(res);
			   jQuery('.recent-user-shrug-loading').hide();
			}
			});
			return false;
		});
	 }
	 
	 
	});	 
</script>

<?php }else{ ?>
	<div class="container">
     <div class="alert alert-danger"><p>Invalid User</p></div>
    </div>
<?php } ?>




<div class="modal fade poup" id="login" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          Review Chart Detail
        </div>
        <div class="modal-body loginbox">
          
          <div class="row">
          		<div id="show_pie" style="min-width:595px; height:500px; margin: 0 auto"></div>
           </div>
        </div>
        
      </div>
    </div>
  </div>
  
  
<script type="text/javascript">
    jQuery(document).ready(function(){
		jQuery('.bucktcls').find('input[type=checkbox]:checked').parent().parent().addClass('iamdone')
		  });   
		
		</script>