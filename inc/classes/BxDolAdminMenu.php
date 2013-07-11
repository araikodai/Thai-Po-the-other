<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolMistake');

class BxDolAdminMenu extends BxDolMistake
{
    /**
     * constructor
     */
    function BxDolAdminMenu()
    {
        parent::BxDolMistake();
    }

    function getTopMenu()
    {
        $aItems = $GLOBALS['MySQL']->getAll("SELECT `caption`, `url`, `icon` FROM `sys_menu_admin_top` ORDER BY `Order`");

        $aItemsResult = array();
        foreach($aItems as $aItems)
            $aItemsResult[] = array(
                'caption' => _t($aItems['caption']),
                'url' => str_replace(
                    array(
                        '{site_url}',
                        '{admin_url}'
                    ),
                    array(
                        $GLOBALS['site']['url'],
                        $GLOBALS['site']['url_admin'],
                    ),
                    $aItems['url']
                ),
                'icon' => false === strpos($aItems['icon'], '.') ? '<i class="sys-icon ' . $aItems['icon'] . '"></i>' : '<img src="' . $GLOBALS['oAdmTemplate']->getIconUrl($aItems['icon']) . '" alt="' . _t($aItems['caption']) . '" />',
            );
        return $GLOBALS['oAdmTemplate']->parseHtmlByName('top_menu.html', array('bx_repeat:items' => $aItemsResult));
    }
    function getMainMenu()
    {
        if(!isAdmin())
            return '';

        $sUri = $_SERVER['REQUEST_URI'];
        $sPath = parse_url (BX_DOL_URL_ROOT, PHP_URL_PATH);
        if ($sPath && $sPath != '/' && 0 == strncmp($sPath, $sUri, strlen($sPath)))
            $sUri = substr($sUri, strlen($sPath) - strlen($sUri));
        $sUri = BX_DOL_URL_ROOT . $sUri;
        $sFile = basename($_SERVER['PHP_SELF']);

        $oPermalinks = new BxDolPermalinks();
        $aMenu = $GLOBALS['MySQL']->getAll("SELECT `id`, `name`, `title`, `url`, `icon` FROM `sys_menu_admin` WHERE `parent_id`='0' ORDER BY `order`" );

        $oZ = new BxDolAlerts('system', 'admin_menu', 0, 0, array(
            'parent' => false,
            'menu' => &$aMenu,
        ));
        $oZ->alert();

        $aItems = array();
        foreach($aMenu as $aMenuItem) {
            $aMenuItem['url'] = str_replace(array('{siteUrl}', '{siteAdminUrl}'), array(BX_DOL_URL_ROOT, BX_DOL_URL_ADMIN), $aMenuItem['url']);

            $bActiveCateg = $sFile == 'index.php' && (!empty($_GET['cat'])) && $_GET['cat'] == $aMenuItem['name'];
            $aSubmenu = $GLOBALS['MySQL']->getAll("SELECT * FROM `sys_menu_admin` WHERE `parent_id`='" . $aMenuItem['id'] . "' ORDER BY `order`");

            $oZ = new BxDolAlerts('system', 'admin_menu', 0, 0, array(
	            'parent' => &$aMenuItem,
	            'menu' => &$aSubmenu,
	        ));
	        $oZ->alert();

            $aSubitems = array();
            foreach($aSubmenu as $aSubmenuItem) {
                $aSubmenuItem['url'] = $oPermalinks->permalink($aSubmenuItem['url']);
                $aSubmenuItem['url'] = str_replace(array('{siteUrl}', '{siteAdminUrl}'), array(BX_DOL_URL_ROOT, BX_DOL_URL_ADMIN), $aSubmenuItem['url']);

                if(!defined('BX_DOL_ADMIN_INDEX') && $aSubmenuItem['url'] != '' && (strpos($sUri, $aSubmenuItem['url']) !== false || strpos($aSubmenuItem['url'], $sUri) !== false))
                    $bActiveCateg = $bActiveItem = true;
                else
                    $bActiveItem = false;

                $aSubitems[] = BxDolAdminMenu::_getMainMenuSubitem($aSubmenuItem, $bActiveItem);
            }
            $aItems[] = BxDolAdminMenu::_getMainMenuItem($aMenuItem, $aSubitems, $bActiveCateg);
        }
        return $GLOBALS['oAdmTemplate']->parseHtmlByName('main_menu.html', array('bx_repeat:items' => $aItems));
    }
    function getMainMenuLink($sUrl)
    {
        if(substr($sUrl, 0, 11) == 'javascript:') {
            $sLink = 'javascript:void(0);';
            $sOnClick = 'onclick="' . $sUrl . '"';
        } else {
            $sLink = $sUrl;
            $sOnClick = '';
        }

        $aAdminProfile = getProfileInfo();
        $aVariables = array(
            'adminLogin' => $aAdminProfile['NickName'],
            'adminPass' => $aAdminProfile['Password']
        );
        $sLink = $GLOBALS['oAdmTemplate']->parseHtmlByContent($sLink, $aVariables, array('{', '}'));
        $sOnClick = $GLOBALS['oAdmTemplate']->parseHtmlByContent($sOnClick, $aVariables, array('{', '}'));

        return array($sLink, $sOnClick);
    }
    function _getMainMenuItem($aCateg, $aItems, $bActive)
    {
        global $oAdmTemplate;
        $bSubmenu = !empty($aItems);

        $sClass = "adm-mm-" . $aCateg['name'];
        if($bActive && !empty($aItems))
            $sClass .= ' adm-mmh-opened';
        else if($bActive && empty($aItems))
            $sClass .= ' adm-mmh-active';

        $sLink = "";
        if(!empty($aCateg['url']))
            $sLink = $aCateg['url'];
        else if($aCateg['id'])
            $sLink = BX_DOL_URL_ADMIN . "index.php?cat=" . $aCateg['name'];
        else
            $sLink = BX_DOL_URL_ADMIN . "index.php";

        return array(
            'class' => $sClass,
            'click' => !$bSubmenu ? 'onclick="javascript:window.open(\'' . $sLink . '\', \'_self\')"' : '',
            'bx_if:icon' => array(
                'condition' => false !== strpos($aCateg['icon'], '.'),
                'content' => array(
                    'icon' => $oAdmTemplate->getIconUrl($aCateg['icon'])
                )
            ),
            'bx_if:texticon' => array(
                'condition' => false === strpos($aCateg['icon'], '.'),
                'content' => array(
                    'icon' => $aCateg['icon']
                )
            ),
            'bx_if:collapsible' => array(
                'condition' => !empty($aItems),
                'content' => array(
                    'class' => ($bActive && !empty($aItems) ? 'adm-mma-opened' : '')
                )
            ),
            'bx_if:item-text' => array(
                'condition' => $bActive,
                'content' => array(
                    'title' => _t($aCateg['title'])
                )
            ),
            'bx_if:item-link' => array(
                'condition' => !$bActive,
                'content' => array(
                    'link' => $sLink,
                    'title' => _t($aCateg['title'])
                )
            ),
            'bx_if:submenu' => array(
                'condition' => $bSubmenu,
                'content' => array(
                    'id' => $aCateg['id'],
                    'class' => ($bActive && !empty($aItems) ? 'adm-mmi-opened' : ''),
                    'bx_repeat:subitems' => $aItems
                )
            )
        );
    }

