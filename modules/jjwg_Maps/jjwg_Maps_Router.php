<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/utils.php');
require_once('include/export_utils.php');

/*
 * The entry point is registered by
 * custom/include/MVC/Controller/entry_point_registry.php
 */

if (!empty($_REQUEST['cron'])) {
  
  require_once('modules/jjwg_Maps/jjwg_Maps.php');
  require_once('modules/jjwg_Maps/controller.php');
  /*
   * This script can be used as an entry point for a cron
   * job to run the address geocoding on a regular basis.
   * index.php?module=jjwg_Maps&entryPoint=jjwg_Maps&cron=1&limit=2500
   */
  $controller = new jjwg_MapsController();
  $controller->action_geocode_addresses();
  
  exit;

} else {
  
  /*
   * This script is also used to pass selected records from 
   * a module list view to the Maps Module (jjwg_Maps).
   *
   * Multiple records are posted thru 'uid' (comma separated) or 
   * 'current_post' (see export_utils.php)
   * 
   * A Javascript post method is required here as the
   * parameters are sometimes too long for a get method
   * 
   * Search Types
   * 1.) Default - All Records - Map
   *     Uses 'current_post' parameter to define search
   * 2.) Default - Checked Records or This Page - Map
   *     Uses 'uid'(s) parameter to define search
   * 3.) Parameter Search - Select All - Map
   *     Uses 'current_post'
   * 4.) Parameter Search - Checked Records - Map
   *     Uses 'uid'(s) parameter to define search
   */
  //echo 'Test:<pre>'."\n";
  //foreach (array_keys($_REQUEST) as $key) {
  //  echo 'Name: '.htmlspecialchars($key).'  Value: '.htmlspecialchars($_REQUEST[$key])."\n";
  //}
  
  // Redirect parameters to view/action using Javascript form post.
  echo '<html><head></head><body>';
  echo '<form name="redirect" action="index.php" method="POST">'."\n";
  echo '<input type="hidden" name="module" value="jjwg_Maps">'."\n";
  echo '<input type="hidden" name="action" value="map_display">'."\n";
  foreach (array_keys($_REQUEST) as $key) {
    if (!in_array($key, array('action','module','entryPoint','display_module', 'quick_address'))) {
      echo '<input type="hidden" name="'.htmlspecialchars($key).'" value="'.htmlspecialchars($_REQUEST[$key]).'">'."\n";
    }
  }
  echo '<input type="hidden" name="display_module" value="'.htmlspecialchars($_REQUEST['display_module']).'">'."\n";
  echo '</form>'."\n";
  echo '<script language="javascript" type="text/javascript">document.redirect.submit();</script>'."\n"; 
  echo '</body></html>';
  
  exit;
}
