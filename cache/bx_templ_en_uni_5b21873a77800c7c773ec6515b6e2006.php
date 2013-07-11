<script type="text/javascript">
	var sContacts_mode  = '<?=$a['contacts_mode'];?>';
	var iMessageId		= <?=$a['message_id'];?>;

	// create the object;
	oMailBoxArchive = new MailBoxArchive();
</script>
<div class="contacts_container contacts_container_archive bx-def-margin">
	<?php if(is_array($a['bx_repeat:messages'])) for($i=0; $i<count($a['bx_repeat:messages']); $i++){ ?>
        <div class="sys-mailbox-contact bx-def-margin-sec-top">
            <div class="sys-mbc-author">
                <div class="sys-mbc-checkbox">
                    <input type="checkbox" name="messages[]" value="<?=$a['bx_repeat:messages'][$i]['message_id'];?>" owner="<?=$a['bx_repeat:messages'][$i]['message_owner'];?>" >
                </div>
                <?=$a['bx_repeat:messages'][$i]['member_icon'];?>
            </div>
            <div class="sys-mbc-info">
                <div class="sys-mbc-author-info">
                    <b><?=$a['bx_repeat:messages'][$i]['message_subject'];?></b>
                </div>
                <div class="sys-mbc-actions">
                    <?=$a['bx_repeat:messages'][$i]['message_date'];?>
                </div>
            </div>
        </div>
    <?php } else if(is_string($a['bx_repeat:messages'])) echo $a['bx_repeat:messages']; ?>
</div>