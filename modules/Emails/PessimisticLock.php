<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

global $mod_strings;
global $locale;
$userName = $mod_strings['LBL_UNKNOWN'];

if (isset($_REQUEST['user'])) {
    $user = BeanFactory::newBean('Users');
    $user->retrieve($_REQUEST['user']);
    $userName = $locale->getLocaleFormattedName($user->first_name, $user->last_name);
}


// NEXT FREE
if (isset($_REQUEST['next_free']) && $_REQUEST['next_free'] == true) {
    $next = BeanFactory::newBean('Emails');
    $rG = $next->db->query('SELECT count(id) AS c FROM users WHERE deleted = 0 AND users.is_group = 1');
    $aG = $next->db->fetchByAssoc($rG);
    if ($rG['c'] > 0) {
        $rG = $next->db->query('SELECT id FROM users WHERE deleted = 0 AND users.is_group = 1');
        $aG = $next->db->fetchByAssoc($rG);
        while ($aG = $next->db->fetchByAssoc($rG)) {
            $ids[] = $aG['id'];
        }
        $in = ' IN (';
        foreach ($ids as $k => $id) {
            $in .= '"'.$id.'", ';
        }
        $in = substr($in, 0, (strlen($in) - 2));
        $in .= ') ';
        
        $team = '';
        
        $qE = 'SELECT count(id) AS c FROM emails WHERE deleted = 0 AND assigned_user_id'.$in.$team.'LIMIT 1';
        $rE = $next->db->query($qE);
        $aE = $next->db->fetchByAssoc($rE);

        if ($aE['c'] > 0) {
            $qE = 'SELECT id FROM emails WHERE deleted = 0 AND assigned_user_id'.$in.$team.'LIMIT 1';
            $rE = $next->db->query($qE);
            $aE = $next->db->fetchByAssoc($rE);
            $next->retrieve($aE['id']);
            $next->assigned_user_id = $current_user->id;
            $next->save();
            
            header('Location: index.php?module=Emails&action=DetailView&record='.$next->id);
        } else {
            // no free items
            header('Location: index.php?module=Emails&action=ListView&type=inbound&group=true');
        }
    } else {
        // no groups
        header('Location: index.php?module=Emails&action=ListView&type=inbound&group=true');
    }
}
?>
<table width="100%" cellpadding="12" cellspacing="0" border="0">
	<tr>
		<td valign="middle" align="center" colspan="2">
			<?php echo $mod_strings['LBL_LOCK_FAIL_DESC']; ?>
			<br>
			<?php echo $userName.$mod_strings['LBL_LOCK_FAIL_USER']; ?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right" width="50%">
			<a href="index.php?module=Emails&action=ListView&type=inbound&group=true"><?php echo $mod_strings['LBL_BACK_TO_GROUP']; ?></a>
		</td>
		<td valign="middle" align="left">
			<a href="index.php?module=Emails&action=PessimisticLock&next_free=true"><?php echo $mod_strings['LBL_NEXT_EMAIL']; ?></a>
		</td>
	</tr>
</table>
