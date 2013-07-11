<div id="wall-event-<?=$a['post_id'];?>" class="wall-event">
    <?=$this->parseSystemKey('post_owner_icon', $mixedKeyWrapperHtml);?>
    <div class="wall-event-cnt">
        <div class="wall-event-circle"><i class="sys-icon edit"></i></div>
        <div class="wall-caption">
            <span class="wall-caption-owner"><?=$a['cpt_user_name'];?></span> <?=$a['cpt_edited_profile_status_message'];?>&nbsp;
        </div>
        <div class="wall-content status-message"><?=$a['cnt_status_message'];?></div>
        <div class="wall-comments" id="wall-comment-<?=$a['post_id'];?>">
            <?=$this->parseSystemKey('comments_content', $mixedKeyWrapperHtml);?>
        </div>
    </div>
</div>
