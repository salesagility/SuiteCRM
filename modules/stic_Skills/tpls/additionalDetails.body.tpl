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
{if !empty($FIELD.LANGUAGE)}
    <div>
        <strong>{$PARAM.LBL_LANGUAGE}:</strong>
        {$FIELD.LANGUAGE}
    </div>
{/if}
{if !empty($FIELD.OTHER)}
    <div>
        <strong>{$PARAM.LBL_OTHER}:</strong>
        {$FIELD.OTHER}
    </div>
{/if}
{if !empty($FIELD.WRITTEN)}
    <div>
        <strong>{$PARAM.LBL_WRITTEN}:</strong>
        {$FIELD.WRITTEN}
    </div>
{/if}
{if !empty($FIELD.ORAL)}
<div>
    <strong>{$PARAM.LBL_ORAL}:</strong>
    {$FIELD.ORAL}
</div>
{/if}
{if !empty($FIELD.CERTIFICATE)}
<div>
    <strong>{$PARAM.LBL_CERTIFICATE}:</strong>
    {$FIELD.CERTIFICATE}
</div>
{/if}
{if !empty($FIELD.CERTIFICATE_DATE)}
<div>
    <strong>{$PARAM.LBL_CERTIFICATE_DATE}:</strong>
    {$FIELD.CERTIFICATE_DATE}
</div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}:</strong>
        {$FIELD.DESCRIPTION}
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION) 
    || !empty($FIELD.LANGUAGE) 
    || !empty($FIELD.OTHER) 
    || !empty($FIELD.WRITTEN) 
    || !empty($FIELD.ORAL)
    || !empty($FIELD.CERTIFICATE)
    || !empty($FIELD.CERTIFICATE_DATE)}
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