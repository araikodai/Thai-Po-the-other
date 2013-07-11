<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolModuleDb');
bx_import('BxDolIO');

class BxDolInstallerUtils extends BxDolIO
{
    function BxDolInstallerUtils()
    {
        parent::BxDolIO();
    }

    function isXsltEnabled()
    {
        if (((int)phpversion()) >= 5) {
            if (class_exists ('DOMDocument') && class_exists ('XsltProcessor'))
                return true;
        } else {
            if (function_exists('domxml_xslt_stylesheet_file'))
                return true;
            elseif (function_exists ('xslt_create'))
                return true;
        }
        return false;
    }

    function isAllowUrlInclude()
    {
        if (version_compare(phpversion(), "5.2", ">") == 1) {
            $sAllowUrlInclude = ini_get('allow_url_include');
            return !($sAllowUrlInclude == 0);
        };
        return false;
    }

    function isModuleInstalled($sUri)
    {
        $oModuleDb = new BxDolModuleDb();
        return $oModuleDb->isModule($sUri);
    }

    function addHtmlFields ($a)
    {
        $this->_addFields ('html', $a);
    }

    function removeHtmlFields ()
    {
        $this->_removeFields('html');
    }

    function addJsonFields ($a)
    {
        $this->_addFields ('json', $a);
    }

    function removeJsonFields ()
    {
        $this->_removeFields('json');
    }

    function addExceptionsFields ($a)
    {
        $this->_addFields ('exceptions', $a);
    }

    function removeExceptionsFields ()
    {
        $this->_removeFields('exceptions');
    }

    function updateSystemExceptions ()
    {
        $s = getParam('sys_exceptions_fields');
        if (!$s) {
            $a = array ();
        } else {
            $a = unserialize($s);
            unset($a['system']);
        }
        $a['system'] = array(
            'COOKIE.memberSession',
        );
        $s = serialize ($a);
        setParam ('sys_exceptions_fields', $s);
        // recreate cache
        $GLOBALS['MySQL']->cleanCache ('sys_exceptions_fields');
        $GLOBALS['MySQL']->fromCache ('sys_exceptions_fields', 'getOne', "SELECT `VALUE` FROM `sys_options` WHERE `Name` = 'sys_exceptions_fields' LIMIT 1");
    }

    function updateEmailTemplatesExceptions ()
    {
        $s = getParam('sys_exceptions_fields');
        if (!$s) {
            $a = array ();
        } else {
            $a = unserialize($s);
            unset($a['system_email_templates']);
        }
        $a['system_email_templates'] = $this->_getEmailTemplatesHtmlFields();
        $s = serialize ($a);
        setParam ('sys_exceptions_fields', $s);
        // recreate cache
        $GLOBALS['MySQL']->cleanCache ('sys_exceptions_fields');
        $GLOBALS['MySQL']->fromCache ('sys_exceptions_fields', 'getOne', "SELECT `VALUE` FROM `sys_options` WHERE `Name` = 'sys_exceptions_fields' LIMIT 1");
    }

    function updateProfileFieldsHtml ()
    {
        $s = getParam('sys_html_fields');
        if (!$s) {
            $a = array ();
        } else {
            $a = unserialize($s);
            unset($a['system_profile_html']);
        }
        $a['system_profile_html'] = $this->_getSystemProfileHtmlFields();
        $s = serialize ($a);
        setParam ('sys_html_fields', $s);
        // recreate cache
        $GLOBALS['MySQL']->cleanCache ('sys_html_fields');
        $GLOBALS['MySQL']->fromCache ('sys_html_fields', 'getOne', "SELECT `VALUE` FROM `sys_options` WHERE `Name` = 'sys_html_fields' LIMIT 1");
    }

    //--- Protected methods ---//

    function _getEmailTemplatesHtmlFields ()
    {
        $aRet = array ();
        $a = $GLOBALS['MySQL']->getAll ("SELECT `Name` FROM `sys_email_templates`");
        foreach ($a as $r) {
            $aRet[] = 'POST.' . $r['Name'] . '_Body';
            $aRet[] = 'REQUEST.' . $r['Name'] . '_Body';
            $aRet[] = 'POST.' . $r['Name'] . '_Subject';
            $aRet[] = 'REQUEST.' . $r['Name'] . '_Subject';
        }
        return $aRet;
    }

    function _getSystemProfileHtmlFields ()
    {
        $aRet = array ();
        $a = $GLOBALS['MySQL']->getAll ("SELECT `Name` FROM `sys_profile_fields` WHERE `Type` = 'html_area'");
        foreach ($a as $r) {
            $aRet[] = 'POST.' . $r['Name'] . '.0';
            $aRet[] = 'POST.' . $r['Name'] . '.1';
            $aRet[] = 'REQUEST.' . $r['Name'] . '.0';
            $aRet[] = 'REQUEST.' . $r['Name'] . '.1';
        }
        return $aRet;
    }

    function _addFields ($sType, $a)
    {
        switch ($sType) {
        case 'html':
        case 'json':
        case 'exceptions':
            break;
        default:
            return array();
        }

        $s = getParam("sys_{$sType}_fields");
        if (!$s) {
            $a = array ($this->_aConfig['home_uri'] => $a);
        } else {
            $a = array_merge (unserialize($s), array ($this->_aConfig['home_uri'] => $a));
        }
        $s = serialize ($a);
        setParam ("sys_{$sType}_fields", $s);
    }

    function _removeFields ($sType)
    {
        switch ($sType) {
        case 'html':
        case 'json':
        case 'exceptions':
            break;
        default:
            return array();
        }

        $s = getParam("sys_{$sType}_fields");
        if (!$s) {
            return;
        }
        $a = unserialize($s);
        unset ($a[$this->_aConfig['home_uri']]);
        $s = serialize ($a);
        setParam ("sys_{$sType}_fields", $s);
    }

}
