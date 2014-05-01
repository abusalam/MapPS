<?php 
include_once('../mysql_conn.php');
include_once('../functions/common.php');
$ac=isset($_GET['ac'])?$_GET['ac']:"";
$ps_no=isset($_GET['ps_no'])?$_GET['ps_no']:"";
$sector_no=isset($_GET['sector_no'])?$_GET['sector_no']:"";
$op_criteria=isset($_GET['op_criteria'])?$_GET['op_criteria']:"";

if($_GET['stype']=="avg")
{
$sql="select AVG(lat) as avglat,AVG(lon) as avglon from  ps_details where 1=1";
if($ps_no!="") $sql .=" and ps_no=".makeSafe($ps_no);
if($ac!="") $sql .=" and ac_no=".makeSafe($ac);
if(trim($sector_no)!="" && trim($sector_no)!="null") $sql .=" and sector_no=".makeSafe($sector_no)."";
if($op_criteria=="Vulnerable") $sql .=" and vulnerable_ps='Yes'";
if($op_criteria=="Critical") $sql .=" and critical_ps='Yes'";
if($op_criteria=="LWE") $sql .=" and lwe='Yes'";
if($op_criteria=="MSZ") $sql .=" and mobile_shadow_zone='Yes'";
//echo $sql;
$result = mysql_query($sql,$link)    or die("Query  failed! ".mysql_error());
    
    $rows = array();
	while($rec = mysql_fetch_assoc($result)) 
    {
        $rows[] = $rec;
    }
    mysql_free_result($result);
    
    
    echo json_encode($rows);
	
}
if($_GET['stype']=="ps")
{
$sql="select ps_id,ps_no,ac_no,lat,lon,ps_name,sector_officer_name,sector_name,sector_officer_mobile,sector_no,bdo_office,bdo_no,pro_mobile_no,p1_mobile_no,
vulnerable_ps,critical_ps,lwe,mobile_shadow_zone,vst_name, vst_mobile, sst_name, sst_mobile, fs_name, fs_mobile,poll_stat from  ps_details where 1=1";
if($ps_no!="") $sql .=" and ps_no=".makeSafe($ps_no);
if($ac!="") $sql .=" and ac_no=".makeSafe($ac);
if(trim($sector_no)!="" && trim($sector_no)!="null") $sql .=" and sector_no=".makeSafe($sector_no)."";
if($op_criteria=="Vulnerable") $sql .=" and vulnerable_ps='Yes'";
if($op_criteria=="Critical") $sql .=" and critical_ps='Yes'";
if($op_criteria=="LWE") $sql .=" and lwe='Yes'";
if($op_criteria=="MSZ") $sql .=" and mobile_shadow_zone='Yes'";
$result = mysql_query($sql,$link)    or die("Query  failed! ".mysql_error());
    
    $rows = array();
	while($rec = mysql_fetch_assoc($result)) 
    {
        $rows[] = $rec;
    }
    mysql_free_result($result);
    
    
    echo json_encode($rows);
}					
	?>