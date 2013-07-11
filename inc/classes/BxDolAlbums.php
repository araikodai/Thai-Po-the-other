<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolMistake.php');

class BxDolAlbums extends BxDolMistake
{
    var $sAlbumTable;
    var $sAlbumObjectsTable;
    var $aAlbumFields;
    var $sType;
    var $sAlbumCoverParam;
    var $iOwnerId;

    function BxDolAlbums ($sType, $iOwnerId = 0)
    {
        $this->iOwnerId = (int)$iOwnerId;
        $this->sType = process_db_input($sType, BX_TAGS_STRIP);
        $this->sAlbumTable = 'sys_albums';
        $this->sAlbumObjectsTable = 'sys_albums_objects';
        $this->aAlbumFields = array('ID', 'Caption', 'Uri', 'Location', 'Description', 'Type', 'Owner', 'Status', 'Date', 'AllowAlbumView', 'ObjCount', 'LastObjId');
        $this->sAlbumCoverParam = 'sys_make_album_cover_last';
    }

    // inner methods
    function _getSqlPart ($aFields = array(), $sBound = ', ')
    {
        $sqlBody = "";
        foreach ($aFields as $sKey => $sValue) {
            if (in_array($sKey, $this->aAlbumFields) && strlen($sValue) > 0) {
                $sValue = process_db_input($sValue, BX_TAGS_STRIP);
                $sqlBody .= "`{$this->sAlbumTable}`.`{$sKey}` = '$sValue'" . $sBound;
            }
        }
        return trim($sqlBody, $sBound);
    }

    function _getSqlSpec($aData)
    {
        $aRes = array(
            'vis' => '',
            'empty' => '',
            'def' => ''
        );
        if (isset($aData['allow_view']) && is_array($aData['allow_view']))
            $aRes['vis'] = " AND `{$this->sAlbumTable}`.`AllowAlbumView` IN (" . implode(',', $aData['allow_view']) . ")";
        if (isset($aData['hide_default']) && $aData['hide_default'] === TRUE)
            $aRes['def'] = " AND `{$this->sAlbumTable}`.`AllowAlbumView` <> " . BX_DOL_PG_HIDDEN;
        if (!isset($aData['show_empty']) || $aData['show_empty'] === FALSE) {
            if (!isset($aData['obj_count']['min']))
                $aData['obj_count']['min'] = 0;
        }
        if (isset($aData['obj_count'])) {
            if (!is_array($aData['obj_count']))
                $aData['obj_count']['min'] = (int)$aData['obj_count'];
            $sqlObjMain = " AND `{$this->sAlbumTable}`.`ObjCount`";
            $sqlMin = isset($aData['obj_count']['min']) ? "$sqlObjMain > " . (int)$aData['obj_count']['min'] : "";
            $sqlMax = isset($aData['obj_count']['max']) ? "$sqlObjMain < " . (int)$aData['obj_count']['max'] : "";
            $aRes['empty'] = "$sqlObjMain $sqlMin $sqlMax";
        }
        return $aRes;
    }

    // album methods
    function addAlbum ($aData = array(), $bCheck = true)
    {
        if ($bCheck) {
            $iCheck = $this->_checkAlbumExistence($aData);
            if ($iCheck != 0)
                return $iCheck;
        }
        $iOwner = (int)$aData['owner'];
        if (isset($aData['AllowAlbumView']))
            $iAllowAlbumView = (int)$aData['AllowAlbumView'];
        elseif (strpos($aData['caption'], getUsername($iOwner)) !== false)
            $iAllowAlbumView = BX_DOL_PG_ALL;
        else
            $iAllowAlbumView = BX_DOL_PG_NOBODY;
        $aFields = array(
            'Caption' => $aData['caption'],
            'Uri' => $this->getCorrectUri($aData['caption'], $iOwner, $bCheck),
            'Location' => $aData['location'],
            'Description' => $aData['description'],
            'AllowAlbumView' =>  $iAllowAlbumView,
            'Type' => $this->sType,
            'Owner' => $iOwner,
            'Status' => getParam('sys_album_auto_app') == 'on' ? 'active' : 'passive',
            'Date' => time(),
            'LastObjId' => isset($aData['lastObjId']) ? (int)$aData['last_obj'] : 0
        );
        $sqlBegin = "";
        $sqlCond = "";
        $sqlBody = $this->_getSqlPart($aFields);
        $sqlBegin = "INSERT INTO ";
        $sqlQuery = "$sqlBegin `{$this->sAlbumTable}` SET $sqlBody $sqlCond";
        $GLOBALS['MySQL']->res($sqlQuery);
        return $GLOBALS['MySQL']->lastId();
    }

