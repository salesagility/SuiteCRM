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
    'LBL_ASSIGNED_TO_ID' => 'Asignado a (ID)',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_ASSIGNED_TO' => 'Asignado a',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_LIST_ASSIGNED_USER' => 'Asignado a',
    'LBL_CREATED' => 'Creado por',
    'LBL_CREATED_USER' => 'Creado por',
    'LBL_CREATED_ID' => 'Creado por (ID)',
    'LBL_MODIFIED' => 'Modificado por',
    'LBL_MODIFIED_NAME' => 'Modificado por',
    'LBL_MODIFIED_USER' => 'Modificado por',
    'LBL_MODIFIED_ID' => 'Modificado por (ID)',
    'LBL_SECURITYGROUPS' => 'Grupos de Seguridade',
    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => 'Grupos de Seguridade',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creación',
    'LBL_DATE_MODIFIED' => 'Data de Modificación',
    'LBL_DESCRIPTION' => 'Descrición',
    'LBL_DELETED' => 'Eliminado',
    'LBL_NAME' => 'Nome',
    'LBL_LIST_NAME' => 'Nome',
    'LBL_EDIT_BUTTON' => 'Editar',
    'LBL_REMOVE' => 'Quitar',

    'LBL_NUMBER' => 'Número', //PR 3296
    'LBL_LIST_FORM_TITLE' => 'Lista de Liñas de Presuposto',
    'LBL_MODULE_NAME' => 'Liñas de Presuposto',
    'LBL_MODULE_TITLE' => 'Liñas de Presuposto',
    'LBL_HOMEPAGE_TITLE' => 'As miñas Liñas de Presuposto',
    'LNK_NEW_RECORD' => 'Crear unha Liña de Presuposto',
    'LNK_LIST' => 'Mostrar as Liñas de Presuposto',
    'LBL_SEARCH_FORM_TITLE' => 'Buscar Liñas de Presuposto',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_NEW_FORM_TITLE' => 'Nova Liña de Presuposto',
    'LBL_PRODUCT_NAME' => 'Produto',
    'LBL_PRODUCT_NUMBER' => 'Número', //PR 3296
    'LBL_PRODUCT_QTY' => 'Cantidade',
    'LBL_PRODUCT_COST_PRICE' => 'Prezo de Costo',
    'LBL_PRODUCT_LIST_PRICE' => 'Prezo de Lista',
    'LBL_PRODUCT_UNIT_PRICE' => 'Prezo con desconto',
    'LBL_PRODUCT_DISCOUNT' => 'Desconto',
    'LBL_PRODUCT_DISCOUNT_AMOUNT' => 'Desconto',
    'LBL_PART_NUMBER' => 'Código',
    'LBL_PRODUCT_DESCRIPTION' => 'Descrición',
    'LBL_DISCOUNT' => 'Tipo de Desconto',
    'LBL_VAT_AMT' => 'IVE',
    'LBL_VAT' => '% IVE',
    'LBL_PRODUCT_TOTAL_PRICE' => 'Prezo total',
    'LBL_PRODUCT_NOTE' => 'Nota',
    'Quote' => '',
    'LBL_FLEX_RELATE' => 'Relacionado con',
    'LBL_PRODUCT' => 'Produto',

    'LBL_SERVICE_MODULE_NAME' => 'Servizos',
    'LBL_SERVICE_NUMBER' => 'Número', //PR 3296
    'LBL_LIST_NUM' => 'Número',
    'LBL_PARENT_ID' => 'ID do pai',
    'LBL_GROUP_NAME' => 'Grupo',
    'LBL_GROUP_DESCRIPTION' => 'Descrición', //PR 3296
    'LBL_PRODUCT_COST_PRICE_USDOLLAR' => 'Prezo de costo (moeda predeterminada)',
    'LBL_PRODUCT_LIST_PRICE_USDOLLAR' => 'Prezo de lista (moeda predeterminada)',
    'LBL_PRODUCT_UNIT_PRICE_USDOLLAR' => 'Prezo con desconto (moneda predeterminada)',
    'LBL_PRODUCT_TOTAL_PRICE_USDOLLAR' => 'Prezo total (moeda predeterminada)',
    'LBL_PRODUCT_DISCOUNT_USDOLLAR' => 'Desconto (moeda predeterminada)',
    'LBL_PRODUCT_DISCOUNT_AMOUNT_USDOLLAR' => 'Desconto (moeda predeterminada)',
    'LBL_VAT_AMT_USDOLLAR' => 'IVE (moeda predeterminada)',
    'LBL_PRODUCTS_SERVICES' => 'Produto / Servizo',
    'LBL_PRODUCT_ID' => 'ID de produto',

    'LBL_AOS_CONTRACTS' => 'Contratos',
    'LBL_AOS_INVOICES' => 'Facturas',
    'LBL_AOS_PRODUCTS' => 'Produtos',
    'LBL_AOS_QUOTES' => 'Presupostos',
);