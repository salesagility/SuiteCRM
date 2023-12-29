<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
/**
 * This class is used to register new methods into the custom API
 */
require_once 'service/v4_1/SugarWebServiceImplv4_1.php';
class SugarWebServiceImplv4_1_SticCustom extends SugarWebServiceImplv4_1
{

    /**
     * Sets a file for a certain record of a module that contains a file field. Such as the photo in Contacts
     *
     * @param String $session
     * @param String $image_data
     * @return void
     */
    public function set_image($session, $image_data)
    {
        $GLOBALS['log']->debug('Begin: set_image');

        //Here we check that $session represents a valid session
        if (!self::$helperObject->checkSessionAndModuleAccess(
            $session,
            'invalid_session',
            '',
            '',
            '',
            new SoapError()
        )) {
            $GLOBALS['log']->debug('End: set_image.');
            return false;
        }
        return $this->saveImage($image_data);
    }

    public function get_image($session, $image_data)
    {
        $GLOBALS['log']->debug('Begin: get_image');

        //Here we check that $session represents a valid session
        if (!self::$helperObject->checkSessionAndModuleAccess(
            $session,
            'invalid_session',
            '',
            '',
            '',
            new SoapError()
        )) {
            $GLOBALS['log']->debug('End: get_image.');
            return false;
        }

        return $this->getImage($image_data);
    }

    /**
     * Helper function for saving the file into the chosen field.
     *
     * @param String $recordFileData
     * @return void
     */
    protected function saveImage($recordFileData)
    {
        // Checking if the necessary data is available
        if (!isset($recordFileData['module']) && empty($recordFileData['module'])) {
            return false;
        }
        $moduleName = $recordFileData['module'];
        $focus = BeanFactory::newBean($moduleName);

        // Checking if the necessary data is available
        if (!isset($recordFileData['field']) && empty($recordFileData['field'])) {
            return false;
        }
        $fieldName = $recordFileData['field'];

        // Checking if the record ID provided exists
        if (!empty($recordFileData['id'])) {
            $focus->retrieve($recordFileData['id']);
            if (empty($focus->id)) {
                return false;
            }
        } else {
            return false;
        }

        if (!empty($recordFileData['file'])) {

            // Data arrives in base64. First decoding it
            $decodedFile = base64_decode($recordFileData['file']);
            $fileName = $focus->id . '_' . $fieldName;

            // Using the helper class UploadFile to set the decoded data into a temporal file
            $upload_file = new UploadFile($fileName);
            $upload_file->set_for_soap($fileName, $decodedFile);

            // Moving the file to its final destination
            if (!$upload_file->final_move($fileName)) {
                return false;
            }

            // Verify that the file is a proper image. If not, delete the file.
            if (!$this->verifyImage($fileName)) {
                $upload_file->unlink_file($focus->id, $fileName);
                return false;
            }

            $focus->$fieldName = $recordFileData['filename'];
            $focus->save();

        } else {
            return false;
        }
        return true;
    }

    /**
     * Helper function for getting the file from the chosen field.
     *
     * @param String $recordFileData
     * @return void
     */
    protected function getImage($recordFileData)
    {
        // Checking if the necessary data is available
        if (!isset($recordFileData['field']) && empty($recordFileData['field'])) {
            return false;
        }
        $field = $recordFileData['field'];

        // Checking if the necessary data is available
        if (!isset($recordFileData['id']) && empty($recordFileData['id'])) {
            return false;
        }
        $id = $recordFileData['id'];

        // Checking if file isn't empty
        $filename = "upload://" . $id . "_" . $field;
        if (filesize($filename) <= 0) {
            return false;
        }

        // Getting file contents
        if (!$contents = sugar_file_get_contents($filename)) {
            return false;
        }
        $f = finfo_open();

        // Getting file extension
        if (!$mimeType = finfo_buffer($f, $contents, FILEINFO_MIME_TYPE)) {
            return false;
        }

        // Enconding content and sending it back to client
        $contents = base64_encode($contents);
        return array('image_data' => array('mime_type' => $mimeType, 'data' => $contents));
    }

    /**
     * Virify that the image has an allowed extension
     *
     * @param String $filename
     * @return void
     */
    protected function verifyImage($filename)
    {
        global $sugar_config;

        $valid_ext = isset($sugar_config['image_ext']) ? $sugar_config['image_ext'] : array("image/jpeg", "image/png");
        $img_size = getimagesize('upload/' . $filename);
        $filetype = $img_size['mime'];
        if (in_array($filetype, array_values($valid_ext))) {
            return true;
        }
    }

    /**
     * Rebuilds SinergiaDA views and metadata via API.
     *
     * Validates a token provided in the request, and if valid, rebuilds SinergiaDA views and metadata.
     * Logs an error and terminates execution if the token is invalid or of incorrect size.
     *
     * @global [array] $sugar_config Global Sugar configuration
     * @return string|void Result of the rebuild or nothing if the token is invalid.
     */
    public function rebuild_sda()
    {
        global $sugar_config;

        $GLOBALS['log']->stic('Line ' . __LINE__ . ': ' . __METHOD__ . ': ' . "Start rebuild SinergiaDA views & metadata via API");

        // Decode HTML entities
        $apiToken = html_entity_decode($_REQUEST['token']);
        $callUpdateModel = html_entity_decode($_REQUEST['update_model']);
        $callUpdateModel = $callUpdateModel != 1 ? 0 : 1;

        if (strlen($apiToken) != 32) {
            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ': ' . "Token does not have the necessary size.");
            die();
        }

        $db_user_name = $sugar_config['dbconfig']['db_user_name'];

        // Obtain the valid token, must coinicide with the $_REQUEST API token
        $validToken = md5($db_user_name . date("Ymd"));
        if ($apiToken == $validToken) {
            require_once 'SticInclude/SinergiaDARebuild.php';
            $res = SinergiaDARebuild::rebuild($callUpdateModel, $_REQUEST['rebuild_filter']);
            $GLOBALS['log']->stic('Line ' . __LINE__ . ': ' . __METHOD__ . ': ' . "End rebuild SinergiaDA views & metadata via API (\$callUpdateModel is {$callUpdateModel}). Result is $res.");
            return $res;
        } else {
            $GLOBALS['log']->stic('Line ' . __LINE__ . ': ' . __METHOD__ . ': ' . "Invalid token.");
        }
    }

}
