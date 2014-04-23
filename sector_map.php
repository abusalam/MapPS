<!DOCTYPE html>
<html lang="en" >
<head>
    <title>GIS of Polling Station</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/skeleton.css">
	<link rel="stylesheet" href="css/layout.css">
	<link rel="stylesheet" href="css/component.css">
    <script src="js/jquery-1.7.2.min.js"></script>
  <script src="js/modernizr.custom.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>

 <script>
 
var ac=$('select#ac').val();
 var sector_no=$('select#sector_no').val();
 var MAP_TYPE=$('select#map_type').val();
 
 function getData() {
  $('#showLeft').click();
    $.ajax({
       url: "Controllers/ps_list.php?ac="+$('select#ac').val()+"&sector_no="+$('select#sector_no').val(),
        type: "GET",
        async: false,
        dataType: "json",
        _accept: "application/json",
        contentType: "application/json;charset=utf-8",
        data: JSON.stringify(),
        success: function(db){
            //console.log(db.length);
            markers = db;
        },
        error: function() {
            console.log("An Error Occurred");
        }

    }); 
	
	$.ajax({
       url: "Controllers/Position.php?ac="+$('select#ac').val()+"&sector_no="+$('select#sector_no').val(),
        type: "GET",
        async: false,
        dataType: "json",
        _accept: "application/json",
        contentType: "application/json;charset=utf-8",
        data: JSON.stringify(),
        success: function(PositionData){
           for (i=0; i<PositionData.length; i++) 
			{
				var nodePosition = PositionData[i];
				$('#latPosition').val(nodePosition['avglat']);
				$('#lonPosition').val(nodePosition['avglon']);
				
     // alert(lonPosition);
			}
           // markers = PositionData;
        },
        error: function() {
            console.log("An Error Occurred");
        }

    });
 
	iconBlue = new google.maps.MarkerImage('images/237.png');
    iconBlue.image = 'http://labs.google.com/ridefinder/images/mm_20_blue.png';
    iconBlue.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';


    iconRed = new google.maps.MarkerImage('images/221.png');
    iconRed.image = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
    iconRed.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';


    iconGreen = new google.maps.MarkerImage('images/220.png');
    iconGreen.image = 'http://labs.google.com/ridefinder/images/mm_20_green.png';
    iconGreen.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';


    iconYellow = new google.maps.MarkerImage('images/222.png');
    iconYellow.image = 'http://labs.google.com/ridefinder/images/mm_20_yellow.png';
    iconYellow.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';


 

    customIcons = [];
    customIcons["237"] = iconBlue;
    customIcons["221"] = iconRed;
    customIcons["220"] = iconGreen;
    customIcons["222"] = iconYellow;
   

    initialize();
}

function initialize() {
var map_type=$('select#map_type').val();

    var mapOptions = {
        center: new google.maps.LatLng($('#latPosition').val(),$('#lonPosition').val()),
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	
	  var map = new google.maps.Map(document.getElementById("gmap_canvas"),  mapOptions);
	  
	  if(map_type=="HYBRID") map.setMapTypeId(google.maps.MapTypeId.HYBRID);
	  if(map_type=="SATELLITE") map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
	  if(map_type=="TERRAIN") map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
	  
    infowindow = new google.maps.InfoWindow({content: "holding..."});
    for (i=0; i<markers.length; i++) {
	
        var node = markers[i];
        var latitude = node['lat'];
        var longitude = node['lon'];
        var lat = parseFloat(latitude);
        var lng = parseFloat(longitude);
        var ps_name = node['ps_name'];
        var ps_no = node['ps_no'];
        var ac_no = node['ac_no'];
        var bdo_office = node['bdo_office'];
        var bdo_no = node['bdo_no'];
        var sector_no = node['sector_no'];
        var sector_name = node['sector_name'];
        var sector_officer_name = node['sector_officer_name'];
        var sector_officer_mobile = node['sector_officer_mobile'];
		
        var vulnerable_ps = node['vulnerable_ps'];
        var critical_ps = node['critical_ps'];
        var lwe = node['lwe'];
        var mobile_shadow_zone = node['mobile_shadow_zone'];
		
		var lweMark=(lwe=="Yes")?'<img alt="LWE" src="images/lwe.png">':'';
		var critical_ps_mark=(critical_ps=="Yes")?'<img alt="Critical" src="images/critical.png">':'';
		var vulnerable_mark=(vulnerable_ps=="Yes")?'<img alt="Vulnerable" src="images/vulnerable.png">':'';
		var mobile_shadow_zone_mark=(mobile_shadow_zone=="Yes")?'<img alt="mobile_shadow_zone" src="images/mobile_shadow.png">':'';
			
		
        var mobile_shadow_zone = node['mobile_shadow_zone'];
		
		
        var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));

        var marker = new google.maps.Marker({
            position: point,
            map: map,
            title:(ps_no + '\n' + ps_name),
            html:' <table><tbody><tr><td colspan="2">'+ps_no+'-'+ps_name+'</td></tr><tr><td> BDO OFFICE:</td><td>'+bdo_office+'</td></tr><tr><td> BDO NO:</td><td><a href="tel:'+bdo_no+'">'+bdo_no+'</a></td></tr><tr><td>  SECTOR :</td><td>'+sector_no+'-'+sector_name+'</td></tr><tr><td>SECTOR OFFICER :</td><td>'+sector_officer_name+'</td></tr><tr><td>MOBILE NO :</td><td><a href="tel:'+sector_officer_mobile+'">'+sector_officer_mobile+'</a></td></tr><tr><td>PRO MOBILE NO :</td><td><a href="tel:0">0</a></td></tr><tr><td>P1 MOBILE NO:</td><td><a href="tel:0">0</a></td></tr><tr><td></td></tr><tr><td colspan="2"><span>'+lweMark+'</span><span>'+mobile_shadow_zone_mark+'</span><span>'+critical_ps_mark+'</span><span>'+vulnerable_mark+'</span></td></tr></tbody></table>',
            icon: customIcons[ac_no]
        });
		
        //gmarkers.push(marker);
		marker.setMap(map);
        //var div = document.createElement("div");
        //div.innerHTML=(i+1) + '. <a href="javascript:myclick(' + (gmarkers.length-1) + ')">' + name + '<\/a><br>';
        //document.getElementById('sidebar').appendChild(div);

        google.maps.event.addListener(marker, 'click', function () {
            // where I have added .html to the marker object.
            infowindow.setContent(this.html);
            infowindow.open(map, this);
        });

    }
}

