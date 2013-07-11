<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolMistake');
bx_import('BxTemplFormView');

class BxDolAdminIpBlockList extends BxDolMistake
{
    var $_oDb;
    var $_sActionUrl;

    /**
     * constructor
     */
    function BxDolAdminIpBlockList($sActionUrl = '')
    {
        parent::BxDolMistake();

        $this->_oDb = $GLOBALS['MySQL'];
         $this->_sActionUrl = !empty($sActionUrl) ? $sActionUrl : bx_html_attribute($_SERVER['PHP_SELF']) . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
    }

    function GenStoredMemIPs()
    {
        $sRes = '';

        $sFromC = _t('_From');
        $sMemberC = _t('_Member');
        $sDatatimeC = _t('_Date');

        $sTableRes .= <<<EOF
<table style="width:99%; border-collapse:collapse;" cellpadding="4" style="border-collapse: collapse">
    <tr>
        <td class="bx-def-border">{$sFromC}</td>
        <td class="bx-def-border">{$sMemberC}</td>
        <td class="bx-def-border">{$sDatatimeC}</td>
    </tr>
EOF;

        $sCntSQL = "SELECT COUNT(*) FROM `sys_ip_members_visits`";
        ////////////////////////////
        $iTotalNum = db_value( $sCntSQL );
        if( !$iTotalNum ) {
            return $sRes . MsgBox(_t('_Empty'));
        }
        $iPerPage = (int)$_GET['per_page'];
        if( !$iPerPage )
            $iPerPage = 10;
        $iCurPage = (int)$_GET['page'];
        if( $iCurPage < 1 )
            $iCurPage = 1;
        $sLimitFrom = ( $iCurPage - 1 ) * $iPerPage;
        $sqlLimit = "LIMIT {$sLimitFrom}, {$iPerPage}";
        ////////////////////////////

        $sSQL = "SELECT *, UNIX_TIMESTAMP(`DateTime`) AS `DateTimeTS` FROM `sys_ip_members_visits` ORDER BY `DateTime` DESC {$sqlLimit}";
        $rIPList = db_res( $sSQL );

        while( $aIPList = mysql_fetch_assoc( $rIPList ) ) {
            $iID = (int)$aIPList['ID'];
            $sFrom = long2ip($aIPList['From']);
            $sLastDT = getLocaleDate($aIPList['DateTimeTS'], BX_DOL_LOCALE_DATE);
            $sMember = $aIPList['MemberID'] ? '<a href="' . getProfileLink($aIPList['MemberID']) . '">' . getNickname($aIPList['MemberID']) . '</a>' : '';

            $sTableRes .= "<tr><td class='bx-def-border'>{$sFrom}</td><td class='bx-def-border'>{$sMember}</td><td class='bx-def-border'>{$sLastDT}</td></tr>";
        }

        $sTableRes .= <<<EOF
</table>
<div class="clear_both"></div>
EOF;

        $sRequest = $GLOBALS['site']['url_admin'] . 'ip_blacklist.php?mode=list&page={page}&per_page={per_page}';
        $oPaginate = new BxDolPaginate (
            array
            (
                'page_url'	=> $sRequest,
                'count'		=> $iTotalNum,
                'per_page'	=> $iPerPage,
                'page'		=> $iCurPage,
                'per_page_changer'	 => true,
                'page_reloader'		 => true,
                'on_change_page'	 => null,
                'on_change_per_page' => null,
            )
        );

        $sContent = $GLOBALS['oAdmTemplate']-> parseHtmlByName('design_box_content.html', array(
            'content' => $sRes . $sTableRes
        ));
        return $sContent . $oPaginate -> getPaginate();
    }

