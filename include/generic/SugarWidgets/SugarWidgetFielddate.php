<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/



class SugarWidgetFieldDate extends SugarWidgetFieldDateTime
{
    function displayList($layout_def)
    {
        global $timedate;
        // i guess qualifier and column_function are the same..
        if (! empty($layout_def['column_function'])) {
            $func_name = 'displayList'.$layout_def['column_function'];
            if ( method_exists($this,$func_name)) {
                $display = $this->$func_name($layout_def);
                return $display;
            }
        }
        $content = $this->displayListPlain($layout_def);
		return $content;
    }

    function queryFilterBefore($layout_def)
    {
        return $this->queryDateOp($this->_get_column_select($layout_def), $layout_def['input_name0'], "<", "date");
    }

    function queryFilterAfter($layout_def)
    {
        return $this->queryDateOp($this->_get_column_select($layout_def), $layout_def['input_name0'], ">", "date");
    }

    function queryFilterNot_Equals_str($layout_def)
    {
        $column = $this->_get_column_select($layout_def);
        return "($column IS NULL OR ".$this->queryDateOp($column, $layout_def['input_name0'], '!=', "date").")\n";
    }

    function queryFilterOn($layout_def)
    {
        return $this->queryDateOp($this->_get_column_select($layout_def), $layout_def['input_name0'], "=", "date");
    }

    function queryFilterBetween_Dates(& $layout_def)
    {
        $begin = $layout_def['input_name0'];
        $end = $layout_def['input_name1'];
        $column = $this->_get_column_select($layout_def);

        return "(".$this->queryDateOp($column, $begin, ">=", "date")." AND ".
            $this->queryDateOp($column, $end, "<=", "date").")\n";
    }

	function queryFilterTP_yesterday($layout_def)
	{
		global $timedate;
        $layout_def['input_name0'] = $timedate->asDbDate($timedate->getNow(true)->get("-1 day"));
        return $this->queryFilterOn($layout_def);
	}

	function queryFilterTP_today($layout_def)
	{
		global $timedate;
        $layout_def['input_name0'] = $timedate->asDbDate($timedate->getNow(true));
        return $this->queryFilterOn($layout_def);
	}

	function queryFilterTP_tomorrow(& $layout_def)
	{
		global $timedate;
		$layout_def['input_name0'] = $timedate->asDbDate($timedate->getNow(true)->get("+1 day"));
        return $this->queryFilterOn($layout_def);
	}

    protected function queryMonth($layout_def, $month)
    {
        $end = clone($month);
        $end->setDate($month->year, $month->month, $month->days_in_month);
        $beginDate = $month->asDbDate();
        $endDate = $end->asDbDate();
        return $this->get_start_end_date_filter($layout_def, $beginDate, $endDate);
    }

    protected function now()
    {
        global $timedate;
        return $timedate->tzGMT($timedate->getNow(), $this->getAssignedUser());
    }
}
