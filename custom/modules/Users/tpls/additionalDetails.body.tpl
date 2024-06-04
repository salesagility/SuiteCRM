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
        <strong>{$FIELD.NAME}</strong>
    </div>
{/if}
{if !empty($FIELD.LBL_ADDRESS_STREET) || !empty($FIELD.LBL_ADDRESS_CITY) || !empty($FIELD.LBL_ADDRESS_STATE) || !empty($FIELD.ADDRESS_POSTALCODE)}
    <div>
        <strong>{$PARAM.LBL_ADDRESS}</strong>
        {$FIELD.ADDRESS_STREET}, {$FIELD.ADDRESS_CITY}, {$FIELD.ADDRESS_STATE} {$FIELD.ADDRESS_POSTALCODE}
    </div>
{/if}
{if !empty($FIELD.MOBILE_PHONE)}
    <div>
        <strong>{$PARAM.LBL_MOBILE_PHONE}:</strong>
        {$FIELD.MOBILE_PHONE}
    </div>
{/if}
{if !empty($FIELD.ANY_PHONE)}
    <div>
        <strong>{$PARAM.LBL_ANY_PHONE}:</strong>
        {$FIELD.ANY_PHONE}
    </div>
{/if}
{if !empty($FIELD.EMPLOYEE_STATUS)}
    <div>
        <strong>{$PARAM.LBL_EMPLOYEE_STATUS}:</strong>
        {$FIELD.EMPLOYEE_STATUS}
    </div>
{/if}
<div>
    <strong>{$PARAM.LBL_STIC_WORK_CALENDAR}:</strong>
    {$FIELD.STIC_WORK_CALENDAR_C}
</div>
<div>
    <strong>{$PARAM.LBL_STIC_CLOCK}:</strong>
    {$FIELD.STIC_CLOCK_C}
</div>
{if !empty($FIELD.PSW_MODIFIED)}
    <div>
        <strong>{$PARAM.LBL_PSW_MODIFIED}:</strong>
        {$FIELD.PSW_MODIFIED}
    </div>
{/if}

{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DATE_ENTERED) }
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