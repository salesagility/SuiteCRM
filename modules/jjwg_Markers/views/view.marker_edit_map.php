<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MarkersViewMarker_Edit_Map extends SugarView {

  function Jjwg_MarkersViewMarker_Edit_Map() {
    parent::SugarView();
  }
  
  function display() {
    
    global $sugar_config;
    global $jjwg_config;
    global $currentModule;
    global $theme;
    global $mod_strings;
    global $loc;

    $custom_markers_dir = 'custom/themes/default/images/jjwg_Markers/';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <title><?php echo $mod_strings['LBL_MARKER_DISPLAY']; ?></title> 
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
  
  <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>

  <script type="text/javascript">

var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
  parent.document.getElementById('description').value = str;
}

function updateEditFormLatLng(latLng) {
  parent.document.getElementById('jjwg_maps_lat').value = latLng.lat();
  parent.document.getElementById('jjwg_maps_lng').value = latLng.lng();
}

function initialize() {

  var latLng = new google.maps.LatLng(
    <?php echo (!empty($loc['lat'])) ? $loc['lat'] : $jjwg_config['map_default_center_latitude']; ?>, 
    <?php echo (!empty($loc['lng'])) ? $loc['lng'] : $jjwg_config['map_default_center_longitude']; ?> 
  );

  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 4,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
<?php
  if (!empty($loc['image'])) {
?>
  var customImage = new google.maps.MarkerImage('<?php echo $custom_markers_dir; ?>/<?php echo javascript_escape($loc['image']); ?>.png',
    new google.maps.Size(32,37),
    new google.maps.Point(0,0),
    new google.maps.Point(16,37)
  );
  var shape = {coord: [1, 1, 1, 37, 32, 37, 32, 1],type: 'poly'};
<?php
  } // empty image
?>

  var marker = new google.maps.Marker({
    position: latLng,
    title: '<?php echo javascript_escape($loc['name']); ?>',
    map: map,
<?php
  if (!empty($loc['image'])) {
?>
    icon: customImage,
    shape: shape,
<?php
  } // empty image
?>
    draggable: true
  });
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
    // Update the parent window edit view form lat/lng
    updateEditFormLatLng(marker.getPosition());
  });
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
  
  <div id="mapCanvas"></div>
  <div id="infoPanel">
    <b>Marker status:</b>

    <div id="markerStatus"><i>Click and drag the marker.</i></div>
    <b>Marker Position (Latitude, Longitude):</b>
    <div id="info"></div>
    <b>Closest Matching Address:</b>
    <div id="address"></div>
  </div>

</body>
</html>

<?php

  }

}
?>
