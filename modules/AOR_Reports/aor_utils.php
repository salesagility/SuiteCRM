<?php
/**
 *
 *
 * @package
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

/**
 * Returns the display labels for a module path and field.
 * @param $modulePath
 * @param $field
 * @return array
 */
function getDisplayForField($modulePath, $field, $reportModule)
{
    global $app_list_strings;
    $modulePathDisplay = array();
    $currentBean = BeanFactory::getBean($reportModule);
    $modulePathDisplay[] = $currentBean->module_name;
    if (is_array($modulePath)) {
        $split = $modulePath;
    } else {
        $split = explode(':', $modulePath);
    }
    if ($split && $split[0] == $currentBean->module_dir) {
        array_shift($split);
    }
    foreach ($split as $relName) {
        if (empty($relName)) {
            continue;
        }
        if (!empty($currentBean->field_name_map[$relName]['vname'])) {
            $moduleLabel = trim(translate($currentBean->field_name_map[$relName]['vname'], $currentBean->module_dir), ':');
        }
        $thisModule = getRelatedModule($currentBean->module_dir, $relName);
        $currentBean = BeanFactory::getBean($thisModule);

        if (!empty($moduleLabel)) {
            $modulePathDisplay[] = $moduleLabel;
        } else {
            $modulePathDisplay[] = $currentBean->module_name;
        }
    }
    $fieldDisplay = $currentBean->field_name_map[$field]['vname'];
    $fieldDisplay = translate($fieldDisplay, $currentBean->module_dir);
    $fieldDisplay = trim($fieldDisplay, ':');
    foreach($modulePathDisplay as &$module) {
        $module = isset($app_list_strings['aor_moduleList'][$module]) ? $app_list_strings['aor_moduleList'][$module] : (
            isset($app_list_strings['moduleList'][$module]) ? $app_list_strings['moduleList'][$module] : $module
        );
    }
    return array('field' => $fieldDisplay, 'module' => str_replace(' ', '&nbsp;', implode(' : ', $modulePathDisplay)));
}

function requestToUserParameters()
{
    $params = array();
    if(isset($_REQUEST['parameter_id']) && $_REQUEST['parameter_id']) {
        foreach ($_REQUEST['parameter_id'] as $key => $parameterId) {
            if ($_REQUEST['parameter_type'][$key] === 'Multi') {
                $_REQUEST['parameter_value'][$key] = encodeMultienumValue(explode(',', $_REQUEST['parameter_value'][$key]));
            }
            $params[$parameterId] = array('id' => $parameterId,
                'operator' => $_REQUEST['parameter_operator'][$key],
                'type' => $_REQUEST['parameter_type'][$key],
                'value' => $_REQUEST['parameter_value'][$key],
            );
        }
    }
    return $params;
}

function getConditionsAsParameters($report, $override = array())
{
    if (empty($report)) {
        return array();
    }

    global $app_list_strings;
    $conditions = array();
    foreach ($report->get_linked_beans('aor_conditions', 'AOR_Conditions') as $key => $condition) {
        if (!$condition->parameter) {
            continue;
        }

        $path = unserialize(base64_decode($condition->module_path));
        $field_module = $report->report_module;
        if ($path[0] != $report->report_module) {
            foreach ($path as $rel) {
                if (empty($rel)) {
                    continue;
                }
                $field_module = getRelatedModule($field_module, $rel);
            }
        }

        $additionalConditions = unserialize(base64_decode($condition->value));


        $value = isset($override[$condition->id]['value']) ? $override[$condition->id]['value'] : $value = $condition->value;


        $field = getModuleField($field_module, $condition->field, "parameter_value[$key]", 'EditView', $value);
        $disp = getDisplayForField($path, $condition->field, $report->report_module);
        $conditions[] = array(
            'id' => $condition->id,
            'operator' => $condition->operator,
            'operator_display' => $app_list_strings['aor_operator_list'][$condition->operator],
            'value_type' => $condition->value_type,
            'value' => $value,
            'field_display' => $disp['field'],
            'module_display' => $disp['module'],
            'field' => $field,
            'additionalConditions' => $additionalConditions
        );
    }
    return $conditions;
}

/**
 * getPeriodDate
 * @param $date_time_period_list_selected
 * @return DateTime
 */
