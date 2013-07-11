<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolMemberInfo');

/**
 * Member info objects.
 */
class BxPhotosMemberInfo extends BxDolMemberInfo
{
    /**
     * Constructor
     * @param $aObject array of member info options
     */
    public function __construct($aObject)
    {
        parent::__construct($aObject);
    }

    /**
     * Get member avatar from profile photos
     */
    public function get ($aData)
    {
        switch ($this->_sObject) {
        case 'bx_photos_thumb':
            $sThumb = BxDolService::call('photos', 'profile_photo', array($aData['ID'], 'thumb'), 'Search');
            return $sThumb ? $sThumb : $GLOBALS['oFunctions']->getSexPic($aData['Sex'], 'medium');
        case 'bx_photos_icon':
            $sIcon = BxDolService::call('photos', 'profile_photo', array($aData['ID'], 'icon'), 'Search');
            return $sIcon ? $sIcon : $GLOBALS['oFunctions']->getSexPic($aData['Sex'], 'small');
        }
        return parent::get($aData);
    }

    public function isAvatarSearchAllowed ()
    {
        return false;
    }
}
