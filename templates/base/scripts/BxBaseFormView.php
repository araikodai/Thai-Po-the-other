<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once( BX_DIRECTORY_PATH_CLASSES . 'BxDolForm.php' );

class BxBaseFormView extends BxDolForm
{
    var $aWrappedInputTypes = array (
        'text' => 1,
        'email' => 1,
        'url' => 1,
        'date' => 1,
        'datetime' => 1,
        'password' => 1,
        'number' => 1,
        'slider' => 1,
        'range' => 1,
        'doublerange' => 1,
        'textarea' => 1,
        'select_multiple' => 1,
    );

    var $bEnableErrorIcon = true;

    /**
     * HTML Code of this form
     *
     * @var string
     */
    var $sCode;

    /**
     * Code which will be added to the beginning of the form.
     * For example, hidden inputs.
     * For internal use only
     *
     * @var string
     */
    var $_sCodeAdd = '';

    var $_isTbodyOpened = false;

    var $_isDateControl = false;
    var $_isDateTimeControl = false;

    /**
     * Constructor
     *
     * @param array $aInfo Form contents
     *
     * $aInfo['params'] = array(
     *     'remove_form' => true|false,
     * );
     *
     * @return BxBaseFormView
     */
    function BxBaseFormView($aInfo)
    {
        parent::BxDolForm($aInfo);
    }

    /**
     * Return Form code
     *
     * @return string
     */
    function getCode()
    {
        return ($this->sCode = $this->genForm());
    }

    /**
     * Generate the whole form
     *
     * @return string
     */
    function genForm()
    {
        $this->_sCodeAdd = '';

        $sTable = $this->genTable();

        if (!empty($this->aParams['remove_form'])) {
            $sForm = <<<BLAH
                    {$this->_sCodeAdd}
                    <div class="form_advanced_wrapper {$this->id}_wrapper">
                        $sTable
                    </div>
BLAH;
        } else {
            // add default className to attributes
            $this->aFormAttrs['class'] = 'form_advanced' . (isset($this->aFormAttrs['class']) ? (' ' . $this->aFormAttrs['class']) : '');

            $sFormAttrs = $this->convertArray2Attrs($this->aFormAttrs);

            $sForm = <<<BLAH
                <form $sFormAttrs>
                    {$this->_sCodeAdd}
                    <div class="form_advanced_wrapper {$this->id}_wrapper">
                        $sTable
                    </div>
                </form>
BLAH;
        }

        return $sForm;
    }

    /**
     * Generate Table HTML code
     *
     * @return string
     */
    function genTable()
    {
        // add default className to attributes
        $this->aTableAttrs['class'] = 'form_advanced_table' . (isset($this->aTableAttrs['class']) ? (' ' . $this->aTableAttrs['class']) : '');

        // default cellpadding
        if (!isset($this->aTableAttrs['cellpadding']))
            $this->aTableAttrs['cellpadding'] = 0;

        // default cellspacing
        if (!isset($this->aTableAttrs['cellspacing']))
            $this->aTableAttrs['cellspacing'] = 0;

        $sTableAttrs = $this->convertArray2Attrs($this->aTableAttrs);

        // add CSRF token if it's needed.
        if($GLOBALS['MySQL']->getParam('sys_security_form_token_enable') == 'on' && (!isset($this->aParams['csrf']['disable']) || (isset($this->aParams['csrf']['disable']) && $this->aParams['csrf']['disable'] !== true)) && ($mixedCsrfToken = BxDolForm::getCsrfToken()) !== false)
            $this->aInputs['csrf_token'] = array(
                'type' => 'hidden',
                'name' => 'csrf_token',
                'value' => $mixedCsrfToken,
                'db' => array (
                    'pass' => 'Xss',
                )
            );

        // generate table contents
        $sTableCont = '';
        foreach ($this->aInputs as $aInput)
            $sTableCont .= $this->genRow($aInput);

        $sOpenTbody  = $this->getOpenTbody();
        $sCloseTbody = $this->getCloseTbody();

        // generate table
        $sTable = <<<BLAH
            <table $sTableAttrs>
                $sOpenTbody
                    $sTableCont
                $sCloseTbody
            </table>
BLAH;

        $this->addCssJs($this->_isDateControl, $this->_isDateTimeControl);

        return $sTable;
    }

