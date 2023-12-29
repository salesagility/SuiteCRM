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
    'LBL_ALL_MODULES' => 'Tots', //rost fix
    'LBL_ASSIGNED_TO_ID' => 'ID Usuari Assignat',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creació',
    'LBL_DATE_MODIFIED' => 'Última Modificació',
    'LBL_MODIFIED' => 'Modificat Per',
    'LBL_MODIFIED_NAME' => 'Modificat per Nom',
    'LBL_CREATED' => 'Creat Per',
    'LBL_DESCRIPTION' => 'Descripció',
    'LBL_DELETED' => 'Esborrat',
    'LBL_NONINHERITABLE' => 'No heretable',
    'LBL_LIST_NONINHERITABLE' => 'No heretable',
    'LBL_NAME' => 'Nom',
    'LBL_CREATED_USER' => 'Creat per Usuari',
    'LBL_MODIFIED_USER' => 'Modificat per Usuari',
    'LBL_LIST_FORM_TITLE' => 'Grups de Seguretat',
    'LBL_MODULE_NAME' => 'Grups de seguretat',
    'LBL_MODULE_TITLE' => 'Grups de seguretat',
    'LNK_NEW_RECORD' => 'Crea un Grup de Seguretat',
    'LNK_LIST' => 'Mostra els Grups de Seguretat',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca Grups de Seguretat',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => 'Grups de Seguretat',
    'LBL_USERS' => 'Usuaris',
    'LBL_USERS_SUBPANEL_TITLE' => 'Usuaris',
    'LBL_ROLES_SUBPANEL_TITLE' => 'Rols',
    'LBL_ROLES' => 'Rols',

    'LBL_CONFIGURE_SETTINGS' => 'Configuració',
    'LBL_ADDITIVE' => 'Privilegis agregats',
    'LBL_ADDITIVE_DESC' => "L'usuari té els majors privilegis de tots els rols i grups assignats a ell.",
    'LBL_STRICT_RIGHTS' => 'Privilegis estrictes',
    'LBL_STRICT_RIGHTS_DESC' => "Si un usuari és membre de diversos grups s'apliquen només els privilegis del grup assignat al registre actual.",
    'LBL_USER_ROLE_PRECEDENCE' => "Precedència del rol d'usuari",
    'LBL_USER_ROLE_PRECEDENCE_DESC' => "Qualsevol rol assignat directament a l'usuari tindrà precedència sobre qualsevol rol de grup.",
    'LBL_INHERIT_TITLE' => "Regles d'herència de grup",
    'LBL_INHERIT_TITLE_DESC' => "Les regles d'herència de grups s'apliquen exclusivament en el moment de la creació del registre.",
    'LBL_INHERIT_CREATOR' => "Hereta de l'usuari creador",
    'LBL_INHERIT_CREATOR_DESC' => "El registre heretarà tots els grups de l'usuari que l'ha creat.",
    'LBL_INHERIT_PARENT' => 'Hereta del registre pare',
    'LBL_INHERIT_PARENT_DESC' => 'El registre heretarà tots els grups de tots els registres amb els quals estigui relacionat.',
    'LBL_USER_POPUP' => 'Finestra de grups del nou usuari',
    'LBL_USER_POPUP_DESC' => "Quan es creï un nou usuari mostra una finestra emergent per assignar l'usuari als grups que s'escaigui.",
    'LBL_INHERIT_ASSIGNED' => "Hereta de l'usuari assignat",
    'LBL_INHERIT_ASSIGNED_DESC' => "El registre heretarà tots els grups de l'usuari assignat.",
    'LBL_POPUP_SELECT' => 'Mostra el selector de grups',
    'LBL_POPUP_SELECT_DESC' => "Quan un registre és creat per un usuari que està assignat a més d'un grup, es mostra un selector de grups en pantalla. En cas contrari, el registre hereta directament l'únic grup de l'usuari.",
    'LBL_FILTER_USER_LIST' => "Filtra la llista d'usuaris",
    'LBL_FILTER_USER_LIST_DESC' => 'Els usuaris no administradors només poden assignar registres als usuaris dels grups als quals pertanyen.',

    'LBL_DEFAULT_GROUP_TITLE' => 'Grup per defecte per a nous registres',
    'LBL_ADD_BUTTON_LABEL' => 'Afegeix',
    'LBL_REMOVE_BUTTON_LABEL' => 'Elimina',
    'LBL_GROUP' => 'Grup:',
    'LBL_MODULE' => 'Mòdul:',

    'LBL_MASS_ASSIGN' => 'Grups de seguretat: Assignació massiva',
    'LBL_ASSIGN' => 'Assigna',
    'LBL_REMOVE' => 'Elimina',
    'LBL_ASSIGN_CONFIRM' => 'Esteu segur que voleu agregar a aquest grup de seguretat el(s)',
    'LBL_REMOVE_CONFIRM' => "Esteu segur que voleu eliminar d\'aquest grup de seguretat el(s)", // excepció d'escapat
    'LBL_CONFIRM_END' => 'registre(s) seleccionat(s)?',

    'LBL_SECURITYGROUP_USER_FORM_TITLE' => 'Grup de Seguretat / Usuari',
    'LBL_USER_NAME' => "Nom d'usuari",
    'LBL_SECURITYGROUP_NAME' => 'Nom del grup de seguretat',
    'LBL_HOMEPAGE_TITLE' => 'Missatges del grup',
    'LBL_TITLE' => 'Títol',
    'LBL_ROWS' => 'Files',
    'LBL_POST' => 'Envia',
    'LBL_SELECT_GROUP_ERROR' => 'Seleccioneu un grup i torneu-ho a provar.',

    'LBL_GROUP_SELECT' => 'Seleccioneu els grups que han de tenir accés a aquest registre.',
    'LBL_ERROR_DUPLICATE' => "Per causa d'un possible duplicat detectat per SuiteCRM haureu d'afegir manualment els grups de seguretat al registre creat.",
    'LBL_ERROR_EXPORT_WHERE_CHANGED' => "L'actualització ha fallat perquè el filtre de cerca s'ha modificat. Torneu-ho a provar.", // PR 7999

    'LBL_INBOUND_EMAIL' => 'Compte de correu electrònic entrant',
    'LBL_INBOUND_EMAIL_DESC' => "Permet només l'accés a un compte de correu electrònic si l'usuari pertany a un grup assignat al compte de correu.",
    'LBL_PRIMARY_GROUP' => 'Grup principal',
    'LBL_CHECKMARK' => 'Marca de verificació',

);
