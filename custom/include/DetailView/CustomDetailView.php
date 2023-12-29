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

/**
 * This file is used in the SinergiaCRM hotfix #150 that allows properly viewing HTML fields without setting DeveloperMode to true.
 * 
 * CustomDisplayView overrides the setup generic function in order to set the CustomTemplateHandler for the view and 
 * be able to access the invalidateParameter from the view.detail.php 
 * 
 */

require_once('include/DetailView/DetailView2.php');

class CustomDetailView extends DetailView2
{

    /**
     * Override setup
     * @see DetailView2::setup()
     */
    public function setup(
        $module, 
        $focus = null, 
        $metadataFile = null, 
        $tpl = 'include/DetailView/DetailView.tpl', 
        $createFocus = true, 
        $metadataFileName = 'detailviewdefs'
        )
    {
        parent::setup($module, $focus, $metadataFile, $tpl);
        require_once 'custom/include/TemplateHandler/CustomTemplateHandler.php';
        $this->th = new CustomTemplateHandler();
        $this->th->ss = $this->ss; // ss is the Sugar Smarty object
    }
}
