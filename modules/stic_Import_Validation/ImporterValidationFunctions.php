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

require_once 'SticInclude/Utils.php';

/**
 * 
 */
function identificationNumberValidation($module, $rowValue, $row)
{
    $returnValue = false;
    switch ($module) 
    {
        case 'Accounts':
            return SticUtils::isValidCIF($rowValue) ? $rowValue : 'LBL_ERROR_INVALID_IDENTIFICATION_NUMBER';
            break;

        case 'Contacts':
            // If the stic_identification_type_c field is mapped and its value is NIF or NIE
            if ((in_array('NIF', $row) || in_array('nif', $row) || in_array('NIE', $row) || in_array('nie', $row))){
                return SticUtils::isValidNIForNIE($rowValue) ? $rowValue : 'LBL_ERROR_INVALID_IDENTIFICATION_NUMBER';
            } else {
                return 'LBL_ERROR_INVALID_IDENTIFICATION_NUMBER_MISSING_TYPE_FIELD';
            }
            break;

        default:
            return true;
            break;
    }
}


/**
 * 
 */
function bankAccountValidation($rowValue)
{
    return SticUtils::checkIBAN($rowValue) ? $rowValue : 'LBL_ERROR_INVALID_BANK_ACCOUNT';
}