<?php if(is_array($a['bx_repeat:items'])) for($i=0; $i<count($a['bx_repeat:items']); $i++){ ?>
    <span class="bx-def-margin-sec-left">
        <a class="bottom_links_block" href="<?=$a['bx_repeat:items'][$i]['link'];?>" <?=$a['bx_repeat:items'][$i]['script'];?> <?=$a['bx_repeat:items'][$i]['target'];?>><?=$a['bx_repeat:items'][$i]['caption'];?></a>
    </span>
<?php } else if(is_string($a['bx_repeat:items'])) echo $a['bx_repeat:items']; ?>