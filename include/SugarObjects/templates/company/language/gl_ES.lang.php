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
    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro para eliminar a conta.',
    'LBL_ACCOUNT_NAME' => 'Nome de Compañía:',
    'LBL_ACCOUNT' => 'Compañía:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_ADDRESS_INFORMATION' => 'Información de Enderezo',
    'LBL_ANNUAL_REVENUE' => 'Ingresos Anuais:',
    'LBL_ANY_ADDRESS' => 'Calquera Enderezo:',
    'LBL_ANY_EMAIL' => 'Calquera Correo:',
    'LBL_EMAIL_NON_PRIMARY' => 'Correos Electrónicos non Principais',
    'LBL_ANY_PHONE' => 'Calquera Teléfono:',
    'LBL_ASSIGNED_TO_NAME' => 'Usuario:',
    'LBL_RATING' => 'Cualificación',
    'LBL_ASSIGNED_TO' => 'Asignado a:',
    'LBL_ASSIGNED_USER' => 'Asignado a:',
    'LBL_ASSIGNED_TO_ID' => 'Asignado a:',
    'LBL_BILLING_ADDRESS_CITY' => 'Cidade de Enderezo de Facturación:',
    'LBL_BILLING_ADDRESS_COUNTRY' => 'País de Enderezo de Facturación:',
    'LBL_BILLING_ADDRESS_POSTALCODE' => 'CP de Enderezo de Facturación:',
    'LBL_BILLING_ADDRESS_STATE' => 'Estado/Provincia de Enderezo de Facturación:',
    'LBL_BILLING_ADDRESS_STREET_2' => 'Rúa de Enderezo de Facturación 2',
    'LBL_BILLING_ADDRESS_STREET_3' => 'Rúa de Enderezo de Facturación 3',
    'LBL_BILLING_ADDRESS_STREET_4' => 'Rúa de Enderezo de Facturación 4',
    'LBL_BILLING_ADDRESS_STREET' => 'Rúa de Enderezo de Facturación:',
    'LBL_BILLING_ADDRESS' => 'Enderezo de Facturación:',
    'LBL_ACCOUNT_INFORMATION' => 'Información da Compañía',
    'LBL_CITY' => 'Cidade:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
    'LBL_COUNTRY' => 'País:',
    'LBL_DATE_ENTERED' => 'Data de Creación:',
    'LBL_DATE_MODIFIED' => 'Data de Modificación:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Contas',
    'LBL_DESCRIPTION_INFORMATION' => 'Información Adicional',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_DUPLICATE' => 'Posible Conta Duplicada',
    'LBL_EMAIL' => 'Correo Electrónico:',
    'LBL_EMPLOYEES' => 'Empregados:',
    'LBL_FAX' => 'Fax:',
    'LBL_INDUSTRY' => 'Industria:',
    'LBL_LIST_ACCOUNT_NAME' => 'Nome de Conta',
    'LBL_LIST_CITY' => 'Cidade',
    'LBL_LIST_EMAIL_ADDRESS' => 'Email',
    'LBL_LIST_PHONE' => 'Teléfono',
    'LBL_LIST_STATE' => 'Estado',
    'LBL_MEMBER_OF' => 'Membro de:',
    'LBL_MEMBER_ORG_SUBPANEL_TITLE' => 'Organizacións Membro',
    'LBL_NAME' => 'Nome:',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Email Alternativo:',
    'LBL_OTHER_PHONE' => 'Tel. Alternativo:',
    'LBL_OWNERSHIP' => 'Propietario:',
    'LBL_PARENT_ACCOUNT_ID' => 'ID Conta Pai',
    'LBL_PHONE_ALT' => 'Tel. Alternativo:',
    'LBL_PHONE_FAX' => 'Fax Oficina:',
    'LBL_PHONE_OFFICE' => 'Teléfono Oficina:',
    'LBL_PHONE' => 'Teléfono:',
    'LBL_EMAIL_ADDRESS' => 'Enderezo(s) de Email',
    'LBL_EMAIL_ADDRESSES' => 'Enderezos de Email',
    'LBL_POSTAL_CODE' => 'Código Postal:',
    'LBL_SAVE_ACCOUNT' => 'Gardar Conta',
    'LBL_SHIPPING_ADDRESS_CITY' => 'Cidade de Enderezo de Envío:',
    'LBL_SHIPPING_ADDRESS_COUNTRY' => 'País de Enderezo de Envío:',
    'LBL_SHIPPING_ADDRESS_POSTALCODE' => 'CP de Enderezo de Envío:',
    'LBL_SHIPPING_ADDRESS_STATE' => 'Estado/Provincia de Enderezo de Envío:',
    'LBL_SHIPPING_ADDRESS_STREET_2' => 'Rúa de Enderezo de Envío 2',
    'LBL_SHIPPING_ADDRESS_STREET_3' => 'Rúa de Enderezo de Envío 3',
    'LBL_SHIPPING_ADDRESS_STREET_4' => 'Rúa de Enderezo de Envío 4',
    'LBL_SHIPPING_ADDRESS_STREET' => 'Rúa de Enderezo de Envío:',
    'LBL_SHIPPING_ADDRESS' => 'Enderezo de Envío:',

    'LBL_STATE' => 'Estado ou rexión:',
    'LBL_TICKER_SYMBOL' => 'Símbolo Ticker:',
    'LBL_TYPE' => 'Tipo:',
    'LBL_WEBSITE' => 'Sitio Web:',

    'LNK_ACCOUNT_LIST' => 'Contas',
    'LNK_NEW_ACCOUNT' => 'Crear unha conta',

    'MSG_DUPLICATE' => 'A creación desta conta pode producir unha conta duplicada. Pode escoller unha conta existente da lista inferior ou facer clic en Gardar para continuar a creación dunha nova conta cos datos introducidos previamente.',
    'MSG_SHOW_DUPLICATES' => 'O rexistro de conta que está a punto de crear podería ser un duplicado dunha conta que xa existe. As contas que conteñen nomes similares lístanse a continuación.<br>Faga clic en Crear Conta para seguir coa creación desta nova conta, ou faga clic en Cancelar para volver ao módulo sen crear a conta.',

    'NTC_DELETE_CONFIRMATION' => '¿Está seguro de que desexa eliminar este rexistro?',

    'LBL_EDIT_BUTTON' => 'Editar',
    // STIC-Custom 20240214 JBL - QuickEdit view
    // https://github.com/SinergiaTIC/SinergiaCRM/pull/93
    'LBL_QUICKEDIT_BUTTON' => '↙ Editar',
    // END STIC-Custom
    'LBL_REMOVE' => 'Quitar',

);
