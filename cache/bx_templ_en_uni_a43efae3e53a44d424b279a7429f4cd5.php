<div class="feedback-entry-divider bx-def-hr bx-def-margin-sec-topbottom"></div>
<div id="<?=$a['id'];?>" class="feedback-entry">
    <?php if($a['bx_if:checkbox']['condition']){ ?>
        <div class="feedback-checkbox">
            <input type="checkbox" name="feedback-ids[]" value="<?=$a['bx_if:checkbox']['content']['id'];?>" />
        </div>
    <?php } ?>
    <?=$a['author_icon'];?>
    <div class="feedback-info">
        <div class="feedback-caption bx-def-font-h2">
            <a class="feedback-caption bx-def-font-h2" href="<?=$a['link'];?>"><?=$a['caption'];?></a>
        </div>
        <div class="feedback-text<?=$a['class'];?> bx-def-font-large bx-def-margin-sec-top"><?=$a['content'];?></div>
        <div class="feedback-date bx-def-margin-sec-top">
            <a class="feedback-author" href="<?=$a['author_url'];?>"><?=$a['author_username'];?></a>
            <span class="bullet">&#183;</span>
            <span class="feedback-date bx-def-font-small bx-def-font-grayed"><?=$a['date'];?></span>
            <?php if($a['bx_if:status']['condition']){ ?>
                <span class="bullet">&#183;</span>
                <span class="feedback-status bx-def-font-small bx-def-font-grayed"><?=$a['bx_if:status']['content']['status'];?></span>
            <?php } ?>
            <?php if($a['bx_if:edit_link']['condition']){ ?>
                <span class="bullet">&#183;</span>
                <a class="feedback-action bx-def-font-small" href="<?=$a['bx_if:edit_link']['content']['edit_link_url'];?>"><?=$a['bx_if:edit_link']['content']['edit_link_caption'];?></a>
            <?php } ?>
        </div>
    </div>
    <div class="feedback-cb">&nbsp;</div>
</div>