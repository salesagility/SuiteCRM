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
{if !empty($FIELD.TRANSACTION_CODE)}
    <div>
        <strong>{$PARAM.LBL_TRANSACTION_CODE}:</strong>
        {$FIELD.TRANSACTION_CODE}
    </div>
{/if}
{if !empty($FIELD.BANKING_CONCEPT)}
    <div>
        <strong>{$PARAM.LBL_BANKING_CONCEPT}:</strong>
        {$FIELD.BANKING_CONCEPT}
    </div>
{/if}
{if !empty($FIELD.BANK_ACCOUNT)}
    <div>
        <strong>{$PARAM.LBL_BANK_ACCOUNT}:</strong>
        {$FIELD.BANK_ACCOUNT}
    </div>
{/if}

{if !empty($FIELD.M182_EXCLUDED)}
    <div>
        <strong>{$PARAM.LBL_M182_EXCLUDED}:</strong>
        {$FIELD.M182_EXCLUDED}
    </div>
{/if}
{if !empty($FIELD.REJECTION_DATE)}
<div>
    <strong>{$PARAM.LBL_REJECTION_DATE}:</strong>
    {$FIELD.REJECTION_DATE}
</div>
{/if}
{if !empty($FIELD.PAYMENT_METHOD)}
<div>
    <strong>{$PARAM.LBL_PAYMENT_METHOD}:</strong>
    {$FIELD.PAYMENT_METHOD}
</div>
{/if}
{if !empty($FIELD.SEPA_REJECTED_REASON)}
<div>
    <strong>{$PARAM.LBL_SEPA_REJECTED_REASON}:</strong>
    {$FIELD.SEPA_REJECTED_REASON}
</div>
{/if}
{if !empty($FIELD.GATEWAY_REJECTION_REASON)}
<div>
    <strong>{$PARAM.LBL_GATEWAY_REJECTION_REASON}:</strong>
    {$FIELD.GATEWAY_REJECTION_REASON}
</div>
{/if}
{if !empty($FIELD.AGGREGATED_SERVICES_COMPLETE)}
<div>
    <strong>{$PARAM.LBL_AGGREGATED_SERVICES_COMPLETE}:</strong>
    {$FIELD.AGGREGATED_SERVICES_COMPLETE}
</div>
{/if}
{if !empty($FIELD.SEGMENTATION)}
<div>
    <strong>{$PARAM.LBL_SEGMENTATION}:</strong>
    {$FIELD.SEGMENTATION}
</div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.SEGMENTATION) 
    || !empty($FIELD.AGGREGATED_SERVICES_COMPLETE) 
    || !empty($FIELD.GATEWAY_REJECTION_REASON) 
    || !empty($FIELD.SEPA_REJECTED_REASON)
    || !empty($FIELD.PAYMENT_METHOD)
    || !empty($FIELD.REJECTION_DATE)
    || !empty($FIELD.M182_EXCLUDED)
    || !empty($FIELD.BANK_ACCOUNT)
    || !empty($FIELD.BANKING_CONCEPT)
    || !empty($FIELD.TRANSACTION_CODE)}
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