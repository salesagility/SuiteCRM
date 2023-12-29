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
    'LBL_ADD_DOCUMENT' => 'Afegir un document',
    'LBL_ADD_FILE' => 'Afegir un arxiu',
    'LBL_ATTACHMENTS' => 'Adjunts',
    'LBL_BODY' => 'Cos:',
    'LBL_CLOSE' => 'Tancat:',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_EDIT_ALT_TEXT' => 'Editar Text Plà',
    'LBL_EMAIL_ATTACHMENT' => 'Adjunt de correu electrònic',
    'LBL_HIDE_ALT_TEXT' => 'Ocultar el text pla',
    'LBL_HTML_BODY' => 'Cos HTML',
    'LBL_INSERT_VARIABLE' => 'Insertar Variable:',
    'LBL_INSERT_URL_REF' => 'Insertar Referència a URL',
    'LBL_INSERT_TRACKER_URL' => 'Insertar URL de Seguiment:',
    'LBL_INSERT' => 'Insertar',
    'LBL_LIST_DATE_MODIFIED' => 'Última Modificació',
    'LBL_LIST_DESCRIPTION' => 'Descripció',
    'LBL_LIST_FORM_TITLE' => 'Llista de plantilles de correu electrònic',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_MODULE_NAME' => 'Plantilles de correu electrònic',
    'LBL_MODULE_TITLE' => 'Plantilles de correu electrònic: Inici',
    'LBL_NAME' => 'Nom:',
    'LBL_NEW_FORM_TITLE' => 'Crear plantilla de correu electrònic',
    'LBL_PUBLISH' => 'Publicació:',
    'LBL_RELATED_TO' => 'Relacionat amb:',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de plantilles de correu electrònic',
    'LBL_SHOW_ALT_TEXT' => 'Mostrar Text Plà',
    'LBL_SUBJECT' => 'Assumpte:',
    'LBL_SUITE_DOCUMENT' => 'Document',
    'LBL_UPLOAD_FILE' => 'Subir fichero',
    'LBL_TEXT_BODY' => 'Cos de Text',
    'LBL_USERS' => 'Usuaris',

    'LNK_EMAIL_TEMPLATE_LIST' => 'Veure plantilles de correu electrònic',
    'LNK_IMPORT_NOTES' => 'Importar Notes',
    'LNK_NEW_EMAIL_TEMPLATE' => 'Crear plantilla de correu electrònic',
    'LNK_NEW_EMAIL' => 'Arxivar correu electrònic',
    'LNK_NEW_SEND_EMAIL' => 'Redactar correu electrònic',
    'LNK_SENT_EMAIL_LIST' => 'Correus electrònics enviats',
    'LNK_VIEW_CALENDAR' => 'Avui',
    // for Inbox
    'LBL_NEW' => 'Nou',
    'LNK_MY_DRAFTS' => 'Borradors',
    'LNK_MY_INBOX' => 'El meu correu electrònic',
    'LBL_TEXT_ONLY' => 'Només Text',
    'LBL_SEND_AS_TEXT' => 'Enviar Només Text',
    'LBL_ACCOUNT' => 'Compte',
    'LBL_FROM_NAME' => 'Nom del Remitent',
    'LBL_PLAIN_TEXT' => 'Text Plà',
    'LBL_CREATED_BY' => 'Creat Per',
    'LBL_PUBLISHED' => 'Publicat',
    'LNK_VIEW_MY_INBOX' => 'Veure els meus correus eletrònics',
    'LBL_ASSIGNED_TO_ID' => 'Assignat a',
    'LBL_EDIT_LAYOUT' => 'Editar Diseny' /*for 508 compliance fix*/,
    'LBL_SELECT' => 'Seleccionar' /*for 508 compliance fix*/,
    'LBL_ID_FF_CLEAR' => 'Netejar' /*for 508 compliance fix*/,
    'LBL_TYPE' => 'Tipus',
    'LBL_WIDTH' => 'Ample per defecte',
    'LNK_IMPORT_CAMPAIGNS' => 'Importar Campanya',
);