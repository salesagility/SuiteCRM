<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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

$mod_strings['LBL_MAP'] = 'Mapa';
$mod_strings['LBL_MODULE_NAME'] = 'Mapes';
$mod_strings['LBL_MODULE_TITLE'] = 'Mapes: Inici';
$mod_strings['LBL_MODULE_ID'] = 'Mapes';
$mod_strings['LBL_LIST_FORM_TITLE'] = 'Llistat de mapes';
$mod_strings['LBL_MAP_CUSTOM_MARKER'] = 'Marcador personalitzat';
$mod_strings['LBL_MAP_CUSTOM_AREA'] = 'Espai personalitzat';
$mod_strings['LBL_HOMEPAGE_TITLE'] = 'La meva llistat de mapes';

$mod_strings['LBL_FLEX_RELATE'] = 'Relacionat amb (Centre):';
$mod_strings['LBL_MODULE_TYPE'] = 'Tipus de mòdul a mostrar:';
$mod_strings['LBL_DISTANCE'] = 'Distància (Radi):';
$mod_strings['LBL_UNIT_TYPE'] = 'Tipus d\'unitat:';

$mod_strings['LBL_MAP_DISPLAY'] = 'Visualització del mapa';
$mod_strings['LBL_MAP_LEGEND'] = 'Llegenda:';
$mod_strings['LBL_MAP_USER_GROUPS'] = 'Grups:';
$mod_strings['LBL_MAP_GROUP'] = 'Grup';
$mod_strings['LBL_MAP_TYPE'] = 'Tipus';
$mod_strings['LBL_MAP_ASSIGNED_TO'] = 'Assignat a:';
$mod_strings['LBL_MAP_GET_DIRECTIONS'] = 'Obtenir indicacions';
$mod_strings['LBL_MAP_GOOGLE_MAPS_VIEW'] = 'Visualització de mapes de Google';

$mod_strings['LNK_NEW_MAP'] = 'Afegir un nou mapa';
$mod_strings['LNK_NEW_RECORD'] = 'Afegir un nou mapa';
$mod_strings['LNK_MAP_LIST'] = 'Llista de mapes';

$mod_strings['LBL_MAP_ADDRESS_TEST'] = 'Prova de geocodificació';
$mod_strings['LBL_MAP_QUICK_RADIUS'] = 'Quick Radius Map';
$mod_strings['LBL_MAP_NULL_GROUP_NAME'] = 'Res';
$mod_strings['LBL_MAP_ADDRESS'] = 'Adreça';
$mod_strings['LBL_MAP_PROCESS'] = 'Processar!';

$mod_strings['LBL_MAP_LAST_STATUS'] = 'Darrer estat de codificació geogràfica';
$mod_strings['LBL_GEOCODED_COUNTS'] = 'Módul de contes geocodificades';
$mod_strings['LBL_CRON_URL'] = 'URL de cron:';
$mod_strings['LBL_MODULE_HEADING'] = 'Mòdul';

$mod_strings['LBL_N/A'] = 'No disponible';
$mod_strings['LBL_ZERO_RESULTS'] = 'No hi ha resultats';
$mod_strings['LBL_OK'] = 'Ok';
$mod_strings['LBL_INVALID_REQUEST'] = 'Petició invàlida';
$mod_strings['LBL_APPROXIMATE'] = 'Aproximat';
$mod_strings['LBL_EMPTY'] = 'Buit';

$mod_strings['LBL_MODULE_TOTAL_HEADING'] = 'Total';
$mod_strings['LBL_MODULE_RESET_HEADING'] = 'Restablir';
$mod_strings['LBL_GEOCODED_COUNTS_DESCRIPTION'] = 'La taula següent mostra el nombre d\'objectes mòdul geolocalitzada, agrupats per resposta Geocodificació. Tingueu en compte que el límit de l\'ús de Google Maps estàndard és de 2500 sol·licituds per dia. Aquest mòdul amagatall de voluntat la informació Geocodificació de les adreces durant el processat per reduir el nombre total de sol·licituds necessàries.';

