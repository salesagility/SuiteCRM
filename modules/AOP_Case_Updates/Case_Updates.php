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

    $hideImage = SugarThemeRegistry::current()->getImageURL('basic_search.gif');
    $showImage = SugarThemeRegistry::current()->getImageURL('advanced_search.gif');

    //Javascript for Asynchronous update
    $html = <<<A
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
function caseUpdates(record){
    loadingMessgPanl = new YAHOO.widget.SimpleDialog('loading', {
                    width: '200px',
                    close: true,
                    modal: true,
                    visible: true,
                    fixedcenter: true,
                    constraintoviewport: true,
                    draggable: false
                });
    loadingMessgPanl.setHeader(SUGAR.language.get('app_strings', 'LBL_EMAIL_PERFORMING_TASK'));
    loadingMessgPanl.setBody(SUGAR.language.get('app_strings', 'LBL_EMAIL_ONE_MOMENT'));
    loadingMessgPanl.render(document.body);
    loadingMessgPanl.show();

    var update_data = document.getElementById('update_text').value;
    var checkbox = document.getElementById('internal').checked;
    var internal = "";
    if(checkbox){
        internal=1;
    }

    //Post parameters

    var params =
        "record="+record+"&module=Cases&return_module=Cases&action=Save&return_id="+record+"&return_action=DetailView&relate_to=Cases&relate_id="+record+"&offset=1&update_text="
        + update_data + "&internal=" + internal;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "index.php", true);


    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length", params.length);
    xmlhttp.setRequestHeader("Connection", "close");

    //When button is clicked
    xmlhttp.onreadystatechange = function() {

        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {


            showSubPanel('history', null, true);
            //Reload the case updates stream and history panels
		    $("#LBL_AOP_CASE_UPDATES").load("index.php?module=Cases&action=DetailView&record="+record + " #LBL_AOP_CASE_UPDATES", function(){


            //Collapse all except newest update
            $('.caseUpdateImage').attr("src",showUpdateImage);
            $('.caseUpdate').slideUp('fast');

            var id = $('.caseUpdate').last().attr('id');
            if(id){
            toggleCaseUpdate(id.replace('caseUpdate',''));
            }


            loadingMessgPanl.hide();

            }

        );
	}
}

        xmlhttp.send(params);



}
</script>
A;

    $updates = $focus->get_linked_beans('aop_case_updates',"AOP_Case_Updates");
    if(!$updates || is_null($focus->id)){
        $html .= quick_edit_case_updates();
        return $html;
        //return $mod_strings['LBL_NO_CASE_UPDATES'];
    }





    $html .= <<<EOD
<script>
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
    $html .= quick_edit_case_updates();
    return $html;
}



/**
 * @return mixed|string|void
 */
function display_update_form(){
    global $mod_strings, $app_strings;
    $sugar_smarty	= new Sugar_Smarty();
    $sugar_smarty->assign('MOD', $mod_strings);
    $sugar_smarty->assign('APP', $app_strings);
    return $sugar_smarty->fetch('modules/AOP_Case_Updates/tpl/caseUpdateForm.tpl');
}

/**
 *
 * @param SugarBean $update
 * @return string - html to be displayed
 */
function getUpdateDisplayHead(SugarBean $update){
    global $mod_strings;
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
    $html .= "<span>".($update->internal ? "<strong>" . $mod_strings['LBL_INTERNAL'] . "</strong> " : '') .$name . " ".$update->date_entered."</span><br>";
    $notes = $update->get_linked_beans('notes','Notes');
    if($notes){
        $html.= $mod_strings['LBL_AOP_CASE_ATTACHMENTS'];
        foreach($notes as $note){
            $html .= "<a href='index.php?module=Notes&action=DetailView&record={$note->id}'>{$note->filename}</a>&nbsp;";
        }
    }
    return $html;
}

/**
 * Gets a single update and returns it
 *
 * @param AOP_Case_Updates $update
 * @return string - the html for the update
 */
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

/**
 * Displays case attachments
 *
 * @param $case
 * @return string - html link
 */
function display_case_attachments($case){
    $html = '';
    $notes = $case->get_linked_beans('notes','Notes');
    if($notes){
        foreach($notes as $note){
            $html .= "<a href='index.php?module=Notes&action=DetailView&record={$note->id}'>{$note->filename}</a>&nbsp;";
        }
    }
    return $html;
}


/**
 * The Quick edit for case updates which appears under update stream
 * Also includes the javascript for AJAX update
 *
 * @return string - the html to be displayed and javascript
 */
function quick_edit_case_updates(){
    global $action;

    //on DetailView only
    if($action != 'DetailView') return;

    //current record id
    $record = $_GET['record'];

    //Get Users roles
    require_once('modules/ACLRoles/ACLRole.php');
    $user = $GLOBALS['current_user'];
    $id = $user->id;
    $acl = new ACLRole();
    $roles = $acl->getUserRoles($id);

    //Return if user cannot edit cases
    if(in_array( "no edit cases", $roles) || $roles === "no edit cases"){

        return;
    }

    $html = <<< EOD
    <form id='case_updates' enctype="multipart/form-data">


    <textarea id="update_text" name="update_text" cols="80" rows="4"></textarea>

    <input id='internal' type='checkbox' name='internal' tabindex=0 title='' value='1'> Internal</input>
    </br>
    <input type='button' value='Save' onclick="caseUpdates('$record')" title="Save" name="button"> </input>


    </br>
    </form>


EOD;




    return $html;

}
