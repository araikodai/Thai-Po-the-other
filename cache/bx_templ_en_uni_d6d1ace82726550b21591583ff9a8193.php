<?php if($a['bx_if:menu_position_bottom']['condition']){ ?>
<div class="control">
    <div>        
        <a href="http://www.thaipo.org/mail.php?mode=inbox"><?=$a['bx_if:menu_position_bottom']['content']['go_inbox'];?></a> (<?=$a['bx_if:menu_position_bottom']['content']['inbox_count'];?>)
    </div>
    <div>        
        <a href="http://www.thaipo.org/mail.php?mode=outbox"><?=$a['bx_if:menu_position_bottom']['content']['go_outbox'];?></a> (<?=$a['bx_if:menu_position_bottom']['content']['outbox_count'];?>)
    </div>
    <div>
        <a href="http://www.thaipo.org/mail.php?mode=trash"><?=$a['bx_if:menu_position_bottom']['content']['go_trash'];?></a> (<?=$a['bx_if:menu_position_bottom']['content']['trash_count'];?>)
    </div>
    <div>
        <a href="http://www.thaipo.org/mail.php?mode=compose"><?=$a['bx_if:menu_position_bottom']['content']['go_compose'];?></a> 
    </div>
</div>
<?php } ?>
<?php if(is_array($a['bx_repeat:new_message'])) for($i=0; $i<count($a['bx_repeat:new_message']); $i++){ ?>
<div class="extra_menu_list">
    <table>
        <tbody>
            <tr>
                <td class="icon">
                    <?=$a['bx_repeat:new_message'][$i]['thumbnail'];?>
                </td>
                <td valign="top">
                    <a href="<?=$a['bx_repeat:new_message'][$i]['sender_link'];?>" class="message"><?=$a['bx_repeat:new_message'][$i]['sender_nick'];?></a>
                    <div class="message_caption">
                        <a href="http://www.thaipo.org/mail.php?mode=view_message&messageID=<?=$a['bx_repeat:new_message'][$i]['message_id'];?>" class="msg_link"><?=$a['bx_repeat:new_message'][$i]['msg_caption'];?></a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php } else if(is_string($a['bx_repeat:new_message'])) echo $a['bx_repeat:new_message']; ?>
<?php if($a['bx_if:menu_position_top']['condition']){ ?>
<div class="control">
    <div>
        <a href="http://www.thaipo.org/mail.php?mode=inbox"><?=$a['bx_if:menu_position_top']['content']['go_inbox'];?></a> (<?=$a['bx_if:menu_position_top']['content']['inbox_count'];?>)
    </div>
    <div>
        <a href="http://www.thaipo.org/mail.php?mode=outbox"><?=$a['bx_if:menu_position_top']['content']['go_outbox'];?></a> (<?=$a['bx_if:menu_position_top']['content']['outbox_count'];?>)
    </div>
    <div>
        <a href="http://www.thaipo.org/mail.php?mode=compose"><?=$a['bx_if:menu_position_top']['content']['go_compose'];?></a> 
    </div>
    <div>
        <a href="http://www.thaipo.org/mail.php?mode=trash"><?=$a['bx_if:menu_position_top']['content']['go_trash'];?></a> (<?=$a['bx_if:menu_position_top']['content']['trash_count'];?>)
    </div>
</div>
<?php } ?>
