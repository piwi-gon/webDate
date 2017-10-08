<?php
/**
 *
 * migrate.php
 *
 * author : piwi
 *
 * created: 13.11.2016
 * changed: 13.11.2016
 *
 * purpose:
 *
 */

?>
<html>
<head>
    <title>WebDate V2.0.0 - Migrations-Tool</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="lib/js/base.js"></script>
</head>
<body>
<div id="dialog"></div>
<script>
function startMigration() {
    $('#resultMigrationId').html('Migration started<br>');
    $.ajax({
        url: "migrationStep1.php",
        type:'POST',
        success: function(data) {
            if(data.indexOf("success") > 0) {
                $('#resultMigrationId').append('Migration in progress<br>New Tables were created<br>');
                $.ajax({
                    url: "migrationStep2.php",
                    type:'POST',
                    success: function(data) {
                        if(data.indexOf("success") > 0) {
                            $('#resultMigrationId').append('Content copied<br>Migration has finished<br>');
                        } else{
                            $('#resultMigrationId').append(data);
                        }
                    }
                });
            } else {
                $('#resultMigrationId').append(data);
            }
        }
    });
}
</script>
<div class="table" style="width:99%;margin:0 auto;">
    <div class="trow">
        <div class="tcell ui-widget-header h40 f12b" style="text-align:center;">
            Migration Ihrer alten Daten
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="text-align:center;">
            <button onClick="startMigration();">Start</button>
        </div>
    </div>
    <div class="trow">
        <div class="tcell ui-widget-content h40 f12b" style="text-align:center;">
            <div id="resultMigrationId" style="width:99%;margin:0 auto;"></div>
        </div>
    </div>
</div>