<div class="thumbnail_block <?=$a['classes_add'];?>" style="float:<?=$a['sys_thb_float'];?>;">

	<div class="thumbnail_image" onmouseover="javascript:startUserInfoTimer(<?=$a['iProfId'];?>, this)" onmouseout="javascript:stopUserInfoTimer(<?=$a['iProfId'];?>)">
		<a href="<?=$a['usr_profile_url'];?>" title="<?=$a['usr_thumb_title0'];?>">
            <img src="http://www.thaipo.org/templates/base/images/spacer.gif" style="background-image:url(<?=$a['usr_thumb_url0'];?>);" class="thumbnail_image_file bx-def-shadow bx-def-round-corners" />
            <i class="sys-online-offline sys-icon <?=$a['sys_status_icon'];?>" title="<?=$a['sys_status_title'];?>"></i>
		</a>
	</div>	

<?php if($a['bx_if:profileLink']['condition']){ ?>
    <div class="thumb_username">
        <a class="bx-def-font-large" href="<?=$a['bx_if:profileLink']['content']['usr_profile_url'];?>"><?=$a['bx_if:profileLink']['content']['user_title'];?></a>
        <br />
        <i class="bx-def-font-small bx-def-font-grayed"><?=$a['bx_if:profileLink']['content']['user_info'];?></i>
    </div>
<?php } ?>

    <div class="clear_both"></div>

</div>
