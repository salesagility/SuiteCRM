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
<?php

// config|_override.php
if(is_file('../../../config.php')) {
    require_once('../../../config.php'); // provides $sugar_config
}

// load up the config_override.php file.  This is used to provide default user settings
if(is_file('../../../config_override.php')) {
    require_once('../../../config_override.php');
}

//if(!isset($sugar_config['theme_settings']['Suite7'])) return;

//set file type back to css from php
header("Content-type: text/css; charset: UTF-8");

?>

/* suggestion-box */

#suggestion_box table {
    border: 1px solid #cccccc;
    padding: 0px !important;
    width: 100%;
    max-width: 400px;
    color: #337ab7;
    border-spacing: 0px;
}
#suggestion_box table tr {
    border-bottom: 1px solid #cccccc;
}
#suggestion_box table tr:hover {
    background-color: #dfeffe;
    cursor: pointer;
}
#suggestion_box table tr th {
    padding: 4px!important;
    text-align:left;
    background-color: #f0f0ee;
    color: #333333;
}
#suggestion_box table tr td {
    margin: 0px;
    border: none;
}
#tool-tip-separator {
    margin-top: 10px;
    margin-bottom: 10px;
}

.tool-tip-title {
    margin-bottom: 3px;
    display: inline-block;
}

#use_resolution {
    margin-top: 4px;
    padding: 8px;
}
#additional_info_p {
    margin-bottom: 4px;
}
.transfer {
    border: 2px dotted gray;
}

.qtip-content {
    max-height: 450px;
    overflow-y: auto;
}

.qtip {
    font-family: Arial, Verdana, Helvetica, sans-serif;
    font-size: 12px;
    background: #ffffff;
    border: 1px solid #cccccc;
    -webkit-border-radius: 0px;
    border-radius: 0px;
}

/*
<?php print_r($sugar_config); ?>
*/

.qtip-tipped .qtip-titlebar {
    background-color: #<?php echo $sugar_config['theme_settings']['SuiteR']['suggestion_popup_from']; ?>;
    padding: 10px 40px 10px 10px;
    background-image: -webkit-gradient(linear,left top,left bottom,from(#<?php echo $sugar_config['theme_settings']['SuiteR']['suggestion_popup_from']; ?>),to(#<?php echo $sugar_config['theme_settings']['SuiteR']['suggestion_popup_to']; ?>));
    background-image: -webkit-linear-gradient(top,#<?php echo $sugar_config['theme_settings']['SuiteR']['suggestion_popup_from']; ?>,#<?php echo $sugar_config['theme_settings']['SuiteR']['suggestion_popup_to']; ?>);
}

/* suggestion box has to be responsive */

@media (max-width: 640px) {

    #suggestion_box table {
        border: none;
    }

    #suggestion_box table tbody tr {
        display: table-row;
        border: 1px solid #ccc;
        padding: 0;
    }

    #suggestion_box table tbody tr th,
    #suggestion_box table tbody tr td {
        display: table-cell;
        width: auto;
    }

}