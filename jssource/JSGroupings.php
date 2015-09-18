<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*
 * This is the array that is used to determine how to group/concatenate js files together
 * The format is to define the location of the file to be concatenated as the array element key
 * and the location of the file to be created that holds the child files as the array element value.
 * So: $original_file_location => $Concatenated_file_location
 *
 * If you wish to add a grouping that contains a file that is part of another group already,
 * add a '.' after the .js in order to make the element key unique.  Make sure you pare the extension out
 *
 */

       $js_groupings = array(
           $sugar_grp1 = array(
                //scripts loaded on first page
                'include/javascript/alerts.js'          => 'include/javascript/sugar_grp1.js',
                'include/javascript/sugar_3.js'         => 'include/javascript/sugar_grp1.js',
                'include/javascript/ajaxUI.js'          => 'include/javascript/sugar_grp1.js',
                'include/javascript/cookie.js'          => 'include/javascript/sugar_grp1.js',
                'include/javascript/menu.js'            => 'include/javascript/sugar_grp1.js',
                'include/javascript/calendar.js'        => 'include/javascript/sugar_grp1.js',
                'include/javascript/quickCompose.js'    => 'include/javascript/sugar_grp1.js',
                'include/javascript/yui/build/yuiloader/yuiloader-min.js' => 'include/javascript/sugar_grp1.js',
                //HTML decode
                'include/javascript/phpjs/get_html_translation_table.js' => 'include/javascript/sugar_grp1.js',
                'include/javascript/phpjs/html_entity_decode.js' => 'include/javascript/sugar_grp1.js',
                'include/javascript/phpjs/htmlentities.js' => 'include/javascript/sugar_grp1.js',
               'include/EditView/Panels.js'   => 'include/javascript/sugar_grp1.js',
            ),
			//jquery libraries
			$sugar_grp_jquery = array(
                //jquery
                'include/javascript/jquery/jquery-min.js'             => 'include/javascript/sugar_grp1_jquery.js',
                //bootstrap
                'include/javascript/jquery/bootstrap.min.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/html5shiv.min.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/respond.min.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/footable.js'              => 'include/javascript/sugar_grp1_jquery.js',
                //jquery ui
                'include/javascript/jquery/jquery-ui-min.js'          => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.dialogTitle.js'         => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.browser.js'         => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.json-2.3.js'        => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.cookie.js'        => 'include/javascript/sugar_grp1_jquery.js',
                //jquery for moddule menus
                'include/javascript/jquery/jquery.hoverIntent.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.hoverscroll.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.hotkeys.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.superfish.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.tipTip.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.sugarMenu.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.highLight.js'              => 'include/javascript/sugar_grp1_jquery.js',
                'include/javascript/jquery/jquery.showLoading.js'              => 'include/javascript/sugar_grp1_jquery.js',

            
			),
           $sugar_field_grp = array(
               'include/SugarFields/Fields/Collection/SugarFieldCollection.js' => 'include/javascript/sugar_field_grp.js',
               'include/SugarFields/Fields/Datetimecombo/Datetimecombo.js' => 'include/javascript/sugar_field_grp.js',
           ),
            $sugar_grp1_yui = array(
			//YUI scripts loaded on first page
            'include/javascript/yui3/build/yui/yui-min.js'              => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui3/build/loader/loader-min.js'        => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui3/build/oop/oop-min.js'              => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui3/build/event-custom/event-custom-base-min.js' => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui3/build/io/io-base-min.js'           => 'include/javascript/sugar_grp1_yui.js',
			'include/javascript/yui/build/yahoo/yahoo-min.js'           => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/dom/dom-min.js'               => 'include/javascript/sugar_grp1_yui.js',
			'include/javascript/yui/build/yahoo-dom-event/yahoo-dom-event.js'
			    => 'include/javascript/sugar_grp1_yui.js',
			'include/javascript/yui/build/event/event-min.js'           => 'include/javascript/sugar_grp1_yui.js',
			'include/javascript/yui/build/logger/logger-min.js'         => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/animation/animation-min.js'   => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/connection/connection-min.js' => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/dragdrop/dragdrop-min.js'     => 'include/javascript/sugar_grp1_yui.js',
            //Ensure we grad the SLIDETOP custom container animation
            'include/javascript/yui/build/container/container-min.js'   => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/element/element-min.js'       => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/tabview/tabview-min.js'       => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/selector/selector.js'     => 'include/javascript/sugar_grp1_yui.js',
            //This should probably be removed as it is not often used with the rest of YUI
            'include/javascript/yui/ygDDList.js'                        => 'include/javascript/sugar_grp1_yui.js',
            //YUI based quicksearch
            'include/javascript/yui/build/datasource/datasource-min.js' => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/json/json-min.js'             => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/autocomplete/autocomplete-min.js'=> 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/quicksearch.js'                         => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/menu/menu-min.js'             => 'include/javascript/sugar_grp1_yui.js',
			'include/javascript/sugar_connection_event_listener.js'     => 'include/javascript/sugar_grp1_yui.js',
			'include/javascript/yui/build/calendar/calendar.js'     => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/history/history.js'     => 'include/javascript/sugar_grp1_yui.js',
            'include/javascript/yui/build/resize/resize-min.js'     => 'include/javascript/sugar_grp1_yui.js',
            ),

            $sugar_grp_yui_widgets = array(
			//sugar_grp1_yui must be laoded before sugar_grp_yui_widgets
            'include/javascript/yui/build/datatable/datatable-min.js'   => 'include/javascript/sugar_grp_yui_widgets.js',
            'include/javascript/yui/build/treeview/treeview-min.js'     => 'include/javascript/sugar_grp_yui_widgets.js',
			'include/javascript/yui/build/button/button-min.js'         => 'include/javascript/sugar_grp_yui_widgets.js',
            'include/javascript/yui/build/calendar/calendar-min.js'     => 'include/javascript/sugar_grp_yui_widgets.js',
			'include/javascript/sugarwidgets/SugarYUIWidgets.js'        => 'include/javascript/sugar_grp_yui_widgets.js',
            // Include any Sugar overrides done to YUI libs for bugfixes
            'include/javascript/sugar_yui_overrides.js'   => 'include/javascript/sugar_grp_yui_widgets.js',
            ),

			$sugar_grp_yui_widgets_css = array(
				"include/javascript/yui/build/fonts/fonts-min.css" => 'include/javascript/sugar_grp_yui_widgets.css',
				"include/javascript/yui/build/treeview/assets/skins/sam/treeview.css"
					=> 'include/javascript/sugar_grp_yui_widgets.css',
				"include/javascript/yui/build/datatable/assets/skins/sam/datatable.css"
					=> 'include/javascript/sugar_grp_yui_widgets.css',
				"include/javascript/yui/build/container/assets/skins/sam/container.css"
					=> 'include/javascript/sugar_grp_yui_widgets.css',
                "include/javascript/yui/build/button/assets/skins/sam/button.css"
					=> 'include/javascript/sugar_grp_yui_widgets.css',
				"include/javascript/yui/build/calendar/assets/skins/sam/calendar.css"
					=> 'include/javascript/sugar_grp_yui_widgets.css',
			),

            $sugar_grp_yui2 = array(
            //YUI combination 2
            'include/javascript/yui/build/dragdrop/dragdrop-min.js'    => 'include/javascript/sugar_grp_yui2.js',
            'include/javascript/yui/build/container/container-min.js'  => 'include/javascript/sugar_grp_yui2.js',
            ),

            //Grouping for emails module.
            $sugar_grp_emails = array(
            'include/javascript/yui/ygDDList.js' => 'include/javascript/sugar_grp_emails.js',
            'include/SugarEmailAddress/SugarEmailAddress.js' => 'include/javascript/sugar_grp_emails.js',
            'include/SugarFields/Fields/Collection/SugarFieldCollection.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/InboundEmail/InboundEmail.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/EmailUIShared.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/EmailUI.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/EmailUICompose.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/ajax.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/grid.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/init.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/complexLayout.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/composeEmailTemplate.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/displayOneEmailTemplate.js' => 'include/javascript/sugar_grp_emails.js',
            'modules/Emails/javascript/viewPrintable.js' => 'include/javascript/sugar_grp_emails.js',
            'include/javascript/quicksearch.js' => 'include/javascript/sugar_grp_emails.js',

            ),

            //Grouping for the quick compose functionality.
            $sugar_grp_quick_compose = array(
            'include/javascript/jsclass_base.js' => 'include/javascript/sugar_grp_quickcomp.js',
            'include/javascript/jsclass_async.js' => 'include/javascript/sugar_grp_quickcomp.js',
            'modules/Emails/javascript/vars.js' => 'include/javascript/sugar_grp_quickcomp.js',
            'include/SugarFields/Fields/Collection/SugarFieldCollection.js' => 'include/javascript/sugar_grp_quickcomp.js', //For team selection
            'modules/Emails/javascript/EmailUIShared.js' => 'include/javascript/sugar_grp_quickcomp.js',
            'modules/Emails/javascript/ajax.js' => 'include/javascript/sugar_grp_quickcomp.js',
            'modules/Emails/javascript/grid.js' => 'include/javascript/sugar_grp_quickcomp.js', //For address book
            'modules/Emails/javascript/EmailUICompose.js' => 'include/javascript/sugar_grp_quickcomp.js',
            'modules/Emails/javascript/composeEmailTemplate.js' => 'include/javascript/sugar_grp_quickcomp.js',
            'modules/Emails/javascript/complexLayout.js' => 'include/javascript/sugar_grp_quickcomp.js',
            ),

            $sugar_grp_jsolait = array(
                'include/javascript/jsclass_base.js'    => 'include/javascript/sugar_grp_jsolait.js',
                'include/javascript/jsclass_async.js'   => 'include/javascript/sugar_grp_jsolait.js',
                'modules/Meetings/jsclass_scheduler.js'   => 'include/javascript/sugar_grp_jsolait.js',
            ),
        );

    /**
     * Check for custom additions to this code
     */
    if(file_exists("custom/application/Ext/JSGroupings/jsgroups.ext.php")) {
        require("custom/application/Ext/JSGroupings/jsgroups.ext.php");
    }
