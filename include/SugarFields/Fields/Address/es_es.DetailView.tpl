{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the Spanish language pack for the base application.
 * Portions created by REDK Ingeniería del Software S.L..
 * All Rights Reserved.
 * Contributor(s): REDK Software Engineering (www.redk.net)
 ********************************************************************************/


*}
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='99%'>
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_street" value="{$fields.{{$displayParams.key}}_address_street.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_city" value="{$fields.{{$displayParams.key}}_address_city.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_country" value="{$fields.{{$displayParams.key}}_address_country.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_postalcode" value="{$fields.{{$displayParams.key}}_address_postalcode.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
{$fields.{{$displayParams.key}}_address_street.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}<br>
{$fields.{{$displayParams.key}}_address_city.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br} {$fields.{{$displayParams.key}}_address_state.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}&nbsp;&nbsp;{$fields.{{$displayParams.key}}_address_postalcode.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}<br>
{$fields.{{$displayParams.key}}_address_country.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}
</td>
{{if !empty($displayParams.enableConnectors)}}
<td class="dataField">
{{sugarvar_connector view='DetailView'}} 
</td>
{{/if}}
<td class='dataField' width='1%'>
{{* 
Este es el código personalizado que se puede configurar para que muestre en la segunda columna 
de la tabla de direcciones. Un ejemplo podría ser el botón "Copiar" de la presente DetailView Cuentas.
Ver modules modules/Accounts/views/view.detail.php para ver el valor que se establece
*}}
{$custom_code_{{$displayParams.key}}}
</td>
</tr>
</table>