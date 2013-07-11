<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

if(isLogged()) {
    $iLoggedId = (int)getLoggedId();
    if(file_exists(BX_DIRECTORY_PATH_ROOT . 'user' . $iLoggedId . '.php') && is_file(BX_DIRECTORY_PATH_ROOT . 'user' . $iLoggedId . '.php'))
        require_once( BX_DIRECTORY_PATH_CACHE . 'user' . $iLoggedId . '.php');
}

$GLOBALS['BxDolTemplateJsOptions'] = array();
$GLOBALS['BxDolTemplateJsTranslations'] = array();
$GLOBALS['BxDolTemplateJsImages'] = array();

//--- Initialize template's engine ---//
require_once(BX_DIRECTORY_PATH_INC . 'languages.inc.php');
require_once(BX_DIRECTORY_PATH_CLASSES . "BxDolTemplate.php");

$oSysTemplate = new BxDolTemplate();
$oSysTemplate->init();

//--- Add default CSS ---//
$oSysTemplate->addCss(array(
    'default.css',
    'common.css',
    'general.css',
    'anchor.css',
    'forms_adv.css',
    'login_form.css',
    'top_menu.css',
    'icons.css',
));

//--- Add default JS ---//
$oSysTemplate->addJs(array(
    'jquery.js',
    'jquery-migrate.min.js',
    'jquery.jfeed.js',
    'jquery.ui.position.min.js',
    'functions.js',
    'jquery.dolRSSFeed.js',
    'jquery.float_info.js',
    'jquery.webForms.js',
    'jquery.form.js',
    'jquery.dolPopup.js',
    'common_anim.js',
    'login.js',
    'BxDolVoting.js',
    'user_status.js',
    'jquery.cookie.js',
));

//--- Add default language keys in JS output ---//
$oSysTemplate->addJsTranslation(array(
    '_Counter',
    '_PROFILE_ERR',
    '_sys_txt_btn_loading'
));

//--- Add default images in JS output ---//
$oSysTemplate->addJsImage(array(
    'loading'   => 'loading.gif',
));

/**
 * Backward compatibility.
 * @deprecated
 */
$tmpl = $oSysTemplate->getCode();

require_once( BX_DIRECTORY_PATH_ROOT . "templates/tmpl_" . $tmpl . "/scripts/BxTemplConfig.php" );
$oTemplConfig = new BxTemplConfig($site);
//--- Initialize template's engine ---//

if (defined('BX_PROFILER') && BX_PROFILER) require_once(BX_DIRECTORY_PATH_MODULES . 'boonex/profiler/classes/BxProfiler.php');

// if IP is banned - total block
if ((int)getParam('ipBlacklistMode') == 1 && bx_is_ip_blocked()) {
    echo _t('_Sorry, your IP been banned');
    exit;
}