    function getCorrectUri ($sCaption, $iOwnerId = 0, $bCheck = true)
    {
        $sUri = uriFilter($sCaption);
        if (!$sUri) $sUri = '-';
        if (!$bCheck) return $sUri;
        if ($this->checkUriUniq($sUri, $iOwnerId)) return $sUri;
        if (get_mb_len($sUri) > 240)
            $sUri = get_mb_substr ($sUri, 0, 240);
        $sUri .= '-' . date('Y-m-d');
        if ($this->checkUriUniq($sUri, $iOwnerId)) return $sUri;
        for ($i = 0; $i < 999; ++$i) {
            if ($this->checkUriUniq($sUri . '-' . $i, $iOwnerId))
                return ($sUri . '-' . $i);
        }
        return time();
    }

    function checkUriUniq ($sUri, $iOwnerId)
    {
        $sUri = process_db_input($sUri, BX_TAGS_STRIP);
        $iOwnerId = (int)$iOwnerId;
        return !$GLOBALS['MySQL']->getRow("SELECT 1 FROM $this->sAlbumTable WHERE `Uri` = '$sUri' AND `Owner` = '$iOwnerId' AND `Type` = '{$this->sType}' LIMIT 1");
    }

    function updateAlbum ($mixedIdent, $aData)
    {
        $sqlWhere = "`Uri` = '" . process_db_input($mixedIdent, BX_TAGS_STRIP) . "'";
        $sqlBody = $this->_getSqlPart($aData);
        $sValue = (int)$aData['Owner'] ? (int)$aData['Owner'] : $this->iOwnerId;
        $sqlWhereAdd = " AND `Owner` = '$sValue'";
        $sqlQuery = "UPDATE `{$this->sAlbumTable}` SET $sqlBody WHERE $sqlWhere $sqlWhereAdd LIMIT 1";
        return $GLOBALS['MySQL']->query($sqlQuery);
    }
    function updateAlbumById ($iId, $aData)
    {
        $sqlWhere = "`ID` = '" . (int)$iId . "'";
        $sqlBody = $this->_getSqlPart($aData);
        $sValue = (int)$aData['Owner'] ? (int)$aData['Owner'] : $this->iOwnerId;
        $sqlWhereAdd = " AND `Owner` = '$sValue'";
        $sqlQuery = "UPDATE `{$this->sAlbumTable}` SET $sqlBody WHERE $sqlWhere $sqlWhereAdd LIMIT 1";
        return $GLOBALS['MySQL']->query($sqlQuery);
    }
    function removeAlbum ($iAlbumId)
    {
        $iAlbumId = (int)$iAlbumId;
        $aObj = $this->getAlbumObjList($iAlbumId);
        $this->removeObject($iAlbumId, $aObj);
        $sqlQuery = "DELETE FROM `{$this->sAlbumTable}` WHERE `ID`='$iAlbumId'";
        $GLOBALS['MySQL']->res($sqlQuery);
    }

    function _checkAlbumExistence ($aData)
    {
        $aFields = array(
            'Caption' => $aData['caption'],
            'Type' => $this->sType,
            'Owner' => (int)$aData['owner'],
        );
        $sqlBody = $this->_getSqlPart($aFields, ' AND');
        $sqlQuery = "SELECT `ID` FROM {$this->sAlbumTable} WHERE $sqlBody";
        return (int)$GLOBALS['MySQL']->getOne($sqlQuery);
    }

    function changeAlbumStatus ($mixedAlbum, $sStatus)
    {
        if ((int)$mixedAlbum != 0)
            $sqlWhere = "`ID`='" . (int)$mixedAlbum . "'";
        else
            $sqlWhere = "`Uri`='" . $mixedAlbum . "'";
        $sStatus = process_db_input($sStatus, BX_TAGS_STRIP);
        $sqlQuery = "UPDATE `{$this->sAlbumTable}` SET `Status` = '$sStatus' WHERE $sqlWhere";
        return $GLOBALS['MySQL']->query($sqlQuery);
    }

