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
    //DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_last_name' => 'LBL_LIST_LAST_NAME',
    'db_first_name' => 'LBL_LIST_FIRST_NAME',
    'db_title' => 'LBL_LIST_TITLE',
    'db_email1' => 'LBL_LIST_EMAIL_ADDRESS',
    'db_account_name' => 'LBL_LIST_ACCOUNT_NAME',
    'db_email2' => 'LBL_LIST_EMAIL_ADDRESS',
    //END DON'T CONVERT

    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro para eliminar o Cliente potencial.',
    'LBL_ACCOUNT_DESCRIPTION' => 'Descrición da Conta',
    'LBL_ACCOUNT_ID' => 'ID de Conta',
    'LBL_ACCOUNT_NAME' => 'Nome de Conta:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_ADDRESS_INFORMATION' => 'Información de Enderezo',
    'LBL_ALT_ADDRESS_CITY' => 'Cidade de enderezo alternativo',
    'LBL_ALT_ADDRESS_COUNTRY' => 'País de enderezo alternativo',
    'LBL_ALT_ADDRESS_POSTALCODE' => 'CP de enderezo alternativo',
    'LBL_ALT_ADDRESS_STATE' => 'Estado/Provincia de enderezo alternativo',
    'LBL_ALT_ADDRESS_STREET_2' => 'Rúa de enderezo alternativo 2',
    'LBL_ALT_ADDRESS_STREET_3' => 'Rúa de enderezo alternativo 3',
    'LBL_ALT_ADDRESS_STREET' => 'Rúa de enderezo alternativo',
    'LBL_ALTERNATE_ADDRESS' => 'Enderezo alternativo:',
    'LBL_ALT_ADDRESS' => 'Outro enderezo:',
    'LBL_ANY_ADDRESS' => 'Calquera enderezo:',
    'LBL_ANY_EMAIL' => 'Calquera Correo:',
    'LBL_ANY_PHONE' => 'Calquera teléfono:',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_ASSIGNED_TO_ID' => 'Usuario Asignado:',
    'LBL_BUSINESSCARD' => 'Convertir Cliente Potencial',
    'LBL_CITY' => 'Cidade:',
    'LBL_CONTACT_ID' => 'ID Contacto',
    'LBL_CONTACT_INFORMATION' => 'Visión Global', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_CONTACT_NAME' => 'Nome do cliente potencial:',
    'LBL_CONTACT_OPP_FORM_TITLE' => 'Cliente Potencial-Oportunidade:',
    'LBL_CONTACT_ROLE' => 'Rol:',
    'LBL_CONTACT' => 'Cliente Potencial:',
    'LBL_CONVERTED_ACCOUNT' => 'Conta Convertida:',
    'LBL_CONVERTED_CONTACT' => 'Contacto Convertido:',
    'LBL_CONVERTED_OPP' => 'Oportunidade Convertida:',
    'LBL_CONVERTED' => 'Convertido',
    'LBL_CONVERTLEAD_BUTTON_KEY' => 'V',
    'LBL_CONVERTLEAD_TITLE' => 'Convertir Cliente Potencial',
    'LBL_CONVERTLEAD' => 'Convertir Cliente Potencial',
    'LBL_CONVERTLEAD_WARNING' => 'Aviso: o estado do Cliente Potencial que está a punto de convertir é "Convertido". É posible que xa se creara algún rexistros de tipo Contacto e/ou Conta a partir deste Cliente Potencial. Se desexa continuar coa conversión do Cliente Potencial, faga clic en Gardar. Para volver ao Cliente Potencial sen realizar a conversión, faga clic en Cancelar.',
    'LBL_CONVERTLEAD_WARNING_INTO_RECORD' => 'Posible Contacto:',
    'LBL_COUNTRY' => 'País:',
    'LBL_CREATED_NEW' => 'Creou un novo',
    'LBL_CREATED_ACCOUNT' => 'Creada unha nova conta',
    'LBL_CREATED_CALL' => 'Nova chamada creada',
    'LBL_CREATED_CONTACT' => 'Novo contacto creado',
    'LBL_CREATED_MEETING' => 'Nova reunión creada',
    'LBL_CREATED_OPPORTUNITY' => 'Nova oportunidade creada',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Clientes Potenciais',
    'LBL_DEPARTMENT' => 'Departamento:',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_DO_NOT_CALL' => 'Non chamar:',
    'LBL_DUPLICATE' => 'Clientes potenciais similares',
    'LBL_EMAIL_ADDRESS' => 'Correo electrónico:',
    'LBL_EMAIL_OPT_OUT' => 'Rehusar Email:',
    'LBL_EXISTING_ACCOUNT' => 'Usada unha conta existente',
    'LBL_EXISTING_CONTACT' => 'Usado un contacto existente',
    'LBL_EXISTING_OPPORTUNITY' => 'Usada unha oportunidade existente',
    'LBL_FAX_PHONE' => 'Fax:',
    'LBL_FIRST_NAME' => 'Nome:',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_HOME_PHONE' => 'Tel. casa:',
    'LBL_IMPORT_VCARD' => 'Importar vCard',
    'LBL_VCARD' => 'vCard',
    'LBL_IMPORT_VCARDTEXT' => 'Automaticamente crea un novo cliente potencial importando unha vCard.',
    'LBL_INVALID_EMAIL' => 'Email non Váildo:',
    'LBL_INVITEE' => 'Informadores',
    'LBL_LAST_NAME' => 'Apelidos:',
    'LBL_LEAD_SOURCE_DESCRIPTION' => 'Descrición de toma de contacto:',
    'LBL_LEAD_SOURCE' => 'Toma de contacto:',
    'LBL_LIST_ACCEPT_STATUS' => 'Aceptar Estato',
    'LBL_LIST_ACCOUNT_NAME' => 'Nome de Conta',
    'LBL_LIST_CONTACT_NAME' => 'Nome do cliente potencial',
    'LBL_LIST_CONTACT_ROLE' => 'Rol',
    'LBL_LIST_DATE_ENTERED' => 'Data de Creación',
    'LBL_LIST_EMAIL_ADDRESS' => 'Email',
    'LBL_LIST_FIRST_NAME' => 'Nome',
    'LBL_LIST_FORM_TITLE' => 'Lista de Clientes Potenciais',
    'LBL_LIST_LAST_NAME' => 'Apelidos',
    'LBL_LIST_LEAD_SOURCE_DESCRIPTION' => 'Descrición de toma de contacto',
    'LBL_LIST_LEAD_SOURCE' => 'Toma de contacto',
    'LBL_LIST_MY_LEADS' => 'Os Meus Clientes Potenciais',
    'LBL_LIST_NAME' => 'Nome completo',
    'LBL_LIST_PHONE' => 'Teléfono',
    'LBL_LIST_REFERED_BY' => 'Referido por',
    'LBL_LIST_STATUS' => 'Estado',
    'LBL_LIST_TITLE' => 'Cargo',
    'LBL_MOBILE_PHONE' => 'Móbil:',
    'LBL_MODULE_NAME' => 'Clientes Potenciais',
    'LBL_MODULE_TITLE' => 'Clientes Potenciais: Inicio',
    'LBL_NAME' => 'Nome completo:',
    'LBL_NEW_FORM_TITLE' => 'Novo Cliente Potencial',
    'LBL_OFFICE_PHONE' => 'Tel. Oficina:',
    'LBL_OPP_NAME' => 'Nome da oportunidade:',
    'LBL_OPPORTUNITY_AMOUNT' => 'Cantidade da Oportunidade:',
    'LBL_OPPORTUNITY_ID' => 'ID Oportunidade',
    'LBL_OPPORTUNITY_NAME' => 'Nome da oportunidade:',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Email Alternativo:',
    'LBL_OTHER_PHONE' => 'Tel. Alternativo:',
    'LBL_PHONE' => 'Teléfono:',
    'LBL_PORTAL_APP' => 'Aplicación do Portal',
    'LBL_PORTAL_INFORMATION' => 'Información do Portal',
    'LBL_PORTAL_NAME' => 'Nome do Portal:',
    'LBL_POSTAL_CODE' => 'Código postal:',
    'LBL_STREET' => 'Rúa',
    'LBL_PRIMARY_ADDRESS_CITY' => 'Cidade de enderezo principal',
    'LBL_PRIMARY_ADDRESS_COUNTRY' => 'País de enderezo principal',
    'LBL_PRIMARY_ADDRESS_POSTALCODE' => 'CP de enderezo principal',
    'LBL_PRIMARY_ADDRESS_STATE' => 'Estado/Provincia de enderezo principal',
    'LBL_PRIMARY_ADDRESS_STREET_2' => 'Rúa de enderezo principal 2',
    'LBL_PRIMARY_ADDRESS_STREET_3' => 'Rúa de enderezo principal 3',
    'LBL_PRIMARY_ADDRESS_STREET' => 'Rúa de enderezo principal',
    'LBL_PRIMARY_ADDRESS' => 'Enderezo principal:',
    'LBL_REFERED_BY' => 'Referido por:',
    'LBL_REPORTS_TO_ID' => 'Informa a ID',
    'LBL_REPORTS_TO' => 'Informa a:',
    'LBL_SALUTATION' => 'Saúdo',
    'LBL_MODIFIED' => 'Modificado por',
    'LBL_CREATED' => 'Creado por',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Clientes Potenciais',
    'LBL_SELECT_CHECKED_BUTTON_LABEL' => 'Seleccionar Clientes Potenciais Marcados',
    'LBL_SELECT_CHECKED_BUTTON_TITLE' => 'Seleccionar Clientes Potenciais Marcados',
    'LBL_STATE' => 'Estado ou rexión:',
    'LBL_STATUS_DESCRIPTION' => 'Descrición estado:',
    'LBL_STATUS' => 'Estado:',
    'LBL_TITLE' => 'Posto de traballo:',
    'LNK_IMPORT_VCARD' => 'Novo Cliente Potencial desde vCard',
    'LNK_LEAD_LIST' => 'Ver Clientes Potenciais',
    'LNK_NEW_ACCOUNT' => 'Crear unha conta',
    'LNK_NEW_APPOINTMENT' => 'Nova Cita',
    'LNK_NEW_CONTACT' => 'Novo Contacto',
    'LNK_NEW_LEAD' => 'Novo Cliente Potencial',
    'LNK_NEW_NOTE' => 'Nova Nota',
    'LNK_NEW_TASK' => 'Nova Tarefa',
    'LNK_NEW_CASE' => 'Novo Caso',
    'LNK_NEW_CALL' => 'Rexistrar Chamada',
    'LNK_NEW_MEETING' => 'Programar Reunión',
    'LNK_NEW_OPPORTUNITY' => 'Nova Oportunidade',
    'LNK_SELECT_ACCOUNTS' => '<b>O</b> Seleccione unha Conta',
    'LNK_SELECT_CONTACTS' => ' <b>O</b> Selecciona Contacto',
    'NTC_DELETE_CONFIRMATION' => '¿Está seguro de que desexa eliminar este rexistro?',
    'NTC_REMOVE_CONFIRMATION' => '¿Está seguro de que desexa quitar este cliente potencial do caso?',
    'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE' => 'Campañas',
    'LBL_CAMPAIGN' => 'Campaña:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
    'LBL_PROSPECT_LIST' => 'Público Obxectivo',
    'LBL_CAMPAIGN_LEAD' => 'Campañas',
    'LBL_BIRTHDATE' => 'Data de nacemento:',
    'LBL_ASSISTANT_PHONE' => 'Tel. Asistente',
    'LBL_ASSISTANT' => 'Asistente',
    'LBL_CREATED_USER' => 'Usuario Creado',
    'LBL_MODIFIED_USER' => 'Usuario Modificado',
    'LBL_CAMPAIGNS' => 'Campañas',
    'LBL_CONVERT_MODULE_NAME' => 'Módulo',
    'LBL_CONVERT_REQUIRED' => 'Requirido',
    'LBL_CONVERT_SELECT' => 'Permitir Selección',
    'LBL_CONVERT_COPY' => 'Copiar Datos',
    'LBL_CONVERT_EDIT' => 'Editar',
    'LBL_CONVERT_DELETE' => 'Eliminar',
    'LBL_CONVERT_ADD_MODULE' => 'Agregar Módulo',
    'LBL_CREATE' => 'Crear',
    'LBL_SELECT' => '<b>O</b> Seleccionar',
    'LBL_WEBSITE' => 'Sitio Web',
    'LNK_IMPORT_LEADS' => 'Importar Clientes Potenciais',
