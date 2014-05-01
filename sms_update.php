<?php 
include_once('mysql_conn.php');
include_once('functions/common.php');
//sms format
//Commencement of poll
// S<space><PS NO><space><AC NO>
//END of poll
// E<space><PS NO><space><AC NO>


$phone_no=trim($_GET['phone']);
$message=trim($_GET['message']);
//remove the extra space from message
if($phone_no!="" and $message!="")
{

		$message = preg_replace( '/\s+/', ' ', $message );
		$message_pieces = explode(" ", $message);
		$poll_status=@strtoupper($message_pieces[0]);
		$ps_no=@$message_pieces[1];
		$ac_no=@$message_pieces[2];
		if($poll_status=="E" or $poll_status=="S" )
		{
			if($poll_status!="" and $ps_no!="" and $ac_no!="")
			{
			
				 $query   = "SELECT ps_id  FROM ps_details where sector_officer_mobile='".$phone_no."'";
				$result  = mysql_query($query) or die('Error, query failed,select');
				if(mysql_affected_rows($link)>0)
					{
						 $sql_update="update ps_details set poll_stat='".$poll_status."' where ac_no='".$ac_no."' and ps_no='".$ps_no."'";
						$result  = mysql_query($sql_update) or die('Error, query failed,select');

					}
				else
					echo"Invalid sector officer";	
			 }	
        }		 
}			
else
{

echo "invalid";
}