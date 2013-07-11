<div id="wall-event-<?=$a['post_id'];?>" class="wall-event bx-ava-wall-event">
    <a name="wall-ava-<?=$a['post_id'];?>"></a>
    <?=$this->parseSystemKey('post_owner_icon', $mixedKeyWrapperHtml);?>
    <div class="wall-event-cnt">
        <div class="wall-event-circle"><i class="sys-icon user"></i></div>
        <div class="wall-caption bx-ava-wall-caption">
            <span class="bx-ava-wall-caption-owner"><?=$a['cpt_user_name'];?></span> <?=$a['cpt_added_new'];?> <?=$a['cpt_object'];?>
        </div>
        <div class="wall-comments bx-ava-wall-comments" id="wall-comment-<?=$a['post_id'];?>">
            <?=$this->parseSystemKey('comments_content', $mixedKeyWrapperHtml);?>
        </div>
    </div>
</div>
