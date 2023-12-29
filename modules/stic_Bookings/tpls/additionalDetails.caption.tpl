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
{* This template is showed both in Bookings' ListView and Bookings Calendar reservations popups *}

<div id="qtip-6-title" class="qtip-title" aria-atomic="true">
    <div class="qtip-title-text">
       {$APP.LBL_ADDITIONAL_DETAILS}
    </div>
    {if $PARAM.show_buttons != "false"}
    <div class="qtip-title-buttons">
        {if $ACL_EDIT_VIEW == true}<a href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}" class="btn btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>{/if}
        {if $ACL_DETAIL_VIEW == true}<a href="index.php?action=EditView&module={$MODULE_NAME}&record={$FIELD.ID}" class="btn btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>{/if}
    </div>
    {/if}
</div>