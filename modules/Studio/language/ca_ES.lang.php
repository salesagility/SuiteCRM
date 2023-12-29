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
    'LBL_EDIT_LAYOUT' => 'Editar Diseny',
    'LBL_EDIT_FIELDS' => 'Editar Camps Personalitzats',
    'LBL_SELECT_FILE' => 'Seleccionar Arxiu',
    'LBL_MODULE_TITLE' => 'Estudi',
    'LBL_TOOLBOX' => 'Caixa d\'Eines',
    'LBL_SUITE_FIELDS_STAGE' => 'Camps de SuiteCRM (faci clic en els elements per a afegir-los a l\'àrea de disseny)',
    'LBL_VIEW_SUITE_FIELDS' => 'Veure camps de SuiteCRM',
    'LBL_FAILED_TO_SAVE' => 'Error al Desar',
    'LBL_CONFIRM_UNSAVE' => 'Els canvis no s\'han guardat i es perdran. Està segur de que vol continuar?',
    'LBL_PUBLISHING' => 'Publicant ...',
    'LBL_PUBLISHED' => 'Publicat',
    'LBL_FAILED_PUBLISHED' => 'Error al Publicar',
    'LBL_DROP_HERE' => '[Deixar Anar Aquí]',

//CUSTOM FIELDS
    'LBL_NAME' => 'Nom',
    'LBL_LABEL' => 'Etiqueta',
    'LBL_MASS_UPDATE' => 'Actualització Massiva',
    'LBL_DEFAULT_VALUE' => 'Valor per Defecte',
    'LBL_REQUIRED' => 'Requerit',
    'LBL_DATA_TYPE' => 'Tipus',


    'LBL_HISTORY' => 'Historial',

//WIZARDS

//STUDIO WIZARD
    'LBL_SW_WELCOME' => '<h2>Benvingut al Estudi!</h2><br> Què desitja fer avui?<br><b> Si us plau, seleccioni una de les següents opcions.</b>',
    'LBL_SW_EDIT_MODULE' => 'Editar un Mòdul',
    'LBL_SW_EDIT_DROPDOWNS' => 'Editar Llistes Desplegables',
    'LBL_SW_EDIT_TABS' => 'Configurar Pestanyes',
    'LBL_SW_RENAME_TABS' => 'Renombrar Pestanyes',
    'LBL_SW_EDIT_GROUPTABS' => 'Configurar Grups de Pestanyes',
    'LBL_SW_EDIT_PORTAL' => 'Editar Portal',
    'LBL_SW_REPAIR_CUSTOMFIELDS' => 'Reparar Camps Personalitzats',
    'LBL_SW_MIGRATE_CUSTOMFIELDS' => 'Migrar Camps Personalitzats',

//Manager Backups History
    'LBL_MB_DELETE' => 'Esborrar',

//EDIT DROP DOWNS
    'LBL_ED_CREATE_DROPDOWN' => 'Crea una llista desplegable',
    'LBL_DROPDOWN_NAME' => 'Nom de la llista desplegable:',
    'LBL_DROPDOWN_LANGUAGE' => 'Idioma de la llista desplegable:',
    'LBL_TABGROUP_LANGUAGE' => 'Idioma:',

//END WIZARDS

//DROP DOWN EDITOR
    'LBL_DD_DISPALYVALUE' => 'Valor de Visualització',
    'LBL_DD_DATABASEVALUE' => 'Valor de Base de dades',
    'LBL_DD_ALL' => 'Tot',

//BUTTONS
    'LBL_BTN_SAVE' => 'Desar',
    'LBL_BTN_CANCEL' => 'Cancel·lar',
    'LBL_BTN_SAVEPUBLISH' => 'Desar i Publicar',
    'LBL_BTN_HISTORY' => 'Historial',
    'LBL_BTN_ADDROWS' => 'Agregar Files',
    'LBL_BTN_UNDO' => 'Desfer',
    'LBL_BTN_REDO' => 'Repetir',
    'LBL_BTN_ADDCUSTOMFIELD' => 'Agregar Camp Personalitzat',
    'LBL_BTN_TABINDEX' => 'Editar Ordre de Pestanyes',

//TABS
    'LBL_MODULES' => 'Mòduls',
    'LBL_MODULE_NAME' => 'Administració',
    'LBL_CONFIGURE_GROUP_TABS' => 'Configurar el mòdul de menú de filtres',
    'LBL_GROUP_TAB_WELCOME' => 'El disseny dels Grups de Pestanyes s\'usarà sempre que un usuari elegeixi utilitzar Grups de Pestanyes en lloc de les Pestanyes de Mòduls habituals en Dc. Compte>Opcions de Presentació.',
    'LBL_RENAME_TAB_WELCOME' => 'Faci clic en el Valor de Visualització de qualsevol pestanya de la següent taula per rebatejar la pestanya.',
    'LBL_DELETE_MODULE' => 'Eliminar&nbsp;mòdul<br />del&nbsp;filtre',
    'LBL_TAB_GROUP_LANGUAGE_HELP' => 'Sel·lecciona un dels idiomes disponibles, edita les etiquetes de grup i fes click en guardar i desplegar per aplicar les etiquetes amb l\'idioma escollit.',
    'LBL_ADD_GROUP' => 'Afegir filtre',
    'LBL_NEW_GROUP' => 'Nou Grup',
    'LBL_RENAME_TABS' => 'Renombrar Pestanyes',

//ERRORS
    'ERROR_INVALID_KEY_VALUE' => "Error: Valor de Clau No vàlid: [']",

//SUGAR PORTAL
    'LBL_SAVE' => 'Desar' /*for 508 compliance fix*/,
    'LBL_UNDO' => 'Desfer' /*for 508 compliance fix*/,
    'LBL_REDO' => 'Repetir' /*for 508 compliance fix*/,
    'LBL_INLINE' => 'de línia' /*for 508 compliance fix*/,
    'LBL_DELETE' => 'Eliminar' /*for 508 compliance fix*/,
    'LBL_ADD_FIELD' => 'Afegir Camp' /*for 508 compliance fix*/,
    'LBL_MAXIMIZE' => 'Maximitzar' /*for 508 compliance fix*/,
    'LBL_MINIMIZE' => 'Minimitzar' /*for 508 compliance fix*/,
    'LBL_PUBLISH' => 'Publicar' /*for 508 compliance fix*/,
    'LBL_ADDROWS' => 'Agregar Files' /*for 508 compliance fix*/,
    'LBL_ADDFIELD' => 'Afegir Camp' /*for 508 compliance fix*/,
    'LBL_EDIT' => 'Editar' /*for 508 compliance fix*/,

    'LBL_LANGUAGE_TOOLTIP' => 'Seleccioni l\'idioma que desitja editar.',
    'LBL_SINGULAR' => 'Etiqueta singular',
    'LBL_PLURAL' => 'Etiqueta plural',
    'LBL_RENAME_MOD_SAVE_HELP' => 'Cliqui <b>Desar</b> per aplicar els canvis.'

);
