<?php 
include_once('../mysql_conn.php');
include_once('../functions/common.php');
//echo "ssss". $_REQUEST['ac'];
if(strtoupper(makeSafe(@$_GET['ac']))!="ALL")
{
   $sql="select distinct sector_no,sector_name from ps_details where ac_no=".makeSafe($_GET['ac'])." order by sector_no";
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