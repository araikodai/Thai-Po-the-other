<div class="sys_file_search_pic bx_photos_file_search_pic" style="background-image: url('<?=$a['imgUrl'];?>');">
    <?php if($a['bx_if:admin']['condition']){ ?>
        <div class="bx_sys_unit_checkbox">
            <input type="checkbox" name="entry[]" value="<?=$a['bx_if:admin']['content']['id'];?>"/>
        </div>
    <?php } ?>
    <a href="<?=$a['fileLink'];?>"><img src="<?=$a['spacer'];?>"></a>
</div>