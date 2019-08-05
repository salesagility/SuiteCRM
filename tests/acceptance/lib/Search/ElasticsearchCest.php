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

use Facebook\WebDriver\Exception\UnexpectedAlertOpenException;
use Helper\WebDriverHelper;
use Step\Acceptance\AccountsTester;
use Step\Acceptance\NavigationBarTester;

/**
 * ElasticsearchCest
 *
 * @author gyula
 */
class ElasticsearchCest
{
    /**
     *
     * @param AcceptanceTester $I
     * @param WebDriverHelper $helper
     */
    public function testSearchSetup(AcceptanceTester $I, WebDriverHelper $helper)
    {        
        // login..
        $I->loginAsAdmin();
        
        // setup elasticsearch..
        
        $I->click('admin');
        
        // Click on Admin menu:
        // TODO: Page css selector error: I found element #admin_link at 3 times. Html tag should have uniqe ID.
        $I->click('.navbar.navbar-inverse.navbar-fixed-top .container-fluid .desktop-bar #toolbar #globalLinks .dropdown-menu.user-dropdown.user-menu #admin_link');
        
        $I->click('Search Settings');
        $I->selectOption('#search-engine', 'Elasticsearch Engine');
        $I->click('Save');

        $I->waitForElementVisible('#elastic_search');
        $I->click('#elastic_search');
        $I->checkOption('#es-enabled');
        $I->fillField('#es-host', $helper->getElasticSearchHost());
        $I->fillField('#es-user', 'admin');
        $I->fillField('#es-password', 'admin');

        $I->click('Schedule full indexing');
        $I->wait(1);
        $I->seeInPopup('A full indexing has been scheduled and will start in the next 60 seconds. Search results might be inconsistent until the process is complete.');
        $I->acceptPopup();
        
        $I->click('Schedule partial indexing');
        $I->wait(1);
        $I->seeInPopup('A partial indexing has been scheduled and will start in the next 60 seconds.');
        $I->acceptPopup();

        $I->click('Test connection');
        $I->wait(1);
        $I->seeInPopup('Connection successful.');
        $I->acceptPopup();

        $I->click('Save');
    }
    
    /**
     *
     * @param AcceptanceTester $I
     */
    public function testSearchNotFound(AcceptanceTester $I)
    {
        
        // login..
        $I->loginAsAdmin();
        
        // lets try out elasticsearch..
        // TODO [Selenium browser Logs] 12:47:10.930 SEVERE - http://localhost/SuiteCRM/index.php?action=Login&module=Users - [DOM] Found 2 elements with non-unique id #form: (More info: https://goo.gl/9p2vKq)
        $I->fillField('div.desktop-bar ul#toolbar li #searchform .input-group #query_string', 'I_bet_there_is_nothing_to_contains_this');
        
        // click on search icon: TODO: search icon ID is not unique:
        $I->click('.desktop-bar #searchform > div > span > button');
        
        $I->see('SEARCH');
        $I->see('Results');
        $I->see('No results matching your search criteria. Try broadening your search.');
        $I->see('Search performed in');
        
        $I->fillField('div.desktop-bar ul#toolbar li #searchform .input-group #query_string', 'acc');
        $I->click('#search-wrapper-form > table > tbody > tr:nth-child(1) > td > input.button.primary');
        
        $I->see('SEARCH');
        $I->see('Results');
        $I->see('No results matching your search criteria. Try broadening your search.');
        $I->see('Search performed in');
    }
    
    /**
     *
     * @param AccountsTester $accounts
     * @param type $max
     */
    protected function createTestAccounts(AccountsTester $accounts, $max, $from = 0)
    {
        $navi = new NavigationBarTester($accounts->getPublicScenario());
        $navi->clickAllMenuItem('Accounts');
        
        for ($i=$from; $i<$max; $i++) {
            $accounts->createAccountForElasticSearch('acc_for_test ' . $i);
            // waiting few second to elasticsearch indexer makes the job done:
            $accounts->wait(3);
        }
        
        // waiting few second to elasticsearch indexer makes the job done:
        $accounts->wait(5);
    }
    
    /**
     *
     * @param AcceptanceTester $I
     * @param AccountsTester $accounts
     * @param type $max
     */
    protected function deleteTestAccounts(AcceptanceTester $I, AccountsTester $accounts, $max)
    {
        $navi = new NavigationBarTester($accounts->getPublicScenario());
        $navi->clickAllMenuItem('Accounts');
        
        for ($i=0; $i<$max; $i++) {
            $I->waitForElementVisible('//*[@id="MassUpdate"]/div[3]/table/tbody/tr[1]/td[3]/b/a');
            $I->click('//*[@id="MassUpdate"]/div[3]/table/tbody/tr[1]/td[3]/b/a');
            $I->waitForElementVisible('//*[@id="tab-actions"]/a');
            $I->click('//*[@id="tab-actions"]/a');
            $I->click('Delete');
            $I->wait(1);
            $I->seeInPopup('Are you sure you want to delete this record?');
            $I->acceptPopup();
        }
    }
    
    /**
     *
     * @param AcceptanceTester $I
     * @param AccountsTester $accounts
     */
    public function testSearchFounds(AcceptanceTester $I, AccountsTester $accounts)
    {
        $max = 15;
        
        // login..
        $I->loginAsAdmin();
        
        // adding some account..
        $this->createTestAccounts($accounts, $max);
        
        // search for them..
        
        $I->fillField('div.desktop-bar ul#toolbar li #searchform .input-group #query_string', 'acc_for_test');
        $I->click('.desktop-bar #searchform > div > span > button');
        
        $I->see('SEARCH');
        $I->see('Results');
//        $I->see('Total result(s): ' . $max);
        $I->see('Search performed in');
        $I->see('Page 1 of 2');
        
        $I->click('Next');
        $I->see('SEARCH');
        $I->see('Results');
//        $I->see('Total result(s): ' . $max);
        $I->see('Search performed in');
        $I->see('Page 2 of 2');
        
        
        $I->fillField('div.desktop-bar ul#toolbar li #searchform .input-group #query_string', '11');
        $I->see('SEARCH');
        $I->see('Results');
        //sometimes elasticsearch indexer randomly broken in travis, so the next check randomly failing:
        // $I->see('Total result(s): 1');
        $I->see('Search performed in');
        $I->see('Accounts');
        $I->see('Account Name');
        $I->see('acc_for_test 11');
        
        // add few more until end of the last page
        $end = 20;
        $this->createTestAccounts($accounts, $end, $max);
           
        $I->fillField('div.desktop-bar ul#toolbar li #searchform .input-group #query_string', 'acc_for_test');
        $I->click('.desktop-bar #searchform > div > span > button');
        
        $I->see('SEARCH');
        $I->see('Results');
        //sometimes elasticsearch indexer randomly broken in travis, so the next check randomly failing:
        //$I->see('Total result(s): ' . $end);
        $I->see('Search performed in');
        $I->see('Page 1 of 2');
        
        // clean up test accounts
        $this->deleteTestAccounts($I, $accounts, $end);
    }
}
