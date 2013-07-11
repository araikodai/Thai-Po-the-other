<div class="bx-def-bc-padding">

    <div id="<?=$a['prefix'];?>-gallery" class="bx-gallery">

        <div class="bx-gallery-icons bx-def-margin-sec-bottom">            
            <div class="bx-gallery-icons-rails">
                <?php if(is_array($a['bx_repeat:icons'])) for($i=0; $i<count($a['bx_repeat:icons']); $i++){ ?><img class="bx-gallery-icon" title="<?=$a['bx_repeat:icons'][$i]['title'];?>" alt="_<?=$a['bx_repeat:icons'][$i]['title'];?>" src="<?=$a['bx_repeat:icons'][$i]['icon_url'];?>" id="bx-gallery-icon-<?=$a['bx_repeat:icons'][$i]['id'];?>" /><?php } else if(is_string($a['bx_repeat:icons'])) echo $a['bx_repeat:icons']; ?>
            </div>
            <div class="bx-gallery-icon-selector"></div>
        </div>

        <div id="<?=$a['prefix'];?>-gallery-imgs" class="bx-gallery-imgs">
            <?php if(is_array($a['bx_repeat:images'])) for($i=0; $i<count($a['bx_repeat:images']); $i++){ ?>
                <div class="bx-gallery-img-cont" data-img="<?=$a['bx_repeat:images'][$i]['image_url'];?>" data-icon="<?=$a['bx_repeat:images'][$i]['icon_url'];?>" id="bx-gallery-img-cont-<?=$a['bx_repeat:images'][$i]['id'];?>">
                    <div class="bx-gallery-img-title bx-def-font-large bx-def-round-corners"><?=$a['bx_repeat:images'][$i]['title'];?></div>
                    <img class="bx-gallery-img bx-def-shadow bx-def-round-corners" title="<?=$a['bx_repeat:images'][$i]['title'];?>" alt="<?=$a['bx_repeat:images'][$i]['title'];?>" src="<?=$a['bx_repeat:images'][$i]['image_url'];?>" id="bx-gallery-img-<?=$a['bx_repeat:images'][$i]['id'];?>" />
                </div>
            <?php } else if(is_string($a['bx_repeat:images'])) echo $a['bx_repeat:images']; ?>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#<?=$a['prefix'];?>-gallery').dolGalleryImages();
        });
    </script>

</div>
