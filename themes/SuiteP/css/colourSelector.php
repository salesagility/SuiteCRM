<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 */

// config|_override.php
if (is_file('../../../config.php')) {
    require_once '../../../config.php';
}

// load up the config_override.php file.  This is used to provide default user settings
if (is_file('../../../config_override.php')) {
    require_once '../../../config_override.php';
}

if (!isset($sugar_config['theme_settings']['SuiteP'])) {
    return;
}

//set file type back to css from php
header('Content-type: text/css; charset: UTF-8');

?>

/* Header CSS */

h1, h2, h3, h4 {
color: #<?php echo $sugar_config['theme_settings']['SuiteP']['page_header']; ?>;

}

/* Pagelink CSS */

a, a:link, a:visited, #dashletbuttons, .detail tr td a:link, .detail tr td a:visited, .detail tr td a:hover{
color: #<?php echo $sugar_config['theme_settings']['SuiteP']['page_link']; ?>;
}

/* Dashlet CSS */

.dashletPanel .h3Row{
background: #<?php echo $sugar_config['theme_settings']['SuiteP']['dashlet']; ?>;
}

.dashletPanel .h3Row h3{
color: #<?php echo $sugar_config['theme_settings']['SuiteP']['dashlet_headertext']; ?> !important;
}

.dashletPanel .h3Row .dashletToolSet .icon{
fill: #<?php echo $sugar_config['theme_settings']['SuiteP']['dashlet_headertext']; ?> !important;
}

/* Top navigation bar CSS */

.navbar-inverse {
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['navbar']; ?> !important;
}

.headerlinks a:link, .headerlinks a:visited, .navbar-inverse .navbar-brand, .moremenu a,  a[id^=grouptab], a[id^=moduleTab] {
background:none;
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['navbar_font']; ?>;
}

@media(max-width:979px){
ul.navbar-nav li a,.navbar-inverse .navbar-nav .open .dropdown-menu > li > a, .moremenu ul li a {
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['navbar_font']; ?>; !important;
}
}

ul.topnav li:hover, .dropdown-menu li a:hover, li#usermenu:hover, .moremenu ul li a:hover,ul.navbar-nav li:hover {
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['navbar_hover']; ?> !important;
}

.headerlinks a:hover, .navbar-inverse .navbar-brand:hover {
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['navbar_link_hover']; ?> !important;
}

#desktop_notifications .btn {
background: #<?php echo $sugar_config['theme_settings']['SuiteP']['navbar']; ?> !important;
}

#searchform .btn
{
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['navbar']; ?> !important;
color: #<?php echo $sugar_config['theme_settings']['SuiteP']['icon']; ?> !important;
}

#usermenu a{
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['navbar_font']; ?>; !important;
}

/* Drop down menu CSS */

.dropdown-menu {
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['dropdown_menu']; ?> !important;
}

.dropdown-menu li a, .dropdown-menu em a, .moremenu ul li a , #globalLinks ul li a, #quickcreatetop ul li a{
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['dropdown_menu_link']; ?> !important;
}

.moremenu li a:hover, .dropdown-menu li a:hover, #globalLinks ul li a:hover, #quickcreatetop ul li a:hover{
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['dropdown_menu_link_hover']; ?> !important;
}

/* Drop down menu CSS */

#mobile_menu {
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['dropdown_menu']; ?> !important;
}

#mobile_menu li a, #mobile_menu em a {
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['dropdown_menu_link']; ?> !important;
}

#mobile_menu li a:hover {
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['dropdown_menu_link_hover']; ?> !important;
}

#mobilegloballinks ul li a {
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['dropdown_menu_link']; ?> !important;
}

#mobilegloballinks ul li a:hover {
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['button_link_hover']; ?> !important;
}


/* Icon CSS */

.icon{
fill: #<?php echo $sugar_config['theme_settings']['SuiteP']['icon']; ?> !important;
}

/* Button and action menu CSS */

