<div class="MsgBox" id="<?=$a['id'];?>">
    <table class="MsgBox bx-def-margin-top bx-def-margin-bottom"><tr><td>
        <div class="msgbox_content bx-def-font-large bx-def-padding-sec">
            <?=$a['msgText'];?>
        </div>
    </td></tr></table>
	<?php if($a['bx_if:timer']['condition']){ ?>
        <script type="text/javascript" language="javascript">
            setTimeout("$('#<?=$a['bx_if:timer']['content']['id'];?>').bx_anim('hide', 'fade', 'slow', function() { $(this).remove(); <?=$a['bx_if:timer']['content']['on_timer'];?> } )", <?=$a['bx_if:timer']['content']['time'];?>);
        </script>
    <?php } ?>
</div>