    function getAlbumObjList ($mixedAlbum)
    {
        $sqlJoin = "";
        if ((int)$mixedAlbum > 0)
            $sqlWhere = "`id_album`='" . (int)$mixedAlbum . "'";
        else {
            $sqlJoin = "LEFT JOIN `sys_albums` ON `sys_albums_objects`.`id_album` = `sys_albums`.`ID`";
            $sqlWhere = "`sys_albums`.`Uri` = '" . process_db_input($mixedAlbum, BX_TAGS_STRIP) . "'";
        }
        $sqlQuery = "SELECT `id_object` FROM `{$this->sAlbumObjectsTable}` $sqlJoin WHERE $sqlWhere";
        return $GLOBALS['MySQL']->getPairs($sqlQuery, 'id_object', 'id_object');
    }

    function getAlbumCoverFiles ($iAlbumId, $aJoin = array(), $aJoinCond = array(), $iLimit = 4)
    {
        $iAlbumId = (int)$iAlbumId;
        $iLimit = (int)$iLimit;
        $sqlWhere = "`id_album`='$iAlbumId'";
        $sqlAddFields = '';
        if (is_array($aJoin)) {
            $sqlJoin = "INNER JOIN `{$aJoin['table']}` ON `{$aJoin['table']}`.`{$aJoin['field']}`=`{$this->sAlbumObjectsTable}`.`id_object`";
            if (is_array($aJoinCond)) {
                foreach ($aJoinCond as $aValue)
                    $sqlWhere .= " AND `{$aJoin['table']}`.`{$aValue['field']}`='{$aValue['value']}'";
            }
            if (is_array($aJoin['fields_list']))
                $sqlAddFields = ", `" . implode("`, `", $aJoin['fields_list']) . "`";
        }
        $sqlQuery = "SELECT `id_object` $sqlAddFields FROM `{$this->sAlbumObjectsTable}` $sqlJoin WHERE $sqlWhere ORDER BY `obj_order`, `id_object` DESC LIMIT $iLimit";
        return $GLOBALS['MySQL']->getAll($sqlQuery);
    }

    function getAlbumList ($aData = array(), $iPage = 1, $iPerPage = 10, $bSimple = false)
    {
        $aFields = array(
            'Type' => $this->sType,
            'Status' => !isset($aData['status']) ? 'active' : $aData['status'],
            'Caption' => isset($aData['caption']) ? $aData['caption']: '',
        );
        if ($aFields['Status'] == 'any')
            unset($aFields['Status']);
        if (isset($aData['owner']) && strlen($aData['owner']) > 0) {
            if ((int)$aData['owner'] == 0) {
                $iUserId = getID($aData['owner']);
                $aFields['Owner'] = $iUserId > 0 ? $iUserId : '';
            } else
                $aFields['Owner'] = (int)$aData['owner'];
        }

        $aSqlSpec = $this->_getSqlSpec($aData);

        $sqlLimit = "";
        if (!$bSimple) {
            $iPage = (int)$iPage;
            $iPerPage = (int)$iPerPage;
            if ($iPage < 1)
                $iPage = 1;
            if ($iPerPage < 1)
                $iPerPage = 10;

            $sqlLimit = "LIMIT " . ($iPage - 1) * $iPerPage . ", " . $iPerPage;
        }

        $sqlJoin = "";
        $sqlJoinWhere = "";
        if (isset($aData['ownerStatus'])) {
            $sqlJoin = "LEFT JOIN `Profiles` ON `Profiles`.`ID`=`{$this->sAlbumTable}`.`Owner`";
            $sqlJoinWhere = "AND `Profiles`.`Status` ";
            if (is_array($aData['ownerStatus']))
                $sqlJoinWhere .= "NOT IN ('" . implode("','", $aData['ownerStatus']) . "')";
            else
                $sqlJoinWhere .= "<> '{$aData['ownerStatus']}'";
        }

        $sqlBegin = "SELECT `{$this->sAlbumTable}`.* FROM `{$this->sAlbumTable}` $sqlJoin";
        $sqlCond  = "WHERE " . $this->_getSqlPart($aFields, ' AND ');
        $sqlOrder = "ORDER BY `{$this->sAlbumTable}`.`Date` DESC";
        $sqlQuery = "$sqlBegin $sqlCond {$aSqlSpec['vis']} {$aSqlSpec['def']} {$aSqlSpec['empty']} $sqlJoinWhere $sqlOrder $sqlLimit";
        return $GLOBALS['MySQL']->getAll($sqlQuery);
    }

