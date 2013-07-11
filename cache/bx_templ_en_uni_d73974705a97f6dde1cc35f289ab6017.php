<div class="adm-mp-order-item">
    Order by:
    <select name="order_by" class="form_input_select" onchange="<?=$a['change_order'];?>">
        <option value="" selected="selected">None</option>
        <option value="NickName">User Name</option>
        <option value="DateReg DESC">Last Join</option>
        <option value="DateLastNav DESC">Last Activity</option>
    </select>            
</div>
<div class="adm-mp-order-item-right">
    <?=$a['per_page'];?>
</div>
<div class="clear_both">&nbsp;</div>