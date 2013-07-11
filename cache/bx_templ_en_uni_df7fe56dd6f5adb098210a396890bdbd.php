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

        <div class="adm-header">
        	<div class="adm-header-content">
            	<div class="adm-header-title bx-def-margin-sec-left">
            		<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_logo_before'); ?>
                    <img class="adm-header-logo" src="http://www.thaipo.org/administration/templates/base/images/logo.png" />
            		<div class="adm-header-text bx-def-font-h1">Dolphin <span><?=$this->parseSystemKey('version', $mixedKeyWrapperHtml);?></span></div>
            		<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_logo_after'); ?>
                    <div class="adm-header-update bx-def-margin-sec-left" id="adm-header-update"></div>
                    <div class="clear_both">&nbsp;</div>
                    <script language="javascript" type="text/javascript">
                    <!--
                        $(document).ready(function() {
                            $.get(
                                'http://www.thaipo.org/get_rss_feed.php?ID=boonex_version&member=0', 
                                {},
                                function(sData) {
                                	if(!sData)
                                	    return;

                                    var sVerCur = '<?=$this->parseSystemKey('current_version', $mixedKeyWrapperHtml);?>';
                                    var sVerNew = $(sData).find('dolphin').html(); 
                                    if(sVerNew != undefined && sVerNew != null && sVerNew != '' && sVerNew != sVerCur)
                                        $('#adm-header-update').html('<a href="http://www.boonex.com/dolphin/download/">Update to ' + sVerNew + ' now!</a>');
                                },
                                'text'
                            );
                        });
                    -->
                    </script>
            	</div>
            	<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_top_menu_before'); ?>
            	<?=$this->parseSystemKey('top_menu', $mixedKeyWrapperHtml);?>
            	<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_top_menu_after'); ?>
            	<div class="clear_both">&nbsp;</div>
            </div>
        </div>
        <div class="adm-middle">
            <div class="adm-middle-center">
                <div class="adm-middle-cnt bx-def-margin-sec-leftright">
            		<table class="adm-middle" cellpadding="0" cellspacing="0">
            			<tr>
            				<td class="adm-middle-menu">
            					<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_main_menu_before'); ?>
                                <?=$this->parseSystemKey('main_menu', $mixedKeyWrapperHtml);?>
                                <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_main_menu_after'); ?>
                                <p class="bx-def-margin-sec-top">&copy; <a href="http://www.boonex.com/">BoonEx</a></p>
                                <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_copyright_after'); ?>
            				</td>
    
            				<td class="adm-middle-main" id="main_cont">
            					<div class="adm-page-header"><?=$this->parseSystemKey('page_header', $mixedKeyWrapperHtml);?></div>
            					<div class="adm-page-content">
            						<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_content_before'); ?>
