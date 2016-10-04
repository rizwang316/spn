<script type="text/javascript">
$(document).ready(function(){	   
		 // get curent user id
		 var current_userID ='<?=$this->session->userdata('user_id')?>';
		 
		 var socket = io.connect( 'http://'+window.location.hostname+':3000' );
	     //recive request.
		   socket.on( 'new_request', function( data ) {
			   		   
			  if(data.userID_receiver == current_userID ){				 
				  // $("#"+current_userID).html('success');
				   $("#"+current_userID+" > #notif_audio")[0].play();
				  // get data for notification.
				   var dataString = { 
             		 user_id : data.userID_send,
           			 }; 
				 $.ajax({
					type: "POST",
					url: "<?php echo base_url('user/get_user_request_data');?>",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(success_data){					  
					  if(success_data.success == true){		   
						  $("#notify_"+data.userID_receiver+"  #notifyId").html(success_data.content);	
					  }
				  
					} ,error: function(xhr, status, error) {
					  alert(error);
					},
		
				});				   
					// alert(JSON.stringify(data));
				}	    
							
		  });	
});
</script>