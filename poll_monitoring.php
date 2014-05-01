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
                var colors = [
                    'FFA07A', 'FF69B4', 'FFA07A', 'FFA500', 'E6E6FA',
                    'FFFACD', 'FFDAB9', 'FF00FF', 'ADFF2F', '20B2AA',
                    '00FFFF', 'E0FFFF', '7FFFD4', 'B0E0E6', '87CEFA',
                    'FFF8DC', 'DAA520', 'F0FFF0', 'FAEBD7', 'F5F5DC',
                    'F0FFF0', 'B8860B', '808000', '4682B4',
                    '7FFF00', 'FFA500', 'FF7F50', '008B8B',
                    '9400D3', '7B68EE', '1E90FF', '778899',
                    'FFD700', '40E0D0', '6B8E23', '8B4513',
                    'FFA07A', '6A5ACD', '2E8B57', '008B8B',
                    '2F4F4F'];
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
                    var ColorAC = colors[parseInt(ac_no) - 219];

                    var gMarker = {
                        path: 'M50,0C22.382,0,0,21.966,0,49.054C0,76.151,50,165,50,165s50-88.849,50-115.946C100,21.966,77.605,0,50,0z',
                        anchor: '50,165',
                        fillColor: '#' + ColorAC,
                        fillOpacity: 0.5,
                        scale: 1,
                        strokeColor: '#000000',
                        strokeOpacity: 1,
                        strokeWeight: 1
                    };

                    var marker = new google.maps.Marker({
                        id: ps_id,
                        tag: ps_id,
                        position: point,
                        map: map,
                        animation: google.maps.Animation.DROP,
                        title: ('[AC:' + ac_no + ' - PS:' + ps_no + '] ' + ps_name),
                        html: '<div style="height:300px"> <table><tbody><tr><td colspan="2">'
                                + '[AC:' + ac_no + '-PS:' + ps_no + '] ' + ps_name + '</td></tr><tr><td> BDO OFFICE:</td><td>'
                                + bdo_office + '</td></tr><tr><td> BDO NO:</td><td><a class="PhoneNo">'
                                + bdo_no + '</a></td></tr><tr><td>  SECTOR :</td><td>' + sector_no + '-' + sector_name
                                + '</td></tr><tr><td>SECTOR OFFICER :</td><td>' + sector_officer_name
                                + '</td></tr><tr><td>MOBILE NO :</td><td><a class="PhoneNo">' + sector_officer_mobile
                                + '</a></td></tr><tr><td> VST:</td><td>' + vst_name
                                + ' <a class="PhoneNo">' + vst_mobile
                                + '</a></td></tr><tr><td> SST:</td><td>' + sst_name
                                + ' <a class="PhoneNo">' + sst_mobile
                                + '</a></td></tr><tr><td> FS:</td><td>' + fs_name
                                + ' <a class="PhoneNo">' + fs_mobile
                                + '</a></td></tr><tr><td>PRO :</td><td><a class="PhoneNo">' + pro_mobile_no
                                + '</a></td></tr><tr><td>P1:</td><td><a href="tel:' + p1_mobile_no + '">'
                                + p1_mobile_no + '</a></td></tr><tr><td></td></tr><tr><td colspan="2"><span>' + lweMark
                                + '</span><span>' + mobile_shadow_zone_mark
                                + '</span><span>' + critical_ps_mark
                                + '</span><span>' + vulnerable_mark + '</span></td></tr>'
                                + '<tr><td colspan="4"><a data-lightbox="example-set" href="ps_photo/' + ac_no + '_'
                                + ps_no + '.jpg"><img width="50px" height="50px" src="ps_photo/' + ac_no + '_' + ps_no
                                + '_T.jpg"></a><tr><td></tbody></table></div>',
                        icon: 'http://10.173.168.128/PollDayMonitoring/Marker.php?PSNo=' + ps_no + '&Color=' + ColorAC
                    });

                    // gmarkers.push(marker);
                    marker.setMap(map);
                    // var div = document.createElement("div");
                    // div.innerHTML=(i+1) + '. <a href="javascript:myclick(' + (gmarkers.length-1) + ')">' + name + '<\/a><br>';
                    // document.getElementById('sidebar').appendChild(div);

                    google.maps.event.addListener(marker, 'click', function() {
                        // where I have added .html to the marker object.
                        //maxWidth: 200

                        if (this.getAnimation() !== null) {
                            this.setAnimation(null);
                        } else {
                            this.setAnimation(google.maps.Animation.BOUNCE);
                        }
                        infowindow.setContent(this.html);
                        infowindow.open(map, this);

                        $('a.PhoneNo').click(function(event) {
                            event.preventDefault();
                            var callURI = 'http://10.173.168.133:8080';
                            $.ajax({
                                url: callURI,
                                dataType: 'jsonp',
                                data: {
                                    cellNo: $(this).html(),
                                    format: "json"},
                                success: function(resp) {
                                    console.log("Done: " + resp);
                                },
                                error: function(resp) {
                                    console.log("Error: " + resp);
                                }
                            });
                        });
                    });
                }
                $('#loading').hide();
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
                <table width="100%" class="" cellspacing="0">
                    <tr>
                        <td align="left"><div><h2>POLL MONITORING (PASCHIM MEDINIPUR)</h2></div></td>
                        <td><span id="loading" style="display:none">Loading...</span></td>
                    </tr>
                    <tr>
                        <td>PC:	<select name="pc" id="pc" style="width:150px" onchange="select_PC();">
                                <option value="" selected>--Please select--</option>
                                <option value="33" >33-Jhargram</option>
                                <option value="34" >34-Medinipur</option>
                                <option value="32" >32-Ghatal</option>
                            </select>
                            AC: <select name="ac" id="ac" style="width:150px">
                                <option value="" >All</option>
                            </select>
                            <input style="width:150px" type="button" name="btn" name="btn" class="btn" value="SHOW STATUS" onclick="getData();"/>
                            </ul></td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <div class="gmap">
                    <div id='gmap_canvas' style="position:relative; width:100%;"></div>
                </div>
            </div>
        </div>
        <script>
            var sHeight = screen.height;
            var head_height = $('#pHead').height();
            $('#gmap_canvas').height($(document).height());
        </script>
    </body>
</html>
