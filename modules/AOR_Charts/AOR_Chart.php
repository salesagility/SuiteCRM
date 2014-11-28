<?php
/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
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
 * @author SalesAgility <info@salesagility.com>
 */

class AOR_Chart extends Basic {
	var $new_schema = true;
	var $module_dir = 'AOR_Charts';
	var $object_name = 'AOR_Chart';
	var $table_name = 'aor_charts';
	var $importable = true;
	var $disable_row_level_security = true ;
	
	var $id;
	var $name;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $modified_by_name;
	var $created_by;
	var $created_by_name;
	var $description;
	var $deleted;
	var $created_by_link;
	var $modified_user_link;
	
	function AOR_Chart(){
		parent::Basic();
	}

    function save_lines(array $post,AOR_Report $bean,$postKey){
        foreach($post[$postKey.'id'] as $key => $id){
            if($id){
                $aorChart = BeanFactory::getBean('AOR_Charts',$id);
            }else{
                $aorChart = BeanFactory::newBean('AOR_Charts');
            }
            $aorChart->name = $post[$postKey.'title'][$key];
            $aorChart->type = $post[$postKey.'type'][$key];
            $aorChart->x_field = $post[$postKey.'x_field'][$key];
            $aorChart->y_field = $post[$postKey.'y_field'][$key];
            $aorChart->aor_report_id = $bean->id;
            $aorChart->save();
            $seenIds[] = $aorChart->id;
        }
        //Any beans that exist but aren't in $seenIds must have been removed.
        foreach($bean->get_linked_beans('aor_charts','AOR_Charts') as $chart){
            if(!in_array($chart->id,$seenIds)){
                $chart->mark_deleted($chart->id);
            }
        }
    }
}
