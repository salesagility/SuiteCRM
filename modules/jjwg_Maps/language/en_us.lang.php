<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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

$mod_strings['LBL_MAP'] = 'Map';
$mod_strings['LBL_MODULE_NAME'] = 'Maps';
$mod_strings['LBL_MODULE_TITLE'] = 'Maps: Home';
$mod_strings['LBL_MODULE_ID'] = 'Maps';
$mod_strings['LBL_LIST_FORM_TITLE'] = 'Maps Listing';
$mod_strings['LBL_MAP_CUSTOM_MARKER'] = 'Custom Marker';
$mod_strings['LBL_MAP_CUSTOM_AREA'] = 'Custom Area';
$mod_strings['LBL_HOMEPAGE_TITLE'] = 'My Maps Listing';

$mod_strings['LBL_FLEX_RELATE'] = 'Related to (Center):';
$mod_strings['LBL_MODULE_TYPE'] = 'Module Type to Display:';
$mod_strings['LBL_DISTANCE'] = 'Distance (Radius):';
$mod_strings['LBL_UNIT_TYPE'] = 'Unit Type:';

$mod_strings['LBL_MAP_DISPLAY'] = 'Map Display';
$mod_strings['LBL_MAP_LEGEND'] = 'Legend:';
$mod_strings['LBL_MAP_USER_GROUPS'] = 'Groups:';
$mod_strings['LBL_MAP_GROUP'] = 'Group';
$mod_strings['LBL_MAP_TYPE'] = 'Type';
$mod_strings['LBL_MAP_ASSIGNED_TO'] = 'Assigned to:';
$mod_strings['LBL_MAP_GET_DIRECTIONS'] = 'Get Directions';
$mod_strings['LBL_MAP_GOOGLE_MAPS_VIEW'] = 'Google Maps View';

$mod_strings['LNK_NEW_MAP'] = 'Add New Map';
$mod_strings['LNK_NEW_RECORD'] = 'Add New Map';
$mod_strings['LNK_MAP_LIST'] = 'List Maps';

$mod_strings['LBL_MAP_ADDRESS_TEST'] = 'Geocoding Test';
$mod_strings['LBL_MAP_QUICK_RADIUS'] = 'Quick Radius Map';
$mod_strings['LBL_MAP_NULL_GROUP_NAME'] = 'None';
$mod_strings['LBL_MAP_ADDRESS'] = 'Address';
$mod_strings['LBL_MAP_PROCESS'] = 'Process It!';

$mod_strings['LBL_MAP_LAST_STATUS'] = 'Last Geocode Status';
$mod_strings['LBL_GEOCODED_COUNTS'] = 'Module Geocoded Counts';
$mod_strings['LBL_CRON_URL'] = 'Cron URL:';
$mod_strings['LBL_MODULE_HEADING'] = 'Module';
$mod_strings['LBL_MODULE_TOTAL_HEADING'] = 'Total';
$mod_strings['LBL_MODULE_RESET_HEADING'] = 'Reset';
$mod_strings['LBL_GEOCODED_COUNTS_DESCRIPTION'] = 'The table shown belown shows the number of module objects geocoded, grouped by geocoding response. Keep in mind that the standard Google Maps usage limit is 2500 requests per day . This module will cache the addresses geocoding information during processing to reduce the overall number of requests needed.';

$mod_strings['LBL_CRON_INSTRUCTIONS'] = 'To process the geocoding requests it is recommended to setup a nightly Cron-Job. A custom entry point has been created for this purpose and can be accessed without authentication. The URL shown below is meant to be used with an Administrative Scheduled Task. Please see the documentation for more information.';
$mod_strings['LBL_EXPORT_ADDRESS_URL'] = 'Export URLs';
$mod_strings['LBL_EXPORT_INSTRUCTIONS'] = 'Use the links below to export full addresses in need of geocodeing information. Then use an online or offline batch geocoding tool to geocode the addresses. When you are finished geocoding, import the addresses into the Address Cache module to be used with your maps. Note, the Address Cache module is optional. All geocoding information is stored in the representative module.';
$mod_strings['LBL_ADDRESS_CACHE'] = 'Address Cache';
$mod_strings['LBL_ADD_TO_TARGET_LIST'] = 'Add to Target List';
$mod_strings['LBL_ADD_TO_TARGET_LIST_PROCESSING'] = 'Processing...';


