 <div class="clear"></div>
          <div class="chatroom">
           <div class="bg-white flist">
            <div class="border-bottom padding-sm ch-h">
            	<h3>Members</h3>
            </div>
            
            <!-- =============================================================== -->
            <!-- member list -->
            <ul class="friend-list">
             <?php $friend_lists = get_friend_list($this->session->userdata('user_id')); ?>
             <?php if ($friend_lists->num_rows() > 0) { ?>
                   		 
                 <?php  foreach ($friend_lists->result() as $row){ ?>
                   <li class="useronline open_chat_box" userID="<?=$row->id?>">
                	<a href="#" class="clearfix">
                    
                		<img src="<?php echo get_profile_photo_by_id($row->id,'thumb');?>" alt="" class="img-circle">
                		<div class="friend-name">	
                			<strong><?php echo $row->last_name ?></strong>
                		</div>
                		<?php /*?><div class="last-message text-muted">Hello, Are you there?</div><?php */?>
                		<?php /*?><small class="time text-muted">Just now</small><?php */?>
                        <?php
						// check online
						$users_online = $this->onlineusers->get_info(); //prefer using reference to best memory usage				
						foreach($users_online as $user) 
						{
							if(is_array($user)) {
							  foreach($user as $usr){
								if(isset($usr['username'])) {
									if($row->user_name == $usr['username'] ){ ?>
                                    <small class="chat-alert label on-dot"><i class="fa fa-circle"></i></small>                                    <?php										
										} 								
								   }
								
							   }
							}   
						}
						 ?>
                		
                	</a>                          		
                 <?php } ?>              
       <?php }else{  echo 'No friend in list.'; } ?>                      
                          
                
                                 
            </ul>
		</div>
          <div class="show-chat"></div>
          </div>
      
    
   <?php /*?> <script type="text/javascript">
	$(document).ready(function(){
		
	 // get curent user id
	 var current_userID ='<?=$this->session->userdata('user_id')?>';
		
	// open chat box.
	$(".open_chat_box").click(function(){	
		     
			 $( "#load" ).show();
			 // get user id for request.			 
			 var userID = $(this).attr('userID');
			 var $this = $(this);					 
			 var dataString = { 
              userID : $(this).attr('userID'),
            }; 
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/open_chat_box');?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
              if(data.success == true){
				  
				  $(".show-chat").html(data.content);
				   $('.chatopen').show();
				  				  
				//$this.html("Friends");
				  
               // $("#notif").html(data.notif);
				
               // var socket = io.connect( 'http://'+window.location.hostname+':3000' );				
		   		//socket.emit('new_user_request', userID);	
				
               // socket.emit('new_count_message', { 
                //  new_count_message: data.new_count_message
               // });

               
              } else if(data.success == false){
				  
                $("#notif").html(data.notif);

              }
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },

        });
	});
		
	});
	</script><?php */?>