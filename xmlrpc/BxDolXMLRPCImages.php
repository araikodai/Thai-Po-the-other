<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

class BxDolXMLRPCImages extends BxDolXMLRPCMedia
{

    function removeImage ($sUser, $sPwd, $iImageId)
    {
        if (!($iId = BxDolXMLRPCUtil::checkLogin ($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1,"int")), "struct"));

        if (BxDolService::call('photos', 'remove_object', array((int)$iImageId)))
            return new xmlrpcval ("ok");
        return new xmlrpcval ("fail");
    }

    function makeThumbnail ($sUser, $sPwd, $iImageId)
    {
        if (!($iId = BxDolXMLRPCUtil::checkLogin ($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1,"int")), "struct"));

        switch (getParam('sys_member_info_thumb')) {
        case 'sys_avatar':
            if (BxDolService::call('avatar', 'make_avatar_from_shared_photo_auto', array((int)$iImageId)))
                return new xmlrpcval ("ok");
            break;
        case 'bx_photos_thumb':
            if (BxDolService::call('photos', 'set_avatar', array((int)$iImageId)))
                return new xmlrpcval ("ok");
            break;
        }
        return new xmlrpcval ("fail");
    }

    function getImageAlbums ($sUser, $sPwd, $sNick)
    {
        $iIdProfile = BxDolXMLRPCUtil::getIdByNickname ($sNick);
        if (!$iIdProfile || !($iId = BxDolXMLRPCUtil::checkLogin ($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1,"int")), "struct"));

        // create user's default album if there is no one
        if ($sUser == $sNick) {
            $sCaption = str_replace('{nickname}', $sUser, getParam('bx_photos_profile_album_name'));
            bx_import('BxDolAlbums');
            $oAlbum = new BxDolAlbums('bx_photos');
            $aData = array(
                'caption' => $sCaption,
                'location' => _t('_bx_photos_undefined'),
                'owner' => $iId,
                'AllowAlbumView' => BX_DOL_PG_ALL,
            );
            $oAlbum->addAlbum($aData);
        }

        return BxDolXMLRPCMedia::_getMediaAlbums ('photo', $iIdProfile, $iId, $iIdProfile == $iId);
    }

    function uploadImage ($sUser, $sPwd, $sAlbum, $binImageData, $iDataLength, $sTitle, $sTags, $sDesc)
    {
        if (!($iId = BxDolXMLRPCUtil::checkLogin ($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1,"int")), "struct"));

        if (!BxDolXMLRPCMedia::_isMembershipEnabledFor($iIdProfileViewer, 'BX_PHOTOS_ADD', true))
            return new xmlrpcval ("fail access");

        // write tmp file

        $sTmpFilename = BX_DIRECTORY_PATH_ROOT . "tmp/" . time() . '_' . $iId;
        $f = fopen($sTmpFilename, "wb");
        if (!$f)
            return new xmlrpcval ("fail fopen");
        if (!fwrite ($f, $binImageData, (int)$iDataLength)) {
            fclose($f);
            return new xmlrpcval ("fail write");
        }
        fclose($f);

        // upload
        $aFileInfo = array();
        $aFileInfo['medTitle'] = $sTitle;
        $aFileInfo['medDesc'] = $sDesc;
        $aFileInfo['medTags'] = $sTags;
        $aFileInfo['Categories'] = array ($sAlbum);
        $aFileInfo['album'] = $sAlbum;

        if (BxDolService::call('photos', 'perform_photo_upload', array($sTmpFilename, $aFileInfo, 0, $iId), 'Uploader'))
            return new xmlrpcval ("ok");
        else
            return new xmlrpcval ("fail upload");
    }

    function getImagesInAlbum($sUser, $sPwd, $sNick, $iAlbumId)
    {
        $iIdProfile = BxDolXMLRPCUtil::getIdByNickname ($sNick);
        if (!$iIdProfile || !($iId = BxDolXMLRPCUtil::checkLogin ($sUser, $sPwd)))
            return new xmlrpcresp(new xmlrpcval(array('error' => new xmlrpcval(1,"int")), "struct"));

        return BxDolXMLRPCMedia::_getFilesInAlbum ('photos', $iIdProfile, $iId, (int)$iAlbumId);
    }

}
