<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolFilesPageHome');

class BxPhotosPageHome extends BxDolFilesPageHome
{
    function BxPhotosPageHome (&$oShared)
    {
        parent::BxDolFilesPageHome($oShared);
    }

    function getBlockCode_LatestFile ()
    {
        $this->oSearch->clearFilters(array('activeStatus', 'allow_view', 'album_status', 'albumType', 'ownerStatus'), array('albumsObjects', 'albums'));
        $this->oSearch->aCurrent['restriction']['featured'] = array(
            'field' => 'Featured',
            'value' => '1',
            'operator' => '=',
            'param' => 'featured'
        );
        $this->oSearch->aCurrent['paginate']['perPage'] = 1;
        $aFiles = $this->oSearch->getSearchData();
        return $this->oSearch->getSwitcherUnit($aFiles[0], array('showLink'=>1, 'showRate' => 1, 'showDate' => 1, 'showFrom' => 1));
    }
}
