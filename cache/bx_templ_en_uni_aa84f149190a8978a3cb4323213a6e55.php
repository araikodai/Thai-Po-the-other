<div class="mbp-current-level">
    <div class="mbp-level">
        <div class="mbp-level-icon" style="background-image:url(<?=$a['icon'];?>);">
            <img src="http://www.thaipo.org/templates/base/images/spacer.gif" />
        </div>
        <div class="mbp-level-content">
            <div class="mbp-level-title">
                <a href="javascript: void(0)" onclick="javascript: loadHtmlInPopup('explanation_popup', 'http://www.thaipo.org/explanation.php?explain=membership&type=<?=$a['id'];?>');"><?=$a['title'];?></a>
            </div>                
            <div class="mbp-level-info"><?=$a['expires'];?></div>
        </div>
        <div class="mbp-level-description"><?=$a['description'];?></div>
    </div>
</div>
