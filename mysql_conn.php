<?php
$link=mysql_connect ("localhost", "root", "mysql") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("gis");
@session_start();
$_SESSION['uid']="1";
?>
