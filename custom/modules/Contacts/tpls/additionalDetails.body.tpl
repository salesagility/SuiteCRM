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
{if !empty($FIELD.STIC_AGE_C)}
    <div>
        <strong>{$PARAM.LBL_STIC_AGE}:</strong>
        {$FIELD.STIC_AGE_C}
    </div>
{/if}
{if !empty($FIELD.BIRTHDATE)}
    <div>
        <strong>{$PARAM.LBL_BIRTHDATE}</strong>
        {$FIELD.BIRTHDATE}
    </div>
{/if}
{if !empty($FIELD.STIC_IDENTIFICATION_NUMBER_C)}
    <div>
        <strong>{$FIELD.STIC_IDENTIFICATION_TYPE_C}:</strong>
        {$FIELD.STIC_IDENTIFICATION_NUMBER_C}
    </div>
{/if}
{if !empty($FIELD.PHONE_MOBILE)}
    <div>
        <strong>{$PARAM.LBL_MOBILE_PHONE}</strong>
        {$FIELD.PHONE_MOBILE}
    </div>
{/if}
{if !empty($FIELD.PRIMARY_ADDRESS_STREET) || !empty($FIELD.PRIMARY_ADDRESS_CITY) || !empty($FIELD.PRIMARY_ADDRESS_STATE) || !empty($FIELD.PRIMARY_ADDRESS_POSTALCODE)}
    <div>
        <strong>{$PARAM.LBL_PRIMARY_ADDRESS}</strong>
        {$FIELD.PRIMARY_ADDRESS_STREET}, {$FIELD.PRIMARY_ADDRESS_CITY}, {$FIELD.PRIMARY_ADDRESS_STATE}, {$FIELD.PRIMARY_ADDRESS_POSTALCODE} 
    </div>
{/if}
{if !empty($FIELD.STIC_LANGUAGE_C)}
    <div>
        <strong>{$PARAM.LBL_STIC_LANGUAGE}:</strong>
        {$FIELD.STIC_LANGUAGE_C}
    </div>
{/if}
{if !empty($FIELD.ACCOUNT_NAME)}
    <div>
        <strong>{$PARAM.LBL_ACCOUNT_NAME}</strong>
        <a href="index.php?module=Accounts&action=DetailView&record={$FIELD.ACCOUNT_ID}">{$FIELD.ACCOUNT_NAME}</a>
    </div>
{/if}
{if ($FIELD.STIC_182_EXCLUDED_C)==1}
    <div>
        <strong>{$PARAM.LBL_STIC_182_EXCLUDED}</strong>
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.STIC_182_EXCLUDED_C) 
    || !empty($FIELD.ACCOUNT_NAME) 
    || !empty($FIELD.STIC_LANGUAGE_C) 
    || !empty($FIELD.PRIMARY_ADDRESS_STREET) 
    || !empty($FIELD.PRIMARY_ADDRESS_CITY) 
    || !empty($FIELD.PRIMARY_ADDRESS_STATE) 
    || !empty($FIELD.PRIMARY_ADDRESS_POSTALCODE)
    || !empty($FIELD.PHONE_MOBILE)
    || !empty($FIELD.STIC_IDENTIFICATION_NUMBER_C) 
    || !empty($FIELD.STIC_AGE_C) 
    || !empty($FIELD.BIRTHDATE)}
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
        <strong>{$PARAM.LBL_DATE_MODIFIED}</strong>
        {$FIELD.DATE_MODIFIED}
    </div>
{/if}
