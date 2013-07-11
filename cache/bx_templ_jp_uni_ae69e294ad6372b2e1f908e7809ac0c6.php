<div class="communicator_container bx-def-bc-margin">
    <?php if(is_array($a['bx_repeat:rows'])) for($i=0; $i<count($a['bx_repeat:rows']); $i++){ ?>
        <div class="sys-connections-row">
            <div class="sys-cntsr-cnt">            
                <div class="sys-cntsr-author-icon">
                    <div class="sys-cntsr-checkbox">
                        <input type="checkbox" name="rows[]" value="<?=$a['bx_repeat:rows'][$i]['row_value'];?>" />
                    </div>
                    <?=$a['bx_repeat:rows'][$i]['member_icon'];?>
                    <div class="clear_both"></div>
                </div>
            </div>
        </div>
    <?php } else if(is_string($a['bx_repeat:rows'])) echo $a['bx_repeat:rows']; ?>
    <div class="sys-connections-actions bx-def-padding-sec">
        <div class="sys-cntsa-left">
            <?=$a['select'];?>: 
            <a href="<?=$a['current_page'];?>" onclick="<?=$a['js_object'];?>.selectCheckBoxes(true, 'communicator_container');return false"><?=$a['all_messages'];?></a> 
            <span class="bullet">&#183;</span> 
            <a href="<?=$a['current_page'];?>" onclick="<?=$a['js_object'];?>.selectCheckBoxes(false, 'communicator_container');return false"><?=$a['none_messages'];?></a>
        </div>
        <div class="sys-cntsa-right">
            <?=$a['actions_list'];?>
        </div>
        <div class="clear_both"></div>
    </div>
</div>
<?=$a['page_pagination'];?>
