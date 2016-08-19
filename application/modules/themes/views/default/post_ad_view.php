<link href="<?php echo theme_url();?>/assets/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo theme_url();?>/assets/jquery-ui/jquery-ui.js"></script>
<style>
    #form-map{
        background-color: #e5e3df;
        height: 300px;
        width: 100%;
    }
    #form-map img { max-width: none; }
</style>

<div class="container">
        <form action="<?php echo site_url('create-business');?>" method="post"  class="form-horizontal">
		
        <div class="row">
            <?php echo $this->session->flashdata('msg');?>
            <?php if(isset($msg) && $msg!='') echo $msg;?>
			<?php echo validation_errors(); ?>
		
		<?php  if(!is_loggedin()){ ?>
		<div class="col-md-12">
			<h4>Register your Business Account</h4> 
			 or Click here if you already registered <a  href="<?php echo site_url('account/login');?>">
			<?php echo lang_key('signin');?></a>			
			<hr />
		</div>
		<div class="col-md-6 pull-left"> 
        <!-- Login starts -->
        <div class="" > 
          <!-- Form Group -->
          <div class="form-group"> 
            <!-- Label -->
            <label for="name" class="col-sm-3 control-label"><?php echo lang_key('first_name'); ?> <span class="text-danger">*</span></label>
            <div class="col-sm-9"> 
              <!-- Input -->
              <input type="text" name="first_name" value="<?php echo set_value('first_name');?>" placeholder="<?php echo lang_key('first_name'); ?>" class="form-control">
              <?php echo form_error('first_name');?> </div>
          </div>
          
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label"><?php echo lang_key('email'); ?> <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="text" name="useremail" value="<?php echo set_value('useremail');?>" placeholder="<?php echo lang_key('email'); ?>" class="form-control">
              <?php echo form_error('useremail');?> </div>
          </div>
          
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label"><?php echo lang_key('phone'); ?></label>
            <div class="col-sm-9">
              <input type="text" name="phone" value="<?php echo set_value('phone');?>" placeholder="<?php echo lang_key('phone'); ?>" class="form-control">
              <?php echo form_error('phone');?> </div>
          </div>
          
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label"><?php echo lang_key('password');?> <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="password" name="password" placeholder="<?php echo lang_key('password'); ?>" class="form-control">
              <?php echo form_error('password');?> </div>
          </div>
          
          
          
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <input type="hidden" name="terms_conditon" id="terms_conditon" value="<?php echo (isset($_POST['terms_conditon_field']))?$_POST['terms_conditon_field']:'';?>">
            </div>
          </div>
        </div>
        <!-- Login ends --> 
      </div>
      <div class="col-md-6 pull-right" > 
        <!-- Login starts -->
        <div class="" > 
          <div class="form-group"> 
            <!-- Label -->
            <label for="name" class="col-sm-3 control-label"><?php echo lang_key('last_name'); ?> <span class="text-danger">*</span></label>
            <div class="col-sm-9"> 
              <!-- Input -->
              <input type="text" name="last_name" value="<?php echo set_value('last_name');?>" placeholder="<?php echo lang_key('last_name'); ?>" class="form-control">
              <?php echo form_error('last_name');?> </div>
          </div>
          
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label"><?php echo lang_key('username'); ?> <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="text" name="username" value="<?php echo set_value('username');?>" placeholder="<?php echo lang_key('username'); ?>" class="form-control">
              <?php echo form_error('username');?> </div>
          </div>
          
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label"><?php echo lang_key('company_name'); ?></label>
            <div class="col-sm-9">
              <input type="text" name="company_name" value="<?php echo set_value('company_name');?>" placeholder="<?php echo lang_key('company_name'); ?>" class="form-control">
              <?php echo form_error('company_name');?> </div>
          </div>
          
          
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label"><?php echo lang_key('confirm_password');?> <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="password" name="repassword"  placeholder="<?php echo lang_key('confirm_password'); ?>" class="form-control">
              <?php echo form_error('repassword');?> </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <input type="hidden" name="terms_conditon" id="terms_conditon" value="<?php echo (isset($_POST['terms_conditon_field']))?$_POST['terms_conditon_field']:'';?>">
            </div>
          </div>
        </div>
        <!-- Login ends --> 
      </div>
         <div class="clear-fix"></div>
		
		<?php } ?>
	  
            <div class="col-md-6 col-sm-6">
                <!-- Shopping items content -->
                <div class="shopping-content">
                    <div class="shopping-checkout">
                        <!-- Heading -->
                            <h4><?php echo lang_key('basic_info');?></h4>
                            <hr/>

                            <div class="form-group category">
                                <label class="col-md-3 control-label" for="inputEmail1"><?php echo lang_key('category');?></label>
                                <div class="col-md-8 ">
                                      <div class="category-scroll">
                                        <?php foreach ($categories as $row) { ?>
                                          <label style="display: block">
                                            <?php $v = (set_value("category[]")== $row->id)?'checked="checked"':'';?>
                                            <input type="checkbox" <?=$v?>  value="<?php echo $row->id;?>" name="category[]" >
                                            <strong><?=$row->title?></strong>
                                              </label>
                                            <?php } ?>
                                      </div>
                                    <?php echo form_error('category[]');?>
                                </div>
                            </div> 
							<div class="form-group">
									<label class="col-md-3 control-label">&nbsp;</label>
									<div class="col-md-8">
										<div class="alert alert-info">You can select max 5 categories from list.</div>
									</div>
								</div>

                        <!--<div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('tags');?></label>
                            <div class="col-md-8">
                                <div id="tag-success" class="input-append" data-cloud-name="tag-cloud1">
                                    <input type="text" class="form-control input-sm">
                                    <button class="btn btn-success btn-sm" type="button">Add<b>+</b></button>
                                </div>
                                <?php $v = (set_value('tags')!='')?set_value('tags'):'';?>
                                <ul id="tag-cloud1"><?php if(!empty($v)){ foreach($v as $tag){ ?>
                                        <li class="tag-cloud tag-cloud-info"><input type="hidden" name="tags[]" value="<?=$tag?>"><?=$tag?></li>
                                    <?php } }?></ul>
                                <?php echo form_error('tags');?>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('phone');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('phone_no')!='')?set_value('phone_no'):'';?>
                                <input id="phone_no" type="text" name="phone_no" placeholder="<?php echo lang_key('phone');?>" value="<?php echo $v;?>" class="form-control">
                                <?php echo form_error('phone_no');?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('email');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('email')!='')?set_value('email'):'';?>
                                <input id="email" type="text" name="email" placeholder="<?php echo lang_key('email');?>" value="<?php echo $v;?>" class="form-control">
                                <?php echo form_error('email');?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('website');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('website')!='')?set_value('website'):'';?>
                                <input id="website" type="text" name="website" placeholder="<?php echo lang_key('website');?>" value="<?php echo $v;?>" class="form-control">
                                <?php echo form_error('website');?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('founded');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('founded')!='')?set_value('founded'):'';?>
                                <input id="website" type="text" name="founded" placeholder="<?php echo lang_key('year');?>" value="<?php echo $v;?>" class="form-control">
                                <?php echo form_error('founded');?>
                            </div>
                        </div>                            
                            <h4><?php echo lang_key('address_info');?></h4>
                            <hr/>



                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('country');?></label>
                                <div class="col-md-8">
                                    <select name="country" id="country" class="form-control">
                                        <option data-name="" value=""><?php echo lang_key('select_country');?></option>
                                        <?php foreach (get_all_locations_by_type('country')->result() as $row) {
                                            $sel = ($row->id==set_value('country'))?'selected="selected"':'';
                                            ?>
                                            <option data-name="<?php echo $row->name;?>" value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $row->name;?></option>
                                        <?php }?>
                                    </select>
                                    <?php echo form_error('country');?>
                                </div>
                            </div>
                        <?php $state_active = get_settings('business_settings', 'show_state_province', 'yes'); ?>
                        <?php if($state_active == 'yes'){ ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('state');?></label>
                                <div class="col-md-8">
                                    <select name="state" id="state" class="form-control">
                                        
                                    </select>
                                    <?php echo form_error('state');?>
                                </div>
                            </div>
                        <?php } ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('city');?></label>
                                <div class="col-md-8">
                                    <?php $city_field_type = get_settings('business_settings', 'city_dropdown', 'autocomplete'); ?>
                                    <input type="hidden" name="selected_city" id="selected_city" value="<?php echo(set_value('selected_city')!='')?set_value('selected_city'):'';?>">
                                    <?php if ($city_field_type=='dropdown') {?>
                                    <select name="city" id="city_dropdown" class="form-control">                                        
                                    </select>
                                    <?php }else {?>
                                    <input type="text" id="city" name="city" value="<?php echo(set_value('city')!='')?set_value('city'):'';?>" placeholder="<?php echo lang_key('city');?>" class="form-control" >
                                    <span class="help-inline city-loading">&nbsp;</span>
                                    <?php }?>
                                    <?php echo form_error('city');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('zip_code');?></label>
                                <div class="col-md-8">
                                    <?php $v = (set_value('zip_code')!='')?set_value('zip_code'):'';?>
                                    <input type="text" name="zip_code" placeholder="<?php echo lang_key('zip_code');?>" value="<?php echo $v;?>" class="form-control">
                                    <?php echo form_error('zip_code');?>
                                </div>
                            </div>

                            <!--div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('address');?></label>
                                <div class="col-md-8">
                                <?php $v = (set_value('address')!='')?set_value('address'):'';?>
                                    <input id="address" type="text" name="address" placeholder="<?php echo lang_key('address');?>" value="<?php echo $v;?>" class="form-control">
                                    <?php echo form_error('address');?>
                                </div>
                            </div-->

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo lang_key('address');?></label>
                                    <div class="col-md-8">
                                        <?php $v = (set_value('address')!='')?set_value('address'):'';?>
                                        <input type="text" id="address" name="address" placeholder="<?php echo lang_key('address');?>" value="<?php echo $v;?>" class="form-control">
                                        <?php echo form_error('address');?>
                                    </div>
                                </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="codeAddress()">
									<i class="fa fa-map-marker"></i> <?php echo lang_key('view_on_map');?></a>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">&nbsp;</label>
                                <div class="col-md-8">
                                    <div id="form-map"></div>
                                </div>
                            </div>
							 <div class="form-group">
									<label class="col-md-3 control-label">&nbsp;</label>
									<div class="col-md-8">
										<div class="alert alert-info">Click on  <a href="javascript:void(0)"  onclick="codeAddress()">
											<?php echo lang_key('view_on_map');?></a> for getting Latitude and  Longitude. </div>
									</div>
								</div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('latitude');?></label>
                                <div class="col-md-8">
                                    <?php $v = (set_value('latitude')!='')?set_value('latitude'):'';?>
                                    <input id="latitude" type="text" name="latitude" placeholder="<?php echo lang_key('latitude');?>" value="<?php echo $v;?>" class="form-control">
                                    <?php echo form_error('latitude');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('longitude');?></label>
                                <div class="col-md-8">
                                    <?php $v = (set_value('longitude')!='')?set_value('longitude'):'';?>
                                    <input id="longitude" type="text" name="longitude" placeholder="<?php echo lang_key('longitude');?>" value="<?php echo $v;?>" class="form-control">
                                    <?php echo form_error('longitude');?>
                                </div>
                            </div>                            
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4><?php echo lang_key('general_info');?></h4>
                <hr/>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Business Name</label>
                            <div class="col-md-8">
                                <?php $v = (set_value('title')!='')?set_value('title'):'';?>
                                <input type="text" name="title" placeholder="Business Name" value="<?php echo $v;?>" class="form-control">
                                <?php echo form_error('title');?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('description');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('description')!='')?set_value('description'):'';?>
                                <textarea rows="15"   name="description" id="rich" class="rich"><?php echo $v;?></textarea>
                                <?php echo form_error('description');?>
                            </div>
                        </div>
						<div class="clear-fix"></div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'Area Served'; //echo lang_key('tags');?></label>
                         <div class="col-md-8">
                            <div id="tag-info" class="input-append" data-cloud-name="tag-cloud2">
                                <input type="text" class="form-control area-input pull-left">
                                <button class="btn btn-warning" type="button">Add+</button>
                            </div>
                            <div class="clear-fix"></div>
                            <?php $v = (set_value('area_served')!='')?set_value('area_served'):'';?>
                            <ul id="tag-cloud2" class="tag-clouds">
                                <?php if(!empty($v)){ foreach($v as $area){ ?>
                                    <li class="tag-cloud tag-cloud-info"><input type="hidden" name="area_served[]" value="<?=$area?>"><?=$area?></li>
                                <?php } }?>
                            </ul>
                            <?php echo form_error('area_served');?>
                        </div>
                   </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo lang_key('featured_image');?>
                    <br /> <small class="small-size">Min(175*175)</small></label>
                    <div class="col-md-8">
                        <div class="featured-img">
                            <?php $v = (set_value('featured_img')!='')?set_value('featured_img'):'';?>
                            <input type="hidden" name="featured_img" id="featured-img-input" value="<?php echo $v;?>">
                            <img id="featured-img" src="<?php echo base_url('uploads/images/no-image.png');?>">
                            <div class="upload-button"><?php echo lang_key('upload');?></div>
                             <div class="clear-fix"></div>
                            <?php echo form_error('featured_img');?>
                            
                        </div>
                    </div>
                </div>
                <div class="clear-fix"></div>

                 <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp;</label>
                    <div class="col-md-8">
                        <div class="alert alert-info"><?php echo lang_key('upload_later_msg');?></div>
                    </div>
                </div>

                
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="form-group" style="text-align:center">
                    <button class="btn btn-color" type="submit"><?php echo lang_key('save');?></button>
                    <button class="btn btn-default" type="reset"><?php echo lang_key('reset');?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    // category validation.
    var theCheckboxes = $(".category input[type='checkbox']");
    theCheckboxes.click(function()
    {
    if (theCheckboxes.filter(":checked").length > 5)
    $(this).removeAttr("checked");
    });
