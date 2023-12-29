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
    'ERR_NO_OPPS' => 'Por favor, cree polo menos unha Oportunidade para ver os seus gráficos.',
    'LBL_ALL_OPPORTUNITIES' => 'O valor total de todas as oportunidades é',
    'LBL_CHART_TYPE' => 'Tipo de Gráfico',
    'LBL_CREATED_ON' => 'Executado por última vez o',
    'LBL_CLOSE_DATE_START' => 'Data Estimada de Peche - Desde:',
    'LBL_CLOSE_DATE_END' => 'Data Estimada de Peche - Ata:',
    'LBL_DATE_END' => 'Data de Fin:',
    'LBL_DATE_RANGE_TO' => 'a',
    'LBL_DATE_RANGE' => 'O rango de datas é',
    'LBL_DATE_START' => 'Data de Inicio:',
    'LBL_EDIT' => 'Editar',
    'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Mostra as cantidades acumuladas de oportunidades pola toma de contacto seleccionada polo resultado para os usuarios seleccionados. O resultado baséase en se a etapa de venda é Gañada, Perdida ou calquera outro valor.',
    'LBL_LEAD_SOURCE_BY_OUTCOME' => 'Todas as Oportunidades por Toma de Contacto por Resultado',
    'LBL_LEAD_SOURCE_FORM_DESC' => 'Mostra as cantidades acumuladas de oportunidades pola toma de contacto seleccionada polos usuarios seleccionados.',
    'LBL_LEAD_SOURCE_FORM_TITLE' => 'Todas as oportunidades por Toma de Contacto',
    'LBL_LEAD_SOURCE_OTHER' => 'Outro',
    'LBL_LEAD_SOURCES' => 'Tomas de contacto:',
    'LBL_MODULE_NAME' => 'Cadro de Mando',
    'LBL_MODULE_TITLE' => 'Cadro de Mando: Inicio',
    'LBL_MONTH_BY_OUTCOME_DESC' => 'Mostra as cantidades acumuladas de oportunidades por mes e por resultado para os usuarios seleccionados onde a data estimada de peche está dentro do rango de datas especificado. O resultado baséase en se a etapa de venda é Gañada, Perdida ou calquera outro valor.',
    'LBL_OPP_SIZE' => 'Valor da oportunidade en',
    'LBL_OPP_THOUSANDS' => 'K',
    'LBL_OPPS_IN_LEAD_SOURCE' => 'oportunidades onde a toma de contacto é',
    'LBL_OPPS_IN_STAGE' => 'onde a etapa de venda é',
    'LBL_OPPS_OUTCOME' => 'onde o resultado é',
    'LBL_OPPS_WORTH' => 'valor total de oportunidades',
    'LBL_PIPELINE_FORM_TITLE_DESC' => 'Mostra as cantidades acumuladas polas etapas de venda seleccionadas para as súas oportunidades onde a data de peche esperada está dentro do rango de datas especificado.',
    'LBL_REFRESH' => 'Actualizar',
    'LBL_ROLLOVER_DETAILS' => 'Mova o cursor sobre unha barra para máis detalles.',
    'LBL_ROLLOVER_WEDGE_DETAILS' => 'Mova o cursor sobre unha sección para máis detalles.',
    'LBL_SALES_STAGE_FORM_DESC' => 'Mostra as cantidades acumuladas de oportunidades polas etapas de venda seleccionadas para os usuarios seleccionados onde a data estimada de peche está dentro do rango de datas especificado.',
    'LBL_SALES_STAGE_FORM_TITLE' => 'Proceso por Etapa de Vendas',
    'LBL_SALES_STAGES' => 'Etapas de venda:',
    'LBL_TOTAL_PIPELINE' => 'Total en pipeline',
    'LBL_USERS' => 'Usuarios:',
    'LBL_YEAR_BY_OUTCOME' => 'Embudo por Mes por Resultado',
    'LBL_YEAR' => 'Ano:',
    'LNK_NEW_ACCOUNT' => 'Crear unha conta',
    'LNK_NEW_CALL' => 'Rexistrar Chamada',
    'LNK_NEW_CASE' => 'Novo Caso',
    'LNK_NEW_CONTACT' => 'Novo Contacto',
    'LNK_NEW_LEAD' => 'Crear Cliente potencial',
    'LNK_NEW_MEETING' => 'Programar Reunión',
    'LNK_NEW_NOTE' => 'Nova Nota ou Adxunto',
    'LNK_NEW_OPPORTUNITY' => 'Nova Oportunidade',
    'LNK_NEW_TASK' => 'Nova Tarefa',
    'NTC_NO_LEGENDS' => 'Ningún',

    'LBL_TITLE' => 'Título',
    'LBL_MY_MODULES_USED_SIZE' => 'Número de Accesos',

    'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'Proceso por Etapa de Vendas',
    'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'Toma de Contacto por Resultado',
    'LBL_CHART_OUTCOME_BY_MONTH' => 'Resultado por Mes',
    'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'Embudo por Fonte de Oportunidade',
    'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'O Meu Proceso por Etapa de Vendas',
    'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'Os Meus Módulos Utilizados (Últimos 30 Días)',
);
