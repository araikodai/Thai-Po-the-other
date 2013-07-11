<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
	<head>
		<title><?=$this->parseSystemKey('page_header', $mixedKeyWrapperHtml);?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$this->parseSystemKey('page_charset', $mixedKeyWrapperHtml);?>" />
		<bx_include_css />
		<bx_include_js />

		<?=$this->parseSystemKey('dol_images', $mixedKeyWrapperHtml);?>
        <?=$this->parseSystemKey('dol_lang', $mixedKeyWrapperHtml);?>
        <?=$this->parseSystemKey('dol_options', $mixedKeyWrapperHtml);?>

		<script defer type="text/javascript">
			var site_url = 'http://www.thaipo.org/';
			var aUserInfoTimers = new Array();
			var glUserInfoDisabled = 'yes';
    		$(document).ready( function() {
			    $( 'div.RSSAggrCont' ).dolRSSFeed();
		    } );
        </script>
		
        <?=$this->parseSystemKey('extra_js', $mixedKeyWrapperHtml);?>

	   <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_head'); ?>
    </head>
    <body <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_body'); ?> class="bx-def-font">
        <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_header'); ?>
        <div id="FloatDesc"></div>
