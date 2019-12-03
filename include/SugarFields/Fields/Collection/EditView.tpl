{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2019 Salesagility Ltd.
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
 ********************************************************************************/

*}

<div id='{{sugarvar key='name'}}_image_div' name='{{sugarvar key='name'}}_image_div'><img src="{sugar_getimagepath file='sqsWait.gif'}" alt="loading..." id="{{sugarvar key="name"}}_loading_img" style="display:none"></div>
<div id='{{sugarvar key='name'}}_div' name='{{sugarvar key='name'}}_div'></div>
<script type="text/javascript">
    document.getElementById('{{sugarvar key="name"}}_image_div').parentElement.previousElementSibling.style.width="10%";
    document.getElementById('{{sugarvar key="name"}}_image_div').parentElement.style.width="90%";
{literal}
    var callback = {
        success:function(o){
           {/literal}

            document.getElementById('{{sugarvar key="name"}}_loading_img').style.display="none";
            document.getElementById('{{sugarvar key="name"}}_div').innerHTML = o.responseText;
            SUGAR.util.evalScript(o.responseText);
            {literal}
        },
        failure:function(o){
            alert(SUGAR.language.get('app_strings','LBL_AJAX_FAILURE'));
        }
    }
    {/literal}
    var action_type = 'editview';
    if (document.getElementById('{{sugarvar key="name"}}_collection_action_type'))
        if (document.getElementById('{{sugarvar key="name"}}_collection_action_type').value != '')
            var action_type = document.getElementById('{{sugarvar key="name"}}_collection_action_type').value;
    document.getElementById('{{sugarvar key="name"}}_loading_img').style.display="inline";
{literal}
    if (typeof(document.forms.EditView) == 'undefined')
        for(var s=0; s < document.forms.length; s++){
            if (document.forms[s].getAttribute("name").indexOf('QuickCreate') >= 0) {
                var formnamefound = document.forms[s].getAttribute("name");
            }
        }
     else
         var formnamefound = 'EditView';
{/literal}
    postData = '&displayParams=' + '{{$displayParamsJSON}}' + '&vardef=' + '{{$vardefJSON}}' + '&module_dir=' + document.forms[formnamefound].module.value + '&bean_id=' + document.forms[formnamefound].record.value + '&action_type=' + action_type;
    {literal}
    YAHOO.util.Connect.asyncRequest('POST', 'index.php?action=viewsugarfieldcollection', callback, postData);
{/literal}
</script>