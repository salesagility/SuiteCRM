<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the Spanish language pack for the base application.
 * Portions created by REDK Ingeniería del Software S.L..
 * All Rights Reserved.
 * Contributor(s): REDK Software Engineering (www.redk.net)
 ********************************************************************************/
 
$mod_strings = array (
  'LBL_ID' => 'ID',
  'LBL_DATE_ENTERED' => 'Fecha de Creación',
  'LBL_DATE_MODIFIED' => 'Última Modificación',
  'LBL_MODIFIED' => 'Modificado Por',
  'LBL_MODIFIED_ID' => 'Modificado Por Id',
  'LBL_MODIFIED_NAME' => 'Modificado Por Nombre',
  'LBL_CREATED' => 'Creado Por',
  'LBL_CREATED_ID' => 'Creado Por Id',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DELETED' => 'Eliminado',
  'LBL_NAME' => 'Nombre:',
  'LBL_CREATED_USER' => 'Creado Por Usuario',
  'LBL_MODIFIED_USER' => 'Modificado Por Usuario',
  'LBL_LIST_NAME' => 'Nombre',
  'LBL_EDIT_BUTTON' => 'Editar',
  'LBL_REMOVE' => 'Quitar',
  'LBL_ASSIGNED_TO_ID' => 'Asignado a Usuario con Id',
  'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
  'LBL_MODULE_NAME' => 'Tareas',
  'LBL_TASK' => 'Tareas:',
  'LBL_MODULE_TITLE' => 'Tareas: Inicio',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Tareas',
  'LBL_LIST_FORM_TITLE' => 'Lista de Tareas',
  'LBL_NEW_FORM_TITLE' => 'Nueva Tarea',
  'LBL_NEW_FORM_SUBJECT' => 'Asunto:',
  'LBL_NEW_FORM_DUE_DATE' => 'Fecha Vencimiento:',
  'LBL_NEW_FORM_DUE_TIME' => 'Hora Vencimiento:',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_LIST_CLOSE' => 'Cerrar',
  'LBL_LIST_SUBJECT' => 'Asunto',
  'LBL_LIST_CONTACT' => 'Contacto',
  'LBL_LIST_PRIORITY' => 'Prioridad',
  'LBL_LIST_RELATED_TO' => 'Relacionado con',
  'LBL_LIST_DUE_DATE' => 'Fecha Vencimiento',
  'LBL_LIST_DUE_TIME' => 'Hora Vencimiento',
  'LBL_SUBJECT' => 'Asunto:',
  'LBL_STATUS' => 'Estado:',
  'LBL_DUE_DATE' => 'Fecha vencimiento:',
  'LBL_DUE_TIME' => 'Hora vencimiento:',
  'LBL_PRIORITY' => 'Prioridad:',
  'LBL_COLON' => ':',
  'LBL_DUE_DATE_AND_TIME' => 'Fecha y hora de vencimiento:',
  'LBL_START_DATE_AND_TIME' => 'Fecha y hora de inicio:',
  'LBL_START_DATE' => 'Fecha de inicio:',
  'LBL_LIST_START_DATE' => 'Fecha de inicio',
  'LBL_START_TIME' => 'Hora de inicio:',
  'LBL_LIST_START_TIME' => 'Hora de inicio',
  'DATE_FORMAT' => '(yyyy-mm-dd)',
  'LBL_NONE' => 'Ninguno',
  'LBL_CONTACT' => 'Contacto:',
  'LBL_EMAIL_ADDRESS' => 'Dirección de Correo:',
  'LBL_PHONE' => 'Teléfono:',
  'LBL_EMAIL' => 'Correo electrónico:',
  'LBL_DESCRIPTION_INFORMATION' => 'Información adicional',
  'LBL_CONTACT_NAME' => 'Contacto',
  'LBL_LIST_COMPLETE' => 'Completo:',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_DATE_DUE_FLAG' => 'Sin fecha de vencimiento',
  'LBL_DATE_START_FLAG' => 'Sin fecha de inicio',
  'ERR_DELETE_RECORD' => 'Debe especificar un número de registro para eliminar el contacto.',
  'ERR_INVALID_HOUR' => 'Por favor, introduzca una hora entre 0 y 24',
  'LBL_DEFAULT_PRIORITY' => 'Media',
  'LBL_LIST_MY_TASKS' => 'Mis Tareas Abiertas',
  'LNK_NEW_TASK' => 'Nueva Tarea',
  'LNK_TASK_LIST' => 'Ver Tareas',
  'LNK_IMPORT_TASKS' => 'Importar Tareas',
  'LBL_CONTACT_FIRST_NAME' => 'Nombre del Contacto',
  'LBL_CONTACT_LAST_NAME' => 'Apellido del Contacto',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_DATE_MODIFIED' => 'Fecha de Modificación',
  'LBL_CONTACT_ID' => 'ID de Contacto:',
  'LBL_PARENT_ID' => 'ID de Padre:',
  'LBL_CONTACT_PHONE' => 'Teléfono de Contacto:',
  'LBL_PARENT_NAME' => 'Tipo de Padre:',
  'LBL_ACTIVITIES_REPORTS' => 'Informe de Actividad',
  'LBL_TASK_INFORMATION' => 'Visión General',
  'LBL_EDITLAYOUT' => 'Editar diseño',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notas',
  'LBL_DATE_DUE' => 'Fecha vencimiento',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Usuario asignado',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID usuario asignado',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificado por ID',
  'LBL_EXPORT_CREATED_BY' => 'Creado por ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Relacionado con el módulo',
  'LBL_EXPORT_PARENT_ID' => 'Relacionado con el ID',
  'LBL_RELATED_TO' => 'Relacionado con:',
);