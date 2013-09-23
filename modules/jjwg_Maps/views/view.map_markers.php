<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewMap_Markers extends SugarView {

  function Jjwg_MapsViewMap_Markers() {
    parent::SugarView();
  }

  function display() {
    
    global $sugar_config;
    global $currentModule;
    global $theme;
    global $mod_strings;
    $jsonObj = new JSON(JSON_LOOSE_TYPE);
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <title><?php echo $mod_strings['LBL_MAP_DISPLAY']; ?></title> 
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
    #map_canvas {
      width: 100%;
      height: 500px;
      border: 0;
    }
    div.marker {
      font-size: 12px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      overflow: hidden;
    }
    #legend {
      width: 100%;
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #444444;
      font-weight: normal;  
    }
    b {
      font-size: 12px;
      line-height: 16px;
      font-weight: bold;
      color: #000000;
    }
  </style>
  <script src="//www.google.com/jsapi"></script>
  <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="modules/jjwg_Maps/javascript/markerclusterer.js"></script>
  <script type="text/javascript">
<?php
    // Define globals for use in the view.
    global $jjwg_config_defaults;
    global $jjwg_config;
    global $map_center; // center marker
    global $map_markers; // grouped markers
    global $map_markers_groups; // array of grouping names
    global $custom_markers;
    global $custom_areas;
?>
// Define Map Data for Javascript
var jjwg_config_defaults = <?php echo (!empty($jjwg_config_defaults)) ? $jsonObj->encode($jjwg_config_defaults) : '[]'; ?>;
var jjwg_config = <?php echo (!empty($jjwg_config)) ? $jsonObj->encode($jjwg_config) : '[]'; ?>;
<?php
if (empty($map_center)) {
    $map_center = array(
        'lat' => $jjwg_config['map_default_center_latitude'],
        'lng' => $jjwg_config['map_default_center_longitude'],
        'name' => '',
        'html' => ''
    );
}
?>
var map_center = <?php echo (!empty($map_center)) ? $jsonObj->encode($map_center) : 'null'; ?>;
var map_markers = <?php echo (!empty($map_markers)) ? $jsonObj->encode($map_markers) : '[]'; ?>;
var map_markers_groups = <?php echo (!empty($map_markers_groups)) ? $jsonObj->encode($map_markers_groups) : '[]'; ?>;
var custom_markers = <?php echo (!empty($custom_markers)) ? $jsonObj->encode($custom_markers) : '[]'; ?>;
var custom_areas = <?php echo (!empty($custom_areas)) ? $jsonObj->encode($custom_areas) : '[]'; ?>;
<?php
    // Define Map Data
    $num_markers = count($map_markers);
    $num_groups = count($map_markers_groups);
    if ($num_groups > 216) $num_groups = 216;
    $group_name_to_num = array();
    $i = 1;
    // Define Group Name to Icon Number Mapping 1-216(max)
    if (!empty($map_markers_groups)) {
        foreach ($map_markers_groups as $name) {
            $group_name_to_num[$name] = $i;
            $i++;
        }
    }
    // Define Dir of Group Icons
    $icons_dir_base = 'custom/themes/default/images/jjwg_Maps/';
    if ($num_groups <= 10) {
      $icons_dir = $icons_dir_base.'0-10/';
    } elseif ($num_groups <= 25) {
      $icons_dir = $icons_dir_base.'0-25/';
    } elseif ($num_groups <= 100) {
      $icons_dir = $icons_dir_base.'0-100/';
    } elseif ($num_groups <= 216) {
      $icons_dir = $icons_dir_base.'0-216/';
    } else {
      $icons_dir = $icons_dir_base.'0-10/'; // Demo Version
    }
    
    // Define Custom Markers Dir and Common Icons
    $custom_markers_dir = 'custom/themes/default/images/jjwg_Markers/';
    $custom_markers_icons = array();
    foreach($custom_markers as $marker) {
      $custom_markers_icons[] = $marker['image'];
    }
    $num_custom_markers = count($custom_markers);
    $custom_markers_icons = array_unique($custom_markers_icons);
?>

