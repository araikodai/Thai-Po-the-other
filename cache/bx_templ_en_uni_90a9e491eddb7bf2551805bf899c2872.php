<div id="adm-mp-ctl-qlinks" style="<?=$a['styles_qlinks'];?>">
    <?php if(is_array($a['bx_repeat:content_qlinks'])) for($i=0; $i<count($a['bx_repeat:content_qlinks']); $i++){ ?>
        <div class="adm-mp-qlinks-item">
            <a href="<?=$a['bx_repeat:content_qlinks'][$i]['link'];?>" onclick="<?=$a['bx_repeat:content_qlinks'][$i]['on_click'];?>"><span class="bx-def-font-h1"><?=$a['bx_repeat:content_qlinks'][$i]['count'];?></span> <?=$a['bx_repeat:content_qlinks'][$i]['title'];?></a>
        </div>
    <?php } else if(is_string($a['bx_repeat:content_qlinks'])) echo $a['bx_repeat:content_qlinks']; ?>
    <div class="clear_both">&nbsp;</div>
</div>