<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
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
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}



use Helper\WebDriverHelper;
use Step\Acceptance\Administration;
use Step\Acceptance\ListView;

/**
 * SharedSecurityGroupsCest
 *
 * @author gyula
 */
class SharedSecurityGroupsCest
{
    const WAITING_DELAY = 5;
    
    // ---- common parts of all jobs
    
    protected function clearSearch(AcceptanceTester $I)
    {
        // delete the search settings, if other test DID NOT DOING THIS???!!!
        if (!version_compare(PHP_VERSION, '7.2', '>=') && !version_compare(PHP_VERSION, '7.0', '>=')) {
            $I->waitForElementVisible('#MassUpdate a.glyphicon.glyphicon-remove', self::WAITING_DELAY);
            $I->click('#MassUpdate a.glyphicon.glyphicon-remove');
            return true;
        }
        return false;
    }
    
    protected function goToAccountsPage(AcceptanceTester $I)
    {
        $allMenuButton = '#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav.all';
        $I->waitForElementVisible($allMenuButton, self::WAITING_DELAY);
        $I->click('All', $allMenuButton);
        $allMenu = $allMenuButton . ' > span.notCurrentTab > ul.dropdown-menu';
        $I->waitForElementVisible($allMenu, self::WAITING_DELAY);
        $I->click('Accounts', $allMenu);
        $I->waitForElementVisible('#pagecontent', self::WAITING_DELAY);
    }
    
    protected function doLogout(AcceptanceTester $I)
    {
        $I->waitForElementVisible('#with-label > span:nth-child(2)');
        $I->click('#with-label > span:nth-child(2)');
        $I->waitForElementVisible('.desktop-bar #logout_link');
        $I->click('.desktop-bar #logout_link');
        $I->waitForElementVisible('#bigbutton', self::WAITING_DELAY);
    }
    
    protected function doLogin(AcceptanceTester $I, WebDriverHelper $w, $usr, $pwd)
    {
        $I->amOnUrl($w->getInstanceURL());
        $I->seeElement('#loginform');
        $I->fillField('#user_name', $usr);
        $I->fillField('#username_password', $pwd);
        $I->click('Log In');
        $I->waitForElementNotVisible('#loginform', self::WAITING_DELAY);
        $I->saveSessionSnapshot('login');
    }
    
    
    // --- Admin jobs
    
    protected function cleanUpAccounts(AcceptanceTester $I)
    {
        
        // we are going to accounts module and clean up
        
        // go to accounts
        $this->goToAccountsPage($I);
        if ($this->clearSearch($I)) {
            // go to detail view
            $I->waitForElementVisible('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a', self::WAITING_DELAY);
            $I->click('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a');
            // delete it
            $I->click('ACTIONS', '#tab-actions');
            $I->waitForElementVisible('#tab-actions > .dropdown-menu', self::WAITING_DELAY);
            $I->click('#delete_button');
            $I->acceptPopup();
            // repeat...
            // go to detail view
            $I->waitForElementVisible('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a', self::WAITING_DELAY);
            $I->click('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a');
            // delete it
            $I->click('ACTIONS', '#tab-actions');
            $I->waitForElementVisible('#tab-actions > .dropdown-menu', self::WAITING_DELAY);
            $I->click('#delete_button');
            $I->acceptPopup();
            $I->wait(self::WAITING_DELAY);
        }
    }
    
    protected function cleanUpSharedRule(AcceptanceTester $I, Administration $a)
    {
        
        // delete shared rule
        $a->gotoAdministration();
        $I->click('#sharedrules_settings');
        $I->click('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a');
        $I->waitForElementVisible('#content');
        $I->see('TEST SSG1');
        // delete it
        $I->click('ACTIONS', '#tab-actions');
        $I->waitForElementVisible('#tab-actions > .dropdown-menu', self::WAITING_DELAY);
        $I->click('#delete_button');
        $I->acceptPopup();
    }


    protected function cleanUpAfterTestedSharedSecurityGroups(AcceptanceTester $I, Administration $a)
    {
        $this->cleanUpSharedRule($I, $a);
        $this->cleanUpAccounts($I);
    }
    
    
    protected function createSharedSecurityRule(AcceptanceTester $I, Administration $a)
    {
                
        // we are goint to create a shared sec rule (filtered by account name contains 'foo')
        $a->gotoAdministration();
        $I->click('#sharedrules_settings');
        $I->click('#actionMenuSidebar > ul > li:nth-child(2) > a');
        $I->waitForElementVisible('#EditView_tabs > div.panel-content', self::WAITING_DELAY); // waiting fo create page
        $I->fillField('#name', 'test ssg1');
        $I->selectOption('#flow_module', 'Accounts');
        $I->waitForElementVisible('#fieldTreeLeafs > ul > li:nth-child(23) > div > span', self::WAITING_DELAY);
        $I->click('#fieldTreeLeafs > ul > li:nth-child(23) > div > span'); // it should be the Name field of Account module
        $I->waitForElementVisible('#aor_conditions_operator\5b 0\5d', self::WAITING_DELAY);
        $I->selectOption('#aor_conditions_operator\5b 0\5d', 'Contains');
        $I->fillField('#aor_conditions_value\5b 0\5d', 'foo');
        $I->scrollTo('#powered_by');    // scroll down to see on screenshot if something went wrong
        $I->click('#btn_ActionLine');
        $I->waitForElementVisible('#shared_rules_actions_action0', self::WAITING_DELAY);
        $I->selectOption('#shared_rules_actions_action0', 'AccessLevel');
        $I->click('#action_parameter0 > table > tbody > tr > td:nth-child(2) > button > img'); // + botton at action / options
        $I->selectOption('#shared_rules_actions_param0_accesslevel0', 'view');  // set access to 'View'
        $I->selectOption('#shared_rules_actions_param0_email_target_type0', 'Users'); // .. for all users
        $I->click('#SAVE_FOOTER');
        $I->waitForElementVisible('#pagecontent');
        $I->see('test ssg1');
        $I->see('foo');
    }

