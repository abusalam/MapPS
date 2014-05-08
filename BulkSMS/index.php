<?php

include_once __DIR__ . '/../lib.inc.php';
include_once __DIR__ . '/../smsgw/smsgw.inc.php';

$Sector = trim($_REQUEST['Sector']);
$SMS = trim(preg_replace('/\s+/', ' ', $_REQUEST['SMS']));
?>