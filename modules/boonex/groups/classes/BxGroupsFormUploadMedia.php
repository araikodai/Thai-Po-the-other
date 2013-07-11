<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_groups_import ('FormEdit');

class BxGroupsFormUploadMedia extends BxGroupsFormEdit
{
    function BxGroupsFormUploadMedia ($oMain, $iProfileId, $iEntryId, &$aDataEntry, $sMedia, $aMediaFields)
    {
        parent::BxGroupsFormEdit ($oMain, $iProfileId, $iEntryId, $aDataEntry);

        foreach ($this->_aMedia as $k => $a) {
            if ($k == $sMedia)
                continue;
            unset($this->_aMedia[$k]);
        }

        array_push($aMediaFields, 'Submit', 'id');

        foreach ($this->aInputs as $k => $a) {
            if (in_array($k, $aMediaFields))
                continue;
            unset($this->aInputs[$k]);
        }
    }

}
