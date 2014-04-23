<?php

$_SESSION = array(); // Destroy the variables.
session_destroy(); // Destroy the session itself.
setcookie (session_name(), '', time()-300, '/', '', 0); // Destroy
mysql_close();
echo "<script>location.href='login.php'</script>";

?>