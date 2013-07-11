<?php

$site['ver']               = '7.1';
$site['build']             = '3';
$site['url']               = "http://www.thaipo.org/";
$admin_dir                 = "administration";
$iAdminPage				= 0;
$site['url_admin']         = "{$site['url']}$admin_dir/";

$site['mediaImages']       = "{$site['url']}media/images/";
$site['gallery']           = "{$site['url']}media/images/gallery/";
$site['flags']             = "{$site['url']}media/images/flags/";
$site['banners']           = "{$site['url']}media/images/banners/";
$site['tmp']               = "{$site['url']}tmp/";
$site['plugins']           = "{$site['url']}plugins/";
$site['base']              = "{$site['url']}templates/base/";

$site['bugReportMail']     = "sns@thaipo.net";

$dir['root']               = "/home/araikodai/thaipo.org/public_html/";
$dir['inc']                = "{$dir['root']}inc/";
$dir['profileImage']       = "{$dir['root']}media/images/profile/";

$dir['mediaImages']        = "{$dir['root']}media/images/";
$dir['gallery']            = "{$dir['root']}media/images/gallery/";
$dir['flags']              = "{$dir['root']}media/images/flags/";
$dir['banners']            = "{$dir['root']}media/images/banners/";
$dir['tmp']                = "{$dir['root']}tmp/";
$dir['cache']              = "{$dir['root']}cache/";
$dir['plugins']            = "{$dir['root']}plugins/";
$dir['base']               = "{$dir['root']}templates/base/";
$dir['classes']            = "{$dir['inc']}classes/";

$video_ext                 = 'avi';
$MOGRIFY                   = "/usr/bin/mogrify";
$CONVERT                   = "/usr/bin/convert";
$COMPOSITE                 = "/usr/bin/composite";
$PHPBIN                    = "/usr/local/bin/php";

$db['host']                = 'mysql17.xserver.jp';
$db['sock']                = '';
$db['port']                = '';
$db['user']                = 'araikodai_owner';
$db['passwd']              = 'czrs8z1c';
$db['db']                  = 'araikodai_newthaipo';

define('BX_DOL_URL_ROOT', $site['url']);
define('BX_DOL_URL_ADMIN', $site['url_admin']);
define('BX_DOL_URL_PLUGINS', $site['plugins']);
define('BX_DOL_URL_MODULES', $site['url'] . 'modules/' );
define('BX_DOL_URL_CACHE_PUBLIC', $site['url'] . 'cache_public/');

define('BX_DIRECTORY_PATH_INC', $dir['inc']);
define('BX_DIRECTORY_PATH_ROOT', $dir['root']);
define('BX_DIRECTORY_PATH_BASE', $dir['base']);
define('BX_DIRECTORY_PATH_CACHE', $dir['cache']);
define('BX_DIRECTORY_PATH_CLASSES', $dir['classes']);
define('BX_DIRECTORY_PATH_PLUGINS', $dir['plugins']);
define('BX_DIRECTORY_PATH_DBCACHE', $dir['cache']);
define('BX_DIRECTORY_PATH_MODULES', $dir['root'] . 'modules/' );
define('BX_DIRECTORY_PATH_CACHE_PUBLIC', $dir['root'] . 'cache_public/' );

define('DATABASE_HOST', $db['host']);
define('DATABASE_SOCK', $db['sock']);
define('DATABASE_PORT', $db['port']);
define('DATABASE_USER', $db['user']);
define('DATABASE_PASS', $db['passwd']);
define('DATABASE_NAME', $db['db']);

define('BX_DOL_SPLASH_VIS_DISABLE', 'disable');
define('BX_DOL_SPLASH_VIS_INDEX', 'index');
define('BX_DOL_SPLASH_VIS_ALL', 'all');


