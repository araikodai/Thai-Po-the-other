<div class="bx-def-bc-margin">
	<?php if(is_array($a['bx_repeat:items'])) for($i=0; $i<count($a['bx_repeat:items']); $i++){ ?>
	    <div class="dbPrivacyItem">
	        <a href="javascript:void(0);" onclick="javascript:ps_page_select(this, <?=$a['bx_repeat:items'][$i]['block_id'];?>, <?=$a['bx_repeat:items'][$i]['group_id'];?>);" class="<?=$a['bx_repeat:items'][$i]['class'];?>"><?=$a['bx_repeat:items'][$i]['title'];?></a>
	    </div>
	<?php } else if(is_string($a['bx_repeat:items'])) echo $a['bx_repeat:items']; ?>
</div>