// Define Map Data for Javascript
var num_markers = <?php echo (!empty($num_markers)) ? $jsonObj->encode($num_markers) : '0'; ?>;
var num_groups = <?php echo (!empty($num_groups)) ? $jsonObj->encode($num_groups) : '0'; ?>;
var group_name_to_num = <?php echo (!empty($group_name_to_num)) ? $jsonObj->encode($group_name_to_num) : '[]'; ?>;
var icons_dir = <?php echo (!empty($icons_dir)) ? $jsonObj->encode($icons_dir) : "'custom/themes/default/images/jjwg_Maps/0-10/'"; ?>;
var num_custom_markers = <?php echo (!empty($num_custom_markers)) ? $jsonObj->encode($num_custom_markers) : '0'; ?>;
var custom_markers_dir = <?php echo (!empty($custom_markers_dir)) ? $jsonObj->encode($custom_markers_dir) : "'custom/themes/default/images/jjwg_Markers/'"; ?>;
var custom_markers_icons = <?php echo (!empty($custom_markers_icons)) ? $jsonObj->encode($custom_markers_icons) : '[]'; ?>;

function initialize() {

    var myOptions = {
        zoom: 4,
        center: new google.maps.LatLng(
            <?php echo (!empty($loc['lat'])) ? $loc['lat'] : $jjwg_config['map_default_center_latitude']; ?>,
            <?php echo (!empty($loc['lng'])) ? $loc['lng'] : $jjwg_config['map_default_center_longitude']; ?>
        ),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    var bounds = new google.maps.LatLngBounds();

    var loc = [];
    var myLatLng = [];
    var marker = [];
    // infowindow: array of InfoWindow objects used for all markers, custom markers and custom areas
    var infowindow = [];
    var markers = [];

    // Define the Marker Images
    var markerImage = [];
    for (var i=0; i<=map_markers_groups.length; i++) {
        markerImage[i] = new google.maps.MarkerImage(icons_dir+'/marker_'+i+'.png',
        new google.maps.Size(20,34), new google.maps.Point(0,0), new google.maps.Point(10,34));
    }

    var shape = {coord: [1, 1, 1, 34, 20, 34, 20, 1],type: 'poly'};

    // Center Marker - marker[0]
    if (map_center !== null) {
        loc[0] = map_center;
        myLatLng[0] = new google.maps.LatLng(loc[0].lat, loc[0].lng);
        marker[0] = new google.maps.Marker({
            position: myLatLng[0],
            map: map,
            icon: markerImage[0],
            shape: shape,
            title: loc[0].name,
            infoHtml: loc[0].html,
            zIndex: 99
        });
        //console.log(0);
        google.maps.event.addListener(marker[0], 'click', function() {
            infowindow[0] = new google.maps.InfoWindow();
            infowindow[0].open(map, this);
            infowindow[0].setContent(this.infoHtml);
        });
        bounds.extend(myLatLng[0]);
    }

    // Marker Locations
<?php
  if ($num_markers > 0) {
?>
    for (var i=1; i<=map_markers.length; i++) {
        loc[i] = map_markers[i-1];
        if (loc[i].group == '') loc[i].group = map_markers_groups[0];
        myLatLng[i] = new google.maps.LatLng(loc[i].lat, loc[i].lng);
        marker[i] = new google.maps.Marker({
            position: myLatLng[i],
            map: map,
            icon: markerImage[group_name_to_num[loc[i].group]],
            shape: shape,
            title: loc[i].name,
            infoHtml: loc[i].html,
            infoI: i,
            zIndex: 5
        });
        //console.log(marker[i].infoI);
        google.maps.event.addListener(marker[i], 'click', function() {
            if (typeof infowindow[this.infoI] != 'object') {
                infowindow[this.infoI] = new google.maps.InfoWindow();
            }
            infowindow[this.infoI].open(map, this);
            infowindow[this.infoI].setContent(this.infoHtml);
        });
        bounds.extend(myLatLng[i]);
        markers.push(marker[i]);

    } // end for

    var markerClusterer = new MarkerClusterer(map, markers, { 
        maxZoom: <?php echo (isset($jjwg_config['map_clusterer_max_zoom'])) ? $jjwg_config['map_clusterer_max_zoom'] : $jjwg_config_defaults['map_clusterer_max_zoom']; ?>,
        gridSize: <?php echo (isset($jjwg_config['map_clusterer_grid_size'])) ? $jjwg_config['map_clusterer_grid_size'] : $jjwg_config_defaults['map_clusterer_grid_size']; ?>
    });

<?php
  } // end if
?>
    
    
    
    // Define the Custom Marker Images (jjwg_Markers Module)
    var customImage = [];
    for (var i=0; i<custom_markers_icons.length; i++) {
        image = custom_markers_icons[i];
        customImage[image] = new google.maps.MarkerImage(custom_markers_dir+image+'.png',
            new google.maps.Size(32,37),
            new google.maps.Point(0,0),
            new google.maps.Point(16,37)
        );
    }
    var custom_shape = {coord: [1, 1, 1, 37, 32, 37, 32, 1],type: 'poly'};

<?php
    if ($num_custom_markers > 0) {
?>
    for (var i=num_markers+1; i<=num_markers+num_custom_markers; i++) {
        
        loc[i] = custom_markers[i-num_markers-1];
        myLatLng[i] = new google.maps.LatLng(loc[i].lat, loc[i].lng);
        marker[i] = new google.maps.Marker({
            position: myLatLng[i],
            map: map,
            icon: customImage[loc[i].image],
            shape: custom_shape,
            title: loc[i].name,
            infoHtml: loc[i].html,
            infoI: i,
            zIndex: 25
        });
        //console.log(marker[i].infoI);
        google.maps.event.addListener(marker[i], 'click', function() {
            if (typeof infowindow[this.infoI] != 'object') {
                infowindow[this.infoI] = new google.maps.InfoWindow();
            }
            infowindow[this.infoI].open(map, this);
            infowindow[this.infoI].setContent(this.infoHtml);
        });
        bounds.extend(myLatLng[i]);
        markers.push(marker[i]);
        
    } // end for
    
<?php
    } // end if $custom_markers
?>


  
  

  // Define the Custom Area Polygons (jjwg_Areas Module)
<?php
  if (count($custom_areas) > 0) {
?>
    var polygon = [];
    var p = [];
    var myAreaPolygon = [];
    
    for (var i=0; i<custom_areas.length; i++) {
        
        // coordinates: space separated lng,lat,elv points
        myCoords = [];
        polygon = custom_areas[i].coordinates.split(" ");
        for (var j=0; j<polygon.length; j++) {
            p = polygon[j].split(",");
            myCoords[j] = new google.maps.LatLng(p[1], p[0]); // lat, lng
            bounds.extend(myCoords[j]);
        }
        myAreaPolygon[i] = new google.maps.Polygon({
            paths: myCoords,
            strokeColor: "#000099",
            strokeOpacity: 0.8,
            strokeWeight: 1,
            fillColor: "#000099",
            fillOpacity: 0.15,
            title: custom_areas[i].name,
            infoHtml: custom_areas[i].html,
            infoI: i+num_markers+num_custom_markers+1, // inc with markers counts
            zIndex: 1
        });
        //console.log(myAreaPolygon[i].infoI);
        myAreaPolygon[i].setMap(map);
        google.maps.event.addListener(myAreaPolygon[i], 'click', function(event) {
            if (typeof infowindow[this.infoI] != 'object') {
                infowindow[this.infoI] = new google.maps.InfoWindow();
            }
            infowindow[this.infoI].setContent(this.infoHtml);
            infowindow[this.infoI].setPosition(event.latLng);
            infowindow[this.infoI].open(map);
        });
    }
<?php
  }
?>


  // Lastly
  map.fitBounds(bounds);

}

</script>

</head>

<body onload="initialize()">
  
  <div id="map_canvas"></div>
  <br clear="all" />
  <div id="legend">
  <b><?php echo $mod_strings['LBL_MAP_LEGEND']; ?> </b>
<?php
  if (!empty($map_center)) {
?>
    <img src="<?php echo $sugar_config['site_url'].'/'.$icons_dir.'/marker_0.png'; ?>" align="middle" />
    <?php echo $map_center['name']; ?>, 
<?php
  }
?>
  &nbsp; <b><?php echo $mod_strings['LBL_MAP_USER_GROUPS']; ?> </b>
<?php
  $i = 1;
  foreach($group_name_to_num as $group_name => $group_number) {
?>
    <img src="<?php echo $sugar_config['site_url'].'/'.$icons_dir.'/marker_'.$group_number.'.png'; ?>" align="middle" />
    <?php echo htmlentities($group_name, ENT_COMPAT, "UTF-8", false); ?><?php if ($i != $num_groups) echo ','; ?>
<?php
    $i++;
  }
?>   
  </div>
  
</body> 
</html>
<?php

   }
}

?>
