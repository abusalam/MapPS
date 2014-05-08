<?php 
@session_start();
 ini_set('date.timezone', 'Asia/Calcutta');
 include_once('../mysql_conn.php');
include_once('../functions/common.php');
if(!isset($_SESSION['admin_name']))
 echo "<script>location.href='login.php'</script>";
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
<div id="wrapper">
<div id="header-admin">
	<div class="logo"<a href="./"><img src="../logo.png" alt="Paschim medinipur"></a></div>
	
</div>
<div class="menu-container clearfix">
	
<ul id="nav">
	<li class="first"><a title="Ac List"  href="index.php?pgid=<?php echo base64_encode('ac_list');?>"><span> AC LIST </span></a>
	<li><a title="PS Details" class="parent" href="index.php?pgid=<?php echo base64_encode('ps_list');?>"><span> PS DETAILS </span></a>
	<li><a title="PS Details" class="parent" href="index.php?pgid=<?php echo base64_encode('poll_monitor');?>"><span> POLL MONITORING </span></a>
</ul>
	
</div>
<div style="min-height:400px">
<div class="block">
<?php 
					 $pageUrl=@base64_decode($_GET['pgid']).".php";
					if(isset($_GET['pgid']))
					{
					  if(is_file($pageUrl))
					   include($pageUrl);
					  else 
					   include("404.php");
					 }
					   else
					    include("init.php");
					?>
					   
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
