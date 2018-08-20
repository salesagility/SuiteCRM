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
include_once __DIR__ . '/SugarBeanMock.php';
include_once __DIR__ . '/../../../../include/SubPanel/SubPanelDefinitions.php';
include_once __DIR__ . '/../../../../modules/AM_ProjectTemplates/AM_ProjectTemplates_sugar.php';

use SuiteCRM\StateCheckerConfig;
use SuiteCRM\Test\SuitePHPUnit_Framework_TestCase;

/** @noinspection PhpUndefinedClassInspection */
class SugarBeanTest extends SuitePHPUnit_Framework_TestCase
{

    /**
     * @var array
     */
    protected $fieldDefsStore;

    public function setUp()
    {
        parent::setUp();
        $this->fieldDefsStore();
    }

    public function tearDown()
    {
        $this->fieldDefsRestore();
        parent::tearDown();
    }

    /**
     * Store static field_defs per modules
     * @param string $key
     */
    protected function fieldDefsStore($key = 'base')
    {
        $object = BeanFactory::getBean('Contacts');
        $this->fieldDefsStore[$key]['Contact'] = $object->field_defs;
    }

    /**
     * Restore static field_defs per modules
     * @param string $key
     */
    protected function fieldDefsRestore($key = 'base')
    {
        $object = BeanFactory::getBean('Contacts');
        $object->field_defs = $this->fieldDefsStore[$key]['Contact'];
    }

