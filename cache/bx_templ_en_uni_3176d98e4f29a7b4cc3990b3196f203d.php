<iframe id="adm-mp-members-iframe" name="adm-mp-members-iframe"></iframe>
<form id="adm-mp-members-form" enctype="multipart/form-data" method="post" action="<?=$a['action_url'];?>" class="form_advanced" target="adm-mp-members-iframe">
    <input type="hidden" name="adm-mp-members-ctl-type" value="<?=$a['ctl_type'];?>" />
    <input type="hidden" name="adm-mp-members-view-type" value="<?=$a['view_type'];?>" />
    <div class="top_settings_block">
    <div class="tsb_cnt_out bx-def-btc-margin-out">
        <div class="tsb_cnt_in bx-def-btc-padding-in">
            <?=$a['top_controls'];?>
        </div>
    </div>
</div>
    <div class="adm-mp-members-wrapper" id="adm-mp-members-simple" style="<?=$a['style_simple'];?>"><?=$a['content_simple'];?></div>
    <div class="adm-mp-members-wrapper" id="adm-mp-members-extended" style="<?=$a['style_extended'];?>"><?=$a['content_extended'];?></div>
    <div class="adm-mp-members-wrapper" id="adm-mp-members-geeky" style="<?=$a['style_geeky'];?>"><?=$a['content_geeky'];?></div>
    <?=$a['loading'];?>
</form>