function myclick(i) {
    google.maps.event.trigger(gmarkers[i], "click");
}
 </script>
 <script>
 function loadlist(selobj,url,nameattr,valueattr)
{
    $(selobj).empty();
    $.getJSON(url,{},function(data)
    {$(selobj).append($('<option></option>').val('0').html('--Please Select--'));
        $.each(data, function(i,obj)
        {
             
             $(selobj).append($('<option></option>').val(obj[valueattr]).html(obj[valueattr]+" "+obj[nameattr]));
        });
    });
}

function select_sec()
   {
  
    var ac=$('select#ac').val();
	
    loadlist($('select#sector_no').get(0),'Controllers/sector_list.php?ac='+ac+'','sector_name','sector_no');
   }

	</script>
	



	 
 <style>
	 .popup{};
	 .popup img{border:1px solid #efefef};
	 </style>

</head>
<body class="cbp-spmenu-push">
<input type="hidden" id="latPosition" />	
<input type="hidden" id="lonPosition" />	
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<h3>Menu</h3>
			<ul>
	<li>Map Type:</li>
	<li><select name="map_type" id="map_type" style="width:150px">
			<option value="HYBRID" >HYBRID</option>
			<option value="ROADMAP">ROADMAP</option>
			<option value="SATELLITE">SATELLITE</option>
			<option value="TERRAIN">TERRAIN</option>
		
		</select> 
		</li>
		<li>AC:</li>
		<li><select name="ac" id="ac" style="width:150px"  onchange="select_sec();">
		<option value="" >All</option>
		<option value="237">237-Binpur2ST</option>
		<option value="221">221-Gopiballavpur</option>
		<option value="222">222-Jhargram</option>
		<option value="220">220-Nayagram</option>
		</select></li>
		<li>SECTOR NO :</li>
		<li><select name="sector_no" id="sector_no" style="width:150px" ></select> </li>
		<li><input style="width:150px" type="button" name="btn" name="btn" class="btn" value="SHOW DETAILS" onclick="getData();"/></li>
	
	
	</ul>
		</nav>
		
		
<div id="wrapper" class="container" >

  
	<div class="page_head">
			
			<table width="100%" class="" cellspacing="0">
		<tr>
			
			<td><h2>GIS MAPPING OF Polling Station</h2></td><td><h1><a class="open" id="showLeft" href="#nav">Menu</a></h1></td>
			
		</tr>	
		</table>

</div>	


	
	<div class="block">
        <div class="gmap">
		
            <div id='gmap_canvas' style="position:relative; width:100%; height:500px;"></div>
        </div>
        </div>
		<script src="js/classie.js"></script>
					<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' )
				showLeft = document.getElementById( 'showLeft' ),
				body = document.body;

			showLeft.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				
			};
			

			
		</script>
			
	<div style="position:fixed;bottom:0px;left:0px;background:#fff"><span> <img src="images/237.png">237-Binpur2ST</span><span> <img src="images/221.png" >221-Gopiballavpur</span><br /><span> <img src="images/222.png" >222-Jhargram</span><span> <img src="images/220.png">220-Nayagram</span>	</div>
</div><!--wrapper-->
</body>
</html>
