<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

 


$layout_defs['Documents'] = array(
	// list of what Subpanels to show in the DetailView 
	'subpanel_setup' => array(
		'therevisions' => array(
			'order' => 10,
			'sort_order' => 'desc',
			'sort_by' => 'revision',			
			'module' => 'DocumentRevisions',
			'subpanel_name' => 'default',
			'title_key' => 'LBL_DOC_REV_HEADER',
			'get_subpanel_data' => 'revisions',
			'fill_in_additional_fields'=>true,
		),
        'accounts' => array(
            'order' => 30,
            'module' => 'Accounts',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_ACCOUNTS_SUBPANEL_TITLE',
            'get_subpanel_data' => 'accounts',
            'top_buttons' => 
            array (
                0 => 
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                    ),
                1 => 
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                    ),
                ),
        ),
        'contacts' => array(
            'order' => 40,
            'module' => 'Contacts',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE',
            'get_subpanel_data' => 'contacts',
            'top_buttons' => 
            array (
                0 => 
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                    ),
                1 => 
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                    ),
                ),
        ),
        'opportunities' => array(
            'order' => 40,
            'module' => 'Opportunities',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_OPPORTUNITIES_SUBPANEL_TITLE',
            'get_subpanel_data' => 'opportunities',
            'top_buttons' => 
            array (
                0 => 
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                    ),
                1 => 
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                    ),
                ),
        ),
        'cases' => array(
            'order' => 50,
            'module' => 'Cases',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_CASES_SUBPANEL_TITLE',
            'get_subpanel_data' => 'cases',
            'top_buttons' => 
            array (
                0 => 
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                    ),
                1 => 
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                    ),
                ),
        ),
        'bugs' => array(
            'order' => 60,
            'module' => 'Bugs',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_BUGS_SUBPANEL_TITLE',
            'get_subpanel_data' => 'bugs',
            'top_buttons' => 
            array (
                0 => 
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                    ),
                1 => 
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                    ),
                ),
        ),
	),
);
?>