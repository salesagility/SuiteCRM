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
    'LBL_MODULE_NAME' => 'Llançaments',
    'LBL_MODULE_TITLE' => 'Publicacions: Inici',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de publicacions',
    'LBL_LIST_FORM_TITLE' => 'Llista de publicacions',
    'LBL_NEW_FORM_TITLE' => 'Nova publicació',
    'LBL_RELEASE' => 'Publicació:',
    'LBL_LIST_NAME' => 'Publicació',
    'LBL_NAME' => 'Versió de la publicació:',
    'LBL_LIST_LIST_ORDER' => 'Ordre',
    'LBL_LIST_ORDER' => 'Ordre:',
    'LBL_LIST_STATUS' => 'Estat',
    'LBL_STATUS' => 'Estat:',
    'LNK_NEW_RELEASE' => 'Llista de publicacions',
    'NTC_DELETE_CONFIRMATION' => 'Està segur de que desitja eliminar el registre?',
    'ERR_DELETE_RECORD' => 'Ha d\'especificar un número de registre per a eliminar la publicació.',
    'NTC_STATUS' => 'Establir l\'estat a inactiu per a eliminar aquesta publicació de les llistes desplegables de publicacions',
    'NTC_LIST_ORDER' => 'Estableix l\'ordre en que aquesta publicació apareixerà a les llistes desplegables de publicacions',
    'release_status_dom' =>
        array(
            'Active' => 'Activa',
            'Inactive' => 'Inactiva',
        ),
    'LBL_EDITLAYOUT' => 'Editar Diseny' /*for 508 compliance fix*/,
);
