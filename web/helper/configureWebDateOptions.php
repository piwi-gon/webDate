<?php
/*
 * configureWebDateOptions.php
 *
 * author: klaus
 *
 * created: 28.04.2018
 * changed: 28.04.2018
 *
 */

session_start();
error_reporting(E_ALL&~E_NOTICE);
ini_set("display_errors", 1);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
$options = $oWebDate->queryWebDateOptions();
?>
<script>
function clearOptionData() {
    window.setTimeout(function() { $('#webDateOptionId').dialog('close').remove(); }, 500);
}
function saveOptionData() {
    var formData = $('input,checkbox').serialize();
    $.ajax({
        url: 'helper/saveWebDateOptions.php',
        type: 'POST',
        data: formData,
        success: function(data) {
            console.log(data);
            alert("gespeichert", "OK");
        }
    });
}
</script>
<div class="table99">
    <div class="trow">
        <div class="tcell40 ui-widget-header h40 f12b calign">Name der Option</div>
        <div class="tcell60 ui-widget-header h40 f12b calign">Wert der Option</div>
    </div>
<?php
foreach($options as $opt) {
?>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12 lalign">
            <?php echo $opt['option_name']; ?>
        </div>
        <div class="tcell60 ui-widget-content h40 f12 lalign">
<?php
    if($opt['option_type'] == "bool") {

?>
            <input type="checkbox" name="<?php echo $opt['option_name']; ?>" id="<?php echo $opt['option_name']; ?>Id"<?php echo $opt['option_value']!=""?" checked=\"checked\" ":" "; ?> value="true">
<?php
    } else {
?>
            <input type="text" name="<?php echo $opt['option_name']; ?>" id="<?php echo $opt['option_name']; ?>Id" value="<?php echo $opt['option_value']; ?>">
<?php
    }
?>
        </div>
    </div>
<?php
}
?>
</div>
<div class="table99">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:left;padding-left:5px;">
            <div id="resultOptionChangeId"></div>
        </div>
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:right;padding-right:5px;">
            <button onClick="clearOptionData();">Abbrechen</button>
            <button onClick="saveOptionData();">Speichern</button>
        </div>
    </div>
</div>
