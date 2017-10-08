<?php
/**
 *
 * modSchedule.php
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
$entry = $oWebDate->queryEntry($_GET['selectedEntry']);
if (intval($entry['year']) > 0) {
    $year = $entry['year'];
} else {
    $year = date('Y');
}
?>
<script>
$(document).ready(function() {
    $('#scheduleDateId').datepicker({autoOpen: false});
});
function clearScheduleData() {
    console.log('try to close dialog');
    $('#dialog').dialog('close');
    $('#dialog').dialog("destroy");
}
function saveScheduleData() {
    $('#deleteEntryId').val('false');
    var formData = $('input,textarea,select').serialize();
    $.ajax({
        url: "helper/saveScheduleData.php",
        type: "POST",
        data: formData,
        success: function(data) {
            $('#resultScheduleSavingId').html('gespeichert');
            setTimeout(function() { clearScheduleData();}, 4000);
        }
    });
}
function deleteScheduleData() {
    $('#deleteEntryId').val('true');
    var formData = $('input,textarea,select').serialize();
    $.ajax({
        url: "helper/saveScheduleData.php",
        type: "POST",
        data: formData,
        success: function(data) {
            $('#resultScheduleSavingId').html('gespeichert');
            setTimeout(function() { clearScheduleData();}, 4000);
        }
    });
}

function openRecipientChooser() {
    openAdditionalDialog("recipientChooserDialogId", "helper/emailRecipientChooser.inc.php", 300, 400);
}
</script>
<input type="hidden" name="selectedScheduleEntry"
    id="selectedScheduleEntryId"
    value="<?php echo $entry['schedule_id']; ?>">
<input type="hidden" name="deleteEntry" id="deleteEntryId" value="false">
<div class="table" style="width: 99%; margin: 0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b"
            style="width: 100%; text-align: center;">Eintrag bearbeiten</div>
    </div>
</div>
<div class="table" style="width: 99%; margin: 0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12" style="width: 25%;">Empf&auml;nger</div>
        <div class="tcell ui-widget-content" style="width: 75%;">
            <div class="table" style="width: 100%;">
                <div class="trow">
                    <div class="tcell h40 f12" style="width: 70%;">
                        <div id="recipientId"><?php echo $entry['recipient_name']; ?></div>
                    </div>
                    <div class="tcell h40 f12" style="width: 30%;">
                        <button onClick="openRecipientChooser();">...</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12" style="width: 25%;">Datum
            des Termins</div>
        <div class="tcell ui-widget-content h40 f12" style="width: 75%;">
            <input type="text" name="scheduleDate" id="scheduleDateId"
                value="<?php echo sprintf("%02d.%02d.%d", $entry['day'], $entry['month'], $year); ?>">
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content f12">Text</div>
        <div class="tcell ui-widget-content f12">
            <textarea name="scheduleMessage" id="scheduleMessageId"
                style="width: 99%; height: 120px;"><?php echo iconv("utf-8", "iso-8859-1", $entry['message']); ?></textarea>
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12" style="width: 25%;">Wiederkehrend
            ?</div>
        <div class="tcell ui-widget-content h40 f12" style="width: 75%;">
            <input type="checkbox" name="scheduleIsPeriodic"
                id="scheduleIsPeriodicId"
                <?php echo $entry['single_message'] == 1 ? "" : " checked=\"checked\""; ?>
                value="true">
        </div>
    </div>
</div>
<div class="table" style="width: 99%; margin: 0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b"
            style="width: 20%; text-align: left; padding-left: 5px;">
            <button onClick="deleteScheduleData();">L&ouml;schen</button>
        </div>
        <div class="tcell ui-widget-header h40 f12b"
            style="width: 40%; text-align: left; padding-left: 5px;">
            <div id="resultScheduleSavingId" style="width: 99%;"></div>
        </div>
        <div class="tcell ui-widget-header h40 f12b"
            style="width: 40%; text-align: right; padding-right: 5px;">
            <button onClick="clearScheduleData();">Abbrechen</button>
            <button onClick="saveScheduleData();">Speichern</button>
        </div>
    </div>
</div>
