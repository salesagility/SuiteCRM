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

    'ERR_DELETE_RECORD' => "Heu d'indicar un número de registre per esborrar el compte.",
    'LBL_ACCOUNT_NAME' => 'Nom',
    'LBL_ACCOUNT' => 'Compte:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_ADDRESS_INFORMATION' => "Informació d'adreça",
    'LBL_ANNUAL_REVENUE' => 'Ingressos anuals:',
    'LBL_ANY_ADDRESS' => 'Qualsevol adreça:',
    'LBL_ANY_EMAIL' => 'Qualsevol correu electrònic:',
    'LBL_ANY_PHONE' => 'Qualsevol telèfon:',
    'LBL_RATING' => 'Puntuació',
    'LBL_ASSIGNED_USER' => 'Assignat a',
    'LBL_BILLING_ADDRESS_CITY' => 'Facturació - Població:',
    'LBL_BILLING_ADDRESS_COUNTRY' => 'Facturació - País:',
    'LBL_BILLING_ADDRESS_POSTALCODE' => 'Facturació - Codi postal:',
    'LBL_BILLING_ADDRESS_STATE' => 'Facturació - Província:',
    'LBL_BILLING_ADDRESS_STREET_2' => 'Facturació - Carrer 2',
    'LBL_BILLING_ADDRESS_STREET_3' => 'Facturació - Carrer 3',
    'LBL_BILLING_ADDRESS_STREET_4' => 'Facturació - Carrer 4',
    'LBL_BILLING_ADDRESS_STREET' => 'Facturació - Carrer:',
    'LBL_BILLING_ADDRESS' => 'Adreça de facturació:',
    'LBL_ACCOUNT_INFORMATION' => 'Visió general',
    'LBL_CITY' => 'Població:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_COUNTRY' => 'País:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Comptes',
    'LBL_DUPLICATE' => 'Possible compte duplicat',
    'LBL_EMAIL' => 'Correu electrònic:',
    'LBL_EMPLOYEES' => 'Empleats:',
    'LBL_FAX' => 'Fax:',
    'LBL_INDUSTRY' => 'Indústria:',
    'LBL_LIST_ACCOUNT_NAME' => 'Compte',
    'LBL_LIST_CITY' => 'Població',
    'LBL_LIST_EMAIL_ADDRESS' => 'Correu electrònic',
    'LBL_LIST_PHONE' => 'Telèfon',
    'LBL_LIST_STATE' => 'Província',
    'LBL_MEMBER_OF' => 'Membre de:',
    'LBL_MEMBER_ORG_SUBPANEL_TITLE' => 'Organitzacions Membre',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Correu electrònic alternatiu:',
    'LBL_OTHER_PHONE' => 'Telèfon alternatiu 2:',
    'LBL_OWNERSHIP' => 'Propietari:',
    'LBL_PARENT_ACCOUNT_ID' => 'ID del Compte origen',
    'LBL_PHONE_ALT' => 'Telèfon alternatiu:',
    'LBL_PHONE_FAX' => 'Fax:',
    'LBL_PHONE_OFFICE' => 'Telèfon oficina:',
    'LBL_PHONE' => 'Telèfon:',
    'LBL_POSTAL_CODE' => 'Codi postal:',
    'LBL_SAVE_ACCOUNT' => 'Desa el Compte',
    'LBL_SHIPPING_ADDRESS_CITY' => 'Enviament - Població:',
    'LBL_SHIPPING_ADDRESS_COUNTRY' => 'Enviament - País:',
    'LBL_SHIPPING_ADDRESS_POSTALCODE' => 'Enviament - Codi postal:',
    'LBL_SHIPPING_ADDRESS_STATE' => 'Enviament - Província:',
    'LBL_SHIPPING_ADDRESS_STREET_2' => 'Enviament - Carrer 2',
    'LBL_SHIPPING_ADDRESS_STREET_3' => 'Enviament - Carrer 3',
    'LBL_SHIPPING_ADDRESS_STREET_4' => 'Enviament - Carrer 4',
    'LBL_SHIPPING_ADDRESS_STREET' => 'Enviament - Carrer:',
    'LBL_SHIPPING_ADDRESS' => "Adreça d'enviament:",
    'LBL_STATE' => 'Província:',
    'LBL_TICKER_SYMBOL' => 'Identificador borsari:',
    'LBL_TYPE' => 'Tipus:',
    'LBL_WEBSITE' => 'Web:',
    'LNK_ACCOUNT_LIST' => 'Comptes',
    'LNK_NEW_ACCOUNT' => 'Nou Compte',
    'MSG_DUPLICATE' => "El registre que esteu a punt de crear podria ser un duplicat d'un altre compte existent. Els registres de comptes amb noms similars es llisten a continuació. Per confirmar la creació d'aquest compte feu clic a Desa. En cas contrari, cliqueu Cancel·la.",
    'MSG_SHOW_DUPLICATES' => "El registre que esteu a punt de crear podria ser un duplicat d'un altre compte existent. Els registres de comptes amb noms similars es llisten a continuació. Per confirmar la creació d'aquest compte feu clic a Desa. En cas contrari, cliqueu Cancel·la.",
    'NTC_DELETE_CONFIRMATION' => 'Segur que voleu eliminar el registre?',
    'LBL_LIST_FORM_TITLE' => 'Llista de Factures',
    'LBL_MODULE_NAME' => 'Factures',
    'LBL_MODULE_TITLE' => 'Factures',
    'LBL_HOMEPAGE_TITLE' => 'Les meves Factures',
    'LNK_NEW_RECORD' => 'Crea una Factura',
    'LNK_LIST' => 'Mostra les Factures',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca Factures',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_NEW_FORM_TITLE' => 'Nova Factura',
    'LBL_TERMS_C' => 'Condicions',
    'LBL_APPROVAL_ISSUE' => "Incidències d'aprovació",
    'LBL_APPROVAL_STATUS' => "Estat d'aprovació",
    'LBL_BILLING_ACCOUNT' => 'Compte',
    'LBL_BILLING_CONTACT' => 'Contacte',
    'LBL_EXPIRATION' => 'Vàlid fins',
    'LBL_INVOICE_NUMBER' => 'Número de factura',
    'LBL_OPPORTUNITY' => 'Oportunitat',
    'LBL_TEMPLATE_DDOWN_C' => 'Plantilla de factura',
    'LBL_STAGE' => 'Etapa del pressupost',
    'LBL_TERM' => 'Condicions de pagament',
    'LBL_SUBTOTAL_AMOUNT' => 'Subtotal',
    'LBL_DISCOUNT_AMOUNT' => 'Descompte',
    'LBL_TAX_AMOUNT' => 'IVA',
    'LBL_SHIPPING_AMOUNT' => 'Enviament',
    'LBL_TOTAL_AMT' => 'Total',
    'VALUE' => 'Títol',
    'LBL_EMAIL_ADDRESSES' => 'Adreces de correu electrònic:',
    'LBL_LINE_ITEMS' => 'Articles',
    'LBL_GRAND_TOTAL' => 'Total global',
    'LBL_QUOTE_NUMBER' => 'Número de pressupost',
    'LBL_QUOTE_DATE' => 'Data del pressupost',
    'LBL_INVOICE_DATE' => 'Data de facturació',
    'LBL_DUE_DATE' => 'Data de venciment',
    'LBL_STATUS' => 'Estat',
    'LBL_INVOICE_STATUS' => 'Estat de la factura',
    'LBL_PRODUCT_QUANITY' => 'Quantitat',
    'LBL_PRODUCT_NAME' => 'Producte',
    'LBL_PART_NUMBER' => 'Codi',
    'LBL_PRODUCT_NOTE' => 'Nota',
    'LBL_PRODUCT_DESCRIPTION' => 'Descripció',
    'LBL_LIST_PRICE' => 'Preu de llista',
    'LBL_DISCOUNT_AMT' => 'Descompte',
    'LBL_UNIT_PRICE' => 'Preu amb descompte',
    'LBL_TOTAL_PRICE' => 'Preu total',
    'LBL_VAT' => '% IVA',
    'LBL_VAT_AMT' => 'IVA',
    'LBL_ADD_PRODUCT_LINE' => 'Nova línia de producte',
    'LBL_SERVICE_NAME' => 'Servei',
    'LBL_SERVICE_LIST_PRICE' => 'Preu de llista',
    'LBL_SERVICE_PRICE' => 'Preu amb descompte',
    'LBL_SERVICE_DISCOUNT' => 'Descompte',
    'LBL_ADD_SERVICE_LINE' => 'Nova línia de servei',
    'LBL_REMOVE_PRODUCT_LINE' => 'Elimina',
    'LBL_PRINT_AS_PDF' => 'Genera document PDF',
    'LBL_EMAIL_INVOICE' => 'Envia factura per correu electrònic',
    'LBL_LIST_NUM' => 'Número',
    'LBL_PDF_NAME' => 'Factura',
    'LBL_EMAIL_NAME' => 'Per a',
    'LBL_NO_TEMPLATE' => "ERROR: No s'han trobat plantilles. Si no heu creat cap plantilla de factures, aneu a Plantilles PDF i creeu-ne una.",
    'LBL_SUBTOTAL_TAX_AMOUNT' => 'Subtotal + IVA', //pre shipping
    'LBL_EMAIL_PDF' => 'Envia PDF per correu electrònic',
    'LBL_ADD_GROUP' => 'Nou grup',
    'LBL_DELETE_GROUP' => 'Elimina el grup',
    'LBL_GROUP_NAME' => 'Nom del grup',
    'LBL_GROUP_TOTAL' => 'Total del grup',
    'LBL_SHIPPING_TAX' => '% IVA enviament',
    'LBL_SHIPPING_TAX_AMT' => 'IVA enviament',
    'LBL_IMPORT_LINE_ITEMS' => 'Importa línies de pressupost',
    'LBL_SUBTOTAL_AMOUNT_USDOLLAR' => 'Subtotal (moneda per defecte)',
    'LBL_DISCOUNT_AMOUNT_USDOLLAR' => 'Descompte (moneda per defecte)',
    'LBL_TAX_AMOUNT_USDOLLAR' => 'IVA (moneda per defecte)',
    'LBL_SHIPPING_AMOUNT_USDOLLAR' => 'Enviament (moneda per defecte)',
    'LBL_TOTAL_AMT_USDOLLAR' => 'Total (moneda per defecte)',
    'LBL_SHIPPING_TAX_AMT_USDOLLAR' => 'IVA enviament (moneda per defecte)',
    'LBL_GRAND_TOTAL_USDOLLAR' => 'Total global (moneda per defecte)',
    'LBL_INVOICE_TO' => 'Facturar a',
    'LBL_AOS_LINE_ITEM_GROUPS' => 'Grups de línies de pressupost',
    'LBL_AOS_PRODUCT_QUOTES' => 'Línies de pressupost',
    'LBL_AOS_QUOTES_AOS_INVOICES' => 'Pressupostos: Factures',
);