    /**
     * @see SugarBean::__construct()
     */
    public function testConstruct()
    {
        global $dictionary;

        // test dup3
        include_once __DIR__ . '/../../../../modules/AM_ProjectTemplates/AM_ProjectTemplates_sugar.php';
        $bean = new AM_ProjectTemplates_sugar();
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('AM_ProjectTemplates', $bean->module_name);
        self::assertEquals(array(
            'id' => 1,
            'name' => 1,
            ), $bean->required_fields);
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules/AM_ProjectTemplates/Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('AM_ProjectTemplates', $bean->custom_fields->module);
        self::assertEquals(array(
            0 => 'id',
            1 => 'name',
            2 => 'date_entered',
            3 => 'date_modified',
            4 => 'modified_user_id',
            5 => 'modified_by_name',
            6 => 'created_by',
            7 => 'created_by_name',
            8 => 'description',
            9 => 'deleted',
            10 => 'created_by_link',
            11 => 'modified_user_link',
            12 => 'assigned_user_id',
            13 => 'assigned_user_name',
            14 => 'assigned_user_link',
            15 => 'status',
            16 => 'priority',
            17 => 'am_projecttemplates_project_1',
            18 => 'am_tasktemplates_am_projecttemplates',
            19 => 'am_projecttemplates_users_1',
            20 => 'am_projecttemplates_contacts_1',
            21 => 'override_business_hours',
            ), $bean->column_fields);

        $keys = array_keys($bean->field_name_map);
        self::assertEquals(array(
            0 => 'id',
            1 => 'name',
            2 => 'date_entered',
            3 => 'date_modified',
            4 => 'modified_user_id',
            5 => 'modified_by_name',
            6 => 'created_by',
            7 => 'created_by_name',
            8 => 'description',
            9 => 'deleted',
            10 => 'created_by_link',
            11 => 'modified_user_link',
            12 => 'assigned_user_id',
            13 => 'assigned_user_name',
            14 => 'assigned_user_link',
            15 => 'status',
            16 => 'priority',
            17 => 'am_projecttemplates_project_1',
            18 => 'am_tasktemplates_am_projecttemplates',
            19 => 'am_projecttemplates_users_1',
            20 => 'am_projecttemplates_contacts_1',
            21 => 'override_business_hours',
            ), $keys);

        self::assertEquals($keys, array_keys($bean->field_defs));
        self::assertEquals(true, $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertEquals(true, $bean->acl_fields);


        // test

        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Users');
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertEquals('Users', $bean->module_name);
        self::assertNotTrue(!isset($bean->required_fields));
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules/Users/Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertNotEquals('', $bean->custom_fields->module);
        self::assertNotEquals(array(), $bean->column_fields);
        self::assertNotEquals('', $bean->field_name_map);
        self::assertNotEquals('', $bean->field_defs);
        self::assertEquals('', $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertTrue(isset($bean->added_custom_field_defs));
        self::assertTrue(isset($bean->acl_fields));

        // test
        $dictionary['']['optimistic_locking'] = true;
        $bean = BeanFactory::getBean('Users');
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertNotEquals('', $bean->module_name);
        self::assertTrue(isset($bean->required_fields));
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertNotEquals('custom/Extension/modules//Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertNotEquals('', $bean->custom_fields->module);
        self::assertNotEquals(array(), $bean->column_fields);
        self::assertNotEquals('', $bean->field_name_map);
        self::assertNotEquals('', $bean->field_defs);
        self::assertNotEquals(true, $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertTrue($bean->added_custom_field_defs);
        self::assertTrue(isset($bean->acl_fields));
        $dictionary['']['optimistic_locking'] = null;

        // test
        $bean = BeanFactory::getBean('Users');
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertNotEquals('', $bean->module_name);
        self::assertTrue(isset($bean->required_fields));
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules/Users/Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertNotEquals('', $bean->custom_fields->module);
        self::assertNotEquals(array(), $bean->column_fields);
        self::assertNotEquals('', $bean->field_name_map);
        self::assertNotEquals('', $bean->field_defs);
        self::assertEquals(array(), $bean->list_fields);
        self::assertTrue($bean->added_custom_field_defs);
        self::assertTrue(isset($bean->acl_fields));

        // test
        $GLOBALS['reload_vardefs'] = true;
        $dictionary['']['fields'] = $dictionary['User']['fields'];
        $bean = BeanFactory::getBean('Users');
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertNotEquals('', $bean->module_name);
        self::assertTrue(isset($bean->required_fields));
        self::assertEquals(array(
            'id' => 1,
            'user_name' => 1,
            'system_generated_password' => 1,
            'last_name' => 1,
            'date_entered' => 1,
            'date_modified' => 1,
            'status' => 1,
            'email1' => 1,
            'email_addresses' => 1,
            'email_addresses_primary' => 1,
            ), $bean->required_fields);
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules/Users/Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('Users', $bean->custom_fields->module);
        self::assertEquals(array(
            0 => 'id',
            1 => 'user_name',
            2 => 'user_hash',
            3 => 'system_generated_password',
            4 => 'pwd_last_changed',
            5 => 'authenticate_id',
            6 => 'sugar_login',
            7 => 'first_name',
            8 => 'last_name',
            9 => 'full_name',
            10 => 'name',
            11 => 'is_admin',
            12 => 'external_auth_only',
            13 => 'receive_notifications',
            14 => 'description',
            15 => 'date_entered',
            16 => 'date_modified',
            17 => 'modified_user_id',
            18 => 'modified_by_name',
            19 => 'created_by',
            20 => 'created_by_name',
            21 => 'title',
            22 => 'photo',
            23 => 'department',
            24 => 'phone_home',
            25 => 'phone_mobile',
            26 => 'phone_work',
            27 => 'phone_other',
            28 => 'phone_fax',
            29 => 'status',
            30 => 'address_street',
            31 => 'address_city',
            32 => 'address_state',
            33 => 'address_country',
            34 => 'address_postalcode',
            35 => 'UserType',
            36 => 'deleted',
            37 => 'portal_only',
            38 => 'show_on_employees',
            39 => 'employee_status',
            40 => 'messenger_id',
            41 => 'messenger_type',
            42 => 'calls',
            43 => 'meetings',
            44 => 'contacts_sync',
            45 => 'reports_to_id',
            46 => 'reports_to_name',
            47 => 'reports_to_link',
            48 => 'reportees',
            49 => 'email1',
            50 => 'email_addresses',
            51 => 'email_addresses_primary',
            52 => 'email_link_type',
            53 => 'editor_type',
            54 => 'aclroles',
            55 => 'is_group',
            56 => 'c_accept_status_fields',
            57 => 'm_accept_status_fields',
            58 => 'accept_status_id',
            59 => 'accept_status_name',
            60 => 'prospect_lists',
            61 => 'emails_users',
            62 => 'eapm',
            63 => 'oauth_tokens',
            64 => 'project_resource',
            65 => 'project_users_1',
            66 => 'am_projecttemplates_resources',
            67 => 'am_projecttemplates_users_1',
            68 => 'SecurityGroups',
            69 => 'securitygroup_noninher_fields',
            70 => 'securitygroup_noninherit_id',
            71 => 'securitygroup_noninheritable',
            72 => 'securitygroup_primary_group',
            73 => 'factor_auth',
            74 => 'factor_auth_interface',
            ), $bean->column_fields);

        $keys = array_keys($bean->field_name_map);
        self::assertEquals($bean->column_fields, $keys);

        $keys = array_keys($bean->field_defs);
        self::assertEquals($bean->column_fields, $keys);

        self::assertEquals('', $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertTrue(isset($bean->acl_fields));


        // test
        $GLOBALS['reload_vardefs'] = true;
        $dictionary['']['fields'] = $dictionary['User']['fields'];
        $dictionary['']['optimistic_locking'] = true;
        $bean = BeanFactory::getBean('Users');
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertNotEquals('', $bean->module_name);
        self::assertTrue(isset($bean->required_fields));
        self::assertEquals(array(
            'id' => 1,
            'user_name' => 1,
            'system_generated_password' => 1,
            'last_name' => 1,
            'date_entered' => 1,
            'date_modified' => 1,
            'status' => 1,
            'email1' => 1,
            'email_addresses' => 1,
            'email_addresses_primary' => 1,
            ), $bean->required_fields);
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules/Users/Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('Users', $bean->custom_fields->module);
        self::assertEquals(array(
            0 => 'id',
            1 => 'user_name',
            2 => 'user_hash',
            3 => 'system_generated_password',
            4 => 'pwd_last_changed',
            5 => 'authenticate_id',
            6 => 'sugar_login',
            7 => 'first_name',
            8 => 'last_name',
            9 => 'full_name',
            10 => 'name',
            11 => 'is_admin',
            12 => 'external_auth_only',
            13 => 'receive_notifications',
            14 => 'description',
            15 => 'date_entered',
            16 => 'date_modified',
            17 => 'modified_user_id',
            18 => 'modified_by_name',
            19 => 'created_by',
            20 => 'created_by_name',
            21 => 'title',
            22 => 'photo',
            23 => 'department',
            24 => 'phone_home',
            25 => 'phone_mobile',
            26 => 'phone_work',
            27 => 'phone_other',
            28 => 'phone_fax',
            29 => 'status',
            30 => 'address_street',
            31 => 'address_city',
            32 => 'address_state',
            33 => 'address_country',
            34 => 'address_postalcode',
            35 => 'UserType',
            36 => 'deleted',
            37 => 'portal_only',
            38 => 'show_on_employees',
            39 => 'employee_status',
            40 => 'messenger_id',
            41 => 'messenger_type',
            42 => 'calls',
            43 => 'meetings',
            44 => 'contacts_sync',
            45 => 'reports_to_id',
            46 => 'reports_to_name',
            47 => 'reports_to_link',
            48 => 'reportees',
            49 => 'email1',
            50 => 'email_addresses',
            51 => 'email_addresses_primary',
            52 => 'email_link_type',
            53 => 'editor_type',
            54 => 'aclroles',
            55 => 'is_group',
            56 => 'c_accept_status_fields',
            57 => 'm_accept_status_fields',
            58 => 'accept_status_id',
            59 => 'accept_status_name',
            60 => 'prospect_lists',
            61 => 'emails_users',
            62 => 'eapm',
            63 => 'oauth_tokens',
            64 => 'project_resource',
            65 => 'project_users_1',
            66 => 'am_projecttemplates_resources',
            67 => 'am_projecttemplates_users_1',
            68 => 'SecurityGroups',
            69 => 'securitygroup_noninher_fields',
            70 => 'securitygroup_noninherit_id',
            71 => 'securitygroup_noninheritable',
            72 => 'securitygroup_primary_group',
            73 => 'factor_auth',
            74 => 'factor_auth_interface',
            ), $bean->column_fields);

        $keys = array_keys($bean->field_name_map);
        self::assertEquals($bean->column_fields, $keys);

        $keys = array_keys($bean->field_defs);
        self::assertEquals($bean->column_fields, $keys);

        self::assertNotEquals(true, $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertTrue(isset($bean->acl_fields));


        // test
        $GLOBALS['reload_vardefs'] = true;
        $dictionary['']['fields'] = $dictionary['User']['fields'];
        $dictionary['']['optimistic_locking'] = true;
        $bean = BeanFactory::getBean('Users');
        self::assertInstanceOf(DBManager::class, $bean->db);
        self::assertNotEquals('', $bean->module_name);
        self::assertTrue(isset($bean->required_fields));
        self::assertEquals(array(
            'id' => 1,
            'user_name' => 1,
            'system_generated_password' => 1,
            'last_name' => 1,
            'date_entered' => 1,
            'date_modified' => 1,
            'status' => 1,
            'email1' => 1,
            'email_addresses' => 1,
            'email_addresses_primary' => 1,
            ), $bean->required_fields);
        self::assertInstanceOf(DynamicField::class, $bean->custom_fields);
        self::assertEquals(false, $bean->custom_fields->use_existing_labels);
        self::assertEquals('custom/Extension/modules/Users/Ext/Vardefs', $bean->custom_fields->base_path);
        self::assertSame(DBManagerFactory::getInstance(), $bean->custom_fields->db);
        self::assertSame($bean, $bean->custom_fields->bean);
        self::assertEquals('Users', $bean->custom_fields->module);
        self::assertEquals(array(
            0 => 'id',
            1 => 'user_name',
            2 => 'user_hash',
            3 => 'system_generated_password',
            4 => 'pwd_last_changed',
            5 => 'authenticate_id',
            6 => 'sugar_login',
            7 => 'first_name',
            8 => 'last_name',
            9 => 'full_name',
            10 => 'name',
            11 => 'is_admin',
            12 => 'external_auth_only',
            13 => 'receive_notifications',
            14 => 'description',
            15 => 'date_entered',
            16 => 'date_modified',
            17 => 'modified_user_id',
            18 => 'modified_by_name',
            19 => 'created_by',
            20 => 'created_by_name',
            21 => 'title',
            22 => 'photo',
            23 => 'department',
            24 => 'phone_home',
            25 => 'phone_mobile',
            26 => 'phone_work',
            27 => 'phone_other',
            28 => 'phone_fax',
            29 => 'status',
            30 => 'address_street',
            31 => 'address_city',
            32 => 'address_state',
            33 => 'address_country',
            34 => 'address_postalcode',
            35 => 'UserType',
            36 => 'deleted',
            37 => 'portal_only',
            38 => 'show_on_employees',
            39 => 'employee_status',
            40 => 'messenger_id',
            41 => 'messenger_type',
            42 => 'calls',
            43 => 'meetings',
            44 => 'contacts_sync',
            45 => 'reports_to_id',
            46 => 'reports_to_name',
            47 => 'reports_to_link',
            48 => 'reportees',
            49 => 'email1',
            50 => 'email_addresses',
            51 => 'email_addresses_primary',
            52 => 'email_link_type',
            53 => 'editor_type',
            54 => 'aclroles',
            55 => 'is_group',
            56 => 'c_accept_status_fields',
            57 => 'm_accept_status_fields',
            58 => 'accept_status_id',
            59 => 'accept_status_name',
            60 => 'prospect_lists',
            61 => 'emails_users',
            62 => 'eapm',
            63 => 'oauth_tokens',
            64 => 'project_resource',
            65 => 'project_users_1',
            66 => 'am_projecttemplates_resources',
            67 => 'am_projecttemplates_users_1',
            68 => 'SecurityGroups',
            69 => 'securitygroup_noninher_fields',
            70 => 'securitygroup_noninherit_id',
            71 => 'securitygroup_noninheritable',
            72 => 'securitygroup_primary_group',
            73 => 'factor_auth',
            74 => 'factor_auth_interface',
            ), $bean->column_fields);

        $keys = array_keys($bean->field_name_map);
        self::assertEquals($bean->column_fields, $keys);

        $keys = array_keys($bean->field_defs);
        self::assertEquals($bean->column_fields, $keys);

        self::assertNotEquals(true, $bean->optimistic_lock);
        self::assertEquals(array(), $bean->list_fields);
        self::assertNotTrue(isset($bean->added_custom_field_defs));
        self::assertTrue(isset($bean->acl_fields));
    }

    /**
     * @see SugarBean::setupCustomFields()
     */
    public function testSetupCustomFields()
    {
        $bean = BeanFactory::getBean('Users');

        // test
        $bean->setupCustomFields('test');
        self::assertEquals('custom/Extension/modules/test/Ext/Vardefs', $bean->custom_fields->base_path);

        // test
        $bean->setupCustomFields('Users');
        self::assertEquals('custom/Extension/modules/Users/Ext/Vardefs', $bean->custom_fields->base_path);
    }

    /**
     * @see SugarBean::bean_implements()
     */
    public function testBeanImplements()
    {
        $bean = BeanFactory::getBean('Users');

        // test
        $results = $bean->bean_implements('test');
        self::assertEquals(false, $results);
    }

    /**
     * @see SugarBean::populateDefaultValues()
     */
    public function testPopulateDefaultValues()
    {
        $testBean1 = BeanFactory::getBean('Users');
        ;
        $testBean1->field_defs = null;
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $testBean1->populateDefaultValues();
        self::assertEquals(null, $results);
        self::assertEquals(null, $testBean1->field_defs);

        // test
        $bean = BeanFactory::getBean('Users');
        $force = false;
        $fieldDefsBefore = $bean->field_defs;
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals($fieldDefsBefore, $bean->field_defs);


        // test
        $bean = BeanFactory::getBean('Users');
        $force = true;
        $bean->field_defs['test'] = array(
            'default' => true,
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'default' => true,
            ),
            ), $bean->field_defs);


        // test
        $bean = BeanFactory::getBean('Users');
        $force = true;
        $bean->field_defs['test'] = array(
            'default' => true,
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'default' => true,
            ),
            ), $bean->field_defs);
        $field = 'test';
        self::assertEquals(1, $bean->$field);


        // test
        $bean = BeanFactory::getBean('Users');
        $force = true;
        $bean->field_defs['test'] = array(
            'default' => '',
        );
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->populateDefaultValues($force);
        self::assertEquals(null, $results);
        self::assertEquals(array(
            'test' => array(
                'default' => '',
            ),
            ), $bean->field_defs);
        $field = 'test';
        self::assertEquals('', $bean->$field);
    }

    /**
     * @see SugarBean::parseDateDefault()
     */
    public function testParseDateDefault()
    {
        $bean = new SugarBeanMock();


        // test
        $results = $bean->publicParseDateDefault('2015-05-05');
        self::assertEquals('05/05/2015', $results);

        // test
        $results = $bean->publicParseDateDefault('2015-05-05', true);
        self::assertNotEquals('05/05/2015', $results);
        self::assertEquals(1, preg_match('/05\/05\/2015 \d{2}:\d{2}/', $results));

        // test
        $results = $bean->publicParseDateDefault('2015-05-05 11:11', true);
        self::assertEquals('05/05/2015 11:11', $results);

        // test
        $results = $bean->publicParseDateDefault('2015-05-05&11:11', true);
        self::assertEquals('05/05/2015 11:11', $results);
    }

    /**
     * @see SugarBean::removeRelationshipMeta()
     */
    public function testRemoveRelationshipMeta()
    {
        // test
        $GLOBALS['log']->reset();
        SugarBean::removeRelationshipMeta(null, null, null, null, null);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::removeRelationshipMeta(null, null, null, null, 'Contacts');
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::removeRelationshipMeta('key', null, null, array('key' => 'value'), 'Tests');
        self::assertNotTrue(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        SugarBean::removeRelationshipMeta('key', null, null, array(
            'key' => array(
                'relationships' => true,
            ),
            ), 'Tests');
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);
    }

    /**
     * @see SugarBean::createRelationshipMeta()
     */
    public function testCreateRelationshipMeta()
    {
        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta(null, null, null, array(), null);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta(null, null, null, array(), 'Contacts');
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta(null, null, null, array(), 'Contacts', true);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta('User', null, null, array(), 'Contacts');
        self::assertCount(6, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta('User', $this->db, null, array(), 'Contacts');
        self::assertNotTrue(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta('Nonexists1', $this->db, null, array(), 'Nonexists2');
        self::assertCount(1, $GLOBALS['log']->calls['debug']);

        // test
        $GLOBALS['log']->reset();
        SugarBean::createRelationshipMeta('User', null, null, array(), 'Contacts');
        self::assertCount(6, $GLOBALS['log']->calls['fatal']);
    }

    /**
     * @see SugarBean::get_union_related_list()
     * @todo need more test coverage and less function complexity
     */
    public function testGetUnionRelatedList()
    {
        $request = $_REQUEST;
        self::assertFalse(isset($_SESSION));

        // test
        $GLOBALS['log']->reset();
        $results = SugarBean::get_union_related_list(null);
        self::assertCount(3, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(null, $results);


        // test
        $GLOBALS['log']->reset();
        $_SESSION['show_deleted'] = 1;
        $results = SugarBean::get_union_related_list(null);
        self::assertCount(3, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(null, $results);


        // test
        $GLOBALS['log']->reset();
        $_SESSION['show_deleted'] = 1;
        $parentBean = new SugarBeanMock();
        $subPanelDef = new aSubPanel(null, null, $parentBean);
        $results = SugarBean::get_union_related_list($parentBean, '', '', '', 0, -1, -1, 0, $subPanelDef);
        self::assertEquals(array(
            'list' => array(),
            'parent_data' => array(),
            'row_count' => 0,
            'next_offset' => 10,
            'previous_offset' => -10,
            'current_offset' => 0,
            'query' => '',
            ), $results);


        // test
        $GLOBALS['log']->reset();
        $subPanelDef->_instance_properties['type'] = 'collection';
        $results = SugarBean::get_union_related_list($parentBean, '', '', '', 0, -1, -1, 0, $subPanelDef);
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);
        self::assertEquals(array(
            'list' => array(),
            'parent_data' => array(),
            'row_count' => 0,
            'next_offset' => 10,
            'previous_offset' => -10,
            'current_offset' => 0,
            'query' => '',
            ), $results);


        // test
        $GLOBALS['log']->reset();
        $_SESSION['show_deleted'] = 1;
        $parentBean = new SugarBeanMock();
        $subPanelDef = new aSubPanel(null, null, $parentBean);
        $subPanelDef->_instance_properties['type'] = 'collection';
        $subPanelDef->_instance_properties['collection_list'] = array(
            array('module' => 'Contacts'),
        );
        $subPanelDef->_instance_properties['get_subpanel_data'] = 'function';
        $subPanelDef->_instance_properties['generate_select'] = array();
        $results = SugarBean::get_union_related_list($parentBean, '', '', '', 0, -1, -1, 0, $subPanelDef);

        self::assertEquals(array(
            'list' => array(),
            'parent_data' => array(),
            'row_count' => 0,
            'next_offset' => 10,
            'previous_offset' => -10,
            'current_offset' => 0,
            'query' => '',
            ), $results);

        $_REQUEST = $request;
        unset($_SESSION);
    }

    /**
     * @see SugarBean::build_sub_queries_for_union()
     */
    public function testBuildSubQueriesForUnion()
    {

        // test
        $bean = new SugarBeanMock();
        $panel = new aSubPanel('Test', array(
            'get_subpanel_data' => 1,
            ), $bean);
        $subpanel_list = array(
            $panel
        );
        $subpanel_def = null;
        $parentBean = new SugarBeanMock();
        $order_by = null;
        $GLOBALS['log']->reset();
        $results = SugarBeanMock::publicBuildSubQueriesForUnion($subpanel_list, $subpanel_def, $parentBean, $order_by);
        self::assertEquals(array(), $results);
        self::assertNotTrue(isset($GLOBALS['log']->calls['fatal']));


        // test
        $subpanel_list = array(
            new aSubPanel('Test', array(), new SugarBeanMock())
        );
        $subpanel_def = null;
        $parentBean = null;
        $order_by = null;
        $GLOBALS['log']->reset();
        $results = SugarBeanMock::publicBuildSubQueriesForUnion($subpanel_list, $subpanel_def, $parentBean, $order_by);
        self::assertEquals(array(
            array(
                'select' => ' , \'Test\' panel_name ',
                'query_array' => null,
                'params' => array(
                    'distinct' => false,
                    'joined_tables' => null,
                    'include_custom_fields' => null,
                    'collection_list' => null,
                ),
            ),
            ), $results);
        self::assertCount(6, $GLOBALS['log']->calls['fatal']);


        // test
        $subpanel_list = array(
            1
        );
        $subpanel_def = null;
        $parentBean = null;
        $order_by = null;
        $GLOBALS['log']->reset();
        $results = SugarBeanMock::publicBuildSubQueriesForUnion($subpanel_list, $subpanel_def, $parentBean, $order_by);
        self::assertEquals(array(), $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);


        // test
        $subpanel_list = null;
        $subpanel_def = null;
        $parentBean = null;
        $order_by = null;
        $GLOBALS['log']->reset();
        $results = SugarBeanMock::publicBuildSubQueriesForUnion($subpanel_list, $subpanel_def, $parentBean, $order_by);
        self::assertEquals(array(), $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);
    }

    /**
     * @see SugarBean::process_union_list_query()
     */
    public function testProcessUnionListQuery()
    {
        self::markTestIncomplete('environment dependency');

        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('tracker');

        // test
        global $sugar_config;

        $query = "SELECT * FROM aod_index";
        $resource = DBManagerFactory::getInstance()->query($query);
        $rows = [];
        while ($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        }
        $tableAodIndex = $rows;

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_0';
        $bean->save();
        $query = /** @lang sql */
            "INSERT INTO contacts (id) VALUES ('test_contact_1'), ('test_contact_2'), ('test_contact_3')";
        $this->db->query($query);
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $tmp = $sugar_config['list_max_entries_per_subpanel'];
        $sugar_config['list_max_entries_per_subpanel'] = 0;
        $results = $bean->process_union_list_query($bean, /** @lang sql */ 'SELECT DISTINCT count(*) AS c FROM contacts', null, 0, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));

        self::assertEquals(array(), $results['list']);
        self::assertEquals(array(), $results['parent_data']);
        self::assertNotEquals(0, $results['row_count']);
        self::assertEquals(0, $results['next_offset']);
        self::assertEquals(0, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT count(*) AS c FROM contacts', $results['query']);

        $query = /** @lang sql */
            "DELETE FROM contacts WHERE id IN ('test_contact_0', 'test_contact_1', 'test_contact_2', 'test_contact_3')";
        $this->db->query($query);
        $sugar_config['list_max_entries_per_subpanel'] = $tmp;


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_0';
        $bean->save();
        $query = /** @lang sql */
            "INSERT INTO contacts (id) VALUES ('test_contact_1'), ('test_contact_2'), ('test_contact_3')";
        $this->db->query($query);
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $subpanelDefinition->_instance_properties['type'] = 'collection';
        $results = $bean->process_union_list_query($bean, /** @lang sql */ 'SELECT DISTINCT count(*) AS c FROM contacts', null, -1, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));

        self::assertEquals(array(), $results['parent_data']);
        self::assertNotEquals(0, $results['row_count']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT count(*) AS c FROM contacts', $results['query']);

        $query = /** @lang text */
            "DELETE FROM contacts WHERE id IN ('test_contact_0', 'test_contact_1', 'test_contact_2', 'test_contact_3')";
        $this->db->query($query);


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_0';
        $bean->save();
        $query = /** @lang text */
            "INSERT INTO contacts (id) VALUES ('test_contact_1'), ('test_contact_2'), ('test_contact_3')";
        $this->db->query($query);
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $subpanelDefinition->_instance_properties['type'] = 'collection';
        $results = $bean->process_union_list_query($bean, /** @lang sql */ 'SELECT DISTINCT count(*) AS c FROM contacts', null, -1, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertNotEquals(0, $results['row_count']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT count(*) AS c FROM contacts', $results['query']);

        $query = /** @lang text */
            "DELETE FROM contacts WHERE id IN ('test_contact_0', 'test_contact_1', 'test_contact_2', 'test_contact_3')";
        $this->db->query($query);


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_0';
        $bean->save();
        $query = /** @lang text */
            "INSERT INTO contacts (id) VALUES ('test_contact_1'), ('test_contact_2'), ('test_contact_3')";
        $this->db->query($query);
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $subpanelDefinition->_instance_properties['type'] = 'collection';
        $results = $bean->process_union_list_query($bean, /** @lang sql */ 'SELECT DISTINCT count(*) AS c FROM contacts', null, -1, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertNotEquals(0, $results['row_count']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT count(*) AS c FROM contacts', $results['query']);

        $query = /** @lang text */
            "DELETE FROM contacts WHERE id IN ('test_contact_0', 'test_contact_1', 'test_contact_2', 'test_contact_3')";
        $this->db->query($query);


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_0';
        $bean->save();
        $query = /** @lang text */
            "INSERT INTO contacts (id) VALUES ('test_contact_1'), ('test_contact_2'), ('test_contact_3')";
        $this->db->query($query);
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $results = $bean->process_union_list_query($bean, /** @lang sql */ 'SELECT DISTINCT count(*) AS c FROM contacts', null, -1, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertNotEquals(0, $results['row_count']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT count(*) AS c FROM contacts', $results['query']);

        $query = /** @lang text */
            "DELETE FROM contacts WHERE id IN ('test_contact_0', 'test_contact_1', 'test_contact_2', 'test_contact_3')";
        $this->db->query($query);


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_0';
        $bean->save();
        $query = /** @lang text */
            "INSERT INTO contacts (id) VALUES ('test_contact_1'), ('test_contact_2'), ('test_contact_3')";
        $this->db->query($query);
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $subpanelDefinition->template_instance = $bean;
        $results = $bean->process_union_list_query($bean, /** @lang sql */ 'SELECT DISTINCT count(*) AS c FROM contacts', null, -1, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertNotEquals(0, $results['row_count']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT count(*) AS c FROM contacts', $results['query']);

        $query = /** @lang text */
            "DELETE FROM contacts WHERE id IN ('test_contact_0', 'test_contact_1', 'test_contact_2', 'test_contact_3')";
        $this->db->query($query);


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_0';
        $bean->save();
        $query = /** @lang text */
            "INSERT INTO contacts (id) VALUES ('test_contact_1'), ('test_contact_2'), ('test_contact_3')";
        $this->db->query($query);
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $results = $bean->process_union_list_query(null, /** @lang sql */ 'SELECT DISTINCT count(*) AS c FROM contacts', null, -1, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertNotEquals(0, $results['row_count']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT count(*) AS c FROM contacts', $results['query']);

        $query = /** @lang text */
            "DELETE FROM contacts WHERE id IN ('test_contact_0', 'test_contact_1', 'test_contact_2', 'test_contact_3')";
        $this->db->query($query);


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact1';
        $bean->save();
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $results = $bean->process_union_list_query(null, /** @lang sql */ 'SELECT DISTINCT * FROM contacts', null, -1, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT * FROM contacts', $results['query']);


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact1';
        $bean->save();
        $results = $bean->process_union_list_query(null, /** @lang sql */ 'SELECT DISTINCT * FROM contacts', null);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT * FROM contacts', $results['query']);


        // test
        $GLOBALS['log']->reset();
        $bean = new SugarBeanMock();
        try {
            $results = $bean->process_union_list_query(null, 'DISTINCT', null);
            self::assertTrue(false);
        } catch (Exception $e) {
            self::assertTrue(true);
            self::assertEquals(1, $e->getCode());
        }
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT * FROM contacts', $results['query']);


        // test
        $GLOBALS['log']->reset();
        $bean = new SugarBeanMock();
        $results = $bean->process_union_list_query(null, null, null);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            null, $results['query']);


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->retrieve('test_contact1');
        $results = $bean->process_union_list_query(null, /** @lang sql */ 'SELECT DISTINCT * FROM contacts', 'end');
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertEquals(9.0, $results['next_offset']);
        self::assertEquals(-11.0, $results['previous_offset']);
        self::assertEquals(-1.0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT * FROM contacts', $results['query']);


        // test
        $sugar_config['disable_count_query'] = 1;
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_0';
        $bean->save();
        $query = /** @lang text */
            "INSERT INTO contacts (id) VALUES ('test_contact_1'), ('test_contact_2'), ('test_contact_3')";
        $this->db->query($query);
        $subpanelDefinition = new aSubPanel('TestPanel', array(), $bean);
        $results = $bean->process_union_list_query(null, /** @lang sql */ 'SELECT DISTINCT count(*) AS c FROM contacts', null, -1, -1, '', $subpanelDefinition);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));
        self::assertEquals(array(), $results['parent_data']);
        self::assertNotEquals(0, $results['row_count']);
        self::assertEquals(10, $results['next_offset']);
        self::assertEquals(-10, $results['previous_offset']);
        self::assertEquals(0, $results['current_offset']);
        self::assertEquals(/** @lang sql */
            'SELECT DISTINCT count(*) AS c FROM contacts', $results['query']);

        $query = /** @lang text */
            "DELETE FROM contacts WHERE id IN ('test_contact_0', 'test_contact_1', 'test_contact_2', 'test_contact_3')";
        $this->db->query($query);

        // cleanup
        $this->db->query("DELETE FROM sugarfeed WHERE related_id LIKE 'test_contact%'");
        $this->db->query("DELETE FROM contacts_cstm WHERE id_c LIKE 'test_contact%'");

        $this->db->query("DELETE FROM aod_index");
        foreach ($tableAodIndex as $row) {
            $query = "INSERT aod_index INTO (";
            $query .= (implode(',', array_keys($row)) . ') VALUES (');
            foreach ($row as $value) {
                $quoteds[] = "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }

        // clean up

        $state->popTable('tracker');
        $state->popTable('aod_index');
    }

    /**
     * @see SugarBean::_get_num_rows_in_query()
     */
    public function testGetNumRowsInQuery()
    {
        self::markTestIncomplete('already covered');
    }

    /**
     * @see SugarBean::retrieve_parent_fields()
     */
    public function testRetrieveParentFields()
    {
        $GLOBALS['log']->reset();

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(null);
        self::assertEquals(array(), $results);

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(array(1));
        self::assertEquals(array(), $results);

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(array(array(array('type' => 'parent'))));
        self::assertEquals(array(), $results);

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(array(
            array(
                array(
                    'type' => 'parent',
                    'parent_type' => 1,
                )
            )
        ));
        self::assertEquals(array(), $results);

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(array(
            array(
                array(
                    'type' => 'parent',
                    'parent_type' => 'test',
                )
            )
        ));
        self::assertEquals(array(), $results);

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(array(
            array(
                array(
                    'type' => 'parent',
                    'parent_type' => 'test',
                )
            )
        ));
        self::assertEquals(array(), $results);

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(array(
            array(
                array(
                    'type' => 'parent',
                    'parent_type' => 'Contacts',
                )
            )
        ));
        self::assertEquals(array(), $results);

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(array(
            array(
                array(
                    'type' => 'parent',
                    'parent_id' => 1,
                )
            )
        ));
        self::assertEquals(array(), $results);

        // test
        $bean = new SugarBeanMock();
        $results = $bean->retrieve_parent_fields(array(
            array(
                array(
                    'type' => 'parent',
                    'parent_id' => 1,
                    'parent_type' => 'Contacts',
                )
            )
        ));
        self::assertEquals(array(), $results);


        // test
        $bean = new SugarBeanMock();

        $this->db->query(/** @lang sql */
            "INSERT INTO contacts (id, date_entered, date_modified, modified_user_id, created_by, description, deleted, assigned_user_id, salutation, first_name, last_name, title, photo, department, do_not_call, phone_home, phone_mobile, phone_work, phone_other, phone_fax, primary_address_street, primary_address_city, primary_address_state, primary_address_postalcode, primary_address_country, alt_address_street, alt_address_city, alt_address_state, alt_address_postalcode, alt_address_country, assistant, assistant_phone, lead_source, reports_to_id, birthdate, campaign_id, joomla_account_id, portal_account_disabled, portal_user_type) VALUES ('test_parent_contact_1', '2017-08-04 00:00:11', '2017-08-11 00:00:22', 'aaa', 'bbb', 'ccc', '0', 'eee', 'fff', 'ggg', 'hhh', 'jjj', 'kkk', 'lll', '1', 'mmm', 'nnn', 'ooo', 'ppp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Single');");
        $results = $bean->retrieve_parent_fields(array(
            array(
                array(
                    'type' => 'parent',
                    'parent_id' => 'test_parent_contact_1',
                    'parent_type' => 'Contacts',
                )
            )
        ));
        self::assertEquals(array(
            '' => array(
                'id' => 'test_parent_contact_1',
                'parent_name' => 'ggg hhh',
                'parent_name_owner' => 'eee',
                'parent_name_mod' => 'Contacts',
            ),
            ), $results);
        $this->db->query(/** @lang sql */
            "DELETE FROM contacts WHERE id = 'test_parent_contact_1'");
    }

    /**
     * @see SugarBean::getAuditEnabledFieldDefinitions()
     */
    public function testGetAuditEnabledFieldDefinitions()
    {
        $GLOBALS['log']->reset();

        // test
        $bean = new SugarBeanMock();
        $results = $bean->getAuditEnabledFieldDefinitions();
        self::assertEquals(array(), $results);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getAuditEnabledFieldDefinitions();
        self::assertEquals(array(
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'rname' => 'user_name',
                'id_name' => 'assigned_user_id',
                'vname' => 'LBL_ASSIGNED_TO_ID',
                'group' => 'assigned_user_name',
                'type' => 'relate',
                'table' => 'users',
                'module' => 'Users',
                'reportable' => true,
                'isnull' => 'false',
                'dbType' => 'id',
                'audited' => true,
                'comment' => 'User ID assigned to record',
                'duplicate_merge' => 'disabled',
            ),
            'do_not_call' => array(
                'name' => 'do_not_call',
                'vname' => 'LBL_DO_NOT_CALL',
                'type' => 'bool',
                'default' => '0',
                'audited' => true,
                'comment' => 'An indicator of whether contact can be called',
            ),
            'phone_work' => array(
                'name' => 'phone_work',
                'vname' => 'LBL_OFFICE_PHONE',
                'type' => 'phone',
                'dbType' => 'varchar',
                'len' => 100,
                'audited' => true,
                'unified_search' => true,
                'full_text_search' => array(
                    'boost' => 1
                ),
                'comment' => 'Work phone number of the contact',
                'merge_filter' => 'enabled',
            ),
            'lawful_basis' => array(
                'name' => 'lawful_basis',
                'vname' => 'LBL_LAWFUL_BASIS',
                'type' => 'multienum',
                'massupdate' => true,
                'no_default' => false,
                'comments' => '',
                'inline_edit' => true,
                'reportable' => true,
                'merge_filter' => 'enabled',
                'len' => 100,
                'size' => '20',
                'options' => 'lawful_basis_dom',
                'audited' => true,
                'importable' => true,
            ),
            'date_reviewed' => array(
                'name' => 'date_reviewed',
                'vname' => 'LBL_DATE_REVIEWED',
                'type' => 'date',
                'massupdate' => true,
                'audited' => true,
                'importable' => true,
            ),
            'lawful_basis_source' => array(
                'name' => 'lawful_basis_source',
                'vname' => 'LBL_LAWFUL_BASIS_SOURCE',
                'type' => 'enum',
                'massupdate' => true,
                'no_default' => false,
                'comments' => '',
                'inline_edit' => true,
                'reportable' => true,
                'merge_filter' => 'enabled',
                'len' => 100,
                'size' => '20',
                'options' => 'lawful_basis_source_dom',
                'audited' => true,
                'importable' => true,
            ),
            ), $results);
    }

    /**
     * @see SugarBean::isOwner()
     */
    public function testIsOwner()
    {

        // test
        $GLOBALS['log']->reset();
        $bean = new SugarBeanMock();
        $result = $bean->isOwner(null);
        self::assertTrue($result);
        self::assertEquals('', $bean->id);

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_1';
        $result = $bean->isOwner(null);
        self::assertFalse($result);
        self::assertEquals('test_contact_1', $bean->id);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_1';
        $bean->fetched_row['assigned_user_id'] = 1;
        $result = $bean->isOwner(null);
        self::assertFalse($result);
        self::assertEquals('test_contact_1', $bean->id);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_1';
        $bean->fetched_row['assigned_user_id'] = 1;
        $result = $bean->isOwner(1);
        self::assertTrue($result);
        self::assertEquals('test_contact_1', $bean->id);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_1';
        $bean->assigned_user_id = 1;
        $result = $bean->isOwner(1);
        self::assertTrue($result);
        self::assertEquals('test_contact_1', $bean->id);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_1';
        $bean->assigned_user_id = 1;
        $result = $bean->isOwner(2);
        self::assertFalse($result);
        self::assertEquals('test_contact_1', $bean->id);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_1';
        $bean->created_by = 1;
        $result = $bean->isOwner(1);
        self::assertTrue($result);
        self::assertEquals('test_contact_1', $bean->id);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));
    }

    /**
     * @see SugarBean::get_custom_table_name()
     */
    public function testGetCustomTableName()
    {

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $result = $bean->get_custom_table_name();
        self::assertEquals('contacts_cstm', $result);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));
    }

    /**
     * @see SugarBean::getTableName()
     */
    public function testGetTableName()
    {
        // test
        $GLOBALS['log']->reset();
        $bean = new SugarBeanMock();
        $result = $bean->getTableName();
        self::assertEquals('', $result);

        // test
        $GLOBALS['log']->reset();
        $bean = new SugarBeanMock();
        unset($bean->table_name);
        $result = $bean->getTableName();
        self::assertEquals('', $result);

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $result = $bean->getTableName();
        self::assertEquals('contacts', $result);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));
    }

    /**
     * @see SugarBean::getObjectName()
     */
    public function testGetObjectName()
    {

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $result = $bean->getObjectName();
        self::assertEquals('Contact', $result);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));


        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        unset($bean->table_name);
        $result = $bean->getObjectName();
        self::assertEquals('Contact', $result);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        unset($bean->object_name);
        $result = $bean->getObjectName();
        self::assertEquals(null, $result);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->object_name = false;
        $result = $bean->getObjectName();
        self::assertEquals('contacts', $result);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));
    }

    /**
     * @see SugarBean::getIndices()
     */
    public function testGetIndices()
    {

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $bean->object_name = false;
        $results = $bean->getIndices();
        self::assertEquals(array(), $results);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getIndices();
        self::assertEquals(array(
            'id' => array(
                'name' => 'contactspk',
                'type' => 'primary',
                'fields' => array(
                    0 => 'id',
                ),
            ),
            0 => array(
                'name' => 'idx_cont_last_first',
                'type' => 'index',
                'fields' => array(
                    0 => 'last_name',
                    1 => 'first_name',
                    2 => 'deleted',
                ),
            ),
            1 => array(
                'name' => 'idx_contacts_del_last',
                'type' => 'index',
                'fields' => array(
                    0 => 'deleted',
                    1 => 'last_name',
                ),
            ),
            2 => array(
                'name' => 'idx_cont_del_reports',
                'type' => 'index',
                'fields' => array(
                    0 => 'deleted',
                    1 => 'reports_to_id',
                    2 => 'last_name',
                ),
            ),
            3 => array(
                'name' => 'idx_reports_to_id',
                'type' => 'index',
                'fields' => array(
                    0 => 'reports_to_id',
                ),
            ),
            4 => array(
                'name' => 'idx_del_id_user',
                'type' => 'index',
                'fields' => array(
                    0 => 'deleted',
                    1 => 'id',
                    2 => 'assigned_user_id',
                ),
            ),
            5 => array(
                'name' => 'idx_cont_assigned',
                'type' => 'index',
                'fields' => array(
                    0 => 'assigned_user_id',
                ),
            ),
            ), $results);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));
    }

    /**
     * @see SugarBean::getPrimaryFieldDefinition()
     */
    public function testGetPrimaryFieldDefinition()
    {

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getPrimaryFieldDefinition();
        self::assertEquals(array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier',
            'inline_edit' => false,
            ), $results);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Contacts');
        unset($bean->field_defs['id']);
        $results = $bean->getPrimaryFieldDefinition();
        self::assertEquals(array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'rname' => 'name',
            'link' => true,
            'fields' => array(
                0 => 'first_name',
                1 => 'last_name',
            ),
            'sort_on' => 'last_name',
            'source' => 'non-db',
            'group' => 'last_name',
            'len' => '255',
            'db_concat_fields' => array(
                0 => 'first_name',
                1 => 'last_name',
            ),
            'importable' => 'false',
            ), $results);
        self::assertFalse(isset($GLOBALS['log']->calls['fatal']));
    }

    /**
     * @see SugarBean::getFieldDefinition()
     */
    public function testGetFieldDefinition()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getFieldDefinition(null);
        self::assertFalse($results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getFieldDefinition('undefined');
        self::assertFalse($results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);


        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getFieldDefinition('name');
        self::assertEquals(array(
            'name' => 'name',
            'rname' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'link' => true,
            'fields' => array(
                0 => 'first_name',
                1 => 'last_name',
            ),
            'sort_on' => 'last_name',
            'source' => 'non-db',
            'group' => 'last_name',
            'len' => '255',
            'db_concat_fields' => array(
                0 => 'first_name',
                1 => 'last_name',
            ),
            'importable' => 'false',
            ), $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);
    }

    /**
     * @see SugarBean::getFieldValue()
     */
    public function testGetFieldValue()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getFieldValue(null);
        self::assertFalse($results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getFieldValue('importable');
        self::assertEquals(1, $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getFieldValue('in_workflow');
        self::assertEquals(0, $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getFieldValue('portal_user_type');
        self::assertEquals('Single', $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);
    }

    /**
     * @see SugarBean::unPopulateDefaultValues()
     */
    public function testUnPopulateDefaultValues()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->unPopulateDefaultValues();
        self::assertEquals(null, $results);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals(null, $bean->portal_user_type);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals(null, $bean->jjwg_maps_lat_c);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals(null, $bean->jjwg_maps_lng_c);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs = false;
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->unPopulateDefaultValues();
        self::assertEquals(null, $results);
        self::assertCount(1, $GLOBALS['log']->calls['fatal']);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->unPopulateDefaultValues();
        self::assertEquals(null, $results);
        self::assertCount(2, $GLOBALS['log']->calls['fatal']);
    }

    /**
     * @see SugarBean::__clone()
     */
    public function testClone()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $clone = clone $bean;
        self::assertEquals($bean, $clone);
        self::assertTrue(isset($GLOBALS['log']->calls['fatal']));

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = new SugarBeanMock();
        $bean->foo = 'bar';
        $bean->setLoadedRelationships(array('foo'));
        $clone = clone $bean;
        self::assertEquals('bar', $bean->foo);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertNotTrue(isset($clone->foo));
        unset($bean->foo);
        self::assertEquals($bean, $clone);
    }

    /**
     * @see SugarBean::load_relationships()
     */
    public function testLoadRelationships()
    {
        self::markTestIncomplete('already covered');
    }

    /**
     * @see SugarBean::get_linked_fields()
     */
    public function testGetLinkedFields()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs = array();
        $results = $bean->get_linked_fields();
        self::assertEquals(array(), $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs = array(1);
        $results = $bean->get_linked_fields();
        self::assertEquals(array(), $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs = array(array(1));
        $results = $bean->get_linked_fields();
        self::assertEquals(array(), $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs = array(array('type' => 'link'));
        $results = $bean->get_linked_fields();
        self::assertEquals(array(
            0 => array(
                'type' => 'link',
            ),
            ), $results);
    }

    /**
     * @see SugarBean::getFieldDefinitions()
     */
    public function testGetFieldDefinitions()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getFieldDefinitions();
        self::assertEquals($bean->field_defs, $results);
    }

    /**
     * @see SugarBean::load_relationship()
     */
    public function testLoadRelationship()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->load_relationship(null);
        self::assertEquals(false, $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->load_relationship('test');
        self::assertEquals(false, $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs['testKey'] = 'testValue';
        $results = $bean->load_relationship('testKey');
        self::assertEquals(false, $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs['testKey'] = 'testValue';
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testKey = new Link2('test', $bean);
        $results = $bean->load_relationship('testKey');
        self::assertEquals(true, $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs['testKey'] = array('type' => 'link');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testKey = 'testValue';
        $results = $bean->load_relationship('testKey');
        self::assertEquals(false, $results);
        /** @noinspection MissingIssetImplementationInspection */
        self::assertNotTrue(isset($bean->testKey));

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs['testKey'] = array(
            'type' => 'link',
            'link_class' => 'testClass',
            'link_file' => 'testClass.php',
        );
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testKey = 'testValue';
        $results = $bean->load_relationship('testKey');
        self::assertEquals(false, $results);
        /** @noinspection MissingIssetImplementationInspection */
        self::assertNotTrue(isset($bean->testKey));

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs['testKey'] = array(
            'type' => 'link',
            'link_class' => 'testClass',
            'link_file' => 'modules/Campaigns/ProspectLink.php',
        );
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testKey = 'testValue';
        $results = $bean->load_relationship('testKey');
        self::assertEquals(true, $results);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('testValue', $bean->testKey);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs['testKey'] = array(
            'type' => 'link',
            'link_class' => 'ProspectLink',
            'link_file' => 'modules/Campaigns/ProspectLink.php',
        );
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testKey = 'testValue';
        $results = $bean->load_relationship('testKey');
        self::assertEquals(true, $results);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('testValue', $bean->testKey);


        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs['testKey'] = array(
            'type' => 'link',
            'link_class' => 'ProspectLink',
            'link_file' => 'modules/Campaigns/ProspectLink.php',
            'relationship' => 'campaign_leads',
        );
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testKey = 'testValue';
        $results = $bean->load_relationship('testKey');
        self::assertEquals(false, $results);
        /** @noinspection MissingIssetImplementationInspection */
        self::assertNotTrue(isset($bean->testKey));
    }

    /**
     * @see SugarBean::get_linked_beans()
     */
    public function testGetLinkedBeans()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->get_linked_beans(null);
        self::assertEquals(array(), $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->get_linked_beans(null, 'Case');
        self::assertEquals(array(), $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testKey = new ProspectLink('test', $bean);
        $results = $bean->get_linked_beans('testKey', 'Case');
        self::assertEquals(array(), $results);

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testKey = new ProspectLink('test', $bean);
        $results = $bean->get_linked_beans('testKey', 'Case', '', 0, 1);
        self::assertEquals(array(), $results);
    }

    /**
     * @see SugarBean::get_import_required_fields()
     */
    public function testGetImportRequiredFields()
    {

        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs = array();
        $results = $bean->get_import_required_fields();
        self::assertEquals(array(), $results);
    }

    /**
     * @see SugarBean::get_importable_fields()
     */
    public function testGetImportableFields()
    {
        // test
        $GLOBALS['log']->reset();
        $GLOBALS['log']->fatal('test');
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs = array();
        $results = $bean->get_importable_fields();
        self::assertEquals(array(), $results);
    }

    /**
     * @see SugarBean::create_tables()
     */
    public function testCreateTables()
    {

        // test
        $bean = BeanFactory::getBean('Contacts');
        ob_start();
        $bean->create_tables();
        $results = ob_get_contents();
        ob_get_clean();
        self::assertEquals(/** @lang text */
            "Table already exists : $bean->table_name<br>", $results);
    }

    /**
     * @see SugarBean::getACLCategory()
     */
    public function testGetACLCategory()
    {
        // test
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->getACLCategory();
        self::assertEquals(null !== $bean->acl_category ? $bean->acl_category : $bean->module_dir, $results);
    }

    /**
     * @see SugarBean::is_AuditEnabled()
     */
    public function testIsAuditEnabled()
    {

        // test
        $bean = new SugarBeanMock();
        $results = $bean->is_AuditEnabled();
        self::assertEquals(false, $results);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->is_AuditEnabled();
        self::assertEquals(true, $results);
    }

    /**
     * @see SugarBean::get_audit_table_name()
     */
    public function testGetAuditTableNames()
    {

        // test
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->get_audit_table_name();
        self::assertEquals('contacts_audit', $results);
    }

    /**
     * @see SugarBean::create_audit_table()
     */
    public function testCreateAuditTable()
    {
        $query = /** @lang sql */
            'DROP TABLE contacts_audit;';
        $this->db->query($query);

        // test
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $results = $bean->create_audit_table();
        self::assertEquals(null, $results);
    }

    /**
     * @see SugarBean::drop_tables()
     */
    public function testDropTables()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::save()
     */
    public function testSave()
    {
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('tracker');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user;

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Users');
        $results = null;
        try {
            $results = $bean->save();
            self::assertTrue(false);
        } catch (Exception $e) {
            self::assertTrue(true);
        }
        self::assertNotTrue(isValidId($results));

        self::assertEquals(true, $bean->in_save);
        self::assertEquals(null, $bean->date_modified);
        self::assertEquals($current_user->id, $bean->modified_user_id);
        self::assertEquals($current_user->user_name, $bean->modified_by_name);
        self::assertEquals(0, $bean->deleted);
        self::assertEquals($bean->date_modified, $bean->date_entered);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertEquals(isset($current_user) ? $current_user->id : '', $bean->created_by);
        self::assertNotTrue(isValidId($bean->id));
        self::assertEquals($bean, $bean->custom_fields->bean);
        self::assertEquals(false, $bean->new_with_id);
        //self::assertEquals(null, $bean->old_modified_by_name);
        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Users');
        $bean->new_with_id = true;
        $results = null;
        try {
            $results = $bean->save();
            self::assertTrue(false);
        } catch (Exception $e) {
        }
        self::assertFalse(isValidId($results));

        self::assertEquals(true, $bean->in_save);
        self::assertEquals(null, $bean->date_modified);
        self::assertEquals($current_user->id, $bean->modified_user_id);
        self::assertEquals($current_user->user_name, $bean->modified_by_name);
        self::assertEquals(0, $bean->deleted);
        self::assertEquals($bean->date_modified, $bean->date_entered);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertEquals(isset($current_user) ? $current_user->id : '', $bean->created_by);
        self::assertFalse(isValidId($bean->id));
        self::assertEquals($bean, $bean->custom_fields->bean);
        self::assertEquals(true, $bean->new_with_id);
        self::assertEquals($bean->modified_by_name, $bean->old_modified_by_name);

        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Users');
        $bean->new_with_id = true;
        $bean->modified_by_name = 'testing';
        $results = null;
        try {
            $results = $bean->save();
            self::assertTrue(false);
        } catch (Exception $e) {
        }
        self::assertFalse(isValidId($results));

        self::assertEquals(true, $bean->in_save);
        //self::assertEquals(null, $bean->date_modified);
        self::assertEquals($current_user->id, $bean->modified_user_id);
        //self::assertEquals('testing', $bean->modified_by_name);
        self::assertEquals(0, $bean->deleted);
        self::assertEquals($bean->date_modified, $bean->date_entered);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertEquals(isset($current_user) ? $current_user->id : '', $bean->created_by);
        self::assertFalse(isValidId($bean->id));
        self::assertEquals($bean, $bean->custom_fields->bean);
        self::assertEquals(true, $bean->new_with_id);
        //self::assertEquals(null, $bean->old_modified_by_name);
        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Users');
        $bean->id = 'testBean_1';
        $bean->modified_by_name = 'testing';
        $results = null;
        try {
            $results = $bean->save();
            self::assertTrue(false);
        } catch (Exception $e) {
            self::assertTrue(true);
        }
        self::assertFalse(isValidId($results));

        //self::assertEquals(true, $bean->in_save);
        //self::assertEquals(null, $bean->date_modified);
        self::assertEquals($current_user->id, $bean->modified_user_id);
        //self::assertEquals('testing', $bean->modified_by_name);
        self::assertEquals(0, $bean->deleted);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertFalse(isset($bean->date_entered));
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertEquals(isset($current_user) ? $current_user->id : '', $bean->created_by);
        self::assertFalse(isValidId($bean->id));
        self::assertEquals($bean, $bean->custom_fields->bean);
        self::assertEquals(false, $bean->new_with_id);
        //self::assertEquals(null, $bean->old_modified_by_name);
        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Users');
        $bean->id = 'testBean_1';
        $bean->modified_by_name = 'testing';
        $bean->field_defs = array(
            'email_addresses' => array(
                'type' => 'link',
            ),
            'email_addresses_non_primary' => array(
                'type' => 'email',
            ),
        );
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->email_addresses_non_primary = array(true);
        $results = null;
        try {
            $results = $bean->save();
            self::assertTrue(false);
        } catch (Exception $e) {
            self::assertTrue(true);
        }
        self::assertFalse(isValidId($results));

        self::assertEquals(null, $bean->in_save);
        //self::assertEquals(null, $bean->date_modified);
        self::assertEquals($current_user->id, $bean->modified_user_id);
        //self::assertEquals('testing', $bean->modified_by_name);
        self::assertEquals($current_user->user_name, null);
        self::assertEquals(0, $bean->deleted);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertFalse(isset($bean->date_entered));
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertEquals(isset($current_user) ? $current_user->id : '', $bean->created_by);
        self::assertFalse(isValidId($bean->id));
        self::assertEquals($bean, $bean->custom_fields->bean);
        self::assertEquals(false, $bean->new_with_id);
        //self::assertEquals(null, $bean->old_modified_by_name);
        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Users');
        $bean->id = 'testBean_1';
        $bean->modified_by_name = 'testing';
        $bean->field_defs = array(
            'email_addresses' => array(
                'type' => 'link',
            ),
            'email_addresses_non_primary' => array(
                'type' => 'email',
            ),
        );
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->emailAddress = new EmailAddress();
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->email_addresses_non_primary = array(true);
        $results = null;
        try {
            $results = $bean->save();
            self::assertTrue(false);
        } catch (Exception $e) {
        }
        self::assertFalse(isValidId($results));

        self::assertEquals(false, $bean->in_save);
        //self::assertEquals(null, $bean->date_modified);
        self::assertEquals($current_user->id, $bean->modified_user_id);
        //self::assertEquals('testing', $bean->modified_by_name);
        self::assertEquals($current_user->user_name, null);
        self::assertEquals(0, $bean->deleted);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertFalse(isset($bean->date_entered));
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertEquals(isset($current_user) ? $current_user->id : '', $bean->created_by);
        self::assertFalse(isValidId($bean->id));
        self::assertEquals($bean, $bean->custom_fields->bean);
        self::assertEquals(false, $bean->new_with_id);
        //self::assertEquals(null, $bean->old_modified_by_name);
        // test
        $GLOBALS['log']->reset();
        $bean = BeanFactory::getBean('Users');
        $bean->id = 'testBean_1';
        $bean->modified_by_name = 'testing';
        $bean->field_defs = array(
            'email_addresses' => array(
                'type' => 'link',
            ),
            'email_addresses_non_primary' => array(
                'type' => 'email',
            ),
        );
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->emailAddress = new EmailAddress();
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->email_addresses_non_primary = array(true);
        $results = null;
        try {
            $results = $bean->save();
            self::assertTrue(false);
        } catch (Exception $e) {
        }
        self::assertFalse(isValidId($results));

        self::assertEquals(false, $bean->in_save);
        //self::assertEquals(null, $bean->date_modified);
        self::assertEquals($current_user->id, $bean->modified_user_id);
        //self::assertEquals('testing', $bean->modified_by_name);
        self::assertEquals($current_user->user_name, null);
        self::assertEquals(0, $bean->deleted);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertFalse(isset($bean->date_entered));
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertEquals(isset($current_user) ? $current_user->id : '', $bean->created_by);
        self::assertFalse(isValidId($bean->id));
        self::assertEquals($bean, $bean->custom_fields->bean);
        self::assertEquals(false, $bean->new_with_id);
        //self::assertEquals(null, $bean->old_modified_by_name);
        // test
        $GLOBALS['log']->reset();
        $this->fieldDefsStore('temp1');
        $this->fieldDefsRestore();
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'testBean_1';
        $bean->modified_by_name = 'testing';
        $bean->field_defs = array_merge($bean->field_defs, $bean->field_defs = array(
            'email_addresses' => array(
                'type' => 'link',
            ),
            'email_addresses_non_primary' => array(
                'type' => 'email',
            ),
        ));
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->emailAddress = new EmailAddress();
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->email_addresses_non_primary = array('testbean1@email.com');
        $results = null;
        try {
            $results = $bean->save();
            self::assertTrue(false);
        } catch (Exception $e) {
        }
        self::assertFalse(isValidId($results));

        self::assertEquals(false, $bean->in_save);
        self::assertEquals($GLOBALS['timedate']->nowDb(), $bean->date_modified);
        self::assertEquals($current_user->id, $bean->modified_user_id);
        self::assertEquals($current_user->user_name, $bean->modified_by_name);
        self::assertEquals(0, $bean->deleted);
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertFalse(isset($bean->date_entered));
        /** @noinspection UnSafeIsSetOverArrayInspection */
        self::assertEquals(isset($current_user) ? $current_user->id : '', $bean->created_by);
        self::assertFalse(isValidId($bean->id));
        self::assertEquals($bean, $bean->custom_fields->bean);
        self::assertEquals(false, $bean->new_with_id);
        self::assertEquals('testing', $bean->old_modified_by_name);

        $this->fieldDefsRestore('temp1', true);

        // cleanup
        $this->db->query("DELETE FROM sugarfeed WHERE related_id LIKE 'testBean_1'");
        $this->db->query("DELETE FROM contacts_cstm WHERE id_c LIKE 'testBean_1'");
        $this->db->query("DELETE FROM email_addr_bean_rel WHERE bean_id LIKE 'testBean_1'");
        $this->db->query("DELETE FROM email_addresses WHERE email_address LIKE 'testbean1@email.com'");

        // clean up

        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('tracker');
    }

    /**
     * @see SugarBean::cleanBean()
     */
    public function testCleanBean()
    {
        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->field_defs['testField'] = array('type' => 'html');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField = '<p>test <b>html</b> value</p>';
        $bean->cleanBean();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('&lt;p&gt;test &lt;b&gt;html&lt;/b&gt; value&lt;/p&gt;', $bean->testField);
    }

    /**
     * @see SugarBean::fixUpFormatting()
     */
    public function testFixUpFormatting()
    {
        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->fixUpFormatting();

        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'datetime');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'NULL';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('', $bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'datetime');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'invalid-format';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('', $bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'date');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'NULL';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('', $bean->testField1);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'date');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'invalid-format';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('', $bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'time');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'NULL';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('', $bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'time');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'invalid-format';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('invalid-format', $bean->testField1);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'time');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'am';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('am', $bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'float');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'NULL';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('NULL', $bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'int');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'NULL';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('NULL', $bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'int');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'a string here..';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals(0, $bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = true;
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertTrue($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 1;
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertTrue($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'true';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertTrue($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'TRUE';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertTrue($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'on';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertTrue($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = false;
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertFalse($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = '';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertFalse($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 0;
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertFalse($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = '0';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertFalse($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotNull($bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = null;
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotTrue($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotFalse($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNull($bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'bool');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'NULL';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertTrue($bean->testField1);


        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'encrypt');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = '';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotTrue($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotFalse($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertEquals('', $bean->testField1);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_10';
        $bean->fetched_row['id'] = 'test_contact_10';
        $bean->field_defs['testField1'] = array('type' => 'encrypt');
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->testField1 = 'a test string value';
        $bean->fixUpFormatting();
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotTrue($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotFalse($bean->testField1);
        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNotEquals('', $bean->testField1);
    }

    /**
     * @see SugarBean::encrpyt_before_save()
     */
    public function testEncrpytBeforeSave()
    {
        $bean = BeanFactory::getBean('Contacts');

        $fake = new SugarBeanMock();

        $results = $bean->encrpyt_before_save('test value');
        self::assertEquals(blowfishEncode($fake->getEncryptKeyPublic(), 'test value'), $results);
    }

    /**
     * @see SugarBean::getEncryptKey()
     */
    public function testGetEncryptKey()
    {
        $bean = new SugarBeanMock();
        $results = $bean->getEncryptKeyPublic();
        self::assertEquals(blowfishGetKey('encrypt_field'), $results);
    }

    /**
     * @see SugarBean::_checkOptimisticLocking()
     */
    public function testCheckOptimisticLocking()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::has_been_modified_since()
     */
    public function testHasBeenModifiedSince()
    {

        // test
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->has_been_modified_since(null, null);
        self::assertFalse($results);

        // test
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('wrong1', null);
        self::assertFalse($results);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->has_been_modified_since(null, 'wrong1');
        self::assertFalse($results);

        // test
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('wrong1', 'wrong1');
        self::assertFalse($results);

        // test
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('1900-01-01', null);
        self::assertFalse($results);

        // test
        $bean = BeanFactory::getBean('Contacts');
        $results = $bean->has_been_modified_since(null, '1');
        self::assertFalse($results);

        // test
        $bean = BeanFactory::getBean('Contacts');
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('1900-01-01', '1');
        self::assertFalse($results);

        // test
        $query = /** @lang sql */
            "INSERT INTO contacts (id, modified_user_id, date_modified) VALUES ('test_contact_11', 'test_user_11', '2000-01-01')";
        $this->db->query($query);

        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_11';
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('1999-01-01', 'test_user_12');
        self::assertTrue($results);

        $query = /** @lang sql */
            "DELETE FROM contacts WHERE id = 'test_contact_11'";
        $this->db->query($query);

        // test
        $query = /** @lang sql */
            "INSERT INTO contacts (id, modified_user_id, date_modified) VALUES ('test_contact_11', 'test_user_11', '2000-01-01')";
        $this->db->query($query);

        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_11';
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('2001-01-01', 'test_user_12');
        self::assertTrue($results);

        $query = /** @lang sql */
            "DELETE FROM contacts WHERE id = 'test_contact_11'";
        $this->db->query($query);

        // test
        $query = /** @lang sql */
            "INSERT INTO contacts (id, modified_user_id, date_modified) VALUES ('test_contact_11', 'test_user_11', '2000-01-01')";
        $this->db->query($query);

        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_11';
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('1999-01-01', 'test_user_11');
        self::assertTrue($results);

        $query = /** @lang sql */
            "DELETE FROM contacts WHERE id = 'test_contact_11'";
        $this->db->query($query);

        // test
        $query = /** @lang sql */
            "INSERT INTO contacts (id, modified_user_id, date_modified) VALUES ('test_contact_11', 'test_user_11', '2000-01-01')";
        $this->db->query($query);

        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_11';
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('2001-01-01', 'test_user_11');
        self::assertFalse($results);

        $query = /** @lang sql */
            "DELETE FROM contacts WHERE id = 'test_contact_11'";
        $this->db->query($query);

        // test
        $query = /** @lang sql */
            "INSERT INTO contacts (id, modified_user_id, date_modified) VALUES ('test_contact_11', 'test_user_11', '2000-01-01')";
        $this->db->query($query);

        $bean = BeanFactory::getBean('Contacts');
        $bean->id = 'test_contact_11';
        /** @noinspection PhpParamsInspection */
        $results = $bean->has_been_modified_since('2001-01-01', 'test_user_12');
        self::assertTrue($results);

        $query = /** @lang sql */
            "DELETE FROM contacts WHERE id = 'test_contact_11'";
        $this->db->query($query);
    }

    /**
     * @see SugarBean::toArray()
     */
    public function testToArray()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::save_relationship_changes()
     */
    public function testSaveRelationshipChanges()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::set_relationship_info()
     */
    public function testSetRelationshipInfo()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::handle_preset_relationships()
     */
    public function testHandlePresetRelationships()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::handle_remaining_relate_fields()
     */
    public function testHandleRemainingRelateFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::update_parent_relationships()
     */
    public function testUpdateParentRelationships()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::handle_request_relate()
     */
    public function testHandleRequestRelate()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::call_custom_logic()
     */
    public function testCallCustomLogic()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::hasEmails()
     */
    public function testHasEmails()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::preprocess_fields_on_save()
     */
    public function testPreprocessFieldsOnSave()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::_sendNotifications()
     */
    public function testSendNotifications()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_notification_recipients()
     */
    public function testGetNotificationRecipients()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::send_assignment_notifications()
     */
    public function testSendAssignmentNotifications()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::create_notification_email()
     */
    public function testCreateNotificationEmail()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::track_view()
     */
    public function testTrackView()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_summary_text()
     */
    public function testGetSummaryText()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::add_list_count_joins()
     */
    public function testAddListCountJoins()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_list()
     */
    public function testGetList()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::getOwnerWhere()
     */
    public function testGetOwnerWhere()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_relationship_field()
     */
    public function testGetRelationshipField()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::is_relate_field()
     */
    public function testIsRelateField()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::process_order_by()
     */
    public function testProcessOrderBy()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::process_list_query()
     */
    public function testProcessListQuery()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::create_list_count_query()
     */
    public function testCreateListCountQuery()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::fill_in_additional_list_fields()
     */
    public function testFillInAdditionalListFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_detail()
     */
    public function testGetDetail()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::process_detail_query()
     */
    public function testProcessDetailQuery()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::retrieve()
     */
    public function testRetrieve()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::getCustomJoin()
     */
    public function testGetCustomJoin()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::convertRow()
     */
    public function testConvertRow()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::convertField()
     */
    public function testConvertField()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::populateFromRow()
     */
    public function testPopulateFromRow()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::populateCurrencyFields()
     */
    public function testPopulateCurrencyFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::check_date_relationships_load()
     */
    public function testCheckDateRelationshipsLoad()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::decrypt_after_retrieve()
     */
    public function testDecryptAfterRetrieve()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::fill_in_additional_detail_fields()
     */
    public function testFillInAdditionalDetailFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::fill_in_additional_parent_fields()
     */
    public function testFillInAdditionalParentFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::getRelatedFields()
     */
    public function testGetRelatedFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::fill_in_relationship_fields()
     */
    public function testFillInRelationshipFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::fill_in_link_field()
     */
    public function testFillInLinkField()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_related_fields()
     */
    public function testGetRelatedFieldsSnakeCase()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_related_list()
     */
    public function testGetRelatedList()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_full_list()
     */
    public function testGetFullList()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::process_full_list_query()
     */
    public function testProcessFullListQuery()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::create_index()
     */
    public function testCreateIndex()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::mark_deleted()
     */
    public function testMarkDeleted()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::mark_undeleted()
     */
    public function testMarkUndeleted()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::restoreFiles()
     */
    public function testRestoreFiles()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::haveFiles()
     */
    public function testHaveFiles()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::getFiles()
     */
    public function testGetFiles()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::getFilesFields()
     */
    public function testGetFilesFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::deleteFileDirectory()
     */
    public function testDeleteFileDirectory()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::mark_relationships_deleted()
     */
    public function testMarkRelationshipsDeleted()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::delete_linked()
     */
    public function testDeleteLinked()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::deleteFiles()
     */
    public function testDeleteFiles()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::build_related_list()
     */
    public function testBuildRelatedList()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::build_related_list_where()
     */
    public function testBuildRelatedListWhere()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::build_related_in()
     */
    public function testBuildRelatedIn()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::build_related_list2()
     */
    public function testBuildRelatedList2()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::list_view_parse_additional_sections()
     */
    public function testListViewParseAdditionalSections()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_list_view_data()
     */
    public function testGetListViewData()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_list_view_array()
     */
    public function testGetListViewArray()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::retrieve_by_string_fields()
     */
    public function testRetrieveByStringFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::get_where()
     */
    public function testGetWhere()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::fromArray()
     */
    public function testFromArray()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::process_special_fields()
     */
    public function testProcessSpecialFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::build_generic_where_clause()
     */
    public function testBuildGenericWhereClause()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::parse_additional_headers()
     */
    public function testParseAdditionalHeaders()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::assign_display_fields()
     */
    public function testAssignDisplayFields()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::set_relationship()
     */
    public function testSetRelationship()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::retrieve_relationships()
     */
    public function testRetrieveRelationships()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::loadLayoutDefs()
     */
    public function testLoadLayoutDefs()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::getRealKeyFromCustomFieldAssignedKey()
     */
    public function testGetRealKeyFromCustomFieldAssignedKey()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::getOwnerField()
     */
    public function testGetOwnerField()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::listviewACLHelper()
     */
    public function testListviewACLHelper()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::ACLAccess()
     */
    public function testACLAccess()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::loadFromRow()
     */
    public function testLoadFromRow()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::create_qualified_order_by()
     */
    public function testCreateQualifiedOrderBy()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::add_address_streets()
     */
    public function testAddAddressStreets()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::populateRelatedBean()
     */
    public function testPopulateRelatedBean()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::beforeImportSave()
     */
    public function testBeforeImportSave()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::afterImportSave()
     */
    public function testAfterImportSave()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::create_export_query()
     */
    public function testCreateExportQuery()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::auditBean()
     */
    public function testAuditBean()
    {
        self::markTestIncomplete('need to implement');
    }

    /**
     * @see SugarBean::createAuditRecord()
     */
    public function testCreateAuditRecord()
    {
        self::markTestIncomplete('need to implement');
    }
    
    
    public function testCreateNewListQueryWithCustomVarDefHandlerOverride()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $user->name = 'tester10';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);


        // test
        $tmpUser = BeanFactory::getBean('Users');
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;

        if (!file_exists('custom')) {
            mkdir('custom');
        }
        if (!file_exists('custom/include')) {
            mkdir('custom/include');
        }
        $noCustomIncludeVarDefHandler = false;
        if (!file_exists('custom/include/VarDefHandler')) {
            mkdir('custom/include/VarDefHandler');
            $noCustomIncludeVarDefHandler = true;
        }
        copy('include/VarDefHandler/listvardefoverride.php', 'custom/include/VarDefHandler/listvardefoverride.php');

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));

        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.*  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);


        // clean up
                       
        unlink('custom/include/VarDefHandler/listvardefoverride.php');     
        
        if (!$noCustomIncludeVarDefHandler) {
            rmdir('custom/include/VarDefHandler');
        }
        
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
    }

    public function testCreateNewListQueryWithNoOwnerWhere()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $user->name = 'tester9';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);



        // test

        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        $tmpUser->field_defs['created_by'] = null;

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        $this->assertEmpty($tmpUser->getOwnerWhere($current_user->id));
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.*  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
    }

    public function testCreateNewListQuery()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $fieldDefs = $user->field_defs; // save field defs
        $user->name = 'tester8';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);

        $user->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));

        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.*  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);



        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "foo='bar'";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));

        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.*  FROM users  where (foo='bar' AND  (  (  ( EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "foo='bar'";
        $sugar_config['securitysuite_filter_user_list'] = 1;
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.*  FROM users  where (foo='bar' AND  (  (  ( users.id in (
            select sec.user_id from securitygroups_users sec
            inner join securitygroups_users secu on sec.securitygroup_id = secu.securitygroup_id and secu.deleted = 0
                and secu.user_id = '{$current_user->id}'
            where sec.deleted = 0
        ))  )  ) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = '';
        $sugar_config['securitysuite_filter_user_list'] = 1;
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.*  FROM users  where ( (  (  ( users.id in (
            select sec.user_id from securitygroups_users sec
            inner join securitygroups_users secu on sec.securitygroup_id = secu.securitygroup_id and secu.deleted = 0
                and secu.user_id = '{$current_user->id}'
            where sec.deleted = 0
        ))  )  ) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $results = $bean->create_new_list_query($order_by, $where);
        $this->assertEquals(' SELECT  .*  FROM   where .deleted=0', $results);



        // test
        $prjtpl = new AM_ProjectTemplates_sugar();
        $order_by = '';
        $where = '';
        $results = $prjtpl->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  am_projecttemplates.*  , jt0.user_name modified_by_name , jt0.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt1.user_name created_by_name , jt1.created_by created_by_name_owner  , 'Users' created_by_name_mod,  assigned_user_name  , jt3.user_name assigned_user_name , jt3.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM am_projecttemplates   LEFT JOIN  users jt0 ON am_projecttemplates.modified_user_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0  LEFT JOIN  users jt1 ON am_projecttemplates.created_by=jt1.id AND jt1.deleted=0

 AND jt1.deleted=0 LEFT JOIN users jt2 ON am_projecttemplates.assigned_user_id = jt2.id AND jt2.deleted=0   LEFT JOIN  users jt3 ON am_projecttemplates.assigned_user_id=jt3.id AND jt3.deleted=0

 AND jt3.deleted=0 where ( am_projecttemplates.assigned_user_id ='{$current_user->id}'  AND  (  (  ( am_projecttemplates.assigned_user_id ='{$current_user->id}' )  )  ) ) AND am_projecttemplates.deleted=0", $results);

        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $results = $bean->create_new_list_query($order_by, $where);
        $this->assertEquals(' SELECT  .*  FROM   where .deleted=0', $results);

        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $filter = ['a' => 'b'];
        $results = $bean->create_new_list_query($order_by, $where, $filter);
        $this->assertEquals(' SELECT  .id  FROM   where .deleted=0', $results);


        // test
        $bean = new AM_ProjectTemplates_sugar();
        $order_by = '';
        $where = "foo='bar'";
        $filter = ['a' => 'b'];
        $results = $bean->create_new_list_query($order_by, $where, $filter);
        $this->assertEquals(" SELECT  am_projecttemplates.id , am_projecttemplates.assigned_user_id  FROM am_projecttemplates  where (foo='bar' AND  am_projecttemplates.assigned_user_id ='{$current_user->id}'  AND  (  (  ( am_projecttemplates.assigned_user_id ='{$current_user->id}' )  )  ) ) AND am_projecttemplates.deleted=0", $results);

        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
    }

    public function testCreateNewListQueryWithJoinedTablesInParams()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $fieldDefs = $user->field_defs; // save field defs
        $user->name = 'tester7';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);

        $user->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));

        $filter = [];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.*  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // clean up
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('users');
    }

    public function testCreateNewListQueryWithFiterKeys()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $fieldDefs = $user->field_defs; // save field defs
        $user->name = 'tester6';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);

        $user->field_defs = $fieldDefs; // restore field defs
        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $filter = ['1' => 'b', '2' => 'id', '3' => 'c'];
        $results = $bean->create_new_list_query($order_by, $where, $filter);
        $this->assertEquals(' SELECT  .id  FROM   where .deleted=0', $results);



        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $filter = ['1' => 'b', '2' => 'id', '3' => 'c'];
        $bean->field_defs['c'] = 'd';
        $results = $bean->create_new_list_query($order_by, $where, $filter);
        $this->assertEquals(' SELECT  .id , .c  FROM   where .deleted=0', $results);



        // clean up
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('users');
    }

    public function testCreateNewListQueryForAddRelateField()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $fieldDefs = $user->field_defs; // save field defs
        $user->name = 'tester5';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);

        $user->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));

        $filter = [];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';

        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.*  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
    }

