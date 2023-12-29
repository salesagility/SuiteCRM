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
    //DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_last_name' => 'LBL_LIST_LAST_NAME',
    'db_first_name' => 'LBL_LIST_FIRST_NAME',
    'db_title' => 'LBL_LIST_TITLE',
    'db_email1' => 'LBL_LIST_EMAIL_ADDRESS',
    'db_account_name' => 'LBL_LIST_ACCOUNT_NAME',
    'db_email2' => 'LBL_LIST_EMAIL_ADDRESS',
    //END DON'T CONVERT

    'ERR_DELETE_RECORD' => 'Ha d\'especificar un número de registre a eliminar.',
    'LBL_ACCOUNT_DESCRIPTION' => 'Descripció de la Compte',
    'LBL_ACCOUNT_ID' => 'ID Compte',
    'LBL_ACCOUNT_NAME' => 'Nom del compte:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_ADDRESS_INFORMATION' => 'Informació d\'adreça',
    'LBL_ALT_ADDRESS_CITY' => 'Ciutat alternativa',
    'LBL_ALT_ADDRESS_COUNTRY' => 'País alternatiu',
    'LBL_ALT_ADDRESS_POSTALCODE' => 'Codi postal alternatiu',
    'LBL_ALT_ADDRESS_STATE' => 'Estat/Província alternatiu',
    'LBL_ALT_ADDRESS_STREET_2' => 'Carrer alternatiu 2',
    'LBL_ALT_ADDRESS_STREET_3' => 'Carrer alternatiu 3',
    'LBL_ALT_ADDRESS_STREET' => 'Carrer alternatiu',
    'LBL_ALTERNATE_ADDRESS' => 'Adreça alternativa:',
    'LBL_ALT_ADDRESS' => 'Una altra adreça:',
    'LBL_ANY_ADDRESS' => 'Qualsevol adreça:',
    'LBL_ANY_EMAIL' => 'Qualsevol correu electrònic:',
    'LBL_ANY_PHONE' => 'Qualsevol telèfon:',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_ASSIGNED_TO_ID' => 'Usuari Assignat:',
    'LBL_BUSINESSCARD' => 'Convertir Client Potencial',
    'LBL_CITY' => 'Ciutat:',
    'LBL_CONTACT_ID' => 'ID Contacte',
    'LBL_CONTACT_INFORMATION' => 'Visió general del client potencial', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_CONTACT_NAME' => 'Nom del cliente potencial:',
    'LBL_CONTACT_OPP_FORM_TITLE' => 'Client Potencial-Oportunitat:',
    'LBL_CONTACT_ROLE' => 'Rol:',
    'LBL_CONTACT' => 'Client Potencial:',
    'LBL_CONVERTED_ACCOUNT' => 'Compte Convertida:',
    'LBL_CONVERTED_CONTACT' => 'Contacte Convertit:',
    'LBL_CONVERTED_OPP' => 'Oportunitat Convertida:',
    'LBL_CONVERTED' => 'Convertit',
    'LBL_CONVERTLEAD_BUTTON_KEY' => 'V',
    'LBL_CONVERTLEAD_TITLE' => 'Convertir Client Potencial',
    'LBL_CONVERTLEAD' => 'Convertir Client Potencial',
    'LBL_CONVERTLEAD_WARNING' => 'Avís: L\'estat del Client Potencial que està a punt de convertir és "Convertit". És possible que ja s\'hagi creat algun registres de tipus Contacte i / o Compte a partir d\'aquest Client Potencial. Si desitja continuar amb la conversió Client Potencial, feu clic a Desa. Per tornar al Client Potencial sense realitzar la conversió, feu clic a Cancel·la.',
    'LBL_CONVERTLEAD_WARNING_INTO_RECORD' => 'Possible contacte:',
    'LBL_COUNTRY' => 'País:',
    'LBL_CREATED_NEW' => 'Creat un nou',
    'LBL_CREATED_ACCOUNT' => 'Creat un nou compte',
    'LBL_CREATED_CALL' => 'Creada una nova trucada',
    'LBL_CREATED_CONTACT' => 'Creat un nou contacte',
    'LBL_CREATED_MEETING' => 'Creada una nova reunió',
    'LBL_CREATED_OPPORTUNITY' => 'Creada una nova oportunitat',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Clients Potencials',
    'LBL_DEPARTMENT' => 'Departament:',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_DO_NOT_CALL' => 'No trucar:',
    'LBL_DUPLICATE' => 'Clients potencials similares',
    'LBL_EMAIL_ADDRESS' => 'Adreça de correu electrònic:',
    'LBL_EMAIL_OPT_OUT' => 'Refusar correu electrònic:',
    'LBL_EXISTING_ACCOUNT' => 'Usat un compte existent',
    'LBL_EXISTING_CONTACT' => 'Usat un contacte existent',
    'LBL_EXISTING_OPPORTUNITY' => 'Usada una oportunitat existent',
    'LBL_FAX_PHONE' => 'Fax:',
    'LBL_FIRST_NAME' => 'Nom:',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_HOME_PHONE' => 'Tel. casa:',
    'LBL_IMPORT_VCARD' => 'Importar vCard',
    'LBL_VCARD' => 'vCard',
    'LBL_IMPORT_VCARDTEXT' => 'Automaticàmente crea un nou client potencial important una vCard.',
    'LBL_INVALID_EMAIL' => 'Correu electrònic no vàlid:',
    'LBL_INVITEE' => 'Informadors',
    'LBL_LAST_NAME' => 'Cognoms:',
    'LBL_LEAD_SOURCE_DESCRIPTION' => 'Descripció de presa de contacte:',
    'LBL_LEAD_SOURCE' => 'Presa de contacte:',
    'LBL_LIST_ACCEPT_STATUS' => 'Acceptar Estat',
    'LBL_LIST_ACCOUNT_NAME' => 'Compte',
    'LBL_LIST_CONTACT_NAME' => 'Contacte',
    'LBL_LIST_CONTACT_ROLE' => 'Rol',
    'LBL_LIST_DATE_ENTERED' => 'Creat',
    'LBL_LIST_EMAIL_ADDRESS' => 'Correu electrònic',
    'LBL_LIST_FIRST_NAME' => 'Nom',
    'LBL_LIST_FORM_TITLE' => 'Llista de Clients Potencials',
    'LBL_LIST_LAST_NAME' => 'Cognoms',
    'LBL_LIST_LEAD_SOURCE_DESCRIPTION' => 'Descripció de Presa de Contacte',
    'LBL_LIST_LEAD_SOURCE' => 'Presa de Contacte',
    'LBL_LIST_MY_LEADS' => 'Els Meus Clients Potencials',
    'LBL_LIST_NAME' => 'Nom complet',
    'LBL_LIST_PHONE' => 'Telèfon',
    'LBL_LIST_REFERED_BY' => 'Referit per',
    'LBL_LIST_STATUS' => 'Estat',
    'LBL_LIST_TITLE' => 'Càrrec',
    'LBL_MOBILE_PHONE' => 'Mòbil:',
    'LBL_MODULE_NAME' => 'Clients Potencials',
    'LBL_MODULE_TITLE' => 'Clients Potencials: Inici',
    'LBL_NAME' => 'Nom complet:',
    'LBL_NEW_FORM_TITLE' => 'Nou Client Potencial',
    'LBL_OFFICE_PHONE' => 'Tel. oficina:',
    'LBL_OPP_NAME' => 'Nom de la oportunitat:',
    'LBL_OPPORTUNITY_AMOUNT' => 'Quantitat de l\'oportunitat:',
    'LBL_OPPORTUNITY_ID' => 'ID Oportunitat',
    'LBL_OPPORTUNITY_NAME' => 'Nom de l\'oportunitat:',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Correu electrònic alternatiu:',
    'LBL_OTHER_PHONE' => 'Tel. alternatiu:',
    'LBL_PHONE' => 'Telèfon:',
    'LBL_PORTAL_APP' => 'Aplicació del Portal',
    'LBL_PORTAL_INFORMATION' => 'Informació del Portal',
    'LBL_PORTAL_NAME' => 'Nom del Portal:',
    'LBL_POSTAL_CODE' => 'Codi postal:',
    'LBL_STREET' => 'Carrer',
    'LBL_PRIMARY_ADDRESS_CITY' => 'Ciutat principal',
    'LBL_PRIMARY_ADDRESS_COUNTRY' => 'País principal',
    'LBL_PRIMARY_ADDRESS_POSTALCODE' => 'Codi postal principal',
    'LBL_PRIMARY_ADDRESS_STATE' => 'Estat/Província principal',
    'LBL_PRIMARY_ADDRESS_STREET_2' => 'Carrer principal 2',
    'LBL_PRIMARY_ADDRESS_STREET_3' => 'Carrer principal 3',
    'LBL_PRIMARY_ADDRESS_STREET' => 'Carrer principal',
    'LBL_PRIMARY_ADDRESS' => 'Adreça principal:',
    'LBL_REFERED_BY' => 'Referit per:',
    'LBL_REPORTS_TO_ID' => 'Informa a ID',
    'LBL_REPORTS_TO' => 'Informa a:',
    'LBL_SALUTATION' => 'Salutació',
    'LBL_MODIFIED' => 'Modificat per',
    'LBL_CREATED' => 'Creat per',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Clients Potencials',
    'LBL_SELECT_CHECKED_BUTTON_LABEL' => 'Seleccionar Clients Potencials Marcats',
    'LBL_SELECT_CHECKED_BUTTON_TITLE' => 'Seleccionar Clients Potencials Marcats',
    'LBL_STATE' => 'Estat o regió:',
    'LBL_STATUS_DESCRIPTION' => 'Descripció estat:',
    'LBL_STATUS' => 'Estat:',
    'LBL_TITLE' => 'Càrrec:',
    'LNK_IMPORT_VCARD' => 'Crear desde vCard',
    'LNK_LEAD_LIST' => 'Clients Potencials',
    'LNK_NEW_ACCOUNT' => 'Nou Compte',
    'LNK_NEW_APPOINTMENT' => 'Nova Cita',
    'LNK_NEW_CONTACT' => 'Nou Contacte',
    'LNK_NEW_LEAD' => 'Nou Client Potencial',
    'LNK_NEW_NOTE' => 'Nova Nota',
    'LNK_NEW_TASK' => 'Nova Tasca',
    'LNK_NEW_CASE' => 'Nou Cas',
    'LNK_NEW_CALL' => 'Programar Trucada',
    'LNK_NEW_MEETING' => 'Programar Reunió',
    'LNK_NEW_OPPORTUNITY' => 'Nova Oportunitat',
    'LNK_SELECT_ACCOUNTS' => ' <b>O</b> Seleccioneu un compte',
    'LNK_SELECT_CONTACTS' => ' <b>OR</b> Seleccioneu contacte',
    'NTC_DELETE_CONFIRMATION' => 'Està segur que desitja eliminar aquest registre?',
    'NTC_REMOVE_CONFIRMATION' => 'Està segur que desitja treure aquest client potencial del cas?',
    'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE' => 'Campanyes',
    'LBL_CAMPAIGN' => 'Campanya:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuari Assignat',
    'LBL_PROSPECT_LIST' => 'Públic Objetivo',
    'LBL_CAMPAIGN_LEAD' => 'Client Potencial',
    'LBL_BIRTHDATE' => 'Data de naixement:',
    'LBL_ASSISTANT_PHONE' => 'Tel. Assistent',
    'LBL_ASSISTANT' => 'Assistent',
    'LBL_CREATED_USER' => 'Usuario Creat',
    'LBL_MODIFIED_USER' => 'Usuario Modificat',
    'LBL_CAMPAIGNS' => 'Campanyes',
    'LBL_CONVERT_MODULE_NAME' => 'Mòdul',
    'LBL_CONVERT_REQUIRED' => 'Requerit',
    'LBL_CONVERT_SELECT' => 'Permetre la selecció',
    'LBL_CONVERT_COPY' => 'Copiar les dades',
    'LBL_CONVERT_EDIT' => 'Editar',
    'LBL_CONVERT_DELETE' => 'Eliminar',
    'LBL_CONVERT_ADD_MODULE' => 'Afegir mòdul',
    'LBL_CREATE' => 'Crear',
    'LBL_SELECT' => ' <b>O</b> Seleccioneu',
    'LBL_WEBSITE' => 'Lloc Web',
    'LNK_IMPORT_LEADS' => 'Importar clients potencials',
