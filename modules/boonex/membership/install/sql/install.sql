SET @sModuleName = 'Membership';

SET @iCategoryOrder = (SELECT MAX(`menu_order`) FROM `sys_options_cats`) + 1;
INSERT INTO `sys_options_cats` (`name` , `menu_order` ) VALUES (@sModuleName, @iCategoryOrder);
SET @iCategoryId = LAST_INSERT_ID();

INSERT INTO `sys_options` (`Name`, `VALUE`, `kateg`, `desc`, `Type`, `check`, `err_text`, `order_in_kateg`, `AvailableValues`) VALUES
('mbp_type', '', @iCategoryId, 'Membership type', 'text', '', '', 0, ''),
('permalinks_module_membership', 'on', 26, 'Enable friendly membership permalink', 'checkbox', '', '', 0, '');

INSERT INTO `sys_permalinks`(`standard`, `permalink`, `check`) VALUES('modules/?r=membership/', 'm/membership/', 'permalinks_module_membership');

INSERT INTO `sys_menu_top` (`Parent`, `Name`, `Caption`, `Link`, `Order`, `Visible`, `Target`, `Onclick`, `Check`, `Editable`, `Deletable`, `Active`, `Type`, `Picture`, `BQuickLink`, `Statistics`) VALUES
(118, 'My Membership', '_membership_tmenu_item_my_membership', 'modules/?r=membership/index', 4, 'memb', '', '', '', 1, 1, 1, 'custom', '', 0, '');

SET @iPCPOrder = (SELECT MAX(`Order`) FROM `sys_page_compose_pages`) + 1;
INSERT INTO `sys_page_compose_pages`(`Name`, `Title`, `Order`) VALUES ('bx_mbp_my_membership', 'My Membership', @iPCPOrder);

INSERT INTO `sys_page_compose` (`Page`, `PageWidth`, `Desc`, `Caption`, `Column`, `Order`, `Func`, `Content`, `DesignBox`, `ColWidth`, `Visible`, `MinWidth`) VALUES
('bx_mbp_my_membership', '1140px', 'My Level', '_membership_bcaption_my_status', 1, 0, 'Current', '', 1, 28.1, 'memb', 0),
('bx_mbp_my_membership', '1140px', 'Available Levels', '_membership_bcaption_levels', 2, 0, 'Available', '', 1, 71.9, 'memb', 0);

INSERT INTO `bx_pmt_modules`(`uri`) VALUES ('membership');