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

require_once 'modules/stic_Web_Forms/Assistant/Include/views/view.stepdownload.php';

class ViewEventinscriptionstepdownload extends stic_Web_FormsViewStepDownload
{
    protected $downloadFileName = 'webformtoevent.html'; // File name to download
    protected $downloadLabel = 'LBL_WEBFORMS_DOWNLOAD_LABEL'; // Title of the link to download

    /**
     * Includes the javascript code necessary for the operation of the form
     */
    public function prepareJS()
    {
        require_once "modules/stic_Settings/Utils.php";

        if (stic_SettingsUtils::getSetting('GENERAL_IBAN_VALIDATION') == '1') {
            $fileToIncludeInForm = 'WebFormPC.js';
        } else {
            $fileToIncludeInForm = 'WebFormPCInt.js';
        }

        // Generate the necessary javascript code
        $jsForm = parent::prepareJS();

        // If the form includes payment commitments we include the associated javascript
        if ($this->view_object_map['PERSISTENT_DATA']['include_payment_commitment']) {
            ob_start();
            require_once "{$this->javascriptDir}/{$fileToIncludeInForm}";
            require_once "modules/stic_Web_Forms/Assistant/EventInscription/javascript/ExtendedWebFormPC.js";
            $jsForm .= ob_get_contents();
            ob_end_clean();
        }
        return $jsForm;
    }

    /**
     * It includes the necessary language variables
     */
    public function prepareLangVars()
    {
        $langVars = parent::prepareLangVars();
        if ($this->view_object_map['PERSISTENT_DATA']['include_payment_commitment']) {
            $langVars['stic_Payment_Commitments_LBL_IBAN_NOT_VALID'] = translate('LBL_IBAN_NOT_VALID', 'stic_Payment_Commitments');
        }
        return $langVars;
    }
}
