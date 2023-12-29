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
    //module
    'LBL_MODULE_NAME' => 'Documents',
    'LBL_MODULE_TITLE' => 'Documents: Inici',
    'LNK_NEW_DOCUMENT' => 'Crear Document',
    'LNK_DOCUMENT_LIST' => 'Llista de Documents',
    'LBL_DOC_REV_HEADER' => 'Versions',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Documents',
    //vardef labels
    'LBL_NAME' => 'Nom de Document',
    'LBL_DESCRIPTION' => 'Descripció',
    'LBL_CATEGORY' => 'Categoria',
    'LBL_SUBCATEGORY' => 'Subcategoría',
    'LBL_STATUS' => 'Estat',
    'LBL_CREATED_BY' => 'Creat per',
    'LBL_DATE_ENTERED' => 'Data Creación',
    'LBL_DATE_MODIFIED' => 'Data Modificació',
    'LBL_DELETED' => 'Eliminat',
    'LBL_MODIFIED' => 'Modificat per ID',
    'LBL_MODIFIED_USER' => 'Modificat per',
    'LBL_CREATED' => 'Creat per',
    'LBL_REVISIONS' => 'Versions',
    'LBL_RELATED_DOCUMENT_ID' => 'ID de Document Relacionat',
    'LBL_RELATED_DOCUMENT_REVISION_ID' => 'ID de Versió de Document Relacionat',
    'LBL_IS_TEMPLATE' => 'Es una Plantilla',
    'LBL_TEMPLATE_TYPE' => 'Tipus de Document',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a:',
    'LBL_REVISION_NAME' => 'Número de Versió',
    'LBL_MIME' => 'Tipus MIME',
    'LBL_REVISION' => 'Versió',
    'LBL_DOCUMENT' => 'Document Relacionat',
    'LBL_LATEST_REVISION' => 'Última Versió',
    'LBL_CHANGE_LOG' => 'Historial de Canvis:',
    'LBL_ACTIVE_DATE' => 'Data de Publicació',
    'LBL_EXPIRATION_DATE' => 'Data de Caducitat',
    'LBL_FILE_EXTENSION' => 'Extensió d\'Arxiu',
    'LBL_LAST_REV_MIME_TYPE' => 'Última revisió del tipus MIME',
    'LBL_CAT_OR_SUBCAT_UNSPEC' => 'Sense especificar',
    'LBL_HOMEPAGE_TITLE' => 'Els meus documents',
    //quick search
    'LBL_NEW_FORM_TITLE' => 'Nou Document',
    //document edit and detail view
    'LBL_DOC_NAME' => 'Nom de Document:',
    'LBL_FILENAME' => 'Nom d\'Arxiu:',
    'LBL_LIST_FILENAME' => 'Nom d\'Arxiu',
    'LBL_DOC_VERSION' => 'Versió:',
    'LBL_FILE_UPLOAD' => 'Nom d\'Arxiu',

    'LBL_CATEGORY_VALUE' => 'Categoria:',
    'LBL_LIST_CATEGORY' => 'Categoría',
    'LBL_SUBCATEGORY_VALUE' => 'Subcategoría:',
    'LBL_DOC_STATUS' => 'Estat:',
    'LBL_LAST_REV_CREATOR' => 'Versió Creada Per:',
    'LBL_LASTEST_REVISION_NAME' => 'Nom de la última versió:',
    'LBL_SELECTED_REVISION_NAME' => 'Nom de la versió seleccionada:',
    'LBL_CONTRACT_STATUS' => 'Estat del contracte:',
    'LBL_CONTRACT_NAME' => 'Nom de Contracte:',
    'LBL_DET_RELATED_DOCUMENT' => 'Document Relacionat:',
    'LBL_DET_RELATED_DOCUMENT_VERSION' => "Versió de Document Relacionat:",
    'LBL_DET_IS_TEMPLATE' => 'Plantilla? :',
    'LBL_DET_TEMPLATE_TYPE' => 'Tipus de Document:',
    'LBL_DOC_DESCRIPTION' => 'Descripció:',
    'LBL_DOC_ACTIVE_DATE' => 'Data de Publicació:',
    'LBL_DOC_EXP_DATE' => 'Data de Caducitat:',

    //document list view.
    'LBL_LIST_FORM_TITLE' => 'Llista de Documents',
    'LBL_LIST_DOCUMENT' => 'Document',
    'LBL_LIST_SUBCATEGORY' => 'Subcategoría',
    'LBL_LIST_REVISION' => 'Versió',
    'LBL_LIST_LAST_REV_CREATOR' => 'Publicat Per',
    'LBL_LIST_LAST_REV_DATE' => 'Data de Versió',
    'LBL_LIST_VIEW_DOCUMENT' => 'Veure',
    'LBL_LIST_ACTIVE_DATE' => 'Data de Publicació',
    'LBL_LIST_EXP_DATE' => 'Data de Caducitat',
    'LBL_LIST_STATUS' => 'Estat',
    'LBL_LINKED_ID' => 'Id enllaç',
    'LBL_SELECTED_REVISION_ID' => 'Id de la versió seleccionada',
    'LBL_LATEST_REVISION_ID' => 'Id de l\'última versió',
    'LBL_SELECTED_REVISION_FILENAME' => 'Nom del fitxer de la versió seleccionada',
    'LBL_FILE_URL' => 'URL del fitxer',

    //document search form.
    'LBL_SF_CATEGORY' => 'Categoría:',
    'LBL_SF_SUBCATEGORY' => 'Subcategoría:',

    'DEF_CREATE_LOG' => 'Document Creat',

    //error messages
    'ERR_DOC_NAME' => 'Nom de Document',
    'ERR_DOC_ACTIVE_DATE' => 'Data de Publicació',
    'ERR_FILENAME' => 'Nom d\'Arxiu',
    'ERR_DOC_VERSION' => 'Versió de Document',
    'ERR_DELETE_CONFIRM' => 'Desitja eliminar aquesta versió del document?',
    'ERR_DELETE_LATEST_VERSION' => 'No té permisos per eliminar l\'última versió d\'un document.',
    'LNK_NEW_MAIL_MERGE' => 'Combinar Correspondència',
    'ERR_MISSING_FILE' => 'Aquest document no es troba cap arxiu, molt probablement a causa d\'un error durant la càrrega. Si us plau torneu a intentar carregar el fitxer o poseu-vos en contacte amb l\'administrador.',

    //sub-panel vardefs.
    'LBL_LIST_DOCUMENT_NAME' => 'Nom de Document',
    'LBL_LIST_IS_TEMPLATE' => 'Plantilla?',
    'LBL_LIST_TEMPLATE_TYPE' => 'Tipus de Document',
    'LBL_LAST_REV_CREATE_DATE' => 'Data de Creació de l\'Última Versió',
    'LBL_CONTRACTS' => 'Contractes',
    'LBL_CREATED_USER' => 'Usuari Creat',
    'LBL_DOCUMENT_INFORMATION' => 'Visió general del document', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_DOC_ID' => 'Id del document',
    'LBL_DOC_TYPE' => 'Font',
    'LBL_DOC_TYPE_POPUP' => 'Seleccioni l\'origen on serà carregat aquest document <br> i del qual estarà disponible. ',
    'LBL_DOC_URL' => 'URL del document',
    'LBL_SEARCH_EXTERNAL_DOCUMENT' => 'Nom d\'Arxiu',
    'LBL_EXTERNAL_DOCUMENT_NOTE' => 'Els primers 20 arxius més recentment modificats es mostren en ordre descendent en la llista de baix. Utilitzeu la cerca per a trobar altres arxius.',
    'LBL_LIST_EXT_DOCUMENT_NAME' => 'Nom d\'Arxiu',
    'ERR_INVALID_EXTERNAL_API_ACCESS' => 'L\'usuari ha intentat accedir a una API externa no vàlida ({0})',
    'ERR_INVALID_EXTERNAL_API_LOGIN' => 'La comprovació d\'inici de sessió a una API externa ha fallat ({0})',

    // Links around the world
    'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Comptes',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Oportunitats',
    'LBL_CASES_SUBPANEL_TITLE' => 'Casos',
    'LBL_BUGS_SUBPANEL_TITLE' => 'Seguiment d\'Incidències',

    'LBL_AOS_CONTRACTS' => 'Contractes',
);