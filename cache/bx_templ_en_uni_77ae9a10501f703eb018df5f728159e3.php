<div class="message_block">
    <div class="icon_block"><?=$a['owner_icon'];?></div>
    <div class="content">
        <?php if($a['bx_if:delete_allowed']['condition']){ ?>
	        <a class="act" href="javascript:void(0)" title="<?=$a['bx_if:delete_allowed']['content']['delete_cpt'];?>" onclick="if( confirm('<?=$a['bx_if:delete_allowed']['content']['sure_cpt'];?>') ){oShoutBox.deleteMessage(<?=$a['bx_if:delete_allowed']['content']['message_id'];?>, this)}">
	            <i class="sys-icon remove"></i>
	        </a>
        <?php } ?>
        <?php if($a['bx_if:block_allowed']['condition']){ ?>
	        <a class="act" href="javascript:void(0)" title="<?=$a['bx_if:block_allowed']['content']['block_cpt'];?>" onclick="if( confirm('<?=$a['bx_if:block_allowed']['content']['sure_cpt'];?>') ){oShoutBox.blockMessage(<?=$a['bx_if:block_allowed']['content']['message_id'];?>)}">
	            <i class="sys-icon ban-circle"></i>
	        </a>
        <?php } ?>
        <span class="date bx-def-font-small bx-def-font-grayed"><?=$a['date'];?></span>
    </div>
    <div class="content"><span class="by bx-def-font-small bx-def-font-grayed"><?=$a['by'];?></span> <a href="<?=$a['owner_link'];?>"><?=$a['owner_nick'];?></a></div>
    <div class="content"><?=$a['message'];?></div>
    <div class="clear_both"></div>
</div>
