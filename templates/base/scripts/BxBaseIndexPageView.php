<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

include_once (BX_DIRECTORY_PATH_MODULES . 'boonex/avatar/include.php');

bx_import('BxDolSubscription');
bx_import('BxTemplTags');
bx_import('BxTemplCategories');

class BxBaseIndexPageView extends BxDolPageView
{
    function BxBaseIndexPageView()
    {
        BxDolPageView::BxDolPageView( 'index' );
    }

    /**
     * News Letters block
     */
    function getBlockCode_Subscribe()
    {
        global $site;

        $iUserId = isLogged() ? getLoggedId() : 0;

        $oSubscription = new BxDolSubscription();
        $aButton = $oSubscription->getButton($iUserId, 'system', '');
        $sContent = $oSubscription->getData() . $GLOBALS['oSysTemplate']->parseHtmlByName('home_page_subscribe.html', array(
            'message' => _t('_SUBSCRIBE_TEXT', $site['title']),
            'button_title' => $aButton['title'],
            'button_script' => $aButton['script']
        ));

        return array($sContent, array(), array(), false);
    }

    /**
     * Featured members block
     */
    function getBlockCode_Featured()
    {
        $iFeatureNum = getParam('featured_num');
        $aCode = $this->getMembers('Featured', array('Featured' => 1), $iFeatureNum);
        return $aCode;
    }

    function getBlockCode_Members()
    {
        $iMaxNum = (int) getParam( "top_members_max_num" ); // number of profiles
        $aCode = $this->getMembers('Members', array(), $iMaxNum);
        return $aCode;
    }

    function getBlockCode_Tags($iBlockId)
    {
        $oTags = new BxTemplTags();
        $oTags->getTagObjectConfig(array('type' => ''));

        if(empty($oTags->aTagObjects))
            return '';

        $aParam = array(
            'type' => isset($_REQUEST['tags_mode']) ? $_REQUEST['tags_mode'] : $oTags->getFirstObject(),
            'orderby' => 'popular',
            'limit' => getParam('tags_perpage_browse')
        );

        $sMenu = $oTags->getTagsTopMenu($aParam);
        $sContent = $oTags->display($aParam, $iBlockId);
        return array($sContent, $sMenu, array(), false);
    }

    function getBlockCode_Categories($iBlockId)
    {
        $oCategories = new BxTemplCategories();
        $oCategories->getTagObjectConfig(array('status' => 'active'));

        if(empty($oCategories->aTagObjects))
            return '';

        $aParam = array(
            'type' => isset($_REQUEST['tags_mode']) ? $_REQUEST['tags_mode'] : $oCategories->getFirstObject(),
            'limit' => getParam('categ_perpage_browse'),
            'orderby' => 'popular'
        );

        $sMenu = $oCategories->getCategTopMenu($aParam);
        $sContent = $oCategories->display($aParam, $iBlockId, '', false, getParam('categ_show_columns'));
        return array($sContent, $sMenu, array(), false);
    }

    function getBlockCode_QuickSearch()
    {
        $aProfile = isLogged() ? getProfileInfo() : array();

        // default params for search form
        $aDefaultParams = array(
            'LookingFor'  => !empty($aProfile['Sex'])        ? $aProfile['Sex']           : 'male',
            'Sex'         => !empty($aProfile['LookingFor']) ? $aProfile['LookingFor']    : 'female',
            'Country'     => !empty($aProfile['Country'])    ? $aProfile['Country']       : getParam('default_country'),
            'DateOfBirth' => getParam('search_start_age') . '-' . getParam('search_end_age'),
        );

        $oPF = new BxDolProfileFields(10);
        return array($oPF->getFormCode(array('default_params' => $aDefaultParams)), array(), array(), false);
    }

    function getBlockCode_SiteStats()
    {
        return array(getSiteStatUser(), array(), array(), false);
    }

    function getBlockCode_Download()
    {
        $a = $GLOBALS['MySQL']->fromCache('sys_box_download', 'getAll', 'SELECT * FROM `sys_box_download` WHERE `disabled` = 0 ORDER BY `order`');
        $s = '';

        foreach ($a as $r) {
            if ('_' == $r['title'][0])
                $r['title'] = _t($r['title']);
            if ('_' == $r['desc'][0])
                $r['desc'] = _t($r['desc']);

            if (0 == strncmp('php:', $r['url'], 4))
                $r['url'] = eval(substr($r['url'], 4));
            if (!$r['url'])
                continue;

            $r['icon'] = $GLOBALS['oSysTemplate']->getIconUrl($r['icon']);
            $s .= $GLOBALS['oSysTemplate']->parseHtmlByName('download_box_unit.html', $r);
        }

        return array($s, array(), array(), false);
    }

