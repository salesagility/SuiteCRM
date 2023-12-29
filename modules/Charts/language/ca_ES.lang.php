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
    'ERR_NO_OPPS' => 'Si us plau, creï com a mínim una Oportunitat per veure els seus gràfics.',
    'LBL_ALL_OPPORTUNITIES' => 'El valor total de totes les oportunitats es ',
    'LBL_CHART_TYPE' => 'Tipus de Gráfic',
    'LBL_CREATED_ON' => 'Executat per última vegada el ',
    'LBL_CLOSE_DATE_START' => 'Data de tancament estimada - Des de:',
    'LBL_CLOSE_DATE_END' => 'Data de tancament estimada - Fins:',
    'LBL_DATE_END' => 'Data de finalització:',
    'LBL_DATE_RANGE_TO' => 'a',
    'LBL_DATE_RANGE' => 'El rang de dates és',
    'LBL_DATE_START' => 'Data d\'Inici:',
    'LBL_EDIT' => 'Editar',
    'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Mostra les quantitats acumulades d\'oportunitats per la presa de contacte seleccionada pel resultat per als usuaris seleccionats. El resultat es basa en si l\'etapa de venda és Bestiar, Perdido o qualsevol altre valor.',
    'LBL_LEAD_SOURCE_BY_OUTCOME' => 'Totes les oportunitats per presa de contacte per resultat',
    'LBL_LEAD_SOURCE_FORM_DESC' => 'Mostra les quantitats acumulades d\'oportunitats per la presa de contacte seleccionada pels usuaris seleccionats.',
    'LBL_LEAD_SOURCE_FORM_TITLE' => 'Totes les oportunitats per presa de contacte',
    'LBL_LEAD_SOURCE_OTHER' => 'Un altre',
    'LBL_LEAD_SOURCES' => 'Presa de Contacte:',
    'LBL_MODULE_NAME' => 'Quadre de Comandament',
    'LBL_MODULE_TITLE' => 'Quadre de comandament: Inici',
    'LBL_MONTH_BY_OUTCOME_DESC' => 'Mostra les quantitats acumulades d\'oportunitats per mes i per resultat per als usuaris seleccionades on la data estimada de tancament és dins del rang de dates especificades.',
    'LBL_OPP_SIZE' => 'Valor de l\'oportunitat en',
    'LBL_OPP_THOUSANDS' => 'K',
    'LBL_OPPS_IN_LEAD_SOURCE' => 'oportunitats on la presa de contacte és',
    'LBL_OPPS_IN_STAGE' => 'amb etapa de venda',
    'LBL_OPPS_OUTCOME' => 'on el resultat és',
    'LBL_OPPS_WORTH' => 'oportunitats valorades en',
    'LBL_PIPELINE_FORM_TITLE_DESC' => 'Mostra les quantitats acumulades pels etapes de venda seleccionats per a les seves oportunitats on la data de tancament esperada és dins del rang de dates éspecificades.',
    'LBL_REFRESH' => 'Actualitzar',
    'LBL_ROLLOVER_DETAILS' => 'Mogui el cursor sobre una barra per a més detall.',
    'LBL_ROLLOVER_WEDGE_DETAILS' => 'Mogui el cursor sobre una secció per a més detall.',
    'LBL_SALES_STAGE_FORM_DESC' => 'Mostra les quantitats acumulades d\'oportunitats pels etapes de venda seleccionats per als usuaris seleccionats on la data estimada de tancament és dins del rang de dates especificades.',
    'LBL_SALES_STAGE_FORM_TITLE' => 'Objectiu per etapa de venda',
    'LBL_SALES_STAGES' => 'Etapas de venda:',
    'LBL_TOTAL_PIPELINE' => 'Total en objectiu ',
    'LBL_USERS' => 'Usuaris:',
    'LBL_YEAR_BY_OUTCOME' => 'Objectiu per mes per resultat',
    'LBL_YEAR' => 'Any:',
    'LNK_NEW_ACCOUNT' => 'Nou Compte',
    'LNK_NEW_CALL' => 'Programar Trucada',
    'LNK_NEW_CASE' => 'Nou Cas',
    'LNK_NEW_CONTACT' => 'Nou Contacte',
    'LNK_NEW_LEAD' => 'Nou Client Potencial',
    'LNK_NEW_MEETING' => 'Programar Reunió',
    'LNK_NEW_NOTE' => 'Nova Nota o Adjunt',
    'LNK_NEW_OPPORTUNITY' => 'Nova Oportunitat',
    'LNK_NEW_TASK' => 'Nova Tasca',
    'NTC_NO_LEGENDS' => 'Cap',

    'LBL_TITLE' => 'Títol',
    'LBL_MY_MODULES_USED_SIZE' => 'Número d\'Accesos',

    'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'Embut per etapa de vendes',
    'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'Font principal pel resultat',
    'LBL_CHART_OUTCOME_BY_MONTH' => 'Resultat per Mes',
    'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'Embut per font principal',
    'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'El meu canal per etapa de vendes',
    'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'Els meus mòduls utilitzats (Últims 30 dies)',
);