</script>
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script src="<?php echo theme_url();?>/assets/js/markercluster.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map-icons.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map_config.js"></script>

<script src="<?php echo theme_url();?>/assets/js/jquery.form.js"></script>
<?php require 'multiple-uploader.php';?>

<script type="text/javascript">

$(document).on('keyup keypress', 'form input[type="text"]', function(e) {
  if(e.which == 13) {
    e.preventDefault();
    return false;
  }
});

jQuery(document).ready(function(){

    var city_field_type =  '<?php echo get_settings("business_settings", "city_dropdown", "autocomplete"); ?>' ;
    //alert(city_field_type);
    jQuery('#contact_for_price').click(function(){
        show_hide_price();
    });
    show_hide_price();

    jQuery('.upload-button').click(function(){
        jQuery('#photoimg_featured').click();
    });

    jQuery('#featured-img-input').change(function(){
        var val = jQuery(this).val();
        if(val=='')
        {
            val = 'no-image.png';
        }

        var base_url  = '<?php echo base_url();?>';
        var image_url = base_url+'uploads/thumbs/'+val;
        jQuery( '#featured-img' ).attr('src',image_url);

    }).change();

    var site_url = '<?php echo site_url();?>';
    jQuery('#country').change(function(){
        // jQuery('#city').val('');
        // jQuery('#selected_city').val('');
        var val = jQuery(this).val();
        
        var loadUrl = site_url+'/show/get_locations_by_parent_ajax/'+val;

        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                <?php if($state_active=='yes'){?>
                jQuery('#state').html(responseText);
                var sel_country = '<?php echo (set_value("country")!='')?set_value("country"):'';?>';
                var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):'';?>';
                if(val==sel_country)
                jQuery('#state').val(sel_state);
                else
                jQuery('#state').val('');
                jQuery('#state').focus();
                jQuery('#state').trigger('change');
                <?php }else{?>
                var sel_country = '<?php echo (set_value("country")!='')?set_value("country"):'';?>';
                var sel_city   = '<?php echo (set_value("selected_city")!='')?set_value("selected_city"):'';?>';
                var city   = '<?php echo (set_value("city")!='')?set_value("city"):'';?>';
                if(city_field_type=='dropdown')
                populate_city(val); //populate the city drop down
                if(val==sel_country)
                {
                    jQuery('#selected_city').val(sel_city);
                    jQuery('#city').val(city);
                }
                else
                {
                    jQuery('#selected_city').val(sel_city);
                    jQuery('#city').val('');            
                }
                <?php }?>

            }
        );
     }).change();

    jQuery('#state').change(function(){
        <?php if($state_active=='yes'){?>
        var val = jQuery(this).val();
        var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):'';?>';
        var sel_city   = '<?php echo (set_value("selected_city")!='')?set_value("selected_city"):'';?>';
        var city   = '<?php echo (set_value("city")!='')?set_value("city"):'';?>';
        
        if(city_field_type=='dropdown')
        populate_city(val); //populate the city drop down

        if(val==sel_state)
        {
            jQuery('#selected_city').val(sel_city);
            jQuery('#city').val(city);
        }
        else
        {
            jQuery('#selected_city').val('');
            jQuery('#city').val('');            
        }
        <?php }?>

    });

    <?php if($state_active == 'yes'){ ?>

        var parent = '#state';
    <?php } else { ?>

        var parent = '#country';
    <?php } ?>

    if(city_field_type=='autocomplete') {
        jQuery( "#city" ).bind( "keydown", function( event ) {
            if ( event.keyCode === jQuery.ui.keyCode.TAB &&
                jQuery( this ).data( "ui-autocomplete" ).menu.active ) {
                event.preventDefault();
            }
        })
            .autocomplete({
                source: function( request, response ) {

                    jQuery.post(
                        "<?php echo site_url('show/get_cities_ajax');?>/",
                        {term: request.term,parent: jQuery(parent).val()},
                        function(responseText){
                            response(responseText);
                            jQuery('#selected_city').val('');
                            jQuery('.city-loading').html('');
                        },
                        "json"
                    );
                },
                search: function() {
                    // custom minLength
                    var term = this.value ;
                    if ( term.length < 2 || jQuery(parent).val()=='') {
                        return false;
                    }
                    else
                    {
                        jQuery('.city-loading').html('Loading...');
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    this.value = ui.item.value;
                    jQuery('#selected_city').val(ui.item.id);
                    jQuery('.city-loading').html('');
                    return false;
                }
            });
    }
    else if(city_field_type=='dropdown') {
        jQuery('#city_dropdown').change(function (){
            var val = jQuery('option:selected', this).attr('city_id');
            jQuery('#selected_city').val(val);
        });
    }

});
function show_hide_price()
{
    var val = jQuery('#contact_for_price').attr('checked');
    if(val=='checked')
    {
        jQuery('.price-input-holder').hide();
    }
    else
    {
        jQuery('.price-input-holder').show();        
    }
}

