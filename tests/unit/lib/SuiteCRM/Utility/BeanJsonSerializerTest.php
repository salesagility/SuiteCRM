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
 * Date: 29/06/18
 * Time: 10:21
 */

use SuiteCRM\Utility\BeanJsonSerializer;
use SuiteCRM\Utility\BeanJsonSerializerTestData\SaltBean;

class BeanJsonSerializerTest extends \Codeception\Test\Unit
{

    public function testSanitizePhone()
    {
        $data1 = "(+44) 012321323";
        $expe1 = "+44012321323";

        $data2 = "(+45) 0123-213-23";
        $expe2 = "+45012321323";

        $data3 = "(ab) 0123 213 23";
        $expe3 = "012321323";

        self::assertEquals($expe1, BeanJsonSerializer::sanitizePhone($data1));
        self::assertEquals($expe2, BeanJsonSerializer::sanitizePhone($data2));
        self::assertEquals($expe3, BeanJsonSerializer::sanitizePhone($data3));
    }

    public function testToArray()
    {
        $absolutelyNotAFakeBean = $this->getSaltBean();

        $expected = json_decode(file_get_contents(__DIR__ . '/BeanJsonSerializerTestData/ContactBean.expected.json'), true);

        $result = BeanJsonSerializer::toArray($absolutelyNotAFakeBean, false);

        self::assertEquals($expected, $result);
    }

    /**
     * @return SugarBean
     */
    private function getSaltBean()
    {
        /** @var SugarBean $absolutelyNotAFakeBean */
        $absolutelyNotAFakeBean = new SaltBean('Contacts', __DIR__ . '/BeanJsonSerializerTestData/ContactBean.json');
        return $absolutelyNotAFakeBean;
    }

    public function testSerialize()
    {
        $absolutelyNotAFakeBean = $this->getSaltBean();

        $actual = BeanJsonSerializer::serialize($absolutelyNotAFakeBean, false, true);

        self::assertJsonStringEqualsJsonFile(
            __DIR__ . '/BeanJsonSerializerTestData/ContactBean.expected.json',
            $actual
        );
    }
}