    // ----- non-block functions ----- //
    function getMembers ($sBlockName, $aParams = array(), $iLimit = 16, $sMode = 'last')
    {
        $aDefFields = array(
            'ID', 'NickName', 'Couple', 'Sex'
        );
        $sCode = '';

        $iOnlineTime = (int)getParam( "member_online_time" );

        //main fields
        $sqlMainFields = "";
        foreach ($aDefFields as $iKey => $sValue)
             $sqlMainFields .= "`Profiles`. `$sValue`, ";

        $sqlMainFields .= "if(`DateLastNav` > SUBDATE(NOW(), INTERVAL $iOnlineTime MINUTE ), 1, 0) AS `is_online`";

        // possible conditions
        $sqlCondition = "WHERE `Profiles`.`Status` = 'Active' and (`Profiles`.`Couple` = 0 or `Profiles`.`Couple` > `Profiles`.`ID`)";
        if (is_array($aParams)) {
             foreach ($aParams as $sField => $sValue)
                 $sqlCondition .= " AND `Profiles`.`$sField` = '$sValue'";
        }

        // top menu and sorting
        $aModes = array('last', 'top', 'online');
        $aDBTopMenu = array();

        if (empty($_GET[$sBlockName . 'Mode'])) {
            $sMode = 'last';
        } else {
            $sMode = (in_array($_GET[$sBlockName . 'Mode'], $aModes)) ? $_GET[$sBlockName . 'Mode'] : $sMode = 'last';
        }
        $sqlOrder = "";
        foreach( $aModes as $sMyMode ) {
            switch ($sMyMode) {
                case 'online':
                    if ($sMode == $sMyMode) {
                        $sqlCondition .= " AND `Profiles`.`DateLastNav` > SUBDATE(NOW(), INTERVAL ".$iOnlineTime." MINUTE)";
                        $sqlOrder = " ORDER BY `Profiles`.`Couple` ASC";
                    }
                    $sModeTitle = _t('_Online');
                break;
                case 'last':
                    if ($sMode == $sMyMode)
                        $sqlOrder = " ORDER BY `Profiles`.`Couple` ASC, `Profiles`.`DateReg` DESC";
                    $sModeTitle = _t('_Latest');
                break;
                case 'top':
                    if ($sMode == $sMyMode) {
                        $oVotingView = new BxTemplVotingView ('profile', 0, 0);
                        $aSql        = $oVotingView->getSqlParts('`Profiles`', '`ID`');
                        $sqlOrder    = $oVotingView->isEnabled() ? " ORDER BY `Profiles`.`Couple` ASC, (`pr_rating_sum`/`pr_rating_count`) DESC, `pr_rating_count` DESC, `Profiles`.`DateReg` DESC" : $sqlOrder;
                        $sqlMainFields .= $aSql['fields'];
                        $sqlLJoin    = $aSql['join'];
                        $sqlCondition .= " AND `pr_rating_count` > 1";
                    }
                    $sModeTitle = _t('_Top');
                break;
            }
            $aDBTopMenu[$sModeTitle] = array('href' => BX_DOL_URL_ROOT . "index.php?{$sBlockName}Mode=$sMyMode", 'dynamic' => true, 'active' => ( $sMyMode == $sMode ));
        }
        if (empty($sqlLJoin)) $sqlLJoin = '';
        $iCount = (int)db_value("SELECT COUNT(`Profiles`.`ID`) FROM `Profiles` $sqlLJoin $sqlCondition");
        $aData = array();
        $sPaginate = '';
        if ($iCount) {
            $iLimit = (int)$iLimit > 0 ? (int)$iLimit : 8;
            $iPages = ceil($iCount/ $iLimit);
            $iPage = empty($_GET['page']) ? 1 : (int)$_GET['page'];
            if ($iPage > $iPages)
                $iPage = $iPages;
            if ($iPage < 1)
                $iPage = 1;
            $sqlFrom = ($iPage - 1) * $iLimit;
            $sqlLimit = "LIMIT $sqlFrom, $iLimit";

            $sqlQuery = "SELECT " . $sqlMainFields . " FROM `Profiles` $sqlLJoin $sqlCondition $sqlOrder $sqlLimit";
            $rData = db_res($sqlQuery);
            $iCurrCount = mysql_num_rows($rData);
            $aOnline = $aTmplVars = array();
            while ($aData = mysql_fetch_assoc($rData)) {
                $aOnline['is_online'] = $aData['is_online'];
                $aTmplVars[] = array(
                    'thumbnail' => get_member_thumbnail($aData['ID'], 'none', true, 'visitor', $aOnline)
                );
            }
            $sCode = $GLOBALS['oSysTemplate']->parseHtmlByName('members_list.html', array(
                'bx_repeat:list' => $aTmplVars
            ));

            if ($iPages > 1) {
                $oPaginate = new BxDolPaginate(array(
                    'page_url' => BX_DOL_URL_ROOT . 'index.php',
                    'count' => $iCount,
                    'per_page' => $iLimit,
                    'page' => $iPage,
                    'per_page_changer' => true,
                    'page_reloader' => true,
                    'on_change_page' => 'return !loadDynamicBlock({id}, \'index.php?'.$sBlockName.'Mode='.$sMode.'&page={page}&per_page={per_page}\');',
                    'on_change_per_page' => ''
                ));
                $sPaginate = $oPaginate->getSimplePaginate(BX_DOL_URL_ROOT . 'browse.php');
            }
        } else {
            $sCode = MsgBox(_t("_Empty"));
        }
        return array($sCode, $aDBTopMenu, $sPaginate, true);
    }
}
