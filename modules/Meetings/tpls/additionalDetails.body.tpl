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
<input id="type" type="hidden" value="{$OBJECT_NAME}"/>
{if !empty($FIELD.ID)}
    <input id="id" type="hidden" value="{$FIELD.ID}"/>
{/if}

{if !empty($FIELD.NAME)}
    <div>
        <strong>{$MOD.LBL_SUBJECT}</strong>
        <a href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}">{$FIELD.NAME}</a>
    </div>
{/if}

{if !empty($FIELD.DATE_START)}
    <div data-field="DATE_START" data-date="{$FIELD.DB_DATE_START}">
        <strong>{$MOD.LBL_DATE_TIME}</strong>
        {$FIELD.DATE_START}
    </div>
{/if}

{if !empty($FIELD.DURATION_HOURS)  or !empty($FIELD.DURATION_MINUTES)}
    <div>
        <strong>{$MOD.LBL_DURATION}</strong>
        {if !empty($FIELD.DURATION_HOURS)}
            {$FIELD.DURATION_HOURS} {$MOD.LBL_HOURS_ABBREV}
        {/if}

        {if !empty($FIELD.DURATION_MINUTES)}
            {$FIELD.DURATION_MINUTES} {$MOD.LBL_MINSS_ABBREV}
        {/if}
    </div>
{/if}

{if !empty($FIELD.PARENT_ID)}
    <div>
        <strong>{$MOD.LBL_RELATED_TO}</strong>
        <a href="index.php?module={$FIELD.PARENT_TYPE}&action=DetailView&record={$FIELD.PARENT_ID}">{$FIELD.PARENT_TYPE}
            - {$FIELD.PARENT_NAME}</a>
    </div>
{/if}

{if !empty($FIELD.STATUS)}
    <div>
        <strong>{$MOD.LBL_STATUS}</strong>
        {$FIELD.STATUS}
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$MOD.LBL_DESCRIPTION}</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
