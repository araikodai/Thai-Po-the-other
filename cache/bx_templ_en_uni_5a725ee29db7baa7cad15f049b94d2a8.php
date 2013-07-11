<div class="actionsContainer actionsContainerSubmenu">
	<?php if(is_array($a['bx_repeat:actions'])) for($i=0; $i<count($a['bx_repeat:actions']); $i++){ ?>
        <?=$a['bx_repeat:actions'][$i]['action_link'];?>
    <?php } else if(is_string($a['bx_repeat:actions'])) echo $a['bx_repeat:actions']; ?>
</div>