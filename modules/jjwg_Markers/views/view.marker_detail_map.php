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

class Jjwg_MarkersViewMarker_Detail_Map extends SugarView
{

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function Jjwg_MarkersViewMarker_Detail_Map()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    function __construct()
    {
        parent::__construct();
    }

    function display()
    {

        $custom_markers_dir = 'themes/default/images/jjwg_Markers/';

        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title><?php echo $GLOBALS['mod_strings']['LBL_MARKER_DISPLAY']; ?></title>
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

            <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>

            <script type="text/javascript">

              var geocoder = new google.maps.Geocoder();

              function geocodePosition(pos) {
                geocoder.geocode({
                  latLng: pos
                }, function (responses) {
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
              }

              function initialize() {

                var latLng = new google.maps.LatLng(
                    <?php echo (!empty($GLOBALS['loc']['lat'])) ? $GLOBALS['loc']['lat'] : $GLOBALS['jjwg_config']['map_default_center_latitude']; ?>,
                    <?php echo (!empty($GLOBALS['loc']['lng'])) ? $GLOBALS['loc']['lng'] : $GLOBALS['jjwg_config']['map_default_center_longitude']; ?>
                );

                var map = new google.maps.Map(document.getElementById('mapCanvas'), {
                  zoom: 4,
                  center: latLng,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var customImage = new google.maps.MarkerImage('<?php echo $custom_markers_dir; ?>/<?php echo javascript_escape($GLOBALS['loc']['image']); ?>.png',
                  new google.maps.Size(32, 37),
                  new google.maps.Point(0, 0),
                  new google.maps.Point(16, 37)
                );
                var shape = {coord: [1, 1, 1, 37, 32, 37, 32, 1], type: 'poly'};

                var marker = new google.maps.Marker({
                  position: latLng,
                  title: '<?php echo javascript_escape($GLOBALS['loc']['name']); ?>',
                  map: map,
                  icon: customImage,
                  shape: shape,
                  draggable: false
                });
                // Update current position info.
                updateMarkerPosition(latLng);
                geocodePosition(latLng);
              }

              // Onload handler to fire off the app.
              google.maps.event.addDomListener(window, 'load', initialize);
            </script>
        </head>
        <body>
        <div id="mapCanvas"></div>
        <div id="infoPanel"><b></b>
            <div id="markerStatus"><i></i></div>
            <b><?php echo $GLOBALS['mod_strings']['LBL_MARKER_MARKER_POSITION']; ?></b>
            <div id="info"></div>
            <b><?php echo $GLOBALS['mod_strings']['LBL_MARKER_CLOSEST_MATCHING_ADDRESS']; ?></b>
            <div id="address"></div>
        </div>
        </body>
        </html>

        <?php

    }

}
