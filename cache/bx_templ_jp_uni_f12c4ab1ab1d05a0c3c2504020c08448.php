<script type="text/javascript">
    var <?=$a['js_object'];?> = new CommunicatorPage();
    <?=$a['js_object'];?>.sPageReceiver     = '<?=$a['current_page'];?>?ajax_mode=true';
    <?=$a['js_object'];?>.sCommunicatorMode = '<?=$a['communicator_mode'];?>';
    <?=$a['js_object'];?>.sPersonMode       = '<?=$a['communicator_person_mode'];?>';
    <?=$a['js_object'];?>.sErrorMessage     = '<?=$a['error_message'];?>';
    <?=$a['js_object'];?>.sSureCaption      = '<?=$a['sure_message'];?>';
</script>
<div id="rows_content">
    <?=$a['page_content'];?>
</div>