<?php
/*
 * createAndSendMail.inc.php
 *
 * author: klaus
 *
 * created: 27.04.2018
 * changed: 27.04.2018
 *
 */

session_start();
error_reporting(E_ALL&~E_NOTICE);
ini_set("display_errors", 1);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$URL = "cli/mailcron.php?recipientAddress={RA}&message=".urlencode("Testmessage from WebDate V2.0.0");
?>
<script>
function sendMessage() {
    var recipientAddress=$('#testEmailRecipientAddressId').val();
    $.ajax({
        url: "<?php echo $URL; ?>".replace("{RA}", recipientAddress),
        type: 'POST',
        success: function(data) {
            console.log(data + '\n' + '<?php echo $URL; ?>');
            alert("gesendet", "OK");
        }
    });
}
</script>
<div class="table99">
    <div class="trow">
        <div class="tcell40 ui-widget-content f12b h40 lalign">Empfangsadresse</div>
        <div class="tcell60 ui-widget-content f12b h40 lalign">
            <input type="text" name="testEmailRecipientAddress" id="testEmailRecipientAddressId">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content f12b h40 lalign">Testext</div>
        <div class="tcell60 ui-widget-content f12b h40 lalign">Testmessage from WebDate V2.0.0</div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-header h40 f12b lalign">
            <div id="resultRecipientTestSendId"></div>
        </div>
        <div class="tcell60 ui-widget-header h40 f12 ralign">
            <button onClick="sendMessage();">Absenden</button>
        </div>
    </div>
</div>
