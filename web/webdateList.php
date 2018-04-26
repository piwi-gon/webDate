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
function openEditDialog(selectedEntry, selectedMonth) {
    openMainDialog("helper/modSchedule.php?selectedEntry="+selectedEntry+"&selectedMonth="+selectedMonth, getABSWidth(50), getABSHeight(55));
}

function addEntry(selectedEntry) {
    openMainDialog("helper/addSchedule.php", 600, 400);
}

function configuration() {
    openMainDialog("helper/configurationMain.php", getABSWidth(80), getABSHeight(60), 'administrationId', true);
}

function changeWebDatePassword() {
    openMainDialog("helper/changePassword.php", getABSWidth(50), getABSHeight(40), 'pwChangeId', true);
}

function changeRecipientAddress() {
    openMainDialog("helper/changeRecipientAddress.php", getABSWidth(50), getABSHeight(40), 'emailChangeId', true);
}
function logout() {
    $.ajax({
        url: 'helper/logout.php',
        type:"POST",
        success: function() {
            window.location.href="index.php";
        }
    });
}
</script>
<div class="table60">
    <div class="trow">
        <div class="tcell15 ui-widget-header h40 f12b" style="padding-left:10px;">
<?php
    if($_SESSION['ADMIN']) {
?>
            <button onClick="configuration();" title="Konfiguration"><img src="images/gfx/wrench.png"></button>
<?php
    }
?>
            <button onClick="changeWebDatePassword();" title="Konfiguration"><img src="images/gfx/lock.png"></button>
<?php
    if(!$_SESSION['ADMIN']) {
?>
            <button onClick="changeRecipientAddress();" title="Empfangsadress &auml;ndern"><img src="images/gfx/email.png"></button>
<?php
    }
?>
        </div>
        <div class="tcell75 ui-widget-header h40 f12b" style="padding-left:10px;">
            Liste aller Eintr&auml;ge
        </div>
        <div class="tcell75 ui-widget-header h40 f12b" style="padding-left:10px;">
            <button onClick="logout();" title="Logout"><img src="images/gfx/door_out.png"></button>
        </div>
    </div>
</div>
<div class="table60">
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
        <div class="tcell25 ui-widget-content ui-hover h100 f12b" style="text-align:center;" onClick="loadAllData('<?php echo $month; ?>');"><?php echo $months[$month]; ?></div>
<?php
    $intCount++;
}
?>
    </div>
</div>
<div style="width:90%;margin:0 auto;height:400px;overflow:auto;">
    <div class="table">
        <div class="trow">
            <div class="tcell100 ui-widget-content" id="scheduleListId"></div>
        </div>
    </div>
</div>
<?php
} else {
    $data = $oWebDate->queryAllData($_SESSION['RECIPIENT_ID'], $_GET['selectedMonth']);
?>
<div style="width:99%;margin:0 auto;">
    <div class="table">
        <div class="trow">
            <div class="tcell10 ui-widget-header h40 f12b" style="padding-left:10px;width:10%;">
                <div class="table100">
                    <div class="trow">
                        <div class="tcell40" style="text-align:center;">
<?php
    if(!$_SESSION['ADMIN']) {
?>
                            <button onClick="addEntry();" title="Neuer Eintrag"><img src="images/gfx/page_white.png"></button>
<?php
    }
?>
                        </div>
                        <div class="tcell60" style="text-align:center;">
                            LfdNr
                        </div>
                    </div>
                </div>
            </div>
            <div class="tcell10 ui-widget-header h40 f12b" style="padding-left:10px;">Tag</div>
            <div class="tcell10 ui-widget-header h40 f12b" style="padding-left:10px;">wiederk.?</div>
            <div class="tcell50 ui-widget-header h40 f12b" style="padding-left:10px;">Nachricht</div>
            <div class="tcell20 ui-widget-header h40 f12b" style="padding-left:10px;">Empf&auml;nger</div>
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
        <div class="trow ui-content ui-hover" onClick="openEditDialog('<?php echo $row['schedule_id']; ?>', '<?php echo $_GET['selectedMonth']; ?>');">
            <div class="tcell10 ui-content ui-hover h40 f12" style="padding-left:10px;"><?php echo sprintf("%02d", $i); ?></div>
            <div class="tcell10 ui-content ui-hover h40 f12" style="padding-left:10px;"><?php echo $row['day']; ?></div>
            <div class="tcell10 ui-content ui-hover h40 f12" style="padding-left:10px;"><?php echo (intval($row['single_message']) == 0 ? "Ja" : "Nein"); ?></div>
            <div class="tcell50 ui-content ui-hover h40 f12" style="padding-left:10px;"><?php echo iconv("utf-8", "iso-8859-1", $row['message']); ?></div>
            <div class="tcell30 ui-content ui-hover h40 f12" style="padding-left:10px;"><?php echo iconv("utf-8", "iso-8859-1", $row['recipient_name']); ?></div>
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