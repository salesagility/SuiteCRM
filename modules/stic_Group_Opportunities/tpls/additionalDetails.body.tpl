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
<br />
{if !empty($FIELD.STIC_GROUP_OPPORTUNITIES_ACCOUNTSACCOUNTS_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_GROUP_OPPORTUNITIES_ACCOUNTS_NAME}:</strong>
        <a href="index.php?module=Accounts&action=DetailView&record={$FIELD.STIC_GROUP_OPPORTUNITIES_ACCOUNTSACCOUNTS_IDA}">{$FIELD.STIC_GROUP_OPPORTUNITIES_ACCOUNTS_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_GROUP_OPPORTUNITIES_OPPORTUNITIESOPPORTUNITIES_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_NAME}:</strong>
        <a href="index.php?module=Opportunities&action=DetailView&record={$FIELD.STIC_GROUP_OPPORTUNITIES_OPPORTUNITIESOPPORTUNITIES_IDA}">{$FIELD.STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STATUS)}
    <div>
        <strong>{$PARAM.LBL_STATUS}:</strong>
        {$FIELD.STATUS}
    </div>
{/if}
{if !empty($FIELD.DOCUMENT_STATUS)}
    <div>
        <strong>{$PARAM.LBL_DOCUMENT_STATUS}:</strong>
        {$FIELD.DOCUMENT_STATUS}
    </div>
{/if}
{if !empty($FIELD.FOLDER)}
    <div>
        <strong>{$PARAM.LBL_FOLDER}:</strong>
        <a href="{$FIELD.FOLDER}" target="_blank">{$FIELD.FOLDER}</a>
    </div>
{/if}
{if !empty($FIELD.CONTACT_ID)}
    <div>
        <strong>{$PARAM.LBL_CONTACT}:</strong>
        <a href="index.php?module=Contacts&action=DetailView&record={$FIELD.CONTACT_ID}">{$FIELD.CONTACT}</a>
    </div>
{/if}
<br />

{if !empty($FIELD.AMOUNT_REQUESTED)}
    <div>
        <strong>{$PARAM.LBL_AMOUNT_REQUESTED}:</strong>
        {$FIELD.AMOUNT_REQUESTED}
    </div>
{/if}
{if !empty($FIELD.AMOUNT_AWARDED)}
    <div>
        <strong>{$PARAM.LBL_AMOUNT_AWARDED}:</strong>
        {$FIELD.AMOUNT_AWARDED}
    </div>
{/if}
{if !empty($FIELD.AMOUNT_RECEIVED)}
    <div>
        <strong>{$PARAM.LBL_AMOUNT_RECEIVED}:</strong>
        {$FIELD.AMOUNT_RECEIVED}
    </div>
{/if}
{if !empty($FIELD.START_DATE)}
    <div>
        <strong>{$PARAM.LBL_START_DATE}:</strong>
        {$FIELD.START_DATE}
    </div>
{/if}
{if !empty($FIELD.VALIDATION_DATE)}
    <div>
        <strong>{$PARAM.LBL_VALIDATION_DATE}:</strong>
        {$FIELD.VALIDATION_DATE}
    </div>
{/if}
{if !empty($FIELD.PRESENTATION_DATE)}
    <div>
        <strong>{$PARAM.LBL_PRESENTATION_DATE}:</strong>
        {$FIELD.PRESENTATION_DATE}
    </div>
{/if}
{if !empty($FIELD.RESOLUTION_DATE)}
    <div>
        <strong>{$PARAM.LBL_RESOLUTION_DATE}:</strong>
        {$FIELD.RESOLUTION_DATE}
    </div>
{/if}
{if !empty($FIELD.ADVANCE_DATE)}
    <div>
        <strong>{$PARAM.LBL_ADVANCE_DATE}:</strong>
        {$FIELD.ADVANCE_DATE}
    </div>
{/if}
{if !empty($FIELD.JUSTIFICATION_DATE)}
    <div>
        <strong>{$PARAM.LBL_JUSTIFICATION_DATE}:</strong>
        {$FIELD.JUSTIFICATION_DATE}
    </div>
{/if}
{if !empty($FIELD.PAYMENT_DATE)}
    <div>
        <strong>{$PARAM.LBL_PAYMENT_DATE}:</strong>
        {$FIELD.PAYMENT_DATE}
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.PAYMENT_DATE) 
    || !empty($FIELD.JUSTIFICATION_DATE) 
    || !empty($FIELD.ADVANCE_DATE) 
    || !empty($FIELD.RESOLUTION_DATE)
    || !empty($FIELD.PRESENTATION_DATE)
    || !empty($FIELD.VALIDATION_DATE)
    || !empty($FIELD.START_DATE)
    || !empty($FIELD.AMOUNT_RECEIVED)
    || !empty($FIELD.AMOUNT_AWARDED)
    || !empty($FIELD.AMOUNT_REQUESTED)}
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