    /**
     * Generate single Table Row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRow(&$aInput)
    {
        switch ($aInput['type']) {
            case 'headers':
                $sRow = $this->genRowHeaders($aInput);
            break;

            case 'block_header':
                $sRow = $this->genRowBlockHeader($aInput);
            break;

            case 'block_end':
                $sRow = $this->genBlockEnd($aInput);
            break;

            case 'hidden':
                // do not generate row for hidden inputs
                            $sRow = '';
                $this->_sCodeAdd .= $this->genInput($aInput);
            break;

            case 'select_box':
                $sRow = $this->genRowSelectBox($aInput);
            break;

            default:
                $sRow = $this->genRowStandard($aInput);
        }

        return $sRow;
    }

    /**
     * Generate standard row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRowStandard(&$aInput)
    {
        $sCaption   = (!empty($aInput['caption']))
            ? ($aInput['caption'] . ': ')
            : (!empty($aInput['colspan']) ? '' : '&nbsp;');

        $sRequired  = (!empty($aInput['required']))? '<span class="required">*</span>&#160;'  : '';

        $sClassAdd  = (!empty($aInput['error']))   ? ' error'                            : '';
        $sInfoIcon  = (!empty($aInput['info']))    ? $this->genInfoIcon($aInput['info']) : '';

        $sErrorIcon = $this->genErrorIcon(empty($aInput['error']) ? '' : $aInput['error']);

        $sTrAttrs = $this->convertArray2Attrs(empty($aInput['tr_attrs']) ? '' : $aInput['tr_attrs']);

        if (isset($aInput['attrs']) && isset($aInput['value']) && is_array ($aInput['value']) && $aInput['attrs']['multiplyable']) {
            $sValFirst = array_shift($aInput['value']);
            $aInputCopy = $aInput;
            $aInputCopy['value'] = $sValFirst;
            $sInputCopy = $this->genInput($aInputCopy);
            $sInputCode = $this->genWrapperInput($aInputCopy, $sInputCopy);
            $sInputCodeExtra = '';
            foreach ($aInput['value'] AS $v) {
                unset($aInputCopy['attrs']['multiplyable']);
                $aInputCopy['attrs']['deletable'] = 'true';
                $aInputCopy['value'] = $v;
                $sInputCopy = $this->genInput($aInputCopy);
                $sInputCodeExtra .= '<div class="clear_both"></div>' . $this->genWrapperInput($aInputCopy, $sInputCopy);
            }
        } else {
            $sInput     = $this->genInput($aInput);
            $sInputCode = $this->genWrapperInput($aInput, $sInput);
        }

        $sCode = '';

        $sCode .= $this->getOpenTbody();

        $sInputCodeBottom = '';
        if (isset($aInput['html']) && $aInput['html_toggle'])
            $sInputCodeBottom = '<div class="form_input_toggle_html"><a href="javascript:void(0);" onclick="$(\'#' . $aInput['attrs']['id'] . '\').formsToggleHtmlEditor()">' . _t('_sys_txt_form_toggle_html_editor') . '</a></div>';

        if (!empty($aInput['colspan'])) { // colspan row
            if (empty($sButtonAdd)) $sButtonAdd = '';
            if (empty($sInputCode)) $sInputCode = '';
            if (empty($sInputCodeExtra)) $sInputCodeExtra = '';
            $sCode .= <<<BLAH
                    <tr $sTrAttrs>
                        <td class="colspan$sClassAdd" colspan="2">
                            <div class="clear_both"></div>
                            $sRequired
                            $sCaption
                            $sInputCode
                            $sButtonAdd
                            $sInfoIcon
                            $sErrorIcon
                            $sInputCodeExtra
                            <div class="clear_both"></div>
                            $sInputCodeBottom
                        </td>
                    </tr>
BLAH;
        } else { // simple row
            if (empty($sInputCodeExtra)) $sInputCodeExtra = '';
            if (empty($sButtonAdd)) $sButtonAdd = '';
            if (empty($sInfoIcon)) $sInfoIcon = '';
            if (empty($sInputCode)) $sInputCode = '';
            if (empty($sErrorIcon)) $sErrorIcon = '';
            $sCode .= <<<BLAH
                <tr $sTrAttrs>
                    <td class="caption">
                        $sRequired
                        $sCaption
                    </td>

                    <td class="value$sClassAdd">
                        <div class="clear_both"></div>
                        $sInputCode
                        $sButtonAdd
                        $sInfoIcon
                        $sErrorIcon
                        $sInputCodeExtra
                        <div class="clear_both"></div>
                        $sInputCodeBottom
                    </td>
                </tr>
BLAH;
        }

        return $sCode;
    }


    function genWrapperInput($aInput, $sContent)
    {
        $sAttr = isset($aInput['attrs_wrapper']) && is_array($aInput['attrs_wrapper']) ? $this->convertArray2Attrs($aInput['attrs_wrapper']) : '';

        $sClassAdd = '';
        if (isset($this->aWrappedInputTypes[$aInput['type']]))
            $sClassAdd = 'bx-def-round-corners-with-border';

        $sCode = <<<BLAH
                        <div class="input_wrapper input_wrapper_{$aInput['type']} $sClassAdd" $sAttr>
                            $sContent
                        </div>
BLAH;

        return $sCode;
    }

    /**
     * Generate select_box row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRowSelectBox(&$aInput)
    {
        $sCaption   = (!empty($aInput['caption'])) ? ($aInput['caption'] . ': ')         : '&nbsp;';
        $sRequired  = (!empty($aInput['required'])) ? '<span class="required">*</span>&#160;'  : '';

        $sClassAdd  = (!empty($aInput['error']))   ? ' error'                            : '';
        $sInfoIcon  = (!empty($aInput['info']))    ? $this->genInfoIcon($aInput['info']) : '';

        $sErrorIcon = $this->genErrorIcon(empty($aInput['error']) ? '' : $aInput['error']);
        $sInput     = $this->genInputSelectBox($aInput, $sInfoIcon, $sErrorIcon);

        $sTrAttrs = $this->convertArray2Attrs(empty($aInput['tr_attrs']) ? array() : $aInput['tr_attrs']);

        $sCode = '';

        $sCode .= $this->getOpenTbody();

        if (!empty($aInput['colspan'])) { // colspan row

            $sCode .= <<<BLAH
                <tr $sTrAttrs>
                    <td class="colspan$sClassAdd" colspan="2">
                        <div class="clear_both"></div>
                        $sInput
                        <div class="clear_both"></div>
                    </td>
                </tr>
BLAH;
        } else { // simple row

            $sCode .= <<<BLAH
                <tr $sTrAttrs>
                    <td class="caption">
                        $sRequired
                        $sCaption
                    </td>

                    <td class="value$sClassAdd">
                        <div class="clear_both"></div>
                            $sInput
                        <div class="clear_both"></div>
                    </td>
                </tr>
BLAH;
        }

        return $sCode;
    }
    /**
     * Generate Table Headers row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRowHeaders(&$aInput)
    {
        $sTrClass = 'headers' . (isset($aInput['tr_class']) ? (' ' . $aInput['tr_class']) : '');

        $sCode = '';

        $sCode .= $this->getCloseTbody();

        $sCode .= <<<BLAH
            <thead>
                <tr class="$sTrClass">
                    <th class="header first">
                        {$aInput[0]}
                    </th>

                    <th class="header second">
                        {$aInput[1]}
                    </th>
                </tr>
            </thead>
BLAH;

        $sCode .= $this->getOpenTbody();

        return $sCode;
    }

    /**
     * Generate Block Headers row
     *
     * @param  array  $aInput
     * @return string
     */
    function genRowBlockHeader(&$aInput)
    {
        $aTrAttrs = empty($aInput['attrs']) ? '' : $aInput['attrs'];
        $aNextTbodyAdd = false; // need to have some default

        if (isset($aInput['collapsable']) and $aInput['collapsable']) {
            $sTheadClass = 'collapsable';

            if (isset($aInput['collapsed']) and $aInput['collapsed']) {
                $sTheadClass .= ' collapsed';
                $aNextTbodyAdd = array(
                    'style' => 'display: none;',
                );
            }
        } else {
            $sTheadClass = '';
            $aNextTbodyAdd = false;
        }

        $aTrAttrs['class'] = "headers" . (isset($aTrAttrs['class']) ? (' ' . $aTrAttrs['class']) : '');

        $sTrAttrs = $this->convertArray2Attrs($aTrAttrs);

        $sCode = '';

        $sCode .= $this->getCloseTbody();

        $sCode .= <<<BLAH
            <thead class="$sTheadClass">
                <tr $sTrAttrs>
                    <th class="block_header bx-def-font-large" colspan="2">
                        {$aInput['caption']}
                    </th>
                </tr>
            </thead>
BLAH;

        $sCode .= $this->getOpenTbody($aNextTbodyAdd);

        return $sCode;
    }

