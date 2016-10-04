
<?php
// load user model
 $this->load->model('user/user_model'); ?>
<div class="container">
  <div class="contactmain add-contact-container">
   
  	<div class="col-sm-6 add-left">
    	<h3>Add Contact </h3>
    </div>
    <div id="load">Please wait ...</div>
    <?php if(is_loggedin() && is_personal()){ ?>  
    	<div class="col-sm-6 add-right">
        	<form action=""  method="post" >
            	<input type="text" name="search_value" placeholder="Search Friends" />
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
       	<table>	
        	<tr>
       		 <td class="td-1">
             <span><img class="" width="50" src="<?php echo get_profile_photo_by_id($row->id);?>"></span>
			 <?php echo $row->first_name.' '.$row->last_name ?>
              </td>
	         <td class="td-2">
             
             <?php $res =($this->user_model->check_user_request($this->session->userdata('user_id'),$row->id));			 
			       $respond =($this->user_model->check_user_respond($this->session->userdata('user_id'),$row->id));	
			   
			   if($res->num_rows() > 0){
				   	// check sent friend request.
				   $row_result = $res->row();					   			   
				   if($row_result->status == 2 && $row_result->user_one == $this->session->userdata('user_id') ){ ?> 
				   <span class="btn-color" userID="<?=$row->id?>">Request Sent</span>                   
				   <?php }else if($row_result->status == 1){ ?> 
                    <span class="btn-color" userID="<?=$row->id?>">Friends</span> 
				   <?php }else{?> 
				   <a href="javascript:void(0)" class="add_user btn-color" userID="<?=$row->id?>">Add Friend</a> 
				   <?php }    ?> 
			   <?php }else if($respond->num_rows() > 0){
				       // respond  to friend request or accept friend request.
					   $respond_result = $respond->row();					   
					   if(($respond_result->status == 2) && ($respond_result->user_two == $this->session->userdata('user_id')) ){ ?> 
				       <a href="javascript:void(0)" userID="<?=$row->id?>" class="respond-user btn-color">Respond to Friend Request</a>
                       <?php }else if(($respond_result->status == 1) && ($respond_result->user_two == $this->session->userdata('user_id')) ){ ?>
                       
                       <span class="btn-color" userID="<?=$row->id?>">Friends</span> 
                       
                       <?php } ?>
				   <?php }else{ ?> 
               
               <a href="javascript:void(0)" class="add_user btn-color" userID="<?=$row->id?>">Add Friend</a> 
			   
			   <?php }  ?>
             
             
              
             </td>    
             </tr>
        </table>
       </div>
      <?php } ?>
  		
  <?php }else{ ?>
  		<strong><p>No result found!</p></strong>
  <?php } ?>
   <?php }else{ ?>
 		 <div class="clear"></div>
   		<p>you have no permission to access this.</p>
    <?php } ?>
  
    
  </div>
  <!--cont--> 
</div>

<script>
$(document).ready(function(){
	   
	    $("#load").hide();
		 // get curent user id
		 var current_userID ='<?=$this->session->userdata('user_id')?>';
		 
		 
		 // add user		
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
				  				  
				  $this.html("Request Sent");
				  
                $("#notif").html(data.notif);
				
                var socket = io.connect( 'http://'+window.location.hostname+':3000' );				
		   		socket.emit('new_user_request',{userID_send: current_userID,userID_receiver:userID});	
				
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
