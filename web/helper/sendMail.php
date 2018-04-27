<?php
/*
 * sendMail.php
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
$curDirr = dirname(__FILE__);
$cmd = "cli/mailcron.php?recipientAddress=".urlencode($_POST['testEmailRecipientAddress']) . "&message= ".urlencode($_POST['testEmailMessage']);
?>
<script>
$(document).ready(function() {
    $.ajax({
        url : '<?php echo $cmd; ?>',
        success: function() {}
    });
});
</script>

