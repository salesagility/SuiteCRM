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
{* This template is showed both in Resources' ListView and Bookings Calendar availability popups *}

{if !empty($FIELD.NAME)}
    <div>
        <a href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}">{$FIELD.NAME}</a>
    </div>
{/if}
{if !empty($FIELD.CONTACT_ID_C)}
    <div>
        <strong>{$PARAM.LBL_OWNER_CONTACT}: </strong>
        <a href="index.php?module=Contacts&action=DetailView&record={$FIELD.CONTACT_ID_C}">{$FIELD.OWNER_CONTACT}</a>
    </div>
{/if}
{if !empty($FIELD.ACCOUNT_ID_C)}
    <div>
        <strong>{$PARAM.LBL_OWNER_ACCOUNT}: </strong>
        <a href="index.php?module=Accounts&action=DetailView&record={$FIELD.ACCOUNT_ID_C}">{$FIELD.OWNER_ACCOUNT}</a>
    </div>
{/if}
{if !empty($FIELD.DESCRIPTION)}
    <div>
        <strong>{$PARAM.LBL_DESCRIPTION}: </strong>
        {$FIELD.DESCRIPTION}
    </div>
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
