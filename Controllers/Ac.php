<?php
include_once('../mysql_conn.php');
include_once('../functions/common.php');
try
{
	if(makeSafe($_SESSION['uid'])!="")
	{
		
		if(makeSafe($_GET["action"])== "list"){
			//Get record count
			$result = mysql_query("SELECT COUNT(*) AS RecordCount FROM ac where  ac_no like '%" . makeSafe($_POST["ac_no"]) . "%';");
			$row = mysql_fetch_array($result);
			$recordCount = $row['RecordCount'];

			//Get records from database
			$result = mysql_query("SELECT * FROM ac where ac_no like '%" . makeSafe($_POST["ac_no"]) . "%' ORDER BY " . makeSafe($_GET["jtSorting"]) . " LIMIT " . makeSafe($_GET["jtStartIndex"]) . "," . makeSafe($_GET["jtPageSize"]) . ";");
			
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
			 $sql="select ac_no from ac where ac_no='".trim(makeSafe($_POST['ac_no']))."'";
			$result  = mysql_query($sql) or die('Error, query failed'.mysql_error());
			if(mysql_affected_rows()>0)
			{
				$jTableResult['Result'] = "ERROR";
				$jTableResult['Message'] = "Duplicate AC";
				print json_encode($jTableResult);
			}
			else
			{
			
				$sql="insert into ac(ac_no,ac_name,pc_no,pc_name,user_pass)";
				$sql=$sql." values('".makeSafe($_POST['ac_no'])."','".makeSafe($_POST['ac_name'])."','".makeSafe($_POST['pc_no'])."','".makeSafe($_POST['pc_name'])."','".makeSafe($_POST['user_pass'])."')";
				$result = mysql_query($sql);
				//Get last inserted record (to return to jTable)
				$result = mysql_query("SELECT * FROM ac WHERE ac_no = '".makeSafe($_POST['ac_no'])."'");
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
			$result = mysql_query("UPDATE ac SET ac_no = '" . makeSafe($_POST["ac_no"]) . "', 
			ac_name = '" . makeSafe($_POST['ac_name']). "' ,
			pc_no = '" . makeSafe($_POST['pc_no']). "' ,
			pc_name = '" . makeSafe($_POST['pc_name']). "' ,
			user_pass = '" . makeSafe($_POST['user_pass']). "' 
			WHERE ac_no = " . makeSafe($_POST["ac_no"]). ";");

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
		}
		//Deleting a record (deleteAction)
		else if(makeSafe($_GET["action"]) == "delete")
		{
			
				$result = mysql_query("select * from ps_details WHERE ac_no = " . makeSafe($_POST["ac_no"]) . ";");
				if(mysql_affected_rows($link)>0)
				{
					$jTableResult['Result'] = "ERROR";
					$jTableResult['Message'] = "Ps Details Exist, Please delete the ps details first";
					print json_encode($jTableResult);
				}
				else 
				{
					$result = mysql_query("DELETE FROM ac WHERE ac_no = " . makeSafe($_POST["ac_no"]) . ";");
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