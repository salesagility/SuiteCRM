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
    'LBL_MODULE_NAME' => 'Tarefas',
    'LBL_MODULE_TITLE' => 'Tarefas: Inicio',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Tarefas',
    'LBL_LIST_FORM_TITLE' => 'Lista de Tarefas',
    'LBL_NEW_FORM_TITLE' => 'Nova Tarefa',
    'LBL_LIST_CLOSE' => 'Cerrar',
    'LBL_LIST_SUBJECT' => 'Asunto',
    'LBL_LIST_CONTACT' => 'Contacto',
    'LBL_LIST_PRIORITY' => 'Prioridade',
    'LBL_LIST_RELATED_TO' => 'Relacionado con',
    'LBL_LIST_DUE_DATE' => 'Data Vencemento',
    'LBL_LIST_DUE_TIME' => 'Hora Vencemento',
    'LBL_SUBJECT' => 'Asunto:',
    'LBL_STATUS' => 'Estado:',
    'LBL_DUE_DATE' => 'Data vencemento:',
    'LBL_DUE_TIME' => 'Hora vencemento:',
    'LBL_PRIORITY' => 'Prioridade:',
    'LBL_DUE_DATE_AND_TIME' => 'Data e hora de vencemento:',
    'LBL_START_DATE_AND_TIME' => 'Data e hora de inicio:',
    'LBL_START_DATE' => 'Data de inicio:',
    'LBL_LIST_START_DATE' => 'Data de inicio',
    'LBL_START_TIME' => 'Hora de inicio:',
    'DATE_FORMAT' => '(aaaa-mm-dd)',
    'LBL_NONE' => 'Ningún',
    'LBL_CONTACT' => 'Contacto:',
    'LBL_EMAIL_ADDRESS' => 'Enderezo de Correo:',
    'LBL_PHONE' => 'Teléfono:',
    'LBL_EMAIL' => 'Correo electrónico:',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_NAME' => 'Nome:',
    'LBL_CONTACT_NAME' => 'Contacto',
    'LBL_LIST_STATUS' => 'Estado',
    'LBL_DATE_DUE_FLAG' => 'Sen data de vencemento',
    'LBL_DATE_START_FLAG' => 'Sen data de inicio',
    'LBL_LIST_MY_TASKS' => 'As miñas Tarefas Abertas',
    'LNK_NEW_TASK' => 'Nova Tarefa',
    'LNK_TASK_LIST' => 'Ver Tarefas',
    'LNK_IMPORT_TASKS' => 'Importar Tarefas',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
    'LBL_LIST_DATE_MODIFIED' => 'Data de Modificación',
    'LBL_CONTACT_ID' => 'ID de Contacto:',
    'LBL_PARENT_ID' => 'ID de Pai:',
    'LBL_CONTACT_PHONE' => 'Teléfono de Contacto:',
    'LBL_PARENT_TYPE' => 'Tipo de Pai:',
    'LBL_TASK_INFORMATION' => 'Visión Xeral', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_EDITLAYOUT' => 'Editar deseño' /*for 508 compliance fix*/,
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Notas',
    //For export labels
    'LBL_DATE_DUE' => 'Data vencemento',
    'LBL_RELATED_TO' => 'Relacionado con:',
);
