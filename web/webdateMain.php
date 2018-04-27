<?php
/**
 *
 * webdateMain.php
 *
 * author : piwi
 *
 * created: 04.11.2016
 * changed: 04.11.2016
 *
 * purpose:
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."main".DS."baseStart.inc.php");
?>
<html>
<head>
    <title>WebDate V2.0.0</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/jquery.messagebox.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="lib/js/base.js"></script>
    <script src="lib/js/jquery.messagebox.widget.js"></script>
</head>
<body>
<div id="dialog"></div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell" style="width:100%;">
            <div id="mainContentId" style="width:99%;margin:0 auto;"></div>
        </div>
    </div>
</div>
<?php
if(!$_SESSION['AUTH']) {
?>
<script>
$(document).ready(function() {
    $('#mainContentId').load('helper/configurationLogin.php');
});
</script>
<?php
} else {
?>
<script>
$(document).ready(function() {
    $('#mainContentId').load('webdateList.php');
});
</script>
<?php
}
?>
</body>
</html>