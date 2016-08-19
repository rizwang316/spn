<span class="totop"><a href="#"><i class="fa fa-angle-up bg-color"></i></a></span>

<!-- Placeholders JS -->
<script src="<?php echo theme_url();?>/assets/js/placeholders.js"></script>

<script src="<?php echo theme_url();?>/assets/js/bootstrap-select.js"></script>

<!-- bootstrap tag cloud -->
<script src="<?php echo theme_url();?>/assets/js/bootstrap-tag-cloud.js"></script>         

<!-- Magnific Popup -->
<script src="<?php echo theme_url();?>/assets/js/jquery.magnific-popup.min.js"></script>
<!-- Owl carousel -->
<script src="<?php echo theme_url();?>/assets/js/owl.carousel.min.js"></script>

<!-- Main JS -->
<script src="<?php echo theme_url();?>/assets/js/main.js"></script>


<script src="<?php echo theme_url();?>/assets/js/respond.min.js"></script>
<!-- HTML5 Support for IE -->
<script src="<?php echo theme_url();?>/assets/js/html5shiv.js"></script>

<!-- Custom JS. Type your JS code in custom.js file -->
<script src="<?php echo theme_url();?>/assets/js/custom.js"></script>

<!--    <script src="--><?php //echo theme_url();?><!--/assets/js/ion.rangeSlider.min.js"></script>-->

<!--    <script src="--><?php //echo theme_url();?><!--/assets/js/jquery.slider.min.js"></script>-->

<script src="<?php echo theme_url();?>/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="<?php echo theme_url();?>/assets/js/waypoints.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/jquery.countTo.js"></script>

<?php
$ga_tracking_code = get_settings('site_settings','ga_tracking_code','');

if($ga_tracking_code != ''){
    echo $ga_tracking_code;
}

?>
<script type="text/javascript">
    jQuery(document).ready(function(){

        if(old_ie==1)
        {
            jQuery('#ie-msg-modal').modal('show');
        }

        jQuery('.signin').click(function(e){
            e.preventDefault();
            jQuery('#signin-modal').modal('show');
        });

        // jQuery(window).resize(function(){
        //    console.log(jQuery(window).width());
        // });
    });
</script>
<script type="text/javascript">


    $(document).ready(function() {

        jQuery('.list-switcher').each(function(){
            jQuery(this).children(":first").trigger('click');
        });

        jQuery('.featured-list-switcher').each(function(){
            jQuery(this).children(":first").trigger('click');
        });

        fix_grid_height();


    });

    function fix_grid_height()
    {
        var maxHeight = -1;
        $('.item-title').each(function() {
            maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
        });

        $('.item-title').each(function() {
            $(this).height(maxHeight);
        });
        jQuery('.find-my-location').tooltip();
        jQuery('.hot-tag').tooltip();
        jQuery('.hot-tag-list').tooltip();
    }

</script>