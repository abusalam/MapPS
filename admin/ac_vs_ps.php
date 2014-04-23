<?php 
include('mysql_conn.php');
		$str="";
		$sql="SELECT ac_no, count( ps_no ) AS tps FROM `ps_details` GROUP BY ac_no ";
		$res=mysql_query($sql) or die("Unable to connect to Server, We are sorry for inconvienent caused".mysql_error());
		while($row=mysql_fetch_array($res))
		{
		$str .= "['".$row['ac_no']."',".$row['tps']."],";
         }
		 $c_values= rtrim($str,",");
		 
		
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <title>GIS of Polling Station</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/skeleton.css">
	<link rel="stylesheet" href="css/layout.css">
   
	 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([

		 
		  ['Task', 'Hours per Day'],
         // ['Work',     11],    ['Eat',      2],     ['Commute',  2],        ['Watch TV', 2],          ['Sleep',    7]
<?php echo $c_values;?>
		
        ]);

        var options = {
          title: 'AC WISE POLLING STATIONS',
		   is3D: true,

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['AC', 'NO OF PS' ],
          <?php echo $c_values;?>
        ]);

        var options = {
          title: '',
          vAxis: {title: 'AC',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

</head>
<body>
<div id="wrapper" class="container" >

  
	<div class="page_head">
	
	<table width="100%" class="" cellspacing="0">
	<tr>
		<td><h2>REPORT(AC WISE POLLING STATIONS</h2></td>
		
	</tr>	
	</table>

</div>	

		<div class="block-green clearfix">
		<div class="eight columns"> <div id="piechart" style="width: 100%; "></div></div>
		 <div class="eight columns"><div id="chart_div" style="width: 100%; "></div></div>



			</div>		
</div><!--wrapper-->
</body>
</html>