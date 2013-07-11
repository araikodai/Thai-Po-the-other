<div class="actionsContainer">
    <div class="actionsBlock">
    	<table width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <?php if(is_array($a['bx_repeat:actions'])) for($i=0; $i<count($a['bx_repeat:actions']); $i++){ ?>
                <?=$a['bx_repeat:actions'][$i]['open_tag'];?>
                <td width="50%">
                    <?=$a['bx_repeat:actions'][$i]['action_link'];?>
                </td>
                <?=$a['bx_repeat:actions'][$i]['close_tag'];?>
            <?php } else if(is_string($a['bx_repeat:actions'])) echo $a['bx_repeat:actions']; ?>
        	</tbody>    
    	</table>
        <?=$a['responce_block'];?>
    </div>
</div>