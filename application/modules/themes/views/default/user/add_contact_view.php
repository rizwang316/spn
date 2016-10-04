
<?php
// load user model
 $this->load->model('user/user_model'); ?>
<div class="container">
  <div class="contactmain">
  	<div class="col-sm-6">
    	<h3>Add Contact </h3>
    </div>
    <div id="load">Please wait ...</div>
    <?php if(is_loggedin() && is_personal()){ ?>  
    	<div class="col-sm-6">
        	<form action=""  method="post" >
            	<input type="text" name="search_value" />
                <input type="submit" name="Search" value="search" />
            </form>
        </div>
        <div class="clear"></div>
     	<div id="notif"></div>
       <div class="clear"></div>     
  <?php if ($users->num_rows() > 0) { ?>
  		
        
	  <?php  foreach ($users->result() as $row){ ?>
      <?php //print_r($row); ?>
       <div class="row bottom20">
       		<div class="col-sm-8">
             <span><img class="" width="50" src="<?php echo get_profile_photo_by_id($row->id);?>"></span>
			 <?php echo $row->first_name.' '.$row->last_name ?>
              </div>  
             <div class="col-sm-4">
             <?php if($this->user_model->check_user_contact($this->session->userdata('user_id'),$row->id)== true){ ?>
                 <a href="javascript:void(0)" class="add_user btn-color" userID="<?=$row->id?>">Add Friend</a>                
                <?php 	}else{	 ?>
                 <span class="btn-color" userID="<?=$row->id?>">Friends</span>
                 <?php  } ?>
              
             </div>      
       </div>
      <?php } ?>
  		
  <?php }else{ ?>
  		<strong><p>No result found!</p></strong>
  <?php } ?>
   <?php }else{ ?>
 		 <div class="clear"></div>
   		<p>you have no permission to access this.</p>
    <?php } ?>
    <!-- frind list-->
    <?php if ($friend_lists->num_rows() > 0) { ?>
    	<ul>
       		 <strong>*****Friend List*****</strong>
    	 <?php  foreach ($friend_lists->result() as $row){ ?>
                    <?php // print_r($row); ?>
             	<li><?php echo $row->first_name.' '.$row->last_name ?>
                <a href="javascript:void(0)" class="chat_user" userID="<?=$row->id?>" >Chat</a>
               </li>             		
         <?php } ?>
      </ul>
      <div class="chat-shows">
      		<div class="show-msg"></div>
            <div id="chat"></div>
            <form id="send-message">	
            	<input type="text" name="message" id="message" />
               
               <input type="submit" name="" />
               
           </form> 
      </div>
    <?php }else{  echo 'No friend in list.'; } ?>
    
  </div>
  <!--cont--> 
</div>

<script>
$(document).ready(function(){
	   
	    $("#load").hide();
		 // get curent user id
		 var current_userID ='<?=$this->session->userdata('user_id')?>';
		
	 	 $(".add_user").click(function(){		
			 
		  $( "#load" ).show();
			 // get user id for request.			 
			 var userID = $(this).attr('userID');
			 var $this = $(this);		
			 
			 var dataString = { 
              userID : $(this).attr('userID'),
            }; 
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/add_user_request');?>",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
              if(data.success == true){
				  				  
				  $this.html("Friends");
				  
                $("#notif").html(data.notif);
				
                var socket = io.connect( 'http://'+window.location.hostname+':3000' );				
		   		socket.emit('new_user_request', userID);	
				
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
	
	// chat  
	$(".chat_user").click(function(){
		
		 var userID = $(this).attr('userID');	
		 
		 $(".chat-shows").html('irfan');
		
		
	});
	var socket = io.connect( 'http://'+window.location.hostname+':3000' );	
	var $messageForm = $("#send-message");
	var $messageBox = $("#message");
	var $chat = $("#chat");
	$messageForm.submit(function(e){
		e.preventDefault();
		socket.emit('send_message',$messageBox.val());
		$messageBox.val('');
		
	});	
	socket.on('new_message',function(data){
		
	     $chat.append(data+"<br />");
	}); 
	
	

	  
	
});
</script>
