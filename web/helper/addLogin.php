<?php
/*
 * addLogin.php
 *
 * author: klaus
 *
 * created: 27.08.2017
 * changed: 27.08.2017
 *
 */
 

?>
<div class="table99">
    <div class="trow">
        <div class="tcell30">Benutzer</div>
        <div class="tcell30">
            <input type="text" name="full_name" id="full_name_id" maxlength="250">
        </div>
    </div>
    <div class="trow">
        <div class="tcell30">Login</div>
        <div class="tcell30">
            <input type="text" name="login_name" id="login_name_id" maxlength="40">
        </div>
    </div>
    <div class="trow">
        <div class="tcell30">Passwort</div>
        <div class="tcell30">
            <input type="text" name="login_pass" id="login_pass_id" maxlength="40">
        </div>
    </div>
    <div class="trow">
        <div class="tcell30">Passwort<br><span style="font-size:smaller;">(Kontrolle)</span></div>
        <div class="tcell30">
            <input type="text" name="login_pass_ctrl" id="login_pass_ctrl_id" maxlength="40">
        </div>
    </div>
</div>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:left;padding-left:5px;">
            <div id="resultLoginSavingId"></div>
        </div>
        <div class="tcell ui-widget-header h40 f12b" style="width:50%;text-align:right;padding-right:5px;">
            <button onClick="clearLoginData();">Abbrechen</button>
            <button onClick="saveLoginData();">Speichern</button>
        </div>
    </div>
</div>
