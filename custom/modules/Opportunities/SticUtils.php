<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

class OpportunitiesUtils
{
    /**
     * This function is used mainly by the Scheduler to remind users about opportunities approaching due date.
     * We place it in this file in order to be accessed by the controller as well.
     * 
     * It checks the opportunities that are near the due date, and sends an email to the assigned user of the Opportunity. If the assigned user
     * of the record can't be reached, it will send the email to the assigned user of the Scheduler.
     * 
     * 1) It will send an email to the user assigned in the opportunity's record one week before one of these deadlines:
     * - Presentation date
     * - Justification date
     *
     * 2) It will also be sent one day before these deadlines:
     * - Presentation date
     * - Justification date
     * - Resolution date
     * - Andvance date
     * - Payment date
     **/
    public static function opportunitiesReminder() {
        global $current_user, $db, $mod_strings, $sugar_config;
        
        // Select those opportunities that might be candidate to be reminded. All opportunities excluding cancelled, justified or denied. 
        $query = "SELECT id, name, assigned_user_id, 
                date_add(stic_presentation_date_c, INTERVAL -7 DAY) AS presentationDate7, 
                date_add(stic_justification_date_c, INTERVAL -7 DAY) AS justificationDate7,	
                date_add(stic_presentation_date_c, INTERVAL -1 DAY) AS stic_presentation_date_c, 
                date_add(stic_resolution_date_c, INTERVAL -1 DAY) AS stic_resolution_date_c,
                date_add(stic_justification_date_c, INTERVAL -1 DAY) AS stic_justification_date_c, 
                date_add(stic_advance_date_c, INTERVAL -1 DAY) AS stic_advance_date_c, 
                date_add(stic_payment_date_c, INTERVAL -1 DAY) AS stic_payment_date_c  
                FROM opportunities 
                INNER JOIN opportunities_cstm ON id = id_c 
                WHERE deleted = 0 AND stic_status_c NOT IN ('justified', 'cancelled', 'denied')";

        $result = $db->query($query);
        if(!$result){
            $GLOBALS['log']->fatal('Line ' . __LINE__ . ': ' . __METHOD__ . ': Error query: Scheduler function - opportunitiesReminder');
            return false;
        }
        $dates = array('presentationDate7', 'justificationDate7', 'stic_presentation_date_c', 'stic_resolution_date_c', 'stic_justification_date_c', 'stic_advance_date_c', 'stic_payment_date_c');
        $today = date("Y-m-d");
        while($row = $db->fetchByAssoc($result)){
            // We check if we need to notify of any hot opportunity
            $sendEmail = false;    
            foreach($dates as $value){
                if($row[$value] == $today){
                    $sendEmail = true;
                    break;
                }
            }
            
            if($sendEmail) {
                // We first send the email to the user assigned to the opportunity
                $user = null;
                if (!empty($row['assigned_user_id'])) {
                    $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ":  Retrieving user data [{$row['assigned_user_id']}] assigned to the opportunity [{$row['id']} - {$row['name']}]...");
                    $user = BeanFactory::getBean('Users', $row['assigned_user_id']);
                } 
            
                // If we can't retrieve the user assigned, we use the user that runs the Scheduler
                if (empty($user)) {
                    $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ":  We can't retrieve the user assigned to the opportunity [{$row['id']} - {$row['name']}]. The email will be sent to the user assigned in the scheduler record, normally an admin [{$current_user->id}].");
                    $user = $current_user;
                }
                
                $address = null;
                if (!$user->emailAddress || !($address = $user->emailAddress->getPrimaryAddress($user))) {
                    $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ": The user with id [{$user->id}] doesn't have an email address, then we can't send the notification.");
                    return false;
                } else {
                    $opportunityLink = rtrim($sugar_config['site_url'], '/').'/index.php?module=Opportunities&action=DetailView&record='.$row['id'];
                                    
                    require_once('include/SugarPHPMailer.php');
                    $mail = new SugarPHPMailer();

                    require_once('modules/Emails/Email.php');
                    $emailObj = new Email();
                    $defaults = $emailObj->getSystemDefaultEmail();

                    $mail->From = $defaults['email'];
                    $mail->FromName = $defaults['name'];

                    $mail->ClearAllRecipients();
                    $mail->ClearReplyTos();

                    $mail->AddAddress($address, $user->first_name.' '.$user->last_name);
                    $mail->Subject = $mod_strings['LBL_EMAIL_OPPORTUNITIES_SUBJECT'].$row['name'];
                    $mail->Body = $mod_strings['LBL_EMAIL_OPPORTUNITIES_BODY_1'].$row['name'].$mod_strings['LBL_EMAIL_OPPORTUNITIES_BODY_2']."\n\n".$opportunityLink;
                    $mail->IsHTML(false); 
                    $mail->prepForOutbound();
                    $mail->setMailerForSystem();

                    //Send the message, log if error occurs
                    if (!$mail->Send()) {
                        $GLOBALS['log']->fatal('Line ' . __LINE__ . ': ' . __METHOD__ . ": Error send the notification email.");
                        return false;
                    }
                    return true;
                }
            }
        }
        return true;
    }

    /**
     * Create Participants in an Opportunity: All Accounts in $accountIds will be Participants in the $opportunityBean
     */
    public static function createParticipantsFromAccounts($accountIds, $opportunityBean) {
        // For each AccountId in $accountIds: Create a Participant with this $opportunityBean

        global $current_user;

        foreach($accountIds as $accountId) {
            $accountBean = BeanFactory::getBean('Accounts', $accountId);
            
            $participantBean = BeanFactory::newBean('stic_Group_Opportunities');

            // Assign Account and Opportunity
            $participantBean->stic_group_opportunities_accountsaccounts_ida = $accountId;
            $participantBean->stic_group_opportunities_opportunitiesopportunities_ida = $opportunityBean->id;

            // Assign other data
            $participantBean->name = $accountBean->name . ' - ' . $opportunityBean->name;
            $participantBean->status = "guest";
            $participantBean->assigned_user_id = $current_user->id;

            $participantBean->save();
        }
    }
}