    function genBlockEnd()
    {
        $aNextTbodyAdd = false; // need to have some default
        $sCode = '';
        $sCode .= $this->getCloseTbody();
        $sCode .= $this->getOpenTbody($aNextTbodyAdd);
        return $sCode;
    }

    /**
     * Generate HTML Input Element
     *
     * @param  array  $aInput
     * @return string Output HTML Code
     */
    function genInput(&$aInput)
    {
        $sDivider = isset($aInput['dv']) ? $aInput['dv'] : ' ';

        switch ($aInput['type']) {

            // standard inputs (and non-standard, interpreted as standard)
            case 'datetime':
                $this->_isDateTimeControl = true;
            case 'date':
                $this->_isDateControl = true;
            case 'text':
            case 'number':
            case 'email':
            case 'url':
            case 'checkbox':
            case 'radio':
            case 'image':
            case 'password':
            case 'slider':
            case 'range':
            case 'doublerange':
            case 'hidden':
                $sInput = $this->genInputStandard($aInput);
            break;

            case 'file':
                if (!isset($aInput['attrs']['size']))
                    $aInput['attrs']['size'] = 12;
                $sInput = $this->genInputStandard($aInput);
            break;

            case 'button':
            case 'reset':
            case 'submit':
                $sInput = $this->genInputButton($aInput);
            break;

            case 'textarea':
                $sInput = $this->genInputTextarea($aInput);
            break;

            case 'select':
                $sInput = $this->genInputSelect($aInput);
            break;

            case 'select_multiple':
                $sInput = $this->genInputSelectMultiple($aInput);
            break;

            case 'checkbox_set':
                $sInput = $this->genInputCheckboxSet($aInput);
            break;

            case 'radio_set':
                $sInput = $this->genInputRadioSet($aInput);
            break;

            case 'input_set': // numeric array of inputs
                $sInput = '';

                foreach ($aInput as $iKey => $aSubInput) {
                    if (!is_int($iKey) or !$aSubInput)
                        continue; // parse only integer keys and existing values

                    $sInput .= $this->genInput($aSubInput); // recursive call
                    $sInput .= $sDivider;
                }
            break;

            case 'custom':
                $sInput = isset($aInput['content']) ? $aInput['content'] : '';
            break;

            case 'canvas':
                //TODO: do we need canvas?
            break;

            case 'captcha':
                $sInput = $this->genInputCaptcha($aInput);
            break;

            case 'value':
                $sInput = $aInput['value'];
            break;

            default:
                //unknown control type
                $sInput = 'Unknown control type';
        }

        // create input label
        $sInput .= $this->genLabel($aInput);

        return $sInput;
    }

