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

/*********************************************************************************

 * Description:  printable license page.
 ********************************************************************************/

clean_incoming_data();

require_once("install/language/{$_GET['language']}.lang.php");
require_once("install/install_utils.php");

$license_file = wordwrap(getLicenseContents("LICENSE.txt"),100);
$langHeader = get_language_header();
$out =<<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">   
   <title>{$mod_strings['LBL_LICENSE_TITLE_2']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css">   
</head>

<body>
  <table cellspacing="0" cellpadding="0" border="0" align="center" class="shell" width="90%">
    <tr>
      <td colspan='3' align="right">
        <input type="button" name="print_license" value=" {$mod_strings['LBL_PRINT']} " onClick='window.print();' />
        <input type="button" name="close_windows" value=" {$mod_strings['LBL_CLOSE']} " onClick='window.close();' />
      </td>
    </tr>
    <tr>
      <td width="2%">&nbsp;</td>
      <td>
        <pre>
            {$license_file}
        </pre>
      </td>
      <td width="2%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan='3' align="right">
        <input type="button" name="print_license" value=" {$mod_strings['LBL_PRINT']} " onClick='window.print();' />
        <input type="button" name="close_windows" value=" {$mod_strings['LBL_CLOSE']} " onClick='window.close();' />
      </td>
    </tr>
  </table>
</body>
</html>
EOQ;
echo $out;
