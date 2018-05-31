<?php
/*
 * finishInstallation.php
 *
 * author: klaus
 *
 * created: 27.05.2018
 * changed: 27.05.2018
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");

/**
 * we create now a login for admin with defined password
 * but with the encoding we use
 */

$ADMIN['emailRecipientUser'] = "admin";
$ADMIN['emailRecipientPass'] = "Ws57Adu9";
$ADMIN['emailRecipientName'] = "Administrator";

echo "adding login-data";

$oWebDate->addLoginData($ADMIN);

$loginId = $oWebDate->checkLoginData("admin", "Ws57Adu9");
if(intval($loginId) > 0) {
    file_put_contents(dirname(__FILE__).DS."installationOK.txt", "");
?>
<script>
$(document).ready(function() {
    $.ajax({
        url: 'removeInstallationDir.php',
        type:'POST',
        success:function(data){
            console.log(data);
        }
    });
});
</script>
<div class="table99">
    <div class="trow">
        <div class="tcell99 ui-widget-header h40 f12b">
            Installation abgeschlossen
        </div>
    </div>
    <div class="trow">
        <div class="tcell99 ui-widget-content h40 f12">
            Sie haben nun einen ADMIN-Login mit dem Benutzer 'admin' und dem Passwort 'Ws57Adu9'
        </div>
    </div>
    <div class="trow">
        <div class="tcell99 ui-widget-content h40 f12">
            Das Verzeichnis für die Installation wurde entfernt.
        </div>
    </div>
    <div class="trow">
        <div class="tcell99 ui-widget-content h40 f12">
            Mit dem Admin k&ouml;nnen Sie sich nun <a href="<?php echo WEBDATE_WWW_DIR; ?>">hier</a> anmelden und die Verwaltung beginnen.
        </div>
    </div>
</div>
<?php
} else {
?>
<div class="table99">
    <div class="trow">
        <div class="tcell99 ui-widget-header h40 f12b">
            Installation konnte nicht korrekt abgeschlossen werden - kein Login m&ouml;glich
        </div>
    </div>
</div>
<?php
}
?>