<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolMistake');
bx_import('BxDolMailBox');

/**
 * Admin dashboard content.
 *
 *
 * Memberships/ACL:
 * Doesn't depend on user's membership.
 *
 *
 * Alerts:
 * no alerts available
 *
 */
class BxDolAdminDashboard extends BxDolMistake
{
    private $aBlocks;

    /**
     * constructor
     */
    function BxDolAdminDashboard()
    {
        parent::BxDolMistake();

        if (isset($_POST['hide_admin_help']) && $_POST['hide_admin_help']) {
            setParam('sys_show_admin_help', '');
            echo '1';
            exit;
        }

        $this->aBlocks = array(
            'help' => 'on' == getParam('sys_show_admin_help') ? true : false,
            'charts' => true,
            'stats' => true,
        );
    }
    function getCode()
    {
        $sContent = '';

        foreach($this->aBlocks as $sName => $bActive) {
            if(!$bActive)
                continue;

            $sMethod = 'getCode' . str_replace(' ', '', ucwords(str_replace('_', ' ', $sName)));
            if(!method_exists($this, $sMethod))
                continue;

            $sContent .= $this->$sMethod();
        }

        return $sContent;
    }
    function getCodeHelp()
    {
        $sContent = _t('_adm_txt_dashboard_help', BX_DOL_URL_ADMIN, BX_DOL_URL_ROOT);
        $sContent .= '
        <div class="adm-ds-help-btn bx-def-margin-sec-top">
            <script>
                function bx_adm_hide_help()
                {
                    $.post(\'' . BX_DOL_URL_ADMIN . '\', {hide_admin_help:1}, function(data) {
                        $(".adm-ds-help").parents().filter(".disignBoxFirst:first").slideUp(function () {
                            $(this).remove();
                        });
                    });
                }
            </script>
            <button class="bx-btn bx-btn-small" onclick="bx_adm_hide_help()">' . _t('_adm_txt_dashboard_help_dont_show') . '</button>
        </div>';

        return DesignBoxAdmin(_t('_adm_box_cpt_help'), $sContent, '', '', 11);
    }
    function getCodeCharts()
    {
        $aObjects = $GLOBALS['MySQL']->getAll("SELECT * FROM `sys_objects_charts` WHERE `active` = 1 ORDER BY `order` ASC");
        foreach ($aObjects as $k => $a)
            $aObjects[$k]['title'] = _t($a['title']);
        $sContent = $GLOBALS['oAdmTemplate']->parseHtmlByName('dashboard_charts.html', array(
            'admin_url' => BX_DOL_URL_ADMIN,
            'from' => date('Y-m-d', time() - 30*24*60*60),
            'to' => date('Y-m-d', time()),
            'bx_repeat:objects' => $aObjects,
        ));

        // add datepicker
        bx_import('BxTemplFormView');
        $oForm = new BxTemplFormView(array());
        $oForm->addCssJs(true);

        return DesignBoxAdmin(_t('_adm_box_cpt_charts'), $sContent, '', '', 11);
    }
    function getCodeStats()
    {
        $aStats = getSiteStatArray();

        $aTmplItemsCom = $aTmplItemsImp = array();
        foreach($aStats as $aStat) {
            $mixedItem = $this->_getStatsItem($aStat);
            if($mixedItem !== false)
                $aTmplItemsCom[] = $mixedItem;

            $mixedItem = $this->_getStatsItem($aStat, 'adm_');
            if($mixedItem !== false)
                $aTmplItemsImp[] = $mixedItem;
        }

        $sCommonChartData = '';
        foreach ($aTmplItemsCom as $r)
            $sCommonChartData .= ",['" . bx_js_string($r['caption'], BX_ESCAPE_STR_APOS) . "', " . $r['number'] . "]";

        $sContent = $GLOBALS['oAdmTemplate']->parseHtmlByName('dashboard_stats.html', array(
            'bx_repeat:items_common' => $aTmplItemsCom,
            'bx_repeat:items_important' => $aTmplItemsImp,
            'common_chart_data' => $sCommonChartData,
        ));
        return DesignBoxAdmin(_t('_adm_box_cpt_content'), $sContent, '', '', 11);
    }
    function _getStatsItem($aStat, $sPrefix = '')
    {
        if(empty($aStat[$sPrefix . 'query']))
            return false;

        $iNumber = (int)$GLOBALS['MySQL']->getOne($aStat[$sPrefix . 'query']);
        if(!empty($sPrefix) && $iNumber == 0)
            return false;

        $sCaption = _t('_' . $aStat['capt'] . ($sPrefix != '' ? '_' . trim($sPrefix, '_') . '_stats' : ''));
        $bLink = !empty($aStat[$sPrefix . 'link']);
        if($bLink) {
            $aStat[$sPrefix . 'link'] = str_replace(array('{site_url}', '{admin_url}'), array(BX_DOL_URL_ROOT, BX_DOL_URL_ADMIN), $aStat[$sPrefix . 'link']);
            if(substr($aStat[$sPrefix . 'link'], 0, 4) != 'http')
                $aStat[$sPrefix . 'link'] = BX_DOL_URL_ROOT . $aStat[$sPrefix . 'link'];
        }

        return array(
            'number' => $iNumber,
            'caption' => $sCaption,
            'bx_if:show_link' => array(
                'condition' => $bLink,
                'content' => array(
                    'link' => $aStat[$sPrefix . 'link'],
                    'number' => $iNumber,
                    'caption' => $sCaption
                )
            ),
            'bx_if:show_text' => array(
                'condition' => !$bLink,
                'content' => array(
                    'number' => $iNumber,
                    'caption' => $sCaption
                )
            )
        );
    }
}
