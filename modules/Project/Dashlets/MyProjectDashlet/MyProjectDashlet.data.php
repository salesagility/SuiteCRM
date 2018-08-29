<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2008 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 */



global $current_user;

$dashletData['MyProjectDashlet']['searchFields'] =  array( 
                                                            'estimated_end_date'         => array('default' => ''),
		                                           'estimated_start_date'        => array('default' => ''),
                                                            'status'         => array('default' => ''),
                                                            'assigned_user_id' => array('type'    => 'assigned_user_name',
                                                                                        'default' => $current_user->name)

                                                            );
$dashletData['MyProjectDashlet']['columns'] = array('name' => array('width'   => '40', 
                                                                       'label'   => 'LBL_NAME',
                                                                       'link'    => true,
                                                                       'default' => true),

                                                                 'assigned_user_name' => array('width'   => '8', 
                                                                                     'label'   => 'LBL_LIST_ASSIGNED_USER',
                                                                                     'default' => true),
                                                                 'estimated_start_date' => array('width' => '10',
										    'label' => 'LBL_DATE_START'),
								 'estimated_end_date' => array('width' => '10',
                                                                                    'label' => 'LBL_DATE_END'),
								 'status' => array('width' => '5',
                                                                                    'label' => 'LBL_STATUS'),
);
