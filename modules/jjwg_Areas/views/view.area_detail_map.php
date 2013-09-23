<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_AreasViewArea_Detail_Map extends SugarView {

  function Jjwg_AreasViewArea_Detail_Map() {
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
    html { height: 100% }
    body { height: 100%; margin: 0px; padding: 0px }
    #mapCanvas {
      width: 500px;
      height: 300px;
      float: left;
    }
    #infoPanel {
      float: left;
      margin-left: 10px;
    }
    #mapCanvas, #infoPanel, #markerStatus, #info, #address {
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #444444;
      margin-bottom: 5px;
    }
    b {
      font-weight: normal;
      color: #000000;
    }
  </style>
  
  <script src="//www.google.com/jsapi"></script>
  <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>

  <script type="text/javascript">

function initialize() {

    //create map
  var latLng = new google.maps.LatLng(
    <?php echo (!empty($loc['lat'])) ? $loc['lat'] : $jjwg_config['map_default_center_latitude']; ?>, 
    <?php echo (!empty($loc['lng'])) ? $loc['lng'] : $jjwg_config['map_default_center_longitude']; ?> 
  );

  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 4,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  var bounds = new google.maps.LatLngBounds();
<?php
  $i = 0;
  if (count($polygon) > 0) {
    foreach ($polygon as $coord) {
?>
      var myLatLng<?php echo $i; ?> = new google.maps.LatLng(<?php echo $coord['lat']; ?>,<?php echo $coord['lng']; ?>);
      bounds.extend(myLatLng<?php echo $i; ?>);
<?php
      $i++;
    }
  }
  if (count($polygon) > 0) {
?>
    var myCoords = [
<?php
    for($i=0;$i<count($polygon);$i++) {
?>
      myLatLng<?php echo $i; ?><?php if ($i != count($polygon)-1) echo ','; ?>
<?php
    }
?>
    ];
  myAreaPolygon = new google.maps.Polygon({
    paths: myCoords,
    strokeColor: "#000099",
    strokeOpacity: 0.8,
    strokeWeight: 1,
    fillColor: "#000099",
    fillOpacity: 0.20
  });  
  myAreaPolygon.setMap(map);

  map.fitBounds(bounds);

<?php
  }
?>

}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
  
  <div id="mapCanvas"></div>
  <div id="infoPanel"><b></b>
    <div id="markerStatus"><i></i></div>
    <div id="info"></div>
    <div id="address"></div>
  </div>

</body>
</html>

<?php

  }

}
?>