define('CHECK_DOLPHIN_REQUIREMENTS', 1);
if (defined('CHECK_DOLPHIN_REQUIREMENTS')) {
    $aErrors = array();
    $aErrors[] = (ini_get('register_globals') == 0) ? '' : '<font color="red">register_globals is On (warning, you should have this param in Off state, or your site will unsafe)</font>';
    $aErrors[] = (ini_get('safe_mode') == 0) ? '' : '<font color="red">safe_mode is On, disable it</font>';
    $aErrors[] = (version_compare(PHP_VERSION, '5.2.0', '<')) ? '<font color="red">PHP version too old, please update to PHP 5.2.0 at least</font>' : '';
    $aErrors[] = (!extension_loaded( 'mbstring')) ? '<font color="red">mbstring extension not installed. <b>Warning!</b> Dolphin cannot work without <b>mbstring</b> extension.</font>' : '';
    $aErrors[] = (ini_get('short_open_tag') == 0 && version_compare(phpversion(), "5.4", "<") == 1) ? '<font color="red">short_open_tag is Off (must be On!)<b>Warning!</b> Dolphin cannot work without <b>short_open_tag</b>.</font>' : '';

    if (version_compare(phpversion(), "5.2", ">") == 1) {
        $aErrors[] = (ini_get('allow_url_include') == 0) ? '' : '<font color="red">allow_url_include is On (warning, you should have this param in Off state, or your site will unsafe)</font>';
    };

    $aErrors = array_diff($aErrors, array('')); //delete empty
    if (count($aErrors)) {
        $sErrors = implode(" <br /> ", $aErrors);
        echo <<<EOF
{$sErrors} <br />
Please go to the <br />
<a href="http://www.boonex.com/trac/dolphin/wiki/GenDolTShooter">Dolphin Troubleshooter</a> <br />
and solve the problem.
EOF;
        exit;
    }
}


//check correct hostname
$aUrl = parse_url( $site['url'] );
if ( isset($_SERVER['HTTP_HOST']) and 0 != strcasecmp($_SERVER['HTTP_HOST'], $aUrl['host']) and 0 != strcasecmp($_SERVER['HTTP_HOST'], $aUrl['host'] . ':80') ) {
    header( "Location:http://{$aUrl['host']}{$_SERVER['REQUEST_URI']}" );
    exit;
}


// check if install folder exists
if ( !defined ('BX_SKIP_INSTALL_CHECK') && file_exists( $dir['root'] . 'install' ) ) {
    $ret = <<<EOJ
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <title>Dolphin Installed</title>
    <link href="{$site['url']}install/general.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body class="bx-def-font">
    <div class="adm-header">
        <div class="adm-header-content">
            <div class="adm-header-title bx-def-margin-sec-left">
                <img class="adm-header-logo" src="{$site['url']}administration/templates/base/images/logo.png" />
                <div class="adm-header-text bx-def-font-h1">Dolphin {$site['ver']}</div>
                <div class="clear_both">&nbsp;</div>
            </div>
            <div class="clear_both">&nbsp;</div>
        </div>
    </div>
    <div id="bx-install-main" class="bx-def-border bx-def-round-corners bx-def-margin-top">
        <div id="bx-install-content" class="bx-def-padding">
            <div class="bx-install-header-caption bx-def-font-h1 bx-def-margin-bottom">
                Well done, mate! Dolphin is now installed.
            </div>
            <div class="bx-install-header-text bx-def-font-large bx-def-font-grayed">
                Remove directory called <b>"install"</b> from your server and <a href="{$site['url']}administration/modules.php">proceed to Admin Panel to install modules</a>.
            </div>
        </div>
    </div>
</body>
</html>
EOJ;
    echo $ret;
    exit();
}


// set error reporting level
if (version_compare(phpversion(), "5.3.0", ">=") == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
else
  error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0);
ini_set('magic_quotes_sybase', 0);


// set default encoding for multibyte functions
mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');


require_once(BX_DIRECTORY_PATH_INC . "security.inc.php");
require_once(BX_DIRECTORY_PATH_ROOT . "flash/modules/global/inc/header.inc.php");
require_once(BX_DIRECTORY_PATH_ROOT . "flash/modules/global/inc/content.inc.php");
require_once(BX_DIRECTORY_PATH_CLASSES . "BxDolService.php");
require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolAlerts.php');
$oZ = new BxDolAlerts('system', 'begin', 0);
$oZ->alert();
