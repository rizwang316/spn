<?php $post = $post->row(); ?>
<?php //echo '<pre>';print_r($post); echo '</pre>'; ?>

<!-- Page heading two starts -->
<div class="container rs-property">
    <div class="single-property">
      <!-- Nav tabs -->                  
                <div class="ajax-loading review-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>
                <?php if(is_loggedin()){?>
                    <span class="review-form-holder"></span>
                <?php } else { ?>
                    <div class="alert alert-info" role="alert"><?php echo lang_key('review_alert'); ?></div>
                <?php } ?>  

                <div class="connectimglove">
                    <h3><a href="#">Connecting With Love</a> <img src="<?php echo theme_url();?>/assets/images/connectlove.png"></h3>
                </div>
    </div>
</div>

<?php if(is_loggedin()){?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            var loadUrl = '<?php echo site_url("show/review/load_review_form/".$post->id);?>';
            jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery('.review-form-holder').html(responseText);
                    init_create_review_js();
                }
            );
        });

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
                        jQuery('.review-form-holder').html(responseText);
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

    
<?php } ?>