$mod_strings['LBL_CRON_INSTRUCTIONS'] = 'Per tramitar les sol. licituds Geocodificació es recomana configurar una feina de Cron cada nit. Un punt d\'entrada costum s\'ha creat a aquest efecte i es pot accedir sense autenticació. L\'URL següent està destinat a ser utilitzat amb un planificat tasca administrativa. Si us plau, vegeu la documentació per a més informació.';
$mod_strings['LBL_EXPORT_ADDRESS_URL'] = 'Exportar URLs';
$mod_strings['LBL_EXPORT_INSTRUCTIONS'] = 'Utilitzeu els següents enllaços per exportar adreces complets que necessiten informació geocodeing. Llavors utilitzar una eina en línia o offline lot Geocodificació Geocodifica les adreces. Quan hàgiu acabat Geocodificació, importar les adreces al mòdul d\'adreça memòria cau per utilitzar amb els seus mapes. Tingueu en compte que el mòdul d\'adreça memòria cau és opcional. Tota la informació Geocodificació s\'emmagatzema en el mòdul representatiu.';
$mod_strings['LBL_ADDRESS_CACHE'] = 'Caché de direccions';
$mod_strings['LBL_ADD_TO_TARGET_LIST'] = 'afegir a la llista de destinacions';
$mod_strings['LBL_ADD_TO_TARGET_LIST_PROCESSING'] = 'Processant...';


$mod_strings['LBL_CONFIG_TITLE'] = 'Configuració';
$mod_strings['LBL_CONFIG_SAVED'] = 'Configuracions desades amb èxit!';
$mod_strings['LBL_BILLING_ADDRESS'] = 'Direcció facturació';
$mod_strings['LBL_SHIPPING_ADDRESS'] = 'Direcció d\'Enviament';
$mod_strings['LBL_PRIMARY_ADDRESS'] = 'Direcció principal';
$mod_strings['LBL_ALTERNATIVE_ADDRESS'] = 'Direcció alternativa';
$mod_strings['LBL_ADDRESS_FLEX_RELATE'] = 'Possiblement relacionat amb ';
$mod_strings['LBL_ADDRESS_ADDRESS'] = 'adreces (simple, usuari)';
$mod_strings['LBL_ADDRESS_CUSTOM'] = 'Modificació (Modificar la lògica del controlador)';
$mod_strings['LBL_ENABLED'] = 'Habilitat';
$mod_strings['LBL_DISABLED'] = 'Deshabilitat';
$mod_strings['LBL_DEFAULT'] = 'Per defecte:';
$mod_strings['LBL_CONFIG_DEFAULT'] = 'Per defecte:';

$mod_strings['LBL_CONFIG_VALID_GEOCODE_MODULES'] = 'Mòduls vàlids geocodificats:';
$mod_strings['LBL_CONFIG_VALID_GEOCODE_TABLES'] = 'Taules vàlides geocodificades:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_SETTINGS_TITLE'] = "Configuració de tipus Adreça: Això defineix el tipus d'adreça dels mòduls, s'utilitza quan Geocodificació d'adreces. Valors acceptables: 'facturació'; 'enviament'; 'primeres'; \"alt\"; 'flex_relate'";
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR'] = 'Tipus d\'adreça per';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_ACCOUNTS'] = 'Tipus d\'adreces per a comptes:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_CONTACTS'] = 'Tipus d\'adreça per a contactes:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_LEADS'] = 'Tipus d\'adreça per a clients potencials:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_OPPORTUNITIES'] = 'Tipus d\'adreça per a oportunitats:';
$mod_strings['LBL_CONFIG_OF_RELATED_ACCOUNT'] = '(de Compta Relacionada)';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_CASES'] = 'Tipus d\'adreça per a casos:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_PROJECTS'] = 'Tipus d\'adreça per a projectes:';
$mod_strings['LBL_CONFIG_OF_RELATED_ACCOUNT_OPPORTUNITY'] = '(de Compta Relacionada/Oportunitat)';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_MEETINGS'] = 'Tipus d\'adreça per a reunions:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_PROSPECTS'] = 'tipus d\'adreces per a perspectives/objectius: ';
$mod_strings['LBL_CONFIG_RELATED_OBJECT_THRU_FLEX_RELATE'] = 'Objeectes relacionats a través del camp de relació flexible';

