 <div class="fileUnit" id="view">
        <div class="navPanel bx-def-margin-sec-bottom">
            <div class="navPanelLink bx-def-font-large">
                Album: <a href="<?=$a['albumUri'];?>"><?=$a['albumCaption'];?></a>
            </div>
            <?php if($a['bx_if:prev']['condition']){ ?>
                <a href="<?=$a['bx_if:prev']['content']['linkPrev'];?>#view" title="<?=$a['bx_if:prev']['content']['titlePrev'];?>"><i class="navPanelLinkPrev sys-icon arrow-left"></i></a>
            <?php } ?>
            <?php if($a['bx_if:next']['condition']){ ?>
                <a href="<?=$a['bx_if:next']['content']['linkNext'];?>#view" title="<?=$a['bx_if:next']['content']['titleNext'];?>"><i class="navPanelLinkNext sys-icon arrow-right"></i></a>
            <?php } ?>
        </div>
        <div class="fileUnitPic">
            <img class="bx-def-round-corners bx-def-shadow" src="<?=$a['pic'];?>" class="fileUnitSpacer" onclick="lightroom(this)" />
        </div>
</div>
<div class="fileUnitInfo bx-def-margin-sec-top">
    <div class="fileUnitInfoRate">
        <?=$a['rate'];?>
    </div>
    <div class="fileUnitInfoCounts">
        <div class="fileUnitInfoFav">
            <i class="sys-icon asterisk" title="Favorited"></i>
            <?=$a['favInfo'];?>
        </div>
        <div class="fileUnitInfoView">
            <i class="sys-icon eye-open" title="Viewed"></i>
            <?=$a['viewInfo'];?>
        </div>
    </div>
    <div class="clear_both"></div>
</div>
<div class="fileTitle bx-def-margin-sec-top bx-def-font-h1">
    <?=$a['fileTitle'];?>
</div>
<div class="fileDescription bx-def-margin-sec-top bx-def-font-large">
    <?=$a['fileDescription'];?>
</div>
<script>
    function lightroom(e) {
        if ($('#lightroom').length) {
            $('#lightroom').remove();
            $('.lightroom-item').removeClass('lightroom-item');
        } else {
            $('body').append('<div id="lightroom"></div>');
            $(e).addClass('lightroom-item');
            $('#lightroom').click(lightroom);
        }
    }
</script>
