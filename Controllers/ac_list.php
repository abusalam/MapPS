<?php 
include_once('../mysql_conn.php');
include_once('../functions/common.php');
//echo "ssss". $_REQUEST['ac'];
if(strtoupper(makeSafe(@$_GET['ac']))!="ALL")
{
   $sql="select distinct ac_no,ac_name from ac where pc_no=".makeSafe($_GET['pc'])." order by ac_no";
$result = mysql_query($sql,$link)    or die("Query  failed! ".mysql_error());
    
    $rows = array();
	while($rec = mysql_fetch_assoc($result)) 
    {
        $rows[] = $rec;
    }
    mysql_free_result($result);
    
    
    echo json_encode($rows);
}
//else
//echo "[{"sector_no":"","sector_name":"Banspahari K.P.S.C. High school"}]";


?>