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
    'LBL_MODULE_NAME' => 'Moedas',
    'LBL_LIST_FORM_TITLE' => 'Moedas',
    'LBL_CURRENCY' => 'Moeda',
    'LBL_ADD' => 'Agregar',
    'LBL_MERGE' => 'Unificar',
    'LBL_MERGE_TXT' => 'Por favor, seleccione as moedas que desexe asociar á moeda seleccionada. Isto eliminará todas as moedas marcadas e reasignará calquera valor asociado con elas á moeda seleccionada.',
    'LBL_US_DOLLAR' => 'Dólar EEUU',
    'LBL_DELETE' => 'Eliminar',
    'LBL_LIST_SYMBOL' => 'Símbolo',
    'LBL_LIST_NAME' => 'Nome de Moeda',
    'LBL_LIST_ISO4217' => 'Código ISO 4217',
    'LBL_LIST_ISO4217_HELP' => 'Introduza o código de tres letras ISO 4217 que define o nome e o símbolo da moeda.',
    'LBL_UPDATE' => 'Actualizar',
    'LBL_LIST_RATE' => 'Cambio',
    'LBL_LIST_RATE_HELP' => 'Un cambio de 0,5 para o Euro significa que 10 dólares EEUU = 5 Euros.',
    'LBL_LIST_STATUS' => 'Estado',
    'LNK_NEW_CONTACT' => 'Novo Contacto',
    'LNK_NEW_ACCOUNT' => 'Nova Conta',
    'LNK_NEW_OPPORTUNITY' => 'Nova Oportunidade',
    'LNK_NEW_CASE' => 'Novo Caso',
    'LNK_NEW_NOTE' => 'Nova Nota',
    'LNK_NEW_CALL' => 'Nova Chamada',
    'LNK_NEW_EMAIL' => 'Novo Email',
    'LNK_NEW_MEETING' => 'Nova Reunión',
    'LNK_NEW_TASK' => 'Nova Tarefa',
    'NTC_DELETE_CONFIRMATION' => '¿Está seguro de que desexa eliminar esta moeda? Todo rexistro que use esta moeda será convertido á moeda por defecto do sistema cando sexa accedido. Sería mellor deixala inactiva.',
    'LBL_BELOW_MIN' => 'O ratio de conversión debe ser maior que 0',
    'currency_status_dom' =>
        array(
            'Active' => 'Activa',
            'Inactive' => 'Inactiva',
        ),
    'LBL_CREATED_BY' => 'Creado por',
    'LBL_EDIT_LAYOUT' => 'Editar deseño' /*for 508 compliance fix*/,
);
