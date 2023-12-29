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
    'LBL_ALL_MODULES' => 'Todos',//rost fix
    'LBL_ASSIGNED_TO_ID' => 'Id de usuario asignado',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creación',
    'LBL_DATE_MODIFIED' => 'Data de Modificación',
    'LBL_MODIFIED' => 'Modificado por',
    'LBL_MODIFIED_NAME' => 'Modificado por Nome',
    'LBL_CREATED' => 'Creado por',
    'LBL_DESCRIPTION' => 'Descrición',
    'LBL_DELETED' => 'Borrado',
    'LBL_NONINHERITABLE' => 'Non herdable',
    'LBL_LIST_NONINHERITABLE' => 'Non herdable',
    'LBL_NAME' => 'Nome',
    'LBL_CREATED_USER' => 'Creado polo Usuario',
    'LBL_MODIFIED_USER' => 'Modificado polo Usuario',
    'LBL_LIST_FORM_TITLE' => 'Grupos de Seguridade',
    'LBL_MODULE_NAME' => 'Xestión de Seguridade',
    'LBL_MODULE_TITLE' => 'Xestión de Seguridade',
    'LNK_NEW_RECORD' => 'Crea un Grupo de Seguridade',
    'LNK_LIST' => 'Ver Lista',
    'LBL_SEARCH_FORM_TITLE' => 'Buscar en Administración de Suite de Seguridade',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => 'Xestión de Seguridade',
    'LBL_USERS' => 'Usuarios',
    'LBL_USERS_SUBPANEL_TITLE' => 'Usuarios',
    'LBL_ROLES_SUBPANEL_TITLE' => 'Roles',
    'LBL_ROLES' => 'Roles',

    'LBL_CONFIGURE_SETTINGS' => 'Configurar',
    'LBL_ADDITIVE' => 'Privilexios agregados',
    'LBL_ADDITIVE_DESC' => "O Usuario ten os maiores privilexios de todos os roles e grupos asignados a el.",
    'LBL_STRICT_RIGHTS' => 'Privilexios terminante',
    'LBL_STRICT_RIGHTS_DESC' => "Se un usuario é un membro de varios grupos soamente as dereitas respectivas do grupo asignado ao rexistro en curso se utilizan.",
    'LBL_USER_ROLE_PRECEDENCE' => 'Precedencia do Rol de Usuario',
    'LBL_USER_ROLE_PRECEDENCE_DESC' => 'Se calquera rol é asignado ao usuario directamente, este tenrá precedencia sobre calquera rol de grupo.',
    'LBL_INHERIT_TITLE' => 'Regras de herdanza de Grupo',
    'LBL_INHERIT_TITLE_DESC' => 'As regras de herdanza de grupos aplícanse exclusivamente no momento da creación do rexistro.',
    'LBL_INHERIT_CREATOR' => 'Herda do Usuario que o creo',
    'LBL_INHERIT_CREATOR_DESC' => 'O rexistro herdará todos os Grupos asignados ao usuario que o creou.',
    'LBL_INHERIT_PARENT' => 'Herda do rexistro pai',
    'LBL_INHERIT_PARENT_DESC' => 'Ex: Se un caso é creado por un contacto, o caso herdará o/os Grupo(s) asociados co contacto.',
    'LBL_USER_POPUP' => 'Ventá de Novo Usuario de Grupo',
    'LBL_USER_POPUP_DESC' => 'Cando se crea un novo Usuario, mostra unha ventá de SecurityGroups para asignar o usuario a Grupo(s).',
    'LBL_INHERIT_ASSIGNED' => 'Herdar de Usuario asignado',
    'LBL_INHERIT_ASSIGNED_DESC' => 'O rexistro herdará todos os grupos do usuario asignado ao rexistro. Outros grupos asignados ao rexistro non serán removidos.',
    'LBL_POPUP_SELECT' => 'Utilice Creador Seleccionar grupo',
    'LBL_POPUP_SELECT_DESC' => 'Cando un rexistro se crea por un usuario en máis dun grupo mostran un panel de selección de grupos na pantalla de creación. Do contrario herdar ese grupo.',
    'LBL_FILTER_USER_LIST' => 'Lista de usuario do filtro',
    'LBL_FILTER_USER_LIST_DESC' => "Os usuarios Non-admin poden asignar soamente aos usuarios nos mesmos grupo(s)",

    'LBL_DEFAULT_GROUP_TITLE' => 'Grupo por defecto para novos rexistros',
    'LBL_ADD_BUTTON_LABEL' => 'Agregar',
    'LBL_REMOVE_BUTTON_LABEL' => 'Quitar',
    'LBL_GROUP' => 'Grupo:',
    'LBL_MODULE' => 'Modulo:',

    'LBL_MASS_ASSIGN' => 'Grupos de Seguridade: Asignación Masiva',
    'LBL_ASSIGN' => 'Asignar',
    'LBL_REMOVE' => 'Quitar',
    'LBL_ASSIGN_CONFIRM' => 'Está seguro que quere agregar este Grupo de ',
    'LBL_REMOVE_CONFIRM' => 'Está seguro que quere remover este Grupo de ',
    'LBL_CONFIRM_END' => ' rexistro(s) seleccionado(s)?',

    'LBL_SECURITYGROUP_USER_FORM_TITLE' => 'GrupoDeSeguridade/Usuario',
    'LBL_USER_NAME' => 'Nome de Usuario',
    'LBL_SECURITYGROUP_NAME' => 'Nome de Grupo de Seguridade',
    'LBL_HOMEPAGE_TITLE' => 'Mensaxes do Grupo',
    'LBL_TITLE' => 'Titulo',
    'LBL_ROWS' => 'Filas',
    'LBL_POST' => 'Enviar',
    'LBL_SELECT_GROUP_ERROR' => 'Por favor seleccione un Grupo e volva a intentalo.',

    'LBL_GROUP_SELECT' => 'Seleccionar os grupos deben ter acceso a este rexistro',
    'LBL_ERROR_DUPLICATE' => 'Debido a un posible duplicado detectado por SuiteCRM vostede terá que agregar manualmente os grupos de seguridade do seu rexistro recén creado.',
    'LBL_ERROR_EXPORT_WHERE_CHANGED' => 'A actualización fallou porque se modificou o filtro de busca. Inténtao de novo.', // PR 7999

    'LBL_INBOUND_EMAIL' => 'Conta de correo electrónico entrante',
    'LBL_INBOUND_EMAIL_DESC' => 'Só permitir o acceso a unha conta de correo electrónico se o usuario pertence a un grupo que se asigna á conta de correo.',
    'LBL_PRIMARY_GROUP' => 'Grupo Principal',
    'LBL_CHECKMARK' => 'Marca de Verificación',

);
