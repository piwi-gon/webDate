<?php
/*
 * installer.php
 *
 * author: klaus
 *
 * created: 02.05.2018
 * changed: 02.05.2018
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
?>
<html lang="DE">
<head>
    <title>WebDate V2.0.0</title>
    <link rel="stylesheet" href="<?php echo WEBDATE_WWW_DIR; ?>css/base.css">
    <link rel="stylesheet" href="<?php echo WEBDATE_WWW_DIR; ?>css/jquery.messagebox.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="<?php echo WEBDATE_WWW_DIR; ?>lib/js/base.js"></script>
    <script src="<?php echo WEBDATE_WWW_DIR; ?>lib/js/jquery.messagebox.widget.js"></script>
</head>
<body>
<script>
var error = false;

$(document).ready( function () {
    $.ajax({
        url: 'checkIf.php?checkPHPVersion=5.6',
        type: 'POST',
        success: function(data) {
            if(data == "success") {
                $('#PHPVERSIONId').html('OK').addClass("isEnabled");
            } else {
                $('#PHPVERSIONId').html('FAIL').addClass("isNOTEnabled")
                error = true;
            }
        }
    });
    $.ajax({
        url: 'checkIf.php?checkExtension=mysqli',
        type: 'POST',
        success: function(data) {
            if(data == "success") {
                $('#MySQLId').html('OK').addClass("isEnabled");
            } else {
                $('#MySQLId').html('FAIL').addClass("isNOTEnabled")
            }
        }
    });
    $.ajax({
        url: 'checkIf.php?checkIsWriteable=true',
        type: 'POST',
        success: function(data) {
            if(data == "success") {
                $('#IsWriteableId').html('OK').addClass("isEnabled");
            } else {
                $('#IsWriteableId').html('FAIL').addClass("isNOTEnabled")
            }
        }
    })
});

function testDatabaseConnection() {
    var formData = $('input').serialize();
    $.ajax({
        url: 'checkDatabaseConnection.php',
        type: 'POST',
        data: formData,
        success: function(data) {
            if(data=="success") {
                $('#dbTestResultId').html(data).css({color: 'white', backgroundColor: 'green'});
                $('#saveDatabaseConnectionButtonId').prop("disabled", false);
            } else{
                $('#dbTestResultId').html('failed').css({color: 'white', backgroundColor: 'red'});
                $('#saveDatabaseConnectionButtonId').prop("disabled", true);
            }
        }
    });
}

function saveDatabaseConnection() {
    var formData = $('input').serialize();
    $.ajax({
        url: 'saveDatabaseConnection.php',
        type: 'POST',
        data: formData,
        success: function(data) {
            if(data == "success") {
                $('#dbCreateResultId').html(data).css({color: 'white', backgroundColor: 'green'});
                $('#finishInstallationButtonId').prop("disabled", false);
            } else {
                $('#dbCreateResultId').html('failed').css({color: 'white', backgroundColor: 'red'});
                $('#finishInstallationButtonId').prop("disabled", true);
            }
        }
    });
}
function finishInstallation() {
    openMainDialog('<?php echo WEBDATE_WWW_DIR; ?>installer/finishInstallation.php', getABSWidth(55), getABSHeight(70), 'finishInstallId', true);
}
</script>
<div class="table60">
    <div class="trow">
        <div class="tcell99 ui-widget-header h40 f12b calign vmiddle">Welcome to WebDate V2.0 installer</div>
    </div>
</div>
<div class="table60">
    <div class="trow">
        <div class="tcell99 ui-widget-content h40 f12b calign">Check Requirements</div>
    </div>
</div>
<div class="table60">
    <div class="trow">
        <div class="tcell60 ui-widget-content h40 f12b calign">PHP-Version >= 5.6</div>
        <div class="tcell40 ui-widget-content h40 f12 calign">
            <div class="table20">
                <div class="trow">
                    <div class="tcell99 h40 f12b checkquader" id="PHPVERSIONId">
                         &nbsp;&nbsp;checking ...&nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="trow">
        <div class="tcell60 ui-widget-content h40 f12b calign">MySQLi-Extension enabled</div>
        <div class="tcell40 ui-widget-content h40 f12 calign">
            <div class="table20">
                <div class="trow">
                    <div class="tcell99 h40 f12b checkquader" id="MySQLId">
                         &nbsp;&nbsp;checking ...&nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="trow">
        <div class="tcell60 ui-widget-content h40 f12b calign">Datenbank-Dir beschreibbar<br>(main/classes/lib)</div>
        <div class="tcell40 ui-widget-content h40 f12 calign">
            <div class="table20">
                <div class="trow">
                    <div class="tcell99 h40 f12b checkquader" id="IsWriteableId">
                         &nbsp;&nbsp;checking ...&nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table60">
    <div class="trow">
        <div class="tcell99 ui-widget-content h40 f12b calign">Datenbankverbindung</div>
    </div>
</div>
<div class="table60">
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b calign">DB-Host</div>
        <div class="tcell60 ui-widget-content h40 f12 calign">
            <input type="text" name="dbHost" id="dbHostid" class="dbrelated" placeholder="Host eingeben">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b calign">DB-Name</div>
        <div class="tcell60 ui-widget-content h40 f12 calign">
            <input type="text" name="dbName" id="dbHostid" class="dbrelated" placeholder="Name der Datenbank">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b calign">DB-Benutzer</div>
        <div class="tcell60 ui-widget-content h40 f12 calign">
            <input type="text" name="dbUser" id="dbHostid" class="dbrelated" placeholder="Benutzername">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b calign">DB-Passwort</div>
        <div class="tcell60 ui-widget-content h40 f12 calign">
            <input type="password" name="dbPass" id="dbHostid" class="dbrelated" placeholder="Passwort">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b calign">DB-Passwort (WH)</div>
        <div class="tcell60 ui-widget-content h40 f12 calign">
            <input type="password" name="dbPass_WH" id="dbHostid" class="dbrelated" placeholder="Passwort (Kontrolle)">
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b calign">
            <div id="dbTestResultId"></div>
        </div>
        <div class="tcell60 ui-widget-content h40 f12b ralign">
            <button onClick="testDatabaseConnection();">Testen</button>
        </div>
    </div>
    <div class="trow">
        <div class="tcell40 ui-widget-content h40 f12b calign">
            <div id="dbCreateResultId"></div>
        </div>
        <div class="tcell60 ui-widget-content h40 f12b ralign">
            <button id="saveDatabaseConnectionButtonId" disabled="disabled" onClick="saveDatabaseConnection();">Tabellen anlegen</button>
        </div>
    </div>
</div>
<div class="table60">
    <div class="trow">
        <div class="tcell99 ui-widget-content h40 f12b calign">
            <button id="finishInstallationButtonId" disabled="disabled" onClick="finishInstallation();">Installation abschliessen</button>
        </div>
    </div>
</div>
</body>
</html>