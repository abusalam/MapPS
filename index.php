<?php
header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html lang="en" >
  <head>
    <title>GIS of Polling Station</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/component.css">
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>
    <link rel="stylesheet" href="css/lightbox.css" media="screen"/>
    <script src="js/lightbox-2.6.min.js"></script>
    <script>
      var ac = $('select#ac').val();
      var sector_no = $('select#sector_no').val();
      var MAP_TYPE = $('select#map_type').val();

      function getData() {
        $('#showLeft').click();
        $('#loading').show();
        $.ajax({
          url: "Controllers/ps_list_all.php?stype=ps&pc=" + $('select#pc').val() + "&ac=" + $('select#ac').val() + "&sector_no=" + $('select#sector_no').val() + "&op_criteria=" + $('input[name=op_criteria]:checked').val() + "&ps_no=" + $('#ps_no').val(),
          type: "GET",
          async: false,
          dataType: "json",
          _accept: "application/json",
          contentType: "application/json;charset=utf-8",
          data: JSON.stringify(),
          success: function(db) {
            //console.log(db.length);
            markers = db;
          },
          error: function() {
            console.log("An Error Occurred");
          }

        });

        $.ajax({
          url: "Controllers/ps_list_all.php?stype=avg&pc=" + $('select#pc').val() + "&ac=" + $('select#ac').val() + "&sector_no=" + $('select#sector_no').val() + "&op_criteria=" + $('input[name=op_criteria]:checked').val() + "&ps_no=" + $('#ps_no').val(),
          type: "GET",
          async: false,
          dataType: "json",
          _accept: "application/json",
          contentType: "application/json;charset=utf-8",
          data: JSON.stringify(),
          success: function(PositionData) {
            for (i = 0; i < PositionData.length; i++)
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

        icon219 = new google.maps.MarkerImage('images/233.png');
        icon220 = new google.maps.MarkerImage('images/220.png');
        icon221 = new google.maps.MarkerImage('images/221.png');
        icon222 = new google.maps.MarkerImage('images/222.png');
        icon223 = new google.maps.MarkerImage('images/237.png');
        icon224 = new google.maps.MarkerImage('images/222.png');
        icon225 = new google.maps.MarkerImage('images/220.png');
        icon226 = new google.maps.MarkerImage('images/222.png');
        icon227 = new google.maps.MarkerImage('images/237.png');
        icon228 = new google.maps.MarkerImage('images/234.png');
        icon229 = new google.maps.MarkerImage('images/220.png');
        icon230 = new google.maps.MarkerImage('images/222.png');
        icon231 = new google.maps.MarkerImage('images/234.png');
        icon232 = new google.maps.MarkerImage('images/237.png');
        icon233 = new google.maps.MarkerImage('images/233.png');
        icon234 = new google.maps.MarkerImage('images/234.png');
        icon235 = new google.maps.MarkerImage('images/233.png');
        icon236 = new google.maps.MarkerImage('images/237.png');
        icon237 = new google.maps.MarkerImage('images/237.png');

        customIcons = [];
        //jhargram
        customIcons["219"] = icon219;
        customIcons["220"] = icon220;
        customIcons["221"] = icon221;
        customIcons["222"] = icon222;
        customIcons["223"] = icon223;
        customIcons["224"] = icon224;
        customIcons["225"] = icon225;
        customIcons["226"] = icon226;
        customIcons["227"] = icon227;
        customIcons["228"] = icon228;
        customIcons["229"] = icon229;
        customIcons["230"] = icon230;
        customIcons["231"] = icon231;
        customIcons["232"] = icon232;
        customIcons["233"] = icon233;
        customIcons["234"] = icon234;
        customIcons["235"] = icon235;
        customIcons["236"] = icon236;
        customIcons["237"] = icon237;
        initialize();
        $('#loading').hide();
      }

      function initialize() {
        var map_type = $('select#map_type').val();

        var mapOptions = {
          center: new google.maps.LatLng($('#latPosition').val(), $('#lonPosition').val()),
          zoom: 9,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("gmap_canvas"), mapOptions);

        if (map_type == "HYBRID")
          map.setMapTypeId(google.maps.MapTypeId.HYBRID);
        if (map_type == "SATELLITE")
          map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
        if (map_type == "TERRAIN")
          map.setMapTypeId(google.maps.MapTypeId.TERRAIN);

        infowindow = new google.maps.InfoWindow({content: "holding..."});
        for (i = 0; i < markers.length; i++) {

          var node = markers[i];
          var latitude = node['lat'];
          var longitude = node['lon'];
          var lat = parseFloat(latitude);
          var lng = parseFloat(longitude);
          var ps_name = node['ps_name'];
          var ps_no = node['ps_no'];
          var p1_mobile_no = node['p1_mobile_no'];
          var pro_mobile_no = node['pro_mobile_no'];
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
          var vst_name = node['vst_name'];
          var vst_mobile = node['vst_mobile'];
          var sst_name = node['sst_name'];
          var sst_mobile = node['sst_mobile'];
          var fs_name = node['fs_name'];
          var fs_mobile = node['fs_mobile'];
          var lweMark = (lwe == "Yes") ? '<img alt="LWE" class="pad" src="images/lwe.png" width="24px">' : '';
          var critical_ps_mark = (critical_ps == "Yes") ? '<img class="pad" alt="Critical" src="images/critical.png" width="24px">' : '';
          var vulnerable_mark = (vulnerable_ps == "Yes") ? '<img class="pad" alt="Vulnerable" src="images/vulnerable.png" width="24px">' : '';
          var mobile_shadow_zone_mark = (mobile_shadow_zone == "Yes") ? '<img class="pad" alt="mobile_shadow_zone" src="images/mobile_shadow.png" width="24px">' : '';
          var mobile_shadow_zone = node['mobile_shadow_zone'];
          var point = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
          var marker = new google.maps.Marker({
            position: point,
            map: map,
            title: (ac_no + "/" + ps_no + '\n' + ps_name),
            html: '<div style="height:300px"> <table><tbody><tr><td colspan="2">'
                    + ac_no + '/' + ps_no + '-' + ps_name + '</td></tr><tr><td> BDO OFFICE:</td><td>'
                    + bdo_office + '</td></tr><tr><td> BDO NO:</td><td><a class="PhoneNo">'
                    + bdo_no + '</a></td></tr><tr><td>  SECTOR :</td><td>' + sector_no + '-' + sector_name
                    + '</td></tr><tr><td>SECTOR OFFICER :</td><td>' + sector_officer_name
                    + '</td></tr><tr><td>MOBILE NO :</td><td><a href="tel:' + sector_officer_mobile + '">' + sector_officer_mobile
                    + '</a></td></tr><tr><td> VST:</td><td>' + vst_name
                    + ' <a href="tel:' + vst_mobile + '">' + vst_mobile
                    + '</a></td></tr><tr><td> SST:</td><td>' + sst_name
                    + ' <a href="tel:' + sst_mobile + '">' + sst_mobile
                    + '</a></td></tr><tr><td> FS:</td><td>' + fs_name
                    + ' <a href="tel:' + fs_mobile + '">' + fs_mobile
                    + '</a></td></tr><tr><td>PRO :</td><td><a href="tel:' + pro_mobile_no + '">' + pro_mobile_no + '</a></td></tr><tr><td>P1:</td><td><a href="tel:' + p1_mobile_no + '">' + p1_mobile_no + '</a></td></tr><tr><td></td></tr><tr><td colspan="2"><span>' + lweMark
                    + '</span><span>' + mobile_shadow_zone_mark
                    + '</span><span>' + critical_ps_mark
                    + '</span><span>' + vulnerable_mark + '</span></td></tr>'
                    + '<tr><td colspan="4"><a data-lightbox="example-set" href="ps_photo/' + ac_no + '_' + ps_no + '.jpg"><img width="50px" height="50px" src="ps_photo/' + ac_no + '_' + ps_no + '_T.jpg"></a><tr><td></tbody></table></div>',
            icon: customIcons[ac_no]

          });
          //gmarkers.push(marker);
          marker.setMap(map);
          //var div = document.createElement("div");
          //div.innerHTML=(i+1) + '. <a href="javascript:myclick(' + (gmarkers.length-1) + ')">' + name + '<\/a><br>';
          //document.getElementById('sidebar').appendChild(div);

          google.maps.event.addListener(marker, 'click', function() {
            // where I have added .html to the marker object.
            infowindow.setContent(this.html);
            infowindow.open(map, this);

            $('.PhoneNo').click(function(event) {
              event.preventDefault();
              $.ajax({
                url: 'http://' + $('#MobileIP').val() + ':8080',
                dataType: 'jsonp',
                data: {
                  'cellNo': $(this).text()
                }
              }).done(function(data) {
                try {
                  console.log(data);
                }
                catch (e) {
                }
              }).fail(function(msg) {
                $('#Msg').html(msg);
              });
            });
          });
          ac_no = "";
        }
      }

      function myclick(i) {
        google.maps.event.trigger(gmarkers[i], "click");
      }

      function loadlist(selobj, url, nameattr, valueattr) {
        $(selobj).empty();
        $.getJSON(url, {}, function(data)
        {
          $(selobj).append($('<option></option>').val('').html('--Please Select--'));
          $.each(data, function(i, obj)
          {

            $(selobj).append($('<option></option>').val(obj[valueattr]).html(obj[valueattr] + " " + obj[nameattr]));
          });
        });
      }

      function select_sec() {

        var ac = $('select#ac').val();
        if (ac != "")
          loadlist($('select#sector_no').get(0), 'Controllers/sector_list.php?ac=' + ac + '', 'sector_name', 'sector_no');
        else
          $('select#sector_no').empty();
      }

      function loadlistPC(selobj, url, nameattr, valueattr) {
        $(selobj).empty();
        $.getJSON(url, {}, function(data)
        {
          $('select#ac').append($('<option></option>').val('').html('--Select All--'));
          $.each(data, function(i, obj)
          {

            $(selobj).append($('<option></option>').val(obj[valueattr]).html(obj[valueattr] + " " + obj[nameattr]));
          });
        });
      }

      function select_PC() {

        var pc = $('select#pc').val();
        if (pc != "")
          loadlistPC($('select#ac').get(0), 'Controllers/ac_list.php?pc=' + pc + '', 'ac_name', 'ac_no');
        else
        {
          $('select#ac').empty();
          $('select#ac').append($('<option></option>').val('').html('--Select All--'));
        }
      }

      var viewStatus = 1;

      function show_hide() {
        if (viewStatus == 0)
        {
          viewStatus = 1;
          document.getElementById("AddlC").style.height = "210px";
        }
        else
        {
          viewStatus = 0;
          document.getElementById("AddlC").style.height = "30px";
        }
      }
    </script>
    <style>
      .popup{};
      .popup img{border:1px solid #efefef};
    </style>
  </head>
  <body class="cbp-spmenu-push">
    <div id="wrapper" class="container" >
      <input type="hidden" id="latPosition" />
      <input type="hidden" id="lonPosition" />
      <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
        <h3>Menu</h3>
        <ul>
          <li>Map Type:</li>
          <li>
            <select name="map_type" id="map_type" style="width:130px">
              <option value="HYBRID" >HYBRID</option>
              <option value="ROADMAP">ROADMAP</option>
              <option value="SATELLITE">SATELLITE</option>
              <option value="TERRAIN">TERRAIN</option>
            </select>
          </li>
          <li>PC:</li>
          <li>
            <select name="pc" id="pc" style="width:90%"  onchange="select_PC();">
              <option value="" selected>--Please select--</option>
              <option value="33" >33-Jhargram</option>
              <option value="34" >34-Medinipur</option>
              <option value="32" >32-Ghatal</option>
            </select>
          </li>
          <li>AC:</li>
          <li>
            <select name="ac" id="ac" style="width:90%"  onchange="select_sec();">
              <option value="" >All</option>
            </select>
          </li>
          <li>SECTOR NO/NAME :</li>
          <li>
            <select name="sector_no" id="sector_no" style="width:90%" ></select>
          </li>
          <li style="height: 20px;font-size: 16px;font-weight: bold;margin-top: 10px;">Additional Filters:</li>
          <hr>
          <li>
            PS NO :
            <input type="text" class="input-mini" name="ps_no" id="ps_no"  />
            <p>
              <input type="radio" name="op_criteria" id="op_criteria" value="Vulnerable"  />
              <img src="images/vulnerable.png" width="20px" align="" />Vulnerable<br />
            </p>
            <p>
              <input type="radio" name="op_criteria" id="op_criteria" value="Critical" />
              <img src="images/critical.png"  width="20px" />Critical<br />
            </p>
            <p>
              <input type="radio" name="op_criteria" id="op_criteria" value="LWE" />
              <img src="images/lwe.png"  width="20px" />LWE<br /></p>
            <p>
              <input type="radio" name="op_criteria" id="op_criteria" value="MSZ" />
              <img src="images/mobile_shadow.png"  width="20px" />Mobile Shadow Zone<br />
            </p>
            <p>
              <input type="radio" name="op_criteria" id="op_criteria" value="" />None<br />
            </p>
          </li>
          <li><input type="button" name="btn" name="btn" class="btn" value="SHOW DETAILS" onclick="getData();"/></li>
          <li><a href="poll_monitoring.php" title="Poll Monitoring"> Poll Monitoring</a></li>
          <label for="MobileIP">Mobile IP: </label><input type="text" style="width: 105px;" value="10.173.168.133" id="MobileIP" />
        </ul>
      </nav>
      <div class="page_head" id="pHead">
        <table width="100%" class="" cellspacing="0">
          <tr>
            <td align="left">
              <div>
                <h2>
                  <a class="menu" id="showLeft" href="#nav">GIS MAPPING OF Polling Station</a>
                </h2>
              </div>
            </td>
            <td><span id="loading" style="display:none">Loading...</span></td>
          </tr>
        </table>
      </div>
      <div class="gmap">
        <div id='gmap_canvas' style="position:relative; width:100%;">
        </div>
      </div>
      <script src="js/classie.js"></script>
      <script>
            var menuLeft = document.getElementById('cbp-spmenu-s1')
            showLeft = document.getElementById('showLeft'),
                    body = document.body;

            showLeft.onclick = function() {
              classie.toggle(this, 'active');
              classie.toggle(menuLeft, 'cbp-spmenu-open');

            };

            var sHeight = screen.height;
            var head_height = $('#pHead').height();
            $('#gmap_canvas').height($(document).height() - head_height);
            show_hide();
      </script>
      <div style="position:fixed;background:#fff;opacity:.7;bottom:0px;left:0px;color:#000">
        <span>[<img src="images/237.png">223, 227, 232, 236, 237]</span>
        <span>[<img src="images/234.png">228, 231, 234]</span>
        <span>[<img src="images/233.png">219, 233, 235]</span>
        <span>[<img src="images/222.png">222, 224, 226, 230]</span>
        <span>[<img src="images/221.png">221]</span>
        <span>[<img src="images/220.png">220, 225, 229]</span>
        <span>[<img src="images/Maps-icon.png"><a href="Android/GoogleMapsV2.apk">PS Maps Android App]</a></span>
        <span>[<img src="images/phone-icon.png"><a href="Android/CallBridge.apk">Phone Calling Android App]</a></span>
      </div>
    </div>
  </body>
</html>