$mod_strings['LBL_CONFIG_TITLE'] = 'Configuration Settings';
$mod_strings['LBL_CONFIG_SAVED'] = 'Settings Saved Successfully!';
$mod_strings['LBL_BILLING_ADDRESS'] = 'Billing Address';
$mod_strings['LBL_SHIPPING_ADDRESS'] = 'Shipping Address';
$mod_strings['LBL_PRIMARY_ADDRESS'] = 'Primary Address';
$mod_strings['LBL_ALTERNATIVE_ADDRESS'] = 'Alternative Address';
$mod_strings['LBL_ADDRESS_FLEX_RELATE'] = 'Flex Relate';
$mod_strings['LBL_ADDRESS_ADDRESS'] = 'Address (Simple, Users)';
$mod_strings['LBL_ADDRESS_CUSTOM'] = 'Custom (Custom Controller Logic)';
$mod_strings['LBL_ENABLED'] = 'Enabled';
$mod_strings['LBL_DISABLED'] = 'Disabled';
$mod_strings['LBL_DEFAULT'] = 'Default:';
$mod_strings['LBL_CONFIG_DEFAULT'] = 'Default:';

$mod_strings['LBL_CONFIG_VALID_GEOCODE_MODULES'] = 'Valid Geocode Modules:';
$mod_strings['LBL_CONFIG_VALID_GEOCODE_TABLES'] = 'Valid Geocode Tables:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_SETTINGS_TITLE'] = "Address Type Settings: This defines the modules' address types used when geocoding addresses. Acceptable Values: 'billing'; 'shipping'; 'primary'; 'alt'; 'flex_relate'";
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR'] = 'Address Type for ';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_ACCOUNTS'] = 'Address Type for Accounts:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_CONTACTS'] = 'Address Type for Contacts:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_LEADS'] = 'Address Type for Leads:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_OPPORTUNITIES'] = 'Address Type for Opportunities:';
$mod_strings['LBL_CONFIG_OF_RELATED_ACCOUNT'] = '(of Related Account)';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_CASES'] = 'Address Type for Cases:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_PROJECTS'] = 'Address Type for Projects:';
$mod_strings['LBL_CONFIG_OF_RELATED_ACCOUNT_OPPORTUNITY'] = '(of Related Account/Opportunity)';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_MEETINGS'] = 'Address Type for Meetings:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_PROSPECTS'] = 'Address Type for Prospects/Targets:';
$mod_strings['LBL_CONFIG_RELATED_OBJECT_THRU_FLEX_RELATE'] = 'Related Object thru Flex Relate Field';

$mod_strings['LBL_CONFIG_MARKER_GROUP_FIELD_SETTINGS_TITLE'] = "Marker Group Field Settings: This defines the 'field' to be used as the group parameter when displaying markers on a map. Examples: assigned_user_name, industry, status, sales_stage, priority";
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR'] = 'Group Field for ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_ACCOUNTS'] = 'Group Field for Accounts:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_CONTACTS'] = 'Group Field for Contacts:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_LEADS'] = 'Group Field for Leads:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_OPPORTUNITIES'] = 'Group Field for Opportunities:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_CASES'] = 'Group Field for Cases:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_PROJECTS'] = 'Group Field for Projects:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_MEETINGS'] = 'Group Field for Meetings:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_PROSPECTS'] = 'Group Field for  Prospects/Targets:';

$mod_strings['LBL_CONFIG_GEOCODING_SETTINGS_TITLE'] = 'Geocoding/Google Settings:';
$mod_strings['LBL_CONFIG_GEOCODING_API_URL_TITLE'] = 'Geocoding API URL:';
$mod_strings['LBL_CONFIG_GEOCODING_API_URL_DESC'] = 'The URL of the Google Maps API V3 or Proxy';
$mod_strings['LBL_CONFIG_GEOCODING_API_SECRET_TITLE'] = 'Secret Phrase for Proxy:';
$mod_strings['LBL_CONFIG_GEOCODING_API_SECRET_DESC'] = 'The Secret Phrase to be used with the Proxy MD5 comparison.';
$mod_strings['LBL_CONFIG_GEOCODING_LIMIT_TITLE'] = 'Geocoding Limit:';
$mod_strings['LBL_CONFIG_GEOCODING_LIMIT_DESC'] = "'geocoding_limit' sets the query limit when selecting records to geocode.";
$mod_strings['LBL_CONFIG_GOOGLE_GEOCODING_LIMIT_TITLE'] = 'Google Geocoding Limit:';
$mod_strings['LBL_CONFIG_GOOGLE_GEOCODING_LIMIT_DESC'] = "'google_geocoding_limit' sets the request limit when geocoding using the Google Maps API.";
$mod_strings['LBL_CONFIG_EXPORT_ADDRESSES_LIMIT_TITLE'] = 'Export Addresses Limit:';
$mod_strings['LBL_CONFIG_EXPORT_ADDRESSES_LIMIT_DESC'] = "'export_addresses_limit' sets the query limit when selecting records to export.";
$mod_strings['LBL_CONFIG_ALLOW_APPROXIMATE_LOCATION_TYPE_TITLE'] = "Allow 'APPROXIMATE' Location Types:";
$mod_strings['LBL_CONFIG_ALLOW_APPROXIMATE_LOCATION_TYPE_DESC'] = "'allow_approximate_location_type' - allows location types of 'APPROXIMATE' to be considered 'OK' geocoding results.";

