<div class="admin_actions_panel">
    <?php if($a['bx_if:selectAll']['condition']){ ?>
        <div class="bx-def-padding-left">
            <input id="admin-actions-select-all-<?=$a['bx_if:selectAll']['content']['wrapperId'];?>" class="admin-actions-select-all" type="checkbox" onclick="$('#<?=$a['bx_if:selectAll']['content']['wrapperId'];?> input[name=\'<?=$a['bx_if:selectAll']['content']['checkboxName'];?>[]\']:enabled').attr('checked', this.checked)"  <?=$a['bx_if:selectAll']['content']['checked'];?> />
            <label for="admin-actions-select-all-<?=$a['bx_if:selectAll']['content']['wrapperId'];?>">Select all</label>
        </div>
    <?php } ?>
    <?php if($a['bx_if:actionButtons']['condition']){ ?>
        <div class="bx-def-padding-left">
            <?php if(is_array($a['bx_if:actionButtons']['content']['bx_repeat:buttons'])) for($i=0; $i<count($a['bx_if:actionButtons']['content']['bx_repeat:buttons']); $i++){ ?>
                <button class="bx-btn bx-btn-small" type="<?=$a['bx_if:actionButtons']['content']['bx_repeat:buttons'][$i]['type'];?>" name="<?=$a['bx_if:actionButtons']['content']['bx_repeat:buttons'][$i]['name'];?>" value="<?=$a['bx_if:actionButtons']['content']['bx_repeat:buttons'][$i]['value'];?>" <?=$a['bx_if:actionButtons']['content']['bx_repeat:buttons'][$i]['onclick'];?> ><?=$a['bx_if:actionButtons']['content']['bx_repeat:buttons'][$i]['value'];?></button>
            <?php } else if(is_string($a['bx_if:actionButtons']['content']['bx_repeat:buttons'])) echo $a['bx_if:actionButtons']['content']['bx_repeat:buttons']; ?>
        </div>
    <?php } ?>
    <?php if($a['bx_if:customHTML']['condition']){ ?>
        <div class="bx-def-padding-left"><?=$a['bx_if:customHTML']['content']['custom_HTML'];?></div>
    <?php } ?>
    <div class="clear_both"></div>
</div>
