function check_album_name_for_fields(iValue) {
    var oTitle = $('tr:has(input[name=title]):last');
    var oPrivacy = $('tr:has(select[name=AllowAlbumView]):last');
    if (iValue != 0) {
        oTitle.hide();
        oPrivacy.hide();
    }
    else {
        oTitle.show();
        oPrivacy.show();
    }
}

function redirect_with_closing(sUrl, iTime) {
    window.setTimeout(function () {
        window.parent.opener.location = sUrl;
        window.parent.close(); 
    }, iTime * 1000);
}

function submit_quick_upload_form(sUrl, sFields) {
    sUrlReq = sUrl + 'upload/get_album_data/?' + sFields;
    $.getJSON(sUrlReq, function(oJson) {
        if (oJson.status == 'OK')
            window.location.href = sUrl + 'albums/my/add_objects/' + oJson.album_uri + '/owner/' + oJson.owner_name;
        else
            alert(oJson.error_msg);
    });
    return false;
}