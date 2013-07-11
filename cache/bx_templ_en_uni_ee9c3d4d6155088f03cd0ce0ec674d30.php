<div id="wall-event-<?=$a['post_id'];?>" class="wall-event bx_photos-wall-event">
    <a name="wall-photo-<?=$a['post_id'];?>"></a>
    <?=$this->parseSystemKey('post_owner_icon', $mixedKeyWrapperHtml);?>
    <div class="wall-event-cnt">
        <div class="wall-event-circle">
        	<i class="sys-icon comment-alt"></i>
        </div>
        <div class="wall-caption bx_photos-wall-caption">
            <span class="bx_photos-wall-caption-owner"><?=$a['cpt_user_name'];?></span> <?=$a['cpt_added_new'];?> <a class="bx_photos-wall-caption-link" href="<?=$a['cpt_item_url'];?>"><?=$a['cpt_object'];?></a>.&nbsp;
        </div>
        <div class="wall-content bx_photos-wall-content bx-def-margin-sec-bottom"><?=$a['cnt_comment_text'];?></div>
        <div class="wall-snippet bx_photos-wall-snippet">
            <div class="wall-thumbnail bx_photos-wall-thumbnail bx-def-shadow bx-def-round-corners">
                <a href="<?=$a['cnt_item_page'];?>"><img src="<?=$a['cnt_item_icon'];?>" title="<?=$a['cnt_item_title'];?>" alt="<?=$a['cnt_item_title'];?>" /></a>
            </div>
            <div class="wall-info bx_photos-wall-info bx-def-margin-sec-left">
                <div class="wall-title bx_photos-wall-title">
                    <a href="<?=$a['cnt_item_page'];?>"><?=$a['cnt_item_title'];?></a>
                </div>
                <div class="wall-description bx_photos-wall-description bx-def-font-small"><?=$a['cnt_item_description'];?></div>
            </div>
            <div class="wall-clear">&nbsp;</div>
        </div>
        <div class="wall-comments bx_photos-wall-comments" id="wall-comment-<?=$a['post_id'];?>">
            <?=$this->parseSystemKey('comments_content', $mixedKeyWrapperHtml);?>
        </div>
    </div>
</div>