    function GenIPBlackListTable()
    {
        $sSitePluginsUrl = BX_DOL_URL_PLUGINS;

        $sFromC = _t('_From');
        $sToC = _t('_To');
        $sTypeC = _t('_adm_ipbl_IP_Role');
        $sDescriptionC = _t('_Description');
        $sDatatimeC = _t('_adm_ipbl_Date_of_finish');
        $sActionC = _t('_Action');
        $sEditC = _t('_Edit');
        $sDeleteC = _t('_Delete');

        $sSQL = "SELECT *, FROM_UNIXTIME(`LastDT`) AS `LastDT_U` FROM `sys_ip_list` ORDER BY `From` ASC";
        $rIPList = db_res( $sSQL );

        $sRows = '';
        while( $aIPList = mysql_fetch_assoc( $rIPList ) ) {
            $iID = (int)$aIPList['ID'];
            $sFrom = long2ip($aIPList['From']);

            $sTo = ($aIPList['To'] == 0) ? '' : long2ip($aIPList['To']);
            $sType = process_html_output($aIPList['Type']);
            $sLastDT_Formatted = getLocaleDate($aIPList['LastDT'], BX_DOL_LOCALE_DATE);
            $sLastDT = preg_replace('/([\d]{2}):([\d]{2}):([\d]{2})/', '$1:$2', $aIPList['LastDT_U']);
            $sDesc = process_html_output($aIPList['Desc']);

            $sRows .= <<<EOF
<tr>
    <td class="bx-def-border">{$sFrom}</td>
    <td class="bx-def-border">{$sTo}</td>
    <td class="bx-def-border">{$sType}</td>
    <td class="bx-def-border">{$sLastDT_Formatted}</td>
    <td class="bx-def-border">{$sDesc}</td>
    <td class="bx-def-border">
        <a href="javascript:void(0)" onclick="ip_accept_values_to_form('{$iID}', '{$sFrom}', '{$sTo}', '{$sType}', '{$sLastDT}', '{$sDesc}'); return false;">{$sEditC}</a> |
        <a href="{$this->_sActionUrl}?action=apply_delete&id={$iID}">{$sDeleteC}</a>
    </td>
</tr>
EOF;
        }

        if (!$sRows)
            return MsgBox(_t('_Empty'));

        return <<<EOF
<table style="width:99%; border-collapse:collapse;" cellpadding="4">
    <tr>
        <td class="bx-def-border">{$sFromC}</td>
        <td class="bx-def-border">{$sToC}</td>
        <td class="bx-def-border">{$sTypeC}</td>
        <td class="bx-def-border">{$sDatatimeC}</td>
        <td class="bx-def-border">{$sDescriptionC}</td>
        <td class="bx-def-border">{$sActionC}</td>
    </tr>
    {$sRows}
</table>
<div class="clear_both"></div>

<script type="text/javascript">
    function ip_accept_values_to_form(id_val, from_val, to_val, type_val, lastdt_val, desc_val)
    {
        $('.form_input_hidden[name="id"]').val(id_val);
        $('.form_input_text[name="from"]').val(from_val);
        $('.form_input_text[name="to"]').val(to_val);
        $('.form_input_select[name="type"]').val(type_val);
        $('.form_input_datetime[name="LastDT"]').val(lastdt_val);
        $('.form_input_text[name="desc"]').val(desc_val);
    }
</script>
EOF;
    }

