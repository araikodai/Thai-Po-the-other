<?=$a['per_page_caption'];?>&nbsp;
<select name="per_page" onchange="<?=$a['per_page_on_change'];?>">
    <?php if(is_array($a['bx_repeat:options'])) for($i=0; $i<count($a['bx_repeat:options']); $i++){ ?>
        <option value="<?=$a['bx_repeat:options'][$i]['opt_value'];?>" <?=$a['bx_repeat:options'][$i]['opt_selected'];?>><?=$a['bx_repeat:options'][$i]['opt_caption'];?></option>
    <?php } else if(is_string($a['bx_repeat:options'])) echo $a['bx_repeat:options']; ?>
</select>