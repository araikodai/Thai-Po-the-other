<div class="adm-mp-members-simple bx-def-bc-margin-thd">
    <?php if(is_array($a['bx_repeat:items'])) for($i=0; $i<count($a['bx_repeat:items']); $i++){ ?>
        <div class="adm-mp-member-simple">
            <div class="adm-mp-ms-check">
                <input type="checkbox" class="form_input_checkbox" id="adm-mp-<?=$a['bx_repeat:items'][$i]['id'];?>" name="members[]" value="<?=$a['bx_repeat:items'][$i]['id'];?>" />
            </div>
            <div class="adm-mp-ms-thumbnail"><?=$a['bx_repeat:items'][$i]['thumbnail'];?></div>
            <div class="adm-mp-ms-info">
        		<div class="adm-mp-msi-username">
                    <a href="<?=$a['bx_repeat:items'][$i]['edit_link'];?>" class="<?=$a['bx_repeat:items'][$i]['edit_class'];?>"><?=$a['bx_repeat:items'][$i]['username'];?></a>
                </div>
                <div class="adm-mp-msi-info bx-def-font-small bx-def-font-grayed">
                    <?=$a['bx_repeat:items'][$i]['info'];?>
        		</div>
			</div>
        </div>
    <?php } else if(is_string($a['bx_repeat:items'])) echo $a['bx_repeat:items']; ?>
    <div class="clear_both">&nbsp;</div>
</div>
<?=$a['paginate'];?>
<?=$a['control'];?>