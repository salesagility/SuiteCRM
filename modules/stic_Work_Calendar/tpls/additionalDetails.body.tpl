{* 
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 *}
{if !empty($FIELD.NAME)}
    <div>
        <a href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}">{$FIELD.NAME}</a>
    </div>
{/if}
<br>
{if !empty($FIELD.START_DATE)}
    <div data-field="START_DATE" data-date="{$FIELD.DB_START_DATE}">
        <strong>{$PARAM.LBL_START_DATE}:</strong>
        {$FIELD.START_DATE}
    </div>
{/if}

{if !empty($FIELD.END_DATE)}
    <div data-field="END_DATE" data-date="{$FIELD.DB_END_DATE}">
        <strong>{$PARAM.LBL_END_DATE}:</strong>
        {$FIELD.END_DATE}
    </div>
{/if}

{if !empty($FIELD.WEEKDAY)}
    <div data-field="WEEKDAY" data-date="{$FIELD.DB_WEEKDAY}">
        <strong>{$PARAM.LBL_WEEKDAY}:</strong>
        {$FIELD.WEEKDAY}
    </div>
{/if}

{if !empty($FIELD.DURATION)}
    <div data-field="DURATION" data-date="{$FIELD.DB_DURATION}">
        <strong>{$PARAM.LBL_DURATION}:</strong>
        {$FIELD.DURATION}
    </div>
{/if}

{if !empty($FIELD.TYPE)}
    <div>
        <strong>{$PARAM.LBL_TYPE}:</strong>
        {$FIELD.TYPE}
    </div>
{/if}

{if !empty($FIELD.ASSIGNED_USER_ID)}
    <div>
        <strong>{$PARAM.LBL_ASSIGNED_TO_NAME}:</strong>
        <a href="index.php?module=Employees&action=DetailView&record={$FIELD.ASSIGNED_USER_ID}">{$FIELD.ASSIGNED_USER_NAME}</a>
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.WEEKDAY) 
    || !empty($FIELD.END_DATE)    
    || !empty($FIELD.START_DATE) 
    || !empty($FIELD.DURATION) 
    || !empty($FIELD.TYPE) 
    || !empty($FIELD.ASSIGNED_USER_ID)}
    <br>
{/if}

{if !empty($FIELD.DATE_ENTERED)}
    <div>
        <strong>{$PARAM.LBL_DATE_ENTERED}:</strong>
        {$FIELD.DATE_ENTERED}
    </div>
{/if}

{if !empty($FIELD.DATE_MODIFIED)}
    <div>
        <strong>{$PARAM.LBL_DATE_MODIFIED}:</strong>
        {$FIELD.DATE_MODIFIED}
    </div>
{/if}
