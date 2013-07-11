<div class="sys_main_menu" style="min-width:<?=$this->parseSystemKey('main_div_width', $mixedKeyWrapperHtml);?>;">
    <div class="sys_mm" style="width:<?=$this->parseSystemKey('main_div_width', $mixedKeyWrapperHtml);?>;">
        <div class="sys_mm_cnt bx-def-margin-sec-leftright">
            <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_top_menu_before'); ?>
            <table class="topMenu" cellpadding="0" cellspacing="0">
                <tr>
                <?=$a['main_menu'];?>
                </tr>
            </table>
            <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_top_menu_after'); ?>       
            <div class="clear_both">&nbsp;</div>
        </div>
    </div>
</div>
<div class="sys_sub_menu" style="width:<?=$this->parseSystemKey('main_div_width', $mixedKeyWrapperHtml);?>;">
    <div class="sys_sm_cnt bx-def-margin-sec-leftright">
        <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_sub_menu_before'); ?>
            <?=$a['sub_menu'];?>
        <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_sub_menu_after'); ?> 
    </div>
</div>
