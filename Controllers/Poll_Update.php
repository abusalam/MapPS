<?php
include_once('../mysql_conn.php');
include_once('../functions/common.php');
$pc=isset($_POST['pc_no'])?$_POST['pc_no']:"0";
$poll_stat=isset($_POST['poll_stat'])?$_POST['poll_stat']:"";
$ac=isset($_POST['ac_no'])?$_POST['ac_no']:"";
$ps_no=isset($_POST['ps_no'])?$_POST['ps_no']:"";
$ps_no=is_numeric($ps_no)?$ps_no:"";
$pc=is_numeric($pc)?$pc:"0";


$sector_no=isset($_POST['sector_no'])?$_POST['sector_no']:"";
try
{
	if(makeSafe($_SESSION['uid'])!="")
	{
		
		if(makeSafe($_GET["action"])== "list"){
			//Get record count
			$sql="select COUNT(ps_id) AS RecordCount from  ps_details,ac  where ps_details.ac_no=ac.ac_no ";
			if($pc!="") $sql .=" and pc_no=".makeSafe($pc);
			if($ac!="") $sql .=" and ps_details.ac_no=".makeSafe($ac);
			if($ps_no!="") $sql .=" and ps_details.ac_no=".makeSafe($ps_no);
			if($poll_stat!="") $sql .=" and ps_details.poll_stat='".makeSafe($poll_stat)."'";
			if(trim($sector_no)!="" && trim($sector_no)!="null") $sql .=" and sector_no=".makeSafe($sector_no)."";

			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$recordCount = $row['RecordCount'];

			//Get records from database
			$sql="select ps_id,ps_no,ac.ac_no,ps_name,sector_officer_name,sector_name,sector_officer_mobile,sector_no,ps_details.bdo_office,ps_details.bdo_no,mobile_shadow_zone,poll_stat from  ps_details,ac  where ps_details.ac_no=ac.ac_no ";
			if($pc!="") $sql .=" and pc_no=".makeSafe($pc);
			if($ac!="") $sql .=" and ps_details.ac_no=".makeSafe($ac);
			if($ps_no!="") $sql .=" and ps_no=".makeSafe($ps_no);
			if($poll_stat!="") $sql .=" and ps_details.poll_stat='".makeSafe($poll_stat)."'";
			if(trim($sector_no)!="" && trim($sector_no)!="null") $sql .=" and sector_no=".makeSafe($sector_no)."";
			
			 $sql .=" ORDER BY " . makeSafe($_GET["jtSorting"]) . " LIMIT " . makeSafe($_GET["jtStartIndex"]) . "," . makeSafe($_GET["jtPageSize"]) . "";
			$result = mysql_query($sql);
			
			//Add all records to an array
			$rows = array();
			while($row = mysql_fetch_array($result))
			{
				$rows[] = $row;
			}

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['SQL'] = $sql;
			$jTableResult['PC'] = $pc;
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = $recordCount;
			$jTableResult['Records'] = $rows;
			print json_encode($jTableResult);
		}
		//Updating a record (updateAction)
		else if(makeSafe($_GET["action"]) == "update")
		{
			//Update record in database
			$sql="UPDATE ps_details SET  
				poll_stat='".makeSafe($_POST['poll_stat'])."'
				where ps_id=" . makeSafe($_POST["ps_id"]). "";
			$result = mysql_query($sql);

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
		}
		

		//Close database connection
		mysql_close($link);
	}
	else
	{
		$jTableResult['Result'] = "ERROR";
		$jTableResult['Message'] = "You are not authorized";
		print json_encode($jTableResult);
	}
}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
	
?>