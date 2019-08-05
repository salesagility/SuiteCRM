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

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/

/**
 * Relationship table linking emails with 1 or more SugarBeans
 */
$dictionary['email_cache'] = array(
    'table' => 'email_cache',
    'fields' => array(
        'ie_id' => array(
            'name'		=> 'ie_id',
            'type'		=> 'id',
        ),
        'mbox' => array(
            'name'		=> 'mbox',
            'type'		=> 'varchar',
            'len'		=> 60,
            'required'	=> true,
        ),
        'subject' => array(
            'name'		=> 'subject',
            'type'		=> 'varchar',
            'len'		=> 255,
            'required'	=> false,
        ),
        'fromaddr' => array(
            'name'		=> 'fromaddr',
            'type'		=> 'varchar',
            'len'		=> 100,
            'required'	=> false,
        ),
        'toaddr' => array(
            'name'		=> 'toaddr',
            'type'		=> 'varchar',
            'len'		=> 255,
            'required'	=> false,
        ),
        'senddate' => array(
            'name'		=> 'senddate',
            'type'		=> 'datetime',
            'required'	=> false,
        ),
        'message_id' => array(
            'name'		=> 'message_id',
            'type'		=> 'varchar',
            'len'		=> 255,
            'required'	=> false,
        ),
        'mailsize' => array(
            'name'		=> 'mailsize',
            'type'		=> 'uint',
            'len'		=> 16,
            'required'	=> true,
        ),
        'imap_uid' => array(
            'name'		=> 'imap_uid',
            'type'		=> 'uint',
            'len'		=> 32,
            'required'	=> true,
        ),
        'msgno' => array(
            'name'		=> 'msgno',
            'type'		=> 'uint',
            'len'		=> 32,
            'required'	=> false,
        ),
        'recent' => array(
            'name'		=> 'recent',
            'type'		=> 'tinyint',
            'len'		=> 1,
            'required'	=> true,
        ),
        'flagged' => array(
            'name'		=> 'flagged',
            'type'		=> 'tinyint',
            'len'		=> 1,
            'required'	=> true,
        ),
        'answered' => array(
            'name'		=> 'answered',
            'type'		=> 'tinyint',
            'len'		=> 1,
            'required'	=> true,
        ),
        'deleted' => array(
            'name'		=> 'deleted',
            'type'		=> 'tinyint',
            'len'		=> 1,
            'required'	=> false,
        ),
        'seen' => array(
            'name'		=> 'seen',
            'type'		=> 'tinyint',
            'len'		=> 1,
            'required'	=> true,
        ),
        'draft' => array(
            'name'		=> 'draft',
            'type'		=> 'tinyint',
            'len'		=> 1,
            'required'	=> true,
        ),
    ),
    'indices' => array(
        array(
            'name'			=> 'idx_ie_id',
            'type'			=> 'index',
            'fields'		=> array(
                'ie_id',
            ),
        ),
        array(
            'name'			=> 'idx_mail_date',
            'type'			=> 'index',
            'fields'		=> array(
                'ie_id',
                'mbox',
                'senddate',
            )
        ),
        array(
            'name'			=> 'idx_mail_from',
            'type'			=> 'index',
            'fields'		=> array(
                'ie_id',
                'mbox',
                'fromaddr',
            )
        ),
        array(
            'name'			=> 'idx_mail_subj',
            'type'			=> 'index',
            'fields'		=> array(
                'subject',
            )
        ),
        array(
            'name'			=> 'idx_mail_to',
            'type'			=> 'index',
            'fields'		=> array(
                'toaddr',
            )
        ),

    ),
);
