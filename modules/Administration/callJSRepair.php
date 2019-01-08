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

    /*
    **this is the ajax call that is called from RebuildJSLang.php.  It processes
    **the Request object in order to call correct methods for repairing/rebuilding JSfiles
    *Note that minify.php has already been included as part of index.php, so no need to include again.
    */

 
    //set default root directory
    $from = getcwd();
    if (isset($_REQUEST['root_directory'])  && !empty($_REQUEST['root_directory'])) {
        $from = $_REQUEST['root_directory'];
    }
    //this script can take a while, change max execution time to 10 mins
    $tmp_time = ini_get('max_execution_time');
    ini_set('max_execution_time', '600');
        
        //figure out which commands to call.
        if ($_REQUEST['js_admin_repair'] == 'concat') {
            //concatenate mode, call the files that will concatenate javascript group files
            $_REQUEST['js_rebuild_concat'] = 'rebuild';
            require_once('jssource/minify.php');
        } else {
            $_REQUEST['root_directory'] = getcwd();
            require_once('jssource/minify.php');
        
            if ($_REQUEST['js_admin_repair'] == 'replace') {
                //should replace compressed JS with source js
                reverseScripts("$from/jssource/src_files", "$from");
            } elseif ($_REQUEST['js_admin_repair'] == 'mini') {
                //should replace compressed JS with minified version of source js
                reverseScripts("$from/jssource/src_files", "$from");
                BackUpAndCompressScriptFiles("$from", "", false);
                ConcatenateFiles("$from");
            } elseif ($_REQUEST['js_admin_repair'] == 'repair') {
                //should compress existing javascript (including changes done) without overwriting original source files
                BackUpAndCompressScriptFiles("$from", "", false);
                ConcatenateFiles("$from");
            }
        }
    //set execution time back to what it was
    ini_set('max_execution_time', $tmp_time);
