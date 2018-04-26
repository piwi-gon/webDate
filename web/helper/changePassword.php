<?php
/*
 * changePassword.php
 *
 * author: klaus
 *
 * created: 26.04.2018
 * changed: 26.04.2018
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
checkAuth();
?>
<script>
function clearLoginData() {
    $('#currentPasswordId').val('');
    $('#newPasswordId').val('');
    $('#newPasswordCtrlId').val('');
    window.setTimeout(function() { $('#pwChangeId').dialog('close').remove(); }, 500);
}
function saveLoginData(){
    var formData = $('input').serialize();
    var newPass = $('#newPasswordId').val();
    var newPassCtrl = $('#newPasswordCtrlId').val();
    if(newPass != newPassCtrl) {
        alert('Die neuen Passw&ouml;rter stimmen nicht &uuml;berein' + '\n' + newPass + " - " + newPassCtrl);
        $('#currentPasswordId').val('');
        $('#newPasswordId').val('');
        $('#newPasswordCtrlId').val('');
    } else {
        $.ajax({
            url: "helper/saveNewPassword.php",
            type:"POST",
            data:formData,
            success: function(data) {
                if(data != "success") {
                    alert(data);
                } else {
                    alert('Passwort wurde ge&auml;ndert', "OK");
                }
            }
        });
    }
}
</script>
<div class="table99">
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            zur zeit g&uuml;ltiges Passwort
        </div>
        <div class="tcell60 ui-widget-content h40 f12 lalign">
            <input type="password" name="currentPassword" id="currentPasswordId">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            neues Passwort
        </div>
        <div class="tcell60 ui-widget-content h40 f12 lalign">
            <input type="password" name="newPassword" id="newPasswordId">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            neues Passwort (WH)
        </div>
        <div class="tcell60 ui-widget-content h40 f12 lalign">
            <input type="password" name="newPasswordCtrl" id="newPasswordCtrlId">
        </div>
    </div>
</div>
<div class="table99">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:left;padding-left:5px;">
            <div id="resultPasswordChangeId"></div>
        </div>
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:right;padding-right:5px;">
            <button onClick="clearLoginData();">Abbrechen</button>
            <button onClick="saveLoginData();">Speichern</button>
        </div>
    </div>
</div>
