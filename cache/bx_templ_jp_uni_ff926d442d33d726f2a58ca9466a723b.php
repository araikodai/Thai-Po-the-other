<select name="new_album">
    <?php if(is_array($a['bx_repeat:choose'])) for($i=0; $i<count($a['bx_repeat:choose']); $i++){ ?>
        <option value="<?=$a['bx_repeat:choose'][$i]['album_id'];?>"><?=$a['bx_repeat:choose'][$i]['album_caption'];?></option>
    <?php } else if(is_string($a['bx_repeat:choose'])) echo $a['bx_repeat:choose']; ?>
</select>