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
      //var sector_no=$('select#sector_no').val();
      //var MAP_TYPE=$('select#map_type').val();

      function getData() {
        $('#showLeft').click();
        $('#loading').show();
        $.ajax({
          url: "Controllers/poll_stat.php?stype=ps&pc=" + $('select#pc').val() + "&ac=" + $('select#ac').val() + "&sector_no=&op_criteria=&ps_no=",
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
          url: "Controllers/poll_stat.php?stype=avg&pc=" + $('select#pc').val() + "&ac=" + $('select#ac').val() + "&sector_no=&op_criteria=&ps_no=",
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

        iconInit = new google.maps.MarkerImage('images/init.png');
        iconInit.image = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
        iconInit.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';

        iconPS = new google.maps.MarkerImage('images/PS.png');
        iconPS.image = 'http://labs.google.com/ridefinder/images/mm_20_green.png';
        iconPS.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';

        iconPE = new google.maps.MarkerImage('images/PE.png');
        iconPE.image = 'http://labs.google.com/ridefinder/images/mm_20_yellow.png';
        iconPE.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';

        customIcons = [];
        customIcons["init"] = iconInit;
        customIcons["PS"] = iconPS;
        customIcons["PE"] = iconPE;

        initialize();
        $('#loading').hide();
      }

      function initialize() {
        //var map_type=$('select#map_type').val();

        var mapOptions = {
          center: new google.maps.LatLng($('#latPosition').val(), $('#lonPosition').val()),
          zoom: 9,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("gmap_canvas"), mapOptions);

        //if(map_type=="HYBRID") map.setMapTypeId(google.maps.MapTypeId.HYBRID);
        //if(map_type=="SATELLITE") map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
        //if(map_type=="TERRAIN") map.setMapTypeId(google.maps.MapTypeId.TERRAIN);

        infowindow = new google.maps.InfoWindow({content: "holding..."});
        for (i = 0; i < markers.length; i++) {

          var node = markers[i];
          var status_icon;
          var ps_id = node['ps_id'];
          var latitude = node['lat'];
          var longitude = node['lon'];
          var lat = parseFloat(latitude);
          var lng = parseFloat(longitude);
          var ps_name = node['ps_name'];
          var ps_no = node['ps_no'];
          var p1_mobile_no = node['p1_mobile_no'];
          var pro_mobile_no = node['pro_mobile_no'];
          var poll_stat = node['poll_stat'];
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
          //N=not started
          //S=Poll Started
          //E=Poll ended
          if (poll_stat == "N")
            status_icon = "init";
          if (poll_stat == "S")
            status_icon = "PS";
          if (poll_stat == "E")
            status_icon = "PE";

          var point = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));

          var marker = new google.maps.Marker({
            id: ps_id,
            tag: ps_id,
            position: point,
            map: map,
            title: (ps_no + '\n' + ps_name),
            html: '<div style="height:300px"> <table><tbody><tr><td colspan="2">'
                    + ps_no + '-' + ps_name + '</td></tr><tr><td> BDO OFFICE:</td><td>'
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
            icon: customIcons[status_icon]

          });

          // gmarkers.push(marker);
          marker.setMap(map);
          // var div = document.createElement("div");
          // div.innerHTML=(i+1) + '. <a href="javascript:myclick(' + (gmarkers.length-1) + ')">' + name + '<\/a><br>';
          // document.getElementById('sidebar').appendChild(div);

          google.maps.event.addListener(marker, 'click', function() {
            // where I have added .html to the marker object.
            //maxWidth: 200
            infowindow.setContent(this.html);

            infowindow.open(map, this);

            $('.PhoneNo').click(function(event) {
              event.preventDefault();
              $.ajax({
                type: 'POST',
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

      function loadlistPC(selobj, url, nameattr, valueattr) {
        $(selobj).empty();
        $.getJSON(url, {}, function(data)
        {
          $(selobj).append($('<option></option>').val('').html('--Select All--'));
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
          $('select#ac').empty();
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
      <div class="page_head" id="pHead">
        <span id="loading" style="display:none;">Loading...</span>
        <table width="100%" class="" cellspacing="0">
          <tr>
            <td align="left">
              <div>
                <h2>POLL MONITORING (PASCHIM MEDINIPUR)</h2>
              </div>
            </td>
          </tr>
          <tr>
            <td style="padding-bottom:5px;">
              Mobile IP: <input type="text" value="10.173.168.133" id="MobileIP" style="width:105px;"/>
              PC:		<select name="pc" id="pc" style="width:120px" onchange="select_PC();">
                <option value="" selected>All</option>
                <option value="33" >33-Jhargram</option>
                <option value="34" >34-Medinipur</option>
                <option value="32" >32-Ghatal</option>
              </select>
              AC:
              <select name="ac" id="ac" style="width:180px">
                <option value="" >All</option>
              </select>
              <input type="button" name="btn" name="btn" class="btn" value="SHOW STATUS" onclick="getData();"/>
            </td>
          </tr>
        </table>
      </div>
      <div class="gmap">
        <div id='gmap_canvas' style="position:relative; width:100%;"></div>
      </div>
      <div style="position:fixed;background:#fff;opacity:.7;bottom:0px;left:0px;color:#000">
        <span>[<img src="images/init.png">Poll Not Started]</span>
        <span>[<img src="images/PS.png">Poll Started]</span>
        <span>[<img src="images/PE.png">Poll Closed]</span>
        <span>[<img src="images/Maps-icon.png"><a href="Android/GoogleMapsV2.apk">PS Maps Android App]</a></span>
        <span>[<img src="images/phone-icon.png"><a href="Android/CallBridge.apk">Phone Calling Android App]</a></span>
      </div>
    </div>
    <script>
      var sHeight = screen.height;
      var head_height = $('#pHead').height();
      $('#gmap_canvas').height($(document).height() - head_height);
    </script>
  </body>
</html>