    /**
     * Generate new Input Element id
     *
     * @param  array  $aInput
     * @return string
     */
    function getInputId(&$aInput)
    {
        if (isset($aInput['id']))
            return $aInput['id'];

        $sPattern = 'a-z0-9';

        $sName = preg_replace("/[^$sPattern]/i", '_', $aInput['name']);

        $sID = $this->id . '_input_' . $sName;

        if ( // multiple elements cause identical id's
            (
                (
                    $aInput['type'] == 'checkbox' and
                    substr($aInput['name'], -2) == '[]' // it is multiple element
                ) or
                $aInput['type'] == 'radio' // it is always multiple (i think so... hm)
            ) and
            isset($aInput['value']) // if we can make difference
        ) {
            $sValue = preg_replace("/[^$sPattern]/i", '_', $aInput['value']);

            // add value
            $sID .= '_' . $sValue;
        }

        $sID = trim($sID, '_');

        $aInput['id'] = $sID; // just for repeated calls

        return $sID;
    }

    /**
     * Generate standard Input Element
     *
     * @param  array  $aInput
     * @return string
     */
    function genInputStandard(&$aInput)
    {
        // clone attributes for system use ;)
        $aAttrs = empty($aInput['attrs']) ? array() : $aInput['attrs'];

        // add default className to attributes
        $aAttrs['class'] = "form_input_{$aInput['type']} bx-def-font" . (isset($aAttrs['class']) ? (' ' . $aAttrs['class']) : '');

        if (isset($aInput['type'])) {            
            if ('datetime' == $aInput['type'])
                $aAttrs['type'] = 'date_time';
            elseif ('date' == $aInput['type'])
                $aAttrs['type'] = 'date_calendar';
            else
                $aAttrs['type'] = $aInput['type'];
        }
        if (isset($aInput['name'])) $aAttrs['name']  = $aInput['name'];
        if (isset($aInput['value'])) $aAttrs['value'] = $aInput['value'];

        // for inputs with labels generate id
        if (isset($aInput['label']))
            $aAttrs['id'] = $this->getInputId($aInput);

        // for checkboxes
        if (isset($aInput['checked']) and $aInput['checked'])
            $aAttrs['checked'] = 'checked';

        $sAttrs = $this->convertArray2Attrs($aAttrs);

        $sCode = <<<BLAH
            <input $sAttrs />
BLAH;

        return $sCode;
    }

    /**
     * Generate standard Button/Reset/Submit Element
     *
     * @param  array  $aInput
     * @return string
     */
    function genInputButton(&$aInput)
    {
        // clone attributes for system use ;)
        $aAttrs = empty($aInput['attrs']) ? array() : $aInput['attrs'];

        // add default className to attributes
        $aAttrs['class'] = "form_input_{$aInput['type']} bx-btn" . (isset($aAttrs['class']) ? (' ' . $aAttrs['class']) : '');
        $aAttrs['type']  = $aInput['type'];
        $aAttrs['name']  = $aInput['name'];
        $aAttrs['value'] = $aInput['value'];

        // for inputs with labels generate id
        if (isset($aInput['label']))
            $aAttrs['id'] = $this->getInputId($aInput);

        // for checkboxes
        if(isset($aInput['checked']) && $aInput['checked'])
            $aAttrs['checked'] = 'checked';

        $sAttrs = $this->convertArray2Attrs($aAttrs);

        $sCode = <<<BLAH
            <div class="button_wrapper">
                <input $sAttrs />
            </div>
BLAH;

        return $sCode;
    }

