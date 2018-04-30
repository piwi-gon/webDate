<?php
/*
 * passwordLostDialog.php
 *
 * author: klaus
 *
 * created: 30.04.2018
 * changed: 30.04.2018
 *
 */

session_start();
@define("DS", DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__) . DS . ".." . DS . "main" . DS . "baseStart.inc.php");
if(!$_SESSION['RECREATE']) {
    header("Location: ".WEBDATE_WWW_DIR."helper/configurationLogin.php");
    exit;
}
?>
<script>
$(document).ready(function() {
    centerOnScreen('passwordLostId');
});
function clearPasswordLostData() {
    $('#recipientNameId').val('');
    $('#passwordLostId').dialog('close').remove();
}
function sendPasswordLostData() {
    var selectedRecipientName = $('#recipientNameId').val();
    if(selectedRecipientName != undefined && selectedRecipientName != "") {
        $.ajax({
            url: 'helper/sendNewGeneratedPassword.php?&selectedRecipient='+selectedRecipientName,
            type: 'POST',
            success:function() {
                $('#recipientNameId').val('');
                alert("Ein neues Passwort wurde erzeugt und an die hinterlegte Adresse gesendet!", "OK");
                $('#passwordLostId').dialog('close').remove();
            }
        });
    }
}
</script>
<div class="table99">
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">Benutzername</div>
        <div class="tcell60 ui-widget-content h40 f12b lalign">
            <input type="text" name="recipientName" id="recipientNameId" maxlength="20">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-header h40 f12b lalign">
        </div>
        <div class="tcell60 ui-widget-header h40 f12b ralign">
            <button onClick="sendPasswordLostData();">Neues Passwort</button>
        </div>
    </div>
</div>
