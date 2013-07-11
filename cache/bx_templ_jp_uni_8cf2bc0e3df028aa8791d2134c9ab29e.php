<div class="ps-members-content">
    <?php if($a['bx_if:search_form']['condition']){ ?>
        <div class="ps-search-form bx-def-bc-margin"><?=$a['bx_if:search_form']['content']['form'];?></div>
    <?php } ?>
    <form id="ps-<?=$a['wnd_action'];?>-member-form" name="ps-<?=$a['wnd_action'];?>-member-form" action="member_privacy.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="ps-<?=$a['wnd_action'];?>-member-group" value="0" />
        <script language="javascript" type="text/javascript">
        <!--                    
            var sPSSiteUrl = '<?=$a['js_site_url'];?>';
            var iPSGroupId = 0;
        -->
        </script>
        <div class="ps-search-results bx-def-bc-margin"><?=$a['results'];?></div>
        <?=$a['control'];?>
    </form>
    <?=$a['loading'];?>
</div>