    function getManagingForm()
    {
        $sApplyChangesC = _t('_sys_admin_apply');
        $sFromC = _t('_From');
        $sToC = _t('_To');
        $sSampleC = _t('_adm_ipbl_sample');
        $sTypeC = _t('_adm_ipbl_IP_Role');
        $sDescriptionC = _t('_Description');
        $sDatatimeC = _t('_adm_ipbl_Date_of_finish');
        $sErrorC = _t('_Error Occured');

        $aForm = array(
            'form_attrs' => array(
                'name' => 'apply_ip_list_form',
                'action' => $this->_sActionUrl,
                'method' => 'post',
            ),
            'params' => array (
                'db' => array(
                    'table' => 'sys_ip_list',
                    'key' => 'ID',
                    'submit_name' => 'add_button',
                ),
            ),
            'inputs' => array(
                'FromIP' => array(
                    'type' => 'text',
                    'name' => 'from',
                    'caption' => $sFromC,
                    'info' => $sSampleC . ': 10.0.0.0',
                    'required' => true,
                    'checker' => array (
                        'func' => 'length',
                        'params' => array(7,15),
                        'error' => $sErrorC,
                    ),
                ),
                'ToIP' => array(
                    'type' => 'text',
                    'name' => 'to',
                    'caption' => $sToC,
                    'info' => $sSampleC . ': 10.0.0.100',
                    'required' => true,
                    'checker' => array (
                        'func' => 'length',
                        'params' => array(7,15),
                        'error' => $sErrorC,
                    ),
                ),
                'IPRole' => array(
                    'type' => 'select',
                    'name' => 'type',
                    'caption' => $sTypeC,
                    'values' => array('allow', 'deny'),
                    'required' => true,
                ),
                'DateTime' => array(
                    'type' => 'datetime',
                    'name' => 'LastDT',
                    'caption' => $sDatatimeC,
                    'required' => true,
                    'checker' => array (
                        'func' => 'DateTime',
                        'error' => $sErrorC,
                    ),
                    'db' => array (
                        'pass' => 'DateTime',
                    ),
                ),
                'Desc' => array(
                    'type' => 'text',
                    'name' => 'desc',
                    'caption' => $sDescriptionC,
                    'required' => true,
                    'checker' => array (
                        'func' => 'length',
                        'params' => array(2,128),
                        'error' => $sErrorC,
                    ),
                    'db' => array (
                        'pass' => 'Xss',
                    ),
                ),
                'ID' => array(
                    'type' => 'hidden',
                    'value' => '0',
                    'name' => 'id',
                ),
                'add_button' => array(
                    'type' => 'submit',
                    'name' => 'add_button',
                    'value' => $sApplyChangesC,
                ),
            ),
        );

        $sResult = '';
        $oForm = new BxTemplFormView($aForm);
        $oForm->initChecker();
        if ($oForm->isSubmittedAndValid()) {
            /*list($iDay, $iMonth, $iYear) = explode( '/', $_REQUEST['datatime']);
            $iDay = (int)$iDay;
            $iMonth = (int)$iMonth;
            $iYear = (int)$iYear;
            //$sCurTime = date("Y:m:d H:i:s");// 2012-06-20 15:46:21
            $sCurTime = "{$iYear}:{$iMonth}:{$iDay} 12:00:00";*/

            $sFrom = sprintf("%u", ip2long($_REQUEST['from']));
            $sTo = sprintf("%u", ip2long($_REQUEST['to']));

            $sType = ((int)$_REQUEST['type']==1) ? 'deny' : 'allow';

            $aValsAdd = array (
                'From' => $sFrom,
                'To' => $sTo,
                /*'LastDT' => $sCurTime,*/
                'Type' => $sType
            );

            $iLastId = ((int)$_REQUEST['id']>0) ? (int)$_REQUEST['id'] : -1;

            if ($iLastId>0) {
                $oForm->update($iLastId, $aValsAdd);
            } else {
                $iLastId = $oForm->insert($aValsAdd);
            }

            $sResult = ($iLastId > 0) ? MsgBox(_t('_Success'), 3) : MsgBox($sErrorC);
        }
        return $sResult . $oForm->getCode();
    }

    function ActionApplyDelete()
    {
        $iID = (int)$_REQUEST['id'];

        if ($iID>0) {
            $sDeleteSQL = "DELETE FROM `sys_ip_list` WHERE `ID`='{$iID}' LIMIT 1";
            db_res($sDeleteSQL);
        }
    }

    function deleteExpired ()
    {
        $iTime = time();
        $r = db_res("DELETE FROM `sys_ip_list` WHERE `LastDT` <= $iTime");
        if ($r && ($iAffectedRows = db_affected_rows())) {
            db_res("OPTIMIZE TABLE `sys_ip_list`");
            return $iAffectedRows;
        } else {
            return 0;
        }
    }
}
