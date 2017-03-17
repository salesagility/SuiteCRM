<?php

trait RemoveUnInvitedFromReminders {
    public function removeUnInvitedFromReminders($reminders) {
        // check reminders against invitees.
        // remove un-invited invitees from any reminders
        // send un-invited invitees an alert informing them that they were un-invited.

        $reminderData = $reminders;
        $uninvited = array();
        foreach($reminders as $r => $reminder) {
            foreach($reminder['invitees'] as $i => $invitee) {
                switch($invitee['module']) {
                    case "Users":
                        if(in_array($invitee['module_id'], $this->users_arr) === false) {
                            // add to uninvited
                            $uninvited[] = $reminderData[$r]['invitees'][$i];
                            // remove user
                            unset($reminderData[$r]['invitees'][$i]);
                        }
                        break;
                    case "Contacts":
                        if(in_array($invitee['module_id'], $this->contacts_arr) === false) {
                            // add to uninvited
                            $uninvited[] = $reminderData[$r]['invitees'][$i];
                            // remove contact
                            unset($reminderData[$r]['invitees'][$i]);
                        }
                        break;
                    case "Leads":
                        if(in_array($invitee['module_id'], $this->leads_arr) === false) {
                            // add to uninvited
                            $uninvited[] = $reminderData[$r]['invitees'][$i];
                            // remove lead
                            unset($reminderData[$r]['invitees'][$i]);
                        }
                        break;
                }
            }
        }
        return $reminderData;
    }
}