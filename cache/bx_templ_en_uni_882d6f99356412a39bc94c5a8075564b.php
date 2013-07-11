<div class="adm-category-items bx-def-bc-margin">
    <?php if(is_array($a['bx_repeat:items'])) for($i=0; $i<count($a['bx_repeat:items']); $i++){ ?>
        <div class="adm-category-item bx-def-margin-sec-top-auto">	        	
            <?php if($a['bx_repeat:items'][$i]['bx_if:icon']['condition']){ ?>
                <img src="<?=$a['bx_repeat:items'][$i]['bx_if:icon']['content']['icon'];?>" />
            <?php } ?>
            <?php if($a['bx_repeat:items'][$i]['bx_if:texticon']['condition']){ ?>
                <i class="sys-icon <?=$a['bx_repeat:items'][$i]['bx_if:texticon']['content']['icon'];?>"></i>
            <?php } ?>
        	<div class="adm-ci-link"><a href="<?=$a['bx_repeat:items'][$i]['link'];?>" <?=$a['bx_repeat:items'][$i]['onclick'];?>><?=$a['bx_repeat:items'][$i]['title'];?></a></div>
        	<div class="adm-ci-description"><?=$a['bx_repeat:items'][$i]['description'];?></div>
        </div>
    <?php } else if(is_string($a['bx_repeat:items'])) echo $a['bx_repeat:items']; ?>
</div>
