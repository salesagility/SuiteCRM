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
{if !empty($FIELD.CONTRACT_DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_CONTRACT_DESCRIPTION}:</strong>
        {$FIELD.CONTRACT_DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.HOURS_PER_WEEK)}
    <div>
        <strong>{$PARAM.LBL_HOURS_PER_WEEK}:</strong>
        {$FIELD.HOURS_PER_WEEK}
    </div>
{/if}
{if !empty($FIELD.RETRIBUTION)}
    <div>
        <strong>{$PARAM.LBL_RETRIBUTION}:</strong>
        {$FIELD.RETRIBUTION}
    </div>
{/if}
{if !empty($FIELD.PROCESS_START_DATE)}
    <div>
        <strong>{$PARAM.LBL_PROCESS_START_DATE}:</strong>
        {$FIELD.PROCESS_START_DATE}
    </div>
{/if}
{if !empty($FIELD.OFFERED_POSITIONS)}
    <div>
        <strong>{$PARAM.LBL_OFFERED_POSITIONS}:</strong>
        {$FIELD.OFFERED_POSITIONS}
    </div>
{/if}
{if !empty($FIELD.POSITION_TYPE)}
    <div>
        <strong>{$PARAM.LBL_POSITION_TYPE}:</strong>
        {$FIELD.POSITION_TYPE}
    </div>
{/if}
{if !empty($FIELD.CONTRACT_TYPE)}
    <div>
        <strong>{$PARAM.LBL_CONTRACT_TYPE}:</strong>
        {$FIELD.CONTRACT_TYPE}
    </div>
{/if}
{if !empty($FIELD.WORKDAY_TYPE)}
    <div>
        <strong>{$PARAM.LBL_WORKDAY_TYPE}:</strong>
        {$FIELD.WORKDAY_TYPE}
    </div>
{/if}
{if !empty($FIELD.SECTOR)}
    <div>
        <strong>{$PARAM.LBL_SECTOR}:</strong>
        {$FIELD.SECTOR}
    </div>
{/if}
{if !empty($FIELD.SUBSECTOR)}
    <div>
        <strong>{$PARAM.LBL_SUBSECTOR}:</strong>
        {$FIELD.SUBSECTOR}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.OFFERED_POSITIONS) 
    || !empty($FIELD.PROCESS_START_DATE) 
    || !empty($FIELD.RETRIBUTION) 
    || !empty($FIELD.HOURS_PER_WEEK)
    || !empty($FIELD.POSITION_TYPE) 
    || !empty($FIELD.CONTRACT_TYPE) 
    || !empty($FIELD.WORKDAY_TYPE)
    || !empty($FIELD.SECTOR) 
    || !empty($FIELD.SUBSECTOR)
    || !empty($FIELD.CONTRACT_DESCRIPTION)}
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
