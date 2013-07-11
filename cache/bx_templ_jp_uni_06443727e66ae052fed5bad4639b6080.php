<div class="ordered_block">
	<?=$a['sort_block'];?>
	<?php if($a['bx_if:show_with_photos']['condition']){ ?>
		&nbsp;
		<input type="checkbox" <?=$a['bx_if:show_with_photos']['content']['photo_checked'];?> name="photos_only" value="on" onclick="oBrowsePage.LocationChange(this, '<?=$a['bx_if:show_with_photos']['content']['photo_location'];?>')" />
		<?=$a['bx_if:show_with_photos']['content']['photo_caption'];?>
	<?php } ?>
	&nbsp;
	<input type="checkbox" <?=$a['online_checked'];?> name="online_only" value="on" onclick="oBrowsePage.LocationChange(this, '<?=$a['online_location'];?>')"/>
	<?=$a['online_caption'];?>
</div>
<div class="per_page_block">
	<?=$a['per_page_block'];?>
</div>
<div class="clear_both"></div>