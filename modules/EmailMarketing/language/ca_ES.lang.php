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
    'LBL_REPLY_ADDR' => 'Direcció de "Contestar a": ',
    'LBL_REPLY_NAME' => 'Nom de "Contestar a": ',

    'LBL_MODULE_NAME' => 'Màrqueting per correu electrònic',
    'LBL_MODULE_TITLE' => 'Màrqueting per correu electrònic: Inici',
    'LBL_LIST_FORM_TITLE' => 'Campanyes de màrqueting per correu electrònic',
    'LBL_NAME' => 'Nom: ',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_LIST_FROM_ADDR' => 'Correu electrònic remitent',
    'LBL_LIST_DATE_START' => 'Data Inici',
    'LBL_LIST_TEMPLATE_NAME' => 'Plantilla de correu electrònic',
    'LBL_LIST_STATUS' => 'Estat',
    'LBL_STATUS' => 'Estat',
    'LBL_STATUS_TEXT' => 'Estat:',
    'LBL_TEMPLATE_NAME' => 'Nom de Plantilla',
    'LBL_DATE_ENTERED' => 'Data Creació',
    'LBL_DATE_MODIFIED' => 'Data Modificació',
    'LBL_MODIFIED' => 'Modificat per: ',
    'LBL_CREATED' => 'Creat per: ',
    'LBL_MESSAGE_FOR' => 'Enviar aquest Missatge a:',

    'LBL_FROM_NAME' => 'Nom Remitent: ',
    'LBL_FROM_ADDR' => 'Direcció correu electrònic remitent: ',
    'LBL_DATE_START' => 'Data Inici',
    'LBL_TIME_START' => 'Hora Inici',
    'LBL_START_DATE_TIME' => 'Data i Hora d\'Inici: ',
    'LBL_TEMPLATE' => 'Plantilla de correu electrònic:',

    'LBL_MODIFIED_BY' => 'Modificat per: ',
    'LBL_CREATED_BY' => 'Creat per: ',

    'LNK_NEW_CAMPAIGN' => 'Crear Campanya',
    'LNK_CAMPAIGN_LIST' => 'Campanyes',
    'LNK_NEW_PROSPECT_LIST' => 'Crear Llista de Públic Objectiu',
    'LNK_PROSPECT_LIST_LIST' => 'Llista de Públic Objectiu',
    'LNK_NEW_PROSPECT' => 'Crear Públic Objectiu',
    'LNK_PROSPECT_LIST' => 'Públic Objectiu',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Màrqueting per correu electrònic',
    'LBL_CREATE_EMAIL_TEMPLATE' => 'Crear',
    'LBL_EDIT_EMAIL_TEMPLATE' => 'Editar',
    'LBL_FROM_MAILBOX' => 'De bustia',
    'LBL_FROM_MAILBOX_NAME' => 'Fer servir bustia:',
    'LBL_OUTBOUND_EMAIL_ACCOUNT_NAME' => 'Compte d\'email sortint:',
    'LBL_PROSPECT_LIST_SUBPANEL_TITLE' => 'Llistes de Públic Objectiu',
    'LBL_ALL_PROSPECT_LISTS' => 'Seleccionar Totes les llistes de públic objectiu de la campanya.',
    'LBL_RELATED_PROSPECT_LISTS' => 'Totes les llistes de públic objectiu relacionades amb aquest missatge.',
    'LBL_PROSPECT_LIST_NAME' => 'Nom de Llista de Públic Objectiu',

    'LBL_LIST_PROSPECT_LIST_NAME' => 'Llista de subscrits',
    'LBL_MODULE_SEND_TEST' => 'Campanya: Enviar prova',
    'LBL_MODULE_SEND_EMAILS' => 'Campanya: Enviar missatges de correu electrònic',
    'LBL_SCHEDULE_MESSAGE_TEST' => 'Seleccioneu els missatges de campanya que voleu provar:',
    'LBL_SCHEDULE_MESSAGE_EMAILS' => 'Seleccioneu els missatges de la campanya que li agradaria programar per al seu enviament en la data i hora d\'inici especificada:',
    'LBL_SCHEDULE_BUTTON_TITLE' => 'Enviar',
    'LBL_SCHEDULE_BUTTON_LABEL' => 'Enviar',
    'LBL_ERROR_ON_MARKETING' => 'Falten camps obligatoris',

    'LBL_CAMPAIGN_ID' => 'ID Campanya',
    'LBL_OUTBOUND_EMAIL_ACOUNT_ID' => 'ID de compte d&#39;E-mail sortint', // Excepció d'escapat 
    'LBL_EMAIL_TEMPLATE' => 'Plantilla de correu electrònic',
    'LBL_PROSPECT_LISTS' => 'Llistes de Públic Objectiu',

);
