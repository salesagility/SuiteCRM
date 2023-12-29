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
{if !empty($FIELD.CONTACT_ID_C)}
    <div>
        <strong>{$PARAM.LBL_EXTERNAL_CONTACT}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.CONTACT_ID_C}">{$FIELD.EXTERNAL_CONTACT}</a>
    </div>
{/if}
{if !empty($FIELD.TYPE)}
    <div data-field="TYPE" data-date="{$FIELD.DB_TYPE}">
        <strong>{$PARAM.LBL_TYPE}:</strong>
        {$FIELD.TYPE}
    </div>
{/if}

{if !empty($FIELD.SUBTYPE)}
    <div data-field="SUBTYPE" data-date="{$FIELD.DB_SUBTYPE}">
        <strong>{$PARAM.LBL_SUBTYPE}:</strong>
        {$FIELD.SUBTYPE}
    </div>
{/if}

{if !empty($FIELD.STATUS)}
    <div data-field="STATUS" data-date="{$FIELD.DB_STATUS}">
        <strong>{$PARAM.LBL_STATUS}:</strong>
        {$FIELD.STATUS}
    </div>
{/if}

{if !empty($FIELD.START_DATE)}
    <div data-field="START_DATE" data-date="{$FIELD.DB_START_DATE}">
        <strong>{$PARAM.LBL_START_DATE}:</strong>
        {$FIELD.START_DATE}
    </div>
{/if}

{if !empty($FIELD.DURATION)}
    <div data-field="DURATION" data-date="{$FIELD.DB_DURATION}">
        <strong>{$PARAM.LBL_DURATION}:</strong>
        {$FIELD.DURATION}
    </div>
{/if}
{if !empty($FIELD.ASSIGNED_USER_ID)}
    <div>
        <strong>{$PARAM.LBL_ASSIGNED_TO}:</strong>
        <a
            href="index.php?module=Employees&action=DetailView&record={$FIELD.ASSIGNED_USER_ID}">{$FIELD.ASSIGNED_USER_NAME}</a>
    </div>
{/if}

{if !empty($FIELD.PENDING_ACTIONS)}
    <div>
        <strong>{$PARAM.LBL_PENDING_ACTIONS}:</strong>
        {$FIELD.PENDING_ACTIONS}
    </div>
{/if}
{if !empty($FIELD.CHANNEL)}
    <div>
        <strong>{$PARAM.LBL_CHANNEL}:</strong>
        {$FIELD.CHANNEL}
    </div>
{/if}
{if !empty($FIELD.STIC_FOLLOWUPS_ID1_C)}
    <div>
        <strong>{$PARAM.LBL_FOLLOWUP_ORIGIN}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.STIC_FOLLOWUPS_ID1_C}">{$FIELD.FOLLOWUP_ORIGIN}</a>
    </div>
{/if}
{if !empty($FIELD.ACCOUNT_ID_C)}
    <div>
        <strong>{$PARAM.LBL_EXTERNAL_ACCOUNT}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.ACCOUNT_ID_C}">{$FIELD.EXTERNAL_ACCOUNT}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_FOLLOWUPS_PROJECTPROJECT_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_FOLLOWUPS_PROJECT_FROM_PROJECT_TITLE}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.STIC_FOLLOWUPS_PROJECTPROJECT_IDA}">{$FIELD.STIC_FOLLOWUPS_PROJECT_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_FOLLOWUPS_STIC_REGISTRATIONS_NAME)}
    <div>
        <strong>{$PARAM.LBL_STIC_FOLLOWUPS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.STIC_FOLLOWUPS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA}">{$FIELD.STIC_FOLLOWUPS_STIC_REGISTRATIONS_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_GOALS_STIC_FOLLOWUPS_NAME)}
    <div>
        <strong>{$PARAM.LBL_STIC_GOALS_STIC_FOLLOWUPS_FROM_STIC_GOALS_TITLE}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.STIC_GOALS_STIC_FOLLOWUPSSTIC_GOALS_IDA}">{$FIELD.STIC_GOALS_STIC_FOLLOWUPS_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.STIC_GOALS_STIC_FOLLOWUPS_NAME) 
    || !empty($FIELD.STIC_FOLLOWUPS_STIC_REGISTRATIONS_NAME) 
    || !empty($FIELD.STIC_FOLLOWUPS_PROJECTPROJECT_IDA) 
    || !empty($FIELD.ACCOUNT_ID_C)
    || !empty($FIELD.CONTACT_ID_C)
    || !empty($FIELD.STIC_FOLLOWUPS_ID1_C)
    || !empty($FIELD.CHANNEL)
    || !empty($FIELD.PENDING_ACTIONS)
    || !empty($FIELD.TYPE)
    || !empty($FIELD.SUBTYPE)
    || !empty($FIELD.STATUS)
    || !empty($FIELD.START_DATE)
    || !empty($FIELD.DURATION)}
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


