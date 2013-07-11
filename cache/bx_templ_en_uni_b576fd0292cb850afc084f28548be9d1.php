
<?php if($a['bx_if:icon']['condition']){ ?>
    <button class="bx-btn bx-btn-img bx-btn-small" <?=$a['bx_if:icon']['content']['action'];?>>
        <u style="background-image:url(<?=$a['bx_if:icon']['content']['picture'];?>)"><?=$a['bx_if:icon']['content']['caption'];?></u>
    </button>
<?php } ?>
<?php if($a['bx_if:texticon']['condition']){ ?>
    <button class="bx-btn bx-btn-img bx-btn-small bx-btn-ifont" <?=$a['bx_if:texticon']['content']['action'];?>>
        <i class="sys-icon <?=$a['bx_if:texticon']['content']['picture'];?>"></i><?=$a['bx_if:texticon']['content']['caption'];?>
    </button>
<?php } ?>

