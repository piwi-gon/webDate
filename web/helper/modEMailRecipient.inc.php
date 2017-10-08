<?php
/**
 *
 * modEMailRecipient.inc.php
 *
 * author : piwi
 *
 * created: 17.12.2016
 * changed: 17.12.2016
 *
 * purpose:
 *
 */

session_start();
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
checkAuth();
$data = $oWebDate->queryRecipient($_GET['selectedRecipient']);
?>
<script>
function clearRecipientData() {
    $('#emailRecipientNameId').val('');
    $('#emailRecipientAddressId').val('');
    window.setTimeout(function() { $('#editRecipientId').dialog('close').remove(); }, 500);
}

function saveRecipientData() {
    var formData = $('input').serialize();
    /*
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
    */
}
</script>
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
    