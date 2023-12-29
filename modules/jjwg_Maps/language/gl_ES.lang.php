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
$mod_strings['LBL_MODULE_NAME'] = 'Mapas';
$mod_strings['LBL_MODULE_TITLE'] = 'Mapas: Inicio';
$mod_strings['LBL_MODULE_ID'] = 'Mapas';
$mod_strings['LBL_LIST_FORM_TITLE'] = 'Mapas de Venda';
$mod_strings['LBL_MAP_CUSTOM_MARKER'] = 'Marcador';
$mod_strings['LBL_MAP_CUSTOM_AREA'] = 'Espazo';
$mod_strings['LBL_HOMEPAGE_TITLE'] = 'O meu listado de mapas';

$mod_strings['LBL_FLEX_RELATE'] = 'Relacionado á (Centro):';
$mod_strings['LBL_MODULE_TYPE'] = 'Tipo de módulo a visualizar:';
$mod_strings['LBL_DISTANCE'] = 'Distancia (Radio):';
$mod_strings['LBL_UNIT_TYPE'] = 'Tipo de Unidade:';

$mod_strings['LBL_MAP_DISPLAY'] = 'Visualización de Mapa';
$mod_strings['LBL_MAP_LEGEND'] = 'Lenda:';
$mod_strings['LBL_MAP_USER_GROUPS'] = 'Grupos de Usuarios:';
$mod_strings['LBL_MAP_GROUP'] = 'Grupo';
$mod_strings['LBL_MAP_TYPE'] = 'Tipo';
$mod_strings['LBL_MAP_ASSIGNED_TO'] = 'Asignado a:';
$mod_strings['LBL_MAP_GET_DIRECTIONS'] = 'Obter enderezos';
$mod_strings['LBL_MAP_GOOGLE_MAPS_VIEW'] = 'Vista de Mapas de Google';

$mod_strings['LNK_NEW_MAP'] = 'Engadir Novo Mapa';
$mod_strings['LNK_NEW_RECORD'] = 'Engadir Novo Mapa';
$mod_strings['LNK_MAP_LIST'] = 'Mapas Lista';

$mod_strings['LBL_MAP_ADDRESS_TEST'] = 'Proba de Xeocodificación';
$mod_strings['LBL_MAP_QUICK_RADIUS'] = 'Mapa Radio rápida';
$mod_strings['LBL_MAP_NULL_GROUP_NAME'] = 'Nada';
$mod_strings['LBL_MAP_ADDRESS'] = 'Enderezo';
$mod_strings['LBL_MAP_PROCESS'] = 'Se Proceso!';

$mod_strings['LBL_MAP_LAST_STATUS'] = 'Estado Geocode Última';
$mod_strings['LBL_GEOCODED_COUNTS'] = 'Módulo Condes Xeocodificadas';
$mod_strings['LBL_CRON_URL'] = 'Cron URL:';
$mod_strings['LBL_MODULE_HEADING'] = 'Módulo';

$mod_strings['LBL_N/A'] = 'Non dispoñible';
$mod_strings['LBL_ZERO_RESULTS'] = 'Non hai resultados';
$mod_strings['LBL_OK'] = 'Ok';
$mod_strings['LBL_INVALID_REQUEST'] = 'Solicitude non válida';
$mod_strings['LBL_APPROXIMATE'] = 'Aproximado';
$mod_strings['LBL_EMPTY'] = 'Baleiro';

$mod_strings['LBL_MODULE_TOTAL_HEADING'] = 'Total';
$mod_strings['LBL_MODULE_RESET_HEADING'] = 'Restablecer';
$mod_strings['LBL_GEOCODED_COUNTS_DESCRIPTION'] = 'A táboa de abaixo mostra o número de obxectos de módulo xeocodificada, agrupados por resposta de xeocodificación. Teña en conta que o límite de uso estándar de mapas de Google é de 2500 solicitudes por día. Este módulo almacenará en caché a información da xeocodificación de enderezos durante o proceso para reducir o número total de solicitudes necesitada.';

