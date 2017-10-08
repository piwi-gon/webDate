<?php
/**
 *
 * emailRecipientChooser.inc.php
 *
 * author : piwi
 *
 * created: 08.01.2017
 * changed: 08.01.2017
 *
 * purpose:
 *
 */

session_start();
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$recipients = $oWebDate->queryRecipients();
?>
<script>
function addRecipientToScheduleEntry() {
    var selectedRecipientId = $('#emailRecipientId option:selected').val();
    $.ajax({
        url: "helper/readRecipientById.inc.php?selectedRecipientId=" + selectedRecipientId,
        type: 'POST',
        success: function(data) {
            var tokens = data.split("|");
            $('#recipientId').html(tokens[1]);
            // $('#selectedScheduleEntryId').val(selectedRecipientId);
            $('#selectedScheduleEntryId').val(tokens[0]);
        }
    });
}
</script>
<div class="table">
    <div class="trow">
        <div class="tcell f12b ui-widget-content">
            Filter: <input type="text" id="filterForEMailRecipientId" name="filterForEMailRecipient" style="width:123px;">
            <select name="emailRecipient" id="emailRecipientId" style="width:250px;height:200px;" size="10" onDblClick="addRecipientToScheduleEntry();">
<?php
if(count($recipients)>0) {
    foreach($recipients as $rec) {
?>
                <option class="optionview f10" value="<?php echo $rec['recipient_id']; ?>"><?php echo $rec['recipient_name']; ?></option>
<?php
    }
}
?>
            </select>
        </div>
    </div>
</div>