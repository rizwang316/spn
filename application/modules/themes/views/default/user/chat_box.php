 <div class="clear"></div>
          <div class="chatroom">        
          <div class="bg-white chatopen">
            <div class="chat_close"><i class="fa fa-close"> </i></div>
             <h5><?php echo $user_data->first_name .' '. $user_data->last_name  ?></h5>
            
            <div class="chat-message"  id="chat_<?=$this->session->userdata('user_id')?>">
                <ul class="chat">
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
                                                          
                                 <?php  echo time_elapsed_string(date('Y-m-d H:i:s',$row->date)); ?> </small>
                    		</div>
                    		<p>
                    			<?php echo $row->reply; ?>
                    		</p>
                    	</div>
                    </li>
                     	
                     <?php } ?>
                   <?php }else{ ?>
                   		<?php /*?><p>no message.</p><?php */?>
                   	<?php } ?>
                                        
                </ul>
            </div>
            <div class="chat-box bg-white">
            	<form action="" method="post" class="message-form">
	            	<div class="input-group">
            		<input type="text" name="reply" class="form-control border no-shadow no-rounded message" value="" placeholder="Type your message here">
                    <input type="hidden" name="c_id" value="<?=$c_id?>" />
                    <input type="hidden" name="user_one" id="user_one" value="<?=$user_one?>" />
                    <input type="hidden" name="user_two" id="user_two" value="<?=$user_two?>" />
            		<span class="input-group-btn">
            			<button class="btn btn-success no-rounded" type="submit">Send</button>
                        
            		</span>
            	</div><!-- /input-group -->	
                </form>
            </div>            
		</div>
          </div>
          
 
<script>
$(document).ready(function(){
	   
	    $("#load").hide();	
	
	var socket = io.connect( 'http://'+window.location.hostname+':3000' );	
	// current user id.		
	var current_userid =  "<?=$this->session->userdata('user_id')?>";	
	//send message.
	var $messageForm = $(".message-form");		
	$messageForm.submit(function(e){
		e.preventDefault();
		 var $message_value = $messageForm.find(".message").val();
		if($message_value != ''){
		// get ids,
		var userID_send_msg =  $messageForm.find("#user_one").val();  
		var userID_receive_msg =  $messageForm.find("#user_two").val(); 
		
		var dataString = $messageForm.serializeArray();		
	   // var $chat = $("#chat");
	    $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/send_user_message');?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data_success){
              $( "#load" ).hide();
              if(data_success.success == true){
				  $messageForm.trigger("reset");
				  
				//$this.html("Friends");				  
               // $("#notif").html(data.notif);   			         
							
		   		socket.emit('new_user_chat_msg',{
								userID_send_msg:userID_send_msg,
								userID_receive_msg:userID_receive_msg,
								insert_id:data_success.insert_id
								});												
						
					
				
               /* socket.emit('new_count_message', { 
                  new_count_message: data.new_count_message
                });*/

               
              } else if(data_success.success == false){
				  
                $("#notif").html(data.notif);

              }
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });		
		
		//socket.emit('send_message',$messageBox.val());
		//$messageBox.val('');
		}else{ 
		 }
		
	});	
	
	// receive message.
	socket.on('user_chat_message', function(data){	
	          		
					// sound.
					$("#"+current_userid+" > #notif_audio")[0].play();
					//$('.chat-message').scrollTop($('.chat-message').prop('scrollHeight'));					
						 
						
								
						var newdataString = {
							userid_one:data.userID_send_msg,
							userid_two:data.userID_receive_msg,
							insert_id:data.insert_id
							}
							
						if(data.userID_send_msg == current_userid ){ 						
						// another ajax call
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('user/get_user_send_one_msg');?>",
							data: newdataString,
							dataType: "json",
							cache : false,
							success: function(data_snd_one_msg){
								$("#chat_<?=$this->session->userdata('user_id')?> .chat").append(data_snd_one_msg.content);
								// for scrool down.
								$('.chat-message').scrollTop($('.chat-message')[0].scrollHeight);		
								// end
								} ,error: function(xhr, status, error) {
							  alert(error);
							},
						});	
						
						var loadUrl = '<?php echo site_url("user/header_notify/");?>';
						jQuery.post(
							loadUrl,
							{},
							function(responseText){
								jQuery("#message_"+data.userID_send_msg+" .notify_message").html(responseText);								
							}
						);
						// menu notify.
						//$("#message_"+data.userID_send_msg+" .notify_message").html('sender');
						
						}
						if(data.userID_receive_msg  == current_userid){
							
							// another ajax call
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('user/get_user_send_one_msg');?>",
							data: newdataString,
							dataType: "json",
							cache : false,
							success: function(data_snd_one_msg_2){
								$("#chat_<?=$this->session->userdata('user_id')?> .chat").append(data_snd_one_msg_2.content);
								// for scrool down.
								$('.chat-message').scrollTop($('.chat-message')[0].scrollHeight);
								
								// end
								} ,error: function(xhr, status, error) {
							  alert(error);
							},
						});		
						
						var loadUrl = '<?php echo site_url("user/header_notify/");?>';
						jQuery.post(
							loadUrl,
							{},
							function(responseText){
								jQuery("#message_"+data.userID_receive_msg+" .notify_message").html(responseText);								
							}
						);
						// menu notify.
						
												
						}					
				 
					 // $chat.append(data+"<br />");
				 }); 	
	//socket.on('new_message',function(data){
		
	//     $chat.append(data+"<br />");
	//}); 
	
	

	  
	
});
</script>
          