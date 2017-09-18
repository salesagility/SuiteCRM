{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
*}
{literal}
<script>
    $(function(){

        /**
         * Event handler for submit button
         * - prevent form submit
         * - fill ie multi-select if empty
         * - submit the form
         */
        $('form[name="sync-form"]').submit(function (e) {
            e.preventDefault();

            // select all inbound email if no one is selected

            if (null === $('select[name="ie-sel[]"]').val()) {
                $('select[name="ie-sel[]"] option').prop('selected', true);
            }

            this.submit();

            $('form[name="sync-form"]').hide();

            setInterval(function(){
                $.get('modules/Administration/SyncInboundEmailAccounts/sync_output.html', function(resp){
                    $('#sync-results').html(resp);
                });
            }, 1000);

        });

    });

</script>
{/literal}

{$app_strings.LBL_SYNC_IE_EMAILS}

<form name="sync-form" method="POST" action="">

    <input type="hidden" name="method" value="sync">

    {$app_strings.LBL_EMAIL_SETTINGS_NAME}

    <br>

    <select name="ie-sel[]" class="ie-sel" multiple="multiple" title="{$app_strings.LBL_EMAIL_SETTINGS_NAME}">
        {foreach from=$ieList item=ie}
            <option value="{$ie.id}">{$ie.name}</option>
        {/foreach}
    </select>

    <br>

    <input class="sync-btn" type="submit" value="{$app_strings.LBL_SYNC}">

</form>
<div id="sync-results"></div>