    function getAlbumCount ($aData = array())
    {
        $aFields = array(
            'Type' => $this->sType,
            'Status' => !isset($aData['status']) ? 'active' : $aData['status'],
        );
        if (isset($aData['owner']) && strlen($aData['owner']) > 0) {
            if ((int)$aData['owner'] == 0) {
                $iUserId = getID($aData['owner']);
                $aFields['Owner'] = $iUserId > 0 ? $iUserId : '';
            } else
                $aFields['Owner'] = (int)$aData['owner'];
        }
        $aSqlSpec = $this->_getSqlSpec($aData);

        $sqlJoin = "";
        $sqlJoinWhere = "";
        if (isset($aData['ownerStatus'])) {
            $sqlJoin = "LEFT JOIN `Profiles` ON `Profiles`.`ID`=`{$this->sAlbumTable}`.`Owner`";
            $sqlJoinWhere = "AND `Profiles`.`Status` ";
            if (is_array($aData['ownerStatus']))
                $sqlJoinWhere .= "NOT IN ('" . implode("','", $aData['ownerStatus']) . "')";
            else
                $sqlJoinWhere .= "<> '{$aData['ownerStatus']}'";
        }

        $sqlBegin = "SELECT COUNT(*) FROM `{$this->sAlbumTable}` $sqlJoin";
        $sqlCond  = "WHERE " . $this->_getSqlPart($aFields, ' AND ');
        $sqlQuery = "$sqlBegin $sqlCond {$aSqlSpec['vis']} {$aSqlSpec['def']} {$aSqlSpec['empty']} $sqlJoinWhere";
        return $GLOBALS['MySQL']->getOne($sqlQuery);
    }

    function getAlbumInfo ($aIdent = array(), $aFields = array())
    {
        $sqlCondition = "`{$this->sAlbumTable}`.`Type`='{$this->sType}'";
        $aParams = array();
        foreach($aIdent as $sKey => $sValue) {
            switch (strtolower($sKey)) {
                case 'fileuri':
                    $aParams['Uri'] = $sValue;
                    break;
                case 'fileid':
                    $aParams['ID'] = (int)$sValue;
                    break;
                case 'owner':
                    $aParams['Owner'] = (int)$sValue;
                    break;
                default:
                    $aParams[$sKey] = $sValue;
            }
        }
        $aParams['Type'] = $this->sType;
        if (count($aFields) == 0)
            $aFields = $this->aAlbumFields;
        $sqlCondition = $this->_getSqlPart($aParams, ' AND ');
        foreach ($aFields as $sValue) {
            if (in_array($sValue, $this->aAlbumFields))
                $sqlFields .= "`{$this->sAlbumTable}`.`$sValue`, ";
        }
        $sqlFields = trim($sqlFields, ', ');
        $sqlQuery = "SELECT $sqlFields FROM `{$this->sAlbumTable}` WHERE $sqlCondition LIMIT 1";
        return $GLOBALS['MySQL']->getRow($sqlQuery);
    }

    function getAlbumName ($iAlbumId)
    {
        $aValue = $this->getAlbumInfo(array('fileId' => (int)$iAlbumId), array('Caption'));
        return $aValue['Caption'];
    }

    function getAlbumDefaultName ()
    {
        return getParam('sys_album_default_name');
    }

