<div class="container">
  <div class="contactmain friend-list-container">
  	<div class="col-sm-12">
    	<h3>Friends List </h3>
    </div>
    <div id="load">Please wait ...</div>
    
<?php /*?>    <?php
$user_one = $this->session->userdata('user_id');
$query= $this->db->query("SELECT u.id,c.c_id,u.user_email
 FROM spn_user_conversation c, spn_users u
 WHERE CASE 
 WHEN c.user_one = '$user_one'
 THEN c.user_two = u.id
 WHEN c.user_two = '$user_one'
 THEN c.user_one= u.id
 END 
 AND (
 c.user_one ='$user_one'
 OR c.user_two ='$user_one'
 )
 Order by c.c_id DESC Limit 20") or die(mysql_error());
 
foreach ($query->result() as $row)
{
	print_r($row);
	$c_id = $row->c_id;
	$cquery = $this->db->query("SELECT R.cr_id,R.reply FROM spn_user_conversation_reply R WHERE R.c_id_fk='$c_id' ORDER BY R.cr_id DESC LIMIT 1") or die(mysql_error());

}

?><?php */?>
    
    <!-- frind list-->
    <?php 
		$friend_lists = get_friend_list($this->session->userdata('user_id'));
	if ($friend_lists->num_rows() > 0) { ?>
    	<div class="row bottom20">
       		    		 
    	 <?php  foreach ($friend_lists->result() as $row){ ?>
              <div class="col-sm-6">
              
              <table>
              <tr>
              <td class="friend_ncls">
             	<span><img class="" width="50" src="<?php echo get_profile_photo_by_id($row->id);?>"></span> </td>
                <td class="friend_ncls2">
			 <?php echo $row->first_name.' '.$row->last_name ?>
             </td>
             </tr>
             </table>
              </div>                          		
         <?php } ?>
         <div class="clear"></div>
      
      </div>
      
    <?php }else{  echo 'No friend in list.'; } ?>
    
     
    
  </div>
  <!--cont--> 
</div>

<script>
$(document).ready(function(){
	   
	    $("#load").hide();	
});
</script>
