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
{if !empty($FIELD.JOURNAL_DATE)}
    <div>
        <strong>{$PARAM.LBL_JOURNAL_DATE}:</strong>
        {$FIELD.JOURNAL_DATE}
    </div>
{/if}
{if !empty($FIELD.TYPE)}
    <div>
        <strong>{$PARAM.LBL_TYPE}:</strong>
        {$FIELD.TYPE}
    </div>
{/if}
{if !empty($FIELD.STIC_JOURNAL_STIC_CENTERSSTIC_CENTERS_IDA)}
    <div>
        <strong>{$PARAM.LBL_STIC_JOURNAL_STIC_CENTERS_FROM_STIC_CENTERS_TITLE}:</strong>
        <a href="index.php?action=DetailView&module=stic_Centers&record={$FIELD.STIC_JOURNAL_STIC_CENTERSSTIC_CENTERS_IDA}">{$FIELD.STIC_JOURNAL_STIC_CENTERS_NAME}</a>
    </div>
{/if}
{if !empty($FIELD.TURN)}
    <div>
        <strong>{$PARAM.LBL_TURN}:</strong>
        {$FIELD.TURN}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if $FIELD.TYPE === $FIELD.TYPE_TASK || $FIELD.TYPE === $FIELD.TYPE_EDUCATIONAL_MEASURE}
    <br>
    {if !empty($FIELD.TASK)}
        <div>
            <strong>{$PARAM.LBL_TASK}:</strong>
            {$FIELD.TASK}
        </div>
    {/if}
    {if !empty($FIELD.TASK_SCOPE)}
        <div>
            <strong>{$PARAM.LBL_TASK_SCOPE}:</strong>
            {$FIELD.TASK_SCOPE}
        </div>
    {/if}
    {if !empty($FIELD.TASK_START_DATE)}
        <div>
            <strong>{$PARAM.LBL_TASK_START_DATE}:</strong>
            {$FIELD.TASK_START_DATE}
        </div>
    {/if}
    {if !empty($FIELD.LBL_TASK_END_DATE)}
        <div>
            <strong>{$PARAM.LBL_TASK_END_DATE}:</strong>
            {$FIELD.TASK_END_DATE}
        </div>
    {/if}
    {if !empty($FIELD.TASK_FULFILLMENT)}
        <div>
            <strong>{$PARAM.LBL_TASK_FULFILLMENT}:</strong>
            {$FIELD.TASK_FULFILLMENT}
        </div>
    {/if}
    {if !empty($FIELD.TASK_DESCRIPTION)}
        <div>
            <strong>{$PARAM.LBL_TASK_DESCRIPTION}:</strong>
            {$FIELD.TASK_DESCRIPTION}
        </div>
    {/if}
{/if}
{if $FIELD.TYPE === $FIELD.TYPE_INFRINGEMENT || $FIELD.TYPE === $FIELD.TYPE_EDUCATIONAL_MEASURE}
    <br>
    {if !empty($FIELD.INFRINGEMENT_SERIOUSNESS)}
        <div>
            <strong>{$PARAM.LBL_INFRINGEMENT_SERIOUSNESS}:</strong>
            {$FIELD.INFRINGEMENT_SERIOUSNESS}
        </div>
    {/if}
    {if !empty($FIELD.INFRINGEMENT_DESCRIPTION)}
        <div>
            <strong>{$PARAM.LBL_INFRINGEMENT_DESCRIPTION}:</strong>
            {$FIELD.INFRINGEMENT_DESCRIPTION}
        </div>
    {/if}
{/if}
<br>
{if !empty($FIELD.DESCRIPTION)}
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
