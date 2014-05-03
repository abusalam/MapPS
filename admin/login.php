<?php 
@session_start();
 ini_set('date.timezone', 'Asia/Calcutta');
 include_once('../mysql_conn.php');
include_once('../functions/common.php');
 ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>AC LIST</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="Bio, Binpur-II">
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/common.css">
	<link rel="stylesheet" href="../css/skeleton.css">
	<link rel="stylesheet" href="../css/layout.css">
	<link rel="stylesheet" href="../css/JQthems/blue/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="../jtable/themes/lightcolor/green/jtable.css" type="text/css" />
	<link rel="stylesheet" href="../css/validationEngine.jquery.css"  type="text/css" />
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="../favicon.ico">
	<link rel="apple-touch-icon" href="../apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../apple-touch-icon-114x114.png">
	

<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.24.ui.min.js"></script>
<script type="text/javascript" src="../jtable/jquery.jtable.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js" language="javascript"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-en.js" language="javascript"></script>
<script type="text/javascript" src="../js/jquery.validate.js" language="javascript"></script>
</script>
</head>

<body>
	<?php

$msg="";
@$act=@$_GET['act'];
if($act==base64_encode('login'))
{
@$uname= makeSafe($_POST['uname']);
@$pass=makeSafe($_POST['pass']);

if($uname=="SDO" and  $pass=="sdojar")
{
$_SESSION['uType']="A";
				$_SESSION['ac']="1";
				$_SESSION['admin_name']="Administrator";
				echo "<script>location.href='index.php?src=init.php'</script>";
}				
else
   $msg="<font color=red>Invalid Username and Password</font>";
	/*
      //echo "Please Wati.........<br>Verifying Username and Password.........";
	if($uname=="" || $pass=="")
	{
	$msg="<font color=red>Blank Username and Password</font>";

	}
	else
	{
		
			$query="SELECT id,usertype,restricted FROM admin_users where userid='".$uname."' and password='".$pass."'";
			$result  = mysql_query($query) or die('Error, query failed'.mysql_error());
			if(mysql_affected_rows($link)>0)
			{	$row     = mysql_fetch_array($result, MYSQL_ASSOC);
			//echo $row['restricted'];
			if($row['restricted']=="Y")
			  $msg="<font color=red>Your login has been Restricted, Please contact administrator of your block </font>";
			  else
			  {
				
				$_SESSION['uType']=$row["usertype"];;
				$_SESSION['adm_id']=$row["id"];
				$_SESSION['admin_name']=$_POST["uname"];
				//echo $_SESSION['uType'];
				echo "<script>location.href='index.php?src=init.php'</script>";
				}
			}
			else
			
				$msg="<font color=red>Invalid Username and Password</font>";
			
		
		
	}	*/
}//login

?>
<div id="wrapper">
<div id="header-admin">
	<div class="logo"<a href="./"><img src="../logo.png" alt="Paschim medinipur"></a></div>
	
</div>
<div style="text-align:center;margin:30px auto;width:400px">
<div class="block">
<form action="login.php?act=<?php echo base64_encode('login'); ?>" name="frmX" method="post">
<table  width="100%" >
	<tbody>
		<tr><td colspan=2 align="left"><div class="block-title"><h2>ADMIN LOGIN</h2></div></td></tr>
		<tr>
			<td align="right">User Name :</td><td><input type="text" name="uname" size="15" /></td>
		</tr>
		<tr>
			<td align="right">Password :</td><td><input type="password" name="pass" size="15" /></td>
		</tr>
		<tr><td colspan="2" class="text-left"><?php    echo @$msg;  ?></td>	</tr>
		<tr><td colspan="2" class="text-left"><input type="submit" name="submit" value="login" class="btn" /></td>	</tr>
				
			</table>	
			</form>
					   
</div>
</div>
<div class="clear"></div>
			
			<div class="sixteen columns">
	
				<div id="footer" class="adjective clearfix">
					<div class="copyright">Copyright &copy; 2014</div>
					<div class="developed"></div>
				</div><!--/ .adjective-->			
				
			</div>
			</div>
			</body>
			</html>