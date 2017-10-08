<?php
/**
 *
 * configurationLogin.php
 *
 * author : piwi
 *
 * created: 07.01.2017
 * changed: 07.01.2017
 *
 * purpose:
 *
 */

session_start();
?>
<script>
function checkLogin() {
    var loginName = $('#loginNameId').val();
    var loginPass = $('#loginPassId').val();
    var formData  = $('input').serialize();
    console.log(formData);
    if(formData != undefined) {
        $('#loginPassId').val('');
        $.ajax({
            url: "helper/checkLogin.php",
            type: "POST",
            data: formData,
            success: function(data) {
                if(data == "success") {
                    $('#mainContentId').load('webdateList.php');
                }
            }
        });
    }
}
function checkLoginKey(event) {
    if(event.keyCode == "13") { checkLogin(); }
}
</script>
<div id="mainConfigurationContentId" class="centerOnScreen60">
    <div class="table" style="width:99%;margin:0 auto;">
        <div class="trow">
            <div class="tcell ui-widget-header h40 calign" style="width:80%;margin:0 auto;">
                Webdate 2.0
            </div>
        </div>
    </div>
    <div class="table" style="width:99%;margin:0 auto;">
        <div class="trow">
            <div class="tcell ui-widget-content h40 calign f12b" style="width:80%;margin:0 auto;">
                Login<br>
                <input type="text" name="loginName" id="loginNameId" onkeypress="checkLoginKey(event);">
            </div>
        </div>
        <div class="trow">
            <div class="tcell ui-widget-content h40 calign f12b" style="width:80%;margin:0 auto;">
                Password<br>
                <input type="password" name="loginPass" id="loginPassId" onKeyPress="checkLoginKey(event);">
            </div>
        </div>
        <div class="trow">
            <div class="tcell ui-widget-content h40 ralign f12b" style="width:80%;margin:0 auto;">
                <button onClick="checkLogin();">Login</button>
            </div>
        </div>
    </div>
</div>