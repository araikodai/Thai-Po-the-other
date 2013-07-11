<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolFilesConfig.php');

class BxSoundsConfig extends BxDolFilesConfig
{
    /**
     * Constructor
     */
    function BxSoundsConfig (&$aModule)
    {
        parent::BxDolFilesConfig($aModule);
        $this->aFilePostfix = array(
            '.mp3',
            '.jpg'
        );
        $this->aGlParams = array(
            'mode_top_index' => 'bx_sounds_mode_index',
            'category_auto_approve' => 'category_auto_activation_bx_sounds',
            'number_all' => 'bx_sounds_number_all',
            'number_index' => 'bx_sounds_number_index',
            'number_user' => 'bx_sounds_number_user',
            'number_related' => 'bx_sounds_number_related',
            'number_top' => 'bx_sounds_number_top',
            'number_browse' => 'bx_sounds_number_browse',
            'number_previous_rated' => 'bx_sounds_number_previous_rated',
            'number_albums_browse' => 'bx_sounds_number_albums_browse',
            'number_albums_home' => 'bx_sounds_number_albums_home',
            'file_width' => 'bx_sounds_file_width',
            'file_height' => 'bx_sounds_file_height',
            'browse_width' => 'bx_sounds_browse_width',
            'browse_height' => 'bx_sounds_browse_height',
            'allowed_exts' => 'bx_sounds_allowed_exts',
            'profile_album_name' => 'bx_sounds_profile_album_name',
        );
    }

    function getFilesPath ()
    {
        return BX_DIRECTORY_PATH_ROOT . 'flash/modules/mp3/files/';
    }

    function getFilesUrl ()
    {
        return BX_DOL_URL_ROOT . 'flash/modules/mp3/';
    }

    function getAllUploaderArray ($sLink = '')
    {
        return array(
            '_adm_admtools_Flash' => array('active' => !isset($_GET['mode']) ? true : false, 'href' => $sLink),
            '_' . $this->sPrefix . '_regular' => array('active' => $_GET['mode'] == 'single' ? true : false, 'href' => $sLink . "&mode=single"),
            '_' . $this->sPrefix . '_record' => array('active' => $_GET['mode'] == 'record' ? true : false, 'href' => $sLink . "&mode=record"),
        );
    }
}