//Convert lead tooltips
    'LBL_MODULE_TIP' => 'Mòdul en el que crear un nou registre.',
    'LBL_REQUIRED_TIP' => 'Ha de seleccionar o crear els mòduls requerits abans que el client potencial pugui ser convertit.',
    'LBL_COPY_TIP' => 'Si està seleccionat, els camps del client potencial seran copiats a camps amb el mateix nom en els registres recent creats.',
    'LBL_SELECTION_TIP' => 'Els mòduls amb un camp relacionat a Contactes poden ser seleccionats en lloc de creats durant el procés de conversió del client potencial.',
    'LBL_EDIT_TIP' => 'Modificar el disseny de conversió per aquest mòdul.',
    'LBL_DELETE_TIP' => 'Eliminar aquest mòdul del disseny de conversió.',

    'LBL_ACTIVITIES_MOVE' => 'Moure activitats a',
    'LBL_ACTIVITIES_COPY' => 'Copiar activitats a',
    'LBL_ACTIVITIES_MOVE_HELP' => "Seleccioneu els registres d'activitat que vulgui moure dels clients potencials. Tasques, trucades, reunions, notes i correus electrònics que seran traslladats al registre seleccionat(s).",
    'LBL_ACTIVITIES_COPY_HELP' => "Selecciona el o els registres per cada còpia creada de les activitats dels Clients Potencials. Les noves Tasques, Trucades, Reunions i Notes seran creades per a cada registre seleccionat. Els correus electrònics es relacionaran amb els registres seleccionat(s).",
    //For export labels
    'LBL_CAMPAIGN_ID' => 'ID Campanya',
    'LBL_EDITLAYOUT' => 'Editar Diseny' /*for 508 compliance fix*/,
    'LBL_ENTERDATE' => 'Introduir Data' /*for 508 compliance fix*/,
    'LBL_LOADING' => 'Carregant' /*for 508 compliance fix*/,
    'LBL_EDIT_INLINE' => 'Editar' /*for 508 compliance fix*/,
    'LBL_FP_EVENTS_LEADS_1_FROM_FP_EVENTS_TITLE' => 'Esdeveniments',
    'LBL_WWW' => 'WWW',
);