    /**
     * Generate Textarea Element
     *
     * @param  array  $aInput
     * @return string
     */
    function genInputTextarea(&$aInput)
    {
        // for inputs with labels generate id
        if (!isset($aInput['attrs']['id']) && (isset($aInput['label']) || isset($aInput['html'])))
            $aInput['attrs']['id'] = $this->getInputId($aInput);

        // clone attributes for system use ;)
        $aAttrs = empty($aInput['attrs']) ? array() : $aInput['attrs'];

        // add default className to attributes
        $aAttrs['class'] =
            "form_input_{$aInput['type']} bx-def-font" .
            (isset($aAttrs['class']) ? (' ' . $aAttrs['class']) : '') .
            ((isset($aInput['html']) and $aInput['html'] and $this->addHtmlEditor($aInput['html'], $aInput)) ? ' form_input_html' : '');

        $aAttrs['name']  = $aInput['name'];

        $sAttrs = $this->convertArray2Attrs($aAttrs);

        $sValue = htmlspecialchars_adv($aInput['value']);

        $sCode = <<<BLAH
            <textarea $sAttrs>$sValue</textarea>
BLAH;

        return $sCode;
    }

    function addHtmlEditor($iViewMode, &$aInput)
    {
        bx_import('BxDolEditor');
        $oEditor = BxDolEditor::getObjectInstance();
        if (!$oEditor)
            return false;

        $this->_sCodeAdd .= $oEditor->attachEditor ((!empty($this->aFormAttrs['id']) ? '#' . $this->aFormAttrs['id'] . ' ': '') . '[name="'.$aInput['name'].'"]', $iViewMode, isset($aInput['html_dynamic']) ? $aInput['html_dynamic'] : false);
        if (!isset($aInput['attrs_wrapper']['style']))
            $aInput['attrs_wrapper']['style'] = '';
        $aInput['attrs_wrapper']['style'] = 'width:' . $oEditor->getWidth($iViewMode) . $aInput['attrs_wrapper']['style'];

        return true;
    }

    /**
     * Generate Select Element
     *
     * @param  array  $aInput
     * @return string
     */
    function genInputSelect(&$aInput)
    {
        $aAttrs = empty($aInput['attrs']) ? array() : $aInput['attrs'];

        // add default className to attributes
        $aAttrs['class'] = "form_input_{$aInput['type']} bx-def-font" . (isset($aAttrs['class']) ? (' ' . $aAttrs['class']) : '');

        $aAttrs['name'] = $aInput['name'];

        // for inputs with labels generate id
        if (isset($aInput['label']))
            $aAttrs['id'] = $this->getInputId($aInput);

        $sAttrs = $this->convertArray2Attrs($aAttrs);

        // generate options
        $sCurValue = $aInput['value'];
        $sOptions = '';

        if (isset($aInput['values']) and is_array($aInput['values'])) {
            foreach ($aInput['values'] as $sValue => $sTitle) {
                if(is_array($sTitle)) {
                    $sValue = $sTitle['key'];
                    $sTitle = $sTitle['value'];
                }
                $sValueC = htmlspecialchars_adv($sValue);
                $sTitleC = htmlspecialchars_adv($sTitle);

                $sSelected = ((string)$sValue === (string)$sCurValue) ? 'selected="selected"' : '';

                $sOptions .= <<<BLAH
                   <option value="$sValueC" $sSelected>$sTitleC</option>
BLAH;

            }
        }

        // generate element
        $sCode = <<<BLAH
            <select $sAttrs>
                $sOptions
            </select>
BLAH;

        return $sCode;
    }

