<div id="sys_inviter_users" class="bx-def-round-corners-with-border">
    <div>
        <input type="checkbox" onclick="$('#sys_inviter_users input[name=\'inviter_users[]\']').attr('checked', this.checked ? 'checked' : '')" />                        
        <span>Select all</span>
    </div>
    <?php if(is_array($a['bx_repeat:rows'])) for($i=0; $i<count($a['bx_repeat:rows']); $i++){ ?>
        <div class="bx-def-border-top-auto">
            <input type="checkbox" name="inviter_users[]" value="<?=$a['bx_repeat:rows'][$i]['ID'];?>" />
            <?=$a['bx_repeat:rows'][$i]['Icon'];?>
            <a href="<?=$a['bx_repeat:rows'][$i]['Link'];?>"><?=$a['bx_repeat:rows'][$i]['NickName'];?></a>
            <div class="clear_both"></div>
        </div>
    <?php } else if(is_string($a['bx_repeat:rows'])) echo $a['bx_repeat:rows']; ?>
    <div class="sys_inviter_no_users bx-def-border-top-auto">
        <?=$a['msg_no_users'];?>
    </div>
</div>
