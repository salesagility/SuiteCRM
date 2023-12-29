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

require_once 'modules/Contacts/controller.php';
class CustomContactsController extends ContactsController
{
    /**
     * This action is triggered when a record is created, added or unlinked from a subpanel.
     * If so, we will run the function updateFieldOnSubpanelChange to update the value of certain fields. 
     */ 
    public function action_SubPanelViewer()
    {
        require_once 'SticInclude/Utils.php';
        $fieldsToUpdate = array(
            'stic_relationship_type_c' => array (
                'type' => 'multienum',
                'list' => 'stic_contacts_relationships_types_list',
            ),
        );
        SticUtils::updateFieldOnSubpanelChange('Contacts', 'stic_contacts_relationships_contacts', $fieldsToUpdate);
    }

    /**
     * Allow call the function directly ContactsUtils::calculateContactsAge using a url like
     * <server_url>/index.php?module=Contacts&action=calculateContactsAge
     *
     * @return void
     */
    public function action_calculateContactsAge() {
        require_once 'custom/modules/Contacts/SticUtils.php';
        ContactsUtils::calculateContactsAge();
        SugarApplication::redirect('index.php?module=Contacts&action=index');

    }
}
