<div class="sys-bm-sub-items bx-def-bc-margin">
    <?php if(is_array($a['bx_repeat:items'])) for($i=0; $i<count($a['bx_repeat:items']); $i++){ ?>
        <div class="sys-bm-sub-item bx-def-margin-sec-top-auto <?=$a['bx_repeat:items'][$i]['class'];?>">
            <?php if($a['bx_repeat:items'][$i]['bx_if:show_icon']['condition']){ ?>
                <img src="<?=$a['bx_repeat:items'][$i]['bx_if:show_icon']['content']['icon_src'];?>" alt="<?=$a['bx_repeat:items'][$i]['bx_if:show_icon']['content']['icon_alt'];?>" width="<?=$a['bx_repeat:items'][$i]['bx_if:show_icon']['content']['icon_width'];?>" height="<?=$a['bx_repeat:items'][$i]['bx_if:show_icon']['content']['icon_height'];?>" />
            <?php } ?>
            <a href="<?=$a['bx_repeat:items'][$i]['link'];?>" <?=$a['bx_repeat:items'][$i]['onclick'];?>><?=$a['bx_repeat:items'][$i]['title'];?></a>
        </div>
    <?php } else if(is_string($a['bx_repeat:items'])) echo $a['bx_repeat:items']; ?>
    <script type="text/javascript">
        function showPopup<?=$a['name_method'];?>() {
        	$('#sys-bm-switcher-<?=$a['name_block'];?>').dolPopup({
                fog: {color: '#fff', opacity: .7}
            });
        	return false;
        }
    </script>
</div>