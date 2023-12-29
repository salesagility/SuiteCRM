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
    'LBL_MODULE_NAME' => 'Tasques',
    'LBL_MODULE_TITLE' => 'Tasques: Inici',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Tasques',
    'LBL_LIST_FORM_TITLE' => 'Llista de Tasques',
    'LBL_NEW_FORM_TITLE' => 'Nova Tasca',
    'LBL_LIST_CLOSE' => 'Tancar',
    'LBL_LIST_SUBJECT' => 'Assumpte',
    'LBL_LIST_CONTACT' => 'Contacte',
    'LBL_LIST_PRIORITY' => 'Prioritat',
    'LBL_LIST_RELATED_TO' => 'Relacionat amb',
    'LBL_LIST_DUE_DATE' => 'Data Venciment',
    'LBL_LIST_DUE_TIME' => 'Hora Venciment',
    'LBL_SUBJECT' => 'Assumpte:',
    'LBL_STATUS' => 'Estat:',
    'LBL_DUE_DATE' => 'Data venciment:',
    'LBL_DUE_TIME' => 'Hora venciment:',
    'LBL_PRIORITY' => 'Prioritat:',
    'LBL_DUE_DATE_AND_TIME' => 'Data i hora de venciment:',
    'LBL_START_DATE_AND_TIME' => 'Data i hora d\'inici:',
    'LBL_START_DATE' => 'Data d&#39;inici:', // Excepció d'escapat 
    'LBL_LIST_START_DATE' => 'Data d\'inici',
    'LBL_START_TIME' => 'Hora d\'inici:',
    'DATE_FORMAT' => '(aaaa-mm-dd)',
    'LBL_NONE' => 'Cap',
    'LBL_CONTACT' => 'Contacte:',
    'LBL_EMAIL_ADDRESS' => 'Adreça de correu electrònic:',
    'LBL_PHONE' => 'Telèfon:',
    'LBL_EMAIL' => 'Adreça de correu electrònic:',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_NAME' => 'Nom:',
    'LBL_CONTACT_NAME' => 'Contacte ',
    'LBL_LIST_STATUS' => 'Estat',
    'LBL_DATE_DUE_FLAG' => 'Sense data de venciment',
    'LBL_DATE_START_FLAG' => 'Sense data d\'inici',
    'LBL_LIST_MY_TASKS' => 'Les Meves Tasques Obertes',
    'LNK_NEW_TASK' => 'Nova Tasca',
    'LNK_TASK_LIST' => 'Tasques',
    'LNK_IMPORT_TASKS' => 'Importar Tasques',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuari Assignat',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a:',
    'LBL_LIST_DATE_MODIFIED' => 'Data de Modificació',
    'LBL_CONTACT_ID' => 'ID de Contacte:',
    'LBL_PARENT_ID' => 'ID de Padre:',
    'LBL_CONTACT_PHONE' => 'Telèfon de Contacte:',
    'LBL_PARENT_TYPE' => 'Tipus de Padre:',
    'LBL_TASK_INFORMATION' => 'Visió general de la tasca', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_EDITLAYOUT' => 'Editar Diseny' /*for 508 compliance fix*/,
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Notes',
    //For export labels
    'LBL_DATE_DUE' => 'Data Venciment',
    'LBL_RELATED_TO' => 'Relacionat amb:',
);
