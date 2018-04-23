<?php
/**
 *
 * webdateList.php
 *
 * author : piwi
 *
 * created: 04.11.2016
 * changed: 04.11.2016
 *
 * purpose:
 *
 */

ini_set("display_errors", 1);
@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."main".DS."baseStart.inc.php");
$months = array("01"=>"Januar", "02"=>"Februar", "03"=>"M&auml;rz", "04"=>"April",   "05"=>"Mai",      "06"=>"Juni",
                "07"=>"Juli",   "08"=>"August",  "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Dezember");
if(!$_SESSION['AUTH']) {
?>
<script>
$(document).ready(function() {
    $('#mainContentId').load('helper/configurationLogin.php');
});
</script>
<?php
}
if($_GET['selectedMonth'] == "") {
?>
<script>
function loadAllData(selectedMonth) {
    $('#scheduleListId').html('');
    $('#scheduleListId').load('webdateList.php?selectedMonth='+selectedMonth);
}
function openEditDialog(selectedEntry) {
    openMainDialog("helper/modSchedule.php?selectedEntry="+selectedEntry, getABSWidth(50), getABSHeight(55));
}

function addEntry(selectedEntry) {
    openMainDialog("helper/addSchedule.php", 600, 400);
}

function configuration() {
    openMainDialog("helper/configurationMain.php", getABSWidth(80), getABSHeight(60), 'administrationId', true);
}
</script>
<div class="table" style="width:60%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="padding-left:10px;width:25%;">
<?php
    if($_SESSION['ADMIN']) {
?>
            <button onClick="configuration();" title="Konfiguration"><img src="images/gfx/wrench.png"></button>
<?php
    }
?>
        </div>
        <div class="tcell ui-widget-header h40 f12b" style="padding-left:10px;width:85%;">Liste aller Eintr&auml;ge</div>
    </div>
</div>
<div class="table" style="width:60%;margin:0 auto;">
<?php
$intCount=0;
foreach(array_keys($months) as $month) {
    if($intCount == 0) {
?>
    <div class="trow">
<?php
    } else if($intCount%4==0) {
?>
    </div>
    <div class="trow">
<?php
    }
?>
        <div class="tcell ui-widget-content ui-hover h100 f12b" style="width:25%;text-align:center;" onClick="loadAllData('<?php echo $month; ?>');"><?php echo $months[$month]; ?></div>
<?php
    $intCount++;
}
?>
    </div>
</div>
<div style="width:90%;margin:0 auto;height:400px;overflow:auto;">
    <div class="table" style="width:100%;">
        <div class="trow">
            <div class="tcell ui-widget-content" id="scheduleListId"></div>
        </div>
    </div>
</div>
<?php
} else {
    $data = $oWebDate->queryAllData($_SESSION['RELATED_EMAIL_ID'], $_GET['selectedMonth']);
?>
<div style="width:99%;margin:0 auto;">
    <div class="table" style="width:100%;">
        <div class="trow">
            <div class="tcell ui-widget-header h40 f12b" style="padding-left:10px;width:10%;">
                <div class="table" style="width:100%;">
                    <div class="trow">
                        <div class="tcell" style="width:40%;text-align:center;">
                            <button onClick="addEntry();" title="Neuer Eintrag"><img src="images/gfx/page_white.png"></button>
                        </div>
                        <div class="tcell" style="width:60%;text-align:center;">
                            LfdNr
                        </div>
                    </div>
                </div>
            </div>
            <div class="tcell ui-widget-header h40 f12b" style="padding-left:10px;width:10%;">Tag</div>
            <div class="tcell ui-widget-header h40 f12b" style="padding-left:10px;width:10%;">wiederk.?</div>
            <div class="tcell ui-widget-header h40 f12b" style="padding-left:10px;width:50%;">Nachricht</div>
            <div class="tcell ui-widget-header h40 f12b" style="padding-left:10px;width:30%;">Empf&auml;nger</div>
        </div>
    </div>
</div>
<div style="width:99%;margin:0 auto;height:340px;overflow:auto;">
    <div class="table" style="width:100%;">
<?php
$i = 0;
    if(count($data)>0) {
        if(is_array($data)) {
            foreach($data as $row){
                $i++;
?>
        <div class="trow ui-content ui-hover" onClick="openEditDialog('<?php echo $row['schedule_id']; ?>');">
            <div class="tcell ui-content ui-hover h40 f12" style="padding-left:10px;width:10%;"><?php echo sprintf("%02d", $i); ?></div>
            <div class="tcell ui-content ui-hover h40 f12" style="padding-left:10px;width:10%;"><?php echo $row['day']; ?></div>
            <div class="tcell ui-content ui-hover h40 f12" style="padding-left:10px;width:10%;"><?php echo (intval($row['single_message']) == 0 ? "Ja" : "Nein"); ?></div>
            <div class="tcell ui-content ui-hover h40 f12" style="padding-left:10px;width:50%;"><?php echo iconv("utf-8", "iso-8859-1", $row['message']); ?></div>
            <div class="tcell ui-content ui-hover h40 f12" style="padding-left:10px;width:30%;"><?php echo iconv("utf-8", "iso-8859-1", $row['recipient_name']); ?></div>
        </div>
<?php
            }
        }else {
            echo "<pre>" . htmlentities(print_r($data)) . "<br>";
        }
    }
?>
    </div>
</div>
<?php
}
?>