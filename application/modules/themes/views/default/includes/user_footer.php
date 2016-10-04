    
	<script src="<?php echo theme_url();?>/assets/js/ios-orientationchange-fix.js"></script>
    <script src="<?php echo theme_url();?>/assets/js/jquery.swipebox.js"></script>
    
    <script src="<?php echo theme_url();?>/assets/js/jquery.slimscroll.min.js"></script>
	<script type="text/javascript">
    $( document ).ready(function() {
        
        
        $('#notifyId').slimScroll({
              railVisible: true,
              railColor: '#6f6f6f',
              height:'300px'});
    
                    
            $(window).click(function() {
            $( ".notify_frnd" ).hide();});
    
            $('.notify_master').click(function(event){
                event.stopPropagation();
            });
             $( ".notfi_cls" ).click(function() {	
              $( ".notify_frnd" ).slideToggle('slow');
              });
			  
			  // start
			  // notify message.
			  $('#messageId').slimScroll({
              railVisible: true,
              railColor: '#6f6f6f',
              height:'300px'});
    
                    
            $(window).click(function() {
            $( ".notify_message" ).hide();});
    
            $('.notify_message_master').click(function(event){
                event.stopPropagation();
            });
             $( ".notfi_message_cls" ).click(function() {	
			         // update database for notify
					 // another ajax call
					  var dataString = { 
             			 userID : '',
           			 }; 
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('user/update_seen');?>",
							data: dataString,
							dataType: "json",
							cache : false,
							success: function(data_snd_one_msg){
								$('.count_unseen').html('');								
								} ,error: function(xhr, status, error) {
							  alert(error);
							},
						});	
             		$( ".notify_message" ).slideToggle('slow');
              });
			  
			  
			  // end
			  
    		$('.chat_close').live('click',function(e) {
                $(this).parent().hide();
            });
			
             /*$('.chat_close').click(function(e) {
                $(this).parent().hide();
            });*/
            
            $('.useronline').click(function(e) {
                $('.chatopen').show();				
				//$(".chat-message").animate({ scrollTop: $(document).height() }, "slow");
				
            });
                    
            /* Basic Gallery */
            $( '.swipebox' ).swipebox();
            
            /* Video */
            $( '.swipebox-video' ).swipebox();
    
            /* Dynamic Gallery */
                $( ".videoimg" ).each(function( i ) {
                 var  url =$(this).find('a').attr("href");
                 var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
                 var match = url.match(regExp);
                if ($(match&&match[7].length==11)){ 
                $(this).find('img').attr('src','http://img.youtube.com/vi/' + match[7] + '/0.jpg')   
                }
        });
    
      });
    </script>
  <script>
$(document).ready(function(){
	   
	    $("#load").hide();
		 // get curent user id
		 var current_userID ='<?=$this->session->userdata('user_id')?>';
		// accept user request.
	    // user respond.
		$(".respond-user").click(function(){		
			 
		  $( "#load" ).show();
			 // get user id for request.			 
			 var userID = $(this).attr('userID');
			 var $this = $(this);		
			 
			 var dataString = { 
              userID : $(this).attr('userID'),
            }; 
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/respond_user_request');?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
              if(data.success == true){
				  				  
				 $this.html("Friend");
				  
                $("#notif").html(data.notif);
				
                var socket = io.connect( 'http://'+window.location.hostname+':3000' );	
							
		   		socket.emit('respond_user_request', userID);	
				
               /* socket.emit('new_count_message', { 
                  new_count_message: data.new_count_message
                });*/

               
              } else if(data.success == false){
				  
                $("#notif").html(data.notif);

              }
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },

        });
	    
	 }); 
	 
	 // user respond.
		$(".delete_user_request").click(function(){		
			 
		  $( "#load" ).show();
			 // get user id for request.			 
			 var userID = $(this).attr('userID');
			 var $this = $(this);		
			 
			 var dataString = { 
              userID : $(this).attr('userID'),
            }; 
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/delete_user_request');?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
              if(data.success == true){
				  				  
				 $this.html("deleted");
				  
                $("#notif").html(data.notif);
				
                var socket = io.connect( 'http://'+window.location.hostname+':3000' );	
							
		   		socket.emit('respond_user_request', userID);	
				
               /* socket.emit('new_count_message', { 
                  new_count_message: data.new_count_message
                });*/

               
              } else if(data.success == false){
				  
                $("#notif").html(data.notif);

              }
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },

        });
	    
	 });
	
});
</script>  

<script type="text/javascript">
     // on click load message box. 
	$(document).ready(function(){		
	 // get curent user id
	 var current_userID ='<?=$this->session->userdata('user_id')?>';
		
	// open chat box.
	$(".open_chat_box").on('click',function(){				
		     
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
			    
				  $(".notify_userID_"+userID+" #count_unread").html('');
				  
				  $(".show-chat").html(data.content);
				   $('.chatopen').show();
				  				  
				//$this.html("Friends");
				  
               // $("#notif").html(data.notif);
				
               // var socket = io.connect( 'http://'+window.location.hostname+':3000' );				
		   		//socket.emit('new_user_request', userID);	
				
               /* socket.emit('new_count_message', { 
                  new_count_message: data.new_count_message
                });*/

               
              } else if(data.success == false){
				  
                $("#notif").html(data.notif);

              }
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },

        });
	});
		
	});
	</script>
    
<!-- chat box -->    
<?php /*?><script>
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
						
					
				
               // socket.emit('new_count_message', { 
                //  new_count_message: data.new_count_message
               // });

               
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
							// sound.
							$("#"+current_userid+" > #notif_audio")[0].play();
							
							// another ajax call
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('user/get_user_send_one_msg');?>",
							data: newdataString,
							dataType: "json",
							cache : false,
							success: function(data_snd_one_msg_2){
								$("#chat_<?=$this->session->userdata('user_id')?> .chat").append(data_snd_one_msg_2.content);
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
</script><?php */?>