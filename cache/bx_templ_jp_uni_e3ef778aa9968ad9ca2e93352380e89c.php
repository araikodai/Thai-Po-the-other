<div class="communicator_fr_container bx-def-bc-margin">
    <?php if(is_array($a['bx_repeat:rows'])) for($i=0; $i<count($a['bx_repeat:rows']); $i++){ ?>
        <div class="sys-connections-fr bx-def-margin-sec-top">
            <div class="sys-cntsfr-author-icon">
                <?=$a['bx_repeat:rows'][$i]['member_icon'];?>
            </div>
            <div class="sys-cntsfr-info">
                <div class="sys-cntsfr-author-info"><?=$a['bx_repeat:rows'][$i]['member_location'];?></div>
                <div class="bx-def-font-small bx-def-font-grayed"><?=$a['bx_repeat:rows'][$i]['member_mutual_friends'];?></div>
                <div class="sys-cntsfr-actions">
                    <button class="bx-btn bx-btn-small" onclick="javascript: if(typeof <?=$a['bx_repeat:rows'][$i]['js_object'];?> != 'undefined') <?=$a['bx_repeat:rows'][$i]['js_object'];?>.sendAction('communicator_fr_container', 'accept_friends_request', 'getProcessingRows', <?=$a['bx_repeat:rows'][$i]['row_value'];?>, false)">
                        Accept
                    </button>
                    <button class="bx-btn bx-btn-small" onclick="javascript: if(typeof <?=$a['bx_repeat:rows'][$i]['js_object'];?> != 'undefined') <?=$a['bx_repeat:rows'][$i]['js_object'];?>.sendAction('communicator_fr_container', 'reject_friends_request', 'getProcessingRows', <?=$a['bx_repeat:rows'][$i]['row_value'];?>)">
                        Reject
                    </button>
                    <div class="clear_both"></div>
                </div>
            </div>
        </div>
    <?php } else if(is_string($a['bx_repeat:rows'])) echo $a['bx_repeat:rows']; ?>
</div>
<?=$a['page_pagination'];?>