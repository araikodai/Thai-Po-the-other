<div class="subMenu bx-def-border" id="subMenu_<?=$a['submenu_id'];?>" style="display:<?=$a['display_value'];?>;">
	<div class="subMenuCnt bx-def-padding-leftright bx-def-padding-sec-topbottom">
		<div class="sys_page_icon">
			<?=$a['picture'];?>
		</div>
		<div class="sys_page_header bx-def-padding-sec-left">
			<?=$a['caption'];?>
            <?=$this->processInjection($GLOBALS['_page']['name_index'], 'injection_title_zone'); ?>
		</div>
        <?php if($a['bx_if:show_status']['condition']){ ?>
            <div class="sys_page_status bx-def-padding-sec-left">
                <?=$a['bx_if:show_status']['content']['status'];?>
            </div>
        <?php } ?>
        <?php if($a['bx_if:show_submenu']['condition']){ ?>
            <div class="sys_page_submenu bx-def-padding-left">
                <?=$a['bx_if:show_submenu']['content']['submenu'];?>
            </div>
        <?php } ?>
        <?php if($a['bx_if:show_empty']['condition']){ ?>
            <div class="sys_page_empty"></div>
        <?php } ?>
        <div class="sys_page_actions">
            <?=$a['profile_actions'];?>
            <?=$a['login_section'];?>
        </div>
		<div class="clear_both"></div>
        <?php if($a['bx_if:show_submenu_bottom']['condition']){ ?>
            <div class="sys_page_submenu_bottom bx-def-padding-sec-top"><?=$a['bx_if:show_submenu_bottom']['content']['submenu'];?></div>
        <?php } ?>
	</div>
</div>
