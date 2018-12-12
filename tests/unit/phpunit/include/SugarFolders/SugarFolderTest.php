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
 * reasonably feasible for technical 169reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

use SuiteCRM\StateSaver;

class SugarFolderTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected $folderId = null;

    public function setUp()
    {
        parent::setUp();

        include_once __DIR__ . '/../../../../../modules/Users/User.php';
        include_once __DIR__ . '/../../../../../include/SugarFolders/SugarFolders.php';
    }

    /**
     * Test the object can be found
     *
     * @return void
     */
    public function testCanGetSugarFolderObject()
    {
        $sugarfolder = new SugarFolder();

        $this->assertTrue(is_object($sugarfolder));
    }

    public function testFunctions()
    {


        /*
            // Public attributes
            public $id;
            public $name;
            public $parent_folder;
            public $has_child = 0; // flag node has child
            public $is_group = 0;
            public $is_dynamic = 0;
            public $dynamic_query = '';
            public $assign_to_id;
            public $created_by;
            public $modified_by;
            public $date_created;
            public $date_modified;
            public $deleted;
            public $folder_type;

            public $db;
            public $new_with_id = true;

            // Core queries
            public $core;
            public $coreSubscribed;
            public $coreWhere;
            public $coreWhereSubscribed;
            public $coreOrderBy;

            public $hrSortLocal;
            public $defaultSort = 'date';
            public $defaultDirection = "DESC";

            // Private attributes
            public $_depth;
         */

        // $sugarfolder->getListItemsForEmailXML($folderId, $page = 1, $pageSize = 10, $sort = '', $direction = '');

        // $sugarfolder->retrieveFoldersForProcessing($user, $subscribed = true);
        // $sugarfolder->getGroupFoldersForSettings($focusUser = null);
        //
        // $sugarfolder->getFoldersForSettings($focusUser = null);
        //
        // $sugarfolder->getFoldersChildForSettings($a, $collection, $subscriptions);
        //
        // $sugarfolder->getCountNewItems($id, $criteria, $folder);
        //
        // $sugarfolder->getUserFolders(&$rootNode, $folderStates, $user = null, $forRefresh = false);
        //
        // $sugarfolder->buildTreeNodeRefresh($folderNode, $subscriptions);
        // $sugarfolder->buildTreeNodeFolders($a, $nodePath, $folderStates, $subscriptions);


        // $sugarfolder->deleteChildrenCascade($id);
    }

    public function testGenerateArchiveFolderQuery()
    {
        $user = new User();
        $user->id = 1;

        $sugarfolder = new SugarFolder($user);
        $sql = $sugarfolder->generateArchiveFolderQuery();

        $expected = "SELECT emails.id , emails.name, emails.date_sent, emails.status, emails.type, emails.flagged, emails.reply_to_status, emails_text.from_addr, emails_text.to_addrs, 'Emails' polymorphic_module FROM emails JOIN emails_text on emails.id = emails_text.email_id WHERE emails.deleted=0 AND emails.type NOT IN ('out', 'draft')"
            . " AND emails.status NOT IN ('sent', 'draft') AND emails.id IN (SELECT eear.email_id FROM emails_email_addr_rel eear JOIN email_addr_bean_rel eabr ON eabr.email_address_id=eear.email_address_id AND eabr.bean_id = '1' AND eabr.bean_module = 'Users' WHERE eear.deleted=0)";

        $this->assertEquals($expected, $sql);

    }

    public function testGenerateSugarsDynamicFolderQuery()
    {
        $user = new User();
        $user->id = 1;

        $sugarfolder = new SugarFolder($user);
        $sugarfolder->folder_type = 'archived';

        $sql = $sugarfolder->generateSugarsDynamicFolderQuery();

        $expected = "SELECT emails.id , emails.name, emails.date_sent, emails.status, emails.type, emails.flagged, emails.reply_to_status, emails_text.from_addr, emails_text.to_addrs, 'Emails' polymorphic_module FROM emails JOIN emails_text on emails.id = emails_text.email_id WHERE emails.deleted=0 AND emails.type NOT IN ('out', 'draft')"
            . " AND emails.status NOT IN ('sent', 'draft') AND emails.id IN (SELECT eear.email_id FROM emails_email_addr_rel eear JOIN email_addr_bean_rel eabr ON eabr.email_address_id=eear.email_address_id AND eabr.bean_id = '1' AND eabr.bean_module = 'Users' WHERE eear.deleted=0)";

        $this->assertEquals($sql, $expected);

        $sugarfolder->folder_type = 'sent';

        $sql = $sugarfolder->generateSugarsDynamicFolderQuery();

        $expected = "SELECT emails.id, emails.name, emails.date_sent, emails.status, emails.type, emails.flagged, emails.reply_to_status, emails_text.from_addr, emails_text.to_addrs, 'Emails' polymorphic_module FROM emails JOIN emails_text on emails.id = emails_text.email_id WHERE (type = 'out' OR status = 'sent'') AND assigned_user_id = '1' AND emails.deleted = 0 AND emails.status NOT IN ('archived') AND emails.type NOT IN ('archived')";

        $this->assertEquals($sql, $expected);

        $sugarfolder->folder_type = 'inbound';

        $sql = $sugarfolder->generateSugarsDynamicFolderQuery();

        $expected = "SELECT emails.id, emails.name, emails.date_sent, emails.status, emails.type, emails.flagged, emails.reply_to_status, emails_text.from_addr, emails_text.to_addrs, 'Emails' polymorphic_module FROM emails JOIN emails_text on emails.id = emails_text.email_id WHERE (type = 'inbound' OR status = 'inbound'') AND assigned_user_id = '1' AND emails.deleted = 0 AND emails.status NOT IN ('sent', 'archived', 'draft') AND emails.type NOT IN ('out', 'archived', 'draft')";

        $this->assertEquals($sql, $expected);
    }


    public function testFolderSubscriptions()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $sugarfolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Test folder',
            'parent_folder'    => ''
        );

        $saved = $sugarfolder->setFolder($fields);

        $this->assertTrue($saved);

        $sugarfolder->insertFolderSubscription($sugarfolder->id, $user->id);

        $subscriptions = $sugarfolder->getSubscriptions($user);

        $this->assertTrue((count($subscriptions) > 0));

        // Access clear with user
        $sugarfolder->clearSubscriptions($user);

        // Access with default param
        $sugarfolder->clearSubscriptions();

        $subscriptions = $sugarfolder->getSubscriptions(null);

        $this->assertEquals(0, count($subscriptions));

        // test the add subscription to group folder
        $sugarfolder->addSubscriptionsToGroupFolder();

        // $sugarfolder->createSubscriptionForUser($user_id);
        // $sugarfolder->getSubscriptions($user);
        // $sugarfolder->insertFolderSubscription($folderId, $userID)
        // $sugarfolder->clearSubscriptions($user = null)
        // $sugarfolder->clearSubscriptionsForFolder($folder_id)
        // $sugarfolder->addSubscriptionsToGroupFolder();
        // $sugarfolder->setSubscriptions($subs, $user = null);


        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testClearSubscriptionsForFolder()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $sugarfolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Test folder',
            'parent_folder'    => ''
        );

        $saved = $sugarfolder->setFolder($fields);

        $this->assertTrue($saved);

        $sugarfolder->insertFolderSubscription($sugarfolder->id, $user->id);

        $sugarfolder->clearSubscriptionsForFolder($sugarfolder->id);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testUnreadCountOfItems()
    {
        $this->assertTrue(true);
    }

    public function testGetFoldersForSettings()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $sugarfolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Test folder',
            'parent_folder'    => ''
        );

        $saved = $sugarfolder->setFolder($fields);

        $this->assertTrue($saved);

        $saved = false;

        $childSugarFolder = new SugarFolder($user);

        $fields = array(
            'name'          => 'Child Test folder',
            'parent_folder' => $sugarfolder->id
        );

        $saved = $childSugarFolder->setFolder($fields);

        $this->assertTrue($saved);

        $sugarfolder->has_child = 1;

        $ret = $sugarfolder->getFoldersForSettings();

        $this->assertTrue(is_array($ret));

        $ret = $childSugarFolder->getParentIDRecursive($childSugarFolder->id);

        $this->assertTrue(in_array($sugarfolder->id, $ret));

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testCrudFolder()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $sugarfolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Test folder',
            'parent_folder'    => ''
        );

        $saved = $sugarfolder->setFolder($fields);

        $this->assertTrue($saved);

        $saved = false;

        $childSugarFolder = new SugarFolder($user);

        $fields = array(
            'name'          => 'Child Test folder',
            'parent_folder' => $sugarfolder->id
        );

        $saved = $childSugarFolder->setFolder($fields);

        $this->assertTrue($saved);

        $sugarfolder->has_child = 1;

        $update = array(
            'record' => $sugarfolder->id,
            'name'   => 'Test Folder',
            'parent_folder' => ''
        );

        $ret = $sugarfolder->updateFolder($update);

        $this->assertEquals('done', $ret['status']);

        // Try to update the child with parent

        $update = array(
            'record' => $sugarfolder->id,
            'name'   => 'Test Folder',
            'parent_folder' => $childSugarFolder->id
        );

        $ret = $sugarfolder->updateFolder($update);

        $this->assertEquals('failed', $ret['status']);

        $deleted = $sugarfolder->delete();

        $this->assertTrue($deleted);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testCheckFalseIdForDelete()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $sugarfolder = new SugarFolder();

        $ret = $sugarfolder->delete();

        $this->assertFalse($ret);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testCopyBean()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $parentFolderOne = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder One',
            'parent_folder'    => ''
        );

        $saved = $parentFolderOne->setFolder($fields);

        $this->assertTrue($saved);

        // reset saved
        $saved = false;

        $parentFolderTwo = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder Two',
            'parent_folder'    => ''
        );

        $saved = $parentFolderTwo->setFolder($fields);

        $this->assertTrue($saved);

        $bean = BeanFactory::newBean('Emails');
        $bean->save();

        $parentFolderOne->addBean($bean);

        $parentFolderOne->copyBean($parentFolderOne->id, $parentFolderTwo->id, $bean->id, $bean->module_name);

        $existInFolderOne = $parentFolderOne->checkEmailExistForFolder($bean->id);
        $existInFolderTwo = $parentFolderTwo->checkEmailExistForFolder($bean->id);

        $this->assertTrue($existInFolderOne);

        $this->assertTrue($existInFolderTwo);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }


    public function testMoveFolder()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $parentFolderOne = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder One',
            'parent_folder'    => ''
        );

        $saved = $parentFolderOne->setFolder($fields);

        $this->assertTrue($saved);

        // reset saved
        $saved = false;

        $parentFolderTwo = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder Two',
            'parent_folder'    => ''
        );

        $saved = $parentFolderTwo->setFolder($fields);

        $this->assertTrue($saved);

        // reset saved
        $saved = false;

        $childFolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Child Folder',
            'parent_folder'    => $parentFolderOne->id
        );

        $saved = $childFolder->setFolder($fields);

        $this->assertTrue($saved);

        $success = $parentFolderOne->move($parentFolderOne->id, $parentFolderTwo->id, $childFolder->id);

        $this->assertTrue($success);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testGetListItemsForEmailXML()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $sugarFolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder',
            'parent_folder'    => ''
        );

        $saved = $sugarFolder->setFolder($fields);

        $this->assertTrue($saved);

        for ($i = 0; $i < 10; $i++) {
            $arrayOfEmailBeans[$i] = BeanFactory::newBean('Emails');
            $arrayOfEmailBeans[$i]->save();

            $sugarFolder->addBean($arrayOfEmailBeans[$i]);
        }

        $results = $sugarFolder->getListItemsForEmailXML($sugarFolder->id);
        $this->assertTrue(is_array($results));

        $sugarFolder->is_dynamic = true;
        $sugarFolder->hrSortLocal = array();

        $results = $sugarFolder->getListItemsForEmailXML($sugarFolder->id);
        $this->assertTrue(is_array($results));

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testCountOfItems()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $parentFolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder',
            'parent_folder'    => ''
        );

        $saved = $parentFolder->setFolder($fields);

        $this->assertTrue($saved);

        $arrayOfEmailBeans = array();

        $deadBean = BeanFactory::newBean('Emails');
        $parentFolder->addBean($deadBean);

        for ($i = 0; $i < 10; $i++) {
            $arrayOfEmailBeans[$i] = BeanFactory::newBean('Emails');
            $arrayOfEmailBeans[$i]->save();

            $parentFolder->addBean($arrayOfEmailBeans[$i]);
        }

        $count = $parentFolder->getCountItems($parentFolder->id);

        $this->assertEquals(10, $count);

        // Test getCountNewItems
        $count = $parentFolder->getCountNewItems($parentFolder->id, false, false);
        $this->assertEquals(0, $count);

        $count = $parentFolder->getCountUnread($parentFolder->id);
        $this->assertEquals(0, $count);

        $parentFolder->is_dynamic = true;

        $count = $parentFolder->getCountItems($parentFolder->id);
        $this->assertEquals(10, $count);

        $count = $parentFolder->getCountUnread($parentFolder->id);
        $this->assertEquals(0, $count);

        // non-existent folder
        $newBean = BeanFactory::newBean('Emails');
        $newBean->save();

        $parentFolder->id = null;

        $parentFolder->addBean($newBean);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testNonExistingRetrieve()
    {
        $state = new StateSaver();

        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $parentFolder = new SugarFolder($user);

        $randomGuid = 'randstring';

        $ret = $parentFolder->retrieve($randomGuid);

        $this->assertFalse($ret);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testDeleteEmailsFromFolder()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $parentFolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder',
            'parent_folder'    => ''
        );

        $saved = $parentFolder->setFolder($fields);

        $this->assertTrue($saved);

        $bean = BeanFactory::newBean('Emails');
        $bean->save();

        $parentFolder->addBean($bean);

        $count = $parentFolder->getCountItems($parentFolder->id);

        $this->assertEquals(1, $count);

        $parentFolder->deleteEmailFromFolder($bean->id);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }


    public function testDeleteEmailsFromAllFolders()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $parentFolderOne = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder One',
            'parent_folder'    => ''
        );

        $saved = $parentFolderOne->setFolder($fields);

        $this->assertTrue($saved);

        // reset saved
        $saved = false;

        $parentFolderTwo = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder Two',
            'parent_folder'    => ''
        );

        $saved = $parentFolderTwo->setFolder($fields);

        $this->assertTrue($saved);

        $bean = BeanFactory::newBean('Emails');
        $bean->save();

        $parentFolderOne->addBean($bean);

        $parentFolderOne->copyBean($parentFolderOne->id, $parentFolderTwo->id, $bean->id, $bean->module_name);

        $existInFolderOne = $parentFolderOne->checkEmailExistForFolder($bean->id);
        $existInFolderTwo = $parentFolderTwo->checkEmailExistForFolder($bean->id);

        $this->assertTrue($existInFolderOne);
        $this->assertTrue($existInFolderTwo);

        $parentFolderOne->deleteEmailFromAllFolder($bean->id);

        $existInFolderOne = $parentFolderOne->checkEmailExistForFolder($bean->id);
        $existInFolderTwo = $parentFolderTwo->checkEmailExistForFolder($bean->id);

        $this->assertFalse($existInFolderOne);
        $this->assertFalse($existInFolderTwo);

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testGetUserFolders()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $parentFolderOne = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder',
            'parent_folder'    => ''
        );

        $saved = $parentFolderOne->setFolder($fields);

        $this->assertTrue($saved);

        $arrayOfEmailBeans = array();

        for ($i = 0; $i < 10; $i++) {
            $arrayOfEmailBeans[$i] = BeanFactory::newBean('Emails');
            $arrayOfEmailBeans[$i]->save();

            $parentFolderOne->addBean($arrayOfEmailBeans[$i]);
        }

        $childFolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Child Folder',
            'parent_folder'    => $parentFolderOne->id
        );

        $subChildFolderOne = new SugarFolder($user);

        $fields = array(
            'name'             => 'Sub Child Folder One',
            'parent_folder'    => $childFolder->id
        );

        $subChildFolderTwo = new SugarFolder($user);

        $fields = array(
            'name'             => 'Sub Child Folder Two',
            'parent_folder'    => $childFolder->id
        );

        $anotherChildFolder = new SugarFolder($user);

        $fields = array(
            'name'             => 'Another Child Folder',
            'parent_folder'    => $parentFolderOne->id
        );

        $parentFolderOne->getUserFolders($rootNode, $folderStates = array(), $user = null, $forRefresh = true);

        $this->assertTrue(is_object($rootNode));

        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testBuildTreeNodeFolders()
    {
        $state = new StateSaver();
        $state->pushTable('folders');
        $state->pushTable('folders_rel');
        $state->pushTable('folders_subscriptions');
        $state->pushTable('emails');
        $state->pushTable('emails_text');

        $user = new User();
        $user->id = 1;

        $parentFolderOne = new SugarFolder($user);

        $fields = array(
            'name'             => 'Parent Folder One',
            'parent_folder'    => ''
        );

        $saved = $parentFolderOne->setFolder($fields);

        $this->assertTrue($saved);

        // reset saved
        $saved = false;

        $parentFolderTwo = new SugarFolder($user);

        $parentFolderOne->buildTreeNodeRefresh();


        $state->popTable('folders');
        $state->popTable('folders_rel');
        $state->popTable('folders_subscriptions');
        $state->popTable('emails');
        $state->popTable('emails_text');
    }

    public function testBuildTreeNodeRefresh()
    {

    }


}
