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
    'LBL_MODULE_NAME' => 'Público Obxectivo',
    'LBL_MODULE_ID' => 'Público Obxectivo',
    'LBL_INVITEE' => 'Informa Directamente',
    'LBL_MODULE_TITLE' => 'Público Obxectivo: Inicio',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Público Obxectivo',
    'LBL_LIST_FORM_TITLE' => 'Lista de Público Obxectivo',
    'LBL_NEW_FORM_TITLE' => 'Novo Público Obxectivo',
    'LBL_LIST_NAME' => 'Nome',
    'LBL_LIST_LAST_NAME' => 'Apelidos',
    'LBL_LIST_TITLE' => 'Posto de traballo',
    'LBL_LIST_EMAIL_ADDRESS' => 'Email',
    'LBL_LIST_PHONE' => 'Teléfono',
    'LBL_LIST_FIRST_NAME' => 'Nome',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_ASSIGNED_TO_ID' => 'Asignado a:',
    'LBL_CAMPAIGN_ID' => 'ID Campaña',
    'LBL_EXISTING_ACCOUNT' => 'Usada unha conta existente',
    'LBL_CREATED_ACCOUNT' => 'Creada unha nova conta',
    'LBL_CREATED_CALL' => 'Nova chamada creada',
    'LBL_CREATED_MEETING' => 'Nova reunión creada',
    'LBL_NAME' => 'Nome:',
    'LBL_PROSPECT_INFORMATION' => 'Visión Global', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_MORE_INFORMATION' => 'Máis Información',
    'LBL_FIRST_NAME' => 'Nome:',
    'LBL_OFFICE_PHONE' => 'Tel. Oficina:',
    'LBL_ANY_PHONE' => 'Tel. Calquera:',
    'LBL_PHONE' => 'Teléfono:',
    'LBL_LAST_NAME' => 'Apelidos:',
    'LBL_MOBILE_PHONE' => 'Móbil:',
    'LBL_HOME_PHONE' => 'Casa:',
    'LBL_OTHER_PHONE' => 'Tel. Alternativo:',
    'LBL_FAX_PHONE' => 'Fax:',
    'LBL_PRIMARY_ADDRESS_STREET' => 'Rúa Enderezo Principal:',
    'LBL_PRIMARY_ADDRESS_CITY' => 'Cidade Enderezo Principal:',
    'LBL_PRIMARY_ADDRESS_COUNTRY' => 'País Enderezo Principal:',
    'LBL_PRIMARY_ADDRESS_STATE' => 'Provincia/Estado Enderezo Principal:',
    'LBL_PRIMARY_ADDRESS_POSTALCODE' => 'CP Enderezo Principal:',
    'LBL_ALT_ADDRESS_STREET' => 'Rúa Enderezo alternativo:',
    'LBL_ALT_ADDRESS_CITY' => 'Cidade Enderezo alternativo:',
    'LBL_ALT_ADDRESS_COUNTRY' => 'País Enderezo alternativo:',
    'LBL_ALT_ADDRESS_STATE' => 'Provincia/Estado Enderezo alternativo:',
    'LBL_ALT_ADDRESS_POSTALCODE' => 'CP Enderezo alternativo:',
    'LBL_TITLE' => 'Posto de traballo:',
    'LBL_DEPARTMENT' => 'Departamento:',
    'LBL_BIRTHDATE' => 'Data de nacemento:',
    'LBL_EMAIL_ADDRESS' => 'Correo electrónico:',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Email alternativo:',
    'LBL_ANY_EMAIL' => 'Calquera Correo:',
    'LBL_ASSISTANT' => 'Asistente:',
    'LBL_ASSISTANT_PHONE' => 'Tel. Asistente:',
    'LBL_DO_NOT_CALL' => 'Non Chamar:',
    'LBL_EMAIL_OPT_OUT' => 'Rehusar Email:',
    'LBL_PRIMARY_ADDRESS' => 'Enderezo Principal:',
    'LBL_ALTERNATE_ADDRESS' => 'Enderezo alternativo:',
    'LBL_ANY_ADDRESS' => 'Enderezo alternativo:',
    'LBL_CITY' => 'Cidade:',
    'LBL_STATE' => 'Estado ou rexión:',
    'LBL_POSTAL_CODE' => 'CP:',
    'LBL_COUNTRY' => 'País:',
    'LBL_ADDRESS_INFORMATION' => 'Información de Enderezo',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_OPP_NAME' => 'Nome da oportunidade:',
    'LBL_IMPORT_VCARD' => 'Importar vCard',
    'LBL_IMPORT_VCARDTEXT' => 'Crear un novo contacto automaticamente importando unha vCard do seu sistema de ficheiros.',
    'LBL_DUPLICATE' => 'Posible Público Obxectivo Duplicado',
    'MSG_SHOW_DUPLICATES' => 'O rexistro para o prospecto que vai a crear podería ser un duplicado doutro rexistro de prospecto existente. Os rexistros de prospectos con nomes e/ou enderezos de correo similares lístanse a continuación.<br>Faga clic en Gardar para continuar coa creación deste prospecto, ou en Cancelar para volver ao módulo sen crear o prospecto.',
    'MSG_DUPLICATE' => 'O rexistro para o prospecto que vai a crear podería ser un duplicado doutro rexistro de prospecto existente. Os rexistros de prospectos con nomes e/ou enderezos de correo similares lístanse a continuación.<br>Faga clic en Gardar para continuar coa creación deste prospecto, ou en Cancelar para volver ao módulo sen crear o prospecto.',
    'LNK_IMPORT_VCARD' => 'Crear desde vCard',
    'LNK_NEW_ACCOUNT' => 'Crear unha conta',
    'LNK_NEW_OPPORTUNITY' => 'Crear Oportunidade',
    'LNK_NEW_CASE' => 'Crear Caso',
    'LNK_NEW_NOTE' => 'Crear Nota or Adxunto',
    'LNK_NEW_CALL' => 'Rexistrar Chamada',
    'LNK_NEW_EMAIL' => 'Arquivar Email',
    'LNK_NEW_MEETING' => 'Planificar Reunión',
    'LNK_NEW_TASK' => 'Crear Tarefa',
    'LNK_NEW_APPOINTMENT' => 'Crear Cita',
    'LNK_IMPORT_PROSPECTS' => 'Importar Prospectos',
    'NTC_DELETE_CONFIRMATION' => '¿Está seguro de que desexa eliminar este rexistro?',
    'NTC_REMOVE_CONFIRMATION' => '¿Está seguro de que desexa quitar este contacto do caso?',
    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro para eliminar o contacto.',
    'LBL_SALUTATION' => 'Saúdo',
    'LBL_CREATED_OPPORTUNITY' => 'Nova oportunidade creada',
    'LNK_SELECT_ACCOUNT' => "Seleccionar Conta",
    'LNK_NEW_PROSPECT' => 'Crear Público Obxectivo',
    'LNK_PROSPECT_LIST' => 'Ver Público Obxectivo',
    'LNK_NEW_CAMPAIGN' => 'Crear Campaña',
    'LNK_CAMPAIGN_LIST' => 'Campañas',
    'LNK_NEW_PROSPECT_LIST' => 'Crear Lista de Público Obxectivo',
    'LNK_PROSPECT_LIST_LIST' => 'Listas de Público Obxectivo',
    'LBL_SELECT_CHECKED_BUTTON_LABEL' => 'Seleccione Público Obxectivo Marcado',
    'LBL_SELECT_CHECKED_BUTTON_TITLE' => 'Seleccione Público Obxectivo Marcado',
    'LBL_INVALID_EMAIL' => 'Email non Válido:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Público Obxectivo',
    'LBL_PROSPECT_LIST' => 'Público Obxectivo',
    'LBL_CONVERT_BUTTON_TITLE' => 'Convertir Público Obxectivo',
    'LBL_CONVERT_BUTTON_LABEL' => 'Convertir Público Obxectivo',
    'LNK_NEW_CONTACT' => 'Novo Contacto',
    'LBL_CREATED_CONTACT' => "Novo contacto creado",
    'LBL_CAMPAIGNS' => 'Campañas',
    'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE' => 'Rexistro de Campañas',
    'LBL_TRACKER_KEY' => 'Clave de Seguimento',
    'LBL_LEAD_ID' => 'Id Cliente Potencial',
    'LBL_CONVERTED_LEAD' => 'Cliente Potencial Convertido',
    'LBL_ACCOUNT_NAME' => 'Nome de Conta',
    'LBL_EDIT_ACCOUNT_NAME' => 'Nome de Conta:',
    'LBL_CREATED_USER' => 'Usuario Creado',
    'LBL_MODIFIED_USER' => 'Usuario Modificado',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    //For export labels
    'LBL_FP_EVENTS_PROSPECTS_1_FROM_FP_EVENTS_TITLE' => 'Eventos',
);
