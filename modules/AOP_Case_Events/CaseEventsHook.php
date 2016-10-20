<?php
/**
 *
 * @package Advanced OpenPortal
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

class CaseEventsHook {

    private $diff_fields = array(
        array('field'=> 'priority', 'display_field' => 'priority', 'display_name' => 'Priority'),
        array('field'=> 'status', 'display_field' => 'status', 'display_name' => 'Status'),
        array('field'=> 'assigned_user_id', 'display_field' => 'assigned_user_name', 'display_name' => 'Assigned User'),
        array('field'=> 'type', 'display_field' => 'type', 'display_name' => 'Type'),
    );

    private function compareBeans($old, $new){
        $events = array();
        foreach($this->diff_fields as $field){
            $field_name = $field['field'];
            $display_field = $field['display_field'];
            $name = $field['display_name'];
            if( (isset($old->$field_name) ? $old->$field_name : null) != (isset($new->$field_name) ? $new->$field_name : null)){
                $event = new AOP_Case_Events();
                $old_display = $old->$display_field;
                $new_display = $new->$display_field;
                $desc = $name . " changed from " . $old_display ." to " . $new_display . ".";
                $event->name = $desc;
                $event->description = $desc;
                $event->case_id = $new->id;
                $events[] = $event;
            }
        }
        return $events;

    }

    public function saveUpdate($bean, $event, $arguments){
        if(!$bean->id){
            //New case so do nothing.
            return;
        }
        if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'Import'){
            return;
        }
        $oldbean = new aCase();
        $oldbean->retrieve($bean->id);
        $events = $this->compareBeans($oldbean,$bean);
        foreach($events as $event){
            $event->save();
        }
    }

    private function log($message){
        $GLOBALS['log']->info("CaseUpdatesHook: ".$message);
    }

}