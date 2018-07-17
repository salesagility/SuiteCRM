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

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 26/06/18
 * Time: 09:57
 */

use SuiteCRM\Search\SearchQuery;
use SuiteCRM\Search\SearchTestAbstract;

class SearchQueryTest extends SearchTestAbstract
{

    public function testFromString()
    {
        $searchString = 'hello test';
        $size = 20;
        $from = 50;

        $query = SearchQuery::fromString($searchString, $size, $from);

        self::assertEquals($searchString, $query->getSearchString());
        self::assertEquals($size, $query->getSize());
        self::assertEquals($from, $query->getFrom());
    }


    public function testTrim()
    {
        $string = ' hello test world    ';
        $query = SearchQuery::fromString($string);
        $query->trim();

        self::assertEquals('hello test world', $query->getSearchString());
    }


    public function testToLowerCase()
    {
        $string = ' HelLo tEsT WorLD    ';
        $query = SearchQuery::fromString($string);
        $query->toLowerCase();

        self::assertEquals(' hello test world    ', $query->getSearchString());
    }

    public function testReplace(){
        $string = '-HELLO_WOR-LD-';
        $expString = 'HELLO_WORLD';
        $query = SearchQuery::fromString($string);
        $query->replace('-', '');

        self::assertEquals($expString, $query->getSearchString());
    }

    public function testStripSlashes()
    {
        $string = "Is your name O\'reilly? :\\\\";
        $expected = "Is your name O'reilly? :\\";

        $query = SearchQuery::fromString($string);
        $query->stripSlashes();

        self::assertEquals($expected, $query->getSearchString());
    }

    public function testEscapeRegex()
    {
        $string = '$40 for a g3/400';
        $expected = '\$40 for a g3\/400';

        $query = SearchQuery::fromString($string);
        $query->escapeRegex();

        self::assertEquals($expected, $query->getSearchString());
    }
}
