<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('modules/jjwg_Areas/jjwg_Areas_sugar.php');
require_once('modules/jjwg_Maps/jjwg_Maps.php');


class jjwg_Areas extends jjwg_Areas_sugar {

    /**
     * @var settings array
     */
    var $settings = array();
    /**
     * Point in Area/Polygon check on vertices?
     * @var boolean
     */
    var $point_on_vertex = true;

    function jjwg_Areas() {
        
        parent::jjwg_Areas_sugar();
        // Admin Config Setting
        $this->configuration();
    }

    /**
     * Load Configuration Settings using Administration Module
     * See jjwg_Maps module for setting config
     * $GLOBALS['jjwg_config_defaults']
     * $GLOBALS['jjwg_config']
     */
    function configuration() {

        $this->jjwg_Maps = new jjwg_Maps();
        $this->settings = $GLOBALS['jjwg_config'];
    }

    /**
     * 
     * Define polygon coordinates for views
     */
    function define_polygon() {

        $polygon = array();
        if (preg_match('/[\n\r]/', $this->coordinates)) {
            $coords = preg_split("/[\n\r\s]+/", $this->coordinates, null, PREG_SPLIT_NO_EMPTY);
        } else {
            $coords = preg_split("/[\s]+/", $this->coordinates, null, PREG_SPLIT_NO_EMPTY);
        }
        if (count($coords) > 0) {
            foreach ($coords as $coord) {
                $p = preg_split("/[\s\(\)]*,[\s\(\)]*/", $coord, null, PREG_SPLIT_NO_EMPTY);
                if ($this->is_valid_lng($p[0]) && $this->is_valid_lat($p[1])) {
                    $polygon[] = array(
                        'lng' => $p[0],
                        'lat' => $p[1],
                        'elv' => $p[2],
                    );
                }
            }
        }
        if (count($polygon) > 0) {
            return $polygon;
        } else {
            return false;
        }
    }

    /**
     * 
     * Define Area centeral point based on average
     */
    function define_area_loc() {

        $loc = array();
        $i = 0;
        $latTotal = 0.0;
        $lngTotal = 0.0;
        // Find average point (lng,lat,elv)
        $coords = preg_split("/[\n\r]+/", $this->coordinates, null, PREG_SPLIT_NO_EMPTY);
        foreach ($coords as $coord) {
            $p = preg_split("/[\s\(\)]*,[\s\(\)]*/", $coord, null, PREG_SPLIT_NO_EMPTY);
            if ($this->is_valid_lat($p[0]) && $this->is_valid_lng($p[1])) {
                $lngTotal += $p[0];
                $latTotal += $p[1];
                $i++;
            }
        }
        $loc['name'] = $this->name;
        if ($i > 0) {
            $loc['lat'] = $latTotal / floatval($i);
            $loc['lng'] = $lngTotal / floatval($i);
            $loc['elv'] = 0;
        } else {
            $loc['lat'] = 0;
            $loc['lng'] = 0;
            $loc['elv'] = 0;
        }
        $loc = $this->define_loc($loc);

        return $loc;
    }

    /**
     * 
     * Define Marker Location
     * @param $marker mixed (array or object)
     */
    function define_loc($marker = array()) {

        $loc = array();
        if (is_object($marker)) {
            $loc['name'] = $marker->name;
            $loc['lat'] = $marker->jjwg_maps_lat;
            $loc['lng'] = $marker->jjwg_maps_lng;
        } elseif (is_array($marker)) {
            $loc['name'] = $marker['name'];
            $loc['lat'] = $marker['lat'];
            $loc['lng'] = $marker['lng'];
        }
        if (empty($loc['name'])) {
            $loc['name'] = 'N/A';
        }
        if (!$this->is_valid_lat($loc['lat'])) {
            $loc['lat'] = '28.7312';
        }
        if (!$this->is_valid_lng($loc['lng'])) {
            $loc['lng'] = '-81.41267';
        }
        return $loc;
    }

    /**
     * 
     * Check for valid longitude
     * @param $lng float
     */
    function is_valid_lng($lng) {
        return (is_numeric($lng) && $lng >= -180 && $lng <= 180);
    }

    /**
     * 
     * Check for valid latitude
     * @param $lat float
     */
    function is_valid_lat($lat) {
        return (is_numeric($lat) && $lat >= -90 && $lat <= 90);
    }

    /**
     * Determine if Marker Object is in Area (Polygon)
     * @param object $marker
     */
    function is_marker_in_area($marker) {
        
        $loc = array();
        if (is_object($marker)) {
            $loc['lat'] = $marker->jjwg_maps_lat;
            $loc['lng'] = $marker->jjwg_maps_lng;
        } elseif (is_array($marker)) {
            $loc['lat'] = $marker['lat'];
            $loc['lng'] = $marker['lng'];
        }
        
        return $this->is_point_in_area($loc['lng'], $loc['lat']);
    }

    /**
     * Determine if lng/lat point is in Area Polygon
     * 
     * @param float $lng
     * @param float $lat
     */
    function is_point_in_area($lng, $lat) {
        
        // lng,lat,elv
        $point = $lng.','.$lat.',0.0';
        
        return $this->point_in_polygon($point);
    }
    
    /**
     * Determine if Point lies within Polygon
     * 
     * Polygon Algorithm: http://assemblysys.com/php-point-in-polygon-algorithm/
     * Modified by JJWDesign 07/16/2013
     *
     * @param string $point
     * @param boolean $point_on_vertex
     * @return boolean
     */
    function point_in_polygon($point, $point_on_vertex = true) {
        
        $this->point_on_vertex = $point_on_vertex;
        $polygon = preg_split('/[\s]+/', $this->coordinates);
 
        // Transform string coordinates into arrays with x and y values
        $point = $this->point_string_to_coordinates($point);
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->point_string_to_coordinates($vertex);
        }
        
        // Check if the point sits exactly on a vertex
        if ($this->point_on_vertex == true and $this->point_on_vertex($point, $vertices) == true) {
            return true;
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0;
        $vertices_count = count($vertices);
 
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1];
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return true;
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return true;
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }
        // If the number of edges we passed through is odd, then it's in the polygon.
        if ($intersections % 2 != 0) {
            return true;
        } else {
            return false;
        }
    }
 
    function point_on_vertex($point, $vertices) {
        
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }

    function point_string_to_coordinates($pointString) {
        
        // Coordinate Results (lng,lat,elv)
        $coordinates = preg_split('/[,]+/', $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }
    

}
