<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once( 'header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'db.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'params.inc.php' );

bx_import ('BxDolImageResize');

$gdInstalled = extension_loaded( 'gd' );
$use_gd = getParam( 'enable_gd' ) == 'on' ? 1 : 0;

/**
 * Resizes image given in $srcFilename to dimensions specified with $sizeX x $sizeY and
 * saves it to $dstFilename
 *
 * @param string $srcFilename			- source image filename
 * @param string $dstFilename			- destination image filename
 * @param int $sizeX					- width of destination image
 * @param int $sizeY					- height of destination image
 * @param bool $forceJPGOutput			- always make result in JPG format
 *
 * @return int 							- zero on success, non-zero on fail
 *
 *
 * NOTE: Source image should be in GIF, JPEG or PNG format
*/
function imageResize( $srcFilename, $dstFilename, $sizeX, $sizeY, $forceJPGOutput = false )
{
    $o =& BxDolImageResize::instance($sizeX, $sizeY);
    $o->removeCropOptions ();
    $o->setJpegOutput ($forceJPGOutput);
    $o->setSize ($sizeX, $sizeY);
    if ((($sizeX == 32) && (32 == $sizeY)) || (($sizeX == 64) && (64 == $sizeY)))
        $o->setSquareResize (true);
    else
        $o->setSquareResize (false);
    return $o->resize($srcFilename, $dstFilename);
}

/**
 * Applies watermark to image given in $srcFilename with specified opacity and saves result
 * to $dstFilename
 *
 * @param string $srcFilename			- source image filename
 * @param string $dstFilename			- destination image filename
 * @param string $wtrFilename			- watermark filename
 * @param int $wtrTransparency			- watermark transparency (from 0 to 100)
 *
 * @return int 							- zero on success, non-zero on fail
 *
 *
 * NOTE: Source image should be in GIF, JPEG or PNG format
 * NOTE: if $wtrTransparency = 0 then no action will be done with source image
 *       but if $wtrTransparency = 100 then watermark will fully override source image
*/
function applyWatermark( $srcFilename, $dstFilename, $wtrFilename, $wtrTransparency )
{
    $o =& BxDolImageResize::instance();
    return $o->applyWatermark ($srcFilename, $dstFilename, $wtrFilename, $wtrTransparency);
}

/**
 * Moves and resize uploaded file
 *
 * @param array $aFiles						- system array of uploaded files
 * @param string $fname						- name of "file" form
 * @param string $path_and_name				- path and name of new file to create
 * @param string $maxsize					- max available size (optional)
 * @param boolean $imResize					- call imageResize function immediately (optional)

 *
 * @return int in case of error and extention of new file
 * in case of success
 *
 * NOTE: Source image should be in GIF, JPEG, PNG or BMP format
*/
function moveUploadedImage( $aFiles, $fname, $path_and_name, $maxsize='', $imResize='true' )
{
    global $max_photo_height;
    global $max_photo_width;

    $height = $max_photo_height;
    if ( !$height )
        $height = 400;
    $width = $max_photo_width;
    if ( !$width )
        $width = 400;

    if ( $maxsize && ($aFiles[$fname]['size'] > $maxsize || $aFiles[$fname]['size'] == 0) ) {
        if ( file_exists($aFiles[$fname]['tmp_name']) ) {
            unlink($aFiles[$fname]['tmp_name']);
        }
        return false;
    } else {
        $scan = getimagesize($aFiles[$fname]['tmp_name']);

        if ( ($scan['mime'] == 'image/jpeg' && $ext = '.jpg' ) ||
            ( $scan['mime'] == 'image/gif' && $ext = '.gif' ) ||
            ( $scan['mime'] == 'image/png' && $ext = '.png' ) ) //deleted .bmp format
        {

            $path_and_name .= $ext;
            move_uploaded_file( $aFiles[$fname]['tmp_name'], $path_and_name );

            if ( $imResize )
                imageResize( $path_and_name, $path_and_name, $width, $height );

        } else {
            return IMAGE_ERROR_WRONG_TYPE;
        }
    }

    return $ext;
}
