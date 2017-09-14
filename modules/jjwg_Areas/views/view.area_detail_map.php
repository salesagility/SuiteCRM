<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class Jjwg_AreasViewArea_Detail_Map extends SugarView
{

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function Jjwg_AreasViewArea_Detail_Map()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    public function __construct()
    {
        parent::__construct();
    }

    function display()
    {

        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title><?php echo $GLOBALS['mod_strings']['LBL_AREA_MAP']; ?></title>
            <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
            <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
            <link rel="stylesheet" type="text/css" href="cache/themes/<?php echo $GLOBALS['theme']; ?>/css/style.css"/>
            <style type="text/css">
                html {
                    height: 100%
                }

                body {
                    height: 100%;
                    margin: 0px;
                    padding: 0px
                }

                #mapCanvas {
                    width: 700px;
                    height: 500px;
                    float: left;
                }

                #infoPanel {
                    width: 450px;
                    float: left;
                    margin-left: 10px;
                }

                #mapCanvas, #infoPanel, #markerStatus, #info, #address {
                    font-size: 12px;
                    line-height: 16px;
                    font-family: Arial, Verdana, Helvetica, sans-serif;
                    color: #444444;
                    margin-bottom: 5px;
                }

                b {
                    font-weight: normal;
                    color: #000000;
                }
            </style>

            <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&libraries=drawing"></script>

            <script type="text/javascript">

              // Define Map Data for Javascript
              var jjwg_config_defaults = <?php echo (!empty($GLOBALS['jjwg_config_defaults'])) ? json_encode($GLOBALS['jjwg_config_defaults']) : '[]'; ?>;
              var jjwg_config = <?php echo (!empty($GLOBALS['jjwg_config'])) ? json_encode($GLOBALS['jjwg_config']) : '[]'; ?>;
              var polygonPoints = <?php echo (!empty($GLOBALS['polygon'])) ? json_encode($GLOBALS['polygon']) : '[]'; ?>;

              function initialize() {

                //create map
                var latLng = new google.maps.LatLng(
                    <?php echo (!empty($GLOBALS['loc']['lat'])) ? $GLOBALS['loc']['lat'] : $GLOBALS['jjwg_config']['map_default_center_latitude']; ?>,
                    <?php echo (!empty($GLOBALS['loc']['lng'])) ? $GLOBALS['loc']['lng'] : $GLOBALS['jjwg_config']['map_default_center_longitude']; ?>
                );

                var map = new google.maps.Map(document.getElementById('mapCanvas'), {
                  zoom: 4,
                  center: latLng,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var bounds = new google.maps.LatLngBounds();


                // Define the Custom Area Polygons (jjwg_Areas Module)
                var polygon = [];
                var p = [];
                var myAreaPolygon = [];

                if (polygonPoints.length > 0) {

                  // Define coordinates from objects
                  myCoords = [];
                  for (var j = 0; j < polygonPoints.length; j++) {
                    p = polygonPoints[j];
                    myCoords[j] = new google.maps.LatLng(parseFloat(p.lat), parseFloat(p.lng)); // lat, lng
                    bounds.extend(myCoords[j]);
                  }
                  myAreaPolygon[0] = new google.maps.Polygon({
                    paths: myCoords,
                    strokeColor: "#000099",
                    strokeOpacity: 0.8,
                    strokeWeight: 1,
                    fillColor: "#000099",
                    fillOpacity: 0.15,
                    zIndex: 1
                  });
                  //console.log(myAreaPolygon[0]);

                  myAreaPolygon[0].setMap(map);

                  map.fitBounds(bounds);

                }

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
