<li class="f_request">
   <table><tr>
    <td class="userimgcls">
    <span>
    <img src="<?php echo get_profile_photo_by_id($user_data->id,'thumb');?>" alt="" >    
    </span></td> 
    <td class="rcell2"><span><?=$user_data->last_name?></span></td>
    <td class="rcell3"><a href="javascript:void(0)" userID="<?=$user_data->id?>" class="respond-user">Confirm</a></td>
    <td class="rcell4"><a href="javascript:void(0)" userID="<?=$user_data->id?>" class="delete_user_request">Delete Request</a></td>
   </tr></table>
</li>
