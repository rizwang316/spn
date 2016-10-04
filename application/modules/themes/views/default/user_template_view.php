<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <?php	
    $page = get_current_page();

    if (!isset($sub_title))
        $sub_title = (isset($page['title'])) ? $page['title'] : lang_key('list_business');

    $seo = (isset($page['seo_settings']) && $page['seo_settings'] != '') ? (array)json_decode($page['seo_settings']) : array();

    if (!isset($meta_desc))
        $meta_desc = (isset($seo['meta_description'])) ? $seo['meta_description'] : get_settings('site_settings', 'meta_description', 'autocon car dealership');

    if (!isset($key_words))
        $key_words = (isset($seo['key_words'])) ? $seo['key_words'] : get_settings('site_settings', 'key_words', 'car dealership,car listing, house, car');

  
    ?>

    <?php
    if(isset($post))
    {
        echo (isset($post))?social_sharing_meta_tags_for_post($post):'';
    }
    elseif(isset($blog_meta))
    {
        echo (isset($blog_meta))?social_sharing_meta_tags_for_blog($blog_meta):'';

    }

    ?>

    <title><?php echo translate(get_settings('site_settings', 'site_title', 'Services Professionals  Network')); ?>
        | <?php echo translate($sub_title); ?></title>
        
    
    <meta name="description" content="<?php echo $meta_desc; ?>">
    <meta name="keywords" content="<?php echo $key_words; ?>"/>
    

    <link rel="icon" type="image/png" href="<?php echo theme_url();?>/assets/img/favicon.png">

    <?php require_once('includes/includes_top.php'); ?>

      <script type="text/javascript">var old_ie = 0;</script>
      <!--[if lte IE 8]> <script type="text/javascript"> old_ie = 1; </script> < ![endif]-->
  </head>
  <body>
       <div class="headercls">
       <div class="beforecls"></div>
          <div class="container">
             <img src="<?php echo theme_url();?>/assets/images/logospnan.png">
          </div>
          <div class="aftercls"></div>
       </div><!--topheader-->
       <?php require_once('includes/sounds.php'); ?>   
          
       
       <?php
	   if(is_loggedin() && is_personal()){    
	    	require_once('includes/user_header.php');
		}else{
			require_once('includes/header.php');
		}
		 ?>       
       
       
       
             <!-- content wrapper-->
          <?php echo (isset($content))?$content:'';?>
          
       
       
       <!-- include footer top-->       
      <!-- footer--> 
      
       <?php
	   if(is_loggedin() && is_personal()){   
	   		require_once('user/user-friend-list.php'); 
	   }
		?>
        
        <?php require_once('includes/user_footer.php'); ?>
         
        <!-- footer--> 
       <?php require_once('includes/footer.php'); ?>
       
       
    <!-- footer js -->
    <?php require_once('includes/includes_bottom.php'); ?>
    <?php require_once('includes/js-socket-common.php'); ?>
    

  </body>
</html>