$mod_strings['LBL_CRON_INSTRUCTIONS'] = 'Para procesar as solicitudes de xeocodificación recoméndase configurar unha tarefa programada cada noite. Un punto de entrada personalizado creouse para este propósito e pódese acceder sen autenticación. A URL que se mostra a continuación está destinada a utilizarse cunha tarefa administrativa prevista. Por favor, consulte a documentación para obter máis información.';
$mod_strings['LBL_EXPORT_ADDRESS_URL'] = 'Exportación de URLs';
$mod_strings['LBL_EXPORT_INSTRUCTIONS'] = 'Utilice os vínculos seguintes para exportar enderezos completos que necesitan información da ferramenta de xeocodeing. Logo utilizar unha ferramenta de xeocodificación de lote en liña ou sen conexión a xeocodificar os enderezos. Cando acabe a xeocodificación, importar os enderezos no módulo de caché de enderezo para ser utilizado cos mapas. Teña en conta que o módulo de caché de enderezo é opcional. Toda a información geocoding é almacenada no módulo representativo.';
$mod_strings['LBL_ADDRESS_CACHE'] = 'Caché de Enderezos';
$mod_strings['LBL_ADD_TO_TARGET_LIST'] = 'Engadir á Lista de destinos';
$mod_strings['LBL_ADD_TO_TARGET_LIST_PROCESSING'] = 'Tratamento...';


$mod_strings['LBL_CONFIG_TITLE'] = 'Configuración';
$mod_strings['LBL_CONFIG_SAVED'] = 'Configuracións Gardadas con Exito!';
$mod_strings['LBL_BILLING_ADDRESS'] = 'Enderezo de Facturación';
$mod_strings['LBL_SHIPPING_ADDRESS'] = 'Enderezo de Envío';
$mod_strings['LBL_PRIMARY_ADDRESS'] = 'Enderezo Primaria';
$mod_strings['LBL_ALTERNATIVE_ADDRESS'] = 'Enderezo alternativo';
$mod_strings['LBL_ADDRESS_FLEX_RELATE'] = 'Posiblemente Relacionado con';
$mod_strings['LBL_ADDRESS_ADDRESS'] = 'Enderezo (Simple, Usuarios)';
$mod_strings['LBL_ADDRESS_CUSTOM'] = 'Personalizado (Lóxica de Controlador Personalizado)';
$mod_strings['LBL_ENABLED'] = 'Habilitada';
$mod_strings['LBL_DISABLED'] = 'Deshabilitada';
$mod_strings['LBL_DEFAULT'] = 'Por Defecto:';
$mod_strings['LBL_CONFIG_DEFAULT'] = 'Por Defecto:';

$mod_strings['LBL_CONFIG_VALID_GEOCODE_MODULES'] = 'Módulos Xeocodificar válidos:';
$mod_strings['LBL_CONFIG_VALID_GEOCODE_TABLES'] = 'Táboas Xeocodificar válidos:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_SETTINGS_TITLE'] = "Configuración de tipo de Enderezo: Isto define os tipos de enderezos nos módulos que se desexan utilizar como enderezo a xeocodificar. Valores aceptables: 'billing'; 'shipping'; 'primary'; 'alt'; 'flex_relate'";
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR'] = 'Tipo de enderezo para ';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_ACCOUNTS'] = 'Tipos de enderezos para Contas:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_CONTACTS'] = 'Tipos de enderezos para Contacts:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_LEADS'] = 'Tipos de enderezos para Clientes Potenciais:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_OPPORTUNITIES'] = 'Tipos de enderezos para Oportunidades:';
$mod_strings['LBL_CONFIG_OF_RELATED_ACCOUNT'] = '(de Conta Relacionada)';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_CASES'] = 'Tipos de enderezos para Casos:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_PROJECTS'] = 'Tipos de enderezos para Proxectos:';
$mod_strings['LBL_CONFIG_OF_RELATED_ACCOUNT_OPPORTUNITY'] = '(de a Conta/Oportunidade relacionada)';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_MEETINGS'] = 'Tipos de enderezos para Reunións:';
$mod_strings['LBL_CONFIG_ADDRESS_TYPE_FOR_PROSPECTS'] = 'Tipos de enderezos para Prospectos/Público Obxectivo:';
$mod_strings['LBL_CONFIG_RELATED_OBJECT_THRU_FLEX_RELATE'] = 'Obxectos relacionados a través de campo de relación flexible';