function populate_city(parent) {
    var site_url = '<?php echo site_url();?>';
    var loadUrl = site_url+'/show/get_city_dropdown_by_parent_ajax/'+parent;
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('#city_dropdown').html(responseText);
                var sel_city   = '<?php echo (set_value("city")!='')?set_value("city"):'';?>';
                jQuery('#city_dropdown').val(sel_city);
            }
        );
}
</script>

<script type="text/javascript" src="<?php echo base_url('assets/tinymce/tinymce.min.js');?>"></script>

<script type="text/javascript">

tinymce.init({
    convert_urls : 0,
    selector: ".rich",
    menubar: false,
    toolbar: "styleselect | bold | link | bullist | numlist | code",
    plugins: [

         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",

         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",

         "save code table contextmenu directionality emoticons template paste textcolor"

   ],  
    max_word: 1000,
	setup: function (ed) {
		ed.on('keyup', function (e) {
			var writtenWords = $('.mce-wordcount').html();
			writtenWords = writtenWords.replace("Words: ", "");
			var maxWord = ed.settings.max_word;
			var limited = "";
			var content = ed.getContent();

			if (writtenWords >= maxWord) {
				$('.mce-wordcount').css("color", "red");				
				limited = $.trim(content).split(" ", maxWord);
				limited = limited.join(" ");
				ed.setContent(limited);
			} else {
				$('.mce-wordcount').css("color", "green");
			}
		});
	}

 });
 tinymce.init({
    auto_focus: "rich"
});
</script>
<script type="text/javascript">
    var markers = [];
    //    var map;
    var Ireland = "Dhaka, Bangladesh";
    function initialize() {
        
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
            center: new google.maps.LatLng(-34.397, 150.644),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: MAP_STYLE
        };
        map = new google.maps.Map(document.getElementById("form-map"),
            mapOptions);
