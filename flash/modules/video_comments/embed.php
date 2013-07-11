<?php
$sModule = "video_comments";
require_once("../../../inc/header.inc.php");
require_once($sIncPath . "customFunctions.inc.php");

$iFileId = (int)$_GET["id"];
$s = getEmbedCode('video_comments', "player", array('id' => $iFileId));

$oAlert = new BxDolAlerts('bx_video_comments', 'embed', $iFileId, getLoggedId(), array(
    'data' => &$s,
));
$oAlert->alert();

header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <style type="text/css">
        html, body { height:100%; background-color: transparent; }
        body { margin:0; padding:0; overflow:hidden; }
        object, object > embed, video { width:100%; height:100%; }
    </style>
</head>
<body class="bx-def-font" style="background: transparent;">
    <?=$s ?>
</body>
</html>
