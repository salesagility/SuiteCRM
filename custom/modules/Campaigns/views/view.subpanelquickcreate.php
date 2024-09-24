<?php
/**
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
 */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/EditView/SubpanelQuickCreate.php';

class CustomCampaignsSubpanelQuickCreate extends SubpanelQuickCreate
{
    public function __construct($module, $view = 'QuickCreate', $proccessOverride = false)
    {
        parent::__construct($module, $view, $proccessOverride);
    }

    public function process($module)
    {
        // Remove 'SUBPANELFULLFORM' button
        if (($key = array_search('SUBPANELFULLFORM', $this->ev->defs['templateMeta']['form']['buttons'])) !== false) {
            unset($this->ev->defs['templateMeta']['form']['buttons'][$key]);
        }

        include_once "custom/modules/Campaigns/SticUtils.php";
        CampaignsUtils::fillDynamicListsForNotifications();

        parent::process($module);

        // Link basic stic css and JS files
        echo getVersionedScript("SticInclude/js/Utils.js");
        echo getVersionedScript("custom/modules/Campaigns/SticUtils.js");

        echo CampaignsUtils::getCampaignsLangStrings();
        echo CampaignsUtils::getNotificationCampaignEmailDataScript();
    }
}
