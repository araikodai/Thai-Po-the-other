<?php

    /**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

    require_once( BX_DIRECTORY_PATH_CLASSES . 'BxDolModuleDb.php' );

    class BxShoutBoxDb extends BxDolModuleDb
    {
        var $_oConfig;

        var $sTablePrefix;

        /**
         * Constructor.
         */
        function BxShoutBoxDb(&$oConfig)
        {
            parent::BxDolModuleDb();

            $this -> _oConfig = $oConfig;
            $this -> sTablePrefix = $oConfig -> getDbPrefix();
        }

        /**
         * Function will create new message
         *
         * @param  : $sMessage (string)  - message;
         * @param  : $iOwnerId (integer) - message's owner Id;
         * @param $iIP integer
         * @return : void;
         */
        function writeMessage($sMessage, $iOwnerId = 0, $iIP = 0)
        {
            $sMessage = process_db_input($sMessage, 0, BX_SLASHES_AUTO);
            $iOwnerId = (int) $iOwnerId;
            if (!preg_match('/^[0-9]+$/', $iIP))
                $iIP = 0;

            $sQuery =
            "
                INSERT INTO
                    `{$this -> sTablePrefix}messages`
                SET
                    `OwnerID` = {$iOwnerId},
                    `Message` = '{$sMessage}',
                    `Date`    = TIMESTAMP( NOW() ),
                    `IP`	  = {$iIP}
            ";

            $this -> query($sQuery);
        }

        /**
         * Function will return last message's Id;
         *
         * @return : (integer) ;
         */
        function getLastMessageId()
        {
            $sQuery     = "SELECT `ID` FROM `{$this -> sTablePrefix}messages` ORDER BY `ID` DESC LIMIT 1";
            $iLastId    = $this -> getOne($sQuery);

            return ($iLastId) ? $iLastId : 0;
        }

        /**
         * Function will return array with messages;
         *
         * @param : iLastId (integer) - message's last id;
         * return : array();
                [OwnerID] - (integer) message owner's Id;
                [Message] - (string)  message text;
                [Date]    - (string)  message creation data;
         */
        function getMessages($iLastId)
        {
            $iLastId = (int) $iLastId;
            $sQuery = "SELECT * FROM `{$this -> sTablePrefix}messages` WHERE `ID` > " . (int) $iLastId . " ORDER BY `ID`";
            return $this -> getAll($sQuery);
        }

        /**
         * Function will get count of all messages;
         *
         * @return : (integer) - number of messages;
         */
        function getMessagesCount()
        {
            $sQuery = "SELECT COUNT(*) FROM `{$this -> sTablePrefix}messages`";
            return $this -> getOne($sQuery);
        }

        /**
         * get message info
         *
         * @param $iMessageId integer
         * @return array
         */
        function getMessageInfo($iMessageId)
        {
            $iMessageId = (int) $iMessageId;
            $sQuery = "SELECT * FROM `{$this -> sTablePrefix}messages` WHERE `ID` = {$iMessageId}";
            $aInfo = $this -> getAll($sQuery);

            return $aInfo ? array_shift($aInfo) : array();
        }

        /**
         * Delete messages;
         *
         * @param  : $iLimit (integer) - limit of deleted messages;
         * @return : void;
         */
        function deleteMessages($iLimit)
        {
            $iLimit = (int) $iLimit;
            $sQuery = "DELETE FROM `{$this -> sTablePrefix}messages` ORDER BY `ID` LIMIT {$iLimit}";
            $this -> query($sQuery);
        }

        /**
         * Delete message
         *
         * @param $iMessageId integer
         * @return integer
         */
        function deleteMessage($iMessageId)
        {
            $iMessageId = (int) $iMessageId;
            $sQuery = "DELETE  FROM `{$this -> sTablePrefix}messages` WHERE `ID` = {$iMessageId}";
            return $this -> query($sQuery);
        }

        /**
         * Delete messages by IP
         *
         * @param $iIp integer
         * @return void
         */
        function deleteMessagesByIp($iIp)
        {
            $iIp = (int) $iIp;

            $sQuery = "DELETE FROM `{$this -> sTablePrefix}messages` WHERE `IP` = {$iIp}";
            $this -> query($sQuery);
        }

        /**
         * Function will delete all oldest data;
         *
         * @param  : $iLifeTime (integer);
         * @return : void();
         */
        function deleteOldMessages($iLifeTime)
        {
            if( is_numeric($iLifeTime) ) {
                $sQuery = "DELETE FROM `{$this -> sTablePrefix}messages` WHERE FROM_UNIXTIME( UNIX_TIMESTAMP() - {$iLifeTime} ) >= `Date`";
                db_res($sQuery);
            }
        }

        /**
         * Function will return number of global settings category;
         *
         * @return : (integer)
         */
        function getSettingsCategory($sName)
        {
            $sName = $this -> escape($sName);
            return $this -> getOne("SELECT `kateg` FROM `sys_options` WHERE `Name` = '{$sName}'");
        }
    }
