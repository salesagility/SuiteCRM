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
 */
 *}
{if !empty($FIELD.NAME)}
    <div>
        <a href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}">{$FIELD.NAME}</a>
    </div>
{/if}
<br>
{if !empty($FIELD.STIC_TOTAL_ANNUAL_DONATIONS_C)}
    <div>
        <strong>{$PARAM.LBL_STIC_TOTAL_ANNUAL_DONATIONS}:</strong>
        {$FIELD.STIC_TOTAL_ANNUAL_DONATIONS_C}
    </div>
{/if}
{if !empty($FIELD.STIC_182_ERROR)}
    <div>
        <strong>{$PARAM.LBL_STIC_182_ERROR}:</strong>
        {$FIELD.STIC_182_ERROR}
    </div>
{/if}
{if !empty($FIELD.STIC_182_EXCLUDED)}
    <div>
        <strong>{$PARAM.LBL_STIC_182_EXCLUDED}:</strong>
        {$FIELD.STIC_182_EXCLUDED}
    </div>
{/if}
{if !empty($FIELD.STIC_LANGUAGE_C)}
    <div>
        <strong>{$PARAM.LBL_STIC_LANGUAGE}</strong>
        {$FIELD.STIC_LANGUAGE_C}
    </div>
{/if}
{if !empty($FIELD.BILLING_ADDRESS_STREET) || !empty($FIELD.BILLING_ADDRESS_CITY) || !empty($FIELD.BILLING_ADDRESS_STATE) || !empty($FIELD.BILLING_ADDRESS_POSTALCODE)}
    <div>
        <strong>{$PARAM.LBL_BILLING_ADDRESS}:</strong>
        {$FIELD.BILLING_ADDRESS_STREET}, {$FIELD.BILLING_ADDRESS_CITY}, {$FIELD.BILLING_ADDRESS_STATE}, {$FIELD.BILLING_ADDRESS_POSTALCODE} 
    </div>
{/if}
{if !empty($FIELD.STIC_IDENTIFICATION_NUMBER)}
    <div>
        <strong>{$PARAM.LBL_STIC_IDENTIFICATION_NUMBER}:</strong>
        {$FIELD.STIC_IDENTIFICATION_NUMBER}
    </div>
{/if}
{if !empty($FIELD.WEBSITE) && preg_match('/^https?:\/\/.+$/', $FIELD.WEBSITE)}
    <div>
        <strong>{$PARAM.LBL_WEBSITE}</strong>
        <a target='_blank' href="{$FIELD.WEBSITE}">{$FIELD.WEBSITE}</a>  

    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.WEBSITE) 
    || !empty($FIELD.STIC_IDENTIFICATION_NUMBER) 
    || !empty($FIELD.BILLING_ADDRESS_STREET) 
    || !empty($FIELD.BILLING_ADDRESS_CITY) 
    || !empty($FIELD.BILLING_ADDRESS_STATE) 
    || !empty($FIELD.BILLING_ADDRESS_POSTALCODE)
    || !empty($FIELD.STIC_LANGUAGE_C)
    || !empty($FIELD.STIC_182_EXCLUDED)
    || !empty($FIELD.STIC_182_ERROR) 
    || !empty($FIELD.STIC_TOTAL_ANNUAL_DONATIONS_C)}
    <br>
{/if}
{if !empty($FIELD.DATE_ENTERED)}
    <div>
        <strong>{$PARAM.LBL_DATE_ENTERED}</strong>
        {$FIELD.DATE_ENTERED}
    </div>
{/if}
{if !empty($FIELD.DATE_MODIFIED)}
    <div>
        <strong>{$PARAM.LBL_DATE_MODIFIED}</strong>
        {$FIELD.DATE_MODIFIED}
    </div>
{/if}