    /**
     * Generate Select Box Element
     *
     * @param  array  $aInput
     * @return string
     */
    function genInputSelectBox(&$aInput, $sInfo = '', $sError = '')
    {
        $sCode = '';

        if (isset($aInput['value']) and is_array($aInput['value'])) {

            $iCounter = 0;

            foreach ($aInput['value'] as $sValue) {
                $aNewInput = $aInput;

                $aNewInput['name'] .= '[]';
                $aNewInput['value'] = $sValue;

                if (isset($aInput['values'][$sValue])) { // draw select if value exists in values

                    $aNewInput['type'] = 'select';

                    if ($iCounter == 0) { // for the first input create multiplyable select and add info and error icons (if set)
                        $aNewInput['attrs']['multiplyable'] = 'true';
                        $aNewInput['attrs']['add_other']    = isset($aNewInput['attrs']['add_other']) ? $aNewInput['attrs']['add_text'] : 'true';
                        $sInputAdd = $sInfo . ' ' . $sError;
                    } else { // for the others inputs create only deletable
                        $aNewInput['attrs']['deletable'] = 'true';
                        $sInputAdd = '';
                    }

                    $iCounter ++;
                } else { // draw text input for non-existent value (man, it is select_box, wow!)
                    $aNewInput['type'] = 'text';
                    $aNewInput['attrs']['deletable'] = 'true';
                }

                $sInput = $this->genInput($aNewInput);
                $sCode .= <<<BLAH
                    <div class="input_wrapper input_wrapper_{$aInput['type']}">
                        $sInput
                    </div>
                    $sInputAdd

                    <div class="clear_both"></div>
BLAH;
            }
        } else {
            // clone
            $aNewInput = $aInput;

            $aNewInput['type'] = 'select';
            $aNewInput['name'] .= '[]';
            $aNewInput['attrs']['multiplyable'] = 'true';
            $aNewInput['attrs']['add_other']    =
                isset($aNewInput['attrs']['add_other'])
                    ? (empty($aNewInput['attrs']['add_text']) ? '' :  $aNewInput['attrs']['add_text'])
                    : 'true';

            $sInput = $this->genInput($aNewInput);
            $sCode .= <<<BLAH
                <div class="input_wrapper input_wrapper_{$aInput['type']}">
                   $sInput
                </div>
                $sInfo
                $sError
BLAH;
        }

        return $sCode;
    }

    /**
     * Generate Multiple Select Element
     *
     * @param  array  $aInput
     * @return string
     */
    function genInputSelectMultiple(&$aInput)
    {
        $aAttrs = $aInput['attrs'];

        // add default className to attributes
        $aAttrs['class'] = "form_input_{$aInput['type']} bx-def-font" . (isset($aAttrs['class']) ? (' ' . $aAttrs['class']) : '');

        $aAttrs['name']     = $aInput['name'] . '[]';
        $aAttrs['multiple'] = 'multiple';

        // for inputs with labels generate id
        if (isset($aInput['label']))
            $aAttrs['id'] = $this->getInputId($aInput);

        $sAttrs = $this->convertArray2Attrs($aAttrs);

        // generate options
        $aCurValues = $aInput['value'] ? (is_array($aInput['value']) ? $aInput['value'] : array($aInput['value'])) : array();
        $sOptions = '';

        if (isset($aInput['values']) and is_array($aInput['values'])) {
            foreach ($aInput['values'] as $sValue => $sTitle) {
                $sValueC = htmlspecialchars_adv($sValue);
                $sTitleC = htmlspecialchars_adv($sTitle);

                $sSelected = in_array($sValue, $aCurValues) ? 'selected="selected"' : '';

                $sOptions .= <<<BLAH
                   <option value="$sValueC" $sSelected>$sTitleC</option>
BLAH;

            }
        }

        // generate element
        $sCode = <<<BLAH
            <select $sAttrs>
                $sOptions
            </select>
BLAH;

        return $sCode;
    }

    /**
     * Generate Checkbox Set Element
     *
     * @param  array  $aInput
     * @return string
     */
    function genInputCheckboxSet(&$aInput)
    {
        $aAttrs = empty($aInput['attrs']) ? array() : $aInput['attrs'];

        // add default className to attributes
        $aAttrs['class'] = "form_input_{$aInput['type']}" . (isset($aAttrs['class']) ? (' ' . $aAttrs['class']) : '');

        $aAttrs['name']  = $aInput['name'];

        // for inputs with labels generate id
        if (isset($aInput['label']))
            $aAttrs['id'] = $this->getInputId($aInput);

        $sAttrs = $this->convertArray2Attrs($aAttrs);

        // generate options
        $sDivider = isset($aInput['dv']) ? $aInput['dv'] : ' ';
        $aCurValues = $aInput['value'] ? (is_array($aInput['value']) ? $aInput['value'] : array($aInput['value'])) : array();

        $sOptions = '';

        if (isset($aInput['values']) and is_array($aInput['values'])) {
            if (count($aInput['values']) > 3 && $sDivider == ' ')
                $sDivider = '<br />';
            // generate complex input using simple standard inputs
            foreach ($aInput['values'] as $sValue => $sLabel) {
                // create new simple input
                $aNewInput = array(
                    'type' => 'checkbox',
                    'name' => $aInput['name'] . '[]',
                    'value' => $sValue,
                    'checked' => in_array($sValue, $aCurValues),
                    'label' => $sLabel,
                );

                $sNewInput  = $this->genInput($aNewInput);

                // attach new input to complex
                $sOptions .= ($sNewInput . $sDivider);
            }
        }

        // generate element
        $sCode = <<<BLAH
            <div $sAttrs>
                $sOptions
            </div>
BLAH;

        return $sCode;
    }
    /**
     * Generate Radiobuttons Set Element
     *
     * @param  array  $aInput
     * @return string
     */
    function genInputRadioSet(&$aInput)
    {
        $aAttrs = empty($aInput['attrs']) ? array() : $aInput['attrs'];

        // add default className to attributes
        $aAttrs['class'] = "form_input_{$aInput['type']}" . (isset($aAttrs['class']) ? (' ' . $aAttrs['class']) : '');

        $aAttrs['name']  = $aInput['name'];

        // for inputs with labels generate id
        if (isset($aInput['label']))
            $aAttrs['id'] = $this->getInputId($aInput);

        $sAttrs = $this->convertArray2Attrs($aAttrs);

        // generate options
        $sDivider = isset($aInput['dv']) ? $aInput['dv'] : ' ';
        $sCurValue = $aInput['value'];

        $sOptions = '';

        if (isset($aInput['values']) and is_array($aInput['values'])) {
            if (count($aInput['values']) > 3 && $sDivider == ' ')
                $sDivider = '<br />';
            // generate complex input using simple standard inputs
            foreach ($aInput['values'] as $sValue => $sLabel) {
                // create new simple input
                $aNewInput = array(
                    'type'    => 'radio',
                    'name'    => $aInput['name'],
                    'value'   => $sValue,
                    'checked' => ((string)$sValue === (string)$sCurValue),
                    'label'   => $sLabel,
                );

                $sNewInput  = $this->genInput($aNewInput);

                // attach new input to complex
                $sOptions .= ($sNewInput . $sDivider);
            }
        }

        // generate element
        $sCode = <<<BLAH
            <div $sAttrs>
                $sOptions
            </div>
BLAH;

        return $sCode;
    }

