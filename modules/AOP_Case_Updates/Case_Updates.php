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
function display_updates($focus, $field, $value, $view){

    $updates = $focus->get_linked_beans('aop_case_updates',"AOP_Case_Updates");
    $html = "";
    usort($updates,function($a,$b){
        $aDate = $a->fetched_row['date_entered'];
        $bDate = $b->fetched_row['date_entered'];
        if($aDate < $bDate){
            return -1;
        }elseif($aDate > $bDate){
            return 1;
        }
        return 0;
    });

    foreach($updates as $update){
        $html .= display_single_update($update);
    }
    return $html;
}


function display_single_update(AOP_Case_Updates $update){
    if($update->contact_id){
        $name = $update->getContact()->name;
    }elseif($update->assigned_user_id){
        $name = $update->getUpdateUser()->name;
    }else{
        $name = "Unknown";
    }
    $html = ($update->internal ? "<strong>Internal</strong> " : '') .$name . " at ".$update->date_entered.  ":<br>";
    $html .= nl2br(html_entity_decode($update->description));
    $html.= "<hr>";
    return $html;
}