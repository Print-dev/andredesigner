<?php 
session_start();
session_destroy();
echo '<script>document.location.href="intranet.php";</script>';
?>