    // album's objects methods
    function addObject ($iAlbumId, $mixedObj, $bUpdateCount = true)
    {
        $iAlbumId = (int)$iAlbumId;
        if ($iAlbumId == 0)
            return;
        $sqlFields = "`id_album`, `id_object`";
        $sqlBody = "";
        $iLastObjId = $this->getLastObj($iAlbumId);
        $iCount = 0;
        if (is_array($mixedObj)) {
            foreach ($mixedObj as $iValue) {
                $iValue = (int)$iValue;
                $sqlBody .= "('$iAlbumId', '$iValue'), ";
                $iCount++;
            }
        } else {
            $iValue = (int)$mixedObj;
            $sqlBody = "('$iAlbumId', '$iValue')";
            $iCount++;
        }
        $sqlQuery = "INSERT INTO `{$this->sAlbumObjectsTable}` ($sqlFields) VALUES " . trim($sqlBody, ', ');
        $iRes = $GLOBALS['MySQL']->query($sqlQuery);

        if ($bUpdateCount) {
            $this->updateObjCounter($iAlbumId, $iCount);
            if ($iLastObjId == 0)
                $this->updateLastObj($iAlbumId, $iValue);
            elseif ($iLastObjId !=0 && getParam($this->sAlbumCoverParam) == 'on')
                $this->updateLastObj($iAlbumId, $iValue);
        }
        return $iRes;
    }

    function moveObject ($iAlbumId, $iNewAlbumId, $mixedObj)
    {
        $iAlbumId = (int)$iAlbumId;
        $iNewAlbumId = (int)$iNewAlbumId;
        $sqlBody = "";
        $iLastObjId = $this->getLastObj($iAlbumId);
        if (!empty($mixedObj)) {
            $iCount = 0;
            if (is_array($mixedObj)) {
                if (in_array($iLastObjId, $mixedObj))
                    $bUpdateLastObj = true;
                foreach ($mixedObj as $iValue) {
                    $iValue = (int)$iValue;
                    $sqlBody .= "'$iValue', ";
                    $iCount++;
                }
            } else {
                $iValue = (int)$mixedObj;
                $sqlBody = "'$iValue'";
                $iCount++;
                if ($iValue == $iLastObjId)
                    $bUpdateLastObj = true;
            }
            $sqlQuery = "UPDATE `{$this->sAlbumObjectsTable}`, `{$this->sAlbumTable}`
                            SET `{$this->sAlbumObjectsTable}`.`id_album` = $iNewAlbumId
                         WHERE `{$this->sAlbumObjectsTable}`.`id_album`=`{$this->sAlbumTable}`.`ID`
                         AND `{$this->sAlbumTable}`.`Type` = '$this->sType' AND `{$this->sAlbumObjectsTable}`.`id_object` IN (".trim($sqlBody, ', ').")";
            $GLOBALS['MySQL']->res($sqlQuery);
            if ($bUpdateLastObj)
                $this->updateLastObj($iAlbumId);
            $this->updateLastObj($iNewAlbumId);

            $sqlQuery = "UPDATE `{$this->sAlbumTable}` SET `ObjCount` = CASE
                WHEN `ID`={$iAlbumId} THEN `ObjCount`-$iCount
                WHEN `ID`={$iNewAlbumId} THEN `ObjCount`+$iCount END
                WHERE `ID` IN ($iAlbumId, $iNewAlbumId)";
            $GLOBALS['MySQL']->res($sqlQuery);
        }
    }

    function removeObject ($iAlbumId, $mixedObj, $bUpdateCount = true)
    {
        $iAlbumId = (int)$iAlbumId;
        $sqlBody = "";
        $iLastObjId = $this->getLastObj($iAlbumId);
        $iCount = 0;
        if (!empty($mixedObj)) {
            if (is_array($mixedObj)) {
                if (in_array($iLastObjId, $mixedObj))
                    $bUpdateLastObj = true;
                foreach ($mixedObj as $iValue) {
                    $iValue = (int)$iValue;
                    $sqlBody .= "'$iValue', ";
                    $iCount++;
                }
            } else {
                $iValue = (int)$mixedObj;
                $sqlBody = "'$iValue'";
                if ($iValue == $iLastObjId)
                    $bUpdateLastObj = true;
                $iCount++;
            }
            $sqlQuery = "DELETE `{$this->sAlbumObjectsTable}`
                            FROM `{$this->sAlbumObjectsTable}`, `{$this->sAlbumTable}`
                         WHERE `{$this->sAlbumObjectsTable}`.`id_album`=`{$this->sAlbumTable}`.`ID`
                         AND `{$this->sAlbumTable}`.`Type` = '$this->sType' AND `{$this->sAlbumObjectsTable}`.`id_object` IN (".trim($sqlBody, ', ').")";
            $GLOBALS['MySQL']->res($sqlQuery);
            if ($bUpdateLastObj)
                $this->updateLastObj($iAlbumId);
            if ($bUpdateCount)
                $this->updateObjCounter($iAlbumId, $iCount, false);
        }
    }

