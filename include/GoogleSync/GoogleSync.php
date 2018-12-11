<?php

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
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Implements Google Calendar Syncing
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
require_once "GoogleSyncBase.php";

class GoogleSync extends GoogleSyncBase
{
    /** @var array An array of user id's we are going to sync for */
    protected $users = array();

    /**
     * Helper method for doSync
     * 
     * @param string $action The action to take with the two events
     * @param Meeting $meeting The CRM Meeting
     * @param \Google_Service_Calendar_Event $event The Google Event
     * 
     * @return bool Success/Failure
     */
    protected function doAction($action, Meeting $meeting = null, Google_Service_Calendar_Event $event = null)
    {
        if ( !empty($meeting) && !empty($event) ) {
            $title = $meeting->name . " / " . $event->getSummary();
        } elseif ( !empty($meeting) ) {
            $title = $meeting->name;
        } elseif ( !empty($event) ) {
            $title = $event->getSummary();
        } else {
            $title = "UNNAMED RECORD"; // Google doesn't require an event to be named.
        }

        switch ($action) {
            case "push":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pushing Record: ' . $title);
                return $this->pushEvent($meeting, $event);
                break;
            case "pull":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pulling Record: ' . $title);
                return $this->pullEvent($event, $meeting);
                break;
            case "skip":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Skipping Record: ' . $title);
                return true;
                break;
            case "push_delete":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Push Deleting Record: ' . $title);
                return $this->delEvent($event, $meeting->id);
                break;
            case "pull_delete":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pull Deleting Record: ' . $title);
                return $this->delMeeting($meeting);
                break;
            default:
                $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unknown Action: ' . $action . ' for record: ' . $title);
                throw new \InvalidArgumentException('Invalid Action');
        }
    }

    /**
     * Perform the sync for a user
     *
     * @param string $id The SuiteCRM user id
     *
     * @return bool Success/Failure
     */
    public function doSync($id)
    {
        if (!$this->setClient($id)) {
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to setup Google Client');
            return false;
        }

        if ($this->workingUser->id == $id) {
            $tz = $this->workingUser->getPreference('timezone', 'global');
            $this->setTimezone($tz);
        } else {
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Failed to set the working user and timezone');
            return false;
        }

        if (!$this->setGService()) {
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to setup Google Service');
            return false;
        }

        if (!$this->setUsersGoogleCalendar()) {
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to setup Google Calendar Id');
            return false;
        }

        $meetings = $this->getUserMeetings();
        if (empty($meetings)) {
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to get Users Meetings');
            return false;
        }

        // First, we look for SuiteCRM meetings that are not on Google
        foreach ($meetings as $meeting) {
            if ( !empty($meeting->gsync_id) ) {
                $gevent = $this->getGoogleEventById($meeting->gsync_id);
            } else {
                $gevent = null;
            }
            
            $action = $this->pushPullSkip($meeting, $gevent);
            $actionResult = $this->doAction($action, $meeting, $gevent);

            if (!$actionResult) {
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - doAction Returned: ' . $actionResult); 
            }
        }

        // Now, we look at the Google Calendar
        $googleEvents = $this->getUserGoogleEvents();
        if (!isset($googleEvents)) {
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to get Google Events');
            return false;
        }

        foreach ($googleEvents as $gevent) {
            if (!$meeting = $this->getMeetingByEventId($gevent->getId())) {
                $meeting = null;
            }

            $action = $this->pushPullSkip($meeting, $gevent);
            $actionResult = $this->doAction($action, $meeting, $gevent);

            if (!$actionResult) {
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - doAction Returned: ' . $actionResult); 
            }
        }
        return true;
    }

