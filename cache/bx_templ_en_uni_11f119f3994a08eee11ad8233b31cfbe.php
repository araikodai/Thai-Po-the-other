<div id="wall-event-<?=$a['post_id'];?>" class="wall-event">
    <?=$this->parseSystemKey('post_owner_icon', $mixedKeyWrapperHtml);?>
    <div class="wall-event-cnt">
        <div class="wall-event-circle"><i class="sys-icon user"></i></div>
        <div class="wall-caption">
            <span class="wall-caption-owner"><?=$a['cpt_user_name'];?></span> is now friends with <a class="wall-caption-link wall-cl-bold" href="<?=$a['cpt_friend_url'];?>"><?=$a['cpt_friend_name'];?></a>.&nbsp;
        </div>
        <div class="wall-content friend-info"><?=$a['cnt_friend'];?></div>
        <div class="wall-comments" id="wall-comment-<?=$a['post_id'];?>">
            <?=$this->parseSystemKey('comments_content', $mixedKeyWrapperHtml);?>
        </div>
    </div>
</div>
