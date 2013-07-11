<div id="wall-event-<?=$a['post_id'];?>" class="wall-event bx-groups-wall-event">
    <a name="wall-groups-<?=$a['post_id'];?>"></a>
    <?=$this->parseSystemKey('post_owner_icon', $mixedKeyWrapperHtml);?>
    <div class="wall-event-cnt">
        <div class="wall-event-circle"><i class="sys-icon comment-alt"></i></div>
        <div class="wall-caption bx-groups-wall-caption">
            <span class="bx-groups-wall-caption-owner"><?=$a['cpt_user_name'];?></span> <?=$a['cpt_added_new'];?> <a class="bx-groups-wall-caption-link" href="<?=$a['cpt_item_url'];?>"><?=$a['cpt_object'];?></a>.&nbsp;
        </div>
        <div class="wall-content bx-groups-wall-content bx-def-margin-sec-bottom"><?=$a['cnt_comment_text'];?></div>
        <div class="wall-snippet bx-groups-wall-snippet">
            <?=$a['unit'];?>
        </div>
        <div class="wall-comments bx-groups-wall-comments" id="wall-comment-<?=$a['post_id'];?>">
            <?=$this->parseSystemKey('comments_content', $mixedKeyWrapperHtml);?>
        </div>
    </div>
</div>
