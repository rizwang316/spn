<header>
         <div class="container">
          <div class="menucls2">  
           	<nav class="navbar menucls">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
             
            </div>
            <div id="navbar" class="navbar-collapse collapse user-menu" aria-expanded="false">
                                                           
              <ul class="nav navbar-nav">
                <li><a href="<?=site_url()?>">Home</a></li>               
                
                <?php if(is_loggedin() && is_personal()){ ?>                
                <li><a href="<?=site_url(); ?>add-contact"  class="<?php if($this->uri->segment('1')=='add-contact'){ echo 'active';} ?>">Add Contacts</a></li>  
               
                
                <li><a href="<?=site_url(); ?>friends-list"  class="<?php if($this->uri->segment('1')=='friends-list'){ echo 'active';} ?>">Friends List</a></li>  
                
                 <?php /*?><li><a href="<?=site_url(); ?>notifications"  class="<?php if($this->uri->segment('1')=='notifications'){ echo 'active';} ?>">Notifications <sup class="notify">1</sup></a></li> <?php */?>
                 <?php 
				 	// get user request.
				 $user_request = get_user_requests($this->session->userdata('user_id')); ?>
                 
                 <li class="notify_master" id="notify_<?=$this->session->userdata('user_id')?>">
                 <a class="notfi_cls" href="javascript:void(0)"><i class="fa fa-user-plus"></i><span>
				 		<?=$user_request->num_rows()?></span></a>
                  <ul class="notify  notify_frnd">
                      <div id="notifyId">
                        <?php							
							if($user_request->num_rows() > 0)
							{
								 foreach ($user_request->result() as $request){
									?>
                                    	<li class="f_request">
                                       <table><tr>
                                        <td class="userimgcls">
                                        <span>
                                        <img src="<?php echo get_profile_photo_by_id($request->id,'thumb');?>" alt="" >    
                                        </span></td> 
                                        <td class="rcell2"><span><?=$request->last_name?></span></td>
                                        <td class="rcell3"><a href="javascript:void(0)" userID="<?=$request->id?>" class="respond-user">Confirm</a></td>
                                        <td class="rcell4"><a href="javascript:void(0)" userID="<?=$request->id?>" class="delete_user_request">Delete Request</a></td>
                                       </tr></table>
                                    </li>

								   <?php		
								 }
								
							}else{
								?>
                                <li class="f_request">
                                      <p>no request pending</p>
                                </li>
                               <?php 
								
							}
						 ?>
                       </div>
                  </ul>
                </li>   
                
                <li class="notify_message_master" id="message_<?=$this->session->userdata('user_id')?>">
                
                 <a class="notfi_message_cls" href="javascript:void(0)">Message
                   <?php $unseen = count_friend_unseen_msg($this->session->userdata('user_id')); 
				     //echo '<pre>'; print_r($unseen->result()); echo '</pre>';
					      if($unseen->num_rows() > 0){
				   			echo '<small  class="count_unseen"><span>'. $unseen->num_rows() .'</span></small>';
						  }
				   ?>
                 <?php /*?><span><?=$user_request->num_rows()?></span><?php */?>
                 </a>
                        
                  <ul class="notify notify_message">
                      <div id="messageId">  
                        <?php $frnd_list_msgs = get_friend_list_msg($this->session->userdata('user_id')); ?>  
                        <?php
						 foreach ($frnd_list_msgs->result() as $row){	
						 // un read message.
						 $unread_msg=count_friend_unread_msg($row->id);	
						 
 												 
							 ?>
                            <li class="f_request open_chat_box notify_userID_<?=$row->id?>" userID="<?=$row->id?>"> 
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
                                <td class="rcell2"><span><?=$row->last_name?>
                                      <?php if($unread_msg->num_rows() > 0){ ?>
                                	<small id="count_unread">(<?php echo $unread_msg->num_rows();	?>) </small> 
                                    <?php } ?>
                                </span></td>                                       		       </tr>                                                    
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
                       
                       </div>
                  </ul>
                </li>   
                
                 <?php } ?>            
               
              </ul>
            </div>
          
        </nav>
        
        <div class="searchcls">
                  <?php if(is_loggedin() && is_personal()){ ?>  
                   
                        <form action="<?php echo site_url(); ?>add-contact"  method="post" >
                           <input type="text" name="search_value" placeholder="Search Friends" />
                           <button><i class="fa fa-search"></i> Search</button>
                           <?php /*?> <input type="submit" name="Search" value="search" /><?php */?>
                        </form>
                   
                    <?php } ?>
                 
                 </div>
                 <div class="clear"></div>       
           </div>
         </div>
       </header>
       
      <?php /*?>  <?php $frnd_list_msgs = get_friend_list_msg($this->session->userdata('user_id')); ?>  
                        <?php
						 foreach ($frnd_list_msgs->result() as $row){
							 echo '<pre>';
							 print_r($row);
							 echo '</pre>';
						 }
						
						 ?><?php */?>