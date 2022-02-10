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

/*
 * Created on Apr 23, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
$view_config = array(
    'actions' => array(
            'ajaxformsave' => array(
                            'show_all' => false
                        ),
            'popup' => array(
                            'show_header' => false,
                            'show_subpanels' => false,
                            'show_search' => false,
                            'show_footer' => false,
                            'show_javascript' => true,
                        ),
            'authenticate' => array(
                            'show_header' => false,
                            'show_subpanels' => false,
                            'show_search' => false,
                            'show_footer' => false,
                            'show_javascript' => true,
                        ),
            'subpanelcreates' => array(
                            'show_header' => false,
                            'show_subpanels' => false,
                            'show_search' => false,
                            'show_footer' => false,
                            'show_javascript' => true,
                        ),
         ),
    'req_params' => array(
        'print' => array(
            'param_value' => true,
                             'config' => array(
                                          'show_header' => true,
                                          'show_footer' => false,
                                          'view_print'  => true,
                                          'show_title' => false,
                                          'show_subpanels' => false,
                                          'show_javascript' => true,
                                          'show_search' => false,)
                       ),
        'action' => array(
            'param_value' => array('Delete','Save'),
                               'config' => array(
                                                'show_all' => false
                                                ),
                        ),
        'to_pdf' => array(
            'param_value' => true,
                               'config' => array(
                                                'show_all' => false
                                                ),
                        ),
        'to_csv' => array(
            'param_value' => true,
                               'config' => array(
                                                'show_all' => false
                                                ),
                        ),
        'sugar_body_only' => array(
            'param_value' => true,
                               'config' => array(
                                                'show_all' => false
                                                ),
                        ),
        'view' => array(
            'param_value' => 'documentation',
                               'config' => array(
                                                'show_all' => false
                                                ),
                        ),
        'show_js' => array(
            'param_value' => true,
                             'config' => array(
                                          'show_header' => false,
                                          'show_footer' => false,
                                          'view_print'  => false,
                                          'show_title' => false,
                                          'show_subpanels' => false,
                                          'show_javascript' => true,
                'show_search' => false,
            )
        ),
        'ajax_load' => array(
            'param_value' => true,
            'config' => array(
                'show_header' => false,
                'show_footer' => false,
                'view_print'  => false,
                'show_title' => true,
                'show_subpanels' => false,
                'show_javascript' => false,
                'show_search' => true,
                'json_output' => true,
            )
                       ),
        ),
);
