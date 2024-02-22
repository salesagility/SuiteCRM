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
    'ERR_DELETE_RECORD' => 'Ha d\'especificar un número de registre per eliminar el compte.',
    'LBL_ACCOUNT_NAME' => 'Nom del Compte:',
    'LBL_ACCOUNT' => 'Compte:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_ADDRESS_INFORMATION' => 'Informació d\'adreça',
    'LBL_ANNUAL_REVENUE' => 'Ingressos Anuals:',
    'LBL_ANY_ADDRESS' => 'Qualsevol adreça:',
    'LBL_ANY_EMAIL' => 'Qualsevol correu electrònic:',
    'LBL_EMAIL_NON_PRIMARY' => 'Correus electrònics no principals',
    'LBL_ANY_PHONE' => 'Qualsevol Telèfon:',
    'LBL_ASSIGNED_TO_NAME' => 'Usuari:',
    'LBL_RATING' => 'Puntuació',
    'LBL_ASSIGNED_TO' => 'Assignat a:',
    'LBL_ASSIGNED_USER' => 'Assignat a:',
    'LBL_ASSIGNED_TO_ID' => 'Assignat a:',
    'LBL_BILLING_ADDRESS_CITY' => 'Ciutat de facturació:',
    'LBL_BILLING_ADDRESS_COUNTRY' => 'País facturació:',
    'LBL_BILLING_ADDRESS_POSTALCODE' => 'Codi postal facturació:',
    'LBL_BILLING_ADDRESS_STATE' => 'Estat/Província facturació:',
    'LBL_BILLING_ADDRESS_STREET_2' => 'Carrer facturació 2',
    'LBL_BILLING_ADDRESS_STREET_3' => 'Carrer facturació 3',
    'LBL_BILLING_ADDRESS_STREET_4' => 'Carrer facturació 4',
    'LBL_BILLING_ADDRESS_STREET' => 'Carrer facturació:',
    'LBL_BILLING_ADDRESS' => 'Adreça de facturació:',
    'LBL_ACCOUNT_INFORMATION' => 'Informació del Compte',
    'LBL_CITY' => 'Ciutat:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_COUNTRY' => 'País:',
    'LBL_DATE_ENTERED' => 'Creat:',
    'LBL_DATE_MODIFIED' => 'Modificat:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Comptes',
    'LBL_DESCRIPTION_INFORMATION' => 'Informació Adicional',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_DUPLICATE' => 'Possible Compte Duplicat',
    'LBL_EMAIL' => 'Adreça de correu electrònic:',
    'LBL_EMPLOYEES' => 'Empleats:',
    'LBL_FAX' => 'Fax:',
    'LBL_INDUSTRY' => 'Industria:',
    'LBL_LIST_ACCOUNT_NAME' => 'Nom',
    'LBL_LIST_CITY' => 'Ciutat',
    'LBL_LIST_EMAIL_ADDRESS' => 'Adreça de correu electrònic',
    'LBL_LIST_PHONE' => 'Telèfon',
    'LBL_LIST_STATE' => 'Estat/Província',
    'LBL_MEMBER_OF' => 'Membre de:',
    'LBL_MEMBER_ORG_SUBPANEL_TITLE' => 'Organitzacions Membre',
    'LBL_NAME' => 'Nom:',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Correu electrònic alternatiu:',
    'LBL_OTHER_PHONE' => 'Tel. Alternatiu:',
    'LBL_OWNERSHIP' => 'Propietari:',
    'LBL_PARENT_ACCOUNT_ID' => 'ID Compte Pare',
    'LBL_PHONE_ALT' => 'Tel. Alternatiu:',
    'LBL_PHONE_FAX' => 'Fax Oficina:',
    'LBL_PHONE_OFFICE' => 'Telèfon Oficina:',
    'LBL_PHONE' => 'Telèfon:',
    'LBL_EMAIL_ADDRESS' => 'Correu electrònic',
    'LBL_EMAIL_ADDRESSES' => 'Adreces de correu electrònic',
    'LBL_POSTAL_CODE' => 'Codi postal:',
    'LBL_SAVE_ACCOUNT' => 'Desar Compte',
    'LBL_SHIPPING_ADDRESS_CITY' => 'Ciutat d\'enviament:',
    'LBL_SHIPPING_ADDRESS_COUNTRY' => 'País enviament:',
    'LBL_SHIPPING_ADDRESS_POSTALCODE' => 'Codi postal d\'enviament:',
    'LBL_SHIPPING_ADDRESS_STATE' => 'Estat/Província enviament:',
    'LBL_SHIPPING_ADDRESS_STREET_2' => 'Carrer enviament 2',
    'LBL_SHIPPING_ADDRESS_STREET_3' => 'Carrer enviament 3',
    'LBL_SHIPPING_ADDRESS_STREET_4' => 'Carrer enviament 4',
    'LBL_SHIPPING_ADDRESS_STREET' => 'Carrer enviament:',
    'LBL_SHIPPING_ADDRESS' => 'Adreça d\'enviament:',

    'LBL_STATE' => 'Estat o regió:',
    'LBL_TICKER_SYMBOL' => 'Sigla bursàtil:',
    'LBL_TYPE' => 'Tipus:',
    'LBL_WEBSITE' => 'Lloc web:',

    'LNK_ACCOUNT_LIST' => 'Comptes',
    'LNK_NEW_ACCOUNT' => 'Nou Compte',

    'MSG_DUPLICATE' => 'La creació d\'aquest compte pot produir un compte duplicat. Podeu escollir un compte existent de la llista següent o fer clic a Desa per continuar la creació d\'un nou compte amb les dades introduïdes prèviament.',
    'MSG_SHOW_DUPLICATES' => 'La creació d\'aquest compte pot crear un compte duplicat. Podeu fer clic a Desa per continuar amb la creació d\'un nou compte amb les dades prèviament introduïdes o podeu fer clic a Cancel·la.',

    'NTC_DELETE_CONFIRMATION' => 'Segur que voleu suprimir aquest registre?',

    'LBL_EDIT_BUTTON' => 'Edita',
    // STIC-Custom 20240214 JBL - QuickEdit view
    // https://github.com/SinergiaTIC/SinergiaCRM/pull/93
    'LBL_QUICKEDIT_BUTTON' => '↙ Edita',
    // END STIC-Custom
    'LBL_REMOVE' => 'Desvincula',

);
