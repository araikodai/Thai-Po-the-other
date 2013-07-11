<div id="wall-event-<?=$a['post_id'];?>" class="wall-event bx-events-wall-event">
    <a name="wall-events-<?=$a['post_id'];?>"></a>
    <?=$this->parseSystemKey('post_owner_icon', $mixedKeyWrapperHtml);?>
    <div class="wall-event-cnt">
        <div class="wall-event-circle"><i class="sys-icon calendar"></i></div>
        <div class="wall-caption bx-events-wall-caption">
            <span class="bx-events-wall-caption-owner"><?=$a['cpt_user_name'];?></span> <?=$a['cpt_added_new'];?> <a class="bx-events-wall-caption-link" href="<?=$a['cpt_item_url'];?>"><?=$a['cpt_object'];?></a>.&nbsp;
        </div>
        <div class="wall-content bx-events-wall-content">
            <?=$a['unit'];?>
        </div>
        <div class="wall-comments bx-events-wall-comments" id="wall-comment-<?=$a['post_id'];?>">
            <?=$this->parseSystemKey('comments_content', $mixedKeyWrapperHtml);?>
        </div>
    </div>
</div>
