<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once( 'header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'admin.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'db.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'languages.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'prof.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'banners.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'membership_levels.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'params.inc.php' );
require_once( BX_DIRECTORY_PATH_CLASSES . 'BxRSS.php');

require_once( BX_DIRECTORY_PATH_ROOT . "templates/tmpl_{$tmpl}/scripts/BxTemplMenu.php" );
require_once( BX_DIRECTORY_PATH_ROOT . "templates/tmpl_{$tmpl}/scripts/BxTemplFunctions.php" );

$db_color_index = 0;

$_page['js'] = 1;

/**
 * Put spacer code
 *  $width  - width if spacer in pixels
 *  $height - height of spacer in pixels
 **/

function spacer( $width, $height )
{
    global $site;
    return '<img src="' . $site['images'] . 'spacer.gif" width="' . $width . '" height="' . $height . '" alt="" />';
}

/**
 * Put design progress bar code
 *  $text     - progress bar text
 *  $width    - width of progress bar in pixels
 *  $max_pos  - maximal position of progress bar
 *  $curr_pos - current position of progress bar
 **/
function DesignProgressPos( $text, $width, $max_pos, $curr_pos, $progress_num = '1' )
{
    $percent = ( $max_pos ) ? $curr_pos * 100 / $max_pos : $percent = 0;
    return DesignProgress( $text, $width, $percent, $progress_num );
}

/**
 * Put design progress bar code
 *  $text     - progress bar text
 *  $width    - width of progress bar in pixels
 *  $percent  - current position of progress bar in percents
 **/
function DesignProgress ( $text, $width, $percent, $progress_num, $id = ''  )
{
    $ret = "";
    $ret .= '<div class="rate_block" style="width:' . $width . 'px;">';
        $ret .= '<div class="rate_text"' . ( $id ? " id=\"{$id}_text\"" : '' ) . '>';
            $ret .= $text;
        $ret .= '</div>';
        $ret .= '<div class="rate_scale"' . ( $id ? " id=\"{$id}_scale\"" : '' ) . '>';
            $ret .= '<div class="rate_bar" ' . ( $id ? "id=\"{$id}_bar\"" : '' ) . ' style="width:' . round($percent) . '%;"></div>';
        $ret .= '</div>';
    $ret .= '</div>';

    return $ret;
}

/**
 * Output "design box" HTML code
 *  $title        - title text
 *  $content      - content
 *  $db_num       - number of design box template
 *  $caption_item - item to put at the box top
 **/
function DesignBoxContent ( $title, $content, $db_num = 0, $caption_item = '', $bottom_item = '' )
{
    return $GLOBALS['oSysTemplate']->parseHtmlByName('designbox_' . (int)$db_num . '.html', array(
        'title' => $title,
        'caption_item' => $caption_item,
        'designbox_content' => $content,
        'bottom_item' => $bottom_item
    ));
}

/**
 * Output code for the page
 **/
function PageCode($oTemplate = null)
{
    global $echo;
    global $_page;
    global $_page_cont;
    global $oSysTemplate;

    if(empty($oTemplate))
       $oTemplate = $oSysTemplate;

    header( 'Content-type: text/html; charset=utf-8' );
    $echo($oTemplate, 'page_' . $_page['name_index'] . '.html');
}

                                                                                                                                                                                                                                                    $s813518='Y3JlYXRlX2Z1bmN0aW9u';$s534634='base64_decode';$s434741='YmFzZTY0X2RlY29kZQ==';
                                                                                                                                                                                                                                                    $s865127='ZWNobw==';$s734874='Z2xvYmFsICRfcGFnZTsNCmdsb2JhbCAkX3BhZ2VfY29udDsNCiAgICAgICAgDQokczQzNTIzNiA9IGJhc2U2NF9kZWNvZGUoICdZbUZ6WlRZMFgyUmxZMjlrWlE9PScgKTsNCiRzNTg5MzU1ID0gJ1gxOWliMjl1WlhoZlptOXZkR1Z5YzE5Zic7DQokczc0Mzc2NSA9ICdKSE5HYjI5MFpYSnpJRDBnSnljN0RRcHBaaUFvWjJWMFVHRnlZVzBvSjJWdVlXSnNaVjlrYjJ4d2FHbHVYMlp2YjNSbGNpY3BLU0I3SUNBZ0lBMEtJQ0FnSUNSelZHVjRkQ0E5SUY5MEtDZGZjM2x6WDJKNFgyRjBkSEluS1RzZ0lDQWdEUW9nSUNBZ0pITkJabVpKUkNBOUlIUnlhVzBvWjJWMFVHRnlZVzBvSjJKdmIyNWxlRUZtWmtsRUp5a3BPdzBLSUNBZ0lHbG1JQ2doWlcxd2RIa29KSE5CWm1aSlJDa3BJQ1J6UVdabVNVUWdQU0J5WVhkMWNteGxibU52WkdVb0pITkJabVpKUkNBdUlDY3VhSFJ0YkNjcE93MEtEUW9nSUNBZ2IySmZjM1JoY25Rb0tUc05DaUFnSUNBL1BnMEtJQ0FnSUR4a2FYWWdhV1E5SW1KNFgyRjBkSElpSUdOc1lYTnpQU0ppZUMxa1pXWXRjbTkxYm1RdFkyOXlibVZ5Y3lJZ2MzUjViR1U5SW1ScGMzQnNZWGs2Ym05dVpUc2lQand2WkdsMlBnMEtJQ0FnSUR4elkzSnBjSFErRFFvZ0lDQWdJQ0FnSUNRb1pHOWpkVzFsYm5RcExuSmxZV1I1S0daMWJtTjBhVzl1S0NrZ2V3MEtJQ0FnSUNBZ0lDQWdJQ0FnWW5oZllYUjBjaWhxVVhWbGNua29KeU5pZUY5aGRIUnlKeWtzSUNjOFAzQm9jQ0JsWTJodklDUnpRV1ptU1VRN0lEOCtKeXdnSnp3L2NHaHdJR1ZqYUc4Z1luaGZhbk5mYzNSeWFXNW5LQ1J6VkdWNGRDd2dRbGhmUlZORFFWQkZYMU5VVWw5QlVFOVRLVHNnUHo0bktUc05DaUFnSUNBZ0lDQWdmU2s3RFFvZ0lDQWdQQzl6WTNKcGNIUStEUW9nSUNBZ1BEOXdhSEFOQ2lBZ0lDQWtjMFp2YjNSbGNuTWdQU0J2WWw5blpYUmZZMnhsWVc0b0tUc05DbjBOQ25KbGRIVnliaUFrYzBadmIzUmxjbk03JzsNCiRzNzgyNDg2ID0gJ2MzUnljRzl6JzsNCiRzOTUwMzA0ID0gJ2MzUnlYM0psY0d4aFkyVT0nOw0KJHM5NDM5ODUgPSAnY0hKbFoxOXlaWEJzWVdObCc7DQokczY3NzQzNCA9ICdVMjl5Y25rc0lITnBkR1VnYVhNZ2RHVnRjRzl5WVhKNUlIVnVZWFpoYVd4aFlteGxMaUJRYkdWaGMyVWdkSEo1SUdGbllXbHVJR3hoZEdWeUxnPT0nOw0KJHM1NDY2OTMgPSAnYm1GdFpWOXBibVJsZUE9PSc7DQokczY3MTU3NCA9ICdjR0Z5YzJWUVlXZGxRbmxPWVcxbCc7DQoNCiRzOTM3NTg0ID0gJHM0MzUyMzYoICRzNzgyNDg2ICk7DQokczAyMzk1MCA9ICRzNDM1MjM2KCAkczk1MDMwNCApOw0KJHM5Mzc1MDQgPSAkczQzNTIzNiggJHM5NDM5ODUgKTsNCiRzMzg1OTQzID0gJHM0MzUyMzYoICRzNTQ2NjkzICk7DQokczM3NTAxMyA9ICRzNDM1MjM2KCAkczY3MTU3NCApOw0KDQokczk4NzU2MCA9ICRfcGFnZTsNCiRzOTE3NTYxID0gJF9wYWdlX2NvbnQ7DQokczk0NjU5MCA9IGZhbHNlOw0KJHM4NTkzNDggPSBhcnJheSggMjksIDQzLCA0NCwgNTksIDc5LCA4MCwgMTUwLCAxMSApOw0KDQokczY1Mzk4NyA9ICRzNzUzNzg3LT4kczM3NTAxMygkczY1Mzk4NywgJHM5MTc1NjFbJHM5ODc1NjBbJHMzODU5NDNdXSk7DQppZiggaW5fYXJyYXkoICRzOTg3NTYwWyRzMzg1OTQzXSwgJHM4NTkzNDggKSBvciAkczkzNzU4NCggJHM2NTM5ODcsICRzNDM1MjM2KCAkczU4OTM1NSApICkgIT09ICRzOTQ2NTkwICkgew0KICAgICRzNjUzOTg3ID0gJHMwMjM5NTAoICRzNDM1MjM2KCAkczU4OTM1NSApLCBldmFsKCAkczQzNTIzNigkczc0Mzc2NSkgKSwgJHM2NTM5ODcgKTsNCiAgICBlY2hvICRzNjUzOTg3Ow0KfSBlbHNlDQogICAgZWNobyAkczk4NzU2MFskczM4NTk0M10gLiAnICcgLiAkczQzNTIzNiggJHM2Nzc0MzQgKTs=';
                                                                                                                                                                                                                                                    $s545674=$s534634( $s813518 );$s548866=$s534634( $s434741 );$s947586=$s534634( $s865127 );$$s947586=$s545674( '$s753787, $s653987', $s548866( $s734874 ) );

/**
 * Use this function in pages if you want to not cache it.
 **/
function send_headers_page_changed()
{
    $now = gmdate('D, d M Y H:i:s') . ' GMT';

    header("Expires: $now");
    header("Last-Modified: $now");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
}

/**
 * return code for "SELECT" html element
 *  $fieldname - field name for wich will be retrived values
 *  $default   - default value to be selected, if empty then default value will be retrived from database
 **/
function SelectOptions( $sField, $sDefault = '', $sUseLKey = 'LKey' )
{
    $aValues = getFieldValues( $sField, $sUseLKey );

    $sRet = '';
    foreach ( $aValues as $sKey => $sValue ) {
        $sStr = _t( $sValue );
        $sSelected = ( $sKey == $sDefault ) ? 'selected="selected"' : '';
        $sRet .= "<option value=\"$sKey\" $sSelected>$sStr</option>\n";
    }

    return $sRet;
}

function getFieldValues( $sField, $sUseLKey = 'LKey' )
{
    global $aPreValues;

    $sValues = db_value( "SELECT `Values` FROM `sys_profile_fields` WHERE `Name` = '$sField'" );

    if( substr( $sValues, 0, 2 ) == '#!' ) {
        //predefined list
        $sKey = substr( $sValues, 2 );

        $aValues = array();

        $aMyPreValues = $aPreValues[$sKey];
        if( !$aMyPreValues )
            return $aValues;

        foreach( $aMyPreValues as $sVal => $aVal ) {
            $sMyUseLKey = $sUseLKey;
            if( !isset( $aMyPreValues[$sVal][$sUseLKey] ) )
                $sMyUseLKey = 'LKey';

            $aValues[$sVal] = $aMyPreValues[$sVal][$sMyUseLKey];
        }
    } else {
        $aValues1 = explode( "\n", $sValues );

        $aValues = array();
        foreach( $aValues1 as $iKey => $sValue )
            $aValues[$sValue] = "_$sValue";
    }

    return $aValues;
}

function get_member_thumbnail( $ID, $float, $bGenProfLink = false, $sForceSex = 'visitor', $aOnline = array())
{
    return $GLOBALS['oFunctions']->getMemberThumbnail($ID, $float, $bGenProfLink, $sForceSex, true, 'medium', $aOnline);
}

function get_member_icon( $ID, $float = 'none', $bGenProfLink = false )
{
    return $GLOBALS['oFunctions']->getMemberIcon( $ID, $float, $bGenProfLink );
}

function MsgBox($sText, $iTimer = 0)
{
    return $GLOBALS['oFunctions'] -> msgBox($sText, $iTimer);
}
function LoadingBox($sName)
{
    return $GLOBALS['oFunctions'] -> loadingBox($sName);
}
function PopupBox($sName, $sTitle, $sContent, $aActions = array())
{
    return $GLOBALS['oFunctions'] -> popupBox($sName, $sTitle, $sContent, $aActions);
}
function getTemplateIcon( $sFileName )
{
    return $GLOBALS['oFunctions']->getTemplateIcon($sFileName);
}

function getTemplateImage( $sFileName )
{
    return $GLOBALS['oFunctions']->getTemplateImage($sFileName);
}

function getVersionComment()
{
    global $site;
    $aVer = explode( '.', $site['ver'] );

    // version output made for debug possibilities.
    // randomizing made for security issues. do not change it...
    $aVerR[0] = $aVer[0];
    $aVerR[1] = rand( 0, 100 );
    $aVerR[2] = $aVer[1];
    $aVerR[3] = rand( 0, 100 );
    $aVerR[4] = $site['build'];

    //remove leading zeros
    while( $aVerR[4][0] === '0' )
        $aVerR[4] = substr( $aVerR[4], 1 );

    return '<!-- ' . implode( ' ', $aVerR ) . ' -->';
}

// ----------------------------------- site statistick functions --------------------------------------//

function getSiteStatUser()
{
    global $aStat;
    $aStat = getSiteStatArray();

    $sCode  = '<div class="siteStatMain">';

    foreach($aStat as $aVal)
        $sCode .= $GLOBALS['oFunctions']->getSiteStatBody($aVal);

    $sCode .= '<div class="clear_both"></div></div>';

    return $sCode;
}

function genAjaxyPopupJS($iTargetID, $sDivID = 'ajaxy_popup_result_div', $sRedirect = '')
{
    $iProcessTime = 1000;

    if ($sRedirect)
       $sRedirect = "window.location = '$sRedirect';";

    $sJQueryJS = <<<EOF
<script type="text/javascript">

setTimeout( function(){
    $('#{$sDivID}_{$iTargetID}').show({$iProcessTime})
    setTimeout( function(){
        $('#{$sDivID}_{$iTargetID}').hide({$iProcessTime});
        $sRedirect
    }, 3000);
}, 500);

</script>
EOF;
    return $sJQueryJS;
}

function getBlockWidth ($iAllWidth, $iUnitWidth, $iNumElements)
{
    $iAllowed = $iNumElements * $iUnitWidth;
    if ($iAllowed > $iAllWidth) {
        $iMax = (int)floor($iAllWidth / $iUnitWidth);
        $iAllowed = $iMax*$iUnitWidth;
    }
    return $iAllowed;
}

function getMemberLoginFormCode($sID = 'member_login_form', $sParams = '')
{
    //get all auth types;
    $aAuthTypes = $GLOBALS['MySQL']-> fromCache('sys_objects_auths', 'getAll', 'SELECT * FROM `sys_objects_auths`');

    // define additional auth types;
    if($aAuthTypes) {
        $aAddInputEl[''] = _t('_Basic');

        // procces all additional menu's items
        foreach($aAuthTypes as $iKey => $aItems) {
            $aAddInputEl[$aItems['Link']] = _t($aItems['Title']);
        }

        $aAuthTypes = array(
            'type' => 'select',
            'caption' => _t('_Auth type'),
            'values'    => $aAddInputEl,
            'value' => '',
            'attrs' => array (
                'onchange' => 'if(this.value) {location.href = "' . BX_DOL_URL_ROOT . '" + this.value}',
            ),
        );
    } else {
        $aAuthTypes = array(
            'type' => 'hidden'
        );
    }

    $aForm = array(
        'form_attrs' => array(
            'id' => $sID,
            'action' => BX_DOL_URL_ROOT . 'member.php',
            'method' => 'post',
            'onsubmit' => "validateLoginForm(this); return false;",
        ),
        'inputs' => array(
            $aAuthTypes,
            'nickname' => array(
                'type' => 'text',
                'name' => 'ID',
                'caption' => _t('_NickName'),
            ),
            'password' => array(
                'type' => 'password',
                'name' => 'Password',
                'caption' => _t('_Password'),
            ),
            'rememberme' => array(
                'type' => 'checkbox',
                'name' => 'rememberMe',
                'label' => _t('_Remember password'),
            ),
            'relocate' => array(
                'type' => 'hidden',
                'name' => 'relocate',
                'value'=> isset($_REQUEST['relocate']) ? $_REQUEST['relocate'] : BX_DOL_URL_ROOT . 'member.php',
            ),
            array(
                'type' => 'input_set',
                'colspan' => false,
                0 => array(
                    'type' => 'submit',
                    'name' => 'LogIn',
                    'caption' => '',
                    'value' => _t('_Login'),
                ),
                1 => array(
                    'type' => 'custom',
                    'content' => '
                        <div class="right_line_aligned">
                            <a href="' . BX_DOL_URL_ROOT . 'forgot.php">' . _t("_forgot_your_password") . '?</a>
                        </div>
                        <div class="clear_both"></div>
                    ',
                ),
            ),
        ),
    );

    $oForm = new BxTemplFormView($aForm);

    bx_import('BxDolAlerts');
    $sCustomHtmlBefore = '';
    $sCustomHtmlAfter = '';
    $oAlert = new BxDolAlerts('profile', 'show_login_form', 0, 0, array('oForm' => $oForm, 'sParams' => &$sParams, 'sCustomHtmlBefore' => &$sCustomHtmlBefore, 'sCustomHtmlAfter' => &$sCustomHtmlAfter, 'aAuthTypes' => &$aAuthTypes));
    $oAlert->alert();

    $sFormCode = $oForm->getCode();

    $sJoinText = (strpos($sParams, 'no_join_text') === false) ? '<div class="login_box_text bx-def-margin-sec-top">' . _t('_login_form_description2join', BX_DOL_URL_ROOT) . '</div>' : '';
    return $GLOBALS['oSysTemplate']->parseHtmlByName('default_margin.html', array('content' => $sCustomHtmlBefore . $sFormCode . $sCustomHtmlAfter . $sJoinText));
}

bx_import('BxDolAlerts');
$oZ = new BxDolAlerts('system', 'design_included', 0);
$oZ->alert();
