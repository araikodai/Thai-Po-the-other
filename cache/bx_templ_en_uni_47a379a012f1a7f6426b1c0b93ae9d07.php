<div id="wall-event-<?=$a['post_id'];?>" class="wall-event bx-blog-wall-main">
    <a name="wall-blog-<?=$a['post_id'];?>"></a>
    <?=$this->parseSystemKey('post_owner_icon', $mixedKeyWrapperHtml);?>
    <div class="wall-event-cnt">
        <div class="wall-event-circle"><i class="sys-icon book"></i></div>
        <div class="wall-caption bx-blog-wall-caption">
            <span class="bx-blog-wall-caption-owner"><?=$a['cpt_user_name'];?></span> <?=$a['cpt_added_new'];?> <a class="bx-blog-wall-caption-link" href="<?=$a['cpt_item_url'];?>"><?=$a['cpt_object'];?></a>.&nbsp;
        </div>
        <div class="wall-content bx-blog-wall-content">
            <?=$a['unit'];?>
        </div>
        <div class="wall-comments bx-blog-wall-comments" id="wall-comment-<?=$a['post_id'];?>">
            <?=$this->parseSystemKey('comments_content', $mixedKeyWrapperHtml);?>
        </div>
    </div>
</div>
