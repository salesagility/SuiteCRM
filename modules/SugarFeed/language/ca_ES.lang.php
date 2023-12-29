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
    'LBL_ASSIGNED_TO_ID' => 'ID Usuari Assignat',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creació',
    'LBL_DATE_MODIFIED' => 'Data de Modificació',
    'LBL_MODIFIED' => 'Modificat Per',
    'LBL_MODIFIED_NAME' => 'Modificat Per Nom',
    'LBL_CREATED' => 'Creat Per',
    'LBL_DESCRIPTION' => 'Descripció',
    'LBL_DELETED' => 'Eliminat',
    'LBL_NAME' => 'Nom',
    'LBL_SAVING' => 'Guardant...',
    'LBL_SAVED' => 'Guardat',
    'LBL_CREATED_USER' => 'Creat Per Usuari',
    'LBL_MODIFIED_USER' => 'Modificat Per Usuari',
    'LBL_LIST_FORM_TITLE' => 'Llista Feed',
    'LBL_MODULE_NAME' => 'Fluxos d\'activitat',
    'LBL_MODULE_TITLE' => 'Fluxos d\'activitat',
    'LBL_DASHLET_DISABLED' => 'Avis: El sistema Feed està deshabilitat, no s\'enviaran noves entrades de feeds fins que sigui activat',
    'LBL_RECORDS_DELETED' => 'Totes les entrades anteriors de Feed s\'han tret, si el sistema SuiteCRM Feed està habilitat, es generaran noves entrades automàticament.',
    'LBL_CONFIRM_DELETE_RECORDS' => 'Està segur de que vol esborrar totes les entrades de Feed?',
    'LBL_FLUSH_RECORDS' => 'Esborrar Entrades de Feed',
    'LBL_ENABLE_FEED' => 'Permetre la meva activitat corrent Dashlet',
    'LBL_ENABLE_MODULE_LIST' => 'Activar Feeds Per a',
    'LBL_HOMEPAGE_TITLE' => 'Flux d\'Activitat',
    'LNK_NEW_RECORD' => 'Nou Feed',
    'LNK_LIST' => 'Feed',
    'LBL_SEARCH_FORM_TITLE' => 'Cercar Feed',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Veure Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_NEW_FORM_TITLE' => 'Nou Feed',
    'LBL_ALL' => 'Tot',
    'LBL_USER_FEED' => 'Feed d\'Usuari',
    'LBL_ENABLE_USER_FEED' => 'Activar Feed d\'Usuari',
    'LBL_TO' => 'Enviar A',
    'LBL_IS' => 'es',
    'LBL_DONE' => 'Fet',
    'LBL_TITLE' => 'Títol',
    'LBL_ROWS' => 'Files',
    'LBL_CATEGORIES' => 'Mòduls',
    'LBL_TIME_LAST_WEEK' => 'Última Setmana',
    'LBL_TIME_WEEKS' => 'setmanes',
    'LBL_TIME_DAY' => 'dia', // PR 6080
    'LBL_TIME_DAYS' => 'dies',
    'LBL_TIME_YESTERDAY' => 'Ahir',
    'LBL_TIME_HOURS' => 'Hores',
    'LBL_TIME_HOUR' => 'Hores',
    'LBL_TIME_MINUTES' => 'Minuts',
    'LBL_TIME_MINUTE' => 'Minut',
    'LBL_TIME_SECONDS' => 'Segons',
    'LBL_TIME_SECOND' => 'Segon',
    'LBL_TIME_AND' => 'i',
    'LBL_TIME_AGO' => 'fa',
// Activity stream
    'CREATED_CONTACT' => 'creat un <b>NOU</b> {0}',
    'CREATED_OPPORTUNITY' => 'creada una <b>NOVA</b> {0}',
    'CREATED_CASE' => 'creat un <b>NOU</b> {0}',
    'CREATED_LEAD' => 'creat un <b>NOU</b> {0}',
    'FOR' => 'per a', // Activity stream for cases
    'FOR_AMOUNT' => 'per la quantitat', // Activity stream for opportunity
    'CLOSED_CASE' => '<b>TANCAT</b> un cas ',
    'CONVERTED_LEAD' => '<b>CONVERTIT</b> un client potencial',
    'WON_OPPORTUNITY' => 'ha <b>GUANYAT</b> una oportunitat',
    'WITH' => 'amb',

    'LBL_LINK_TYPE_Link' => 'Enllaç',
    'LBL_LINK_TYPE_Image' => 'Imatge',
    'LBL_LINK_TYPE_YouTube' => 'YouTube&#153;',

    'LBL_SELECT' => 'Seleccionar',
    'LBL_POST' => 'Enviar',
    'LBL_AUTHENTICATE' => 'Connectar a',
    'LBL_AUTHENTICATION_PENDING' => 'No totes les comptes externes que ha seleccionat han estat autenticades. Faci clic a &#39;Cancel·lar&#39; per a tornar a la finestra d\'opcions per autenticar els comptes externs, o faci clic a &#39;Acceptar&#39; per a no autenticar les comptes.',
    'LBL_ADVANCED_SEARCH' => 'Filtre avançat' /*for 508 compliance fix*/,
    'LBL_SHOW_MORE_OPTIONS' => 'Mostrar més opcions',
    'LBL_HIDE_OPTIONS' => 'Oculta les opcions',
    'LBL_VIEW' => 'Veure',
    'LBL_POST_TITLE' => 'Publicar estat actualitzat per a',
    'LBL_URL_LINK_TITLE' => 'Enllaç URL a utilitzar',
);
