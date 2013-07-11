<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolModuleTemplate');

class BxMbpTemplate extends BxDolModuleTemplate
{
    /**
     * Constructor
     */
    function BxMbpTemplate(&$oConfig, &$oDb)
    {
        parent::BxDolModuleTemplate($oConfig, $oDb);
    }
    function displayCurrentLevel($aUserLevel)
    {
        $aLevelInfo = $this->_oDb->getMembershipsBy(array('type' => 'level_id', 'id' => $aUserLevel['ID']));
        if(isset($aUserLevel['DateExpires']))
            $sTxtExpiresIn = _t('_membership_txt_expires_in', floor(($aUserLevel['DateExpires'] - time())/86400));
        else
            $sTxtExpiresIn = _t('_membership_txt_expires_never');

        $this->addCss('levels.css');
        $sContent = $this->parseHtmlByName('current.html', array(
            'id' => $aLevelInfo['mem_id'],
            'title' => $aLevelInfo['mem_name'],
            'icon' =>  $this->_oConfig->getIconsUrl() . $aLevelInfo['mem_icon'],
            'description' => str_replace("\$", "&#36;", $aLevelInfo['mem_description']),
            'expires' => $sTxtExpiresIn
            )
        );

        return array($sContent, array(), array(), false);
    }
    function displayAvailableLevels($aValues)
    {
        $sCurrencyCode = strtoupper($this->_oConfig->getCurrencyCode());
        $sCurrencySign = $this->_oConfig->getCurrencySign();

        $aMemberships = array();
        foreach($aValues as $aValue) {
            $aMemberships[] = array(
                'url_root' => BX_DOL_URL_ROOT,
                'id' => $aValue['mem_id'],
                'title' => $aValue['mem_name'],
                'icon' =>  $this->_oConfig->getIconsUrl() . $aValue['mem_icon'],
                'description' => str_replace("\$", "&#36;", $aValue['mem_description']),
                'days' => $aValue['price_days'] > 0 ?  $aValue['price_days'] . ' ' . _t('_membership_txt_days') : _t('_membership_txt_expires_never') ,
                'price' => $aValue['price_amount'],
                'currency_code' => $sCurrencyCode,
                'add_to_cart' => BxDolService::call('payment', 'get_add_to_cart_link', array(
                    0,
                    $this->_oConfig->getId(),
                    $aValue['price_id'],
                    1,
                    1
                ))
            );
        }

        $this->addCss('levels.css');
        $sContent = $this->parseHtmlByName('available.html', array('bx_repeat:levels' => $aMemberships));

        return array($sContent, array(), array(), false);
    }
}
