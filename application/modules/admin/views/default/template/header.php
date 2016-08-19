<div id="navbar" class="navbar">
	<button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
	<span class="fa fa-bars"></span>
	</button>
	<a class="navbar-brand" href="<?php echo site_url('admin');?>">
	<small>
	<img src="<?php echo base_url('assets/admin/img/logo_64.png')?>"  style="height:30px">
	<span>SPN Admin</span> </small>
	</a>

	<div class="pull-left logged-in-user-info">
	<img class="thumbnail" src="<?php echo get_profile_photo_by_id($this->session->userdata('user_id'),'thumb');?>"  style="" />
		<span style=""><b><?php echo lang_key('logged_in_as')?> :</b> <?php echo get_user_title_by_id($this->session->userdata('user_id'));?></span>
	</div>
		
	<ul class="nav memento-nav pull-right admin-top-menu">
		<li class="user-profile">
			<a data-toggle="dropdown" href="index.html#" class="user-menu dropdown-toggle">
			<i class="fa fa-user"></i>
			<span class="hhh user_info"><?php echo $this->session->userdata('user_name');?></span>
			<i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-navbar" id="user_menu">
				<li style="margin-top:10px;"></li>	
				<li>
				<a href="<?php echo site_url('admin/auth/changepass');?>">
				<i class="fa fa-cog"></i>
					<?php echo lang_key("change_password") ?> </a>
				</li>
				<li>
				<a href="<?php echo site_url('admin/editprofile');?>">
				<i class="fa fa-wrench"></i>
					<?php echo lang_key("edit_profile") ?> </a>
				</li>
				<li>			
				<li class="divider"></li>
				<li>
				<a href="<?php echo site_url('admin/auth/logout')?>">
				<i class="fa fa-sign-out"></i>
					<?php echo lang_key("logout") ?> </a>
				</li>
				<li class="divider"></li>
			</ul>
		</li>        
		<li>
			<a href="<?php echo site_url();?>">
				<i class="fa fa-laptop"></i>
				<span class="hhh user_info"><?php echo lang_key("visit_site") ?></span>
			</a>
		</li>
        <?php
		 if(!is_business()){
		 // if(get_user_type_by_id(get_user_type_by_user_id(get_id_by_username($this->session->userdata('user_name')))) != 'business'){ ?>
        <li>
			<a href="<?php echo site_url();?>profile/<?=get_id_by_username($this->session->userdata('user_name'));?>" target="_blank">
				<i class="fa fa-user"></i>
				<span class="hhh user_info">View Profile</span>
			</a>
		</li>
        <?php } ?>
	</ul>
</div>