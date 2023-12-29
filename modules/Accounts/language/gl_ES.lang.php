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
    // DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_name' => 'LBL_LIST_ACCOUNT_NAME',
    'db_website' => 'LBL_LIST_WEBSITE',
    'db_billing_address_city' => 'LBL_LIST_CITY',
    // END DON'T CONVERT
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
    // Dashlet Categories
    'LBL_CHARTS' => 'Gráficos',
    'LBL_DEFAULT' => 'Vistas',
    // END Dashlet Categories

    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro para eliminar a conta.',
    'LBL_ACCOUNT_INFORMATION' => 'Visión Global', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_ACCOUNT_NAME' => 'Nome de Conta:',
    'LBL_ACCOUNT' => 'Conta:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_ADDRESS_INFORMATION' => 'Información de Enderezo',
    'LBL_ANNUAL_REVENUE' => 'Ingresos anuais:',
    'LBL_ANY_ADDRESS' => 'Calquera enderezo:',
    'LBL_ANY_EMAIL' => 'Calquera Correo:',
    'LBL_ANY_PHONE' => 'Calquera teléfono:',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
    'LBL_ASSIGNED_TO_ID' => 'Usuario Asignado:',
    'LBL_BILLING_ADDRESS_CITY' => 'Cidade de facturación:',
    'LBL_BILLING_ADDRESS_COUNTRY' => 'País de facturación:',
    'LBL_BILLING_ADDRESS_POSTALCODE' => 'CP de facturación:',
    'LBL_BILLING_ADDRESS_STATE' => 'Estado/provincia de facturación:',
    'LBL_BILLING_ADDRESS_STREET_2' => 'Rúa de facturación 2',
    'LBL_BILLING_ADDRESS_STREET_3' => 'Rúa de facturación 3',
    'LBL_BILLING_ADDRESS_STREET_4' => 'Rúa de facturación 4',
    'LBL_BILLING_ADDRESS_STREET' => 'Rúa de facturación:',
    'LBL_BILLING_ADDRESS' => 'Enderezo de facturación:',
    'LBL_BUGS_SUBPANEL_TITLE' => 'Incidencias',
    'LBL_CAMPAIGN_ID' => 'ID Campaña',
    'LBL_CASES_SUBPANEL_TITLE' => 'Casos',
    'LBL_CITY' => 'Cidade:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
    'LBL_COUNTRY' => 'País:',
    'LBL_DATE_ENTERED' => 'Data de Creación:',
    'LBL_DATE_MODIFIED' => 'Data de Modificación:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Contas',
    'LBL_DESCRIPTION_INFORMATION' => 'Información adicional',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_DUPLICATE' => 'Posible conta duplicada',
    'LBL_EMAIL' => 'Correo electrónico:',
    'LBL_EMAIL_OPT_OUT' => 'Rehusar Email:',
    'LBL_EMAIL_ADDRESSES' => 'Enderezos de Email',
    'LBL_EMPLOYEES' => 'Empregados:',
    'LBL_FAX' => 'Fax:',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_HOMEPAGE_TITLE' => 'As miñas Contas',
    'LBL_INDUSTRY' => 'Industria:',
    'LBL_INVALID_EMAIL' => 'Email non válido:',
    'LBL_INVITEE' => 'Contactos',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciais',
    'LBL_LIST_ACCOUNT_NAME' => 'Nome',
    'LBL_LIST_CITY' => 'Cidade',
    'LBL_LIST_CONTACT_NAME' => 'Nome Contacto',
    'LBL_LIST_EMAIL_ADDRESS' => 'Email',
    'LBL_LIST_FORM_TITLE' => 'Lista de Contas',
    'LBL_LIST_PHONE' => 'Teléfono',
    'LBL_LIST_STATE' => 'Estado/Provincia',
    'LBL_MEMBER_OF' => 'Membro de:',
    'LBL_MEMBER_ORG_SUBPANEL_TITLE' => 'Organizacións Membro',
    'LBL_MODULE_NAME' => 'Contas',
    'LBL_MODULE_TITLE' => 'Contas: Inicio',
    'LBL_MODULE_ID' => 'Contas',
    'LBL_NAME' => 'Nome:',
    'LBL_NEW_FORM_TITLE' => 'Nova Conta',
    'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Oportunidades',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Email alternativo:',
    'LBL_OTHER_PHONE' => 'Tel. alternativo:',
    'LBL_OWNERSHIP' => 'Propietario:',
    'LBL_PARENT_ACCOUNT_ID' => 'ID Conta Pai',
    'LBL_PHONE_ALT' => 'Teléfono alternativo:',
    'LBL_PHONE_FAX' => 'Fax oficina:',
    'LBL_PHONE_OFFICE' => 'Teléfono oficina:',
    'LBL_PHONE' => 'Teléfono:',
    'LBL_POSTAL_CODE' => 'Código postal:',
    'LBL_PRODUCTS_TITLE' => 'Produtos',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proxectos',
    'LBL_PUSH_CONTACTS_BUTTON_LABEL' => 'Copiar a Contactos',
    'LBL_PUSH_CONTACTS_BUTTON_TITLE' => 'Copiar...',
    'LBL_RATING' => 'Cualificación:',
    'LBL_SAVE_ACCOUNT' => 'Gardar Conta',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Contas',
    'LBL_SHIPPING_ADDRESS_CITY' => 'Cidade de envío:',
    'LBL_SHIPPING_ADDRESS_COUNTRY' => 'País de envío:',
    'LBL_SHIPPING_ADDRESS_POSTALCODE' => 'CP de envío:',
    'LBL_SHIPPING_ADDRESS_STATE' => 'Estado/provincia de envío:',
    'LBL_SHIPPING_ADDRESS_STREET_2' => 'Rúa de envío 2',
    'LBL_SHIPPING_ADDRESS_STREET_3' => 'Rúa de envío 3',
    'LBL_SHIPPING_ADDRESS_STREET_4' => 'Rúa de envío 4',
    'LBL_SHIPPING_ADDRESS_STREET' => 'Rúa de envío:',
    'LBL_SHIPPING_ADDRESS' => 'Enderezo de envío:',
    'LBL_SIC_CODE' => 'Código CNAE/SIC:',
    'LBL_STATE' => 'Estado ou rexión:',
    'LBL_TICKER_SYMBOL' => 'Símbolo Ticker:',
    'LBL_TYPE' => 'Tipo:',
    'LBL_WEBSITE' => 'Web:',
    'LBL_CAMPAIGNS' => 'Campañas',
    'LNK_ACCOUNT_LIST' => 'Ver Contas',
    'LNK_NEW_ACCOUNT' => 'Crear unha conta',
    'LNK_IMPORT_ACCOUNTS' => 'Importar Contas',
    'MSG_DUPLICATE' => 'O rexistro para a conta que vai a crear podería ser un duplicado doutro rexistro de conta existente. Os rexistros de conta con nomes similares lístanse a continuación.<br>Faga clic en Gardar para continuar coa creación desta conta, ou en Cancelar para volver ao módulo sen crear a conta.',
    'MSG_SHOW_DUPLICATES' => 'O rexistro para a conta que vai a crear podería ser un duplicado doutro rexistro de conta existente. Os rexistros de conta con nomes similares lístanse a continuación.<br>Faga clic en Gardar para continuar coa creación desta conta, ou en Cancelar para volver ao módulo sen crear a conta.',
    'LBL_ASSIGNED_USER_NAME' => 'Asignado a:',
    'LBL_PROSPECT_LIST' => 'Lista de Público Obxectivo',
    'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Contas',
    'LBL_PROJECT_SUBPANEL_TITLE' => 'Proxectos',
    //For export labels
    'LBL_PARENT_ID' => 'ID Pai:',
    // SNIP
    'LBL_PRODUCTS_SERVICES_PURCHASED_SUBPANEL_TITLE' => 'Produtos e servizos adquiridos',

    'LBL_AOS_CONTRACTS' => 'Contratos',
    'LBL_AOS_INVOICES' => 'Facturas',
    'LBL_AOS_QUOTES' => 'Presupostos',
);