    function genInputCaptcha(&$aInput)
    {
        $aAttrs = empty($aInput['attrs']) ? array() : $aInput['attrs'];

        // add default className to attributes
        $aAttrs['class'] = "form_input_{$aInput['type']}" . (isset($aAttrs['class']) ? (' ' . $aAttrs['class']) : '');

        // for inputs with labels generate id
        if (isset($aInput['label']))
            $aAttrs['id'] = $this->getInputId($aInput);

        $sAttrs = $this->convertArray2Attrs($aAttrs);

        bx_import('BxDolCaptcha');
        $oCaptcha = BxDolCaptcha::getObjectInstance();

        return "<div $sAttrs>" . ($oCaptcha ? $oCaptcha->display() : _t('_sys_txt_captcha_not_available')) . '<input type="hidden" name="' . $aInput['name'] . '" /></div>';
    }

    /**
     * Generate Label Element
     *
     * @param  string $sLabel   Text of the Label
     * @param  string $sInputID Dependant Input Element ID
     * @return string HTML code
     */
    function genLabel(&$aInput)
    {
        if (!isset($aInput['label']) or empty($aInput['label']))
            return '';

        $sLabel   = $aInput['label'];
        $sInputID = $this->getInputId($aInput);

        $sRet = '<label for="' . $sInputID . '">' . $sLabel . '</label>';

        return $sRet;
    }

    /**
     * Convert array to attributes string
     *
     * <code>
     * $a = array('name' => 'test', 'value' => 5);
     * $s = $this->convertArray2Attrs($a);
     * echo $s;
     * </code>
     *
     * Output:
     * name="test" value="5"
     *
     * @param  array  $a
     * @return string
     */
    function convertArray2Attrs($a)
    {
        $sRet = '';

        if (is_array($a)) {
            foreach ($a as $sKey => $sValue) {

                if (!isset($sValue) || is_null($sValue)) // pass NULL values
                    continue;

                $sValueC = htmlspecialchars_adv($sValue);

                $sRet .= " $sKey=\"$sValueC\"";
            }
        }

        return $sRet;
    }

    function genInfoIcon($sInfo)
    {
        $sInfo = str_replace( "\n", "\\n", $sInfo );
        $sInfo = str_replace( "\r", "",    $sInfo );
        $sInfoH  = htmlspecialchars_adv($sInfo);

        return '<i class="info sys-icon info-sign" float_info="' . $sInfoH . '"></i>';
    }

    function genErrorIcon( $sError = '' )
    {
        if (!$this->bEnableErrorIcon)
            return '';

        $sErrorH  = ' '; // it has space because jquery doesnt accept it if it is empty
        if ($sError) {
            $sError = str_replace( "\n", "\\n", $sError );
            $sError = str_replace( "\r", "",    $sError );
            $sErrorH  = htmlspecialchars_adv($sError);
        }

        return '<i class="warn sys-icon exclamation-sign" float_info="' . $sErrorH . '"></i>';
    }

