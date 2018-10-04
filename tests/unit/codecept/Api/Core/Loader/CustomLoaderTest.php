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

use Api\Core\Loader\CustomLoader;
use Slim\App;
use SuiteCRM\StateCheckerUnitAbstract;

/**
 * CustomLoaderTest
 *
 * @author gyula
 */
class CustomLoaderTest extends StateCheckerUnitAbstract
{
    public function testArrayMerge()
    {
        $result = CustomLoader::arrayMerge([
            ['first' => ['one.1', 'one.2', 'one.3'], 'second' => 'two', 'third' => 'three'],
            ['first' => ['one.4', 'one.5'], 'foo' => ['bar', 'bazz']]
        ]);
        $this->assertEquals([
            'first' => ['one.1', 'one.2', 'one.3', 'one.4', 'one.5'],
            'second' => 'two',
            'third' => 'three',
            'foo' => ['bar', 'bazz'],
        ], $result);
    }
    
    public function testMergeCustomArray()
    {
        $result = CustomLoader::mergeCustomArray(['one', 'two', 'three'], 'testCustom.php');
        $this->assertEquals(CustomLoader::ERR_FILE_NOT_FOUND, CustomLoader::getLastError());
        $this->assertEquals(['one', 'two', 'three'], $result);
        
        CustomLoader::setCustomPath(__DIR__ . DIRECTORY_SEPARATOR);
        $result = CustomLoader::mergeCustomArray(['foo', 'bar'], 'testArray.php');
        $this->assertEquals(CustomLoader::ERR_NO_ERROR, CustomLoader::getLastError());
        $this->assertEquals(['foo', 'bar', 'bazz', 1, 2, 3], $result);
        
        try {
            $result = CustomLoader::mergeCustomArray(['foo', 'bar'], 'testArrayWrong.php');
            $this->assertTrue(false, 'It should throws an exception because the customization is not an array.');
        } catch (Exception $e) {
            $this->assertEquals(CustomLoader::ERR_WRONG_CUSTOM_FORMAT, $e->getCode());
        }
        
        // restore custom route
        CustomLoader::setCustomPath();
    }
    
    public function testLoadCustomRoutes()
    {
        $app = new App();
        
        CustomLoader::loadCustomRoutes($app, 'testRoutes.php');
        $this->assertEquals(CustomLoader::ERR_ROUTE_FILE_NOT_FOUND, CustomLoader::getLastError());
        
        CustomLoader::setCustomPath(__DIR__ . DIRECTORY_SEPARATOR);
        CustomLoader::loadCustomRoutes($app, 'testRoutes.php');
        $this->assertEquals(CustomLoader::ERR_NO_ERROR, CustomLoader::getLastError());
                
        // restore custom route
        CustomLoader::setCustomPath();
    }
}
