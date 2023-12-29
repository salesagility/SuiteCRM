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
 * CustomTemplateHandler overrides the checkTemplate generic function in order to invalidate the cache of a certain View.
 * When the cache is invalidated the view will be rebuilt on every access so HTML fields will display their right values.
 * 
 */

require_once('include/TemplateHandler/TemplateHandler.php');

class CustomTemplateHandler extends TemplateHandler
{
    public $disableCheckTemplate = false;

    /**
     * Override checkTemplate
     * @see TemplateHandler::checkTemplate()
     */
    function checkTemplate($module, $view, $checkFormName = false, $formName = '')
    {
        if ($this->disableCheckTemplate === true){
            return false;
        }
        
        return parent::checkTemplate($module, $view, $checkFormName, $formName);
    }
}
