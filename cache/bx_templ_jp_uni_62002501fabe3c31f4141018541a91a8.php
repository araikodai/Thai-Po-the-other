<form id="bx_photos_admin_form" method="post">
    <div id="<?=$a['main_code_id'];?>" class="bx-def-bc-margin-thd">
        <?=$a['main_code'];?>
        <div class="clear_both"></div>
    </div>
    <?=$a['paginate'];?>
    <?=$a['manage'];?>
	<?php if($a['bx_if:hidden']['condition']){ ?>
	    <input type="hidden" name="<?=$a['bx_if:hidden']['content']['hidden_name'];?>" value="<?=$a['bx_if:hidden']['content']['hidden_value'];?>">
	<?php } ?>
</form>