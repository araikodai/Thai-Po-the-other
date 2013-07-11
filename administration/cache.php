<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once( '../inc/header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'design.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'admin_design.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'admin.inc.php' );

bx_import('BxDolPaginate');
bx_import('BxDolAdminIpBlockList');
bx_import('BxDolCacheUtilities');

$logged['admin'] = member_auth(1, true, true);

$aCacheTypes = array (
    array('action' => 'all', 'title' => _t('_adm_txt_dashboard_cache_all')),
    array('action' => 'db', 'title' => _t('_adm_txt_dashboard_cache_db')),
    array('action' => 'pb', 'title' => _t('_adm_txt_dashboard_cache_pb')),
    array('action' => 'template', 'title' => _t('_adm_txt_dashboard_cache_template')),
    array('action' => 'css', 'title' => _t('_adm_txt_dashboard_cache_css')),
    array('action' => 'js', 'title' => _t('_adm_txt_dashboard_cache_js')),
    array('action' => 'users', 'title' => _t('_adm_txt_dashboard_cache_users')),
    array('action' => 'member_menu', 'title' => _t('_adm_txt_dashboard_cache_member_menu')),
);

$oCacheUtilities = new BxDolCacheUtilities();

if (!empty($_POST['clear_cache'])) {
    $aResult = array();
    switch ($_POST['clear_cache']) {
        case 'all':
            foreach ($aCacheTypes as $r) {
                $aResult = $oCacheUtilities->clear($r['action']);
                if ($aResult['code'] != 0)
                    break 2;
            }
            break;
        case 'member_menu':
        case 'pb':
        case 'users':
        case 'db':
        case 'template':
        case 'css':
        case 'js':
            $aResult = $oCacheUtilities->clear($_POST['clear_cache']);
            break;
        default:
            $aResult = array('code' => 1, 'message' => _t('_Error Occured'));
    }

    if (0 == $aResult['code']) {
        // add cache size data for chart in case of successful cache cleaning
        $aResult['chart_data'] = array ();
        foreach ($aCacheTypes as $r) {
            if ('all' == $r['action'])
                continue;
            $iSize = $oCacheUtilities->size($r['action']);
            $aResult['chart_data'][] = array (bx_js_string($r['title'], BX_ESCAPE_STR_APOS), array('v' => $iSize, 'f' => bx_js_string(_t_format_size($iSize))));
        }
    }

    $oJson = new Services_JSON();
    echo $oJson->encode($aResult);
    exit;
}

$iNameIndex = 3;
$_page = array(
    'name_index' => $iNameIndex,
    'css_name' => array(),
    'js_name' => array(),
    'header' => _t('_adm_txt_cache'),
    'header_text' => _t('_adm_txt_cache'),
);

$aPages = array (
    'clear' => array (
        'title' => _t('_adm_txt_clear_cache'),
        'url' => BX_DOL_URL_ADMIN . 'cache.php?mode=clear',
        'func' => 'PageCodeClear',
        'func_params' => array(),
    ),
    'engines' => array (
        'title' => _t('_adm_admtools_cache_engines'),
        'url' => BX_DOL_URL_ADMIN . 'cache.php?mode=engines',
        'func' => 'PageCodeEngines',
        'func_params' => array(),
    ),
    'settings' => array (
        'title' => _t('_Settings'),
        'url' => BX_DOL_URL_ADMIN . 'cache.php?mode=settings',
        'func' => 'PageCodeSettings',
        'func_params' => array(),
    ),
);

if (!isset($_GET['mode']) || !isset($aPages[$_GET['mode']]))
    $sMode = 'clear';
else
    $sMode = $_GET['mode'];

$aTopItems = array();
foreach ($aPages as $k => $r)
    $aTopItems['dbmenu_' . $k] = array(
        'href' => $r['url'],
        'title' => $r['title'],
        'active' => $k == $sMode ? 1 : 0
    );

$_page['css_name'] = 'cache.css';
$_page_cont[$iNameIndex]['page_main_code'] = call_user_func($aPages[$sMode]['func'], $aPages[$sMode]['func_params'][0], $aPages[$sMode]['func_params'][1]);

PageCodeAdmin();

function PageCodeClear ()
{
    global $oAdmTemplate, $oCacheUtilities, $aCacheTypes;

    $sChartData= '';
    foreach ($aCacheTypes as $r) {
        if ('all' == $r['action'])
            continue;
        $iSize = $oCacheUtilities->size($r['action']);
        $sChartData .= ",\n['" . bx_js_string($r['title'], BX_ESCAPE_STR_APOS) . "', {v:" . $iSize . ", f:'" . bx_js_string(_t_format_size($iSize)) . "'}]";
    }
    $s = $oAdmTemplate->parseHtmlByName('cache.html', array(
        'bx_repeat:clear_action' => $aCacheTypes,
        'chart_data' => trim($sChartData, ','),
    ));

    return DesignBoxAdmin(_t('_adm_txt_cache'), $s, $GLOBALS['aTopItems'], '', 11);
}

function PageCodeEngines ()
{
    bx_import('BxDolAdminTools');
    $oAdmTools = new BxDolAdminTools();
    $s = $oAdmTools->GenCommonCode();
    $s .= $oAdmTools->GenCacheEnginesTable();

    return DesignBoxAdmin(_t('_adm_txt_cache'), $s, $GLOBALS['aTopItems'], '', 11);
}

function PageCodeSettings ()
{
    bx_import('BxDolAdminSettings');
    $oSettings = new BxDolAdminSettings(24);

    $sResults = false;
    if (isset($_POST['save']) && isset($_POST['cat']))
        $sResult = $oSettings->saveChanges($_POST);

    $s = $oSettings->getForm();
    if ($sResult)
        $s = $sResult . $s;

    return DesignBoxAdmin(_t('_adm_txt_cache'), $s, $GLOBALS['aTopItems'], '', 11);
}
