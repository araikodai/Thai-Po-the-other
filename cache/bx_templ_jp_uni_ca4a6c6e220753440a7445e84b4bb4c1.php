<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?=$this->parseSystemKey('page_charset', $mixedKeyWrapperHtml);?>" />
	<title><?=$this->parseSystemKey('page_header', $mixedKeyWrapperHtml);?></title>
	<base href="http://www.thaipo.org/" />	
	<?=$this->parseSystemKey('page_description', $mixedKeyWrapperHtml);?>
	<?=$this->parseSystemKey('page_keywords', $mixedKeyWrapperHtml);?>
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<bx_include_css />
	<bx_include_js />
    <?=$this->parseSystemKey('dol_images', $mixedKeyWrapperHtml);?>
    <?=$this->parseSystemKey('dol_lang', $mixedKeyWrapperHtml);?>
    <?=$this->parseSystemKey('dol_options', $mixedKeyWrapperHtml);?>
    <script type="text/javascript" language="javascript">
		var site_url = 'http://www.thaipo.org/';
        var aUserInfoTimers = new Array();
		$(document).ready( function() {
			$( 'div.RSSAggrCont' ).dolRSSFeed();
		} );
	</script>
    <?=$this->parseSystemKey('extra_js', $mixedKeyWrapperHtml);?>
	<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_head'); ?>
    <script type="text/javascript">
        var oBxUserStatus = new BxUserStatus();
        oBxUserStatus.userStatusInit('http://www.thaipo.org/', <?=$this->parseSystemKey('is_profile_page', $mixedKeyWrapperHtml);?>);
    </script>
</head>
<?=$this->parseSystemKey('flush_header', $mixedKeyWrapperHtml);?>
<body <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_body'); ?> class="bx-def-font">
    <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_header'); ?>
    <div id="notification_window" class="notifi_window"></div>
	<div id="FloatDesc" style="position:absolute;display:none;z-index:100;"></div>