    function removeObjectTotal ($iObj, $bUpdateCounter = true)
    {
            $iObj = (int)$iObj;
            $sqlQuery = "SELECT `id_album` as `ID`, `ObjCount`, `LastObjId`
                         FROM `{$this->sAlbumObjectsTable}`
                         LEFT JOIN `{$this->sAlbumTable}` ON `{$this->sAlbumTable}`.`ID` = `{$this->sAlbumObjectsTable}`.`id_album`
                         WHERE `id_object` = '$iObj' AND `$this->sAlbumTable`.`Type` = '$this->sType'";
            $aInfo = $GLOBALS['MySQL']->getRow($sqlQuery);
            $sqlDelete = "DELETE FROM `{$this->sAlbumObjectsTable}` WHERE `id_album`='{$aInfo['ID']}' AND `id_object`='$iObj' LIMIT 1";
            $GLOBALS['MySQL']->res($sqlDelete);
            if ($aInfo['ObjCount'] > 0 && $bUpdateCounter)
                $this->updateObjCounter($aInfo['ID'], 1, false);
            if ($aInfo['LastObjId'] == $iObj)
                $this->updateLastObj($aInfo['ID']);
    }

    function sortObjects ($sAlbumUri, $aSort = array())
    {
        $aAlbumInfo = $this->getAlbumInfo(array('fileUri' => $sAlbumUri, 'owner' => $this->iOwnerId), array('ID'));
        $sqlBegin = "UPDATE `{$this->sAlbumObjectsTable}` SET `obj_order` = ";
        $sqlAlbumPart = " `id_album`='{$aAlbumInfo['ID']}'";
        $iNum = is_array($aSort) ? count($aSort) : 0;
        if ($iNum > 0) {
            $sqlBegin .= " CASE ";
            $sqlWhere = "WHERE `id_object` IN (";
            for ($i = 0; $i < $iNum; $i++) {
                $iElem = (int)$aSort[$i];
                $sqlBegin .= " WHEN `id_object`='$iElem' THEN '$i'";
                $sqlWhere .= "$iElem, ";
            }
            $sqlQuery = $sqlBegin . " END " . trim($sqlWhere, ', ') . ") AND $sqlAlbumPart";
        } else
            $sqlQuery = $sqlBegin . " `id_object` WHERE $sqlAlbumPart";
        $GLOBALS['MySQL']->query($sqlQuery);
    }

    function updateLastObj ($iAlbumId, $iObjId = 0)
    {
        $iAlbumId = (int)$iAlbumId;
        $iObjId = (int)$iObjId;
        if ($iObjId == 0) {
            $sqlQuery = "SELECT MAX(`id_object`) FROM `{$this->sAlbumObjectsTable}` WHERE `id_album` = '{$iAlbumId}'";
            $iObjId = (int)db_value($sqlQuery);
        }
        $sqlQuery = "UPDATE `{$this->sAlbumTable}` SET `LastObjId`='$iObjId' WHERE `ID`='{$iAlbumId}'";
        return $GLOBALS['MySQL']->query($sqlQuery);
    }

    function updateLastObjById ($iObjId)
    {
        $iObjId = (int)$iObjId;
        $sqlQuery = "UPDATE `{$this->sAlbumTable}`, `{$this->sAlbumObjectsTable}`
                     SET `LastObjId` = $iObjId
                     WHERE `{$this->sAlbumTable}`.`ID`=`{$this->sAlbumObjectsTable}`.`id_album`
                     AND `{$this->sAlbumObjectsTable}`.`id_object`=$iObjId
                     AND `{$this->sAlbumTable}`.`Type`='{$this->sType}'";
        return $GLOBALS['MySQL']->query($sqlQuery);
    }

    function getLastObj ($iAlbumId)
    {
        $iAlbumId = (int)$iAlbumId;
        $sqlQuery = "SELECT `LastObjId` FROM `{$this->sAlbumTable}` WHERE `ID`='{$iAlbumId}' AND `Type`='{$this->sType}'";
        return $GLOBALS['MySQL']->getOne($sqlQuery);
    }

