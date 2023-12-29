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
    'LBL_ASSIGNED_TO_NAME' => 'Director del projecte',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creació',
    'LBL_DATE_MODIFIED' => 'Última Modificació',
    'LBL_MODIFIED' => 'Modificat Per',
    'LBL_MODIFIED_NAME' => 'Modificat per Nom',
    'LBL_CREATED' => 'Creat Per',
    'LBL_DELETED' => 'Esborrat',
    'LBL_NAME' => 'Nom de Plantilla',
    'LBL_CREATED_USER' => 'Creat per Usuari',
    'LBL_MODIFIED_USER' => 'Modificat per Usuari',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_EDIT_BUTTON' => 'Editar',
    'LBL_REMOVE' => 'Eliminar',
    'LBL_LIST_FORM_TITLE' => 'Llista de plantilles de projecte',
    'LBL_MODULE_NAME' => 'Plantilles de Projecte',
    'LBL_MODULE_TITLE' => 'Plantilles de Projecte',
    'LBL_HOMEPAGE_TITLE' => 'Les meves plantilles de projectes',
    'LNK_NEW_RECORD' => 'Crear plantilles de projecte',
    'LNK_LIST' => 'Veure plantilles de projecte',
    'LNK_IMPORT_AM_PROJECTTEMPLATES' => 'Importar plantilles de projectes',
    'LBL_SEARCH_FORM_TITLE' => 'Cercar plantilles de projecte',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Veure Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_NEW_FORM_TITLE' => 'Noves plantilles de projecte',
    'LBL_STATUS' => 'Estat',
    'LBL_PRIORITY' => 'Prioritat',
    'LBL_PROJECT_NAME' => 'Nom de Projecte',
    'LBL_START_DATE' => 'Data d\'inici',
    'LBL_CREATE_PROJECT_TITLE' => 'Crear un nou projecte a partir d\'aquesta plantilla?',
    'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_TASKTEMPLATES_TITLE' => 'Plantilles de tasca',
    'LBL_AM_PROJECTTEMPLATES_USERS_1_TITLE' => 'Usuaris',
    'LBL_AM_PROJECTTEMPLATES_CONTACTS_1_TITLE' => 'Contactes',
    'LBL_AM_PROJECTTEMPLATES_RESOURCES_TITLE' => 'Seleccionar recursos',
    'LBL_NEW_PROJECT_CREATED' => 'Nou projecte creat',
    'LBL_NEW_PROJECT' => 'Crear Projecte',
    'LBL_CANCEL_PROJECT' => 'Cancelar',

    'LBL_SUBTASK' => 'Tasques',
    'LBL_MILESTONE_FLAG' => 'Fita',
    'LBL_RELATIONSHIP_TYPE' => 'Tipus de relació',
    'LBL_LAG' => 'Retard',
    'LBL_DAYS' => 'Dies',
    'LBL_HOURS' => 'Hores',
    'LBL_MONTHS' => 'Messos',

    'LBL_PROJECT_TASKS_SUBPANEL_TITLE' => 'Tasques de Projecte',
    'LBL_VIEW_GANTT_TITLE' => 'Veure gantt',
    'LBL_VIEW_GANTT_DURATION' => 'Durada',
    'LBL_TASK_TITLE' => 'Editar tasca',
    'LBL_DURATION_TITLE' => 'Editar la durada',
    'LBL_DESCRIPTION' => 'Notes',
    'LBL_ASSIGNED_USER_ID' => 'Assignat A:',

    'LBL_LIST_ASSIGNED_USER' => 'Director del projecte',
    'LBL_UNASSIGNED' => 'No assignat',
    'LBL_PROJECT_USERS_1_FROM_USERS_TITLE' => 'Recursos',
    'LBL_DELETE_TASK' => 'Eliminar tasca',
    'LBL_VIEW_DETAIL' => 'Veure Detalls',
    'LBL_ADD_NEW_TASK' => 'Afegir nova tasca',
    'LBL_ASSIGNED_USER_NAME' => 'Cap del projecte:',

    'LBL_TASK_ID' => 'ID',
    'LBL_TASK_NAME' => 'Nom de Tasca',
    'LBL_DURATION' => 'Durada',
    'LBL_ACTUAL_DURATION' => 'Duració Real',
    'LBL_START' => 'Inici',
    'LBL_FINISH' => 'Finalitzar',
    'LBL_PREDECESSORS' => 'Anteriors',
    'LBL_PERCENT_COMPLETE' => '% Completat',
    'LBL_EDIT_TASK_PROPERTIES' => 'Editar les propietats de la tasca.',

    'LBL_OVERRIDE_BUSINESS_HOURS' => 'Considerar dies laborables',
    'LBL_COPY_ALL_TASKS' => 'Copiar totes les tasques amb recursos',
    'LBL_COPY_SEL_TASKS' => 'Copiar les tasques seleccionades amb recursos',
    'LBL_TOOLTIP_TITLE' => 'Consell',
    'LBL_TOOLTIP_TEXT' => 'Copia totes les tasques amb els usuaris assignats',

    'LBL_EMAIL' => 'Correu electrònic',
    'LBL_PHONE' => 'Telèfon d\'oficina:',
    'LBL_ADD_BUTTON' => 'Afegir',
    'LBL_ADD_INVITEE' => 'Afegeix un recurs',
    'LBL_FIRST_NAME' => 'Nom',
    'LBL_LAST_NAME' => 'Cognoms',
    'LBL_SEARCH_BUTTON' => 'Cerca',
    'LBL_EMPTY_SEARCH_RESULT' => 'Disculpi, no s\'han trobat resultats. Si us plau, creï una invitació a sota.',
    'LBL_CREATE_INVITEE' => 'Crear un recurs',
    'LBL_CREATE_CONTACT' => 'Com a contacte',
    'LBL_CREATE_AND_ADD' => 'Crear i afegir',
    'LBL_CANCEL_CREATE_INVITEE' => 'Cancelar',
    'LBL_NO_ACCESS' => 'Vostè no té permís per a crear $module',
    'LBL_SCHEDULING_FORM_TITLE' => 'Llista de recursos',
    'LBL_NONE' => 'Cap',

    'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_PROJECT_TITLE' => 'Plantilla de projecte: Projecte a partir del títol del projecte',


);
