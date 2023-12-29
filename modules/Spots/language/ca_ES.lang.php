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
    'LBL_ASSIGNED_TO_ID' => 'ID Usuari Assignat',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_SECURITYGROUPS' => 'Grups de Seguretat',
    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => 'Grups de Seguretat',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creació',
    'LBL_DATE_MODIFIED' => 'Última Modificació',
    'LBL_MODIFIED' => 'Modificat Per',
    'LBL_MODIFIED_NAME' => 'Modificat Per Nom',
    'LBL_CREATED' => 'Creat Per',
    'LBL_DESCRIPTION' => 'Descripció',
    'LBL_DELETED' => 'Eliminat',
    'LBL_NAME' => 'Nom',
    'LBL_CREATED_USER' => 'Creat Per Usuari',
    'LBL_MODIFIED_USER' => 'Modificat Per Usuari',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_EDIT_BUTTON' => 'Editar',
    'LBL_REMOVE' => 'Eliminar',
    'LBL_LIST_FORM_TITLE' => 'Llistat',
    'LBL_MODULE_NAME' => 'Taula dinàmica',
    'LBL_MODULE_TITLE' => 'Taula dinàmica',
    'LBL_HOMEPAGE_TITLE' => 'Meu Pivot',
    'LNK_NEW_RECORD' => 'Crear Pivot',
    'LNK_LIST' => 'Mostra la llista',
    'LBL_SEARCH_FORM_TITLE' => 'Buscar taula dinàmica',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Veure Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_NEW_FORM_TITLE' => 'Nova taula dinàmica',
    'LBL_CONFIG' => 'Configura',
    'LBL_TYPE' => 'Àrea d\'anàlisi',
    'LNK_SPOT_LIST' => 'Veure els punts',
    'LNK_SPOT_CREATE' => 'Crear Spot',

    //Analytics
    'LBL_AN_CONFIGURATION' => 'Configuració',

    'LBL_AN_UNSUPPORTED_DB' => 'Ho sentim, Suite taques estan actualment configurats per a MySQL i MS SQL només',

    //Analytics labels for accounts pivot
    'LBL_AN_ACCOUNTS_ACCOUNT_NAME' => 'Nom',
    'LBL_AN_ACCOUNTS_ACCOUNT_TYPE' => 'Tipus de compta',
    'LBL_AN_ACCOUNTS_ACCOUNT_INDUSTRY' => 'Indústria',
    'LBL_AN_ACCOUNTS_ACCOUNT_BILLING_COUNTRY' => 'País de facturació:',

    //Analytics labels for leads pivot
    'LBL_AN_LEADS_ASSIGNED_USER' => 'Usuari Assignat',
    'LBL_AN_LEADS_STATUS' => 'Estat',
    'LBL_AN_LEADS_LEAD_SOURCE' => 'Presa de Contacte',
    'LBL_AN_LEADS_CAMPAIGN_NAME' => 'Nom de Campanya',
    'LBL_AN_LEADS_YEAR' => 'Any',
    'LBL_AN_LEADS_QUARTER' => 'Trimestre',
    'LBL_AN_LEADS_MONTH' => 'Mes',
    'LBL_AN_LEADS_WEEK' => 'Setmana',
    'LBL_AN_LEADS_DAY' => 'Dia',

    //Analytics labels for sales pivot
    'LBL_AN_SALES_ACCOUNT_NAME' => 'Nom',
    'LBL_AN_SALES_OPPORTUNITY_NAME' => 'Nom de l\'Oportunitat',
    'LBL_AN_SALES_ASSIGNED_USER' => 'Usuari Assignat',
    'LBL_AN_SALES_OPPORTUNITY_TYPE' => 'Tipus d\'oportunitat',
    'LBL_AN_SALES_LEAD_SOURCE' => 'Presa de Contacte',
    'LBL_AN_SALES_AMOUNT' => 'Quantitat',
    'LBL_AN_SALES_STAGE' => 'Etapa de Vendes',
    'LBL_AN_SALES_PROBABILITY' => 'Probabilitat',
    'LBL_AN_SALES_DATE' => 'Data de vendes',
    'LBL_AN_SALES_QUARTER' => 'Trimestre de venda',
    'LBL_AN_SALES_MONTH' => 'Mes compartit',
    'LBL_AN_SALES_WEEK' => 'Setmana compartida',
    'LBL_AN_SALES_DAY' => 'Dia de vendes',
    'LBL_AN_SALES_YEAR' => 'Any de vendes',
    'LBL_AN_SALES_CAMPAIGN' => 'Campanyes',

    //Analytics labels for service pivot
    'LBL_AN_SERVICE_ACCOUNT_NAME' => 'Nom',
    'LBL_AN_SERVICE_STATE' => 'Estat/Província',
    'LBL_AN_SERVICE_STATUS' => 'Estat',
    'LBL_AN_SERVICE_PRIORITY' => 'Prioritat',
    'LBL_AN_SERVICE_CREATED_DAY' => 'Dia creat',
    'LBL_AN_SERVICE_CREATED_WEEK' => 'Setmana creat',
    'LBL_AN_SERVICE_CREATED_MONTH' => 'Contacte Creat',
    'LBL_AN_SERVICE_CREATED_QUARTER' => 'Data de creació',
    'LBL_AN_SERVICE_CREATED_YEAR' => 'Creat l\'any',
    'LBL_AN_SERVICE_CONTACT_NAME' => 'Nom Contacte',
    'LBL_AN_SERVICE_ASSIGNED_TO' => 'Usuari Assignat',

    //Analytics labels for the activities pivot
    'LBL_AN_ACTIVITIES_TYPE' => 'Tipus',
    'LBL_AN_ACTIVITIES_NAME' => 'Nom',
    'LBL_AN_ACTIVITIES_STATUS' => 'Estat',
    'LBL_AN_ACTIVITIES_ASSIGNED_TO' => 'Usuari Assignat',

    //Analytics labels for the marketing pivot
    'LBL_AN_MARKETING_STATUS' => 'Estat',
    'LBL_AN_MARKETING_TYPE' => 'Tipus',
    'LBL_AN_MARKETING_BUDGET' => 'Pressupost',
    'LBL_AN_MARKETING_EXPECTED_COST' => 'Cost Esperat: ',
    'LBL_AN_MARKETING_EXPECTED_REVENUE' => 'Ingressos Esperats',
    'LBL_AN_MARKETING_OPPORTUNITY_NAME' => 'Nom de l\'Oportunitat',
    'LBL_AN_MARKETING_OPPORTUNITY_AMOUNT' => 'Quantitat',
    'LBL_AN_MARKETING_OPPORTUNITY_SALES_STAGE' => 'Etapa de venda d\'oportunitat',
    'LBL_AN_MARKETING_OPPORTUNITY_ASSIGNED_TO' => 'Oportunitat assignada a',
    'LBL_AN_MARKETING_ACCOUNT_NAME' => 'Nom',

    //Analytics labels for the marketing activities pivot
    'LBL_AN_MARKETINGACTIVITY_CAMPAIGN_NAME' => 'Nom de Campanya',
    'LBL_AN_MARKETINGACTIVITY_ACTIVITY_DATE' => 'Data d\'Activitat',
    'LBL_AN_MARKETINGACTIVITY_ACTIVITY_TYPE' => 'Tipus d\'Activitat',
    'LBL_AN_MARKETINGACTIVITY_RELATED_TYPE' => 'Tipus Relacionat',
    'LBL_AN_MARKETINGACTIVITY_RELATED_ID' => 'Id Relacionat',

    //Analytics labels for the quotes pivot
    'LBL_AN_QUOTES_OPPORTUNITY_NAME' => 'Nom de l\'Oportunitat',
    'LBL_AN_QUOTES_OPPORTUNITY_TYPE' => 'Tipus d\'oportunitat',
    'LBL_AN_QUOTES_OPPORTUNITY_LEAD_SOURCE' => 'Font principal d\'oportunitat',
    'LBL_AN_QUOTES_OPPORTUNITY_SALES_STAGE' => 'Etapa de venda d\'oportunitat',
    'LBL_AN_QUOTES_ACCOUNT_NAME' => 'Nom',
    'LBL_AN_QUOTES_CONTACT_NAME' => 'Nom Contacte',
    'LBL_AN_QUOTES_ITEM_NAME' => 'Nom de l\'element',
    'LBL_AN_QUOTES_ITEM_TYPE' => 'Tipus d\'elements',
    'LBL_AN_QUOTES_ITEM_CATEGORY' => 'Categoria d\'element',
    'LBL_AN_QUOTES_ITEM_QTY' => 'Quantitat d\'element',
    'LBL_AN_QUOTES_ITEM_LIST_PRICE' => 'Preu de venda d\'element',
    'LBL_AN_QUOTES_ITEM_SALE_PRICE' => 'Preu de venda d\'element',
    'LBL_AN_QUOTES_ITEM_COST_PRICE' => 'Preu de venda d\'element',
    'LBL_AN_QUOTES_ITEM_DISCOUNT_PRICE' => 'Preu de descompte d\'article',
    'LBL_AN_QUOTES_ITEM_DISCOUNT_AMOUNT' => 'Import de descompte',
    'LBL_AN_QUOTES_ITEM_TOTAL' => 'Total d\'element',
    'LBL_AN_QUOTES_GRAND_TOTAL' => 'Gran total',
    'LBL_AN_QUOTES_ASSIGNED_TO' => 'Usuari Assignat',
    'LBL_AN_QUOTES_DATE_CREATED' => 'Data de Creació',
    'LBL_AN_QUOTES_DAY_CREATED' => 'Dia creat',
    'LBL_AN_QUOTES_WEEK_CREATED' => 'Setmana creada',
    'LBL_AN_QUOTES_MONTH_CREATED' => 'Mes creada',
    'LBL_AN_QUOTES_QUARTER_CREATED' => 'Trimestre creat',
    'LBL_AN_QUOTES_YEAR_CREATED' => 'Creada l\'any',

    //Error message when there are multiple values for the label
    'LBL_AN_DUPLICATE_LABEL_FOR_SUBAREA' => 'Coneixement de l\'etiqueta de la subàrea de dinàmica d\'error',

    //Added to allow for the UI of the pivot to be language agnostic - PR 5452
    'LBL_RENDERERS_TABLE' =>'taula',
    'LBL_RENDERERS_TABLE_BARCHART' =>'Taula i Gràfic',
    'LBL_RENDERERS_HEATMAP' =>'Mapa tèrmic',
    'LBL_RENDERERS_ROW_HEATMAP' =>'Fila del mapa tèrmic',
    'LBL_RENDERERS_COL_HEATMAP' =>'Columna del Mapa tèrmic',
    'LBL_RENDERERS_LINE_CHART' =>'Gràfic de Línies',
    'LBL_RENDERERS_BAR_CHART' =>'Gràfic de Barres',
    'LBL_RENDERERS_STACKED_BAR_CHART' =>'Barra apilada',
    'LBL_RENDERERS_AREA_CHART' =>'Gràfic Circular',
    'LBL_RENDERERS_SCATTER_CHART' =>'Gràfic de dispersió',

    'LBL_AGGREGATORS_COUNT' => 'Total',
    'LBL_AGGREGATORS_COUNT_UNIQUE_VALUES' => 'Valors únics de llista',
    'LBL_AGGREGATORS_LIST_UNIQUE_VALUES' => 'Valors únics de llista',
    'LBL_AGGREGATORS_SUM' => 'Suma',
    'LBL_AGGREGATORS_INTEGER_SUM' => 'Suma d\'enters',
    'LBL_AGGREGATORS_AVERAGE' => 'Mitjana',
    'LBL_AGGREGATORS_MINIMUM' => 'Mínim',
    'LBL_AGGREGATORS_MAXIMUM' => 'Màxim',
    'LBL_AGGREGATORS_SUM_OVER_SUM' => 'Suma sobre la suma',
    'LBL_AGGREGATORS_80%_UPPER_BOUND' => 'Límit superior de 80%',
    'LBL_AGGREGATORS_80%_LOWER_BOUND' => 'Límit inferior de 80%',
    'LBL_AGGREGATORS_SUM_AS_FRACTION_OF_TOTAL' => 'Fracció de columnes que es comptaràn',
    'LBL_AGGREGATORS_SUM_AS_FRACTION_OF_ROWS' => 'Suma com a fracció de files',
    'LBL_AGGREGATORS_SUM_AS_FRACTION_OF_COLUMNS' => 'Suma com a fracció de columnes',
    'LBL_AGGREGATORS_COUNT_AS_FRACTION_OF_TOTAL' => 'Fracció de columnes que es comptarà',
    'LBL_AGGREGATORS_COUNT_AS_FRACTION_OF_ROWS' => 'Contar com a fracció de files',
    'LBL_AGGREGATORS_COUNT_AS_FRACTION_OF_COLUMNS' => 'Fracció de columnes es comptarà',

    'LBL_LOCALE_STRINGS_RENDER_ERROR' => 'S\'ha produït un error al processar els resultats de la taula dinàmica.',
    'LBL_LOCALE_STRINGS_COMPUTING_ERROR' => 'S\'ha produït un error de càlcul dels resultats de la taula dinàmica.',
    'LBL_LOCALE_STRINGS_UI_RENDER_ERROR' => 'S\'ha produït un error al processar la interfície de PivotTable.',
    'LBL_LOCALE_STRINGS_SELECT_ALL' => 'Tots els Registres',
    'LBL_LOCALE_STRINGS_SELECT_NONE' => 'No en seleccionis cap',
    'LBL_LOCALE_STRINGS_TOO_MANY' => '(massa per a la llista)',
    'LBL_LOCALE_STRINGS_FILTER_RESULTS' => 'Resultats filtrats',
    'LBL_LOCALE_STRINGS_TOTALS' => 'Totals',
    'LBL_LOCALE_STRINGS_VS' => 'vs',
    'LBL_LOCALE_STRINGS_BY' => 'per',
    'LBL_LOCALE_STRINGS_OK' => 'Acceptar',

    'LBL_ACTIVITIES_CALL'=>'Trucades',
    'LBL_ACTIVITIES_MEETING'=>'Reunions',
    'LBL_ACTIVITIES_TASK'=>'Tasques',
);