$mod_strings['LBL_CONFIG_MARKER_GROUP_FIELD_SETTINGS_TITLE'] = "Seteo de Marcador de Campo de Agrupamento: Este define o 'campo' a ser utilizado como parámetro de grupo cando se mostran marcadores nun mapa. Exemplos: assigned_user_name, industry, status, sales_stage, priority";
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR'] = 'Campo de grupo para ';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_ACCOUNTS'] = 'Campo de Agrupamento para Contas:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_CONTACTS'] = 'Campo de Agrupamento para Contactos:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_LEADS'] = 'Campo de Agrupamento para Clientes Potenciais:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_OPPORTUNITIES'] = 'Campo de Agrupamento para Oportunidades:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_CASES'] = 'Campo de Agrupamento para Casos:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_PROJECTS'] = 'Campo de Agrupamento para para Proxectos:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_MEETINGS'] = 'Campo de Agrupamento para Reunións:';
$mod_strings['LBL_CONFIG_GROUP_FIELD_FOR_PROSPECTS'] = 'Campo de Agrupamento para Prospectos/Público Obxectivo:';

$mod_strings['LBL_CONFIG_GEOCODING_SETTINGS_TITLE'] = 'Configuración de Xeocodificación de Google:';
$mod_strings['LBL_CONFIG_GEOCODING_API_URL_TITLE'] = 'URL Xeocodificación API:';
$mod_strings['LBL_CONFIG_GEOCODING_API_URL_DESC'] = 'A URL de Google Maps API V3 ou Proxy';
$mod_strings['LBL_CONFIG_GEOCODING_API_SECRET_TITLE'] = 'Frase secreta para Proxy:';
$mod_strings['LBL_CONFIG_GEOCODING_API_SECRET_DESC'] = 'A frase secreta para ser utilizado coa comparación MD5 Proxy.';
$mod_strings['LBL_CONFIG_GEOCODING_LIMIT_TITLE'] = 'Límite de Xeocodificación:';
$mod_strings['LBL_CONFIG_GEOCODING_LIMIT_DESC'] = "'geocoding_limit' establece o límite de consultas cando se seleccionan rexistros para xeocodificar.";
$mod_strings['LBL_CONFIG_GOOGLE_GEOCODING_LIMIT_TITLE'] = 'Límite de Xeocodificación de Google:';
$mod_strings['LBL_CONFIG_GOOGLE_GEOCODING_LIMIT_DESC'] = "'google_geocoding_limit' establece o límite de solicitudes cando se usan as APIs de Google Maps API.";
$mod_strings['LBL_CONFIG_EXPORT_ADDRESSES_LIMIT_TITLE'] = 'Exporta o límite de Enderezos:';
$mod_strings['LBL_CONFIG_EXPORT_ADDRESSES_LIMIT_DESC'] = "'export_addresses_limit' establece o limite de consultas cando se selecciones rexistros para exportar.";
$mod_strings['LBL_CONFIG_ALLOW_APPROXIMATE_LOCATION_TYPE_TITLE'] = "Permitir a 'APPROXIMATE' Ubicación Tipos:";
$mod_strings['LBL_CONFIG_ALLOW_APPROXIMATE_LOCATION_TYPE_DESC'] = "'allow_approximate_location_type' - permite que os tipos de ubicación de 'APPROXIMATE' a ter en conta os resultados de xeocodificación 'OK'.";

$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SETTINGS_TITLE'] = 'Seteos de Caché de Enderezos:';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_GET_ENABLED_TITLE'] = 'Habilita o Cache de Enderezos (Get):';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_GET_ENABLED_DESC'] = "'address_cache_get_enabled' permite ao módulo de caché de enderezos recuperar datos da táboa de caché.";
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SAVE_ENABLED_TITLE'] = 'Habilita o gardado do Caché de Enderezos (Save):';
$mod_strings['LBL_CONFIG_ADDRESS_CACHE_SAVE_ENABLED_DESC'] = "'address_cache_save_enabled' permite que o módulo de caché de enderezos garde datos na táboa de caché.";

$mod_strings['LBL_CONFIG_LOGIC_HOOKS_SETTINGS_TITLE'] = 'Configuración de Logic Hooks:';
$mod_strings['LBL_CONFIG_LOGIC_HOOKS_ENABLED_TITLE'] = 'Habilita todos os Logic Hooks: ';
$mod_strings['LBL_CONFIG_LOGIC_HOOKS_ENABLED_DESC'] = "'logic_hooks_enabled' permite que os logic hooks actualicen automaticamente baseado nos obxectos relacionados. Recoméndase deshabilitar cando se actualiza SuiteCRM.";