//Convert lead tooltips
    'LBL_MODULE_TIP' => 'Módulo no que crear un novo rexistro.',
    'LBL_REQUIRED_TIP' => 'Debe seleccionar ou crear os módulos requiridos antes de que o cliente potencial poida ser convertido.',
    'LBL_COPY_TIP' => 'Se está seleccionado, os campos do cliente potencial serán copiados a campos co mesmo nome nos rexistros acabados de crear.',
    'LBL_SELECTION_TIP' => 'Os módulos cun campo relacionado en Contactos poden ser seleccionados en lugar de creados durante o proceso de conversión do cliente potencial.',
    'LBL_EDIT_TIP' => 'Modificar o deseño de conversión para este módulo.',
    'LBL_DELETE_TIP' => 'Quitar este módulo do deseño de conversión.',

    'LBL_ACTIVITIES_MOVE' => 'Mover actividade a',
    'LBL_ACTIVITIES_COPY' => 'Copiar actividade a',
    'LBL_ACTIVITIES_MOVE_HELP' => "Seleccione os rexistros de actividade que queira mover dos clientes potenciais. Tarefas, chamadas, reunións, notas e correos electrónicos que serán trasladados ao rexistro seleccionado.",
    'LBL_ACTIVITIES_COPY_HELP' => "Selecciona o ou os rexistros para cada copia creada das actividades dos Clientes Potenciais. As novas Tarefas, Chamadas, Reunións e Notas serán creadas para cada rexistro seleccionado. Os Emails relacionaranse cos rexistros seleccionados.",
    //For export labels
    'LBL_CAMPAIGN_ID' => 'Id de Campaña',
    'LBL_EDITLAYOUT' => 'Editar deseño' /*for 508 compliance fix*/,
    'LBL_ENTERDATE' => 'Introducir data' /*for 508 compliance fix*/,
    'LBL_LOADING' => 'Cargando ...' /*for 508 compliance fix*/,
    'LBL_EDIT_INLINE' => 'Editar' /*for 508 compliance fix*/,
    'LBL_FP_EVENTS_LEADS_1_FROM_FP_EVENTS_TITLE' => 'Eventos',
    'LBL_WWW' => 'WWW',
);
