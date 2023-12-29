<?php
/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
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
 * You can contact Christian Knoll at info@kreporter.org
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$kreportCustomFunctions = array(
	'getcurrentuserid' => 'current User ID',
        'interval1630' => 'Interval 16:30'
);

if(!function_exists('getcurrentuserid'))
{
	function getcurrentuserid($whereConditionRecord)
	{
		global $current_user;
		
		return array(
		    'operator' => 'oneof',
		    'value' => $current_user->id . ',seed_chris_id'
		);
	}
}

if(!function_exists('interval1630'))
{
	function interval1630($whereConditionRecord)
	{
		global $current_user;
		
		return array(
                    'operator' => 'between',
                    'value' => '',
		    'valuekey' => date('Y-m-d', time()-86400) . ' 16:30:01', 
                    'valueto' => '',
                    'valuetokey' => date('Y-m-d') . ' 16:30:00', 
		);
	}
}
?>