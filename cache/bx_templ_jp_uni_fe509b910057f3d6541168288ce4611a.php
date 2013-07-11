<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
    <head>
    	<title><?=$this->parseSystemKey('page_header', $mixedKeyWrapperHtml);?></title>
    	<meta http-equiv="Content-Type" content="text/html; charset=<?=$this->parseSystemKey('page_charset', $mixedKeyWrapperHtml);?>" />
    	<meta http-equiv="refresh" content="1;URL=<?=$a['url_relocate'];?>" />	
    	<meta http-equiv="Content-Style-Type" content="text/css" />
    	<bx_include_css />
    	<script src="inc/js/functions.js" type="text/javascript" language="javascript"></script>
        <script src="plugins/jquery/jquery.js" type="text/javascript" language="javascript"></script>
        <script defer type="text/javascript">
    		var site_url = 'http://www.thaipo.org/';
    	</script>
        <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_head'); ?>
    </head>
    <body <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_body'); ?> class="bx-def-font">
    	<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_header'); ?>
    	<?=$a['page_main_code'];?>
    	<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_footer'); ?>
    </body>
</html>
