<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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




error_reporting(1);
//destroying global variables
$GLOBALS['studioConfig'] = array();
$GLOBALS['studioConfig']['parsers']['ListViewParser'] = 'modules/Studio/parsers/ListViewParser.php';
$GLOBALS['studioConfig']['parsers']['SlotParser'] = 'modules/Studio/parsers/SlotParser.php';
$GLOBALS['studioConfig']['parsers']['StudioParser'] = 'modules/Studio/parsers/StudioParser.php';
$GLOBALS['studioConfig']['parsers']['StudioRowParser'] = 'modules/Studio/parsers/StudioRowParser.php';
$GLOBALS['studioConfig']['parsers']['StudioUpgradeParser'] = 'modules/Studio/parsers/StudioUpgradeParser.php';
$GLOBALS['studioConfig']['parsers']['SubpanelColParser'] = 'modules/Studio/parsers/SubpanelColParser.php';
$GLOBALS['studioConfig']['parsers']['SubpanelParser'] = 'modules/Studio/parsers/SubpanelParser.php';
$GLOBALS['studioConfig']['parsers']['TabIndexParser'] = 'modules/Studio/parsers/TabIndexParser.php';
$GLOBALS['studioConfig']['parsers']['XTPLListViewParser'] = 'modules/Studio/parsers/XTPLListViewParser.php';
$GLOBALS['studioConfig']['ajax']['customfieldview'] = 'modules/Studio/ajax/customfieldview.php';
$GLOBALS['studioConfig']['ajax']['editcustomfield'] = 'modules/Studio/ajax/editcustomfield.php';
$GLOBALS['studioConfig']['ajax']['relatedfiles'] = 'modules/Studio/ajax/relatedfiles.php';
$GLOBALS['studioConfig']['dynamicFields']['bool'] = 'modules/DynamicFields/templates/Fields/Forms/bool.php';
$GLOBALS['studioConfig']['dynamicFields']['date'] = 'modules/DynamicFields/templates/Fields/Forms/date.php';
$GLOBALS['studioConfig']['dynamicFields']['email'] = 'modules/DynamicFields/templates/Fields/Forms/email.php';
$GLOBALS['studioConfig']['dynamicFields']['enum'] = 'modules/DynamicFields/templates/Fields/Forms/enum.php';
$GLOBALS['studioConfig']['dynamicFields']['float'] = 'modules/DynamicFields/templates/Fields/Forms/float.php';
$GLOBALS['studioConfig']['dynamicFields']['html'] = 'modules/DynamicFields/templates/Fields/Forms/html.php';
$GLOBALS['studioConfig']['dynamicFields']['int'] = 'modules/DynamicFields/templates/Fields/Forms/int.php';
$GLOBALS['studioConfig']['dynamicFields']['multienum'] = 'modules/DynamicFields/templates/Fields/Forms/multienum.php';
$GLOBALS['studioConfig']['dynamicFields']['radioenum'] = 'modules/DynamicFields/templates/Fields/Forms/radioenum.php';
$GLOBALS['studioConfig']['dynamicFields']['text'] = 'modules/DynamicFields/templates/Fields/Forms/text.php';
$GLOBALS['studioConfig']['dynamicFields']['url'] = 'modules/DynamicFields/templates/Fields/Forms/url.php';
$GLOBALS['studioConfig']['dynamicFields']['varchar'] = 'modules/DynamicFields/templates/Fields/Forms/varchar.php';

?>
