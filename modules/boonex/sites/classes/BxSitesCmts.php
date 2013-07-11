<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

global $tmpl;
require_once(BX_DIRECTORY_PATH_ROOT . 'templates/tmpl_' . $tmpl . '/scripts/BxTemplCmtsView.php');

class BxSitesCmts extends BxTemplCmtsView
{
    /**
     * Constructor
     */
    function BxSitesCmts($sSystem, $iId)
    {
        parent::BxTemplCmtsView($sSystem, $iId);
    }

    /**
     * get full comments block with initializations
     */
    function getCommentsShort($sType)
    {
        return array(
            'cmt_actions' => $this->getActions(0, $sType),
            'cmt_object' => $this->getId(),
            'cmt_addon' => $this->getCmtsInit()
        );
    }
}
