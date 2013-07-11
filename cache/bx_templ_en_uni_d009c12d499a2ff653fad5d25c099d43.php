<div class="featured_blocks bx-def-bc-padding">
	<?php if(is_array($a['bx_repeat:list'])) for($i=0; $i<count($a['bx_repeat:list']); $i++){ ?>
		<div class="featured_block_1 bx-def-margin-sec-top"><?=$a['bx_repeat:list'][$i]['thumbnail'];?></div>
	<?php } else if(is_string($a['bx_repeat:list'])) echo $a['bx_repeat:list']; ?>
	<div class="clear_both"></div>
</div>