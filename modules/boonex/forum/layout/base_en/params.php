<?php
if( isset($_REQUEST['gConf']) ) die; // globals hack prevention

$gConf['dir']['xsl'] = $gConf['dir']['layouts'] . 'base_en/xsl/';	// xsl dir

$gConf['url']['icon'] = $gConf['url']['layouts'] . 'base_en/icons/';	// icons url
$gConf['url']['img'] = $gConf['url']['layouts'] . 'base_en/img/';	// img url
$gConf['url']['css'] = $gConf['url']['layouts']  . 'base_en/css/';	// css url
$gConf['url']['xsl'] = $gConf['url']['layouts'] . 'base_en/xsl/';	// xsl url
