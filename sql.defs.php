<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('Visits'));
  $ObjDB->ddlQuery(SQLDefs('SentSMS'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'Visits':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'Visits` ('
              . '`PageID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`PageURL` text NOT NULL,'
              . '`VisitCount` bigint(20) NOT NULL DEFAULT \'1\','
              . '`LastVisit` timestamp NOT NULL '
              . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
              . '`PageTitle` text,'
              . '`VisitorIP` text NOT NULL,'
              . ' PRIMARY KEY (`PageID`)'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'SentSMS':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SentSMS` ('
              . '`MessageID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`MobileNo` varchar(10) NOT NULL,'
              . '`TxtSMS` text COLLATE utf8_bin NOT NULL,'
              . '`SubmitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
              . '`Response` varchar(50) COLLATE utf8_bin NOT NULL,'
              . 'PRIMARY KEY (`MessageID`)'
              . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;';
      break;
  }
  return $SqlDB;
}

?>