button, .button, input[type="button"], input[type="reset"], input[type="submit"], a#create_link.utilsLink, .btn, .btn-success, .btn-primary, .button, input[type=submit], input[type=button], a#create_link.utilsLink, .btn-group a {
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['button']; ?> !important;
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['button_link']; ?> !important;
}

.btn:hover, .btn-success:hover, .btn-primary:hover, .button:hover, input[type=submit]:hover, input[type=button]:hover, a#create_link.utilsLink:hover, .btn-group a:hover, #globalLinksModule ul.clickMenu.SugarActionMenu li a:hover,
#globalLinksModule ul.clickMenu li:hover span, ul#globalLinksSubnav li a:hover, ul#quickCreateULSubnav li a:hover {
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['button_hover']; ?> !important;
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['button_link_hover']; ?> !important;
}

/* Action Menu CSS */

ul.clickMenu li ul.subnav, ul.clickMenu ul.subnav-sub, ul.SugarActionMenuIESub, ul.clickMenu li ul.subnav li a, ul.clickMenu li ul.subnav li input, ul.subnav-sub li a, ul.SugarActionMenuIESub li a, ul.clickMenu li ul.subnav li a, ul.clickMenu li ul.subnav li input, ul.subnav-sub li a, ul.SugarActionMenuIESub li a, ul.clickMenu li ul.subnav, ul.clickMenu ul.subnav-sub, ul.SugarActionMenuIESub, ul.clickMenu li ul.subnav li a, ul.clickMenu li ul.subnav li input, ul.subnav-sub li a, ul.SugarActionMenuIESub li a{
color: #<?php echo $sugar_config['theme_settings']['SuiteP']['page_link']; ?> !important;
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['action_menu_background']; ?> !important;
}

ul.clickMenu li ul.subnav li a:hover,ul.clickMenu li ul.subnav li input:hover, ul.clickMenu.subpanel.records li ul.subnav li a:hover, ul.clickMenu ul.subnav-sub li a:hover, ul.clickMenu ul.subnav-sub li a:hover{
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['action_menu_background_hover']; ?> !important;
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['button_link']; ?> !important;
}

ul.clickMenu>li, ul.SugarActionMenuIESub li, ul.SugarActionMenuIESub li a,
ul.clickMenu li a, .list tr.pagination td.buttons ul.clickMenu > li > a:link, .list tr.pagination td.buttons ul.clickMenu > li > a {
background:#<?php echo $sugar_config['theme_settings']['SuiteP']['action_menu_button']; ?> !important;
}

ul.SugarActionMenuIESub li a:hover, ul.clickMenu.SugarActionMenu li a:hover, ul.clickMenu.SugarActionMenu li span.subhover:hover {
/*Leave Blank */
}

ul.clickMenu.SugarActionMenu li a:hover {
color:#<?php echo $sugar_config['theme_settings']['SuiteP']['button_link_hover']; ?> !important;
}

ul.clickMenu li span.subhover:hover {
background-position: 6px 0;
}


/* popup colors */

.yui-module .hd, .yui-panel .hd {
background-color: #<?php echo $sugar_config['theme_settings']['SuiteP']['suggestion_popup_from']; ?>;
background: #<?php echo $sugar_config['theme_settings']['SuiteP']['suggestion_popup_from']; ?> none repeat scroll 0 0;
}

/* suggestion box and popup */


#suggestion_box table {
color: #<?php echo $sugar_config['theme_settings']['SuiteP']['page_link']; ?> !important;
}

.qtip-tipped .qtip-titlebar {
background-color: #<?php echo $sugar_config['theme_settings']['SuiteP']['suggestion_popup_from']; ?>;
background-image: -webkit-gradient(linear,left top,left bottom,from(#<?php echo $sugar_config['theme_settings']['SuiteP']['suggestion_popup_from']; ?>),to(#<?php echo $sugar_config['theme_settings']['SuiteP']['suggestion_popup_to']; ?>));
background-image: -webkit-linear-gradient(top,#<?php echo $sugar_config['theme_settings']['SuiteP']['suggestion_popup_from']; ?>,#<?php echo $sugar_config['theme_settings']['SuiteP']['suggestion_popup_to']; ?>);
}
