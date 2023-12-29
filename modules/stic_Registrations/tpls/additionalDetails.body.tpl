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
{if !empty($FIELD.PARTICIPATION_TYPE)}
    <div>
        <strong>{$PARAM.LBL_PARTICIPATION_TYPE}:</strong>
        {$FIELD.PARTICIPATION_TYPE}
    </div>
{/if}
{if !empty($FIELD.ATTENDEES)}
    <div>
        <strong>{$PARAM.LBL_ATTENDEES}:</strong>
        {$FIELD.ATTENDEES}
    </div>
{/if}
{if !empty($FIELD.NOT_PARTICIPATING_REASON)}
    <div>
        <strong>{$PARAM.LBL_NOT_PARTICIPATING_REASON}:</strong>
        {$FIELD.NOT_PARTICIPATING_REASON}
    </div>
{/if}
{if !empty($FIELD.REJECTION_REASON)}
    <div>
        <strong>{$PARAM.LBL_REJECTION_REASON}:</strong>
        {$FIELD.REJECTION_REASON}
    </div>
{/if}
{if !empty($FIELD.SPECIAL_NEEDS)}
    <div>
        <strong>{$PARAM.LBL_SPECIAL_NEEDS}:</strong>
        {$FIELD.SPECIAL_NEEDS}
    </div>
{/if}
{if !empty($FIELD.SPECIAL_NEEDS_DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_SPECIAL_NEEDS_DESCRIPTION}:</strong>
        {$FIELD.SPECIAL_NEEDS_DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.SESSION_AMOUNT)}
    <div>
        <strong>{$PARAM.LBL_SESSION_AMOUNT}:</strong>
        {sugar_number_format var=$FIELD.SESSION_AMOUNT stringFormat=false}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.SESSION_AMOUNT) 
    || !empty($FIELD.SPECIAL_NEEDS_DESCRIPTION) 
    || !empty($FIELD.SPECIAL_NEEDS) 
    || !empty($FIELD.REJECTION_REASON)
    || !empty($FIELD.NOT_PARTICIPATING_REASON)
    || !empty($FIELD.PARTICIPATION_TYPE) 
    || !empty($FIELD.ATTENDEES)}
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