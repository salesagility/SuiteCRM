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

/**
 * class AOPContactUtilsException
 */
class AOPContactUtilsException extends Exception {

    const UNABLE_READ_PORTAL_VERSION = 100;

}

/**
 * Class AOPContactUtils
 */
class AOPContactUtils {


    /**
     * 
     * @param string $portalURL
     * @return boolean
     * @throws AOPContactUtilsException
     */
    public static function isMultiplePortalSupportAvailable($portalURL) {
        $multiplePortalSupportAvailable = false;
        $aopXML = $portalURL . '/administrator/components/com_advancedopenportal/advancedopenportal.xml';
        if (url_exists($aopXML)) {
            $aopv = @file_get_contents($aopXML);
            if($aopv === false) {
                throw new AOPContactUtilsException("Unable to read AOP version from portal: {$aopXML}", AOPContactUtilsException::UNABLE_READ_PORTAL_VERSION);
            }
            if (preg_match('/\<version\>([^<]+)\<\/version\>/', $aopv, $matches)) {
                if (version_compare($matches[1], '2.0.1', '>')) {
                    $multiplePortalSupportAvailable = true;
                }
            }
        }

        return $multiplePortalSupportAvailable;
    }

}
