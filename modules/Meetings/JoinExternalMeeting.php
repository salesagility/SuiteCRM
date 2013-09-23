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


/*
 * This file checks if you are invited to an external meeting, which is too expensive
 * to do per-row in lists so we direct them here and check before either forwarding
 * them along, or displaying an error message to the user.
 */

global $db, $current_user, $mod_strings, $app_strings, $app_list_strings;

$ret = $db->query("SELECT id FROM meetings_users WHERE meeting_id = '".$db->quote($_REQUEST['meeting_id'])."' AND user_id = '".$current_user->id."' AND deleted = 0",true);
$row = $db->fetchByAssoc($ret);

$meetingBean = loadBean('Meetings');
$meetingBean->retrieve($_REQUEST['meeting_id']);

if ( $_REQUEST['host_meeting'] == '1' ) {
    if($meetingBean->assigned_user_id == $GLOBALS['current_user']->id || is_admin($GLOBALS['current_user']) || is_admin_for_module($GLOBALS['current_user'],'Meetings')){
        SugarApplication::redirect($meetingBean->host_url);
    }else{
        //since they are now the owner of the meeting nor an Admin they cannot start the meeting.
        $tplFile = 'modules/Meetings/tpls/extMeetingNoStart.tpl';
        if ( file_exists('custom/'.$tplFile) ) {
            $tplFile = 'custom/'.$tplFile;
        }

        $ss = new Sugar_Smarty();
        $ss->assign('current_user',$current_user);
        $ss->assign('bean',$meetingBean->toArray());
        $ss->display($tplFile);
    }
}else{
    if(isset($row['id']) || $meetingBean->assigned_user_id == $GLOBALS['current_user']->id || is_admin($GLOBALS['current_user']) || is_admin_for_module($GLOBALS['current_user'],'Meetings')){
      SugarApplication::redirect($meetingBean->join_url);
    }else{
        //if the user is not invited or the owner of the meeting or an admin then they cannot join the meeting.
        $tplFile = 'modules/Meetings/tpls/extMeetingNotInvited.tpl';
        if ( file_exists('custom/'.$tplFile) ) {
            $tplFile = 'custom/'.$tplFile;
        }

        $ss = new Sugar_Smarty();
        $ss->assign('current_user',$current_user);
        $ss->assign('bean',$meetingBean->toArray());
        $ss->display($tplFile);
    }
}