    function getOpenTbody($aAdd = false)
    {
        if (!$this->_isTbodyOpened) {

            if ($aAdd and is_array($aAdd))
                $sAttrs = $this->convertArray2Attrs($aAdd);
            else
                $sAttrs = '';

            $sCode = "
                <tbody $sAttrs>\n";

            $this->_isTbodyOpened = true;

            return $sCode;
        } else
            return '';
    }

    function getCloseTbody()
    {
        if ($this->_isTbodyOpened) {
            $sCode = "
                </tbody>\n";

            $this->_isTbodyOpened = false;

            return $sCode;
        } else
            return '';
    }

    function addCssJs($isDateControl = false, $isDateTimeControl = false)
    {
        $aJs = array(
            'jquery.ui.core.min.js',
            'jquery.ui.widget.min.js',
            'jquery.ui.mouse.min.js',
            'jquery.ui.slider.min.js',
        );

        $aCss = array(
            'forms_adv.css',
            'plugins/jquery/themes/|jquery-ui.css',
        );

        if ($isDateControl || $isDateTimeControl) {

            $aUiLangs = array ('af' => 1, 'ar-DZ' => 1, 'ar' => 1, 'az' => 1, 'be' => 1, 'bg' => 1, 'bs' => 1, 'ca' => 1, 'cs' => 1, 'cy-GB' => 1, 'da' => 1, 'de' => 1, 'el' => 1, 'en-AU' => 1, 'en-GB' => 1, 'en-NZ' => 1, 'en' => 1, 'eo' => 1, 'es' => 1, 'et' => 1, 'eu' => 1, 'fa' => 1, 'fi' => 1, 'fo' => 1, 'fr-CA' => 1, 'fr-CH' => 1, 'fr' => 1, 'gl' => 1, 'he' => 1, 'hi' => 1, 'hr' => 1, 'hu' => 1, 'hy' => 1, 'id' => 1, 'is' => 1, 'it' => 1, 'ja' => 1, 'ka' => 1, 'kk' => 1, 'km' => 1, 'ko' => 1, 'ky' => 1, 'lb' => 1, 'lt' => 1, 'lv' => 1, 'mk' => 1, 'ml' => 1, 'ms' => 1, 'nb' => 1, 'nl-BE' => 1, 'nl' => 1, 'nn' => 1, 'no' => 1, 'pl' => 1, 'pt-BR' => 1, 'pt' => 1, 'rm' => 1, 'ro' => 1, 'ru' => 1, 'sk' => 1, 'sl' => 1, 'sq' => 1, 'sr-SR' => 1, 'sr' => 1, 'sv' => 1, 'ta' => 1, 'th' => 1, 'tj' => 1, 'tr' => 1, 'uk' => 1, 'vi' => 1, 'zh-CN' => 1, 'zh-HK' => 1, 'zh-TW' => 1);

            $aJs [] = 'jquery.ui.datepicker.min.js';
            $aJs [] = 'plugins/jquery/i18n/|jquery.ui.datepicker-' . (isset($aUiLangs[$GLOBALS['sCurrentLanguage']]) ? $GLOBALS['sCurrentLanguage'] : 'en') . '.js';
        }

        if ($isDateTimeControl) {

            $aCalendarLangs = array ('af' => 1, 'bg' => 1, 'ca' => 1, 'cs' => 1, 'da' => 1, 'de' => 1, 'el' => 1, 'es' => 1, 'et' => 1, 'eu' => 1, 'fi' => 1, 'fr' => 1, 'gl' => 1, 'he' => 1, 'hr' => 1, 'hu' => 1, 'id' => 1, 'it' => 1, 'ja' => 1, 'ko' => 1, 'lt' => 1, 'nl' => 1, 'no' => 1, 'pl' => 1, 'pt-BR' => 1, 'pt' => 1, 'ro' => 1, 'ru' => 1, 'sk' => 1, 'sv' => 1, 'th' => 1, 'tr' => 1, 'uk' => 1, 'vi' => 1, 'zh-CN' => 1, 'zh-TW' => 1);

            $aJs[] = 'jquery-ui-timepicker-addon.js';
            $aJs[] = 'jquery-ui-sliderAccess.js';
            if (isset($aCalendarLangs[$GLOBALS['sCurrentLanguage']]))
                $aJs[] = 'plugins/jquery/i18n/|jquery-ui-timepicker-' . $GLOBALS['sCurrentLanguage'] . '.js';
            $aCss[] = 'plugins/jquery/themes/|jquery-ui-timepicker-addon.css';
        }

        if (isset($GLOBALS['oSysTemplate'])) {
            $GLOBALS['oSysTemplate']->addJs($aJs);
            $GLOBALS['oSysTemplate']->addCss($aCss);
        }
        if (isset($GLOBALS['oAdmTemplate'])) {
            $GLOBALS['oAdmTemplate']->addJs($aJs);
            $GLOBALS['oAdmTemplate']->addCss($aCss);
        }
    }
}
