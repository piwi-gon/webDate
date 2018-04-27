<?php
/**
 *
 * addSchedule.php
 *
 * author : piwi
 *
 * created: 05.11.2016
 * changed: 05.11.2016
 *
 * purpose:
 *
 */

session_start();
@define("DS", DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__) . DS . ".." . DS . "main" . DS . "baseStart.inc.php");
$recipient = $oWebDate->queryRecipient($_SESSION['RECIPIENT_ID']);
?>
<script>
function clearScheduleData() {
    $('#dialog').dialog('close').remove();
}
function saveScheduleData() {
    var formData = $('input,textarea,select').serialize();
    $.ajax({
        url: "helper/saveScheduleData.php",
        type: "POST",
        data: formData,
        success: function(data) {
            console.log(data);
            $('#resultScheduleSavingId').html('gespeichert');
            window.setTimeout(function() { $('#dialog').dialog('close').remove(); }, 3000);
        }
    });
}
$(document).ready(function() {
    $('#scheduleDateId').datepicker({autoOpen: false, dateFormat: 'dd.mm.yy', firstDay: 1});
});

function openRecipientChooser() {
    openAdditionalDialog("recipientChooserDialogId", "helper/emailRecipientChooser.inc.php", 300, 400);
}
</script>
<input type="hidden" name="selectedScheduleEntry" id="selectedScheduleEntryId" value="<?php echo $entry['schedule_id']; ?>">
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="width:100%;text-align:center;">Neuer Eintrag</div>
    </div>
</div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12" style="width:40%;">Empf&auml;nger</div>
        <div class="tcell ui-widget-content" style="width:60%;">
            <div class="table" style="width:100%;">
                <div class="trow">
                    <div class="tcell h40 f12" style="width:100%;">
                        <div id="recipientId"><?php echo $recipient['recipient_name'] . "<br>&lt;" . $recipient['recipient_address'] . "&gt;"; ?></div>
                        <input type="hidden" name="selectedRecipientId" id="selectedRecipientIdId" value="<?php echo $recipient['recipient_id']; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12" style="width:40%;">Datum des Termins</div>
        <div class="tcell ui-widget-content h40 f12" style="width:60%;">
            <input class="datePickerField" type="text" name="scheduleDate" id="scheduleDateId">
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content f12" style="width:40%;align:center;vertical-align:middle;">Text</div>
        <div class="tcell ui-widget-content f12" style="width:60%;">
            <textarea name="scheduleMessage" id="scheduleMessageId" style="width:99%;height:120px;"></textarea>
        </div>
    </div>
</div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12" style="width:25%;">Wiederkehrend ?</div>
        <div class="tcell ui-widget-content h40 f12" style="width:75%;">
            <input type="checkbox" name="scheduleIsPeriodic" id="scheduleIsPeriodicId" value="true">
        </div>
    </div>
</div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:left;padding-left:5px;">
            <div id="resultScheduleSavingId"></div>
        </div>
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:right;padding-right:5px;">
            <button onClick="clearScheduleData();">Abbrechen</button>
            <button onClick="saveScheduleData();">Speichern</button>
        </div>
    </div>
</div>
