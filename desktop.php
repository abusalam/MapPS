<?php 

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include('mysql_conn.php');
$map_type=isset($_POST['map_type'])?$_POST['map_type']:"HYBRID";
$ac=isset($_POST['ac'])?$_POST['ac']:"";
$ps_no=isset($_POST['ps_no'])?$_POST['ps_no']:"";
$sector_no=isset($_POST['sector_no'])?$_POST['sector_no']:"";
$op_criteria=isset($_POST['op_criteria'])?$_POST['op_criteria']:"";
if(trim($ps_no)!="")
  { 
	if(!is_numeric($ps_no))
	{
		$msg="Invalid Ps No";
		$ps_no="";
		}
	}
		
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <title>GIS of Polling Station</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/skeleton.css">
	<link rel="stylesheet" href="css/layout.css">
   
	<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>
    <script type="text/javascript">

ladestart = new Date();

function ladezeit()
{
 current = new Date();
 dtime = current.getTime() - ladestart.getTime();
 loadtime = dtime/1000 +" seconds page load time(javascript).";
 document.getElementById("Ladezeit-Anzeige").innerHTML = loadtime;
}

</script>


	 
 <style>
	 .popup{};
	 .popup img{border:1px solid #efefef};
	 </style>

</head>
<body>
<div id="wrapper" class="container" >

  
	<div class="page_head">
	
	<table width="100%" class="" cellspacing="0">
<tr>
	<td><h2>GIS MAPPING OF Polling Station</h2></td>
	
</tr>	
</table>

</div>	
<div class="four columns">
		<div class="block-green">
		<?php echo @$msg;?>
		<form name="frm" method="post">
		<table>
		<tr>
			<td nowrap>Map Type:</td><td><select name="map_type">
			<option value="HYBRID"<?php if($map_type=="HYBRID") echo " selected";?>>HYBRID</option>
			<option value="ROADMAP"<?php if($map_type=="ROADMAP") echo " selected";?>>ROADMAP</option>
			<option value="SATELLITE"<?php if($map_type=="SATELLITE") echo " selected";?>>SATELLITE</option>
			<option value="TERRAIN"<?php if($map_type=="TERRAIN") echo " selected";?>>TERRAIN</option>
		
		</select> </td>
		</tr>
		<tr>
		<td>AC:</td>
		<td>
		<select name="ac" id="ac" style="width:130px">
		<option value="">All</option>
		<option value="237" <?php if($ac=="237") echo " selected";?>>237-Binpur2ST</option>
		<option value="221" <?php if($ac=="221") echo " selected";?>>221-Gopiballavpur</option>
		<option value="222" <?php if($ac=="222") echo " selected";?>>222-Jhargram</option>
		<option value="220" <?php if($ac=="220") echo " selected";?>>220-Nayagram</option>			
		
		<?php 
				//		$sql="SELECT ac_no,ac_name FROM ac   ORDER BY ac_name";
				//	$res=mysql_query($sql) or die("Unable to connect to Server, We are sorry for inconvienent caused".mysql_error());
				//		while($row=mysql_fetch_array($res))
				//		{
				//			echo "<option value='".$row['ac_no']."'";
				//			if($ac==$row['ac_no']) echo " selected";
				//			echo ">".$row['ac_no']."-".$row['ac_name']."</option>";
						
				//		}
						
						?>
			
		</select></td>
		</tr>
		<tr><td>PS NO :</td><td><input type="text" class="input-mini" name="ps_no" value="<?php echo $ps_no;?>" /></td></tr>
		<tr><td>SECTOR NO :</td><td><input type="text" class="input-mini" name="sector_no" value="<?php echo $sector_no;?>" /></td></tr>
		<tr>
			<td colspan="2">Additional Criteria :<br />
			
				<p><input type="radio" name="op_criteria" id="op_criteria" value="Vulnerable" <?php if($op_criteria=="Vulnerable") echo " checked";?> /><img src="images/vulnerable.png" align="" />Vulnerable<br /></p>
				<p><input type="radio" name="op_criteria" id="op_criteria" value="Critical" <?php if($op_criteria=="Critical") echo " checked";?> /><img src="images/critical.png"  />Critical<br /></p>
				<p><input type="radio" name="op_criteria" id="op_criteria" value="LWE" <?php if($op_criteria=="LWE") echo " checked";?>/><img src="images/lwe.png"  />LWE<br /></p>
				<p><input type="radio" name="op_criteria" id="op_criteria" value="MSZ" <?php if($op_criteria=="MSZ") echo " checked";?>/><img src="images/mobile_shadow.png"  />Mobile Shadow Zone<br /></p>
				<p><input type="radio" name="op_criteria" id="op_criteria" value="" <?php if($op_criteria=="") echo " checked";?>/>None<br /></p>
			</td>
		</tr>
		<tr><td colspan="2">
		<input type="submit" name="submit" class="btn" value="SHOW DETAILS" />
		</td>
		</tr>
		</table>
		</form>
		</div>
		<div class="block-green">
		
	<p> <img src="images/237.png" align="left">237-Binpur2ST</p><p> <img src="images/221.png" align="left">221-Gopiballavpur</p><p> <img src="images/222.png" align="left">222-Jhargram</p><p> <img src="images/220.png" align="left">220-Nayagram</p>		
	<?php 
	//$sql="SELECT ac_no,ac_name FROM ac   ORDER BY ac_name";
//	$res=mysql_query($sql) or die("Unable to connect to Server, We are sorry for inconvienent caused".mysql_error());
//		while($row=mysql_fetch_array($res))
	//			echo "<p> <image src='images/".$row['ac_no'].".png' align='left' />".$row['ac_no']."-".$row['ac_name']."</p>";
			
		
						?>
		</div>
		
		<div id="Ladezeit-Anzeige" ></div>
		<div id="Ladezeit-Anzeige-php" ></div>
	</div>
	<div class="thirteen columns">
	<div class="block">
        <div class="gmap">
            <div id='gmap_canvas' style="position:relative; width:100%; height:600px;"></div>
        </div>
        </div>


	
    <script type="text/javascript">
var map;
function initialize() {
//101 ps of jhargram 
   <?php 
 $sql="select AVG(lat) as avglat,AVG(lon) as avglon from  ps_details where 1=1";
						if($ps_no!="") $sql .=" and ps_no=".makeSafe($ps_no);
						if($ac!="") $sql .=" and ac_no=".makeSafe($ac);
						if(trim($sector_no)!="") $sql .=" and sector_no=".makeSafe($sector_no)."";
						if($op_criteria=="Vulnerable") $sql .=" and vulnerable_ps='Yes'";
						if($op_criteria=="Critical") $sql .=" and critical_ps='Yes'";
						if($op_criteria=="LWE") $sql .=" and lwe='Yes'";
						if($op_criteria=="MSZ") $sql .=" and mobile_shadow_zone='Yes'";
						$res=mysql_query($sql) or die("Unable to connect to Server, We are sorry for inconvienent caused".mysql_error());
if(mysql_affected_rows($link)>0)
	{
		$row     = mysql_fetch_array($res, MYSQL_ASSOC);
		$lat=$row['avglat'];
		$lon=$row['avglon'];
		}
		else
		{
		$lat = 22.639694;
						$lon = 86.737856;
		
		}
						?>
						
						var iCoordX = <?php echo $lat;?>;
						var iCoordY = <?php echo $lon;?>;
						var myLatlng = new google.maps.LatLng(iCoordX, iCoordY);

						var mapOptions = {
							zoom: 10,
							center: myLatlng,
							scrollwheel:true,
							panControl:true,
							mapTypeControl:true,
							scaleControl:true,
							streetViewControl:true,
							overviewMapControl:true,
							rotateControl:true,
							disableDefaultUI: true,
							mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
						};
						map = new google.maps.Map(document.getElementById('gmap_canvas'), mapOptions);
						var aMarkers = new Array();
						var aMarkerInfos = new Array();
						<?php 
						 $sql="select ps_no,ac_no,lat,lon,ps_name,sector_officer_name,sector_name,sector_officer_mobile,sector_no,bdo_office,bdo_no,pro_mobile_no,p1_mobile_no,
						vulnerable_ps,critical_ps,lwe,mobile_shadow_zone from  ps_details where 1=1";
						if($ps_no!="") $sql .=" and ps_no=".makeSafe($ps_no);
						if($ac!="") $sql .=" and ac_no=".makeSafe($ac);
						if(trim($sector_no)!="") $sql .=" and sector_no=".makeSafe($sector_no)."";
						if($op_criteria=="Vulnerable") $sql .=" and vulnerable_ps='Yes'";
						if($op_criteria=="Critical") $sql .=" and critical_ps='Yes'";
						if($op_criteria=="LWE") $sql .=" and lwe='Yes'";
						if($op_criteria=="MSZ") $sql .=" and mobile_shadow_zone='Yes'";
						
					$res=mysql_query($sql) or die("Unable to connect to Server, We are sorry for inconvienent caused".mysql_error());
					$i=1;
					$total=mysql_affected_rows($link);
					while($row=mysql_fetch_array($res))
					{
					if($row['vulnerable_ps']=="Yes") $vulnerable_ps="<span><img src='images/vulnerable.png' alt='VULNERABLE_PS'/></span>";
					if($row['critical_ps']=="Yes") $critical_ps="<span><img src='images/critical.png' alt='CRITICAL PS'/></span>";
					if($row['lwe']=="Yes") $lwe="<span><img src='images/lwe.png' alt='LWE'/></span>";
					if($row['mobile_shadow_zone']=="Yes") $mobile_shadow_zone="<span><img src='images/mobile_shadow.png' alt='MOBILE SHADOW ZONE'/></span>";
					?>
						//marker infos
						aMarkerInfos[<?php echo $i;?>] = new google.maps.InfoWindow({content: "<div class='popup'><?php echo "<table><tr><td colspan='2'>".$row['ps_no']."-".$row['ps_name']."</td></tr><tr><td> BDO OFFICE:</td><td>".$row['bdo_office']."</td></tr><tr><td> BDO NO:</td><td><a href='tel:".$row['bdo_no']."'>".$row['bdo_no']."</a></td></tr><tr><td>  SECTOR :</td><td>".$row['sector_no']."-".$row['sector_name']."</td></tr><tr><td>SECTOR OFFICER :</td><td>".$row['sector_officer_name']."</td></tr><tr><td>MOBILE NO :</td><td><a href='tel:".$row['sector_officer_mobile']."'>".$row['sector_officer_mobile']."</a></td></tr><tr><td>PRO MOBILE NO :</td><td><a href='tel:".$row['pro_mobile_no']."'>".$row['pro_mobile_no']."</a></td></tr><tr><td>P1 MOBILE NO:</td><td><a href='tel:".$row['p1_mobile_no']."'>".$row['p1_mobile_no']."</a></td></tr><tr><td><tr><td colspan='2'>".@$vulnerable_ps."".@$critical_ps."".@$lwe."".@$mobile_shadow_zone."</td></tr></table>";?></div>"});
						aMarkers[<?php echo $i;?>] = new google.maps.Marker({position: new google.maps.LatLng(<?php echo $row['lat'];?>, <?php echo $row['lon'];?>), map: map,icon:new google.maps.MarkerImage('images/<?php echo $row['ac_no'];?>.png',new google.maps.Size(24, 24),new google.maps.Point(0,0),new google.maps.Point(0, 24)),shadow:new google.maps.MarkerImage('images/shadow-mapgreen24.png',new google.maps.Size(37, 24),new google.maps.Point(0,0),new google.maps.Point(-3, 24)),animation: google.maps.Animation.DROP,title:"<?php echo $row['ps_no']."-".$row['ps_name'];?>"});
								
						google.maps.event.addListener(aMarkers[<?php echo $i;?>], 'click', function(e) {  aMarkerInfos[<?php echo $i;?>].open(map,aMarkers[<?php echo $i;?>]);if(aMarkers[<?php echo $i;?>].getAnimation()==null){  aMarkers[<?php echo $i;?>].setAnimation(google.maps.Animation.BOUNCE);  } });
						google.maps.event.addListener(aMarkerInfos[<?php echo $i;?>], 'closeclick', function() {  if(aMarkers[<?php echo $i;?>].getAnimation()!=null){  aMarkers[<?php echo $i;?>].setAnimation(null); } }); 
						
						<?php 
						$vulnerable_ps="";
						$critical_ps="";
						$lwe="";
						$mobile_shadow_zone="";
						$i=$i+1;
						}
						?>
	//--------------------------------------------------------		
			
	}
	
		google.maps.event.addDomListener(window, 'load', initialize);
		

				    </script>
					<?php echo "TOTAL:".$total;?>
					
			</div>		
</div><!--wrapper-->
<script>ladezeit();</script>
</body>
</html>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo "<script>document.getElementById('Ladezeit-Anzeige-php').innerHTML = 'SERVER :Page generated in ".$total_time." seconds.'</script>";

?>