$mod_strings['LBL_CONFIG_MARKER_GROUP_FIELD_SETTINGS_TITLE'] = "Configuració del camp grup marcador: Indica el \"camp\" per ser utilitzat com paràmetre grup quan es veuen marcadors al mapa. Exemples: assigned_user_name, indústria, estatus, sales_stage, prioritat";
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR'] = 'camp grup per ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_ACCOUNTS'] = 'Camp d\'agrupament de compes: ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_CONTACTS'] = 'Camp d\'agrupament de contactes: ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_LEADS'] = 'Camp d\'agrupament de potencials clients: ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_OPPORTUNITIES'] = 'camp d\'agrupament d\'oportunitats: ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_CASES'] = 'camp d\'agrupametn pels casos: ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_PROJECTS'] = 'camp d\'agrupament de projectes: ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_MEETINGS'] = 'camp d\'agrupament de reunions: ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_PROSPECTS'] = 'camp d\'agrupament de perspectives/públic objectiu: ';

$mod_strings['LBL_CONFIG_GEOCODING_SETTINGS_TITLE'] = 'configuració de la geocodificació de google: ';
$mod_strings['LBL_CONFIG_GEOCODING_API_URL_TITLE'] = 'URL del API de geocodificació:';
$mod_strings['LBL_CONFIG_GEOCODING_API_URL_DESC'] = 'L\'URL de Google Maps API V3 o Proxy';
$mod_strings['LBL_CONFIG_GEOCODING_API_SECRET_TITLE'] = 'Frase secreta pel Proxy:';
$mod_strings['LBL_CONFIG_GEOCODING_API_SECRET_DESC'] = 'La frase secreta per ser utilitzat com la comparació Proxy MD5.';
$mod_strings['LBL_CONFIG_GEOCODING_LIMIT_TITLE'] = 'Límit de geocodificació:';
$mod_strings['LBL_CONFIG_GEOCODING_LIMIT_DESC'] = "'geocoding_limit' modifica la query límit quan sel·lecciona registres per geocodificar.";
$mod_strings['LBL_CONFIG_GOOGLE_GEOCODING_LIMIT_TITLE'] = 'Límit de geocodificació de Google:';
$mod_strings['LBL_CONFIG_GOOGLE_GEOCODING_LIMIT_DESC'] = "'google_geocoding_limit' modifica la petició límit quan l'API de Google Maps utilitza geocodificació.";
$mod_strings['LBL_CONFIG_EXPORT_ADDRESSES_LIMIT_TITLE'] = 'Exportar el límit d\'adreces';
$mod_strings['LBL_CONFIG_EXPORT_ADDRESSES_LIMIT_DESC'] = "'export_addresses_limit' modifica la query límit quan sel·lecciona registres per exportar.";
$mod_strings['LBL_CONFIG_ALLOW_APPROXIMATE_LOCATION_TYPE_TITLE'] = "Permet a 'APROXIMATE' el tipus ubicació: ";
$mod_strings['LBL_CONFIG_ALLOW_APPROXIMATE_LOCATION_TYPE_DESC'] = "'allow_approximate_location_type' - permet al tipus ubicació de 'APROXIMATE' el ser considerat 'OK' per a resultats geocodificats.";

$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SETTINGS_TITLE'] = 'configuració d\'adreces de la memòria cau: ';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_GET_ENABLED_TITLE'] = 'Habilita ,a memòria cau d\'adreces (Get):';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_GET_ENABLED_DESC'] = "address_cache_get_enabled' permet al módul de memòria cau d'adreces el recuperar informació de la taula de la memòria cau.";
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SAVE_ENABLED_TITLE'] = 'Habilita el guardat de la memòria cau d\'adreces (Save): ';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SAVE_ENABLED_DESC'] = "'address_cache_save_enabled' permet al módul de la memòria cau d'adreces el guardar informació a la taula de la memòria cau.";

