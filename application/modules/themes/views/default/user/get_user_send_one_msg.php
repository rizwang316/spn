<?php if ($conversation->num_rows() > 0) { ?>
    	      		 
					 <?php  foreach ($conversation->result() as $row){ ?>
                       <?php //echo '<pre>'; print_r($row); ?>
                       <li class="<?php if($row->user_id_fk == $this->session->userdata('user_id')){ ?> right <?php }else{ ?> left <?php } ?> clearfix">
                    	<span class="chat-img <?php if($row->user_id_fk == $this->session->userdata('user_id')){ ?> pull-right <?php }else{ ?> pull-left <?php } ?>">                    		
                            <img src="<?php echo get_profile_photo_by_id($row->user_id_fk,'thumb');?>" alt="User Avatar">
                    	</span>
                    	<div class="chat-body clearfix">
                    		<div class="header">
                    			<strong class="primary-font"><?php echo $row->last_name ?></strong>
                    			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i>
                                 <?php  echo time_elapsed_string(date('Y-m-d H:i:s', $row->date)); ?> 
                                 </small>
                    		</div>
                    		<p>
                    			<?php echo $row->reply; ?>
                    		</p>
                    	</div>
                    </li>
                     	
                     <?php } ?>
                   <?php }else{ ?>
                   		<p>no message.</p>
                   	<?php } ?>