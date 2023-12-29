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
    'LBL_MODULE_NAME' => 'Oportunidades',
    'LBL_MODULE_TITLE' => 'Oportunidades: Inicio',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Oportunidades',
    'LBL_LIST_FORM_TITLE' => 'Lista de Oportunidades',
    'LBL_OPPORTUNITY_NAME' => 'Nome da oportunidade:',
    'LBL_OPPORTUNITY' => 'Oportunidade:',
    'LBL_NAME' => 'Nome da oportunidade',
    'LBL_INVITEE' => 'Contactos',
    'LBL_CURRENCIES' => 'Moedas',
    'LBL_LIST_OPPORTUNITY_NAME' => 'Nome',
    'LBL_LIST_ACCOUNT_NAME' => 'Nome de Conta',
    'LBL_LIST_AMOUNT' => 'Monto da Oportunidade',
    'LBL_LIST_AMOUNT_USDOLLAR' => 'Monto',
    'LBL_LIST_DATE_CLOSED' => 'Data Peche',
    'LBL_LIST_SALES_STAGE' => 'Etapa de Vendas',
    'LBL_ACCOUNT_ID' => 'ID de Conta',
    'LBL_CURRENCY_NAME' => 'Nome de Moeda',
    'LBL_CURRENCY_SYMBOL' => 'Símbolo de Moeda',

    'UPDATE' => 'Oportunidade - Actualizar Moeda',
    'LBL_ACCOUNT_NAME' => 'Nome de Conta:',
    'LBL_AMOUNT' => 'Monto da Oportunidade:',
    'LBL_AMOUNT_USDOLLAR' => 'Monto:',
    'LBL_CURRENCY' => 'Moeda:',
    'LBL_DATE_CLOSED' => 'Data de peche:',
    'LBL_TYPE' => 'Tipo:',
    'LBL_CAMPAIGN' => 'Campaña:',
    'LBL_NEXT_STEP' => 'Próximo paso:',
    'LBL_LEAD_SOURCE' => 'Toma de contacto:',
    'LBL_SALES_STAGE' => 'Etapa de vendas:',
    'LBL_PROBABILITY' => 'Probabilidade (%):',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_DUPLICATE' => 'Posible oportunidade duplicada',
    'MSG_DUPLICATE' => 'O rexistro para a oportunidade que vai a crear podería ser un duplicado doutro rexistro de oportunidade existente. Os rexistros de oportunidade con nomes similares lístanse a continuación.<br>Faga clic en Gardar para continuar coa creación desta oportunidade, ou en Cancelar para volver ao módulo sen crear a oportunidade.',
    'LBL_NEW_FORM_TITLE' => 'Nova Oportunidade',
    'LNK_NEW_OPPORTUNITY' => 'Nova Oportunidade',
    'LNK_OPPORTUNITY_LIST' => 'Ver Oportunidades',
    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro a eliminar.',
    'LBL_TOP_OPPORTUNITIES' => 'As Miñas Principais Oportunidades',
    'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => '¿Está seguro de que desexa eliminar esta oportunidade do proxecto?',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Oportunidades',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',

    'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciais',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proxectos',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
    'LBL_MY_CLOSED_OPPORTUNITIES' => 'As Miñas Oportunidades Cerradas',
    'LBL_TOTAL_OPPORTUNITIES' => 'Oportunidades Totais',
    'LBL_CLOSED_WON_OPPORTUNITIES' => 'Oportunidades Gañadas',
    'LBL_ASSIGNED_TO_ID' => 'Usuario Asignado:',
    'LBL_MODIFIED_NAME' => 'Modificado polo Nome de Usuario',
    'LBL_CREATED_USER' => 'Usuario Creado',
    'LBL_MODIFIED_USER' => 'Usuario Modificado',
    'LBL_CAMPAIGN_OPPORTUNITY' => 'Campañas',
    'LBL_PROJECT_SUBPANEL_TITLE' => 'Proxectos',
    'LNK_IMPORT_OPPORTUNITIES' => 'Importar Oportunidades',
    'LBL_EDITLAYOUT' => 'Editar deseño' /*for 508 compliance fix*/,

    // SNIP

    'LBL_AOS_CONTRACTS' => 'Contratos',
    'LBL_AOS_QUOTES' => 'Presupostos',
);
