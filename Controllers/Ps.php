<?php
include_once('../mysql_conn.php');
include_once('../functions/common.php');
try
{
	if(makeSafe($_SESSION['uid'])!="")
	{
		
		if(makeSafe($_GET["action"])== "list"){
			//Get record count
			$result = mysql_query("SELECT COUNT(*) AS RecordCount FROM ps_details where  ps_no like '%" . makeSafe($_POST["ps_no"]) . "%' and ac_no like '%" . makeSafe($_POST["ac_no"]) . "%';");
			$row = mysql_fetch_array($result);
			$recordCount = $row['RecordCount'];

			//Get records from database
			$sql="SELECT * FROM ps_details where  ps_no like '%" . makeSafe($_POST["ps_no"]) . "%' and ac_no like '%" . makeSafe($_POST["ac_no"]) . "%'  ORDER BY " . makeSafe($_GET["jtSorting"]) . " LIMIT " . makeSafe($_GET["jtStartIndex"]) . "," . makeSafe($_GET["jtPageSize"]) . "";
			$result = mysql_query($sql);
			
			//Add all records to an array
			$rows = array();
			while($row = mysql_fetch_array($result))
			{
				$rows[] = $row;
			}

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = $recordCount;
			$jTableResult['Records'] = $rows;
			print json_encode($jTableResult);
		}
		//Creating a new record (createAction)
		else if(makeSafe($_GET["action"]) == "create"){
			 $sql="select ps_no from ps_details where ps_no='".trim(makeSafe($_POST['ps_no']))."' and ac_no='".trim(makeSafe($_POST['ac_no']))."'";
			$result  = mysql_query($sql) or die('Error, query failed'.mysql_error());
			if(mysql_affected_rows()>0)
			{
				$jTableResult['Result'] = "ERROR";
				$jTableResult['Message'] = "Duplicate AC";
				print json_encode($jTableResult);
			}
			else
			{
			
				$sql="insert into ps_details( ac_no, ps_no, ps_name, lat, lon, sector_officer_name, sector_officer_mobile,pro_mobile_no,p1_mobile_no,
				vulnerable_ps,critical_ps,lwe,mobile_shadow_zone,vst_name,vst_mobile,sst_name,sst_mobile,fs_name,fs_mobile)";
				$sql=$sql." values('".makeSafe($_POST['ac_no'])."',
				'".makeSafe($_POST['ps_no'])."',
				'".makeSafe($_POST['ps_name'])."',
				'".makeSafe($_POST['lat'])."',
				'".makeSafe($_POST['lon'])."',
				'".makeSafe($_POST['sector_officer_name'])."',
				'".makeSafe($_POST['sector_officer_mobile'])."',
				'".makeSafe($_POST['pro_mobile_no'])."',
				'".makeSafe($_POST['p1_mobile_no'])."',
				'".makeSafe($_POST['vulnerable_ps'])."',
				'".makeSafe($_POST['critical_ps'])."',
				'".makeSafe($_POST['lwe'])."',
				'".makeSafe($_POST['mobile_shadow_zone'])."',
				'".makeSafe($_POST['vst_name'])."',
				'".makeSafe($_POST['vst_mobile'])."',
				'".makeSafe($_POST['sst_name'])."',
				'".makeSafe($_POST['sst_mobile'])."',
				'".makeSafe($_POST['fs_name'])."',
				'".makeSafe($_POST['fs_mobile'])."'
				
				)";
				$result = mysql_query($sql);
				//Get last inserted record (to return to jTable)
				$result = mysql_query("SELECT * FROM ps_details WHERE ps_id = LAST_INSERT_ID();");
				$row = mysql_fetch_array($result);

				//Return result to jTable
				$jTableResult = array();
				$jTableResult['Result'] = "OK";
				$jTableResult['Record'] = $row;
				print json_encode($jTableResult);
			}
		}
		//Updating a record (updateAction)
		else if(makeSafe($_GET["action"]) == "update")
		{
			//Update record in database
			$sql="UPDATE ps_details SET  
				ac_no='".makeSafe($_POST['ac_no'])."',
				ps_no='".makeSafe($_POST['ps_no'])."',
				ps_name='".makeSafe($_POST['ps_name'])."',
				lat='".makeSafe($_POST['lat'])."',
				lon='".makeSafe($_POST['lon'])."',
				sector_officer_name='".makeSafe($_POST['sector_officer_name'])."',
				
				sector_officer_mobile='".makeSafe($_POST['sector_officer_mobile'])."',
				pro_mobile_no='".makeSafe($_POST['pro_mobile_no'])."',
				p1_mobile_no='".makeSafe($_POST['p1_mobile_no'])."',
				vulnerable_ps='".makeSafe($_POST['vulnerable_ps'])."',
				critical_ps='".makeSafe($_POST['critical_ps'])."',
				lwe='".makeSafe($_POST['lwe'])."',
				mobile_shadow_zone='".makeSafe($_POST['mobile_shadow_zone'])."',
				vst_name='".makeSafe($_POST['vst_name'])."',
				vst_mobile='".makeSafe($_POST['vst_mobile'])."',
				sst_name='".makeSafe($_POST['sst_name'])."',
				sst_mobile='".makeSafe($_POST['sst_mobile'])."',
				fs_name='".makeSafe($_POST['fs_name'])."',
				fs_mobile='".makeSafe($_POST['fs_mobile'])."'
				where ps_id=" . makeSafe($_POST["ps_id"]). "";
			$result = mysql_query($sql);

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
		}
		//Deleting a record (deleteAction)
		else if(makeSafe($_GET["action"]) == "delete")
		{
			
				$result = mysql_query("select * from ps_details WHERE ps_no = " . makeSafe($_POST["ps_no"]) . ";");
				if(mysql_affected_rows($link)>0)
				{
					$jTableResult['Result'] = "ERROR";
					$jTableResult['Message'] = "Ps Details Exist, Please delete the ps details first";
					print json_encode($jTableResult);
				}
				else 
				{
					$result = mysql_query("DELETE FROM ps_details WHERE ps_no = " . makeSafe($_POST["ps_no"]) . ";");
					$jTableResult = array();
					$jTableResult['Result'] = "OK";
					print json_encode($jTableResult);
				}	
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