<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolPrivacy');

class BxPhotosPrivacy extends BxDolPrivacy
{
    /**
     * Constructor
     */
    function BxPhotosPrivacy($sTable = 'bx_photos_main', $sId = 'ID', $sOwner = 'Owner')
    {
        parent::BxDolPrivacy($sTable, $sId, $sOwner);
    }

    function getFieldAction($sAction)
    {
        return 'Allow' . str_replace(' ', '', ucwords(str_replace('_', ' ', $sAction)));
    }
}