    protected function createTestAccounts(AcceptanceTester $I, Administration $a)
    {
        
        // we are going to create an account with name contains 'foo'
        
        $this->goToAccountsPage($I);
        
        $I->click('#actionMenuSidebar > ul > li:nth-child(2) > a > div.actionmenulink'); // create
        $I->waitForElementVisible('#EditView_tabs > div.panel-content', self::WAITING_DELAY);
        $I->fillField('#name', 'foo acc1');
        $I->waitForElementVisible('#SAVE', self::WAITING_DELAY);
        $I->click('#SAVE');
        
        // we are going to create an account with name does not contains 'foo'
        $allMenuButton = '#toolbar.desktop-toolbar  > ul.nav.navbar-nav > li.topnav.all';
        $I->waitForElementVisible($allMenuButton, self::WAITING_DELAY);
        $I->wait(1);
        $I->click('All', $allMenuButton);
        $allMenu = $allMenuButton . ' > span.notCurrentTab > ul.dropdown-menu';
        $I->waitForElementVisible($allMenu, self::WAITING_DELAY);
        $I->click('Accounts', $allMenu);
                
        $I->waitForElementVisible('#pagecontent', self::WAITING_DELAY);
        $I->click('#actionMenuSidebar > ul > li:nth-child(2) > a > div.actionmenulink'); // create
        $I->waitForElementVisible('#EditView_tabs > div.panel-content', self::WAITING_DELAY);
        $I->fillField('#name', 'test acc2');
        $I->waitForElementVisible('#SAVE', self::WAITING_DELAY);
        $I->click('#SAVE');
    }
    
    // --- Mr Tester jobs
    
    protected function firstLoginWithMrTester(AcceptanceTester $I, Administration $a, WebDriverHelper $w)
    {
        
        // now we are going to login with the tester user (use the following code if it is the first login)
        //
        $I->waitForElementVisible('#next_tab_personalinfo', self::WAITING_DELAY);
        $I->click('#next_tab_personalinfo'); // next..
        $I->waitForElementVisible('#next_tab_locale', self::WAITING_DELAY);
        $I->click('#next_tab_locale'); // next..
        $I->waitForElementVisible('#next_tab_finish', self::WAITING_DELAY);
        $I->click('#next_tab_finish'); // next..
        $I->waitForElementVisible('#finish > div:nth-child(2) > input:nth-child(2)', self::WAITING_DELAY);
        $I->click('#finish > div:nth-child(2) > input:nth-child(2)'); // finish..
    }

    public function testSharedSecurityGroups(
        AcceptanceTester $I,
        ListView $listView,
        Administration $a,
        WebDriverHelper $w
    ) {
        $I->amOnUrl($w->getInstanceURL());
        
        // (only for tessting: apply the following lines to run only this one test)
        // we are going to login as admin and test ssg
        // $this->doLogin($I, $w, $I->getAdminUser(), $I->getAdminPassword());
        
        $this->createTestAccounts($I, $a);
        $this->doLogout($I);
        
        
        $this->doLogin($I, $w, 'chris', 'chris');
        $this->firstLoginWithMrTester($I, $a, $w);
        // tester is going to the account module page
        $this->goToAccountsPage($I);
        $I->waitForElementVisible('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a');
        $I->click('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a');
        $I->waitForElementVisible('#content');
        $I->canSee('test acc2');
        $this->doLogout($I);
        
        
        $I->amOnUrl($w->getInstanceURL());
        $this->doLogin($I, $w, $I->getAdminUser(), $I->getAdminPassword());
        $this->createSharedSecurityRule($I, $a);
        $this->doLogout($I);
        
        
        $this->doLogin($I, $w, 'chris', 'chris');
        // tester is going to the account module page
        $this->goToAccountsPage($I);
        $I->waitForElementVisible('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a');
        $I->click('#MassUpdate > div.list-view-rounded-corners > table > tbody > tr > td:nth-child(3) > b > a');
        $I->waitForElementVisible('#content');
        $I->canSee('foo acc1');
        $I->wait(self::WAITING_DELAY);
        $this->doLogout($I);
        
        
        // we are going to login as admin and clean up everything after the test
        $I->amOnUrl($w->getInstanceURL());
        $this->doLogin($I, $w, $I->getAdminUser(), $I->getAdminPassword());
        $this->cleanUpAfterTestedSharedSecurityGroups($I, $a);
    }
}
