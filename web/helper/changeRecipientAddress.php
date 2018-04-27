<?php
/*
 * changeRecipientAddress.php
 *
 * author: klaus
 *
 * created: 26.04.2018
 * changed: 26.04.2018
 *
 */

session_start();
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
checkAuth();
if($_GET['selectedRecipient'] != "") {
    $recipient = $oWebDate->queryRecipient($_GET['selectedRecipient']);
} else {
    $recipient = $oWebDate->queryRecipient($_SESSION['RECIPIENT_ID']);
}
?>
<script>
function clearRecipientAddressData() {
    $('#newEMailAddressId').val('');
    $('#newEMailNameId').val('');
    window.setTimeout(function() { $('#emailChangeId').dialog('close').remove(); }, 500);
}
function saveRecipientAddressData(){
    var formData = $('input').serialize();
    $.ajax({
        url: "helper/saveRecipientAddress.php",
        type:"POST",
        data:formData,
        success: function(data) {
            if(data != "success") {
                alert(data);
            } else {
                alert('Adresse wurde ge&auml;ndert', "OK");
            }
        }
    });
}
</script>
<div class="table99">
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            Ihre E-Mail-Adresse zur Zeit
        </div>
        <div class="tcell60 ui-widget-content h40 f12 lalign">
            <?php echo $recipient['recipient_name'] . " &lt;".$recipient['recipient_address'] . "&gt;"; ?>
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            Ihr neuer E-Mail-Name
        </div>
        <div class="tcell60 ui-widget-content h40 f12 lalign">
            <input type="text" name="newEMailName" id="newEMailNameId">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b lalign">
            Ihre neue E-Mail-Adresse
        </div>
        <div class="tcell60 ui-widget-content h40 f12 lalign">
            <input type="text" name="newEMailAddress" id="newEMailAddressId">
        </div>
    </div>
</div>
<div class="table99">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:left;padding-left:5px;">
            <div id="resultRecipientAddressSavingId"></div>
        </div>
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:right;padding-right:5px;">
            <button onClick="clearRecipientAddressData();">Abbrechen</button>
            <button onClick="saveRecipientAddressData();">Speichern</button>
        </div>
    </div>
</div>