    function _getMainMenuSubitem($aItem, $bActive)
    {
        global $oAdmTemplate;

        if(strlen($aItem['check']) > 0) {
            $oFunction = create_function( '', $aItem['check'] );
            if(!$oFunction())
                return '';
        }

        if(!$bActive)
            list($sLink, $sOnClick) = BxDolAdminMenu::getMainMenuLink($aItem['url']);

        return array(
            'bx_if:subicon' => array(
                'condition' => false !== strpos($aItem['icon'], '.'),
                'content' => array(
                    'icon' => $oAdmTemplate->getIconUrl($aItem['icon'])
                )
            ),
            'bx_if:textsubicon' => array(
                'condition' => false === strpos($aItem['icon'], '.'),
                'content' => array(
                    'icon' => $aItem['icon']
                )
            ),
            'bx_if:subitem-text' => array(
                'condition' => $bActive,
                'content' => array(
                    'title' => _t($aItem['title'])
                )
            ),
            'bx_if:subitem-link' => array(
                'condition' => !$bActive,
                'content' => array(
                    'link' => empty($sLink) ? '' : $sLink,
                    'onclick' => empty($sOnClick) ? '' : $sOnClick,
                    'title' => 'manage_modules' == $aItem['name'] || 'flash_apps' == $aItem['name'] ? '<b>' . _t($aItem['title']) . '</b>' : _t($aItem['title']),
                )
            )
        );
    }
}
