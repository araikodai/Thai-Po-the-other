<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once('inc/header.inc.php');
require_once(BX_DIRECTORY_PATH_INC . 'design.inc.php');
require_once(BX_DIRECTORY_PATH_INC . 'params.inc.php');
require_once(BX_DIRECTORY_PATH_INC . 'utils.inc.php');

bx_import('BxDolPrivacy');
bx_import('BxDolUserStatusView');
bx_import('BxDolSubscription');

$iMemberId  = getLoggedId();

if (!isset($_GET['ID']) && !(int)$_GET['ID'])
    exit;

$iProfId = (int)$_GET['ID'];
$aProfileInfo = getProfileInfo($iProfId);
$aMemberInfo = getProfileInfo($iMemberId);

$aProfileInfo['anonym_mode']     = $oTemplConfig->bAnonymousMode;
$aProfileInfo['member_pass']     = $aMemberInfo['Password'];
$aProfileInfo['member_id']		= $iMemberId;
$aProfileInfo['url'] = BX_DOL_URL_ROOT;
$aProfileInfo['status_message'] = process_line_output($aProfileInfo['UserStatusMessage']);

//--- Subscription integration ---//
$oSubscription = new BxDolSubscription();
$sAddon = $oSubscription->getData(true);

$aButton = $oSubscription->getButton($iMemberId, 'profile', '', $iProfId);
$aProfileInfo['sbs_profile_title'] = $aButton['title'];
$aProfileInfo['sbs_profile_script'] = $aButton['script'];
//--- Subscription integration ---//

//--- Check for member/non-member ---//
if(isMember()) {
    $aProfileInfo['cpt_edit'] = _t('_EditProfile');
    $aProfileInfo['cpt_send_letter'] = _t('_SendLetter');
    $aProfileInfo['cpt_fave'] = _t('_Fave');
    $aProfileInfo['cpt_remove_fave'] = _t('_Remove Fave');
    $aProfileInfo['cpt_befriend'] = _t('_Befriend');
    $aProfileInfo['cpt_remove_friend'] = _t('_Remove friend');
    $aProfileInfo['cpt_greet'] = _t('_Greet');
    $aProfileInfo['cpt_get_mail'] = _t('_Get E-mail');
    $aProfileInfo['cpt_share'] = isAllowedShare($aProfileInfo) ? _t('_Share') : '';
    $aProfileInfo['cpt_report'] = _t('_Report Spam');
    $aProfileInfo['cpt_block'] = _t('_Block');
    $aProfileInfo['cpt_unblock'] = _t('_Unblock');
} else {
    $aProfileInfo['cpt_edit'] = '';
    $aProfileInfo['cpt_send_letter'] = '';
    $aProfileInfo['cpt_fave'] = '';
    $aProfileInfo['cpt_remove_fave'] = '';
    $aProfileInfo['cpt_befriend'] = '';
    $aProfileInfo['cpt_remove_friend'] = '';
    $aProfileInfo['cpt_greet'] = '';
    $aProfileInfo['cpt_get_mail'] = '';
    $aProfileInfo['cpt_share'] = '';
    $aProfileInfo['cpt_report'] = '';
    $aProfileInfo['cpt_block'] = '';
    $aProfileInfo['cpt_unblock'] = '';
}

$sProfLink = '<a href="' . getProfileLink($iProfId) . '">' . getNickName($aProfileInfo['ID']) . '</a> ';

$oUserStatus = new BxDolUserStatusView();
$sUserIcon = $oUserStatus->getStatusIcon($iProfId);
$sUserStatus = $oUserStatus->getStatus($iProfId);

$aUnit = array(
    'status_icon' => $sUserIcon,
    'profile_status' => _t('_prof_status', $sProfLink, $sUserStatus),
    'profile_status_message' => $aProfileInfo['status_message'],
    'profile_actions' => $oFunctions->genObjectsActions( $aProfileInfo, 'Profile'),
);

header('Content-type:text/html;charset=utf-8');
echo $oFunctions->transBox($oSysTemplate->parseHtmlByName('short_profile_info.html', $aUnit) . $sAddon);

function isAllowedShare(&$aDataEntry)
{
	if($aDataEntry['allow_view_to'] != BX_DOL_PG_ALL)
    	return false;

	return true;
}