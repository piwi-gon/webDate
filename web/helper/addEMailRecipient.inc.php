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
    var errmsg=[];
    $(document).find("input[data-type=mandatory]").each(function(index,obj) {
        if($(this).val() == "") { errmsg.push($(this).attr('name')); }
    });
    if(errmsg.length > 0) {
        alert('Fehler bei der Eingabe');
    } else {
        alert('saving', "OK");
        /*
        var formData = $('input').serialize();
        $.ajax({
            url: "helper/saveEMailRecipientData.inc.php",
            type: 'POST',
            data: formData,
            success: function(data) {
                var tokens = data.split("|");
                if(tokens[1] != "") {
                    $('#resultRecipientSavingId').html('Die Daten wurden gespeichert.'+'\n'+'Der neue Benutzer kann nun seine Termine eintragen.');
                    // $('#emailRecipientId').append($('<option>').addClass("optionview f10").val(data));
                    $('#editRecipientId').dialog('close').remove();
                }
            }
        });
        */
    }
}

function toggleAutoPasswordCreation() {
    if($('#autoPasswordId').is(':checked')) {
        $('#emailRecipientPassId').removeAttr("data-type");
        $('#emailRecipientPassWHId').removeAttr("data-type");
    } else {
        $('#emailRecipientPassId').attr("data-type", "mandatory");
        $('#emailRecipientPassWHId').attr("data-type", "mandatory");
    }
    $('#emailRecipientPassId').prop("disabled", $('#autoPasswordId').is(':checked'));
    $('#emailRecipientPassWHId').prop("disabled", $('#autoPasswordId').is(':checked'));
}
</script>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            Name des Empf&auml;ngers
        </div>
        <div class="tcell60 ui-widget-content h40 f12b lalign">
            <input data-type="mandatory" type="text" name="emailRecipientName" id="emailRecipientNameId" maxlength="200">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            Adresse
        </div>
        <div class="tcell60 ui-widget-content h40 f12b lalign">
            <input data-type="mandatory" type="text" name="emailRecipientAddress" id="emailRecipientAddressId" maxlength="200">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            Login
        </div>
        <div class="tcell60 ui-widget-content h40 f12b lalign">
            <input data-type="mandatory" type="text" name="emailRecipientUser" id="emailRecipientUserId" maxlength="20">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            <div class="table99">
                <div class="trow">
                    <div class="tcell60 h40 f12b">
                        Passwort
                    </div>
                    <div class="tcell40 h40 f12">
                        <label for="autoPasswordId">Auto&nbsp;</label>
                        <input type="checkbox" name="autoPassword" id="autoPasswordId" title="Passwort automatisch erzeugen" onClick="toggleAutoPasswordCreation();" value="true">
                    </div>
                </div>
            </div>
        </div>
        <div class="tcell60 ui-widget-content h40 f12b lalign">
            <input data-type="mandatory" type="text" name="emailRecipientPass" id="emailRecipientPassId" maxlength="60">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            Passwort (Wh.)
        </div>
        <div class="tcell60 ui-widget-content h40 f12b lalign">
            <input data-type="mandatory" type="text" name="emailRecipientPassWH" id="emailRecipientPassWHId" maxlength="60">
        </div>
    </div>
</div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell40 ui-widget-header h40 f12b lalign">
            <div id="resultRecipientSavingId"></div>
        </div>
        <div class="tcell60 ui-widget-header h40 f12b ralign">
            <button onClick="clearRecipientData();">Abbrechen</button>
            <button onClick="saveRecipientData();">Speichern</button>
        </div>
    </div>
</div>
