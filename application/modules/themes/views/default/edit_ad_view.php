<link href="<?php echo theme_url();?>/assets/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo theme_url();?>/assets/jquery-ui/jquery-ui.js"></script>
<script src="<?php echo theme_url();?>/assets/jquery-ui/timepicker.js"></script>
<style>
    dl dd, dl dt {
        font-size: 13px;
        line-height: 13px;
    }
</style>
<?php $post = $post->row();?>

<div class="container">
		
        <form action="<?php echo site_url('update-ad');?>" method="post" role="form" class="form-horizontal">
        <input type="hidden" name="id" value="<?php echo $post->id;?>">
        <input type="hidden" name="page" value="<?php echo ($page)?$page:0;?>">
        	<div class="row">
            <?php echo $this->session->flashdata('msg');?>
            <div class="col-md-6 col-sm-6">
                <!-- Shopping items content -->
                <div class="shopping-content">
                    <div class="shopping-checkout">
                        <!-- Heading -->
                            <h4><?php echo lang_key('basic_info');?></h4>
                            <hr/>
                          <?php
                            // cateogories
                            foreach ($post_categories->result() as $row){
                                $category_sel[]=$row->category_id;
                            }
                           ?>

                        <div class="form-group category">
                            <label class="col-md-3 control-label" for="inputEmail1"><?php echo lang_key('category');?></label>
                            <div class="col-md-8">
                                <div class="category-scroll">
                                    <?php foreach ($categories as $row) { ?>
                                        <label style="display: block">
                                            <?php								
											$v = (set_value("category[$row->title]")!='')?set_value("category[]"):$category_sel;
											if(in_array($row->id,$v)){ $sel = 'checked="checked"';}else{$sel ='';}
                                            ?>
                                            <input  type="checkbox" <?=$sel?>  value="<?php echo $row->id;?>" name="category[]" >
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
<!--
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('tags');?></label>
                            <div class="col-md-8">
                                <div id="tag-success" class="input-append" data-cloud-name="tag-cloud1">
                                    <input type="text" class="form-control input-sm">
                                    <button class="btn btn-success btn-sm" type="button">Add<b>+</b></button>
                                </div>
                                <?php $v = (set_value('tags')!='')?set_value('tags'):explode(',',$post->tags);?>
                                <ul id="tag-cloud1"><?php if(!empty($v)){ foreach($v as $tag){ ?>
                                        <li class="tag-cloud tag-cloud-info"><input type="hidden" name="tags[]" value="<?=$tag?>"><?=$tag?></li>
                                    <?php } }?></ul>
                                <?php echo form_error('tags');?>
                            </div>
                        </div>
-->

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('phone');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('phone_no')!='')?set_value('phone_no'):$post->phone_no;?>
                                <input id="phone_no" type="text" name="phone_no" placeholder="<?php echo lang_key('phone');?>" value="<?php echo $v;?>" class="form-control">
                                <?php echo form_error('phone_no');?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('email');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('email')!='')?set_value('email'):$post->email;?>
                                <input id="email" type="text" name="email" placeholder="<?php echo lang_key('email');?>" value="<?php echo $v;?>" class="form-control">
                                <?php echo form_error('email');?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('website');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('website')!='')?set_value('website'):$post->website;?>
                                <input id="website" type="text" name="website" placeholder="<?php echo lang_key('website');?>" value="<?php echo $v;?>" class="form-control">
                                <?php echo form_error('website');?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('founded');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('founded')!='')?set_value('founded'):$post->founded;?>
                                <input id="founded" type="text" name="founded" placeholder="<?php echo lang_key('year');?>" value="<?php echo $v;?>" class="form-control">
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
                                        <?php $v = (set_value('country')!='')?set_value('country'):$post->country;?>
                                        <?php foreach (get_all_locations_by_type('country')->result() as $row) {
                                            $sel = ($row->id==$v)?'selected="selected"':'';
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
                                    <?php $selected_city = (set_value('selected_city')!='')?set_value('selected_city'):$post->city;?>
                                    <input type="hidden" name="selected_city" id="selected_city" value="<?php echo $selected_city;?>">
                                    <?php if ($city_field_type=='dropdown') {?>
                                    <select name="city" id="city_dropdown" class="form-control">                                        
                                    </select>
                                    <?php }else {?>
                                    <input type="text" id="city" name="city" value="<?php echo get_location_name_by_id($selected_city);?>" placeholder="<?php echo lang_key('city');?>" class="form-control input-sm" >
                                    <span class="help-inline city-loading">&nbsp;</span>
                                    <?php }?>
                                    <?php echo form_error('city');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('zip_code');?></label>
                                <div class="col-md-8">
                                    <?php $v = (set_value('zip_code')!='')?set_value('zip_code'):$post->zip_code;?>
                                    <input type="text" name="zip_code" placeholder="<?php echo lang_key('zip_code');?>" value="<?php echo $v;?>" class="form-control">
                                    <?php echo form_error('zip_code');?>
                                </div>
                            </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo lang_key('address');?></label>
                                    <div class="col-md-8">
                                        <?php $v = (set_value('address')!='')?set_value('address'):$post->address;?>

                                        <input type="text" name="address" placeholder="<?php echo lang_key('address');?>" value="<?php echo $v; ?>" class="form-control">
                                        <?php echo form_error('address');?>
                                    </div>
                                </div>

                                    

            
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="codeAddress()"><i class="fa fa-map-marker"></i> <?php echo lang_key('view_on_map');?></a>

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
                                    <?php $v = (set_value('latitude')!='')?set_value('latitude'):$post->latitude;?>
                                    <input id="latitude" type="text" name="latitude" placeholder="<?php echo lang_key('latitude');?>" value="<?php echo $v;?>" class="form-control">
                                    <?php echo form_error('latitude');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang_key('longitude');?></label>
                                <div class="col-md-8">
                                    <?php $v = (set_value('longitude')!='')?set_value('longitude'):$post->longitude;?>
                                    <input id="longitude" type="text" name="longitude" placeholder="<?php echo lang_key('longitude');?>" value="<?php echo $v;?>" class="form-control">
                                    <?php echo form_error('longitude');?>
                                </div>
                            </div>

                        <?php if($this->config->item('hide_opening_hours')==0){?>    
                        <h4><?php echo lang_key('opening_hour');?></h4>
                        <hr/>


                        <?php
                        $days = array(1 => 'monday', 2 => 'tuesday', 3=>'wednesday', 4=> 'thursday', 5=> 'friday', 6=> 'saturday', 7 =>'sunday');
                        $opening_hour = ($post->opening_hour!='')?(array)json_decode($post->opening_hour):array();                        

                        foreach($days as $key => $day){
                            ?>
                            <input type="hidden" name="days[]" value="<?php echo $day; ?>">

                            <div class="form-group">
                                <label class="col-xs-3 control-label"><?php echo lang_key($day);?></label>
                                <?php $post_opening     = (isset($opening_hour[$key-1]->start_time))?$opening_hour[$key-1]->start_time:'09:00 AM';?>
                                <?php $default_opening  = (isset($_POST['opening_hour'][$key-1]) && $_POST['opening_hour'][$key-1]!='')?$_POST['opening_hour'][$key-1]:$post_opening;  ?>
                                <?php $post_closing     = (isset($opening_hour[$key-1]->close_time))?$opening_hour[$key-1]->close_time:'05:00 PM';?>
                                <?php $default_closing  = (isset($_POST['closing_hour'][$key-1]) && $_POST['closing_hour'][$key-1]!='')?$_POST['closing_hour'][$key-1]:$post_closing;  ?>
                                <?php $post_closed      = (isset($opening_hour[$key-1]->closed))?$opening_hour[$key-1]->closed:'';?>
                                <?php $default_closed   = (isset($_POST['closed'][$key-1]) && $_POST['closed'][$key-1]!='')?$_POST['closed'][$key-1]:$post_closed;  ?>

                                <div class="col-xs-3">
                                    <input type="text" id="start-time-<?php echo $key; ?>"  name="opening_hour[]" value="<?php echo $default_opening; ?>"  class="form-control input-sm time-input" >

                                </div>
                                <div class="col-xs-3">
                                    <input type="text" id="end-time-<?php echo $key; ?>"  name="closing_hour[]" value="<?php echo $default_closing; ?>"  class="form-control input-sm time-input" >

                                </div>
                                <div class="col-xs-3">
                                    <label>
                                        <?php $chk = ($default_closed==1)?'checked="checked"':'';?>
                                        <input <?php echo $chk;?> data-day="<?php echo $key; ?>" type="checkbox" class="close-days" value="<?php echo $key;?>" name="closed_days[]">
                                        <?php echo lang_key('closed'); ?>
                                    </label>
                                </div>
                            </div>

                        <?php
                        }
                    }
                        ?>
                        
                        <h4><?php echo lang_key('social_links'); ?></h4><hr/>
                        <div class="form-group">
		                    <label class="col-md-3 control-label"><?php  echo lang_key('bbb');?></label>
		                    <div class="col-md-8">
		                        <input type="text" name="bbb_profile" value="<?php echo get_post_meta($post->id,'bbb_profile','');?>" class="form-control">
		                    </div>
		                </div> 
                        <div class="form-group">
		                    <label class="col-md-3 control-label"><?php  echo lang_key('yelp');?></label>
		                    <div class="col-md-8">
		                        <input type="text" name="yelp_profile" value="<?php echo get_post_meta($post->id,'yelp_profile','');?>" class="form-control">
		                    </div>
		                </div> 
                        
		                <div class="form-group">
		                    <label class="col-md-3 control-label"><?php echo lang_key('facebook');?></label>
		                    <div class="col-md-8">
		                        <input type="text" name="facebook_profile" value="<?php echo get_post_meta($post->id,'facebook_profile','');?>" class="form-control">
		                    </div>
		                </div>            
		                <div class="form-group">
		                    <label class="col-md-3 control-label"><?php echo lang_key('twitter');?></label>
		                    <div class="col-md-8">
		                        <input type="text" name="twitter_profile" value="<?php echo get_post_meta($post->id,'twitter_profile','');?>" class="form-control">
		                    </div>
		                </div>
                        
		                <div class="form-group">
		                    <label class="col-md-3 control-label"><?php echo lang_key('Angles List');?></label>
		                    <div class="col-md-8">
		                        <input type="text" name="angle_list_profile" value="<?php echo get_post_meta($post->id,'angle_list_profile','');?>" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-3 control-label"><?php  echo lang_key('linkedin');?></label>
		                    <div class="col-md-8">
		                        <input type="text" name="linkedin_profile" value="<?php echo get_post_meta($post->id,'linkedin_profile','');?>" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-3 control-label"><?php echo lang_key('googleplus');?></label>
		                    <div class="col-md-8">
		                        <input type="text" name="googleplus_profile" value="<?php echo get_post_meta($post->id,'googleplus_profile','');?>" class="form-control">
		                    </div>
		                </div>
                        
                        <div class="form-group">
		                    <label class="col-md-3 control-label"><?php echo lang_key('ebay');?></label>
		                    <div class="col-md-8">
		                        <input type="text" name="ebay_profile" value="<?php echo get_post_meta($post->id,'ebay_profile','');?>" class="form-control">
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
                        <?php $v = (set_value('title')!='')?set_value('title'):$post->title;?>
                        <input type="text" name="title" placeholder="Business Name" value="<?php echo $v;?>" class="form-control">
                        <?php echo form_error('title');?>
                    </div>
                </div>

                <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang_key('description');?></label>
                            <div class="col-md-8">
                                <?php $v = (set_value('description')!='')?set_value('description'):$post->description;?>
                                <textarea rows="15" name="description" class="form-control rich"><?php echo $v;?></textarea>
                                <?php echo form_error('description');?>
                            </div>
                        </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Area Served'; //echo lang_key('tags');?></label>
                    <div class="col-md-8">
                        <div id="tag-info" class="input-append" data-cloud-name="tag-cloud2">
                            <input type="text" class="form-control area-input pull-left">
                            <button class="btn btn-warning" type="button">Add+</button>
                        </div>
                        <div class="clear-fix"></div>
                        <?php $v = (set_value('area_served')!='')?set_value('area_served'):explode(',',$post->area_served);?>
                        <ul id="tag-cloud2" class="tag-clouds"><?php if(!empty($v)){ foreach($v as $area){ ?><li class="tag-cloud tag-cloud-info"><input type="hidden" name="area_served[]" value="<?=$area?>"><?=$area?></li><?php } }?></ul>
                        <?php echo form_error('area_served');?>
                    </div>
                 </div>
                 <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo lang_key('Coupon Code');?></label>
                    <div class="col-md-8">
                        <?php $v = (set_value('coupon_code')!='')?set_value('coupon_code'):$post->coupon_code;?>
                        <input type="text" name="coupon_code" placeholder="<?php echo lang_key('Coupon Code');?>" value="<?php echo $v;?>" class="form-control">
                        <?php echo form_error('coupon_code');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo lang_key('Set Off On Total Purchase');?></label>
                    <div class="col-md-8">
                        <?php $v = (set_value('get_off')!='')?set_value('get_off'):$post->get_off;?>                       
                        <div class="input-group">                  
                  		<input type="text" class="form-control"  name="get_off" placeholder="Set Off On Purchase" value="<?php echo $v;?>" >
     			 		<div class="input-group-addon">%</div>
    </div>
                        <?php echo form_error('get_off');?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo lang_key('additional_features');?></label>
                    <div class="col-md-8">
                        <div class="input_fields_wrap">
                            <?php 
                            $additional_features = ($post->additional_features!='')?(array)json_decode($post->additional_features):array();
                            foreach ($additional_features as $key=>$feature) 
                            {
                                $post_feature_value = (isset($additional_features[$key]))?$additional_features[$key]:'';
                                $feature_value = (isset($_POST['additional_features'][$key]) && $_POST['additional_features'][$key]!='')?$_POST['additional_features'][$key]:$post_feature_value;
                            ?>
                            <div id="feature-input-holder">
                                <input style="margin-bottom: 5px" placeholder="<?php echo lang_key('additional_features');?>" type="text" class="form-control" name="additional_features[]" value="<?php echo $feature_value;?>">
                                <a href="#" class="remove_field">X</a>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <button class="add_field_button btn btn-orange"><?php echo lang_key('add_more_fields');?></button>

                        <?php // echo form_error('tags');?>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo lang_key('featured_image');?></label>
                    <div class="col-md-8">
                        <div class="featured-img">
                            <?php $v = (set_value('featured_img')!='')?set_value('featured_img'):$post->featured_img;?>
                            <input type="hidden" name="featured_img" id="featured-img-input" value="<?php echo $v;?>">
                            <img id="featured-img" src="<?php echo base_url('uploads/images/no-image.png');?>">
                            <div class="upload-button"><?php echo lang_key('upload');?></div>
                            <?php echo form_error('featured_img');?>
                            <br /> <small class="small-size">Min(175*175)</small>
                        </div>
                    </div>
                </div>               

				<?php /* ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo lang_key('video_url');?></label>
                    <div class="col-md-8">
                        <?php $v = (set_value('video_url')!='')?set_value('video_url'):$post->video_url;?>
                        <span id="video_preview"></span>
                        <input id="video_url" type="text" name="video_url" placeholder="<?php echo lang_key('video_url');?>" value="<?php echo $v;?>" class="form-control">
                        <span class="help-inline"><?php echo lang_key('video_notes');?></span>
                        <?php echo form_error('video_url');?>
                    </div>
                </div>
              <?php */ ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo lang_key('gallery');?></label>
                    <div class="col-md-8">
                        <?php //$tmp_gallery = ($post->gallery!='')?json_decode($post->gallery):array();?>
                        <?php //$gallery = (isset($_POST['gallery']))?$_POST['gallery']:$tmp_gallery;?>
						   <ul class="multiple-uploads">
						    <?php if(isset($_POST['gallery'])){ 
								$gallery = $_POST['gallery']; ?>							
								<?php foreach ($gallery as $item) { ?>
								<li class="gallery-img-list">
								  <input type="hidden" name="gallery[]" value="<?php echo $item;?>" />
								  <img src="<?php echo base_url('uploads/gallery/'.$item);?>" />
								  <div class="remove-image" onclick="jQuery(this).parent().remove();">X</div>
								</li>
								<?php }?>
						<?php }else{ ?>
							<?php $tem_gallery = (get_post_data($post->id,'gallery_img')); ?>
							 <?php if(count($tem_gallery)>0){ ?>							   
								<?php foreach ($tem_gallery->result() as $item) {  ?>
								<li class="gallery-img-list">
								  <input type="hidden" name="gallery[]" value="<?php echo $item->value;?>" />
								  <img src="<?php echo base_url('uploads/gallery/'.$item->value);?>" />
								  <div class="remove-image" onclick="jQuery(this).parent().remove();">X</div>
								</li>
								<?php }?>
								
							 <?php } ?>
						<?php } ?>		
							<li class="add-image" id="dragandrophandler">+</li>
							</ul>						
                        <div class="clearfix"></div>
                        <span class="gallery-upload-instruction"><?php echo lang_key('gallery_notes');?></span>
                        <div class="clearfix clear-top-margin"></div>
                    </div>
                </div>

                <?php if(is_admin()){?>
                <hr/>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="inputEmail1"><?php echo lang_key('assigned_to');?></label>
                    <div class="col-md-8">
                        <select name="assigned_to" class="form-control">
                            <option value=""><?php echo lang_key('select_assigned_to');?></option>
                            <?php foreach (get_all_users() as $user) {
                                $v = (set_value('assigned_to')!='')?set_value('assigned_to'):$post->created_by;
                                $sel = ($v==$user->id)?'selected="selected"':'';
                            ?>
                                <option value="<?php echo $user->id;?>" <?php echo $sel;?>><?php echo get_user_fullname_from_user($user);?></option>
                            <?php
                            }?>
                        </select>
                        <?php echo form_error('assigned_to');?>
                    </div>
                </div>
                <?php }?>                          
                
                
            </div>
        </div>
            <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="form-group align-centre">
                    <button class="btn btn-color" type="submit"><?php echo lang_key('save');?></button>
                </div>
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
<?php require'multiple-uploader.php';?>
<?php require'bulk_uploader_view.php';?>
<script type="text/javascript">

$(document).on('keyup keypress', 'form input[type="text"]', function(e) {
  if(e.which == 13) {
    e.preventDefault();
    return false;
  }
});
	
jQuery(document).ready(function(){	
    
    jQuery('#photoimg').attr('target','.multiple-uploads');
    jQuery('#photoimg').attr('input','gallery');
    var obj = $("#dragandrophandler");
    obj.on('dragenter', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', '2px solid #0B85A1');
    });

    obj.on('dragover', function (e)
    {
         e.stopPropagation();
         e.preventDefault();
    });

    obj.on('drop', function (e)
    {
     
         $(this).css('border', '2px dotted #0B85A1');
         e.preventDefault();
         var files = e.originalEvent.dataTransfer.files;
         //console.log(files);
         //We need to send dropped files to Server
         handleFileUpload(files,obj);
    });

    $(document).on('dragenter', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
    });

    $(document).on('dragover', function (e)
    {
      e.stopPropagation();
      e.preventDefault();
      obj.css('border', '2px dotted #0B85A1');
    });
    
    $(document).on('drop', function (e)
    {
        e.stopPropagation();
        e.preventDefault();
    });

    jQuery('.multiple-uploads > .add-image').click(function(){
        jQuery('#photoimg').attr('target','.multiple-uploads');
        jQuery('#photoimg').attr('input','gallery');
        jQuery('#photoimg').click();
    });

    jQuery( ".multiple-uploads" ).sortable();
});
</script>