$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SETTINGS_TITLE'] = 'Address Cache Settings:';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_GET_ENABLED_TITLE'] = 'Enable Address Cache (Get):';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_GET_ENABLED_DESC'] = "'address_cache_get_enabled' allows the address cache module to retrieve data from the cache table.";
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SAVE_ENABLED_TITLE'] = 'Enable Saving Address Cache (Save):';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SAVE_ENABLED_DESC'] = "'address_cache_save_enabled' allows the address cache module to save data to the cache table.";

$mod_strings['LBL_CONFIG_LOGIC_HOOKS_SETTINGS_TITLE'] = 'Logic Hooks Setting:';
$mod_strings['LBL_CONFIG_LOGIC_HOOKS_ENABLED_TITLE'] = 'Enable All Logic Hooks: ';
$mod_strings['LBL_CONFIG_LOGIC_HOOKS_ENABLED_DESC'] = "'logic_hooks_enabled' allows logic hooks for automatic updating based on related objects. It is recommended to disable when upgrading your SuiteCRM.";

$mod_strings['LBL_CONFIG_MARKER_MAPPING_SETTINGS_TITLE'] = 'Marker/Mapping Settings:';
$mod_strings['LBL_CONFIG_MAP_MARKERS_LIMIT_TITLE'] = "Map Markers Limit:";
$mod_strings['LBL_CONFIG_MAP_MARKERS_LIMIT_DESC'] = "'map_markers_limit' sets the query limit when selecting records to display on a map.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LATITUDE_TITLE'] = "Map Default Center Latitude:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LATITUDE_DESC'] = "'map_default_center_latitude' sets the default center latitude position for maps.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LONGITUDE_TITLE'] = "Map Default Center Longitude:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LONGITUDE_DESC'] = "'map_default_center_longitude' sets the default center longitude position for maps.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_UNIT_TYPE_TITLE'] = "Map Default Unit Type:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_UNIT_TYPE_DESC'] = "'map_default_unit_type' sets the default unit measurement type for distance calculations. Values: 'mi' (miles) or 'km' (kilometers).";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_DISTANCE_TITLE'] = "Map Default Distance:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_DISTANCE_DESC'] = "'map_default_distance' sets the default distance used for distance based maps.";
$mod_strings['LBL_CONFIG_MAP_DUPLICATE_MARKER_ADJUSTMENT_TITLE'] = "Map Duplicate Marker Adjustment:";
$mod_strings['LBL_CONFIG_MAP_DUPLICATE_MARKER_ADJUSTMENT_DESC'] = "'map_duplicate_marker_adjustment' sets an offset adjustment to be added to longitude and latitude in case of duplicate marker position.";
$mod_strings['LBL_CONFIG_MAP_CLUSTER_GRID_SIZE_TITLE'] = "Map Markers Clusterer Grid Size:";
$mod_strings['LBL_CONFIG_MAP_CLUSTER_GRID_SIZE_DESC'] = "'map_clusterer_grid_size' is used to set the grid size for calculating map clusterers.";
$mod_strings['LBL_CONFIG_MAP_MARKERS_CLUSTERER_MAX_ZOOM_TITLE'] = "Map Markers Clusterer Max Zoom:";
$mod_strings['LBL_CONFIG_MAP_MARKERS_CLUSTERER_MAX_ZOOM_DESC'] = "'map_clusterer_max_zoom' is used to set the maximum zoom level at which clustering will not be applied.";
$mod_strings['LBL_CONFIG_CUSTOM_CONTROLLER_DESC'] = "Important Note: All saved settings can be found in the 'config' table under category 'jjwg'. Note, a custom controller.php file should no longer be used to override settings.";
$mod_strings['LBL_JJWG_MAPS_JJWG_AREAS_FROM_JJWG_AREAS_TITLE'] = 'Areas';
$mod_strings['LBL_JJWG_MAPS_JJWG_MARKERS_FROM_JJWG_MARKERS_TITLE'] = 'Markers';
$mod_strings['LBL_PARENT_ID'] = 'Parent ID';
$mod_strings['LBL_JJWP_PARTNERS'] = 'JJWP Partners';
$mod_strings['LBL_GET_GOOGLE_API_KEY'] = 'Get A Key';
$mod_strings['LBL_GOOGLE_API_KEY'] = 'Google Api Key';
$mod_strings['LBL_ERROR_NO_GOOGLE_API_KEY'] = 'Please set the Google Api Key in the Google Maps Administrative Panel.';
