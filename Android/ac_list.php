<?php 
include_once('../mysql_conn.php');
include_once('../functions/common.php');
//echo "ssss". $_REQUEST['ac'];
$pc=makeSafe(@$_GET['pc']);
$pc=is_numeric($pc)?$pc:"";
if($pc!="")
{
   $sql="select distinct ac_no,ac_name from ac where pc_no=".makeSafe($pc)." order by ac_no";
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
}

else
{

 $sql="select distinct ac_no,ac_name from ac  order by ac_no";
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

}


?>