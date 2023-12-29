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
    'LBL_MODULE_NAME' => 'Públic Objectiu',
    'LBL_MODULE_ID' => 'Públic Objectiu',
    'LBL_INVITEE' => 'Informa Directament',
    'LBL_MODULE_TITLE' => 'Públic Objectiu: Inici',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Públic Objectiu',
    'LBL_LIST_FORM_TITLE' => 'Llista de Públic Objectiu',
    'LBL_NEW_FORM_TITLE' => 'Nou Públic Objectiu',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_LIST_LAST_NAME' => 'Cognom',
    'LBL_LIST_TITLE' => 'Càrrec',
    'LBL_LIST_EMAIL_ADDRESS' => 'Correu electrònic',
    'LBL_LIST_PHONE' => 'Telèfon',
    'LBL_LIST_FIRST_NAME' => 'Nom',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_ASSIGNED_TO_ID' => 'Assignat a:',
    'LBL_CAMPAIGN_ID' => 'ID Campanya',
    'LBL_EXISTING_ACCOUNT' => 'Usat un compte existent',
    'LBL_CREATED_ACCOUNT' => 'Nova compte creada',
    'LBL_CREATED_CALL' => 'Nova trucada creada',
    'LBL_CREATED_MEETING' => 'Nova reunió creada',
    'LBL_NAME' => 'Nom:',
    'LBL_PROSPECT_INFORMATION' => 'Visió general de la perspectiva', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_MORE_INFORMATION' => 'Més Informació',
    'LBL_FIRST_NAME' => 'Nom:',
    'LBL_OFFICE_PHONE' => 'Tel. Oficina:',
    'LBL_ANY_PHONE' => 'Tel. Qualsevol:',
    'LBL_PHONE' => 'Telèfon:',
    'LBL_LAST_NAME' => 'Cognom:',
    'LBL_MOBILE_PHONE' => 'Mòbil:',
    'LBL_HOME_PHONE' => 'Casa:',
    'LBL_OTHER_PHONE' => 'Tel. Alternatiu:',
    'LBL_FAX_PHONE' => 'Fax:',
    'LBL_PRIMARY_ADDRESS_STREET' => 'Carrer Adreça Principal:',
    'LBL_PRIMARY_ADDRESS_CITY' => 'Ciutat Adreça Principal:',
    'LBL_PRIMARY_ADDRESS_COUNTRY' => 'País Adreça Principal:',
    'LBL_PRIMARY_ADDRESS_STATE' => 'Província/Estat Adreça Principal:',
    'LBL_PRIMARY_ADDRESS_POSTALCODE' => 'CP Adreça Principal:',
    'LBL_ALT_ADDRESS_STREET' => 'Carrer Adreça Alternativa:',
    'LBL_ALT_ADDRESS_CITY' => 'Ciutat Adreça Alternativa:',
    'LBL_ALT_ADDRESS_COUNTRY' => 'País Adreça Alternativa:',
    'LBL_ALT_ADDRESS_STATE' => 'Província/Estat Adreça Alternativa:',
    'LBL_ALT_ADDRESS_POSTALCODE' => 'CP Adreça Alternativa:',
    'LBL_TITLE' => 'Càrrec:',
    'LBL_DEPARTMENT' => 'Departament:',
    'LBL_BIRTHDATE' => 'Data de naixement:',
    'LBL_EMAIL_ADDRESS' => 'Adreça de correu electrònic:',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Correu electrònic alternatiu:',
    'LBL_ANY_EMAIL' => 'Correu electrònic qualsevol:',
    'LBL_ASSISTANT' => 'Assistent:',
    'LBL_ASSISTANT_PHONE' => 'Tel. Assistent:',
    'LBL_DO_NOT_CALL' => 'No Trucar:',
    'LBL_EMAIL_OPT_OUT' => 'Refusar correu electrònic:',
    'LBL_PRIMARY_ADDRESS' => 'Adreça Principal:',
    'LBL_ALTERNATE_ADDRESS' => 'Adreça Alternativa:',
    'LBL_ANY_ADDRESS' => 'Adreça Alternativa:',
    'LBL_CITY' => 'Ciutat:',
    'LBL_STATE' => 'Estat o regió:',
    'LBL_POSTAL_CODE' => 'CP:',
    'LBL_COUNTRY' => 'País:',
    'LBL_ADDRESS_INFORMATION' => 'Informació d\'adreça',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_OPP_NAME' => 'Nom Oportunitat:',
    'LBL_IMPORT_VCARD' => 'Importar vCard',
    'LBL_IMPORT_VCARDTEXT' => 'Crear un nou contacte automàticament important una vCard el seu sistema de fitxers.',
    'LBL_DUPLICATE' => 'Possible Públic Objectiu Duplicat',
    'MSG_SHOW_DUPLICATES' => 'El registre per al prospecte que crearà podria ser un duplicat d\'un altre registre de prospecte existent. Els registres de prospectes amb noms i/o direccions de correu electrònic similars es llisten a continuació.<br>Faci clic a Desar per continuar amb la creació d\'aquest prospecte, o en Cancel·lar per tornar al mòdul sense crear el prospecte.',
    'MSG_DUPLICATE' => 'El registre per al prospecte que crearà podria ser un duplicat d\'un altre registre de prospecte existent. Els registres de prospectes amb noms i/o direccions de correu electrònic similars es llisten a continuació.<br>Faci clic a Desar per continuar amb la creació d\'aquest prospecte, o en Cancel·lar per tornar al mòdul sense crear el prospecte.',
    'LNK_IMPORT_VCARD' => 'Crear desde vCard',
    'LNK_NEW_ACCOUNT' => 'Crear Compte',
    'LNK_NEW_OPPORTUNITY' => 'Crear Oportunitat',
    'LNK_NEW_CASE' => 'Crear Cas',
    'LNK_NEW_NOTE' => 'Crear Nota o Adjunt',
    'LNK_NEW_CALL' => 'Planificar Trucada',
    'LNK_NEW_EMAIL' => 'Arxivar correu electrònic',
    'LNK_NEW_MEETING' => 'Planificar Reunió',
    'LNK_NEW_TASK' => 'Crear Tasca',
    'LNK_NEW_APPOINTMENT' => 'Crear Cita',
    'LNK_IMPORT_PROSPECTS' => 'Importar Públic Objectiu',
    'NTC_DELETE_CONFIRMATION' => 'Està segur que desitja eliminar aquest registre?',
    'NTC_REMOVE_CONFIRMATION' => 'Està segur que desitja treure aquest contacte del cas?',
    'ERR_DELETE_RECORD' => 'Ha d\'especificar un número de registre per eliminar el contacte.',
    'LBL_SALUTATION' => 'Salutació',
    'LBL_CREATED_OPPORTUNITY' => 'Crear una nova oportunitat',
    'LNK_SELECT_ACCOUNT' => "Seleccionar Compte",
    'LNK_NEW_PROSPECT' => 'Crear Públic Objectiu',
    'LNK_PROSPECT_LIST' => 'Públic Objectiu',
    'LNK_NEW_CAMPAIGN' => 'Crear Campanya',
    'LNK_CAMPAIGN_LIST' => 'Campanyes',
    'LNK_NEW_PROSPECT_LIST' => 'Crear Llista de Públic Objectiu',
    'LNK_PROSPECT_LIST_LIST' => 'Llistes de Públic Objectiu',
    'LBL_SELECT_CHECKED_BUTTON_LABEL' => 'Seleccioni Públic Objectiu Marcat',
    'LBL_SELECT_CHECKED_BUTTON_TITLE' => 'Seleccioni Públic Objectiu Marcat',
    'LBL_INVALID_EMAIL' => 'Correu electrònic no vàlid:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Públic Objectiu',
    'LBL_PROSPECT_LIST' => 'Públic Objectiu',
    'LBL_CONVERT_BUTTON_TITLE' => 'Convertir Públic Objectiu',
    'LBL_CONVERT_BUTTON_LABEL' => 'Convertir Públic Objectiu',
    'LNK_NEW_CONTACT' => 'Nou Contacte',
    'LBL_CREATED_CONTACT' => "S'ha creat un nou contacte",
    'LBL_CAMPAIGNS' => 'Campanyes',
    'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE' => 'Registre de Campanyes',
    'LBL_TRACKER_KEY' => 'Clau de Seguiment',
    'LBL_LEAD_ID' => 'Id Client Potencial',
    'LBL_CONVERTED_LEAD' => 'Client Potencial Convertit',
    'LBL_ACCOUNT_NAME' => 'Nom de Compte:',
    'LBL_EDIT_ACCOUNT_NAME' => 'Nom de Compte:',
    'LBL_CREATED_USER' => 'Usuari Creat',
    'LBL_MODIFIED_USER' => 'Usuari Modificat',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    //For export labels
    'LBL_FP_EVENTS_PROSPECTS_1_FROM_FP_EVENTS_TITLE' => 'Esdeveniments',
);
