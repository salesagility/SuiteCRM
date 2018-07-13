<?php
/**
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

use SuiteCRM\Search\MasterSearch;
use SuiteCRM\Search\SearchQuery;

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 06/07/18
 * Time: 09:13
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controller = new MasterSearchController();

$controller->display();

/** @noinspection PhpUndefinedClassInspection */

class MasterSearchController
{
    private $view;

    public function __construct()
    {
        $this->view = new MasterSearchView();
    }

    public function display()
    {
        $this->parseRequest();
        $this->view->display();
    }

    private function parseRequest()
    {
        $searchQuery = filter_input(INPUT_GET, 'search-query-string', FILTER_SANITIZE_STRING);
        if (empty($searchQuery)) {
            $searchQuery = filter_input(INPUT_GET, 'query_string', FILTER_SANITIZE_STRING);
        }
        $searchQuerySize = intval(filter_input(INPUT_GET, 'search-query-size', FILTER_SANITIZE_NUMBER_INT));

        if (empty($searchQuery)) {
            return;
        }

        if (!$searchQuerySize) {
            $searchQuerySize = 10;
        }

        $this->view->ss->assign('searchQueryString', $searchQuery);
        $this->view->ss->assign('searchQuerySize', $searchQuerySize);

        try {
            $query = SearchQuery::fromString($searchQuery, $searchQuerySize);
            $hits = MasterSearch::search('ElasticSearchEngine', $query);
            $hits = $this->parseHits($hits);
            $this->view->ss->assign('hits', $hits);
            $this->view->ss->assign('time', MasterSearch::getSearchTime() * 1000);
        } catch (Exception $e) {
            $this->view->ss->assign('error', true);
        }
    }

    private function parseHits($hits)
    {
        $parsed = [];

        foreach ($hits as $module => $beans) {
            foreach ($beans as $bean) {
                $parsed[$module][] = BeanFactory::getBean($module, $bean);
            }
        }

        return $parsed;
    }
}

class MasterSearchView
{
    public $ss;

    public function __construct()
    {
        $this->ss = new Sugar_Smarty();
    }

    public function display()
    {
        $sizes = [10 => 10, 20 => 20, 30 => 30, 40 => 40, 50 => 50];
        $engines = [];

        foreach (MasterSearch::getEngines() as $engine) {
            // TODO retrieve translations
            $engines[$engine] = $engine;
        }

        $this->ss->assign('sizeOptions', $sizes);
        $this->ss->assign('engineOptions', $engines);

        $this->ss->display(__DIR__ . '/templates/search.main.tpl');
    }

}