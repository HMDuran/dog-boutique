<?php
session_start();
session_unset();
session_destroy();

setcookie(session_name(), '', time() - 3600, '/');

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

header("Location: /apps/views/home/home.php");
exit();
?>

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
        location.replace("/apps/views/home/home.php");
    };
</script>