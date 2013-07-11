<div class="sys-service-menu bx-def-margin-sec-left bx-def-font-large">
    <?php if(is_array($a['bx_repeat:items'])) for($i=0; $i<count($a['bx_repeat:items']); $i++){ ?>
        <span>
            <a class="sys-sm-link" href="<?=$a['bx_repeat:items'][$i]['link'];?>" <?=$a['bx_repeat:items'][$i]['script'];?> <?=$a['bx_repeat:items'][$i]['target'];?>><?=$a['bx_repeat:items'][$i]['caption'];?></a>
        </span>
        <span class="bullet">&#183;</span>
    <?php } else if(is_string($a['bx_repeat:items'])) echo $a['bx_repeat:items']; ?>
</div>
