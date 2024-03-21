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
    <div>
        <strong>{$PARAM.LBL_START_DATE}:</strong>
        {$FIELD.START_DATE}
    </div>
{/if}
{if !empty($FIELD.END_DATE)}
    <div>
        <strong>{$PARAM.LBL_END_DATE}:</strong>
        {$FIELD.END_DATE}
    </div>
{/if}

{if !empty($FIELD.SCOPE)}
    <div>
        <strong>{$PARAM.LBL_SCOPE}:</strong>
        {$FIELD.SCOPE}
    </div>
{/if}
{if !empty($FIELD.PREVIOUS)}
    <div>
        <strong>{$PARAM.LBL_PREVIOUS}:</strong>
        {$FIELD.PREVIOUS}
    </div>
{/if}
{if !empty($FIELD.FORMAL)}
    <div>
        <strong>{$PARAM.LBL_FORMAL}:</strong>
        {$FIELD.FORMAL}
    </div>
{/if}
{if !empty($FIELD.ACCREDITED)}
    <div>
        <strong>{$PARAM.LBL_ACCREDITED}:</strong>
        {$FIELD.ACCREDITED}
    </div>
{/if}
{if !empty($FIELD.QUALIFICATION)}
    <div>
        <strong>{$PARAM.LBL_QUALIFICATION}:</strong>
        {$FIELD.QUALIFICATION}
    </div>
{/if}
{if !empty($FIELD.CERTIFICATION)}
    <div>
        <strong>{$PARAM.LBL_CERTIFICATION}:</strong>
        {$FIELD.CERTIFICATION}
    </div>
{/if}
{if !empty($FIELD.GRANT_TRAINING)}
    <div>
        <strong>{$PARAM.LBL_GRANT_TRAINING}:</strong>
        {$FIELD.GRANT_TRAINING}
    </div>
{/if}
{if !empty($FIELD.GRANT_AMOUNT)}
    <div>
        <strong>{$PARAM.LBL_GRANT_AMOUNT}:</strong>
        {$FIELD.GRANT_AMOUNT}
    </div>
{/if}
{if !empty($FIELD.AMOUNT)}
    <div>
        <strong>{$PARAM.LBL_AMOUNT}:</strong>
        {$FIELD.AMOUNT}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.START_DATE) 
    || !empty($FIELD.END_DATE) 
    || !empty($FIELD.SCOPE) 
    || !empty($FIELD.PREVIOUS) 
    || !empty($FIELD.FORMAL) 
    || !empty($FIELD.ACCREDITED) 
    || !empty($FIELD.QUALIFICATION)
    || !empty($FIELD.CERTIFICATION)
    || !empty($FIELD.GRANT_TRAINING)
    || !empty($FIELD.AMOUNT)
    || !empty($FIELD.GRANT_AMOUNT)}
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