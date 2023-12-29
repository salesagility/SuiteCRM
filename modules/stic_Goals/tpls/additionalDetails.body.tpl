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
{if !empty($FIELD.AREA)}
    <div>
        <strong>{$PARAM.LBL_AREA}:</strong>
         {$FIELD.AREA}
    </div>
{/if}
{if !empty($FIELD.SUBAREA)}
    <div>
        <strong>{$PARAM.LBL_SUBAREA}:</strong>
        {$FIELD.SUBAREA}
    </div>
{/if}
{if !empty($FIELD.LEVEL)}
        <strong>{$PARAM.LBL_LEVEL}:</strong>
        {$FIELD.LEVEL}
    </div>
{/if}

{if !empty($FIELD.STIC_GOALS_PROJECT_NAME)}
    <div>
        <strong>{$PARAM.LBL_STIC_GOALS_PROJECT_FROM_PROJECT_TITLE}:</strong>
        <a href="index.php?module=Project&action=DetailView&record={$FIELD.STIC_GOALS_PROJECTPROJECT_IDA}">{$FIELD.STIC_GOALS_PROJECT_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_GOALS_STIC_REGISTRATIONS_NAME)}
    <div>
        <strong>{$PARAM.LBL_STIC_GOALS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE}:</strong>
        <a href="index.php?module=stic_Registrations&action=DetailView&record={$FIELD.STIC_GOALS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA}">{$FIELD.STIC_GOALS_STIC_REGISTRATIONS_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.STIC_GOALS_STIC_ASSESSMENTS_NAME)}
    <div>
        <strong>{$PARAM.LBL_STIC_GOALS_STIC_ASSESSMENTS_FROM_STIC_ASSESSMENTS_TITLE}:</strong>
        <a href="index.php?module=stic_Assessments&action=DetailView&record={$FIELD.STIC_GOALS_STIC_ASSESSMENTSSTIC_ASSESSMENTS_IDA}">{$FIELD.STIC_GOALS_STIC_ASSESSMENTS_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.FOLLOW_UP)}
    <div>
        <strong>{$PARAM.LBL_FOLLOW_UP}:</strong>
        {$FIELD.FOLLOW_UP}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.FOLLOW_UP) 
    || !empty($FIELD.STIC_GOALS_STIC_ASSESSMENTS_NAME) 
    || !empty($FIELD.STIC_GOALS_PROJECT_NAME)
    || !empty($FIELD.LEVEL) 
    || !empty($FIELD.SUBAREA) 
    || !empty($FIELD.AREA)}
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