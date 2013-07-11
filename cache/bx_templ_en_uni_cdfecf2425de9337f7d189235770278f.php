
<div class="paginate bx-def-padding-right bx-def-padding-left">	

    <?php if($a['bx_if:info']['condition']){ ?>
		<div class="info bx-def-margin-left-auto">
			<?=$a['bx_if:info']['content']['from'];?>-<?=$a['bx_if:info']['content']['to'];?> <span><?=$a['bx_if:info']['content']['of'];?></span> <?=$a['bx_if:info']['content']['total'];?>
		</div>
	<?php } ?>

    <?php if($a['bx_if:per_page']['condition']){ ?>
    	<div class="per_page bx-def-margin-left-auto">
            <?=$a['bx_if:per_page']['content']['per_page_caption'];?>&nbsp;
            <select name="per_page" onchange="<?=$a['bx_if:per_page']['content']['per_page_on_change'];?>">
                <?php if(is_array($a['bx_if:per_page']['content']['bx_repeat:options'])) for($i=0; $i<count($a['bx_if:per_page']['content']['bx_repeat:options']); $i++){ ?>
                    <option value="<?=$a['bx_if:per_page']['content']['bx_repeat:options'][$i]['opt_value'];?>" <?=$a['bx_if:per_page']['content']['bx_repeat:options'][$i]['opt_selected'];?>><?=$a['bx_if:per_page']['content']['bx_repeat:options'][$i]['opt_caption'];?></option>
                <?php } else if(is_string($a['bx_if:per_page']['content']['bx_repeat:options'])) echo $a['bx_if:per_page']['content']['bx_repeat:options']; ?>
            </select>
    	</div>
    <?php } ?>

	<?php if($a['bx_if:reloader']['condition']){ ?>
        <div class="reloader bx-def-margin-left-auto">
            <div class="paginate_btn">
                <a href="<?=$a['bx_if:reloader']['content']['lnk_url'];?>" title="<?=$a['bx_if:reloader']['content']['lnk_title'];?>" <?=$a['bx_if:reloader']['content']['lnk_on_click'];?>>
                    <i class="sys-icon refresh"></i>
                </a>
            </div>
        </div>
    <?php } ?>

	<?php if($a['bx_if:view_all']['condition']){ ?>
        <div class="view_all bx-def-margin-left-auto">
            <a href="<?=$a['bx_if:view_all']['content']['lnk_url'];?>" title="<?=$a['bx_if:view_all']['content']['lnk_title'];?>"><?=$a['bx_if:view_all']['content']['lnk_content'];?></a>
        </div>
	<?php } ?>

	<div class="pages_section"><?=$a['content'];?></div>

	<div class="clear_both"></div>

</div>