$mod_strings['LBL_CONFIG_MARKER_MAPPING_SETTINGS_TITLE'] = 'Configuración de Marcadores/Mapas:';
$mod_strings['LBL_CONFIG_MAP_MARKERS_LIMIT_TITLE'] = "Límite de Marcadores de Mapa:";
$mod_strings['LBL_CONFIG_MAP_MARKERS_LIMIT_DESC'] = "'map_markers_limit' establece o límite de consulta cando se seleccionan rexistros para mostrar nun mapa.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LATITUDE_TITLE'] = "Latitude Central por defecto nos Mapas:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LATITUDE_DESC'] = "'map_default_center_latitude' establece a latitude central por defecto para os mapas.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LONGITUDE_TITLE'] = "Lonxitude Central por defecto nos Mapas:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_CENTER_LONGITUDE_DESC'] = "'map_default_center_longitude' establece a lonxitude central por defecto para os for mapas.";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_UNIT_TYPE_TITLE'] = "Tipo de Unidade por defecto nos Mapas:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_UNIT_TYPE_DESC'] = "'map_default_unit_type' establece o tipo de unidade de medida por defecto para os calculos. Valores: 'mi' (millas) or 'km' (kilometros).";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_DISTANCE_TITLE'] = "Distancia por defecto nos Mapas:";
$mod_strings['LBL_CONFIG_MAP_DEFAULT_DISTANCE_DESC'] = "'map_default_distance' establece a unidade de meddida por defecto utilizada para as distancias.";
$mod_strings['LBL_CONFIG_MAP_DUPLICATE_MARKER_ADJUSTMENT_TITLE'] = "Axuste de marca duplicada:";
$mod_strings['LBL_CONFIG_MAP_DUPLICATE_MARKER_ADJUSTMENT_DESC'] = "'map_duplicate_marker_adjustment' establece un axuste de offset para ser agregado á lonxitude e latitude en caso de posición de marcador duplicada.";
$mod_strings['LBL_CONFIG_MAP_CLUSTER_GRID_SIZE_TITLE'] = "Tamaño de Grilla de Marcadores de Clusters:";
$mod_strings['LBL_CONFIG_MAP_CLUSTER_GRID_SIZE_DESC'] = "'map_clusterer_grid_size' é usado para establecer o tamaño da grilla para calcular os clusters de mapas.";
$mod_strings['LBL_CONFIG_MAP_MARKERS_CLUSTERER_MAX_ZOOM_TITLE'] = "Zoom máximo de Markers Clusters:";
$mod_strings['LBL_CONFIG_MAP_MARKERS_CLUSTERER_MAX_ZOOM_DESC'] = "'map_clusterer_max_zoom' é usado para establecer o nivel máximo de zoom  ao cal o clusterizado non se aplica.";
$mod_strings['LBL_CONFIG_CUSTOM_CONTROLLER_DESC'] = "Nota Importante: Todas as configuracións gardadas poden ser encontradas na táboa 'config' bao a categoría 'jjwg'. Nota: a utilización do arquivo 'controller.php' personalizado para ignorar as configuracións, queda obsoleto a partir de agora.";
$mod_strings['LBL_JJWG_MAPS_JJWG_AREAS_FROM_JJWG_AREAS_TITLE'] = 'Map Áreas';
$mod_strings['LBL_JJWG_MAPS_JJWG_MARKERS_FROM_JJWG_MARKERS_TITLE'] = 'Marcadores';
$mod_strings['LBL_PARENT_ID'] = 'ID Pai';
$mod_strings['LBL_JJWP_PARTNERS'] = 'Socios JJWP';
$mod_strings['LBL_GET_GOOGLE_API_KEY'] = 'Obter unha clave';
$mod_strings['LBL_GOOGLE_API_KEY'] = 'Google Api Key';
$mod_strings['LBL_ERROR_NO_GOOGLE_API_KEY'] = 'Por favor seleccione o Google Api Key no Panel administrativo de mapas de Google.';
