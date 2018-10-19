<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


/**
 * @var DirectoryIterator $node
 * @var User $current_user
 * @var SugarBean $bean
 * @var DBManager $db
 */
global $beanList, $current_user, $db, $mod_strings;
$validBeans = array();
if (!is_admin($current_user)) {
    sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}
set_time_limit(3600);

foreach ($beanList as $moduleName => $className) {
    $bean = BeanFactory::getBean($moduleName);
    if (!($bean instanceof SugarBean)) {
        continue;
    }
    if (!$bean->haveFiles()) {
        continue;
    }

    $validBeans[] = $bean;
}

echo '<pre>';
$directory = new DirectoryIterator('upload://');
$stat = array(
    'total' => 0,
    'removed' => 0
);
foreach ($directory as $node) {
    if (!$node->isFile()) {
        continue;
    }
    if (!is_guid($node->getFilename())) {
        continue;
    }
    $stat['total'] ++;

    $row = false;
    foreach ($validBeans as $bean) {
        $filter = array('deleted');
        $where = array();
        foreach ($bean->getFilesFields() as $fieldName) {
            $where[] = $fieldName . '=' . $db->quoted($node->getFilename());
            $filter[] = $fieldName;
        }
        $where = '(' . implode(' OR ', $where) . ')';

        $row = $db->fetchOne($bean->create_new_list_query('', $where, $filter, array(), 0));
        if (!empty($row)) {
            break;
        }
        $row = $db->fetchOne($bean->create_new_list_query('', $where, $filter, array(), 1));
        if (!empty($row)) {
            break;
        }
    }

    if ($row == false) {
        if (unlink('upload://' . $node->getFilename())) {
            $stat['removed'] ++;
        }
    } elseif ($row['deleted'] == 1) {
        $bean->populateFromRow($row);
        if ($bean->deleteFiles()) {
            $stat['removed'] ++;
        }
    }

    echo '.';
    if ($stat['total'] % 100 == 0) {
        echo '<br>';
        ob_flush();
        flush();
    }
}
echo '</pre>';

echo $mod_strings['LBL_TOTAL_FILES'] . ': ' . $stat['total'] . '<br>';
echo $mod_strings['LBL_REMOVED_FILES'] . ': ' . $stat['removed'] . '<br>';
