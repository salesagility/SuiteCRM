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
{if !empty($FIELD.STIC_GRANTS_CONTACTSCONTACTS_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_GRANTS_CONTACTS_FROM_CONTACTS_TITLE}:</strong>
        <a href="index.php?module=Contact&action=DetailView&record={$FIELD.STIC_GRANTS_CONTACTSCONTACTS_IDA}">{$FIELD.STIC_GRANTS_CONTACTS_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_GRANTS_ACCOUNTSACCOUNTS_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_GRANTS_ACCOUNTS_FROM_ACCOUNTS_TITLE}:</strong>
        <a href="index.php?module=Account&action=DetailView&record={$FIELD.STIC_GRANTS_ACCOUNTSACCOUNTS_IDA}">{$FIELD.STIC_GRANTS_ACCOUNTS_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_GRANTS_PROJECTPROJECT_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_GRANTS_PROJECT_FROM_PROJECT_TITLE}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.STIC_GRANTS_PROJECTPROJECT_IDA}">{$FIELD.STIC_GRANTS_PROJECT_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_GRANTS_STIC_FAMILIESSTIC_FAMILIES_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_GRANTS_STIC_FAMILIES_FROM_STIC_FAMILIES_TITLE}:</strong>
        <a href="index.php?module=stic_Families&action=DetailView&record={$FIELD.STIC_GRANTS_STIC_FAMILIESSTIC_FAMMILIES_IDA}">{$FIELD.STIC_GRANTS_STIC_FAMILIES_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_GRANTS_OPPORTUNITIESOPPORTUNITIES_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_GRANTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE}:</strong>
        <a href="index.php?module=Opportunity&action=DetailView&record={$FIELD.STIC_GRANTS_OPPORTUNITIESOPPORTUNITIES_IDA}">{$FIELD.STIC_GRANTS_OPPORTUNITIES_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.RETURNED_AMOUNT)}
    <div>
        <strong>{$PARAM.LBL_RETURNED_AMOUNT}:</strong>
        {$FIELD.RETURNED_AMOUNT}
    </div>
{/if}
{if !empty($FIELD.PERIODICITY)}
    <div>
        <strong>{$PARAM.LBL_PERIODICITY}:</strong>
        {$FIELD.PERIODICITY}
    </div>
{/if}

{if !empty($FIELD.RENOVATION_DATE)}
    <div data-field="RENOVATION_DATE" data-date="{$FIELD.DB_RENOVATION_DATE}">
        <strong>{$PARAM.LBL_RENOVATION_DATE}:</strong>
        {$FIELD.RENOVATION_DATE}
    </div>
{/if}
{if !empty($FIELD.EXPECTED_END_DATE)}
    <div data-field="EXPECTED_END_DATE" data-date="{$FIELD.DB_EXPECTED_END_DATE}">
        <strong>{$PARAM.LBL_EXPECTED_END_DATE}:</strong>
        {$FIELD.EXPECTED_END_DATE}
    </div>
{/if}
{if !empty($FIELD.END_DATE)}
    <div data-field="END_DATE" data-date="{$FIELD.DB_END_DATE}">
        <strong>{$PARAM.LBL_END_DATE}:</strong>
        {$FIELD.END_DATE}
    </div>
{/if}


{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.STIC_GRANTS_CONTACTSCONTACTS_IDA) 
    || !empty($FIELD.STIC_GRANTS_ACCOUNTSACCOUNTS_IDA) 
    || !empty($FIELD.STIC_GRANTS_PROJECTPROJECT_IDA)
    || !empty($FIELD.STIC_GRANTS_STIC_FAMILIESSTIC_FAMILIES_IDA) 
    || !empty($FIELD.STIC_GRANTS_OPPORTUNITIESOPPORTUNITIES_IDA) 
    || !empty($FIELD.RETURNED_AMOUNT)
    || !empty($FIELD.PERIODICITY) 
    || !empty($FIELD.RENOVATION_DATE) 
    || !empty($FIELD.EXPECTED_END_DATE)
    || !empty($FIELD.END_DATE)}
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