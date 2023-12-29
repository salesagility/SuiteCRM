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
/* HEADER */
// Set module name
var module = 'stic_Attendances';

/* INCLUDES */

/* VALIDATION DEPENDENCIES */
validationDependencies = {
  duration:'status',
  status:'duration',
};

/* VALIDATION CALLBACKS */
addToValidateMoreThan(getFormName(), 'duration', 'decimal', false, SUGAR.language.languages.app_strings.ERR_INVALID_VALUE, 0.25);

addToValidateCallback(getFormName(), 'duration', 'decimal', false, SUGAR.language.get(module, 'LBL_ERROR_STATUS_DURATION'), function() {
	var status = getFieldValue('status','stic_attendances_status_list');
	var duration = getFieldValue('duration');
	if (duration == '' && ['yes', 'partial'].indexOf(status) != -1) {
		return false;
	} else {
		return true;
	}
});

addToValidateCallback(getFormName(), 'status', 'enum', false, SUGAR.language.get(module, 'LBL_ERROR_STATUS_DURATION'), function() {
	var status = getFieldValue('status','stic_attendances_status_list');
	var duration = getFieldValue('duration');
	if (duration == '' && ['yes', 'partial'].indexOf(status) != -1) {
		return false;
	} else {
		return true;
	}
});

/* VIEWS CUSTOM CODE */
switch (viewType()) {
	case 'edit':
	case 'quickcreate':
	case "popup":
		setAutofill(["name", "start_date"]);
		break;
	case 'detail':
		break;

	case 'list':
		break;

	default:
		break;
}

/* AUX FUNCTIONS */


var $status = $('select#status');
showHideDurationRequiredMark($status);
$status.on('change', function() {
  showHideDurationRequiredMark($status);
});

function showHideDurationRequiredMark($status) {
	if (['yes', 'partial'].indexOf($status.val()) != -1) {
		addRequiredMark('duration');
	} else {
		removeRequiredMark('duration');
	}
}
