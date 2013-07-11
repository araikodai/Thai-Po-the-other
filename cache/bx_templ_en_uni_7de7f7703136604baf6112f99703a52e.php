<?php if($a['bx_if:menu_position_bottom']['condition']){ ?>
<div class="control">
    <div>
        <i class="sys-icon user" title="<?=$a['bx_if:menu_position_bottom']['content']['friends_request'];?>"></i>
        <a href="http://www.thaipo.org/communicator.php?person_switcher=to&communicator_mode=friends_requests"><?=$a['bx_if:menu_position_bottom']['content']['friends_request'];?></a> (<?=$a['bx_if:menu_position_bottom']['content']['request_count'];?>)
    </div>
    <div>
        <i class="sys-icon sign-blank sys-status-online" title="<?=$a['bx_if:menu_position_bottom']['content']['online_friends'];?>"></i>
        <a href="http://www.thaipo.org/viewFriends.php?&iUser=<?=$a['bx_if:menu_position_bottom']['content']['ID'];?>&online_only=on"><?=$a['bx_if:menu_position_bottom']['content']['online_friends'];?></a> (<?=$a['bx_if:menu_position_bottom']['content']['online_count'];?>)
    </div>
</div>
<?php } ?>
<?php if(is_array($a['bx_repeat:friend_list'])) for($i=0; $i<count($a['bx_repeat:friend_list']); $i++){ ?>
<div class="extra_menu_list">
<table style="border:0">
        <tbody>
            <tr>
                <td class="icon" valign="top">
                    <?=$a['bx_repeat:friend_list'][$i]['thumbnail'];?>
                </td>
                <td valign="top">
                    <?php if($a['bx_repeat:friend_list'][$i]['bx_if:video_messenger']['condition']){ ?>
			        <div style="float:left;padding-right:5px">
			            <a title="<?=$a['bx_repeat:friend_list'][$i]['bx_if:video_messenger']['content']['messenger_title'];?>" href="javascript:void(0)" onclick="openRayWidget('im', 'user', '<?=$a['bx_repeat:friend_list'][$i]['bx_if:video_messenger']['content']['sender_id'];?>', '<?=$a['bx_repeat:friend_list'][$i]['bx_if:video_messenger']['content']['sender_passw'];?>', '<?=$a['bx_repeat:friend_list'][$i]['bx_if:video_messenger']['content']['recipient_id'];?>');return false">
			            	<img src="<?=$a['bx_repeat:friend_list'][$i]['bx_if:video_messenger']['content']['video_img_src'];?>" width="16" height="16" />
			            </a>
			        </div>
			        <?php } ?>
                    <a href="http://www.thaipo.org/<?=$a['bx_repeat:friend_list'][$i]['profile_nick'];?>" class="message"><?=$a['bx_repeat:friend_list'][$i]['profile_nick'];?></a>
                    <div class="message_caption">
                        <?=$a['bx_repeat:friend_list'][$i]['head_line'];?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>    
</div>
<?php } else if(is_string($a['bx_repeat:friend_list'])) echo $a['bx_repeat:friend_list']; ?>
<?php if($a['bx_if:menu_position_top']['condition']){ ?>
<div class="control">
    <div>
        <i class="sys-icon user" title="<?=$a['bx_if:menu_position_top']['content']['friends_request'];?>"></i>
        <a href="http://www.thaipo.org/communicator.php?person_switcher=to&communicator_mode=friends_requests"><?=$a['bx_if:menu_position_top']['content']['friends_request'];?></a> (<?=$a['bx_if:menu_position_top']['content']['request_count'];?>)
    </div>
    <div>
        <i class="sys-icon sign-blank sys-status-online" title="<?=$a['bx_if:menu_position_top']['content']['online_friends'];?>"></i>
        <a href="http://www.thaipo.org/viewFriends.php?&iUser=<?=$a['bx_if:menu_position_top']['content']['ID'];?>&online_only=on"><?=$a['bx_if:menu_position_top']['content']['online_friends'];?></a> (<?=$a['bx_if:menu_position_top']['content']['online_count'];?>)
    </div>
</div>
<?php } ?>
