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
    'LBL_EDIT_LAYOUT' => 'Editar Deseño',
    'LBL_EDIT_FIELDS' => 'Editar Campos Personalizados',
    'LBL_SELECT_FILE' => 'Seleccionar Arquivo',
    'LBL_MODULE_TITLE' => 'Estudio',
    'LBL_TOOLBOX' => 'Caixa de Ferramentas',
    'LBL_SUITE_FIELDS_STAGE' => 'Campos SuiteCRM (faga clic nos elementos para agregalos á área de deseño)',
    'LBL_VIEW_SUITE_FIELDS' => 'Ver Campos SuiteCRM',
    'LBL_FAILED_TO_SAVE' => 'Erro ao Gardar',
    'LBL_CONFIRM_UNSAVE' => 'Os cambios non se gardaron e perderanse. ¿Está seguro de que desexa continuar?',
    'LBL_PUBLISHING' => 'Publicando ...',
    'LBL_PUBLISHED' => 'Publicado',
    'LBL_FAILED_PUBLISHED' => 'Erro ao Publicar',
    'LBL_DROP_HERE' => '[Soltar Aquí]',

//CUSTOM FIELDS
    'LBL_NAME' => 'Nome',
    'LBL_LABEL' => 'Etiqueta',
    'LBL_MASS_UPDATE' => 'Actualización Masiva',
    'LBL_DEFAULT_VALUE' => 'Valor por Defecto',
    'LBL_REQUIRED' => 'Requirido',
    'LBL_DATA_TYPE' => 'Tipo',


    'LBL_HISTORY' => 'Historial',

//WIZARDS

//STUDIO WIZARD
    'LBL_SW_WELCOME' => '<h2>¡Benvido ao Estudio!</h2><br> ¿Que desexa facer hoxe?<br><b> Por favor, seleccione unha das seguintes opcións.</b>',
    'LBL_SW_EDIT_MODULE' => 'Editar un Módulo',
    'LBL_SW_EDIT_DROPDOWNS' => 'Editar Listas Despregables',
    'LBL_SW_EDIT_TABS' => 'Configurar Pestanas',
    'LBL_SW_RENAME_TABS' => 'Renomear Pestanas',
    'LBL_SW_EDIT_GROUPTABS' => 'Configurar Grupos de Pestanas',
    'LBL_SW_EDIT_PORTAL' => 'Editar Portal',
    'LBL_SW_REPAIR_CUSTOMFIELDS' => 'Reparar Campos Personalizados',
    'LBL_SW_MIGRATE_CUSTOMFIELDS' => 'Migrar Campos Personalizados',

//Manager Backups History
    'LBL_MB_DELETE' => 'Eliminar',

//EDIT DROP DOWNS
    'LBL_ED_CREATE_DROPDOWN' => 'Crea unha Lista Despregable',
    'LBL_DROPDOWN_NAME' => 'Nome de Lista Despregable:',
    'LBL_DROPDOWN_LANGUAGE' => 'Idioma de Lista Despregable:',
    'LBL_TABGROUP_LANGUAGE' => 'Idioma:',

//END WIZARDS

//DROP DOWN EDITOR
    'LBL_DD_DISPALYVALUE' => 'Valor de Visualización',
    'LBL_DD_DATABASEVALUE' => 'Valor de Base de datos',
    'LBL_DD_ALL' => 'Todo',

//BUTTONS
    'LBL_BTN_SAVE' => 'Gardar',
    'LBL_BTN_CANCEL' => 'Cancelar',
    'LBL_BTN_SAVEPUBLISH' => 'Gardar e Publicar',
    'LBL_BTN_HISTORY' => 'Historial',
    'LBL_BTN_ADDROWS' => 'Agregar Filas',
    'LBL_BTN_UNDO' => 'Desfacer',
    'LBL_BTN_REDO' => 'Repetir',
    'LBL_BTN_ADDCUSTOMFIELD' => 'Agregar Campo Personalizado',
    'LBL_BTN_TABINDEX' => 'Editar Orde de Pestanas',

//TABS
    'LBL_MODULES' => 'Módulos',
    'LBL_MODULE_NAME' => 'Administración',
    'LBL_CONFIGURE_GROUP_TABS' => 'Configurar filtros de agrupación de módulos',
    'LBL_GROUP_TAB_WELCOME' => 'Os seguintes grupos mostraranse na barra de navegación aos usuarios que escollan ver Módulos Agrupados. Arrastre e solte módulos desde os Grupos para configurar que módulos aparecen baixo os grupos. Nota: os grupos baleiros non serán mostrados na barra de navegación.',
    'LBL_RENAME_TAB_WELCOME' => 'Faga clic no Valor de Visualización de calquera pestana da seguinte táboa para renomear a pestana.',
    'LBL_DELETE_MODULE' => 'Quitar&nbsp;módulo<br />do&nbsp;filtro',
    'LBL_TAB_GROUP_LANGUAGE_HELP' => 'Seleccione un dos idiomas dispoñibles, edite as etiquetas do Grupo e faga clic en Gardar e Despregar para aplicar as etiquetas no idioma desexado.',
    'LBL_ADD_GROUP' => 'Agregar filtro',
    'LBL_NEW_GROUP' => 'Novo Grupo',
    'LBL_RENAME_TABS' => 'Renomear Pestanas',

//ERRORS
    'ERROR_INVALID_KEY_VALUE' => "Erro: Valor de Clave non válido: [&#39;]",

//SUGAR PORTAL
    'LBL_SAVE' => 'Gardar' /*for 508 compliance fix*/,
    'LBL_UNDO' => 'Desfacer' /*for 508 compliance fix*/,
    'LBL_REDO' => 'Repetir' /*for 508 compliance fix*/,
    'LBL_INLINE' => 'En liña' /*for 508 compliance fix*/,
    'LBL_DELETE' => 'Eliminar' /*for 508 compliance fix*/,
    'LBL_ADD_FIELD' => 'Agregar Campo:' /*for 508 compliance fix*/,
    'LBL_MAXIMIZE' => 'Maximizar' /*for 508 compliance fix*/,
    'LBL_MINIMIZE' => 'Minimizar' /*for 508 compliance fix*/,
    'LBL_PUBLISH' => 'Publicar' /*for 508 compliance fix*/,
    'LBL_ADDROWS' => 'Agregar Filas' /*for 508 compliance fix*/,
    'LBL_ADDFIELD' => 'Agregar Campo:' /*for 508 compliance fix*/,
    'LBL_EDIT' => 'Editar' /*for 508 compliance fix*/,

    'LBL_LANGUAGE_TOOLTIP' => 'Seleccione o idioma que desexa editar.',
    'LBL_SINGULAR' => 'Etiqueta en Singular',
    'LBL_PLURAL' => 'Etiqueta en Plural',
    'LBL_RENAME_MOD_SAVE_HELP' => 'Pulse en Gardar para aplicar os cambios.'

);