<script type="text/javascript">
jQuery(document).ready(function(){

    for(var i=1; i<=7; i++)
    {
        var startTimeTextBox = $('#start-time-' + i);
        var endTimeTextBox = $('#end-time-' + i);
        $(startTimeTextBox).timepicker({timeFormat: 'hh:mm TT'});
        $(endTimeTextBox).timepicker({timeFormat: 'hh:mm TT'});
    }

    jQuery('.time-input').each(function(){
        var val = jQuery(this).attr('value');
        jQuery(this).val(val);
    });

    jQuery('.close-days').click(function(){
        var val = jQuery(this).attr('checked');
        if(val=='checked')
        {
            jQuery(this).parent().parent().parent().find('input[type=text]').val('<?php echo lang_key("closed"); ?>');
            jQuery(this).parent().parent().parent().find('input[type=text]').attr('readonly','readonly');
        }
        else
        {
            jQuery(this).parent().parent().parent().find('input[type=text]').val('09:00 AM');
            jQuery(this).parent().parent().parent().find('input[type=text]').removeAttr("readonly");
        }
    });

    jQuery('.close-days').each(function(){
        var val = jQuery(this).attr('checked');
        if(val=='checked')
        {
            jQuery(this).parent().parent().parent().find('input[type=text]').val('<?php echo lang_key("closed"); ?>');
            jQuery(this).parent().parent().parent().find('input[type=text]').attr('readonly','readonly');
        }
        else
        {
            //jQuery(this).parent().parent().parent().find('input[type=text]').val('09:00 AM');
            jQuery(this).parent().parent().parent().find('input[type=text]').removeAttr("readonly");
        }
    });


    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $('.input_fields_wrap').append('<div><input placeholder="<?php echo lang_key('additional_features');?>" type="text" class="form-control" name="additional_features[]" style="margin-bottom:5px;"><a href="#" class="remove_field">X</a></div>'); //add input box
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>

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
            var code = '<iframe class="thumbnail" width="100%" height="200" src="'+src+'" frameborder="0" allowfullscreen></iframe>';
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
            var code = '<iframe class="thumbnail" src="//player.vimeo.com/video/'+video_id+'" width="100%" height="200" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            jQuery('#video_preview').html(code);
        }
        else
        {
            //alert("only youtube and video url is valid");
        }
    }

    jQuery(document).ready(function(){

    var city_field_type =  '<?php echo get_settings("business_settings", "city_dropdown", "autocomplete"); ?>' ;

    jQuery('#video_url').change(function(){
        var url = jQuery(this).val();
        showVideoPreview(url);
    }).change();

    jQuery('#contact_for_price').click(function(){
        show_hide_price();
    });
    show_hide_price();

    jQuery('.upload-button').click(function(){
        jQuery('#photoimg_featured').click();
    });

    jQuery('.logo-upload-button').click(function(){
        jQuery('#photoimg_logo').click();
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

    jQuery('#business-logo-input').change(function(){
        var val = jQuery(this).val();
        if(val=='')
        {
            val = 'no-image.png';
        }

        var base_url  = '<?php echo base_url();?>';
        var image_url = base_url+'uploads/logos/'+val;
        jQuery( '#business-logo' ).attr('src',image_url);

    }).change();

    var site_url = '<?php echo site_url();?>';
    var val = jQuery('#country').val();
    var loadUrl = site_url+'/show/get_locations_by_parent_ajax/'+val;
    jQuery.post(
        loadUrl,
        {},
        function(responseText){
            jQuery('#state').html(responseText);
            var sel_country = '<?php echo (set_value("country")!='')?set_value("country"):$post->country;?>';
            var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):$post->state;?>';
            if(val==sel_country)
                jQuery('#state').val(sel_state);
            else
                jQuery('#state').val('');
            jQuery('#state').focus();
            jQuery('#state').trigger('change');
        }
    );
    jQuery('#country').change(function(){
        jQuery('#city').val('');
        var val = jQuery(this).val();
        var loadUrl = site_url+'/show/get_locations_by_parent_ajax/'+val;
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                <?php if($state_active=='yes'){?>
                jQuery('#state').html(responseText);
                var sel_country = '<?php echo (set_value("country")!='')?set_value("country"):$post->country;?>';
                var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):$post->state;?>';
                if(val==sel_country)
                jQuery('#state').val(sel_state);
                else
                jQuery('#state').val('');
                jQuery('#state').focus();
                jQuery('#state').trigger('change');
                <?php }else{?>
                var sel_country = '<?php echo (set_value("country")!='')?set_value("country"):$post->country;?>';
                var sel_city   = '<?php echo (set_value("selected_city")!='')?set_value("selected_city"):$post->city;?>';
                var city   = '<?php echo (set_value("city")!='')?set_value("city"):get_location_name_by_id($post->city);?>';
                if(city_field_type=='dropdown')
                populate_city(val);
                if(val==sel_country)
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
            }
        );
     });

    jQuery('#state').change(function(){
        <?php if($state_active=='yes'){?>
        var val = jQuery(this).val();
        var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):$post->state;?>';
        var sel_city   = '<?php echo (set_value("selected_city")!='')?set_value("selected_city"):$post->city;?>';
        var city   = '<?php echo (set_value("city")!='')?set_value("city"):get_location_name_by_id($post->city);?>';
        
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
        if(city_field_type=='dropdown'){
            
            var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):$post->state;?>';
            populate_city(sel_state);
        }
    var parent = '#state';
    <?php } else { ?>
        if(city_field_type=='dropdown'){
            
            var sel_country = jQuery('#country').val();
            populate_city(sel_country);
        }
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
    //alert(parent);
    var site_url = '<?php echo site_url();?>';
    var loadUrl = site_url+'/show/get_city_dropdown_by_parent_ajax/'+parent;
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('#city_dropdown').html(responseText);
                var sel_city   = '<?php echo get_location_name_by_id($selected_city);?>';
                //alert(sel_city);
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

   ]

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
        var lang = '<?php echo get_current_lang();?>';
        var main_address = $('input[name=address_'+lang+']').val();
        var country = $('#country').find(':selected').data('name');
        var state = $('#state').find(':selected').data('name');
        var city_field_type =  '<?php echo get_settings("business_settings", "city_dropdown", "autocomplete"); ?>' ;
        if(city_field_type=='dropdown')
        var city = $('#city_dropdown').find(':selected').data('name');
        else
        var city = $('#city').val();

        <?php if($state_active == 'yes'){ ?>

        var address = [main_address, city, state, country].join();
        <?php } else { ?>

        var address = [main_address, city, country].join();
        <?php } ?>
//        console.log(address);
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

