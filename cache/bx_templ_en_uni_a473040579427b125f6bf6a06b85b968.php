<div id="cmts-box-<?=$a['html_id'];?>" class="cmts-box">
    <div class="top_settings_block">
    <div class="tsb_cnt_out bx-def-btc-margin-out">
        <div class="tsb_cnt_in bx-def-btc-padding-in">
            <?=$a['top_controls'];?>
        </div>
    </div>
</div>
    <div class="bx-def-bc-margin">

        <a name="cmta-<?=$a['html_id'];?>"></a>

        <div class="cmts"><?=$a['list'];?></div>

        <div class="cmt-show-more bx-def-margin-sec-top">
        <?php if($a['bx_if:show_paginate']['condition']){ ?>
            <?=$a['bx_if:show_paginate']['content']['content'];?>
        <?php } ?>
        </div>

        <?php if($a['bx_if:show_post']['condition']){ ?>
            <div class="cmt-reply bx-def-margin-sec-top"><?=$a['bx_if:show_post']['content']['content'];?></div>
        <?php } ?>

    </div>
    <?=$a['js_code'];?>
</div>
