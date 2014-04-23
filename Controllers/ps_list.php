<?php 
include_once('../mysql_conn.php');
include_once('../functions/common.php');
$sql="select ps_id,ps_no,ac_no,lat,lon,ps_name,sector_officer_name,sector_name,sector_officer_mobile,sector_no,bdo_office,bdo_no,pro_mobile_no,p1_mobile_no,
vulnerable_ps,critical_ps,lwe,mobile_shadow_zone from  ps_details where 1=1";

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