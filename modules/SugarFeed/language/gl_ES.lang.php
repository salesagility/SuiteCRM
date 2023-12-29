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

$mod_strings = array(
    'LBL_ASSIGNED_TO_ID' => 'Id de usuario asignado',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creación',
    'LBL_DATE_MODIFIED' => 'Data de Modificación',
    'LBL_MODIFIED' => 'Modificado Por',
    'LBL_MODIFIED_NAME' => 'Modificado Por Nome',
    'LBL_CREATED' => 'Creado Por',
    'LBL_DESCRIPTION' => 'Descrición',
    'LBL_DELETED' => 'Eliminado',
    'LBL_NAME' => 'Nome',
    'LBL_SAVING' => 'Gardando...',
    'LBL_SAVED' => 'Gardado',
    'LBL_CREATED_USER' => 'Creado polo Usuario',
    'LBL_MODIFIED_USER' => 'Modificado polo Usuario',
    'LBL_LIST_FORM_TITLE' => 'Lista Feed',
    'LBL_MODULE_NAME' => 'Fluxos de Actividade',
    'LBL_MODULE_TITLE' => 'Fluxos de Actividade',
    'LBL_DASHLET_DISABLED' => 'Aviso: o sistema SuiteCRM Feed está deshabilitado, non se enviarán novas entradas de feeds ata que sexa activado',
    'LBL_RECORDS_DELETED' => 'Todas as entradas anteriores de SuiteCRM Feed foron eliminadas, se o sistema SuiteCRM Feed está habilitado, xeraranse novas entradas automaticamente.',
    'LBL_CONFIRM_DELETE_RECORDS' => '¿Está seguro de que desexa eliminar todas as entradas de SuiteCRM Feed?',
    'LBL_FLUSH_RECORDS' => 'Eliminar Entradas de Feed',
    'LBL_ENABLE_FEED' => 'Habilitar Dashlet Meu Fluxo de Actividade',
    'LBL_ENABLE_MODULE_LIST' => 'Activar Feeds Para',
    'LBL_HOMEPAGE_TITLE' => 'O meu Fluxo de Actividade',
    'LNK_NEW_RECORD' => 'Crear SuiteCRM Feed',
    'LNK_LIST' => 'SuiteCRM Feed',
    'LBL_SEARCH_FORM_TITLE' => 'Buscar SuiteCRM Feed',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Ver Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_NEW_FORM_TITLE' => 'Novo SuiteCRM Feed',
    'LBL_ALL' => 'Todo',
    'LBL_USER_FEED' => 'Feed de Usuario',
    'LBL_ENABLE_USER_FEED' => 'Activar Feed de Usuario',
    'LBL_TO' => 'Enviar A Equipo',
    'LBL_IS' => 'é',
    'LBL_DONE' => 'Feito',
    'LBL_TITLE' => 'Título',
    'LBL_ROWS' => 'Filas',
    'LBL_CATEGORIES' => 'Módulos',
    'LBL_TIME_LAST_WEEK' => 'Última Semana',
    'LBL_TIME_WEEKS' => 'semanas',
    'LBL_TIME_DAY' => 'día', // PR 6080
    'LBL_TIME_DAYS' => 'días',
    'LBL_TIME_YESTERDAY' => 'Onte',
    'LBL_TIME_HOURS' => 'Horas',
    'LBL_TIME_HOUR' => 'Horas',
    'LBL_TIME_MINUTES' => 'Minutos',
    'LBL_TIME_MINUTE' => 'Minuto',
    'LBL_TIME_SECONDS' => 'Segundos',
    'LBL_TIME_SECOND' => 'Segundo',
    'LBL_TIME_AND' => 'e',
    'LBL_TIME_AGO' => 'atrás',
// Activity stream
    'CREATED_CONTACT' => 'creou un <b>NOVO</b> {0}',
    'CREATED_OPPORTUNITY' => 'creou unha <b>NOVA</b> {0}',
    'CREATED_CASE' => 'creou un <b>NOVO</b> {0}',
    'CREATED_LEAD' => 'creou un <b>NOVO</b> {0}',
    'FOR' => 'para', // Activity stream for cases
    'FOR_AMOUNT' => 'para a cantidade de', // Activity stream for opportunity
    'CLOSED_CASE' => '<b>CERRADO</b> un {0} ',
    'CONVERTED_LEAD' => '<b>CONVERTIDO</b> a {0}',
    'WON_OPPORTUNITY' => 'ha <b>GAÑADO</b> unha {0}',
    'WITH' => 'con',

    'LBL_LINK_TYPE_Link' => 'Enlace',
    'LBL_LINK_TYPE_Image' => 'Imaxe',
    'LBL_LINK_TYPE_YouTube' => 'YouTube&#153;',

    'LBL_SELECT' => 'Seleccionar',
    'LBL_POST' => 'Enviar',
    'LBL_AUTHENTICATE' => 'Conectar a',
    'LBL_AUTHENTICATION_PENDING' => 'Non todas as contas externas que seleccionou foron autenticadas. Faga click en &#39;Cancelar&#39; para regresar á ventá de Opcións para autenticar as contas externas, ou faga click en &#39;Ok&#39; para non autenticar as contas.',
    'LBL_ADVANCED_SEARCH' => 'Filtro avanzado' /*for 508 compliance fix*/,
    'LBL_SHOW_MORE_OPTIONS' => 'Mostrar Máis Opcións',
    'LBL_HIDE_OPTIONS' => 'Ocultar Opcións',
    'LBL_VIEW' => 'Ver',
    'LBL_POST_TITLE' => 'Publicar Estado Actualizado para',
    'LBL_URL_LINK_TITLE' => 'Link URL a utilizar',
);
