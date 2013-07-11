<div id="adm-mp-control">
    <div id="adm-mp-ctl-qlinks" style="<?=$a['styles_qlinks'];?>">
    <?php if(is_array($a['bx_repeat:content_qlinks'])) for($i=0; $i<count($a['bx_repeat:content_qlinks']); $i++){ ?>
        <div class="adm-mp-qlinks-item">
            <a href="<?=$a['bx_repeat:content_qlinks'][$i]['link'];?>" onclick="<?=$a['bx_repeat:content_qlinks'][$i]['on_click'];?>"><span class="bx-def-font-h1"><?=$a['bx_repeat:content_qlinks'][$i]['count'];?></span> <?=$a['bx_repeat:content_qlinks'][$i]['title'];?></a>
        </div>
    <?php } else if(is_string($a['bx_repeat:content_qlinks'])) echo $a['bx_repeat:content_qlinks']; ?>
    <div class="clear_both">&nbsp;</div>
</div>
	<div id="adm-mp-ctl-browse" style="<?=$a['styles_browse'];?>">
    <?=$a['content_browse'];?>
</div>
    <div id="adm-mp-ctl-calendar" style="<?=$a['styles_calendar'];?>">
    <?=$a['content_calendar'];?>
</div>
    <div id="adm-mp-ctl-tags" style="<?=$a['styles_tags'];?>">
    <?=$a['content_tags'];?>
</div>
    <div id="adm-mp-ctl-search" style="<?=$a['styles_search'];?>">
    <?=$a['content_search'];?>
</div>
    <?=$a['loading'];?>
</div>