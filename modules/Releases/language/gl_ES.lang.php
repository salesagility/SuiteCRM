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
    'LBL_MODULE_NAME' => 'Publicacións',
    'LBL_MODULE_TITLE' => 'Publicacións: Inicio',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Publicacións',
    'LBL_LIST_FORM_TITLE' => 'Lista de Publicacións',
    'LBL_NEW_FORM_TITLE' => 'Nova Publicación',
    'LBL_RELEASE' => 'Publicación:',
    'LBL_LIST_NAME' => 'Publicación',
    'LBL_NAME' => 'Versión da publicación:',
    'LBL_LIST_LIST_ORDER' => 'Orde',
    'LBL_LIST_ORDER' => 'Orde:',
    'LBL_LIST_STATUS' => 'Estado',
    'LBL_STATUS' => 'Estado:',
    'LNK_NEW_RELEASE' => 'Lista de Publicacións',
    'NTC_DELETE_CONFIRMATION' => '¿Está seguro de que desexa eliminar este rexistro?',
    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro para eliminar a publicación.',
    'NTC_STATUS' => 'Establece o estado a Inactiva para eliminar esta publicación das listas despregables de Publicacións',
    'NTC_LIST_ORDER' => 'Establece o orde en que esta publicación aparecerá nas listas despregables de Publicacións',
    'release_status_dom' =>
        array(
            'Active' => 'Activa',
            'Inactive' => 'Inactiva',
        ),
    'LBL_EDITLAYOUT' => 'Editar Deseño' /*for 508 compliance fix*/,
);