    // calculate closest object in album for current element
    function getClosestObj ($iAlbumId, $iObjectId, $sType = 'next', $iOrder = 0, $aExcludeIds = array())
    {
        $iAlbumId = (int)$iAlbumId;
        $iObjectId = (int)$iObjectId;
        $iOrder = (int)$iOrder;
        $sType = strip_tags($sType);
        $bOrder = true;
        if ($iOrder == 0) {
            $sqlCheck = "SELECT COUNT(*) FROM `$this->sAlbumObjectsTable` WHERE `id_album`=$iAlbumId AND `obj_order`>0";
            $iCheck = (int)db_value($sqlCheck);
            $bOrder = $iCheck > 0 ? true : false;
        }

        if ($iOrder == 0 && !$bOrder) {
            $sqlField = "id_object";
            $sqlValue = $iObjectId;
            $sKey = 'prev';
        } else {
            $sqlField = "obj_order";
            $sqlValue = $iOrder;
            $sKey = 'next';
        }

        if ($sType == $sKey) {
            $sSign = ">";
            $sqlType = "ASC";
        } else {
            $sSign = "<";
            $sqlType = "DESC";
        }

        $sqlIds = "";
        if (is_array($aExcludeIds) && !empty($aExcludeIds))
            $sqlIds = "AND `id_object` NOT IN ('" . implode("','", $aExcludeIds) . "')";

        $sqlQuery = "SELECT `id_object` FROM `$this->sAlbumObjectsTable`
                     WHERE `id_album`=$iAlbumId AND `$sqlField`$sSign $sqlValue $sqlIds
                     ORDER BY `$sqlField` $sqlType LIMIT 1";
        return (int)db_value($sqlQuery);
    }

    function getObjCount ($aIdent)
    {
        $aInfo = $this->getAlbumInfo($aIdent, array('ObjCount'));
        return $aInfo['ObjCount'];
    }

    function getObjTotalCount ($aData = array())
    {
        $aFields = array(
            'Type' => $this->sType,
            'Status' => !isset($aData['status']) ? 'active' : $aData['status'],
        );
        if (isset($aData['owner'])) {
            if ((int)$aData['owner'] == 0) {
                $iUserId = getID($aData['owner']);
                $aFields['Owner'] = $iUserId > 0 ? $iUserId : '';
            } else
                $aFields['Owner'] = (int)$aData['owner'];
        }
        $sqlQuery = "SELECT SUM(`ObjCount`) FROM `{$this->sAlbumTable}` WHERE " . $this->_getSqlPart($aFields, ' AND ');
        return (int)$GLOBALS['MySQL']->getOne($sqlQuery);
    }

    function calcObjCount ($iAlbumId)
    {
        $iAlbumId = (int)$iAlbumId;
        $sqlQuery = "SELECT COUNT(*) FROM `{$this->sAlbumObjectsTable}` WHERE `id_album`='$iAlbumId'";
        return $GLOBALS['MySQL']->getOne($sqlQuery);
    }

    function updateObjCounter ($iAlbumId, $iNumber, $bIncrease = true)
    {
        $iAlbumId = (int)$iAlbumId;
        $iNumber = (int)$iNumber;
        $sOperator = $bIncrease ? '+' : '-';
        $sqlQuery = "UPDATE `{$this->sAlbumTable}` SET `ObjCount`=`ObjCount` $sOperator $iNumber WHERE `ID`='{$iAlbumId}'";
        $GLOBALS['MySQL']->res($sqlQuery);
    }

    function updateObjCounterById ($iObjId, $bIncrease = true)
    {
        $iObjId = (int)$iObjId;
        $sOperator = $bIncrease ? '+' : '-';
        $sqlQuery = "UPDATE `{$this->sAlbumTable}`, `{$this->sAlbumObjectsTable}`
                     SET `ObjCount` = `ObjCount` $sOperator 1
                     WHERE `{$this->sAlbumTable}`.`ID`=`{$this->sAlbumObjectsTable}`.`id_album`
                     AND `{$this->sAlbumObjectsTable}`.`id_object`=$iObjId
                     AND `{$this->sAlbumTable}`.`Type`='{$this->sType}'";
        $GLOBALS['MySQL']->res($sqlQuery);
    }
}
