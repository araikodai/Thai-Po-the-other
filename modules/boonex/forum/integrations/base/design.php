<?php
/**
*                            Orca Interactive Forum Script
*                              ---------------
*     Started             : Mon Mar 23 2006
*     Copyright           : (C) 2007 BoonEx Group
*     Website             : http://www.boonex.com
* This file is part of Orca - Interactive Forum Script
* GPL
**/

// generate custom $glHeader and $glFooter variables here

// ******************* include dolphin header/footer [begin]

check_logged();

require_once(BX_DIRECTORY_PATH_INC . 'db.inc.php');
require_once(BX_DIRECTORY_PATH_INC . 'params.inc.php');
require_once(BX_DIRECTORY_PATH_INC . 'design.inc.php');
require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolPageView.php');

global $_page, $glHeader, $glFooter, $logged, $_ni;

$GLOBALS['name_index'] = $_page['name_index'] = 55;

$_page['header'] = $gConf['def_title'];
$_page['header_text'] = $gConf['def_title'];

$_ni = $_page['name_index'];
$_page_cont[$_ni]['page_main_code'] = '-=++=-';

global $gConf;
$GLOBALS['oSysTemplate']->addCss ("modules/boonex/forum/layout/{$gConf['skin']}/css/|main.css");
$GLOBALS['oSysTemplate']->addJs (array(
    $gConf['url']['js'] . 'util.js',
    $gConf['url']['js'] . 'BxError.js',
    $gConf['url']['js'] . 'BxXmlRequest.js',
    $gConf['url']['js'] . 'BxXslTransform.js',
    $gConf['url']['js'] . 'BxForum.js',
    $gConf['url']['js'] . 'BxHistory.js',
    $gConf['url']['js'] . 'BxLogin.js',
    $gConf['url']['js'] . 'BxAdmin.js',
));

if (isset($_page['extra_js']))
    $_page['extra_js'] .= $GLOBALS['oSysTemplate']->addJs ('tiny_mce_gzip.js', true);
else
    $_page['extra_js'] = $GLOBALS['oSysTemplate']->addJs ('tiny_mce_gzip.js', true);

$GLOBALS['BxDolTemplateInjections']['page_'.$_ni]['injection_body'][] = array('type' => 'text', 'data' => 'id="body" onload="if(!document.body) { document.body = document.getElementById(\'body\'); }; h = new BxHistory(); document.h = h; return h.init(\'h\'); "');

if (BX_ORCA_INTEGRATION == 'dolphin') {
    $aVars = array ('ForumBaseUrl' => $gConf['url']['base']);
    $GLOBALS['oTopMenu']->setCustomSubActions($aVars, 'bx_forum_title', false);
}

if (isLogged()) {
    bx_import('BxDolEditor');
    $oEditor = BxDolEditor::getObjectInstance();
    if ($oEditor)
        $sEditor .= $oEditor->attachEditor ('#fakeEditor', BX_EDITOR_FULL) . '<div id="fakeEditor" style="display:none;"></div>';
}

ob_start();
PageCode();
$sDolphinDesign = ob_get_clean();

$iPos = strpos($sDolphinDesign, '-=++=-');
$glHeader = substr ($sDolphinDesign, 0, $iPos) . $sEditor;
$glFooter = substr ($sDolphinDesign, $iPos + 6 - strlen($sDolphinDesign));


// ******************* include dolphin header/footer [ end ]

class BxDolOrcaForumsTemplate extends BxDolTemplate
{
    function BxDolOrcaForumsTemplate($sRootPath = BX_DIRECTORY_PATH_ROOT, $sRootUrl = BX_DOL_URL_ROOT)
    {
        parent::BxDolTemplate($sRootPath, $sRootUrl);
        $this->addLocation('BxDolOrcaForums', $GLOBALS['gConf']['dir']['base'], $GLOBALS['gConf']['url']['base']);
    }
}

class BxDolOrcaForumsIndex extends BxDolPageView
{
    var $sMarker = '-=++=-';

    function BxDolOrcaForumsIndex()
    {
        parent::BxDolPageView('forums_index');
    }

    function getBlockCode_FullIndex()
    {
        return $this->sMarker;
    }
}

class BxDolOrcaForumsHome extends BxDolPageView
{
    var $sMarker = '-=++=-';

    function BxDolOrcaForumsHome()
    {
        parent::BxDolPageView('forums_home');
    }

    function getBlockCode_Search()
    {
        $oTemplate = new BxDolOrcaForumsTemplate();
        $aVars = array(
            'base_url_forum' => $GLOBALS['gConf']['url']['base'],
        );
        return array($oTemplate->parseHtmlByName('search_block.html', $aVars));
    }

    function getBlockCode_ShortIndex()
    {
        global $gConf;

        $s = '<div class="forums_index_short">';
        $ac = $GLOBALS['f']->fdb->getCategs();
        foreach ($ac as $c) {
            $s .= '<div class="forums_index_short_cat bx-def-font-large"><a href="' . $gConf['url']['base'] . sprintf($gConf['rewrite']['cat'], $c['cat_uri'], 0) . '" onclick="return f.selectForumIndex(\'' . $c['cat_uri'] . '\')">'. $c['cat_name'] .'</a></div>';
            $af = $GLOBALS['f']->fdb->getForumsByCatUri (filter_to_db($c['cat_uri']));
            foreach ($af as $ff)
                $s .= '<div class="forums_index_short_forum bx-def-padding-sec-left"><a href="' . $gConf['url']['base'] . sprintf($gConf['rewrite']['forum'], $ff['forum_uri'], 0) . '" onclick="return f.selectForum(\'' . $ff['forum_uri'] . '\', 0)">' . $ff['forum_title'] . '</a></div>';
        }
        $s .= '</div>';
        return array($s);
    }

    function getBlockCode_RecentTopics()
    {
        return $this->sMarker;
    }
}