function getPeriodDate($date_time_period_list_selected)
{
    global $sugar_config;
    $datetime_period = new DateTime();

    // Setup when year quarters start & end
    if ($sugar_config['aor']['quarters_begin']) {
        $q = calculateQuarters($sugar_config['aor']['quarters_begin']);
    } else {
        $q = calculateQuarters();
    }

    if ($date_time_period_list_selected == 'today') {
        $datetime_period = new DateTime();
    } else if ($date_time_period_list_selected == 'yesterday') {
        $datetime_period = $datetime_period->sub(new DateInterval("P1D"));
    } else if ($date_time_period_list_selected == 'this_week') {
        $datetime_period = $datetime_period->setTimestamp(strtotime('this week'));
    } else if ($date_time_period_list_selected == 'last_week') {
        $datetime_period = $datetime_period->setTimestamp(strtotime('last week'));
    } else if ($date_time_period_list_selected == 'this_month') {
        $datetime_period = $datetime_period->setDate($datetime_period->format('Y'), $datetime_period->format('m'), 1);
    } else if ($date_time_period_list_selected == 'last_month') {
        $datetime_period = $datetime_period->setDate($datetime_period->format('Y'), $datetime_period->format('m'), 1);
    } else if ($date_time_period_list_selected == 'this_quarter') {
        $thisMonth = $datetime_period->setDate($datetime_period->format('Y'), $datetime_period->format('m'), 1);
        if ($thisMonth >= $q[1]['start'] && $thisMonth <= $q[1]['end']) {
            // quarter 1
            $datetime_period = $datetime_period->setDate($q[1]['start']->format('Y'), $q[1]['start']->format('m'), $q[1]['start']->format('d'));
        } else if ($thisMonth >= $q[2]['start'] && $thisMonth <= $q[2]['end']) {
            // quarter 2
            $datetime_period = $datetime_period->setDate($q[2]['start']->format('Y'), $q[2]['start']->format('m'), $q[2]['start']->format('d'));
        } else if ($thisMonth >= $q[3]['start'] && $thisMonth <= $q[3]['end']) {
            // quarter 3
            $datetime_period = $datetime_period->setDate($q[3]['start']->format('Y'), $q[3]['start']->format('m'), $q[3]['start']->format('d'));
        } else if ($thisMonth >= $q[4]['start'] && $thisMonth <= $q[4]['end']) {
            // quarter 4
            $datetime_period = $datetime_period->setDate($q[4]['start']->format('Y'), $q[4]['start']->format('m'), $q[4]['start']->format('d'));
        }
    } else if ($date_time_period_list_selected == 'last_quarter') {
        $thisMonth = $datetime_period->setDate($datetime_period->format('Y'), $datetime_period->format('m'), 1);
        if ($thisMonth >= $q[1]['start'] && $thisMonth <= $q[1]['end']) {
            // quarter 1 - 3 months
            $datetime_period = $q[1]['start']->sub(new DateInterval('P3M'));
        } else if ($thisMonth >= $q[2]['start'] && $thisMonth <= $q[2]['end']) {
            // quarter 2 - 3 months
            $q[2]['start']->sub(new DateInterval('P3M'));
        } else if ($thisMonth >= $q[3]['start'] && $thisMonth <= $q[3]['end']) {
            // quarter 3 - 3 months
            $q[3]['start']->sub(new DateInterval('P3M'));
        } else if ($thisMonth >= $q[4]['start'] && $thisMonth <= $q[4]['end']) {
            // quarter 4 - 3 months
            $q[3]['start']->sub(new DateInterval('P3M'));
        }
    } else if ($date_time_period_list_selected == 'this_year') {
        $datetime_period = $datetime_period = $datetime_period->setDate($datetime_period->format('Y'), 1, 1);
    } else if ($date_time_period_list_selected == 'last_year') {
        $datetime_period = $datetime_period = $datetime_period->setDate($datetime_period->format('Y') - 1, 1, 1);
    }
    // set time to 00:00:00
    $datetime_period = $datetime_period->setTime(0, 0, 0);
    return $datetime_period;
}

/**
 * @param int $offsetMonths - defines start of the year.
 * @return array - The each quarters boundary
 */
function calculateQuarters($offsetMonths = 0)
{
    // define quarters
    $q = array();
    $q['1'] = array();
    $q['2'] = array();
    $q['3'] = array();
    $q['4'] = array();

    // Get the start of this year
    $q1start = new DateTime();
    $q1start = $q1start->setTime(0, 0, 0);
    $q1start = $q1start->setDate($q1start->format('Y'), 1, 1);
    /*
     * $offsetMonths gets added to the current month. Therefor we need this variable to equal one less than the start
     * month. So Jan becomes 0. Feb => 1 and so on.
     */
    $offsetMonths -= 1;
    // Offset months
    if ($offsetMonths > 0) {
        $q1start->add(new DateInterval('P' . $offsetMonths . 'M'));
    }
    $q1end = DateTime::createFromFormat(DATE_ISO8601, $q1start->format(DATE_ISO8601));
    $q1end->add(new DateInterval('P2M'));

    $q2start = DateTime::createFromFormat(DATE_ISO8601, $q1start->format(DATE_ISO8601));
    $q2start->add(new DateInterval('P3M'));
    $q2end = DateTime::createFromFormat(DATE_ISO8601, $q2start->format(DATE_ISO8601));
    $q2end->add(new DateInterval('P2M'));

    $q3start = DateTime::createFromFormat(DATE_ISO8601, $q2start->format(DATE_ISO8601));
    $q3start->add(new DateInterval('P3M'));
    $q3end = DateTime::createFromFormat(DATE_ISO8601, $q3start->format(DATE_ISO8601));
    $q3end->add(new DateInterval('P2M'));

    $q4start = DateTime::createFromFormat(DATE_ISO8601, $q3start->format(DATE_ISO8601));
    $q4start->add(new DateInterval('P3M'));
    $q4end = DateTime::createFromFormat(DATE_ISO8601, $q4start->format(DATE_ISO8601));
    $q4end->add(new DateInterval('P2M'));

    // Assign quarter boundaries
    $q['1']['start'] = $q1start;
    $q['1']['end'] = $q1end;
    $q['2']['start'] = $q2start;
    $q['2']['end'] = $q2end;
    $q['3']['start'] = $q3start;
    $q['3']['end'] = $q3end;
    $q['4']['start'] = $q4start;
    $q['4']['end'] = $q4end;

    return $q;
}