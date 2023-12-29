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
    'LBL_ASSIGNED_TO_ID' => 'Id de usuario asignado',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_SECURITYGROUPS' => 'Grupos de Seguridade',
    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => 'Grupos de Seguridade',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creación',
    'LBL_DATE_MODIFIED' => 'Data de Modificación',
    'LBL_MODIFIED' => 'Modificado Por',
    'LBL_MODIFIED_NAME' => 'Modificado Por Nome',
    'LBL_CREATED' => 'Creado Por',
    'LBL_DESCRIPTION' => 'Descrición',
    'LBL_DELETED' => 'Eliminado',
    'LBL_NAME' => 'Nome',
    'LBL_CREATED_USER' => 'Creado polo Usuario',
    'LBL_MODIFIED_USER' => 'Modificado polo Usuario',
    'LBL_LIST_NAME' => 'Nome',
    'LBL_EDIT_BUTTON' => 'Editar',
    'LBL_REMOVE' => 'Quitar',
    'LBL_LIST_FORM_TITLE' => 'Listado',
    'LBL_MODULE_NAME' => 'Táboa dinámica',
    'LBL_MODULE_TITLE' => 'Táboa dinámica',
    'LBL_HOMEPAGE_TITLE' => 'A Miña Táboa Dinámica',
    'LNK_NEW_RECORD' => 'Crear Pivot',
    'LNK_LIST' => 'Ver Pivot',
    'LBL_SEARCH_FORM_TITLE' => 'Buscar Táboa dinámica',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Ver Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_NEW_FORM_TITLE' => 'Nova Táboa Dinámica',
    'LBL_CONFIG' => 'Configuración',
    'LBL_TYPE' => 'Área para Análise',
    'LNK_SPOT_LIST' => 'Ver Spots',
    'LNK_SPOT_CREATE' => 'Crear Spot',

    //Analytics
    'LBL_AN_CONFIGURATION' => 'Configuración',

    'LBL_AN_UNSUPPORTED_DB' => 'Sentímolo, Suite Spots actualmente só está configurado para MySQL e MS SQL',

    //Analytics labels for accounts pivot
    'LBL_AN_ACCOUNTS_ACCOUNT_NAME' => 'Nome',
    'LBL_AN_ACCOUNTS_ACCOUNT_TYPE' => 'Tipo de conta',
    'LBL_AN_ACCOUNTS_ACCOUNT_INDUSTRY' => 'Industria',
    'LBL_AN_ACCOUNTS_ACCOUNT_BILLING_COUNTRY' => 'País de facturación',

    //Analytics labels for leads pivot
    'LBL_AN_LEADS_ASSIGNED_USER' => 'Usuario Asignado',
    'LBL_AN_LEADS_STATUS' => 'Estado',
    'LBL_AN_LEADS_LEAD_SOURCE' => 'Toma de contacto',
    'LBL_AN_LEADS_CAMPAIGN_NAME' => 'Nome de Campaña',
    'LBL_AN_LEADS_YEAR' => 'Ano',
    'LBL_AN_LEADS_QUARTER' => 'Trimestre',
    'LBL_AN_LEADS_MONTH' => 'Mes',
    'LBL_AN_LEADS_WEEK' => 'Semana',
    'LBL_AN_LEADS_DAY' => 'Día',

    //Analytics labels for sales pivot
    'LBL_AN_SALES_ACCOUNT_NAME' => 'Nome de Conta',
    'LBL_AN_SALES_OPPORTUNITY_NAME' => 'Nome da oportunidade',
    'LBL_AN_SALES_ASSIGNED_USER' => 'Usuario Asignado',
    'LBL_AN_SALES_OPPORTUNITY_TYPE' => 'Tipo de Oportunidade',
    'LBL_AN_SALES_LEAD_SOURCE' => 'Toma de contacto',
    'LBL_AN_SALES_AMOUNT' => 'Cantidade',
    'LBL_AN_SALES_STAGE' => 'Etapa de Vendas',
    'LBL_AN_SALES_PROBABILITY' => 'Probabilidade',
    'LBL_AN_SALES_DATE' => 'Data de venda',
    'LBL_AN_SALES_QUARTER' => 'Trimestre de venda',
    'LBL_AN_SALES_MONTH' => 'Vendas do mes',
    'LBL_AN_SALES_WEEK' => 'Vendas da semana',
    'LBL_AN_SALES_DAY' => 'Vendas do día',
    'LBL_AN_SALES_YEAR' => 'Vendas do ano',
    'LBL_AN_SALES_CAMPAIGN' => 'Campaña',

    //Analytics labels for service pivot
    'LBL_AN_SERVICE_ACCOUNT_NAME' => 'Nome de Conta',
    'LBL_AN_SERVICE_STATE' => 'Estado',
    'LBL_AN_SERVICE_STATUS' => 'Estado',
    'LBL_AN_SERVICE_PRIORITY' => 'Prioridade',
    'LBL_AN_SERVICE_CREATED_DAY' => 'Día de creación',
    'LBL_AN_SERVICE_CREATED_WEEK' => 'Semana de creación',
    'LBL_AN_SERVICE_CREATED_MONTH' => 'Mes de creación',
    'LBL_AN_SERVICE_CREATED_QUARTER' => 'Trimestre de creación',
    'LBL_AN_SERVICE_CREATED_YEAR' => 'Ano de creación',
    'LBL_AN_SERVICE_CONTACT_NAME' => 'Nome Contacto',
    'LBL_AN_SERVICE_ASSIGNED_TO' => 'Usuario Asignado',

    //Analytics labels for the activities pivot
    'LBL_AN_ACTIVITIES_TYPE' => 'Tipo',
    'LBL_AN_ACTIVITIES_NAME' => 'Nome',
    'LBL_AN_ACTIVITIES_STATUS' => 'Estado',
    'LBL_AN_ACTIVITIES_ASSIGNED_TO' => 'Usuario Asignado',

    //Analytics labels for the marketing pivot
    'LBL_AN_MARKETING_STATUS' => 'Estado',
    'LBL_AN_MARKETING_TYPE' => 'Tipo',
    'LBL_AN_MARKETING_BUDGET' => 'Presuposto',
    'LBL_AN_MARKETING_EXPECTED_COST' => 'Costo esperado',
    'LBL_AN_MARKETING_EXPECTED_REVENUE' => 'Ingresos Esperados',
    'LBL_AN_MARKETING_OPPORTUNITY_NAME' => 'Nome da oportunidade',
    'LBL_AN_MARKETING_OPPORTUNITY_AMOUNT' => 'Monto da Oportunidade',
    'LBL_AN_MARKETING_OPPORTUNITY_SALES_STAGE' => 'Etapa de venda de oportunidade',
    'LBL_AN_MARKETING_OPPORTUNITY_ASSIGNED_TO' => 'Oportunidade asignada a',
    'LBL_AN_MARKETING_ACCOUNT_NAME' => 'Nome de Conta',

    //Analytics labels for the marketing activities pivot
    'LBL_AN_MARKETINGACTIVITY_CAMPAIGN_NAME' => 'Nome de Campaña',
    'LBL_AN_MARKETINGACTIVITY_ACTIVITY_DATE' => 'Data de Actividade',
    'LBL_AN_MARKETINGACTIVITY_ACTIVITY_TYPE' => 'Tipo de Actividade',
    'LBL_AN_MARKETINGACTIVITY_RELATED_TYPE' => 'Tipo Relacionado',
    'LBL_AN_MARKETINGACTIVITY_RELATED_ID' => 'Id Relacionado',

    //Analytics labels for the quotes pivot
    'LBL_AN_QUOTES_OPPORTUNITY_NAME' => 'Nome da oportunidade',
    'LBL_AN_QUOTES_OPPORTUNITY_TYPE' => 'Tipo de oportunidade',
    'LBL_AN_QUOTES_OPPORTUNITY_LEAD_SOURCE' => 'Toma de contacto da oportunidade',
    'LBL_AN_QUOTES_OPPORTUNITY_SALES_STAGE' => 'Etapa de venda de oportunidade',
    'LBL_AN_QUOTES_ACCOUNT_NAME' => 'Nome de Conta',
    'LBL_AN_QUOTES_CONTACT_NAME' => 'Nome Contacto',
    'LBL_AN_QUOTES_ITEM_NAME' => 'Nome do Elemento',
    'LBL_AN_QUOTES_ITEM_TYPE' => 'Tipo de elemento',
    'LBL_AN_QUOTES_ITEM_CATEGORY' => 'Categoría de artigo',
    'LBL_AN_QUOTES_ITEM_QTY' => 'Cantidade de Artigos',
    'LBL_AN_QUOTES_ITEM_LIST_PRICE' => 'Prezo de lista do artigo',
    'LBL_AN_QUOTES_ITEM_SALE_PRICE' => 'Prezo de venda do artigo',
    'LBL_AN_QUOTES_ITEM_COST_PRICE' => 'Prezo de costo do artigo',
    'LBL_AN_QUOTES_ITEM_DISCOUNT_PRICE' => 'Prezo de desconto de artigo',
    'LBL_AN_QUOTES_ITEM_DISCOUNT_AMOUNT' => 'Cantidade do Desconto',
    'LBL_AN_QUOTES_ITEM_TOTAL' => 'Total de Artigo',
    'LBL_AN_QUOTES_GRAND_TOTAL' => 'Gran Total',
    'LBL_AN_QUOTES_ASSIGNED_TO' => 'Usuario Asignado',
    'LBL_AN_QUOTES_DATE_CREATED' => 'Data de Creación',
    'LBL_AN_QUOTES_DAY_CREATED' => 'Día de creación',
    'LBL_AN_QUOTES_WEEK_CREATED' => 'Semana Creada',
    'LBL_AN_QUOTES_MONTH_CREATED' => 'Mes creado',
    'LBL_AN_QUOTES_QUARTER_CREATED' => 'Trimestre Creado',
    'LBL_AN_QUOTES_YEAR_CREATED' => 'Ano creada',

    //Erro message when there are multiple values for the label
    'LBL_AN_DUPLICATE_LABEL_FOR_SUBAREA' => 'Erro para determinar a etiqueta da zona pivote',

    //Added to allow for the UI of the pivot to be language agnostic - PR 5452
    'LBL_RENDERERS_TABLE' =>'Táboa',
    'LBL_RENDERERS_TABLE_BARCHART' =>'Táboa e Gráfico',
    'LBL_RENDERERS_HEATMAP' =>'Mapa térmico',
    'LBL_RENDERERS_ROW_HEATMAP' =>'Fila do Mapa térmico',
    'LBL_RENDERERS_COL_HEATMAP' =>'Columna do Mapa térmico',
    'LBL_RENDERERS_LINE_CHART' =>'Gráfico de Liñas',
    'LBL_RENDERERS_BAR_CHART' =>'Gráfico de Barras',
    'LBL_RENDERERS_STACKED_BAR_CHART' =>'Barra apilada',
    'LBL_RENDERERS_AREA_CHART' =>'Gráfica de área',
    'LBL_RENDERERS_SCATTER_CHART' =>'Gráfico de dispersión',

    'LBL_AGGREGATORS_COUNT' => 'Total',
    'LBL_AGGREGATORS_COUNT_UNIQUE_VALUES' => 'Contar valores únicos',
    'LBL_AGGREGATORS_LIST_UNIQUE_VALUES' => 'Lista de valores únicos',
    'LBL_AGGREGATORS_SUM' => 'Suma',
    'LBL_AGGREGATORS_INTEGER_SUM' => 'Suma de enteiros',
    'LBL_AGGREGATORS_AVERAGE' => 'Promedio',
    'LBL_AGGREGATORS_MINIMUM' => 'Minimo',
    'LBL_AGGREGATORS_MAXIMUM' => 'Maximo',
    'LBL_AGGREGATORS_SUM_OVER_SUM' => 'Suma sobre suma',
    'LBL_AGGREGATORS_80%_UPPER_BOUND' => 'Límite superior de 80%',
    'LBL_AGGREGATORS_80%_LOWER_BOUND' => 'Límite inferior de 80%',
    'LBL_AGGREGATORS_SUM_AS_FRACTION_OF_TOTAL' => 'Suma como fracción do Total',
    'LBL_AGGREGATORS_SUM_AS_FRACTION_OF_ROWS' => 'Suma como fracción de filas',
    'LBL_AGGREGATORS_SUM_AS_FRACTION_OF_COLUMNS' => 'Suma como fracción de columnas',
    'LBL_AGGREGATORS_COUNT_AS_FRACTION_OF_TOTAL' => 'Contar como fracción do Total',
    'LBL_AGGREGATORS_COUNT_AS_FRACTION_OF_ROWS' => 'Conta como fracción de filas',
    'LBL_AGGREGATORS_COUNT_AS_FRACTION_OF_COLUMNS' => 'Conta como fracción de columnas',

    'LBL_LOCALE_STRINGS_RENDER_ERROR' => 'Produciuse un erro ao procesar os resultados da táboa dinámica.',
    'LBL_LOCALE_STRINGS_COMPUTING_ERROR' => 'Produciuse un erro de cálculo dos resultados da táboa dinámica.',
    'LBL_LOCALE_STRINGS_UI_RENDER_ERROR' => 'Produciuse un erro ao procesar a interfaz de PivotTable.',
    'LBL_LOCALE_STRINGS_SELECT_ALL' => 'Seleccionar Todo',
    'LBL_LOCALE_STRINGS_SELECT_NONE' => 'Non seleccionar ningún',
    'LBL_LOCALE_STRINGS_TOO_MANY' => '(demasiados para a lista)',
    'LBL_LOCALE_STRINGS_FILTER_RESULTS' => 'Resultados do filtro',
    'LBL_LOCALE_STRINGS_TOTALS' => 'Totais',
    'LBL_LOCALE_STRINGS_VS' => 'vs',
    'LBL_LOCALE_STRINGS_BY' => 'por',
    'LBL_LOCALE_STRINGS_OK' => 'Aceptar',

    'LBL_ACTIVITIES_CALL'=>'Chamada',
    'LBL_ACTIVITIES_MEETING'=>'Reunión',
    'LBL_ACTIVITIES_TASK'=>'Tarefa',
);
