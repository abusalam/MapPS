<?php 
include_once('../mysql_conn.php');
include_once('../functions/common.php');

   $sql="select AVG(lat) as avglat,AVG(lon) as avglon from  ps_details  where 1=1";
   
if($_GET['ac']!="") $sql .=" and ac_no=".makeSafe($_GET['ac']);
if(trim($_GET['sector_no'])!="") $sql .=" and sector_no=".makeSafe($_GET['sector_no'])."";
$result = mysql_query($sql,$link)    or die("Query  failed! ".mysql_error());
    
    $rows = array();
	while($rec = mysql_fetch_assoc($result)) 
    {
        $rows[] = $rec;
    }
    mysql_free_result($result);
    
    
    echo json_encode($rows);



?>