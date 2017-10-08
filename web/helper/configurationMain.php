<?php
/**
 *
 * configurationMain.php
 *
 * author : piwi
 *
 * created: 07.01.2017
 * changed: 07.01.2017
 *
 * purpose:
 *
 */

session_start();
@define("DS", DIRECTORY_SEPARATOR);
if($_GET['action'] == "editEntry") {
    header("Location: modSchedule.php?selectedEntry=".$_GET['selectedEntry']);
    exit;
}
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$recipients = $oWebDate->queryRecipients();
?>
<script>
$(document).ready(function() {
    $('#mainConfigurationContentId').html('').load("helper/configurationMain.php?action=<?php echo $_GET['action']; ?>&selectedEntry=<?php echo $_GET['selectedEntry']; ?>");
    $('#emailRecipientContentId').css("height", getABSHeight(80, "dialog")).css("overflow", "auto");
});
function addRecipient() {
    openAdditionalDialog("editRecipientId", "helper/addEMailRecipient.inc.php", getABSWidth(50), getABSHeight(55));
}
function modRecipient(selectedRecipient) {
    openAdditionalDialog("editRecipientId", "helper/modEMailRecipient.inc.php?selectedRecipient=" + selectedRecipient, getABSWidth(50), getABSHeight(55));
}
</script>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header">
            <div class="table">
                <div class="trow">
                    <div class="tcell">
                        <button onClick="addRecipient();">Neu</button>
                    </div>
                    <div class="tcell"> EMail-Empf&auml;nger </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="text-align:center;width:40%;">
            Name
        </div>
        <div class="tcell ui-widget-content h40 f12b" style="text-align:center;width:60%;">
            Adresse
        </div>
    </div>
</div>
<?php
if(count($recipients)>0) {
?>
<div id="emailRecipientContentId">
    <div class="table" style="width:99%;margin:0 auto;">
<?php
    foreach($recipients as $rec) {
?>
        <div class="trow ui-hover" onClick="modRecipient('<?php echo $rec['recipient_id']; ?>');">
        <div class="tcell ui-widget-content h40 f12" style="width:40%;">
            <?php echo $rec['recipient_name']; ?>
        </div>
        <div class="tcell ui-widget-content h40 f12" style="width:60%;">
            <?php echo $rec['recipient_address']; ?>
        </div>
        </div>
<?php
    }
?>
    </div>
</div>
<?php
}
?>