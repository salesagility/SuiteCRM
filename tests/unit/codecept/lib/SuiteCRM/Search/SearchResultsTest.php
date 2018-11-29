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


use SuiteCRM\Search\SearchResults;
use SuiteCRM\StateCheckerUnitAbstract;
use SuiteCRM\StateSaver;

/**
 * SearchResultsTest
 *
 * @author gyula
 */
class SearchResultsTest extends StateCheckerUnitAbstract {
    
    public function testGetHitsAsBeans() {
        
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('job_queue');
        $state->pushTable('aod_indexevent');
        $state->pushGlobals();
        
        $acc = BeanFactory::getBean('Accounts');
        $acc->name = 'acc 1';
        $ids[] = $acc->save();
        $acc = BeanFactory::getBean('Accounts');
        $acc->name = 'acc 2';
        $ids[] = $acc->save();
        $acc = BeanFactory::getBean('Accounts');
        $acc->name = 'acc 3';
        $ids[] = $acc->save();
        $hits = [
            'Accounts' => $ids,
        ];
        
        $sr = new SearchResults($hits);
        $parsed = $sr->getHitsAsBeans();
        
        $exp = array_keys($parsed);
        $this->assertSame(['Accounts'], $exp);
        
        $exp = array_keys($parsed['Accounts']);
        $this->assertSame([0, 1, 2], $exp);
        
        $exp = array_keys((array)$parsed['Accounts'][0]);
        $this->assertContains('modified_user_id', $exp);
        
        $exp = $parsed['Accounts'][0]->name;
        global $sugar_config;
        $siteUrl = $sugar_config['site_url'];
        $this->assertEquals('<a href="' . $siteUrl . '/index.php?action=DetailView&module=Accounts&record=' . $ids[0] . '&offset=1"><span>acc 1</span></a>', $exp);
        
        
        $state->popGlobals();
        $state->popTable('aod_indexevent');
        $state->popTable('job_queue');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
}
