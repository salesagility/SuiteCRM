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
    
    'ERR_DELETE_RECORD' => 'Debe especificar un rexistro para borralo da conta.',
    'LBL_ACCOUNT_NAME' => 'Nome',
    'LBL_ACCOUNT' => 'Conta:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_ADDRESS_INFORMATION' => 'Información de Enderezo',
    'LBL_ANNUAL_REVENUE' => 'Ingresos Anuais:',
    'LBL_ANY_ADDRESS' => 'Calquera Enderezo:',
    'LBL_ANY_EMAIL' => 'Calquera Email:',
    'LBL_ANY_PHONE' => 'Calquera Teléfono:',
    'LBL_RATING' => 'Puntuación',
    'LBL_ASSIGNED_USER' => 'Asignado a:',
    'LBL_BILLING_ADDRESS_CITY' => 'Facturación - Poboación:',
    'LBL_BILLING_ADDRESS_COUNTRY' => 'Facturación - País:',
    'LBL_BILLING_ADDRESS_POSTALCODE' => 'Facturación - Código Postal:',
    'LBL_BILLING_ADDRESS_STATE' => 'Facturación - Provincia:',
    'LBL_BILLING_ADDRESS_STREET_2' => 'Facturación - Rúa 2',
    'LBL_BILLING_ADDRESS_STREET_3' => 'Facturación - Rúa 3',
    'LBL_BILLING_ADDRESS_STREET_4' => 'Facturación - Rúa 4',
    'LBL_BILLING_ADDRESS_STREET' => 'Facturación - Rúa:',
    'LBL_BILLING_ADDRESS' => 'Enderezo de Facturación:',
    'LBL_ACCOUNT_INFORMATION' => 'Visión xeral',
    'LBL_CITY' => 'Poboación:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
    'LBL_COUNTRY' => 'País:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Contas',
    'LBL_DUPLICATE' => 'Posible conta duplicada',
    'LBL_EMAIL' => 'Email:',
    'LBL_EMPLOYEES' => 'Empregados:',
    'LBL_FAX' => 'Fax:',
    'LBL_INDUSTRY' => 'Industria:',
    'LBL_LIST_ACCOUNT_NAME' => 'Conta',
    'LBL_LIST_CITY' => 'Poboación',
    'LBL_LIST_EMAIL_ADDRESS' => 'Email',
    'LBL_LIST_PHONE' => 'Teléfono',
    'LBL_LIST_STATE' => 'Provincia',
    'LBL_MEMBER_OF' => 'Membro de:',
    'LBL_MEMBER_ORG_SUBPANEL_TITLE' => 'Organizacións Membro',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Outro Email:',
    'LBL_OTHER_PHONE' => 'Teléfono alternativo 2:',
    'LBL_OWNERSHIP' => 'Propiedade:',
    'LBL_PARENT_ACCOUNT_ID' => 'ID da Conta orixe',
    'LBL_PHONE_ALT' => 'Teléfono alternativo:',
    'LBL_PHONE_FAX' => 'Fax:',
    'LBL_PHONE_OFFICE' => 'Teléfono de Oficina:',
    'LBL_PHONE' => 'Teléfono:',
    'LBL_POSTAL_CODE' => 'Código Postal:',
    'LBL_SAVE_ACCOUNT' => 'Gardar Conta',
    'LBL_SHIPPING_ADDRESS_CITY' => 'Envío - Poboación:',
    'LBL_SHIPPING_ADDRESS_COUNTRY' => 'Envío - País:',
    'LBL_SHIPPING_ADDRESS_POSTALCODE' => 'Envío - Código Postal:',
    'LBL_SHIPPING_ADDRESS_STATE' => 'Envío - Provincia:',
    'LBL_SHIPPING_ADDRESS_STREET_2' => 'Envío - Rúa 2',
    'LBL_SHIPPING_ADDRESS_STREET_3' => 'Envío - Rúa 3',
    'LBL_SHIPPING_ADDRESS_STREET_4' => 'Envío - Rúa 4',
    'LBL_SHIPPING_ADDRESS_STREET' => 'Envío - Rúa:',
    'LBL_SHIPPING_ADDRESS' => 'Dirección de Envío:',
    'LBL_STATE' => 'Provincia:',
    'LBL_TICKER_SYMBOL' => 'Identificador bursátil:',
    'LBL_TYPE' => 'Tipo:',
    'LBL_WEBSITE' => 'Web:',
    'LNK_ACCOUNT_LIST' => 'Contas',
    'LNK_NEW_ACCOUNT' => 'Nova conta',
    'MSG_DUPLICATE' => "O rexistro que está a punto de crear podería ser un duplicado de outra conta existente. Os rexistros de contas con nomes similares se listan a continuación. Para confirmar a creación desta conta faga click en Gardar. En caso contrario, faga click en Cancelar.",
    'MSG_SHOW_DUPLICATES' => "O rexistro que está a punto de crear podería ser un duplicado de outra conta existente. Os rexistros de contas con nomes similares se listan a continuación. Para confirmar a creación desta conta faga click en Gardar. En caso contrario, faga click en Cancelar.",
    'NTC_DELETE_CONFIRMATION' => '¿Está seguro que quere eliminar este rexistro?',
    'LBL_LIST_FORM_TITLE' => 'Lista de Facturas',
    'LBL_MODULE_NAME' => 'Facturas',
    'LBL_MODULE_TITLE' => 'Facturas',
    'LBL_HOMEPAGE_TITLE' => 'As Miñas Facturas',
    'LNK_NEW_RECORD' => 'Crear Factura',
    'LNK_LIST' => 'Facturas',
    'LBL_SEARCH_FORM_TITLE' => 'Buscar Facturas',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_NEW_FORM_TITLE' => 'Nova Factura',
    'LBL_TERMS_C' => 'Condicións',
    'LBL_APPROVAL_ISSUE' => 'Incidencias de Aprobación',
    'LBL_APPROVAL_STATUS' => 'Estado de Aprobación',
    'LBL_BILLING_ACCOUNT' => 'Conta',
    'LBL_BILLING_CONTACT' => 'Contacto',
    'LBL_EXPIRATION' => 'Válida Ata',
    'LBL_INVOICE_NUMBER' => 'Número de Factura',
    'LBL_OPPORTUNITY' => 'Oportunidade',
    'LBL_TEMPLATE_DDOWN_C' => 'Plantilla de Factura',
    'LBL_STAGE' => 'Etapa de Presuposto',
    'LBL_TERM' => 'Condicións de Pago',
    'LBL_SUBTOTAL_AMOUNT' => 'Subtotal',
    'LBL_DISCOUNT_AMOUNT' => 'Desconto',
    'LBL_TAX_AMOUNT' => 'IVE',
    'LBL_SHIPPING_AMOUNT' => 'Envío',
    'LBL_TOTAL_AMT' => 'Total',
    'VALUE' => 'Título',
    'LBL_EMAIL_ADDRESSES' => 'Enderezos de Email',
    'LBL_LINE_ITEMS' => 'Artigos',
    'LBL_GRAND_TOTAL' => 'Total global',
    'LBL_QUOTE_NUMBER' => 'Número de Presuposto',
    'LBL_QUOTE_DATE' => 'Data de Presuposto',
    'LBL_INVOICE_DATE' => 'Data de Facturación',
    'LBL_DUE_DATE' => 'Data de Vencemento',
    'LBL_STATUS' => 'Estado',
    'LBL_INVOICE_STATUS' => 'Estado da Factura',
    'LBL_PRODUCT_QUANITY' => 'Cantidade',
    'LBL_PRODUCT_NAME' => 'Produto',
    'LBL_PART_NUMBER' => 'Código',
    'LBL_PRODUCT_NOTE' => 'Nota',
    'LBL_PRODUCT_DESCRIPTION' => 'Descrición',
    'LBL_LIST_PRICE' => 'Prezo de lista',
    'LBL_DISCOUNT_AMT' => 'Desconto',
    'LBL_UNIT_PRICE' => 'Prezo con desconto',
    'LBL_TOTAL_PRICE' => 'Prezo total',
    'LBL_VAT' => '% IVE', 
    'LBL_VAT_AMT' => 'IVE', 
    'LBL_ADD_PRODUCT_LINE' => 'Nova Liña de Produto',
    'LBL_SERVICE_NAME' => 'Servizo',
    'LBL_SERVICE_LIST_PRICE' => 'Prezo de lista',
    'LBL_SERVICE_PRICE' => 'Prezo con desconto',
    'LBL_SERVICE_DISCOUNT' => 'Desconto',
    'LBL_ADD_SERVICE_LINE' => 'Nova Liña de Servizo',
    'LBL_REMOVE_PRODUCT_LINE' => 'Quitar',
    'LBL_PRINT_AS_PDF' => 'Xerar documento PDF',
    'LBL_EMAIL_INVOICE' => 'Enviar Factura por Email',
    'LBL_LIST_NUM' => 'Número',
    'LBL_PDF_NAME' => 'Factura',
    'LBL_EMAIL_NAME' => 'Para',
    'LBL_NO_TEMPLATE' => 'ERROR: Non se encontraron plantillas. Se non creou ningunha planilla de facturas, vaia a Plantillas PDF e cree unha.',
    'LBL_SUBTOTAL_TAX_AMOUNT' => 'Subtotal + IVE',//pre shipping
    'LBL_EMAIL_PDF' => 'Enviar PDF por Email',
    'LBL_ADD_GROUP' => 'Novo Grupo',
    'LBL_DELETE_GROUP' => 'Eliminar Grupo',
    'LBL_GROUP_NAME' => 'Nome do Grupo',
    'LBL_GROUP_TOTAL' => 'Total de Grupo',
    'LBL_SHIPPING_TAX' => '% IVE envío',
    'LBL_SHIPPING_TAX_AMT' => 'IVE envío',
    'LBL_IMPORT_LINE_ITEMS' => 'Importar Liñas de Presuposto',
    'LBL_SUBTOTAL_AMOUNT_USDOLLAR' => 'Subtotal (moeda predeterminada)',
    'LBL_DISCOUNT_AMOUNT_USDOLLAR' => 'Desconto (moeda predeterminada)',
    'LBL_TAX_AMOUNT_USDOLLAR' => 'IVE (moeda predeterminada)',
    'LBL_SHIPPING_AMOUNT_USDOLLAR' => 'Envío (moeda predeterminada)',
    'LBL_TOTAL_AMT_USDOLLAR' => 'Total (moeda predeterminada)',
    'LBL_SHIPPING_TAX_AMT_USDOLLAR' => 'IVE de envío (moeda predeterminada)',
    'LBL_GRAND_TOTAL_USDOLLAR' => 'Total global (moneda predeterminada)',
    'LBL_INVOICE_TO' => 'Facturar a',
    'LBL_AOS_LINE_ITEM_GROUPS' => 'Grupos de Liñas de presuposto',
    'LBL_AOS_PRODUCT_QUOTES' => 'Liñas de presuposto',
    'LBL_AOS_QUOTES_AOS_INVOICES' => 'Presupostos: Facturas',
);
