<div class="bx-twig-unit bx_events_unit bx-def-margin-top-auto">

    <div class="bx-twig-unit-thumb-cont bx-def-margin-sec-right">
        <a href="<?=$a['event_url'];?>"><img class="bx-twig-unit-thumb bx-def-round-corners bx-def-shadow" src="<?=$a['thumb_url'];?>"></a>
    </div>

    <div class="bx-twig-unit-info">

        <div class="bx-twig-unit-title bx-def-font-h2">
            <a href="<?=$a['event_url'];?>"><?=$a['event_title'];?></a>
        </div>

        <div class="bx-twig-unit-line bx-twig-unit-desc"><?=$a['snippet_text'];?></div>

        <div class="bx-twig-unit-line bx-twig-unit-special"><?=$a['event_start'];?></div>

        <div class="bx-twig-unit-line"><?=$a['country_city'];?></div>

        <div class="bx-twig-unit-line bx_events_unit_participants"><i class="sys-icon user bx-def-font-grayed"></i><b><?=$a['participants'];?></b></div>

        <?php if($a['bx_if:full']['condition']){ ?>

            <div class="bx-twig-unit-line bx-twig-unit-rate"><?=$a['bx_if:full']['content']['rate'];?></div>
        
            <div class="bx-twig-unit-line bx-def-font-small bx-def-font-grayed">
                From <a href="<?=$a['bx_if:full']['content']['author_url'];?>"><?=$a['bx_if:full']['content']['author'];?></a>
            </div>                    

        <?php } ?>

    </div>    

</div>
