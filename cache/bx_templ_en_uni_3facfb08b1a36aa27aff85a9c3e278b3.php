<div id="admin_license_form_popup" class="admin_license_form_popup bx-def-font-grayed">
    <div class="admin_license_form bx-def-padding bx-def-border">
        <form method="post" action="http://www.thaipo.org/administration/license.php">
            <div class="admin_license_message bx-def-font-h2">
                Trial copy! <b><a href="http://www.boonex.com/paymentprovider/payment">Get a license</a></b> and register it:
            </div>
            <div class="bx-def-margin-top">
                <div class="admin_license_cell_cpt bx-def-margin-sec-right bx-def-font-large">
                    License:
                </div>
                <div class="admin_license_cell bx-def-margin-sec-right">
                    <input type="text" name="license_code" id="admin_login_license" class="bx-def-round-corners-with-border bx-def-font-large">
                </div>
                <div class="admin_license_cell">
                    <button class="bx-btn" type="submit" id="admin_login_form_submit">
                        Register
                    </button>
                </div>
                <div class="clear_both"></div>
            </div>
        </form>
    </div>
    <div class="admin_license_continue bx-def-margin-sec-top">or <a id="admin_license_form_popup_close" href="javascript:void(0)">continue trial</a></div>
</div>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	$('#admin_license_form_popup_close').bind('click', function() {
		$('#admin_license_form_popup').dolPopupHide({});
	});

	$('#admin_license_form_popup').dolPopup({
	    fog: {
	        color: '#fff', 
	        opacity: .7
	    },
	    closeOnOuterClick: false
	});
});
</script>
