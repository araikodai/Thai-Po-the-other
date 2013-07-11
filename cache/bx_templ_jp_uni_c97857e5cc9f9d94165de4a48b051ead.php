<form id="ps-my-groups-form" name="ps-my-groups-form" action="member_privacy.php" method="post" enctype="multipart/form-data">
    <div class="ps-groups bx-def-bc-margin">
        <?php if(is_array($a['bx_repeat:groups'])) for($i=0; $i<count($a['bx_repeat:groups']); $i++){ ?>            
            <div class="ps-cell-chb">
                <input type="checkbox" name="ps-my-groups-ids[]" value="<?=$a['bx_repeat:groups'][$i]['group_id'];?>" />
            </div>
            <div class="ps-cell-title"><?=$a['bx_repeat:groups'][$i]['group_title'];?>(<?=$a['bx_repeat:groups'][$i]['group_members'];?>)<?php if($a['bx_repeat:groups'][$i]['bx_if:extended']['condition']){ ?><?=$a['bx_repeat:groups'][$i]['bx_if:extended']['content']['group_extended'];?><?php } ?></div>
            <div class="ps-cell-action">
                <a href="javascript:void(0)" onclick="javascript:ps_showDialog('add', <?=$a['bx_repeat:groups'][$i]['group_id'];?>, this)"><img src="<?=$a['bx_repeat:groups'][$i]['add_img_url'];?>" alt="<?=$a['bx_repeat:groups'][$i]['add_img_title'];?>" title="<?=$a['bx_repeat:groups'][$i]['add_img_title'];?>" /></a>&nbsp;
                <a href="javascript:void(0)" onclick="javascript:ps_showDialog('del', <?=$a['bx_repeat:groups'][$i]['group_id'];?>, this)"><img src="<?=$a['bx_repeat:groups'][$i]['delete_img_url'];?>" alt="<?=$a['bx_repeat:groups'][$i]['delete_img_title'];?>" title="<?=$a['bx_repeat:groups'][$i]['delete_img_title'];?>" /></a>
            </div>
        <?php } else if(is_string($a['bx_repeat:groups'])) echo $a['bx_repeat:groups']; ?>
        <div class="clear_both">&nbsp;</div>
    </div>
    <?=$a['control'];?>
</form>