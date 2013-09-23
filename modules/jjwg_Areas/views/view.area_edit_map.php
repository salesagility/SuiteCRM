<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_AreasViewArea_Edit_Map extends SugarView {

  function Jjwg_AreasViewArea_Edit_Map() {
    parent::SugarView();
  }
  
  function display() {
    
    global $sugar_config;
    global $jjwg_config;
    global $currentModule;
    global $theme;
    global $mod_strings;
    global $loc;
    global $polygon;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <title><?php echo $mod_strings['LBL_AREA_MAP']; ?></title> 
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
  <link rel="stylesheet" type="text/css" href="cache/themes/<?php echo $theme; ?>/css/style.css" />
  <style type="text/css">
    html,body{
      margin:0;
      padding:0;
      width:100%;
      height:100%;
      font-family:Arial, Helvetica, sans-serif;
    }
      
    #header{ 
      vertical-align: top;
    }
    #main-map{
      width: 500px;
      height: 300px;
      float: left;
    }
    #side{
      float: left;
      width: 450px;
      margin-left: 10px;
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #444444;
      font-weight: normal;  
    }
    
    #dataPanel{
      overflow:auto;
      border:1px solid #DDDDDD;
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #444444;
      font-weight: normal;  
    }
    input{
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #444444;
      font-weight: normal;  
    }
    
    input.navi{
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #444444;
      font-weight: normal;  
      margin-bottom:10px;
    }
    #header p{
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #444444;
      padding-bottom: 10px;
    }
    b {
      font-weight: normal;
      color: #000000;
    }
    .message-box { text-align: center; padding: 5px; color:#545454; width:80%;  margin:5px auto; font-size:12px;}
    .clean { background-color: #efefef; border-top: 2px solid #dedede; border-bottom: 2px solid #dedede; }
    .info  { background-color: #f7fafd; border-top: 2px solid #b5d3ff; border-bottom: 2px solid #b5d3ff; }
    .ok    { background-color: #d7f7c4; border-top: 2px solid #82cb2f; border-bottom: 2px solid #82cb2f; }
    .alert { background-color: #fef5be; border-top: 2px solid #fdd425; border-bottom: 2px solid #fdd425; }
    .error { background-color: #ffcdd1; border-top: 2px solid #e10c0c; border-bottom: 2px solid #e10c0c; }
  </style>

  <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="modules/jjwg_Areas/javascript/jquery-1.4.2.min.js"></script>
  <script type="text/javascript" src="modules/jjwg_Areas/javascript/polygon.js"></script>
  
  <script type="text/javascript">
  $(function(){
      //create map
     var latLng = new google.maps.LatLng(
        <?php echo (!empty($loc['lat'])) ? $loc['lat'] : $jjwg_config['map_default_center_latitude']; ?>, 
        <?php echo (!empty($loc['lng'])) ? $loc['lng'] : $jjwg_config['map_default_center_longitude']; ?> 
     );
     var myOptions = {
        zoom: 4,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
     map = new google.maps.Map(document.getElementById('main-map'), myOptions);
     
     var creator = new PolygonCreator(map);
     
     //reset polygon
     $('#reset').click(function(){ 
        creator.destroy();
        creator=null;
        creator = new PolygonCreator(map);
     });
     
     //show paths / coordinates
     var myCoords = Array();
     var myDataString = '';
     var myCoord = Array();
     $('#showData').click(function(){ 
        $('#dataPanel').empty();
        if(null==creator.showData()){
          $('#dataPanel').append('First Create a Polygon');
        }else{
          // Strange data format: (lat,lng)(lat,lng)(lat,lng)
          myDataString = '';
          myCoords = creator.showData().split(')(');
          for (var i = 0; i < myCoords.length; i++) {
            myCoord = myCoords[i].replace(/\(|\)/g, '').split(',');
            // Return format: lng,lat,elv
            if (myCoord[0] && myCoord[1]) {
              myDataString += myCoord[1].replace(/\s/g,"")+','+myCoord[0].replace(/\s/g,"")+',0 ';
            }
          }
          $('#dataPanel').append(myDataString);
          // Update Parent Form Value
          parent.document.getElementById('coordinates').value = myDataString.replace(/^\s+|\s+$/g,"");
        }
     });
     
  });
  </script>
</head>
<body>
  <div id="main-map">
  </div>
  <div id="side">
    <div id="header"><b>Area Creation Instructions:</b><br />
    Left click on the map, in a clockwise motion, to create marker points for the area.
    Click on the first marker point to close the polygon area.<br />
    <input id="reset" value="Reset" type="button" class="navi"/>
    <input id="showData" value="Use Area Coordinates" type="button" class="navi"/>
    <br />
    Coordinate Results (lng,lat,elv):
    <br />
    </div>
    <div id="dataPanel">
    </div>
  </div>
</body>
</html>

<?php

  }

}
?>