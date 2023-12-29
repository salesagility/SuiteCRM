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
    'LBL_ASSIGNED_TO_ID' => 'Assignat a (ID)',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_ASSIGNED_TO' => 'Assignat a',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_LIST_ASSIGNED_USER' => 'Assignat a',
    'LBL_CREATED' => 'Creat per',
    'LBL_CREATED_USER' => 'Creat per',
    'LBL_CREATED_ID' => 'Creat per (ID)',
    'LBL_MODIFIED' => 'Modificat per',
    'LBL_MODIFIED_NAME' => 'Modificat per',
    'LBL_MODIFIED_USER' => 'Modificat per',
    'LBL_MODIFIED_ID' => 'Modificat per (ID)',
    'LBL_SECURITYGROUPS' => 'Grups de seguretat',
    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => 'Grups de seguretat',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creació',
    'LBL_DATE_MODIFIED' => 'Data de Modificació',
    'LBL_DESCRIPTION' => 'Descripció',
    'LBL_DELETED' => 'Suprimit',
    'LBL_NAME' => 'Nom',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_EDIT_BUTTON' => 'Edita',
    'LBL_REMOVE' => 'Desvincula',
    
    'LBL_NUMBER' => 'Número', //PR 3296
    'LBL_LIST_FORM_TITLE' => 'Llista de Línies de Pressupost',
    'LBL_MODULE_NAME' => 'Línies de Pressupost',
    'LBL_MODULE_TITLE' => 'Línies de Pressupost',
    'LBL_HOMEPAGE_TITLE' => 'Les meves Línies de Pressupost',
    'LNK_NEW_RECORD' => 'Crea una Línia de Pressupost',
    'LNK_LIST' => 'Mostra les Línies de Pressupost',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca Línies de Pressupost',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_NEW_FORM_TITLE' => 'Nova Línia de Presupost',
    'LBL_PRODUCT_NAME' => 'Producte',
    'LBL_PRODUCT_NUMBER' => 'Número', //PR 3296
    'LBL_PRODUCT_QTY' => 'Quantitat',
    'LBL_PRODUCT_COST_PRICE' => 'Preu de cost',
    'LBL_PRODUCT_LIST_PRICE' => 'Preu de llista',
    'LBL_PRODUCT_UNIT_PRICE' => 'Preu amb descompte',
    'LBL_PRODUCT_DISCOUNT' => 'Descompte',
    'LBL_PRODUCT_DISCOUNT_AMOUNT' => 'Descompte',
    'LBL_PART_NUMBER' => 'Codi',
    'LBL_PRODUCT_DESCRIPTION' => 'Descripció',
    'LBL_DISCOUNT' => 'Tipus de descompte',
    'LBL_VAT_AMT' => 'IVA',
    'LBL_VAT' => '% IVA',
    'LBL_PRODUCT_TOTAL_PRICE' => 'Preu total',
    'LBL_PRODUCT_NOTE' => 'Nota',
    'Quote' => '',
    'LBL_FLEX_RELATE' => 'Relacionat amb',
    'LBL_PRODUCT' => 'Producte',

    'LBL_SERVICE_MODULE_NAME' => 'Serveis',
    'LBL_LIST_NUM' => 'Número',
    'LBL_PARENT_ID' => 'ID del pare',
    'LBL_GROUP_NAME' => 'Grup',
    'LBL_GROUP_DESCRIPTION' => 'Descripció', //PR 3296
    'LBL_PRODUCT_COST_PRICE_USDOLLAR' => 'Preu de cost (moneda per defecte)',
    'LBL_PRODUCT_LIST_PRICE_USDOLLAR' => 'Preu de llista (moneda per defecte)',
    'LBL_PRODUCT_UNIT_PRICE_USDOLLAR' => 'Preu amb descompte (moneda per defecte)',
    'LBL_PRODUCT_TOTAL_PRICE_USDOLLAR' => 'Preu total (moneda per defecte)',
    'LBL_PRODUCT_DISCOUNT_USDOLLAR' => 'Descompte (moneda per defecte)',
    'LBL_PRODUCT_DISCOUNT_AMOUNT_USDOLLAR' => 'Descompte (moneda per defecte)',
    'LBL_VAT_AMT_USDOLLAR' => 'IVA (moneda per defecte)',
    'LBL_PRODUCTS_SERVICES' => 'Producte / Servei',
    'LBL_PRODUCT_ID' => 'ID del producte',

    'LBL_AOS_CONTRACTS' => 'Contractes',
    'LBL_AOS_INVOICES' => 'Factures',
    'LBL_AOS_PRODUCTS' => 'Productes',
    'LBL_AOS_QUOTES' => 'Pressupostos',
);
