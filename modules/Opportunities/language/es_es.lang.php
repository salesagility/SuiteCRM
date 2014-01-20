<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the Spanish language pack for the base application.
 * Portions created by REDK Ingeniería del Software S.L..
 * All Rights Reserved.
 * Contributor(s): REDK Software Engineering (www.redk.net)
 ********************************************************************************/
 
$mod_strings = array (
  'LBL_ID' => 'ID',
  'LBL_DATE_ENTERED' => 'Fecha de Creación',
  'LBL_DATE_MODIFIED' => 'Última Modificación',
  'LBL_MODIFIED' => 'Modificado Por',
  'LBL_MODIFIED_ID' => 'Modificada por ID',
  'LBL_MODIFIED_NAME' => 'Modificada por Usuario',
  'LBL_CREATED' => 'Creado Por',
  'LBL_CREATED_ID' => 'Creada por ID',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DELETED' => 'Eliminado',
  'LBL_NAME' => 'Nombre Oportunidad',
  'LBL_CREATED_USER' => 'Usuario Creado',
  'LBL_MODIFIED_USER' => 'Usuario Modificado',
  'LBL_LIST_NAME' => 'Nombre',
  'LBL_EDIT_BUTTON' => 'Editar',
  'LBL_REMOVE' => 'Quitar',
  'LBL_ASSIGNED_TO_ID' => 'Usuario Asignado:',
  'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
  'LBL_MODULE_NAME' => 'Oportunidades',
  'LBL_MODULE_TITLE' => 'Oportunidades: Inicio',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Oportunidades',
  'LBL_VIEW_FORM_TITLE' => 'Vista de Oportunidades',
  'LBL_LIST_FORM_TITLE' => 'Lista de Oportunidades',
  'LBL_OPPORTUNITY_NAME' => 'Nombre Oportunidad:',
  'LBL_OPPORTUNITY' => 'Oportunidad:',
  'LBL_INVITEE' => 'Contactos',
  'LBL_CURRENCIES' => 'Monedas',
  'LBL_LIST_OPPORTUNITY_NAME' => 'Nombre',
  'LBL_LIST_ACCOUNT_NAME' => 'Cuenta',
  'LBL_LIST_AMOUNT' => 'Monto de la Oportunidad',
  'LBL_LIST_AMOUNT_USDOLLAR' => 'Monto',
  'LBL_LIST_DATE_CLOSED' => 'Fecha Cierre',
  'LBL_LIST_SALES_STAGE' => 'Etapa de Ventas',
  'LBL_ACCOUNT_ID' => 'ID de Cuenta',
  'LBL_CURRENCY_ID' => 'ID de Moneda',
  'LBL_CURRENCY_NAME' => 'Nombre de Moneda',
  'LBL_CURRENCY_SYMBOL' => 'Símbolo de Moneda',
  'db_sales_stage' => 'LBL_LIST_SALES_STAGE',
  'db_name' => 'LBL_NAME',
  'db_amount' => 'LBL_LIST_AMOUNT',
  'db_date_closed' => 'LBL_LIST_DATE_CLOSED',
  'UPDATE' => 'Oportunidad - Actualizar Moneda',
  'UPDATE_DOLLARAMOUNTS' => 'Actualizar Montos en Dólares EEUU',
  'UPDATE_VERIFY' => 'Verificar Montos',
  'UPDATE_VERIFY_TXT' => 'Verifica que los valores de las cantidades en las oportunidades son números decimales válidos con sólo caracteres numéricos (0-9) y decimales(.)',
  'UPDATE_FIX' => 'Corregir Montos',
  'UPDATE_FIX_TXT' => 'Intenta corregir cualquier cantidad no válida creando un número decimal válido a partir de la cantidad actual. Antes realiza una copia de seguridad de todas las cantidades modificadas en el campo de base de datos amount_backup. Si tras la correción detecta problemas, no vuelva a realizar esta operación sin restaurar los valores previos desde la copia de seguridad ya que si no sobrescribirá la copia de seguridad con nuevos datos no válidos.',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Actualiza las cantidades en Dólares EEUU para las oportunidades basadas en el conjunto actual de cambios de moneda. Este valor se usa para calcular gráficas y vistas de listas de cantidades monetarias.',
  'UPDATE_CREATE_CURRENCY' => 'Creación de nueva moneda:',
  'UPDATE_VERIFY_FAIL' => 'Fallo de verificación de registro:',
  'UPDATE_VERIFY_CURAMOUNT' => 'Monto actual:',
  'UPDATE_VERIFY_FIX' => 'La corrección daría',
  'UPDATE_INCLUDE_CLOSE' => 'Registros cerrados incluidos',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nuevo monto:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nueva moneda:',
  'UPDATE_DONE' => 'Hecho',
  'UPDATE_BUG_COUNT' => 'Problemas detectados cuya resolución se ha intentado:',
  'UPDATE_BUGFOUND_COUNT' => 'Problemas detectados:',
  'UPDATE_COUNT' => 'Registros actualizados:',
  'UPDATE_RESTORE_COUNT' => 'Registros con cantidades restauradas:',
  'UPDATE_RESTORE' => 'Restaurar Montos',
  'UPDATE_RESTORE_TXT' => 'Restaura los valores de las cantidades desde la copia de seguridad creada durante la corrección.',
  'UPDATE_FAIL' => 'No ha podido actualizarse -',
  'UPDATE_NULL_VALUE' => 'La cantidad es NULL, estableciéndola a 0 -',
  'UPDATE_MERGE' => 'Unificar Monedas',
  'UPDATE_MERGE_TXT' => 'Unifica múltiples monedas en una única moneda. Si detecta que hay múltiples registros de tipo moneda para la misma moneda, puede unificarlas. Esto también unificará las monedas para el resto de módulos.',
  'LBL_ACCOUNT_NAME' => 'Cuenta:',
  'LBL_AMOUNT' => 'Monto de la Oportunidad:',
  'LBL_AMOUNT_USDOLLAR' => 'Monto:',
  'LBL_CURRENCY' => 'Moneda:',
  'LBL_DATE_CLOSED' => 'Fecha de cierre:',
  'LBL_TYPE' => 'Tipo:',
  'LBL_CAMPAIGN' => 'Campaña:',
  'LBL_NEXT_STEP' => 'Próximo paso:',
  'LBL_LEAD_SOURCE' => 'Toma de contacto:',
  'LBL_SALES_STAGE' => 'Etapa de ventas:',
  'LBL_PROBABILITY' => 'Probabilidad (%):',
  'LBL_DUPLICATE' => 'Posible oportunidad duplicada',
  'MSG_DUPLICATE' => 'El registro para la oportunidad que va a crear podría ser un duplicado de otro registro de oportunidad existente. Los registros de oportunidad con nombres similares se listan a continuación.<br>Haga clic en Guardar para continuar con la creación de esta oportunidad, o en Cancelar para volver al módulo sin crear la oportunidad.',
  'LBL_NEW_FORM_TITLE' => 'Nueva Oportunidad',
  'LNK_NEW_OPPORTUNITY' => 'Nueva Oportunidad',
  'LNK_OPPORTUNITY_LIST' => 'Ver Oportunidades',
  'ERR_DELETE_RECORD' => 'Debe especificar un número de registro a eliminar.',
  'LBL_TOP_OPPORTUNITIES' => 'Mis Principales Oportunidades',
  'NTC_REMOVE_OPP_CONFIRMATION' => '¿Está seguro de que desea eliminar este contacto de la oportunidad?',
  'OPPORTUNITY_REMOVE_PROJECT_CONFIRM' => '¿Está seguro de que desea eliminar esta oportunidad del proyecto?',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Oportunidades',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
  'LBL_RAW_AMOUNT' => 'Importe Bruto',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciales',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_MY_CLOSED_OPPORTUNITIES' => 'Mis Oportunidades Cerradas',
  'LBL_TOTAL_OPPORTUNITIES' => 'Oportunidades Totales',
  'LBL_CLOSED_WON_OPPORTUNITIES' => 'Oportunidades Ganadas',
  'LBL_CAMPAIGN_OPPORTUNITY' => 'Campañas',
  'LBL_PROJECT_SUBPANEL_TITLE' => 'Proyectos',
  'LABEL_PANEL_ASSIGNMENT' => 'Asignación',
  'LNK_IMPORT_OPPORTUNITIES' => 'Importar Oportunidades',
  'LBL_EDITLAYOUT' => 'Editar diseño',
  'LBL_EXPORT_CAMPAIGN_ID' => 'Id de campaña',
  'LBL_OPPORTUNITY_TYPE' => 'Tipo de oportunidad',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Usuario asignado',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID Usuario asignado',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificador por ID',
  'LBL_EXPORT_CREATED_BY' => 'Creado por ID',
  'LBL_EXPORT_NAME' => 'Nombre',
  'LBL_CONTACT_HISTORY_SUBPANEL_TITLE' => 'Emails de contactos relacionados',
);