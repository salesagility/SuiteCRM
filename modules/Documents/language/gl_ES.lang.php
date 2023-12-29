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
    'LBL_MODULE_NAME' => 'Documentos',
    'LBL_MODULE_TITLE' => 'Documentos: Inicio',
    'LNK_NEW_DOCUMENT' => 'Crear Documento',
    'LNK_DOCUMENT_LIST' => 'Ver Documentos',
    'LBL_DOC_REV_HEADER' => 'Versións',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Documentos',
    //vardef labels
    'LBL_NAME' => 'Nome de Documento',
    'LBL_DESCRIPTION' => 'Descrición',
    'LBL_CATEGORY' => 'Categoría',
    'LBL_SUBCATEGORY' => 'Subcategoría',
    'LBL_STATUS' => 'Estado',
    'LBL_CREATED_BY' => 'Creado por',
    'LBL_DATE_ENTERED' => 'Data de Creación',
    'LBL_DATE_MODIFIED' => 'Data de Modificación',
    'LBL_DELETED' => 'Eliminado',
    'LBL_MODIFIED' => 'Modificado por ID',
    'LBL_MODIFIED_USER' => 'Modificado por',
    'LBL_CREATED' => 'Creado por',
    'LBL_REVISIONS' => 'Versións',
    'LBL_RELATED_DOCUMENT_ID' => 'ID de Documento Relacionado',
    'LBL_RELATED_DOCUMENT_REVISION_ID' => 'ID de Versión de Documento Relacionado',
    'LBL_IS_TEMPLATE' => 'É unha Plantilla',
    'LBL_TEMPLATE_TYPE' => 'Tipo de Documento',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
    'LBL_REVISION_NAME' => 'Número de Versión',
    'LBL_MIME' => 'Tipo MIME',
    'LBL_REVISION' => 'Versión',
    'LBL_DOCUMENT' => 'Documento Relacionado',
    'LBL_LATEST_REVISION' => 'Última Versión',
    'LBL_CHANGE_LOG' => 'Historial de Cambios:',
    'LBL_ACTIVE_DATE' => 'Data de Publicación',
    'LBL_EXPIRATION_DATE' => 'Data de Caducidade',
    'LBL_FILE_EXTENSION' => 'Extensión de Arquivo',
    'LBL_LAST_REV_MIME_TYPE' => 'Tipo MIME da última versión',
    'LBL_CAT_OR_SUBCAT_UNSPEC' => 'Sen especificar',
    'LBL_HOMEPAGE_TITLE' => 'Os Meus documentos',
    //quick search
    'LBL_NEW_FORM_TITLE' => 'Novo Documento',
    //document edit and detail view
    'LBL_DOC_NAME' => 'Nome de Documento:',
    'LBL_FILENAME' => 'Nome de Arquivo:',
    'LBL_LIST_FILENAME' => 'Arquivo:',
    'LBL_DOC_VERSION' => 'Versión:',
    'LBL_FILE_UPLOAD' => 'Arquivo:',

    'LBL_CATEGORY_VALUE' => 'Categoría:',
    'LBL_LIST_CATEGORY' => 'Categoría',
    'LBL_SUBCATEGORY_VALUE' => 'Subcategoría:',
    'LBL_DOC_STATUS' => 'Estado:',
    'LBL_LAST_REV_CREATOR' => 'Versión Creada Por:',
    'LBL_LASTEST_REVISION_NAME' => 'Nome da última versión:',
    'LBL_SELECTED_REVISION_NAME' => 'Nome da versión seleccionada:',
    'LBL_CONTRACT_STATUS' => 'Estado do contrato:',
    'LBL_CONTRACT_NAME' => 'Nome do Contrato:',
    'LBL_DET_RELATED_DOCUMENT' => 'Documento Relacionado:',
    'LBL_DET_RELATED_DOCUMENT_VERSION' => "Versión de Documento Relacionado:",
    'LBL_DET_IS_TEMPLATE' => '¿Plantilla? :',
    'LBL_DET_TEMPLATE_TYPE' => 'Tipo de Documento:',
    'LBL_DOC_DESCRIPTION' => 'Descrición:',
    'LBL_DOC_ACTIVE_DATE' => 'Data de Publicación:',
    'LBL_DOC_EXP_DATE' => 'Data de Caducidade:',

    //document list view.
    'LBL_LIST_FORM_TITLE' => 'Lista de Documentos',
    'LBL_LIST_DOCUMENT' => 'Documento',
    'LBL_LIST_SUBCATEGORY' => 'Subcategoría',
    'LBL_LIST_REVISION' => 'Versión',
    'LBL_LIST_LAST_REV_CREATOR' => 'Publicado Por',
    'LBL_LIST_LAST_REV_DATE' => 'Data de Versión',
    'LBL_LIST_VIEW_DOCUMENT' => 'Ver',
    'LBL_LIST_ACTIVE_DATE' => 'Data de Publicación',
    'LBL_LIST_EXP_DATE' => 'Data de Caducidade',
    'LBL_LIST_STATUS' => 'Estado',
    'LBL_LINKED_ID' => 'Id enlace',
    'LBL_SELECTED_REVISION_ID' => 'Id de versión seleccionada',
    'LBL_LATEST_REVISION_ID' => 'Id de última versión',
    'LBL_SELECTED_REVISION_FILENAME' => 'Nome de arquivo de versión seleccionada',
    'LBL_FILE_URL' => 'URL do arquivo',

    //document search form.
    'LBL_SF_CATEGORY' => 'Categoría:',
    'LBL_SF_SUBCATEGORY' => 'Subcategoría:',

    'DEF_CREATE_LOG' => 'Documento Creado',

    //erro messages
    'ERR_DOC_NAME' => 'Nome de Documento',
    'ERR_DOC_ACTIVE_DATE' => 'Data de Publicación',
    'ERR_FILENAME' => 'Nome de Arquivo',
    'ERR_DOC_VERSION' => 'Versión de Documento',
    'ERR_DELETE_CONFIRM' => '¿Desexa eliminar esta versión do documento?',
    'ERR_DELETE_LATEST_VERSION' => 'Non ten permisos para eliminar a última versión dun documento.',
    'LNK_NEW_MAIL_MERGE' => 'Combinar Correspondencia',
    'ERR_MISSING_FILE' => 'Este documento non se encontra un arquivo, é moi probable que o erro se xerara durante a carga. Por favor volva a intentar cargar o arquivo ou póñase en contacto co seu administrador.',

    //sub-panel vardefs.
    'LBL_LIST_DOCUMENT_NAME' => 'Nome',
    'LBL_LIST_IS_TEMPLATE' => '¿Plantilla?',
    'LBL_LIST_TEMPLATE_TYPE' => 'Tipo de Documento',
    'LBL_LAST_REV_CREATE_DATE' => 'Data de Creación de Última Versión',
    'LBL_CONTRACTS' => 'Contratos',
    'LBL_CREATED_USER' => 'Usuario Creado',
    'LBL_DOCUMENT_INFORMATION' => 'Visión Global', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_DOC_ID' => 'ID do documento',
    'LBL_DOC_TYPE' => 'Fonte',
    'LBL_DOC_TYPE_POPUP' => 'Seleccione unha orixe para que este documento sexa cargado <br> e do cal estará dispoñible.',
    'LBL_DOC_URL' => 'URL do documento',
    'LBL_SEARCH_EXTERNAL_DOCUMENT' => 'Nome de Arquivo',
    'LBL_EXTERNAL_DOCUMENT_NOTE' => 'Os primeiros 20 arquivos modificados máis recentemente móstranse en orde descendente na lista a continuación. Use a busca para encontrar outros arquivos.',
    'LBL_LIST_EXT_DOCUMENT_NAME' => 'Nome de Arquivo',
    'ERR_INVALID_EXTERNAL_API_ACCESS' => 'O usuario intentou acceder a unha API externa non válida ({0})',
    'ERR_INVALID_EXTERNAL_API_LOGIN' => 'A comprobación de inicio de sesión foi errónea para a API externa ({0})',

    // Links around the world
    'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Contas',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
    'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Oportunidades',
    'LBL_CASES_SUBPANEL_TITLE' => 'Casos',
    'LBL_BUGS_SUBPANEL_TITLE' => 'Incidencias',

    'LBL_AOS_CONTRACTS' => 'Contratos',
);