        		<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_content_after'); ?>
                <div class="clear_both"></div>
            </div>
        </div>
		<?=$this->processInjection($GLOBALS['_page']['name_index'], 'banner_bottom'); ?>
		<!-- end of body -->
	</div>
    <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_between_content_breadcrumb'); ?>
    <div class="sys_breadcrumb bx-def-margin-top" style="width:<?=$this->parseSystemKey('main_div_width', $mixedKeyWrapperHtml);?>;">
       <div class="sys_bc_wrapper bx-def-margin-sec-leftright bx-def-border">
            <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_breadcrumb_before'); ?>      
            <?=$this->parseSystemKey('top_menu_breadcrumb', $mixedKeyWrapperHtml);?>
            <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_breadcrumb_after'); ?>
            <div class="clear_both">&nbsp;</div>
        </div>
    </div>
    <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_between_breadcrumb_bottom_menu'); ?>
	<div class="sys_copyright bx-def-margin-top" style="width: <?=$this->parseSystemKey('main_div_width', $mixedKeyWrapperHtml);?>">
        <div class="sys_cr_wrapper bx-def-margin-sec-leftright bx-def-border">
            <div class="sys_cr bx-def-margin-leftright">
                <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_footer_before'); ?>
        		<div class="bottomLinks bx-def-margin-sec-right"><?=$this->parseSystemKey('bottom_links', $mixedKeyWrapperHtml);?></div>
        		<div class="bottomCpr"><?=$this->parseSystemKey('copyright', $mixedKeyWrapperHtml);?></div>
        		<?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_footer_after'); ?>
        		<div class="clear_both"></div>
            </div>
        </div>
	</div>
    <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_between_bottom_menu_footer'); ?>
    <?=$this->parseSystemKey('boonex_footers', $mixedKeyWrapperHtml);?>
	   <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_footer'); ?>
    </body>
</html>
