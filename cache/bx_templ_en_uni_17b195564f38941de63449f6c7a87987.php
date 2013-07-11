<script type="text/javascript">
    var oShoutBox = new BxShoutBox();
    oShoutBox.oMessages.empty_message = '<?=$a['message_empty_message'];?>';
    oShoutBox.sPageReceiver  = '<?=$a['module_path'];?>';
    oShoutBox.iUpdateTime    = <?=$a['update_time'];?>;
    oShoutBox.iLastMessageId = <?=$a['last_message_id'];?>;
    oShoutBox.sWaitMessage   = '<?=$a['wait_cpt'];?>';	

    $('#shoutbox_msg_field').parent().addClass('shoutbox_send_field');

    var elShoutbox = $('.' + oShoutBox.sMessagesContainer);
    if(elShoutbox) {
        var iBoxPadding = 20;
        var iShoutboxParentWidth = elShoutbox.parents('.form_advanced_wrapper').width();
        elShoutbox.css('width', iShoutboxParentWidth - iBoxPadding);
    }

    oShoutBox.scrollContent();

    $(document).ready(function () {
        oShoutBox.getMessages();
    });
</script>