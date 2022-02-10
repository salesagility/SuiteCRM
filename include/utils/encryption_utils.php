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

require_once('include/Pear/Crypt_Blowfish/Blowfish.php');

function sugarEncode($key, $data)
{
    return base64_encode($data);
}


function sugarDecode($key, $encoded)
{
    $data = base64_decode($encoded);
    return $data;
}

///////////////////////////////////////////////////////////////////////////////
////	BLOWFISH
/**
 * retrives the system's private key; will build one if not found, but anything encrypted before is gone...
 * @param string type
 * @return string key
 */
function blowfishGetKey($type)
{
    $key = array();

    $type = str_rot13($type);

    $keyCache = "custom/blowfish/{$type}.php";

    // build cache dir if needed
    if (!file_exists('custom/blowfish')) {
        mkdir_recursive('custom/blowfish');
    }

    // get key from cache, or build if not exists
    if (file_exists($keyCache)) {
        include($keyCache);
    } else {
        // create a key
        $key[0] = create_guid();
        write_array_to_file('key', $key, $keyCache);
    }
    return $key[0];
}

/**
 * Uses blowfish to encrypt data and base 64 encodes it. It stores the iv as part of the data
 * @param STRING key - key to base encoding off of
 * @param STRING data - string to be encrypted and encoded
 * @return string
 */
function blowfishEncode($key, $data)
{
    $bf = new Crypt_Blowfish($key);
    $encrypted = $bf->encrypt($data);
    return base64_encode($encrypted);
}

/**
 * Uses blowfish to decode data assumes data has been base64 encoded with the iv stored as part of the data
 * @param STRING key - key to base decoding off of
 * @param STRING encoded base64 encoded blowfish encrypted data
 * @return string
 */
function blowfishDecode($key, $encoded)
{
    $data = base64_decode($encoded);
    $bf = new Crypt_Blowfish($key);
    return trim($bf->decrypt($data));
}
