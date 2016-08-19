
<div class="container">
    <div class="row">
    <?php echo $this->session->flashdata('msg');?>
       
        <div class="col-md-6 col-md-offset-3">
            <!-- Login starts -->
            <div class="login-reg-form">
                <!-- Heading -->
                <h3 class="heading"><?php echo lang_key('login_to_your_account'); ?></h3>
                <hr />
                <!-- Form -->
                <form action="<?php echo site_url('account/login');?>" class="form-horizontal" role="form" method="post">
                    <!-- Form Group -->
                    <div class="form-group">
                        <!-- Label -->
                        <label for="user" class="col-sm-3 control-label"><?php echo lang_key('email'); ?></label>
                        <div class="col-sm-9">
                            <!-- Input -->
                            <input type="text" class="form-control" name="useremail" placeholder="<?php echo lang_key('email'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label"><?php echo lang_key('password'); ?></label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control"  name="password" placeholder="<?php echo lang_key('password'); ?>">
                        </div>
                    </div>
                    <?php if(constant("ENVIRONMENT")=='demo'){?>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        demo user : user@spn.com pass: 12345
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="">
                                <label>
                                    <input type="checkbox"> <?php echo lang_key('remember_me'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <!-- Button -->
                            <button type="submit" class="btn btn-green"><?php echo lang_key('login'); ?></button>&nbsp;                            
                        </div>
                    </div>
                    <div class="col-sm-offset-3 col-sm-9">
                        <a href="<?php echo site_url('account/recoverpassword');?>" class="black"><?php echo lang_key('forgot_password'); ?> ?</a> 
                        <?php if(get_settings('business_settings','enable_signup','Yes')=='Yes'){?>
                        | <a href="<?php echo site_url('account/signup');?>" class="black"><?php echo lang_key('sign_up'); ?></a>
                        <?php }?>
                    </div>
                </form>
                <br />
                <hr />
                <?php
                $fb_enabled = get_settings('business_settings','enable_fb_login','No');
                $gplus_enabled = get_settings('business_settings','enable_gplus_login','No');
                if($fb_enabled=='Yes' || $gplus_enabled=='Yes'){
                    ?>
                    <!-- Social Media Login -->
                    <div class="s-media text-center">
                        <!-- Button -->
                        <?php if($gplus_enabled=='Yes'){?>
                            <a href="<?php echo site_url('account/newaccount/google_plus');?>" class="btn btn-red"><i class="fa fa-google-plus"></i> &nbsp; <?php echo lang_key('login_with_google');?></a>
                        <?php }?>
                        <?php if($fb_enabled=='Yes'){?>
                            <a href="<?php echo site_url('account/newaccount/fb');?>" class="btn btn-blue"><i class="fa fa-facebook"></i> &nbsp; <?php echo lang_key('login_with_facebook');?></a>
                        <?php }?>
                    </div>
                <?php } ?>
            </div>
            <!-- Login ends -->
        </div>
    </div>
</div>
