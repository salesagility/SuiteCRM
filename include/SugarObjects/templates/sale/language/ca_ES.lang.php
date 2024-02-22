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
    'LBL_MODULE_NAME' => 'Vendes',
    'LBL_MODULE_TITLE' => 'Vendes: Inici',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Vendes',
    'LBL_LIST_FORM_TITLE' => 'Llista de Vendes',
    'LBL_NAME' => 'Nom de Venta',
    'LBL_LIST_SALE_NAME' => 'Nom',
    'LBL_LIST_ACCOUNT_NAME' => 'Nom de Compte',
    'LBL_LIST_AMOUNT' => 'Quantitat',
    'LBL_LIST_DATE_CLOSED' => 'Tancament',
    'LBL_LIST_SALE_STAGE' => 'Etapa de Vendes',
    'LBL_ACCOUNT_ID' => 'ID de Compte',
    //DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_name' => 'LBL_NAME',
    //END DON'T CONVERT
    'LBL_ACCOUNT_NAME' => 'Nom de Compte:',
    'LBL_AMOUNT' => 'Quantitat:',
    'LBL_AMOUNT_USDOLLAR' => 'Quantitat en Dólars EEUU:',
    'LBL_CURRENCY' => 'Moneda:',
    'LBL_DATE_CLOSED' => 'Data de Tancament Prevista:',
    'LBL_TYPE' => 'Tipus:',
    'LBL_CAMPAIGN' => 'Campanya:',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Clients Potencials',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projectes',
    'LBL_NEXT_STEP' => 'Proper Pas:',
    'LBL_LEAD_SOURCE' => 'Pressa de Contacte:',
    'LBL_SALES_STAGE' => 'Etapa de Vendes:',
    'LBL_PROBABILITY' => 'Probabilitat (%):',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_DUPLICATE' => 'Possible Venta Duplicada',
    'MSG_DUPLICATE' => 'El registre per a la venta que va a crear podria ser un duplicat en un altre registre de venta existent. Els registres de venta amb noms similars es llisten a continuació.<br>Faci clic a Desar per continuar amb la creació d\'aquesta venta, o en Cancel·lar per tornar al mòdul sense crear la venta.',
    'LBL_NEW_FORM_TITLE' => 'Nova Venta',
    'ERR_DELETE_RECORD' => 'Té que especifícar un número de registre per eliminar la venta.',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Venta',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',

    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_ASSIGNED_TO_NAME' => 'Usuari:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuari Assignat',
    'LBL_ASSIGNED_TO_ID' => 'Assignada a ID',
    'LBL_MODIFIED_NAME' => 'Modificada per Usuari',
    'LBL_SALE_INFORMATION' => 'Informació sobre la Venta',
    'LBL_CURRENCY_NAME' => 'Nom de Moneda',
    'LBL_CURRENCY_SYMBOL' => 'Símbol de Moneda',
    'LBL_EDIT_BUTTON' => 'Edita',
    // STIC-Custom 20240214 JBL - QuickEdit view
    // https://github.com/SinergiaTIC/SinergiaCRM/pull/93
    'LBL_QUICKEDIT_BUTTON' => '↙ Edita',
    // END STIC-Custom
    'LBL_REMOVE' => 'Desvincula',

);
