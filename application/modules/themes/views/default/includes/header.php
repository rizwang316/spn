<header>
         <div class="container">
           <nav class="navbar menucls">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
             
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false">
                                                           
              <ul class="nav navbar-nav">
                <li><a href="<?=site_url()?>">Home</a></li>
                
                <li><a href="<?=site_url(); ?>account/list-business" class="<?php if($this->uri->segment('2')=='list-business'){ echo 'active';} ?>"> List Business</a></li>
                
                <li><a href="<?=site_url(); ?>about-me"  class="<?php if($this->uri->segment('1')=='about-me'){ echo 'active';} ?>"> About Me</a></li>
                
               <?php /*?> <?php if(is_loggedin() && is_personal()){ ?>                
                <li><a href="<?=site_url(); ?>add-contact"  class="<?php if($this->uri->segment('1')=='add-contact'){ echo 'active';} ?>">Add Contacts</a></li>  
                <?php } ?>  <?php */?>
                           
                 <li><a href="#">Partner</a></li>
                <li><a href="<?php  echo site_url(); ?>blog" class="<?php if($this->uri->segment('1')=='blog'){ echo 'active';} ?>">Blog</a></li>
                <li><a href="<?=site_url(); ?>contact" class="<?php if($this->uri->segment('1')=='contact'){ echo 'active';} ?>">Contact SPN</a></li>
                <?php /*?><li><a href="<?php echo site_url('account/login');?>">Login</a></li>
                <li class="signup"><a href="<?php echo site_url('account/signupform');?>">Signup</a></li><?php */?>
                
                 <?php if(!is_loggedin()){ ?>
                       <li class="">
                            <a  href="<?php echo site_url('account/login');?>"><?php echo lang_key('signin');?></a>
                        </li>
                        <?php if(get_settings('business_settings','enable_signup','Yes')=='Yes'){?>
                        <li class="signup">
                            <a  href="<?php echo site_url('account/signupform');?>"><?php echo lang_key('signup')?></a>
                        </li>
                        <?php }?>                        
                        <?php }else{ ?>
                      <?php if(is_loggedin() && is_personal()){ ?>   
                                   
                			<li><a href="<?php  echo site_url('profile/'.$this->session->userdata('user_id').'/'.get_user_fullname_by_id($this->session->userdata('user_id')));?>"  class="<?php if($this->uri->segment('1')=='profile'){ echo 'active';} ?>">My Profile</a></li>  
                <?php } ?> 
                        <li class="">
                            <a  href="<?php echo site_url('admin');?>">My Dashboard</a>
                        </li>
                        <li class="signup">
                            <a  href="<?php echo site_url('account/logout');?>"><?php echo lang_key('logout');?></a>
                        </li>
                        <?php }?>
              </ul>
            </div>
          
        </nav>
         </div>
       </header>
        <div class="container">
      	 <div id="<?=$this->session->userdata('user_id')?>"></div>
       </div>