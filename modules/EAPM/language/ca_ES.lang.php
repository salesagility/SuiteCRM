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
    'LBL_ASSIGNED_TO_ID' => 'ID Usuari Assignat',
    'LBL_ASSIGNED_TO_NAME' => 'Usuari de SuiteCRM',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creació',
    'LBL_DATE_MODIFIED' => 'Última Modificació',
    'LBL_MODIFIED' => 'Modificat Per',
    'LBL_MODIFIED_NAME' => 'Modificat per Nom',
    'LBL_CREATED' => 'Creat Per',
    'LBL_DESCRIPTION' => 'Descripció',
    'LBL_DELETED' => 'Esborrat',
    'LBL_NAME' => 'Nom d\'usuari de l\'aplicació',
    'LBL_CREATED_USER' => 'Creat per l\'usuari',
    'LBL_MODIFIED_USER' => 'Modificat per l\'usuari',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_LIST_FORM_TITLE' => 'Llista de comptes externs',
    'LBL_MODULE_NAME' => 'Compta externa',
    'LBL_MODULE_TITLE' => 'Comptes externes',
    'LBL_HOMEPAGE_TITLE' => 'Les meves comptes externes',
    'LNK_NEW_RECORD' => 'Crear compta externa',
    'LNK_LIST' => 'Veure comptes externes',
    'LBL_SEARCH_FORM_TITLE' => 'Cercar fonts externes',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Veure Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_NEW_FORM_TITLE' => 'Nova compta externa',
    'LBL_PASSWORD' => 'Contrasenya de l\'aplicació',
    'LBL_USER_NAME' => 'Nom d\'usuari de l\'aplicació',
    'LBL_URL' => 'URL',
    'LBL_APPLICATION' => 'Aplicació',
    'LBL_API_DATA' => 'Dades de la API',
    'LBL_API_CONSKEY' => 'Clau del consumidor',
    'LBL_API_CONSSECRET' => 'Secret del consumidor',
    'LBL_API_OAUTHTOKEN' => 'Token d\'OAuth',
    'LBL_AUTH_UNSUPPORTED' => "Aquest mètode d'autorització no és suportat per l'aplicació",
    'LBL_AUTH_ERROR' => 'L\'intent de conectar-se a aquest compte ha fallat.',
    'LBL_VALIDATED' => 'Connectat',
    'LBL_ACTIVE' => 'Actiu',
    'LBL_OAUTH_NAME' => '%s',
    'LBL_CONNECT_BUTTON_TITLE' => 'Connectar',
    'LBL_NOTE' => 'Tingui en compte',
    'LBL_CONNECTED' => 'Connectat',

    'LBL_ERR_NO_AUTHINFO' => 'No hi ha informació d\'autenticació per aquesta compta.',
    'LBL_ERR_NO_TOKEN' => 'No hi ha tokens d\'inici de sessió vàlids per aquesta compta.',

    'LBL_ERR_FAILED_QUICKCHECK' => 'Vostè no està connectat a la seva compta {0}. Cliqui Acceptar per a accedir a la seva compta i tornar a activar la connexió.',

    'LBL_CLICK_TO_EDIT' => 'Feu clic per editar',

    // Various strings used throughout the external account modules
    'LBL_REAUTHENTICATE_LABEL' => 'Reautenticar',
    'LBL_APPLICATION_FOUND_NOTICE' => 'Ja existeix un compte per aquesta aplicació. S\'ha restituït la compta existent.',
    'LBL_OMIT_URL' => '(Ometre http:// o https://)',
    'LBL_OAUTH_SAVE_NOTICE' => 'Cliqui <b>Connectar</b> per a dirigir-se a una pàgina per a proporcionar informació de la seva compta i autoritzar l\'accés a la compta per SuiteCRM. Després de connectar, se\'l redirigeix a SuiteCRM de nou.',
    'LBL_BASIC_SAVE_NOTICE' => 'Faci clic a <b>Conectar</b> per a connectar aquesta compta a SuiteCRM.',
    'LBL_ERR_POPUPS_DISABLED' => 'Si us plau habiliti les finestres emergents en el navegador, o afegiu una excepció per al lloc web "{0}" per poder connectar-se.',

    'LBL_API_OAUTHSECRET' => 'API OAuth Secret',
);
