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
	
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="../favicon.ico">
	<link rel="apple-touch-icon" href="../apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../apple-touch-icon-114x114.png">
	
</script>
</head>

<body>

<div class="block-admin">
 <script>
<!--

function waitSign()
{
document.getElementById("WS").innerHTML = '<img src="../../images/loading.gif" align="center" />Uploading...';

}
//-->


</script>
 <?php

$ac_no=$_GET['ac_no'];
$ps_no=@$_GET['ps_no'];

$Errs="";

include_once('class.sample_image.php');

if(isset($_POST['submit']))
 {	
 $Errs="";
 if ($_FILES["file"]["error"] > 0)// no logo upload
	$Errs="<DIV class='message error'>Please select image</DIV>";	
   else
    {   
		$extn=explode('.',$_FILES["file"]["name"]);
		$upathThumb="../ps_photo/".$ac_no."_".$ps_no."_T.".strtolower($extn[1]);
		$upathBig="../ps_photo/".$ac_no."_".$ps_no.".".strtolower($extn[1]);
		move_uploaded_file($_FILES["file"]["tmp_name"],$upathBig);
		$Errs=$Errs."<div class='message error'>Image Updated</div>";
		
		
		$image = new SimpleImage();
		$image->load($upathBig);
		$targetWidth=640;
		$targetHeight=480;
		if ($image->getWidth()>=$image->getHeight()) 
			$percentage = ($targetWidth / $image->getWidth());
		else 
			$percentage = ($targetHeight / $image->getHeight());

		$width = round($image->getWidth() * $percentage);
		$height = round($image->getHeight() * $percentage);
		$image->resize($width,$height);
		$image->save($upathBig);
		
		$image = new SimpleImage();
		$image->load($upathBig);
		
		$targetWidth=100;
		$targetHeight=75;
		if ($image->getWidth()>=$image->getHeight()) 
			$percentage = ($targetWidth / $image->getWidth());
		else 
			$percentage = ($targetHeight / $image->getHeight());

		$width = round($image->getWidth() * $percentage);
		$height = round($image->getHeight() * $percentage);
		$image->resize($width,$height);
		$image->save($upathThumb);
		$Errs="<div class='message'>Image updated successfully</div>";
	
	}	
			
  } //END OF update

?>
<div class="block">
	<h2>UPLOAD POLLING STATION IMAGE</h2>
	<div id="WS"></div>

	<form action="upload_img.php?ac_no=<?php echo $ac_no; ?>&ps_no=<?php echo $ps_no; ?>" method="post" enctype="multipart/form-data" name="frmManu">
<span id="spErr"></span>
<div id="WS"></div>
<table class="adminform"> 

   <tr>
    <td align="right" valign="top">Image Path :</td>
    <td>
    	<input type="file" name="file" id="file" size="40"  value ='<?php echo @$file;?>' />
                   
    </td>
  </tr>

  <tr>
    <td colspan="2" align="center">
        <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" value='UPLOAD' name="B1" onclick="waitSign();">
      </td>
      </tr>
       
    </form>
    </td>
  </tr>
  <tr>
  <td colspan=2>
  <?php $img="../ps_photo/".$ac_no."_".$ps_no.".jpg";
  if(is_file($img))
     echo '<img width="200px" src="'.$img.'" />';
	 ?>
	 </td>
  </tr>
</table>
   </div>
   <script language=javascript>
<!--

document.getElementById("spErr").innerHTML= "<?php echo $Errs; ?>";
//-->
   </script>
</div>
   </body>
   </html>
