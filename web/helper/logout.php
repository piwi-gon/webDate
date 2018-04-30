<?php
/*
 * logout.php
 *
 * author: klaus
 *
 * created: 26.04.2018
 * changed: 26.04.2018
 *
 */

@define("DS", DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS."..".DS."main".DS."baseStart.inc.php");
checkAuth();
session_destroy();
?>
<script>
$(document).ready(function() {
    window.location.href='<?php echo WEBDATE_WWW_DIR; ?>webdateMain.php';
});
</script>
