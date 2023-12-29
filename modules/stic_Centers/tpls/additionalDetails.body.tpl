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
{if !empty($FIELD.ADDRESS_STREET)}
    <div>
        <strong>{$PARAM.LBL_ADDRESS_STREET}:</strong>
        {$FIELD.ADDRESS_STREET}
    </div>
{/if}
{if !empty($FIELD.ADDRESS_STATE)}
    <div>
        <strong>{$PARAM.LBL_ADDRESS_STATE}:</strong>
        {$FIELD.ADDRESS_STATE}
    </div>
{/if}
{if !empty($FIELD.ADDRESS_POSTALCODE)}
    <div>
        <strong>{$PARAM.LBL_ADDRESS_POSTALCODE}:</strong>
        {$FIELD.ADDRESS_POSTALCODE}
    </div>
{/if}
{if !empty($FIELD.ADDRESS_COUNTRY)}
    <div>
        <strong>{$PARAM.LBL_ADDRESS_COUNTRY}:</strong>
        {$FIELD.ADDRESS_COUNTRY}
    </div>
{/if}
<br>
{if substr($FIELD.URL_LOCATION, 0, 8) !== 'http://'}
    <div>
        <strong>{$PARAM.LBL_URL_LOCATION}:</strong>
        {$FIELD.URL_LOCATION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.ADDRESS_POSTALCODE) 
    || !empty($FIELD.ADDRESS_STATE) 
    || !empty($FIELD.ADDRESS_STREET) 
    || !empty($FIELD.ADDRESS_COUNTRY)
    || !empty($FIELD.URL_LOCATION)}
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
