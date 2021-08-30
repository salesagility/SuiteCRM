<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

namespace Step\Acceptance;

use AcceptanceTester;
use Codeception\Scenario;

/**
 * Class AccountsTester
 * @package Step\Acceptance
 */
class AccountsTester extends AcceptanceTester
{
    /**
     * Create an account
     *
     * @param string $name
     * @return string Account ID
     */
    public function createAccount(string $name): string
    {
        global $db;
        $id = create_guid();
        $accountType = 'Customer';
        $query = "INSERT INTO accounts (id, name, account_type, date_entered) VALUES ('?', '?', '?', '?')";
        $db->pQuery($query, array(
            $id,
            $name,
            $accountType,
            date('Y-m-d H:i:s')
        ));

        return $id;
    }

    /**
     * Creates accounts that can be indexed by elasticsearch
     * @param string $name
     */
    public function createAccountForElasticSearch(string $name): void
    {
        $I = new EditView($this->getScenario());
        $DetailView = new DetailView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());

        $I->waitForText('Create Account', 5, '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);

        $I->seeElement('#assigned_user_name');
        $I->seeElement('#parent_name');
        $I->seeElement('#campaign_name');

        $I->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }

    /**
     * @return Scenario
     */
    public function getPublicScenario(): Scenario
    {
        return $this->getScenario();
    }
}