$mod_strings['LBL_CONFIG_LOGIC_HOOKS_SETTINGS_TITLE'] = 'configuració de la lògica Hooks: ';
$mod_strings['LBL_CONFIG_LOGIC_HOOKS_ENABLED_TITLE'] = 'Habilitat totes les lògiques Hooks: ';
$mod_strings['LBL_CONFIG_LOGIC_HOOKS_ENABLED_DESC'] = "'logic_hooks_enabled' permet a les lògiques hooks el fer actualitzacions automàtiques basades en els objectes relacionats. Es recomana deshabilitar quan s'actualitza SuiteCRM.";

$mod_strings['LBL_CONFIG_MARKER_MAPPING_SETTINGS_TITLE'] = 'configuració de marcadors/mapes: ';
$mod_strings['LBL_CONFIG_MAP_MARKERS_LIMIT_TITLE'] = "Límit de marcadors de mapa:";
$mod_strings['LBL_CONFIG_MAP_MARKERS_LIMIT_DESC'] = "'map_markers_limit' modifica la query límit quan sel·lecciona registres per mostrar al mapa.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LATITUDE_TITLE'] = "Latitud per defecte en els mapes:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LATITUDE_DESC'] = "'map_default_center_latitude' modifica la latitud central per defecte a la posició dels mapes.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LONGITUDE_TITLE'] = "Longitud per defecte en els mapes:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LONGITUDE_DESC'] = "'map_default_center_longitude' modifica la longitud central per defecte als mapes.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_UNIT_TYPE_TITLE'] = "Tipus d'unitat per defecte als mapes";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_UNIT_TYPE_DESC'] = "'map_default_unit_type' modifica el tipus d'unitat de mesura per defecte pels càlculs. Valors: 'mi' (milles) o 'km' (kilòmetres).";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_DISTANCE_TITLE'] = "Distància per defecte en els mapes:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_DISTANCE_DESC'] = "'map_default_distance' modifica l'unitat de mesura per defecte utilitzada per les distàncies.";
$mod_strings['LBL_CONFIG_MAP_DUPLICATE_MARKER_ADJUSTMENT_TITLE'] = "Configuració de marcador de mapa duplicat:";
$mod_strings['LBL_CONFIG_MAP_DUPLICATE_MARKER_ADJUSTMENT_DESC'] = "'map_duplicate_marker_adjustment' modifica un ajust de offset per ser agregat a la longitud i latitud en cas de posició de marcadar duplicada.";
$mod_strings['LBL_CONFIG_MAP_CLUSTER_GRID_SIZE_TITLE'] = "Mapa de marcadors Clusterer mida de Reixat:";
$mod_strings['LBL_CONFIG_MAP_CLUSTER_GRID_SIZE_DESC'] = "'map_clusterer_grid_size' s'utilitza per configurar la mida de Reixat per calcular al mapa clusterers.";
$mod_strings['LBL_CONFIG_MAP_MARKERS_CLUSTERER_MAX_ZOOM_TITLE'] = "Zoom màxim del clúster de marcadors: ";
$mod_strings['LBL_CONFIG_MAP_MARKERS_CLUSTERER_MAX_ZOOM_DESC'] = "'map_clusterer_max_zoom' s'utilitza per modificar el nivell màxim de zoom al que el clúster no aplica.";
$mod_strings['LBL_CONFIG_CUSTOM_CONTROLLER_DESC'] = "Nota important: totes les configuracions guardades poden ser trobades a la taula 'config' sota la categoria 'jjwg'. Nota, un controller.php configurat no pot ser utilitzar per sobrescriu-re previes configuracions.";
$mod_strings['LBL_JJWG_MAPS_JJWG_AREAS_FROM_JJWG_AREAS_TITLE'] = 'Àrees';
$mod_strings['LBL_JJWG_MAPS_JJWG_MARKERS_FROM_JJWG_MARKERS_TITLE'] = 'Marcadors';
$mod_strings['LBL_PARENT_ID'] = 'Id pare';
$mod_strings['LBL_JJWP_PARTNERS'] = 'JJWP socis';
$mod_strings['LBL_GET_GOOGLE_API_KEY'] = 'Aconseguir una clau';
$mod_strings['LBL_GOOGLE_API_KEY'] = 'Clau d\'Api de Google';
$mod_strings['LBL_ERROR_NO_GOOGLE_API_KEY'] = 'Establiu la clau de Google Api al Panell Administratiu de Google Maps.
';
