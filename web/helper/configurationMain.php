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
error_reporting(E_ALL&~E_NOTICE);
ini_set("display_errors", 1);
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
    $('#emailRecipientContentId').css("height", getABSHeight(80, "administration")).css("overflow", "auto");
});
function addRecipient() {
    openAdditionalDialog("editRecipientId", "helper/addEMailRecipient.inc.php", getABSWidth(50), getABSHeight(55));
}
function modRecipient(selectedRecipient) {
    openAdditionalDialog("editRecipientId", "helper/modEMailRecipient.inc.php?selectedRecipient=" + selectedRecipient, getABSWidth(50), getABSHeight(55));
}
function createAndSendTestMail() {
    openAdditionalDialog("editRecipientId", "helper/createAndSendMail.inc.php", getABSWidth(50), getABSHeight(55));
}
</script>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header">
            <div class="table">
                <div class="trow">
                    <div class="tcell">
                        <button onClick="addRecipient();"><img src="images/gfx/page_white.png"></button>
                        <button onClick="createAndSendTestMail();"><img src="images/gfx/email.png"></button>
                    </div>
                    <div class="tcell"> EMail-Empf&auml;nger </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="text-align:center;width:40%;">Name</div>
        <div class="tcell ui-widget-content h40 f12b" style="text-align:center;width:60%;">Adresse</div>
    </div>
</div>
<?php
if(count($recipients)>0) {
?>
<div id="emailRecipientContentId">
    <div class="table" style="width:99%;margin:0 auto;">
<?php
    //foreach($recipients as $record) {
    for($count = 0; $count < count($recipients); $count++) {
        $record = $recipients[$count];
//         print_r($record);
//         echo "<pre>"; print_r($recipients); echo "</pre>";
?>
        <div class="trow ui-hover" onClick="modRecipient('<?php echo $record['recipient_id']; ?>');">
            <div class="tcell ui-widget-content h40 f12" style="width:40%;"><?php echo trim($record['recipient_name']); ?></div>
            <div class="tcell ui-widget-content h40 f12" style="width:60%;"><?php echo $record['recipient_address']; ?></div>
         </div>
<?php
    }
?>
    </div>
</div>
<?php
}
?>