//        codeAddress();//call the function
        var ex_latitude = $('#latitude').val();
        var ex_longitude = $('#longitude').val();

        if (ex_latitude != '' && ex_longitude != ''){
            map.setCenter(new google.maps.LatLng(ex_latitude, ex_longitude));//center the map over the result
            var marker = new google.maps.Marker(
                {
                    map: map,
                    draggable:true,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng(ex_latitude, ex_longitude)
                });

            markers.push(marker);
            google.maps.event.addListener(marker, 'dragend', function()
            {
                var marker_positions = marker.getPosition();
                $('#latitude').val(marker_positions.lat());
                $('#longitude').val(marker_positions.lng());
//                        console.log(marker.getPosition());
            });

        }

    }

    function codeAddress()
    {
        var city_field_type =  '<?php echo get_settings("business_settings", "city_dropdown", "autocomplete"); ?>' ;

        var lang = '<?php echo get_current_lang();?>';
        var main_address = $('#address_'+lang).val();
        var country = $('#country').find(':selected').data('name');
        var state = $('#state').find(':selected').data('name');

        if(city_field_type=='autocomplete') {
            var city = $('#city').val();
        }
        else
        {
            var city = $('#city_dropdown').find(':selected').data('name');;
        }
        
        <?php if($state_active == 'yes'){ ?>

        var address = [main_address, city, state, country].join();
        <?php } else { ?>

        var address = [main_address, city, country].join();
        <?php } ?>


        if(country != '' && city != '')
        {


            setAllMap(null); //Clears the existing marker

            geocoder.geocode( {address:address}, function(results, status)
            {
                if (status == google.maps.GeocoderStatus.OK)
                {
//                    console.log(results[0].geometry.location.lat());
                    $('#latitude').val(results[0].geometry.location.lat());
                    $('#longitude').val(results[0].geometry.location.lng());
                    map.setCenter(results[0].geometry.location);//center the map over the result


                    //place a marker at the location
                    var marker = new google.maps.Marker(
                        {
                            map: map,
                            draggable:true,
                            animation: google.maps.Animation.DROP,
                            position: results[0].geometry.location
                        });

                    markers.push(marker);


                    google.maps.event.addListener(marker, 'dragend', function()
                    {
                        var marker_positions = marker.getPosition();
                        $('#latitude').val(marker_positions.lat());
                        $('#longitude').val(marker_positions.lng());
//                        console.log(marker.getPosition());
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });

        }
        else{
            alert('You must enter at least country and city');
        }

    }

    function setAllMap(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>


