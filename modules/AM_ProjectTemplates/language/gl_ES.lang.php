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
    'LBL_ASSIGNED_TO_NAME' => 'Director do proxecto',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creación',
    'LBL_DATE_MODIFIED' => 'Data de Modificación',
    'LBL_MODIFIED' => 'Modificado Por',
    'LBL_MODIFIED_NAME' => 'Modificado por Nome',
    'LBL_CREATED' => 'Creado por',
    'LBL_DELETED' => 'Eliminado',
    'LBL_NAME' => 'Nome de Plantilla',
    'LBL_CREATED_USER' => 'Creado polo Usuario',
    'LBL_MODIFIED_USER' => 'Modificado polo Usuario',
    'LBL_LIST_NAME' => 'Nome',
    'LBL_EDIT_BUTTON' => 'Editar',
    'LBL_REMOVE' => 'Quitar',
    'LBL_LIST_FORM_TITLE' => 'Lista de plantillas de proxecto',
    'LBL_MODULE_NAME' => 'Plantillas de Proxecto',
    'LBL_MODULE_TITLE' => 'Plantillas de Proxecto',
    'LBL_HOMEPAGE_TITLE' => 'As miñas plantillas de proxecto',
    'LNK_NEW_RECORD' => 'Crear plantillas de proxecto',
    'LNK_LIST' => 'Ver plantillas de proxecto',
    'LNK_IMPORT_AM_PROJECTTEMPLATES' => 'Importar plantillas de proxecto',
    'LBL_SEARCH_FORM_TITLE' => 'Buscar plantillas de proxecto',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Ver Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_NEW_FORM_TITLE' => 'Novas plantillas de proxecto',
    'LBL_STATUS' => 'Estado',
    'LBL_PRIORITY' => 'Prioridade',
    'LBL_PROJECT_NAME' => 'Nome de Proxecto',
    'LBL_START_DATE' => 'Data de inicio',
    'LBL_CREATE_PROJECT_TITLE' => '¿Cree un novo proxecto desta plantilla?',
    'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_TASKTEMPLATES_TITLE' => 'Plantillas de tarefas',
    'LBL_AM_PROJECTTEMPLATES_USERS_1_TITLE' => 'Usuarios',
    'LBL_AM_PROJECTTEMPLATES_CONTACTS_1_TITLE' => 'Contactos',
    'LBL_AM_PROJECTTEMPLATES_RESOURCES_TITLE' => 'Seleccionar Recursos',
    'LBL_NEW_PROJECT_CREATED' => 'Novo proxecto creado',
    'LBL_NEW_PROJECT' => 'Crear Proxecto',
    'LBL_CANCEL_PROJECT' => 'Cancelar',

    'LBL_SUBTASK' => 'Tarefa',
    'LBL_MILESTONE_FLAG' => 'Fito',
    'LBL_RELATIONSHIP_TYPE' => 'Tipo de relación',
    'LBL_LAG' => 'Lag',
    'LBL_DAYS' => 'Días',
    'LBL_HOURS' => 'Horas',
    'LBL_MONTHS' => 'Meses',

    'LBL_PROJECT_TASKS_SUBPANEL_TITLE' => 'Tarefas de Proxecto',
    'LBL_VIEW_GANTT_TITLE' => 'Ver Gantt',
    'LBL_VIEW_GANTT_DURATION' => 'Duración',
    'LBL_TASK_TITLE' => 'Editar tarefa',
    'LBL_DURATION_TITLE' => 'Editar a duración',
    'LBL_DESCRIPTION' => 'Notas',
    'LBL_ASSIGNED_USER_ID' => 'Asignado A:',

    'LBL_LIST_ASSIGNED_USER' => 'Director do proxecto',
    'LBL_UNASSIGNED' => 'Sen Asignar',
    'LBL_PROJECT_USERS_1_FROM_USERS_TITLE' => 'Recursos',
    'LBL_DELETE_TASK' => 'Eliminar tarefa',
    'LBL_VIEW_DETAIL' => 'Ver Detalles',
    'LBL_ADD_NEW_TASK' => 'Agregar nova tarefa',
    'LBL_ASSIGNED_USER_NAME' => 'Director do proxecto:',

    'LBL_TASK_ID' => 'ID',
    'LBL_TASK_NAME' => 'Nome de Tarefa',
    'LBL_DURATION' => 'Duración',
    'LBL_ACTUAL_DURATION' => 'Duración Real',
    'LBL_START' => 'Inicio',
    'LBL_FINISH' => 'Finalizar',
    'LBL_PREDECESSORS' => 'Predecesoras',
    'LBL_PERCENT_COMPLETE' => '% Completado',
    'LBL_EDIT_TASK_PROPERTIES' => 'Editar propiedades da tarefa.',

    'LBL_OVERRIDE_BUSINESS_HOURS' => 'Considerar días laborais',
    'LBL_COPY_ALL_TASKS' => 'Copiar todas as tarefas con recursos',
    'LBL_COPY_SEL_TASKS' => 'Copiar as tarefas seleccionadas con recursos',
    'LBL_TOOLTIP_TITLE' => 'Pista',
    'LBL_TOOLTIP_TEXT' => 'Copiar todas as tarefas cos seus usuarios asignados',

    'LBL_EMAIL' => 'Email',
    'LBL_PHONE' => 'Teléfono de Oficina:',
    'LBL_ADD_BUTTON' => 'Engadir',
    'LBL_ADD_INVITEE' => 'Agregar recurso',
    'LBL_FIRST_NAME' => 'Nome',
    'LBL_LAST_NAME' => 'Apelidos',
    'LBL_SEARCH_BUTTON' => 'Busca',
    'LBL_EMPTY_SEARCH_RESULT' => 'Sentímolo, non se encontraron resultados. Por favor cree unha invitación abaixo.',
    'LBL_CREATE_INVITEE' => 'Crear un recurso',
    'LBL_CREATE_CONTACT' => 'Novo Contacto',
    'LBL_CREATE_AND_ADD' => 'Crear e Engadir',
    'LBL_CANCEL_CREATE_INVITEE' => 'Cancelar',
    'LBL_NO_ACCESS' => 'Non ten permisos para crear rexistros no módulo $module',
    'LBL_SCHEDULING_FORM_TITLE' => 'Lista de recursos',
    'LBL_NONE' => 'Ningún',

    'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_PROJECT_TITLE' => 'Plantilla de proxecto: Proxecto a partir do nome do proxecto',


);
