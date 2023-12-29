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
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documents',
    // Dashlet Categories
    'LBL_CHARTS' => 'Gràfics',
    'LBL_DEFAULT' => 'Vistes',
    // END Dashlet Categories

    'ERR_DELETE_RECORD' => 'Heu d\'especificar un número de registre per eliminar el compte.',
    'LBL_ACCOUNT_INFORMATION' => 'Visió general del compte', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_ACCOUNT_NAME' => 'Nom:',
    'LBL_ACCOUNT' => 'Compte:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_ADDRESS_INFORMATION' => 'Informació d\'adreça',
    'LBL_ANNUAL_REVENUE' => 'Ingressos anuals:',
    'LBL_ANY_ADDRESS' => 'Qualsevol adreça:',
    'LBL_ANY_EMAIL' => 'Qualsevol correu electrònic:',
    'LBL_ANY_PHONE' => 'Qualsevol telèfon:',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a:',
    'LBL_ASSIGNED_TO_ID' => 'Usuari Assignat:',
    'LBL_BILLING_ADDRESS_CITY' => 'Ciutat de facturació:',
    'LBL_BILLING_ADDRESS_COUNTRY' => 'País de facturació:',
    'LBL_BILLING_ADDRESS_POSTALCODE' => 'CP de facturació:',
    'LBL_BILLING_ADDRESS_STATE' => 'Estat/Província de facturació:',
    'LBL_BILLING_ADDRESS_STREET_2' => 'Carrer de facturació 2',
    'LBL_BILLING_ADDRESS_STREET_3' => 'Carrer de facturació 3',
    'LBL_BILLING_ADDRESS_STREET_4' => 'Carrer de facturació 4',
    'LBL_BILLING_ADDRESS_STREET' => 'Carrer de facturació:',
    'LBL_BILLING_ADDRESS' => 'Adreça de facturació:',
    'LBL_BUGS_SUBPANEL_TITLE' => 'Incidències',
    'LBL_CAMPAIGN_ID' => 'ID Campanya',
    'LBL_CASES_SUBPANEL_TITLE' => 'Casos',
    'LBL_CITY' => 'Ciutat:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_COUNTRY' => 'País:',
    'LBL_DATE_ENTERED' => 'Data de Creació:',
    'LBL_DATE_MODIFIED' => 'Data de Modificació:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Comptes',
    'LBL_DESCRIPTION_INFORMATION' => 'Informació addicional',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_DUPLICATE' => 'Possible compte duplicat',
    'LBL_EMAIL' => 'Correu electrònic:',
    'LBL_EMAIL_OPT_OUT' => 'Refusar correu electrònic:',
    'LBL_EMAIL_ADDRESSES' => 'Adreces de correu electrònic:',
    'LBL_EMPLOYEES' => 'Empleats:',
    'LBL_FAX' => 'Fax:',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_HOMEPAGE_TITLE' => 'Els Meus Comptes',
    'LBL_INDUSTRY' => 'Indústria:',
    'LBL_INVALID_EMAIL' => 'Correu electrònic no vàlid:',
    'LBL_INVITEE' => 'Contactes',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Clients Potencials',
    'LBL_LIST_ACCOUNT_NAME' => 'Nom',
    'LBL_LIST_CITY' => 'Ciutat',
    'LBL_LIST_CONTACT_NAME' => 'Contacte',
    'LBL_LIST_EMAIL_ADDRESS' => 'Correu electrònic',
    'LBL_LIST_FORM_TITLE' => 'Llista de Comptes',
    'LBL_LIST_PHONE' => 'Telèfon',
    'LBL_LIST_STATE' => 'Estat/Província',
    'LBL_MEMBER_OF' => 'Membre de:',
    'LBL_MEMBER_ORG_SUBPANEL_TITLE' => 'Organitzacions Membre',
    'LBL_MODULE_NAME' => 'Comptes',
    'LBL_MODULE_TITLE' => 'Comptes: Inici',
    'LBL_MODULE_ID' => 'Comptes',
    'LBL_NAME' => 'Nom:',
    'LBL_NEW_FORM_TITLE' => 'Nou Compte',
    'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Oportunitats',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Correu electrònic alternatiu:',
    'LBL_OTHER_PHONE' => 'Telèfon alternatiu 1:',
    'LBL_OWNERSHIP' => 'Propietari:',
    'LBL_PARENT_ACCOUNT_ID' => 'ID Compte Origen',
    'LBL_PHONE_ALT' => 'Telèfon alternatiu 2:',
    'LBL_PHONE_FAX' => 'Fax oficina:',
    'LBL_PHONE_OFFICE' => 'Telèfon oficina:',
    'LBL_PHONE' => 'Telèfon:',
    'LBL_POSTAL_CODE' => 'Codi postal:',
    'LBL_PRODUCTS_TITLE' => 'Productes',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projectes',
    'LBL_PUSH_CONTACTS_BUTTON_LABEL' => 'Copiar a Contactes',
    'LBL_PUSH_CONTACTS_BUTTON_TITLE' => 'Copiar...',
    'LBL_RATING' => 'Puntuació',
    'LBL_SAVE_ACCOUNT' => 'Desar Compte',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Comptes',
    'LBL_SHIPPING_ADDRESS_CITY' => 'Ciutat d\'enviament:',
    'LBL_SHIPPING_ADDRESS_COUNTRY' => 'País d\'enviament:',
    'LBL_SHIPPING_ADDRESS_POSTALCODE' => 'CP d\'enviament:',
    'LBL_SHIPPING_ADDRESS_STATE' => 'Estat/Província d\'enviament:',
    'LBL_SHIPPING_ADDRESS_STREET_2' => 'Carrer d\'enviament 2',
    'LBL_SHIPPING_ADDRESS_STREET_3' => 'Carrer d\'enviament 3',
    'LBL_SHIPPING_ADDRESS_STREET_4' => 'Carrer d\'enviament 4',
    'LBL_SHIPPING_ADDRESS_STREET' => 'Carrer d\'enviament:',
    'LBL_SHIPPING_ADDRESS' => 'Adreça d\'enviament:',
    'LBL_SIC_CODE' => 'Codi CNAE/SIC:',
    'LBL_STATE' => 'Estat o regió:',
    'LBL_TICKER_SYMBOL' => 'Sigla bursàtil:',
    'LBL_TYPE' => 'Tipus:',
    'LBL_WEBSITE' => 'Web:',
    'LBL_CAMPAIGNS' => 'Campanyes',
    'LNK_ACCOUNT_LIST' => 'Comptes',
    'LNK_NEW_ACCOUNT' => 'Nou Compte',
    'LNK_IMPORT_ACCOUNTS' => 'Importar comptes',
    'MSG_DUPLICATE' => 'El registre per al compte que crearà podria ser un duplicat d\'un altre registre de compte existent. Els registres de compte amb noms similars es llisten a continuació.<br>Faci clic a Desar per continuar amb la creació d\'aquest compte, o en Cancel·lar per tornar al mòdul sense crear el compte.',
    'MSG_SHOW_DUPLICATES' => 'El registre per al compte que crearà podria ser un duplicat d\'un altre registre de compte existent. Els registres de compte amb noms similars es llisten a continuació.<br>Faci clic a Desar per continuar amb la creació d\'aquest compte, o en Cancel·lar per tornar al mòdul sense crear el compte.',
    'LBL_ASSIGNED_USER_NAME' => 'Assignat a:',
    'LBL_PROSPECT_LIST' => 'Públic Objectiu',
    'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Comptes',
    'LBL_PROJECT_SUBPANEL_TITLE' => 'Projectes',
    //For export labels
    'LBL_PARENT_ID' => 'Id pare',
    // SNIP
    'LBL_PRODUCTS_SERVICES_PURCHASED_SUBPANEL_TITLE' => 'Productes i serveis adquirits',

    'LBL_AOS_CONTRACTS' => 'Contractes',
    'LBL_AOS_INVOICES' => 'Factures',
    'LBL_AOS_QUOTES' => 'Pressupostos',
);
