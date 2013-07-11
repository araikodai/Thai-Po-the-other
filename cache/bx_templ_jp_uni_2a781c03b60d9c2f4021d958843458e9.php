<div class="prof_act_box bx-def-bc-padding bx-def-font-large">
    <div class="prof_act_message_status bx-def-margin-sec-bottom"><b><?=$a['message_status'];?></b></div>
	<div class="prof_act_message_info bx-def-margin-sec-bottom"><?=$a['message_info'];?></div>
	<?php if($a['bx_if:form']['condition']){ ?>
		<div class="prof_act_form"><?=$a['bx_if:form']['content']['form'];?></div>
	<?php } ?>
	<?php if($a['bx_if:next']['condition']){ ?>
		<div class="prof_act_continue">
            <b><a href="<?=$a['bx_if:next']['content']['next_url'];?>">Continue&nbsp;&gt;&gt;</a></b>
		</div>
	<?php } ?>
</div>