    /**
     * Add a user to the list of users to sync
     *
     * The user id is used as the key
     *
     * @param string $id : the SuiteCRM user id
     * @param string $name : the SuiteCRM user name.
     *  Not really used for anything other than reference.
     *
     * @return bool Success/Failure
     */
    protected function addUser($id, $name)
    {
        if (array_key_exists($id, $this->users)) {
            $this->logger->warn(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . $id . ' already set');
            return false;
        } else {
            $this->users[$id] = $name;
            $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . $id . ' set to ' . $this->users[$id]);
            return true;
        }
    }

    /**
     * Helper method for pushPullSkip.
     *
     * When given a single calendar object, determine its type and return an action.
     * At least one of the params is required.
     *
     * @param Meeting $event_local (optional) Meeting Bean
     * @param \Google_Service_Calendar_Event $event_remote (optional) Google_Service_Calendar_Event Object
     *
     * @return string push, pull, skip, or false on error
     */
    protected function singleEventAction(Meeting $event_local = null, Google_Service_Calendar_Event $event_remote = null)
    {
        if (empty($event_local) && empty($event_remote)) {
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'You must pass at least one event');
            return false;
        }
        if (empty($event_local)) {
            if ( $event_remote->status === 'cancelled' || is_null($event_remote->getStart()->getDateTime()) ) {
                // We only pull if the Google Event is not deleted/cancelled and not an all day event.
                return "skip";
            } else {
                return "pull";
            }
        } else {
            if ($event_local->deleted == '0') {
                // We only push if the meeting is not deleted
                return "push";
            } else {
                return "skip";
            }
        }
        return false;
    }

    /**
     * Figure out if we need to push/pull an update, or do nothing.
     *
     * Used when an event w/ a matching ID is on both ends of the sync.
     * At least one of the params is required.
     *
     * @param Meeting|null $event_local (optional) Meeting Bean or Google_Service_Calendar_Event Object
     * @param \Google_Service_Calendar_Event|null $event_remote (optional) Google_Service_Calendar_Event Object
     *
     * @return string|bool 'push(_delete)', 'pull(_delete)', 'skip', false (on error)
     */
    protected function pushPullSkip(Meeting $event_local = null, Google_Service_Calendar_Event $event_remote = null)
    {
        if (empty($event_local) && empty($event_remote)) {
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'You must pass at least one event');
            return false;
        }

        // Did we only get one event?
        if (empty($event_local) || empty($event_remote)) {
            // If we only got one event, figure out which kind it is, and pass the return from the helper method
            return $this->singleEventAction($event_local, $event_remote);
            
        } else {
            // Check if we already sync'ed this event on this run
            if (in_array($event_local->id, $this->syncedList, true)) {
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'We already synced this meeting. Marking to skip.');
                return "skip";
            }

            // Before we get further, if both events are deleted, skip
            if ($event_local->deleted == '1' && $event_remote->status == 'cancelled') {
                return "skip";
            }

            // Get the last modified time from google event
            $gModified = strtotime($event_remote->getUpdated());

            // Get last modified of SuiteCRM event
            $sModified = strtotime($event_local->fetched_row['date_modified'] . ' UTC'); // SuiteCRM stores the timedate as UTC in the DB
            // Get the last sync time of SuiteCRM event
            if (isset($event_local->fetched_row['gsync_lastsync'])) {
                $lastSync = $event_local->fetched_row['gsync_lastsync'];
            } else {
                $lastSync = 0;
            }

            // Event has not been modified since last sync... skip
            if ($gModified <= $lastSync && $sModified <= $lastSync) {
                $this->syncedList[] = $event_local->id;
                return "skip";
            }

            // Event was modified since last sync
            if ($gModified > $lastSync || $sModified > $lastSync) {
                if ($gModified > $sModified) {
                    if ($event_remote->status == 'cancelled') {
                        // if the remote event is deleted, delete it here
                        return "pull_delete";
                    } else {
                        return "pull";
                    }
                } else {
                    if ($event_local->deleted == '1') {
                        return "push_delete";
                    } else {
                        return "push";
                    }
                }
            }
        }

        return false; // we should never get here
    }

    /**
     * Setup array of users to sync
     *
     * Fills the $users array with users that are configured to sync
     *
     * @return int added users
     */
    protected function setSyncUsers()
    {
        $query = "SELECT id FROM users WHERE deleted = '0'";
        $result = $this->db->query($query);

        $counter = 0;
        while ($row = $this->db->fetchByAssoc($result)) {
            $user = BeanFactory::getBean('Users', $row['id']);
            if (!$user) {
                throw new Exception('Unable to get User bean.');
            }

            if (!empty($user->getPreference('GoogleApiToken', 'GoogleSync')) &&
                    json_decode(base64_decode($user->getPreference('GoogleApiToken', 'GoogleSync'))) &&
                    $user->getPreference('syncGCal', 'GoogleSync') == '1') {
                if ($this->addUser($user->id, $user->full_name)) {
                    $counter++;
                }
            }
        }

        return $counter;
    }

    /**
     * Sync All Configured Users
     *
     * Running this method will collect all users who
     * have Calendar Sync Configured and Enabled and
     * Sync them one by one.
     *
     * @return bool Success/Failure
     */
    public function syncAllUsers()
    {

        // First we populate the array of syncable users
        try {
            $ret = $this->setSyncUsers();
        } catch (Exception $e) {
            $this->logger->error(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . '- setSyncUsers() Exception: ' . $e->getMessage());
        }

        if (!$ret) {
            $this->logger->warn(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - There is no user to sync..');
        }

        // We count failures here
        $failures = 0;

        // Then we go though the array and sync the users with doSync()
        if (isset($this->users) && !empty($this->users)) {
            foreach (array_keys($this->users) as $key) {
                $return = null;
                try {
                    $return = $this->doSync($key);
                } catch (Exception $e) {
                    $this->logger->error(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - doSync() Exception: ' . $e->getMessage());
                }
                if (!$return) {
                    $this->logger->error(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - Something went wrong syncing for user id: ' . $key);
                    $failures++;
                }
            }
        }
        if ($failures > 0) {
            $this->logger->warn(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . $failures . ' failure(s) found at syncAllUsers method.');
            return false;
        } else {
            return true;
        }
    }

}