  <?php $frnd_list_msgs = get_friend_list_msg($this->session->userdata('user_id')); ?>  
<?php foreach ($frnd_list_msgs->result() as $row){	?>
<li class="f_request open_chat_box" userID="<?=$row->id?>"> 
<table>
	<tr>
	<td class="userimgcls">
	<span>
		<img src="<?php echo get_profile_photo_by_id($row->id,'thumb');?>" alt="" >    
	</span></td> 
	<td>                                                        
		<div class="last-message text-muted"><?=$row->reply?></div>
		<small class="time text-muted">
		<?php  echo time_elapsed_string(date('Y-m-d H:i:s',$row->date)); ?>
		</small>
		 <small class="chat-alert label on-dot"><i class="fa fa-circle"></i></small>
	</td>
	<td class="rcell2"><span><?=$row->last_name?></span></td>                                       		       </tr>                                                    
</table>
</li>
 <?php
 
		/*$this->load->model('user/user_model');
		$user_one = $this->session->userdata('user_id');
		$user_two = $row->id;	
		if($user_one!=$user_two)
		{
			$c_id = $this->user_model->creating_conversation($user_one,$user_two);																			
			$conversation = $this->user_model->conversation_reply_latest_one($c_id);
			if ($conversation->num_rows() > 0) { ?>    
							 
			 <?php  foreach ($conversation->result() as $row_c){  ?>
			 
					 <?php if($row_c->user_id_fk == $this->session->userdata('user_id')){
						
					$sent_user_id = $this->user_model->get_sent_user_id($row_c->c_id_fk,$this->session->userdata('user_id'));
					// 	message sender.
					$sender_data = $this->user_model->create_conversation_sent($row_c->cr_id,$sent_user_id);
							//echo $row_c->c_id_fk;
					?>
					<?php  foreach ($sender_data->result() as $s_data){  ?>
						 <?php //print_r($s_data); ?>
						<li class="f_request open_chat_box" userID="<?=$s_data->id?>"> 
					   <table>
							<tr>
							<td class="userimgcls">
							<span>
								<img src="<?php echo get_profile_photo_by_id($s_data->id,'thumb');?>" alt="" >    
							</span></td> 
							<td>                                                        
								<div class="last-message text-muted"><?=$row_c->reply?></div>
								<small class="time text-muted">
								<?php  echo time_elapsed_string(date('Y-m-d H:i:s',$row_c->date)); ?>
								</small>
								 <small class="chat-alert label on-dot"><i class="fa fa-circle"></i></small>
							</td>
							<td class="rcell2"><span><?=$s_data->last_name?></span></td>                                       		       </tr>                                                    
						</table>
				   </li>
					<?php } ?>
					<?php													
							
					 }else{  // message receiver. ?>
					<li class="f_request open_chat_box" userID="<?=$row_c->id?>"> 
					   <table>
							<tr>
							<td class="userimgcls">
							<span>
								<img src="<?php echo get_profile_photo_by_id($row_c->id,'thumb');?>" alt="" >    
							</span></td> 
							<td>                                                        
								<div class="last-message text-muted"><?=$row_c->reply?></div>
								<small class="time text-muted">
								<?php  echo time_elapsed_string(date('Y-m-d H:i:s',$row_c->date)); ?>
								</small>
								 <small class="chat-alert label on-dot"><i class="fa fa-circle"></i></small>
							</td>
							<td class="rcell2"><span><?=$row_c->last_name?></span></td>                                       		       </tr>                                                    
						</table>
				   </li>
					 <?php } 	?>                                         	
			 
			
			 <?php }
			} ?>
		<?php	
		} */
		
										 
		
}

?>