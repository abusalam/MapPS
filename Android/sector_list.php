<?php 
include_once('../mysql_conn.php');
include_once('../functions/common.php');
//echo "ssss". $_REQUEST['ac'];
if(strtoupper(makeSafe(@$_GET['ac']))=="ALL" or makeSafe(@$_GET['ac'])=="")
$ac=0;
else
$ac=makeSafe(@$_GET['ac']);

   $sql="select distinct sector_no,sector_name from ps_details where ac_no=".$ac." order by sector_no";
$result = mysql_query($sql,$link)    or die("Query  failed! ".mysql_error());
    $recordCount=mysql_affected_rows($link);
    $rows = array();
	while($rec = mysql_fetch_assoc($result)) 
    {
        $rows[] = $rec;
    }
    mysql_free_result($result);
    
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
   
?>