<?php
/**
 *
 * configurationLogin.php
 *
 * author : piwi
 *
 * created: 07.01.2017
 * changed: 07.01.2017
 *
 * purpose:
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$_SESSION['RECREATE'] = true;
?>
<html>
<head>
    <title>WebDate V2.0.0</title>
    <link rel="stylesheet" href="<?php echo WEBDATE_WWW_DIR; ?>css/base.css">
    <link rel="stylesheet" href="<?php echo WEBDATE_WWW_DIR; ?>css/jquery.messagebox.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="<?php echo WEBDATE_WWW_DIR; ?>lib/js/base.js"></script>
    <script src="<?php echo WEBDATE_WWW_DIR; ?>lib/js/jquery.messagebox.widget.js"></script>
</head>
<script>
function checkLogin() {
    var loginName = $('#loginNameId').val();
    var loginPass = $('#loginPassId').val();
    var formData  = $('input').serialize();
    console.log(formData);
    if(formData != undefined) {
        $('#loginPassId').val('');
        $.ajax({
            url: "<?php echo WEBDATE_WWW_DIR; ?>helper/checkLogin.php",
            type: "POST",
            data: formData,
            success: function(data) {
                if(data == "success") {
                    window.location.href='<?php echo WEBDATE_WWW_DIR; ?>webdateMain.php';
                } else {
                    $('#mainConfigurationContentId').effect('shake');
                }
            }
        });
    }
}
function checkLoginKey(event) {
    if(event.keyCode == "13") { checkLogin(); }
}
function openPasswordLostDialog() {
    openAdditionalDialog("passwordLostId", "<?php echo WEBDATE_WWW_DIR; ?>helper/passwordLostDialog.php", 500, 200);
}
</script>
<body>
<div id="mainConfigurationContentId" class="centerOnScreen60">
    <div class="table" style="width:99%;margin:0 auto;">
        <div class="trow">
            <div class="tcell100 ui-widget-header h40 calign">
                Webdate 2.0
            </div>
        </div>
    </div>
    <div class="table" style="width:99%;margin:0 auto;">
        <div class="trow">
            <div class="tcell ui-widget-content h40 calign f12b" style="width:80%;margin:0 auto;">
                Login<br>
                <input type="text" name="loginName" id="loginNameId" onKeyPress="checkLoginKey(event);">
            </div>
        </div>
        <div class="trow">
            <div class="tcell ui-widget-content h40 calign f12b" style="width:80%;margin:0 auto;">
                Password<br>
                <input type="password" name="loginPass" id="loginPassId" onKeyPress="checkLoginKey(event);">
            </div>
        </div>
    </div>
    <div class="table" style="width:99%;margin:0 auto;">
        <div class="trow">
            <div class="tcell60 ui-widget-content h40 lalign f12b">
                <a href="#" onClick="openPasswordLostDialog();">Passwort vergessen ?</a>
            </div>
            <div class="tcell40 ui-widget-content h40 ralign f12b">
                <button onClick="checkLogin();">Login</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
