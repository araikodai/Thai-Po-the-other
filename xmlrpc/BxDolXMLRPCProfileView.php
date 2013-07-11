<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once( BX_DIRECTORY_PATH_BASE . 'scripts/BxBaseProfileView.php' );

class BxDolXMLRPCProfileView extends BxBaseProfileGenerator
{
    var $_iViewerId;

    function BxDolXMLRPCProfileView($iProfileId, $iViewerId = 0)
    {
        BxBaseProfileGenerator::BxBaseProfileGenerator ((int)$iProfileId);
        $this->_iViewerId = $iViewerId;
    }

    function getProfileInfoExtra()
    {
        $aRet = array();
        $r = db_res ("SELECT `pc`.`Caption`, `pc`.`Content` FROM `sys_profile_fields` AS `pf` INNER JOIN `sys_page_compose` AS `pc` ON (`pc`.`Func` = 'PFBlock' AND `pc`.`Content` = `pf`.`ID`) WHERE `pc`.`Page` = 'profile' AND `pf`.`Type` = 'block' AND `pc`.`Column` != 0 ORDER BY `pc`.`Column`, `pc`.`Order`");
        while ($a = mysql_fetch_array($r)) {
            $aBlock = $this->getProfileInfoBlock ($a['Caption'], $a['Content']);
            if (false === $aBlock) continue;
            $aRet[] = $aBlock;
        }

        if ($this->_iViewerId == $this->_iProfileID) {

            $aOwnInfo[] = new xmlrpcval (array (
                'Caption' => new xmlrpcval (_t('_E-mail')),
                'Type' => new xmlrpcval ('text'),
                'Value1' => new xmlrpcval ($this->_aProfile['Email']),
            ), "struct");

            $aOwnInfo[] = new xmlrpcval (array (
                'Caption' => new xmlrpcval (_t('_Membership2')),
                'Type' => new xmlrpcval ('text'),
                'Value1' => new xmlrpcval (strip_tags(GetMembershipStatus($this->_iProfileID, false, false))),
            ), "struct");

            $aOwnInfo[] = new xmlrpcval (array (
                'Caption' => new xmlrpcval (_t('_Status')),
                'Type' => new xmlrpcval ('text'),
                'Value1' => new xmlrpcval (_t('__' . $this->_aProfile['Status'])),
            ), "struct");

            $aRet[] = new xmlrpcval (array (
                'Info' => new xmlrpcval ($aOwnInfo, "array"),
                'Title' => new xmlrpcval (_t('_Account Info')),
            ), "struct");
        }

        return new xmlrpcval ($aRet, "array");
    }

    function getProfileInfoBlock($sCaption, $sContent)
    {
        global $site;

        $iBlockID = (int)$sContent;

        if( !isset( $this->aPFBlocks[$iBlockID] ) or empty( $this->aPFBlocks[$iBlockID]['Items'] ) )
            return false;

        $aItems = $this->aPFBlocks[$iBlockID]['Items'];

        $aRet = array ();
        foreach( $aItems as $aItem ) {

            $sValue1 = $this->oPF->getViewableValue( $aItem, $this->_aProfile[ $aItem['Name'] ] );

            if ($aItem['Name'] == 'Age') {
                $sValue1 = (isset($this->_aProfile['DateOfBirth'])) ? age($this->_aProfile['DateOfBirth']) : _t("_uknown");
            }

            if( !$sValue1 ) //if empty, do not draw
                continue;

            $aStruct = array ();

            $aStruct['Caption'] = new xmlrpcval (strip_tags(_t($aItem['Caption'])));
            $aStruct['Type'] = new xmlrpcval ($aItem['Type']);
            $aStruct['Value1'] = new xmlrpcval (strip_tags($sValue1));

            if ($this->bCouple) {
                if (!in_array( $aItem['Name'], $this->aCoupleMutualItems)) {
                    $sValue2 = $this->oPF->getViewableValue($aItem, $this->_aCouple[$aItem['Name']]);
                    $aStruct['Value2'] = new xmlrpcval (strip_tags($sValue2));
                }
            }

            $aRet[] = new xmlrpcval ($aStruct, "struct");
        }

        return new xmlrpcval (array (
            'Info' => new xmlrpcval ($aRet, "array"),
            'Title' => new xmlrpcval (_t($sCaption)),
        ), "struct");
    }
}