    public function testCreateNewListQueryWithValueAlias()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $fieldDefs = $user->field_defs; // save field defs
        $user->name = 'tester4';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);

        $user->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));

        $filter = []; //['id' => ['force_default']];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';
        $tmpUser->field_defs['id']['alias'] = 'test1';
        $tmpUser->field_defs['id']['force_blank'] = true;

        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.*  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // clean up
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('users');
    }

    public function testCreateNewListQueryWithNoFilterFieldForceDefault()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $fieldDefs = $user->field_defs; // save field defs
        $user->name = 'tester3';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);

        $user->field_defs = $fieldDefs; // restore field defs
        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
    }

    public function testCreateNewListQueryWithFilterFieldForceDefault()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('users');
        $state->pushTable('user_preferences');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $fieldDefs = $user->field_defs; // save field defs
        $user->name = 'tester2';
        $user->user_name = 'tester2';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);

        $user->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));

        $filter = ['id' => ['force_blank' => true, 'force_exists' => true, 'force_default' => true]];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';
        $tmpUser->field_defs['id']['alias'] = 'test1';
        $tmpUser->field_defs['id']['force_blank'] = true;

        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.id , 1 id  FROM users  where ( (  (  ( EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // clean up
        $state->popGlobals();
        $state->popTable('user_preferences');
        $state->popTable('users');
        $state->popTable('aod_index');
    }

    public function testCreateNewListQueryWithDataSource()
    {

        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test

        global $current_user, $sugar_config;

        // test
        $user = BeanFactory::getBean('Users');
        $fieldDefs = $user->field_defs; // save field defs
        $user->name = 'tester';
        $user->save();
        $current_user = $user;

        $this->assertNotEmpty($current_user->id);

        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);

        $user->field_defs = $fieldDefs; // restore field defs
        // test
        $tmpUser = BeanFactory::getBean('Users');
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;

        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));

        $filter = ['test']; //['id' => ['force_default']];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';
        $tmpUser->field_defs['id']['alias'] = '';
        $tmpUser->field_defs['id']['force_blank'] = true;
        $tmpUser->field_defs['id']['source'] = 'custom_fields';
        $tmpUser->field_defs['modified_user_id']['source'] = 'custom_field';

        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.id  FROM users  where ( (  (  ( EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);

        $tmpUser->field_defs = $fieldDefs; // restore field defs
        // clean up
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('users');
    }

}
