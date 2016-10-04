<div id="sidebar" class="navbar-collapse collapse">

    <div id="sidebar-collapse" class="">
        <i class="fa fa-angle-double-left"></i>
    </div>

    <ul class="nav nav-list">
        <?php if (is_admin()) { ?>
            <!--<li class="active"> HIGHLIGHTS MENU-->
            <li class="<?php echo is_active_menu('admin/index'); ?>">
                <a href="<?php echo site_url('admin/index'); ?>">
                    <i class="fa fa-dashboard"></i>
                    <span><?php echo lang_key("dashboard"); ?></span>
                </a>
            </li>           
        <?php } ?>
       
        
        <li class="<?php echo active_link('admin') ; ?>">
        		<a href="#" class="dropdown-toggle">
                <i class="fa fa-user"></i>
                <span><?php echo lang_key('profile'); ?></span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
             <ul class="submenu">
                <li class="<?php if($this->uri->segment(2)=="editprofile"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/editprofile'); ?>">
                        <?php echo lang_key('profile'); ?>
                    </a>
                </li>
                 <?php  if(get_user_type_by_id(get_user_type_by_user_id(get_id_by_username($this->session->userdata('user_name')))) != 'business'){ ?>
                 <li class="<?php if($this->uri->segment(2)=="editbucket"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/editbucket'); ?>">
                        Bucket/Causes List
                    </a>
                </li>
                <li class="<?php if($this->uri->segment(2)=="allfavorite"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/allfavorite'); ?>">
                        <?php echo lang_key('Favorite'); ?>
                    </a>
                </li>
                 <li class="<?php if($this->uri->segment(2)=="view_all_blogs"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/view_all_blogs'); ?>">
                        <?php echo lang_key('Blog List'); ?>
                    </a>
                </li>
                 <li class="<?php if($this->uri->segment(2)=="view_all_video"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/view_all_video'); ?>">
                        <?php echo lang_key('Video List'); ?>
                    </a>
                </li>
                <li class="<?php if($this->uri->segment(2)=="editimages"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/editimages'); ?>">
                        <?php echo lang_key('Image List'); ?>
                    </a>
                </li>
                
                <li class="<?php if($this->uri->segment(2)=="alleducation"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/alleducation'); ?>">
                        <?php echo lang_key('Education'); ?>
                    </a>
                </li>
                <li class="<?php if($this->uri->segment(2)=="allexperience"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/allexperience'); ?>">
                        <?php echo lang_key('Experience'); ?>
                    </a>
                </li>
                <?php } ?>
                
            </ul>
            
        </li>

        <li class="<?php echo active_link('business'); ?>">
            <a href="#" class="dropdown-toggle">
                <i class="fa fa-plus-circle"></i>
                <span><?php echo lang_key("product_name"); ?></span>
                <b class="arrow fa fa-angle-right"></b>
            </a>
            
            <ul class="submenu">

                <li class="<?php if($this->uri->segment(3)=="allposts" || $this->uri->segment(3)=='manage_video'|| $this->uri->segment(3)=='view_all_blogs'|| $this->uri->segment(3)=='blog_manage' || $this->uri->segment(3)=='view_all_video' || $this->uri->segment(3)=='view_all_reviews'){echo "active";}?>">
                    <a href="<?php echo site_url('admin/business/allposts'); ?>">
                        <?php echo lang_key('all_posts'); ?>
                    </a>
                </li>                

                <li class="">
                    <a href="<?php echo site_url('list-business'); ?>">
                        <?php echo lang_key('new_business'); ?>
                    </a>
                </li>


                <?php if (is_admin()) { ?>
                <li class="<?php if($this->uri->segment(3)=="reportedpost"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/business/reportedpost'); ?>">
                        <?php echo lang_key('reported_post'); ?>
                    </a>
                </li>
                <li class="<?php if($this->uri->segment(3)=="claimedposts"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/business/claimedposts'); ?>">
                        <?php echo lang_key('claimed_business'); ?>
                    </a>
                </li>

                <?php }?>


                <li class="<?php if($this->uri->segment(3)=="emailtracker"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/business/emailtracker'); ?>">
                        <?php echo lang_key('email_tracker'); ?>
                    </a>
                </li>

                <li class="<?php if($this->uri->segment(3)=="bulkemailform"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/business/bulkemailform'); ?>">
                        <?php echo lang_key('bulk_email'); ?>
                    </a>
                </li>


                <?php if (is_admin()) { ?>

                <li class="<?php if($this->uri->segment(3)=="locations"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/business/locations'); ?>">
                        <?php echo lang_key('locations'); ?>
                    </a>
                </li>

                <li class="<?php if($this->uri->segment(3)=="businesssettings"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/business/businesssettings'); ?>">
                        <?php echo lang_key('site_settings'); ?>
                    </a>
                </li>               

                

                <?php } ?>

            </ul>
        </li>

        <?php if (is_admin()) { ?>

        <li class="<?php echo active_link('category'); ?>">
            <a href="#" class="dropdown-toggle">
                <i class="fa fa-bars"></i>
                <span><?php echo lang_key('category'); ?></span>
                <b class="arrow fa fa-angle-right"></b>
            </a>

            <ul class="submenu">
                <li class="<?php if($this->uri->segment(3)=="all" || $this->uri->segment(3) =='edit' || $this->uri->segment(3) =='delete'){echo "active";}?>">
                    <a href="<?php echo site_url('admin/category/all'); ?>">
                        <?php echo lang_key('all_categories'); ?>
                    </a>
                </li>
                <li class="<?php if($this->uri->segment(3)=="newcategory"){echo "active";}?>">
                    <a href="<?php echo site_url('admin/category/newcategory'); ?>">
                        <?php echo lang_key('new_category'); ?>
                    </a>
                </li>
            </ul>
        </li>

        <?php } ?>
        

        <?php if (is_admin()) { ?>



            
            <li class="<?php echo active_link('users'); ?> ">


                <a href="<?php echo site_url('admin/users'); ?>">


                    <i class="fa fa-users"></i>


                    <span><?php echo lang_key('users'); ?></span>


                </a>


            </li>
            

            <li class="<?php echo active_link('category_blog').' '.active_link('blog'); ?>">


                <a href="#" class="dropdown-toggle">


                    <i class="fa fa-file-o"></i>


                    <span>Blog</span>


                    <b class="arrow fa fa-angle-right"></b>


                </a>


                <ul class="submenu">
                	
                    <li class="<?php if($this->uri->segment(2)=="category_blog" || $this->uri->segment(2)=="newcategory"){echo "active";}?>">
                        <a href="<?php echo site_url('admin/category_blog/all'); ?>">
                            <?php echo lang_key('all_categories'); ?>
                        </a>
                    </li>                 
           

                    <li class="<?php if($this->uri->segment(3)=="all"){echo "active";}?>">
                    	<a href="<?php echo site_url('admin/blog/all'); ?>">All Posts</a>
                    </li>


                    <li class="<?php if($this->uri->segment(3) == "manage"){echo "active";}?>">
                    	<a href="<?php echo site_url('admin/blog/manage'); ?>">New Post</a>
                    </li>


                </ul>


            </li>
           <?php /* ?>
            <li class="<?php echo active_link('page'); ?>">


                <a href="#" class="dropdown-toggle">


                    <i class="fa fa-file-o"></i>


                    <span><?php echo lang_key('pages_and_menu'); ?></span>


                    <b class="arrow fa fa-angle-right"></b>


                </a>


                <ul class="submenu">


                    <!--<li class="active"> HIGHLIGHTS SUBMENU-->


                    <li class="<?php if($this->uri->segment(3)=="all"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/page/all'); ?>"><?php echo lang_key('all_pages'); ?></a></li>


                    <li class="<?php if($this->uri->segment(3)=="index"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/page/index'); ?>"><?php echo lang_key('new_page'); ?></a></li>


                    <li class="<?php if($this->uri->segment(3)=="menu"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/page/menu'); ?>"><?php echo lang_key('menu'); ?></a></li>


                </ul>


            </li>

            <li class="<?php echo active_link('system'); ?>">


                <a href="#" class="dropdown-toggle">


                    <i class="fa fa-cog"></i>


                    <span><?php echo lang_key('system'); ?></span>


                    <b class="arrow fa fa-angle-right"></b>


                </a>


                <ul class="submenu">


                    <!--<li class="active"> HIGHLIGHTS SUBMENU-->


                    <li class="<?php if($this->uri->segment(3)=="allbackups"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/system/allbackups'); ?>"><?php echo lang_key('manage_backups'); ?></a></li>

                    <li class="<?php if($this->uri->segment(3)=="smtpemailsettings"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/system/smtpemailsettings'); ?>"><?php echo lang_key('smtp_email_settings'); ?></a>
                    </li>

                    <li class="<?php if($this->uri->segment(3)=="emailtmpl"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/system/emailtmpl'); ?>"><?php echo lang_key('edit_email_text'); ?></a></li>

                    <li class="<?php if($this->uri->segment(3)=="debugemail"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/system/debugemail'); ?>"><?php echo lang_key('debug_email'); ?></a></li>


                    <li class="<?php if($this->uri->segment(3)=="sitesettings"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/system/sitesettings'); ?>"><?php echo lang_key('default_site_settings'); ?></a></li>


                    <li class="<?php if($this->uri->segment(3)=="settings"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/system/settings'); ?>"><?php echo lang_key('admin_settings'); ?></a></li>


                    <li class="<?php if($this->uri->segment(3)=="generatesitemap"){echo "active";}?>"><a
                            href="<?php echo site_url('admin/system/generatesitemap'); ?>"><?php echo lang_key('sitemap'); ?></a></li>


                </ul>


            </li>
   <?php */ ?>

        <?php } ?>


    </ul>





</div>