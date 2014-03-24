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
    global $mod_strings;

    $updates = $focus->get_linked_beans('aop_case_updates',"AOP_Case_Updates");
    if(!$updates){
        return $mod_strings['LBL_NO_CASE_UPDATES'];
    }

    $hideImage = SugarThemeRegistry::current()->getImageURL('basic_search.gif');
    $showImage = SugarThemeRegistry::current()->getImageURL('advanced_search.gif');



    $html = <<<EOD
<script>
var hideUpdateImage = '$hideImage';
var showUpdateImage = '$showImage';
function collapseAllUpdates(){
    $('.caseUpdateImage').attr("src",showUpdateImage);
    $('.caseUpdate').slideUp('fast');
}
function expandAllUpdates(){
    $('.caseUpdateImage').attr("src",hideUpdateImage);
    $('.caseUpdate').slideDown('fast');
}
function toggleCaseUpdate(updateId){
    var id = 'caseUpdate'+updateId;
    var updateElem = $('#'+id);
    var imageElem = $('#'+id+"Image");

    if(updateElem.is(":visible")){
        imageElem.attr("src",showUpdateImage);
    }else{
        imageElem.attr("src",hideUpdateImage);
    }
    updateElem.slideToggle('fast');
}
$(document).ready(function(){
    collapseAllUpdates();
    var id = $('.caseUpdate').last().attr('id');
    if(id){
        toggleCaseUpdate(id.replace('caseUpdate',''));
    }
});
</script>
<a href='' onclick='collapseAllUpdates(); return false;'>{$mod_strings['LBL_CASE_UPDATES_COLLAPSE_ALL']}</a>
<a href='' onclick='expandAllUpdates(); return false;'>{$mod_strings['LBL_CASE_UPDATES_EXPAND_ALL']}</a>
<div>
EOD;


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
        $html .= display_single_update($update, $hideImage);
    }
    $html .= "</div>";
    return $html;
}

function getUpdateDisplayHead(SugarBean $update){
    if($update->contact_id){
        $name = $update->getUpdateContact()->name;
    }elseif($update->assigned_user_id){
        $name = $update->getUpdateUser()->name;
    }else{
        $name = "Unknown";
    }
    $html = "<a href='' onclick='toggleCaseUpdate(\"".$update->id."\");return false;'>";
    $html .= "<img  id='caseUpdate".$update->id."Image' class='caseUpdateImage' src='".SugarThemeRegistry::current()->getImageURL('basic_search.gif')."'>";
    $html .= "</a>";
    $html .= "<span>".($update->internal ? "<strong>Internal</strong> " : '') .$name . " at ".$update->date_entered."</span><br>";
    $notes = $update->get_linked_beans('notes','Notes');
    if($notes){
        $html.= "Attachments: ";
        foreach($notes as $note){
            $html .= "<a href='index.php?module=Notes&action=DetailView&record={$note->id}'>{$note->filename}</a>&nbsp;";
        }
    }
    return $html;
}

function display_single_update(AOP_Case_Updates $update){

    /*if assigned user*/
    if($update->assigned_user_id){
        /*if internal update*/
        if ($update->internal){
            $html = "<div id='caseStyleInternal'>".getUpdateDisplayHead($update);
            $html .= "<div id='caseUpdate".$update->id."' class='caseUpdate'>";
            $html .= nl2br(html_entity_decode($update->description));
            $html .= "</div></div>";
            return $html;
        }
        /*if standard update*/
        else {
        $html = "<div id='lessmargin'><div id='caseStyleUser'>".getUpdateDisplayHead($update);
        $html .= "<div id='caseUpdate".$update->id."' class='caseUpdate'>";
        $html .= nl2br(html_entity_decode($update->description));
        $html .= "</div></div></div>";
        return $html;
        }
    }

    /*if contact user*/
    if($update->contact_id){
        $html = "<div id='extramargin'><div id='caseStyleContact'>".getUpdateDisplayHead($update);
        $html .= "<div id='caseUpdate".$update->id."' class='caseUpdate'>";
        $html .= nl2br(html_entity_decode($update->description));
        $html .= "</div></div></div>";
        return $html;
    }

}