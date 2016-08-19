
<?php $CI = get_instance(); ?>
<link href="<?php echo theme_url();?>/assets/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo theme_url();?>/assets/jquery-ui/jquery-ui.js"></script>

<link href="<?php echo theme_url();?>/assets/css/select2.css" rel="stylesheet">
<script src="<?php echo theme_url();?>/assets/js/select2.js"></script>



    <form role="form" action="<?php echo site_url('show/advfilter')?>" method="post">
            
              <div class="col-sm-6">  
                     <div class="col-sm-3">               
                       <strong>City</strong>  
                    </div>
                    <div class="col-sm-9">  
                    <select id="input-11" name="city" class="form-control chosen-select">
                        <option data-name="" value="any"><?php echo lang_key('any_city');?></option>
                          <?php foreach (get_all_cities_by_use()->result() as $row) {
                              $sel = ($row->id==set_value('city'))?'selected="selected"':'';
                              ?>
                              <option data-name="<?php echo $row->name;?>" class="cities city-<?php echo $row->parent;?>" value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo lang_key($row->name);?></option>
                          <?php }?>
                    </select>      
                    
                    </div>          
            </div>
            <div class="col-sm-6">  
            		 <div class="col-sm-3">                 
                    	<strong>Category</strong>
                    </div>
                     <div class="col-sm-9">    
                    <?php
                    $CI = get_instance();
                    $CI->load->model('user/post_model');
                    $categories = $CI->post_model->get_all_categories();
                    ?>
                    <select id="input-14" name="category" class="form-control chosen-select">
                        <option value="any"><?php echo lang_key('any_category');?></option>
                          <?php foreach ($categories as $row) {
                              $sub = ($row->parent!=0)?'--':'';
                              $sel = (set_value('category')==$row->id)?'selected="selected"':'';
                          ?>
                              <option value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $sub.lang_key($row->title);?></option>
                          <?php
                          }?>
                    </select>   
                 </div>               
            </div>
                <div class="col-sm-12">
                
                	<div class="col-sm-6">                           
                    <?php echo lang_key('distance_around_my_position'); ?>: <span class="price-range-amount-view" id="amount"></span>               
                    <div class="clearfix"></div>
                     <a href="javascript:void(0);" onclick="findLocation()" class="btn btn-orange btn-xs find-my-location" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo lang_key('identify_my_location');?>"><i class="fa fa-location-arrow"></i></a>
                    <div id="slider-price-sell" class="price-range-slider"></div>
                    <input type="hidden" id="price-slider-sell" name="distance" value="">
                    <input type="hidden" id="geo_lat" name="geo_lat" value="">
                    <input type="hidden" id="geo_lng" name="geo_lng" value="">                    
                   </div> 
                   <div class="col-sm-6"> </div>                
             </div>
             <div class="col-sm-12 submitcls">            
                    <button type="submit" class="btn btn-color"><i class="fa fa-search"></i>&nbsp; <?php echo lang_key('search_businesses'); ?></button>
                
            </div>
      
    </form>

                 
<script type="text/javascript">

    var ua = navigator.userAgent.toLowerCase();
    var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");

    jQuery(window).resize(function(){
        if(!isAndroid) {
            $('.chosen-select').select2({
                theme: "classic"
            });
        }
    });

    $(document).ready(function(){
        if(!isAndroid) {
            $('.chosen-select').select2({
                theme: "classic"
            });
        }
        
        var distance_unit = '<?php echo lang_key(get_settings("business_settings", "show_distance_in", "miles")); ?>';

        $("#slider-price-sell").slider({

            min: <?php echo $this->config->item('min_distance');?>,

            max: <?php echo $this->config->item('max_distance');?>,

            value: <?php echo $this->config->item('default_distance');?>,

            slide: function (event, ui) {

                $("#price-slider-sell").val(ui.value);
                $("#amount").html( ui.value + ' ' + distance_unit );

            }

        });
        $("#amount").html($( "#slider-price-sell" ).slider( "value") + ' ' + distance_unit);


    });

    function findLocation()
    {
        if(!!navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function(position) {

                $('#geo_lat').val(position.coords.latitude);
                $('#geo_lng').val(position.coords.longitude);


            });

        } else {
            alert('No Geolocation Support.');
        }
    }

</script>
<!-- property search big form -->