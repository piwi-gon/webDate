<?php
/**
 *
 * addEMailRecipient.inc.php
 *
 * author : piwi
 *
 * created: 17.12.2016
 * changed: 17.12.2016
 *
 * purpose:
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
checkAuth();
?>
<script>
function clearRecipientData() {
    $('#emailRecipientNameId').val('');
    $('#emailRecipientAddressId').val('');
    window.setTimeout(function() { $('#editRecipientId').dialog('close').remove(); }, 500);
}

function saveRecipientData() {
    var formData = $('input').serialize();
    $.ajax({
        url: "helper/saveEMailRecipientData.inc.php",
        type: 'POST',
        data: formData,
        success: function(data) {
            var tokens = data.split("|");
            if(tokens[1] != "") {
                $('#resultRecipientSavingId').html('gespeichert');
                $('#emailRecipientId').append($('<option>').addClass("optionview f10").val(data));
                window.setTimeout(function() { $('#editRecipientId').dialog('close').remove(); }, 2000);
            }
        }
    });
}
</script>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="width:40%;">
            Name des Empf&auml;ngers
        </div>
        <div class="tcell ui-widget-content h40 f12b" style="width:60%;">
            <input type="text" name="emailRecipientName" id="emailRecipientNameId" maxlength="200">
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="width:40%;">
            Adresse
        </div>
        <div class="tcell ui-widget-content h40 f12b" style="width:60%;">
            <input type="text" name="emailRecipientAddress" id="emailRecipientAddressId" maxlength="200">
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="width:40%;">
            Login
        </div>
        <div class="tcell ui-widget-content h40 f12b" style="width:60%;">
            <input type="text" name="emailRecipientUser" id="emailRecipientUserId" maxlength="20">
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="width:40%;">
            Passwort
        </div>
        <div class="tcell ui-widget-content h40 f12b" style="width:60%;">
            <input type="text" name="emailRecipientPass" id="emailRecipientPassId" maxlength="60">
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="width:40%;">
            Passwort (Wh.)
        </div>
        <div class="tcell ui-widget-content h40 f12b" style="width:60%;">
            <input type="text" name="emailRecipientPassWH" id="emailRecipientPassWHId" maxlength="60">
        </div>
    </div>
</div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:left;padding-left:5px;">
            <div id="resultRecipientSavingId"></div>
        </div>
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:right;padding-right:5px;">
            <button onClick="clearRecipientData();">Abbrechen</button>
            <button onClick="saveRecipientData();">Speichern</button>
        </div>
    </div>
</div>
