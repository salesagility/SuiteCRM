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

require_once __DIR__ . '/GoogleSyncBase.php';
require_once __DIR__ . '/GoogleSyncHelper.php';

/**
 * Implements Google Calendar Syncing
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */

class GoogleSync extends GoogleSyncBase
{
    /** @var array An array of user id's we are going to sync for */
    protected $users = array();

    /**
     * Gets the combined titles of a Meeting/Event pair for Logging
     * 
     * @param Meeting $meeting The CRM Meeting
     * @param \Google_Service_Calendar_Event $event The Google Event
     * 
     * @return string The combined title
     */
    protected function getTitle(Meeting $meeting = null, Google_Service_Calendar_Event $event = null)
    {
        if (!$meeting) {
            // TODO: should it be a user message?
            LoggerManager::getLogger()->warn('GoogleSync is trying to generate title but given meeting is undefined.');
        }
        if (!$event) {
            // TODO: should it be a user message?
            LoggerManager::getLogger()->warn('GoogleSync is trying to generate title but given event is undefined.');
        }
        
        $meetingTitle = isset($meeting) ? $meeting->name : null;
        $eventTitle = isset($event) ? $event->getSummary() : null;

        if ( !empty($meetingTitle) && !empty($eventTitle) ) {
            $title = $meetingTitle . " / " . $eventTitle;
        }
        if ( empty($meetingTitle) || empty($eventTitle) ) {
            $title = $meetingTitle . $eventTitle;
        }
        if ( empty($meetingTitle) && empty($eventTitle) ) {
            $title = "UNNAMED RECORD";
        }
        return $title;
    }

    /**
     * Helper method for doSync
     * 
     * @param string $action The action to take with the two events
     * @param Meeting $meeting The CRM Meeting
     * @param \Google_Service_Calendar_Event $event The Google Event
     * 
     * @return bool Success/Failure
     * @throws GoogleSyncException if $action is invalid.
     * @throws GoogleSyncException if something else fails.
     */
    protected function doAction($action, Meeting $meeting = null, Google_Service_Calendar_Event $event = null)
    {

        $title = $this->getTitle($meeting, $event);

        switch ($action) {
            case "push":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pushing Record: ' . $title);
                $ret = $this->pushEvent($meeting, $event);
                break;
            case "pull":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pulling Record: ' . $title);
                $ret = $this->pullEvent($event, $meeting);
                break;
            case "skip":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Skipping Record: ' . $title);
                $ret = true;
                break;
            case "push_delete":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Push Deleting Record: ' . $title);
                $ret = $this->delEvent($event, $meeting->id);
                break;
            case "pull_delete":
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pull Deleting Record: ' . $title);
                $ret = $this->delMeeting($meeting);
                break;
            default:
                // TODO: fatal does not necessary since it throws an exception
                $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unknown Action: ' . $action . ' for record: ' . $title);
                throw new GoogleSyncException('Unknown Action: ' . $action . ' for record: ' . $title, GoogleSyncException::INVALID_ACTION);
        }

        if ($ret) {
            $this->syncedList[] = $ret;
            return true;
        }
        //else
        throw new GoogleSyncException('Something went wrong with the requested action');
    }

    /**
     * Perform the sync for a user
     *
     * @param string $id The SuiteCRM user id
     *
     * @return bool Success/Failure
     * @throws Exception Rethrows if caught from GoogleSyncBase::initUserService
     */
    public function doSync($id)
    {
        try {
            $this->initUserService($id);
        } catch (Exception $e) {
            // TODO: handle the exception instead just loggin it, it will be logged if unhandled by suitecrm core.
            $this->logger->fatal('Caught exception: ',  $e->getMessage());
            throw $e;
        }

        $meetings = $this->getUserMeetings($id);
        if (empty($meetings)) {
            // TODO: It should be an exception
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to get Users Meetings');
            return false;
        }

        // First, we look for SuiteCRM meetings that are not on Google
        foreach ($meetings as $meeting) {
            $gevent = null;
            if ( !empty($meeting->gsync_id) ) {
                $gevent = $this->getGoogleEventById($meeting->gsync_id);
            }
            
            $action = $this->pushPullSkip($meeting, $gevent);
            $actionResult = $this->doAction($action, $meeting, $gevent);

            if (!$actionResult) {
                // TODO: confusing info log: $actionResult evaluated as string but it also false if converted to boolean. There is an empty string in log as result. - TODO: Inform the caller about this problem (exception?)
                $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - doAction Returned: ' . $actionResult); 
            }
        }

        // Now, we look at the Google Calendar
        $googleEvents = $this->getUserGoogleEvents();
        if (!isset($googleEvents)) { // TODO: if condition never be true, as $googleEvents is definitely set just one line before.
            // TODO: It should be an exception
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to get Google Events');
            return false;
        }

        foreach ($googleEvents as $gevent) {
            $meeting = $this->getMeetingByEventId($gevent->getId());
            $action = $this->pushPullSkip($meeting, $gevent);
            $actionResult = $this->doAction($action, $meeting, $gevent);

            if (!$actionResult) {
                // TODO: Inform the caller about this problem (exception?)
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
        }
        $this->users[$id] = $name;
        $this->logger->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . $id . ' set to ' . $this->users[$id]);
        return true;
    }

    /**
     * Figure out if we need to push/pull an update, or do nothing.
     *
     * Used when an event w/ a matching ID is on both ends of the sync.
     * At least one of the params is required.
     *
     * @param Meeting|null $meeting (optional) Meeting Bean or Google_Service_Calendar_Event Object
     * @param \Google_Service_Calendar_Event|null $event (optional) Google_Service_Calendar_Event Object
     *
     * @return string|bool 'push(_delete)', 'pull(_delete)', 'skip', false (on error)
     */
    protected function pushPullSkip(Meeting $meeting = null, Google_Service_Calendar_Event $event = null)
    {
        if (empty($meeting) && empty($event)) {
            // TODO: It should be an exception
            $this->logger->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'You must pass at least one event');
            return false;
        }

        $helper =  new GoogleSyncHelper;

        // Did we only get one event?
        if (empty($meeting) || empty($event)) {
            // If we only got one event, figure out which kind it is, and pass the return from the helper method
            return $helper->singleEventAction($meeting, $event);
        }

        // Get array of timestamps for this event
        $timeArray = $helper->getTimeStrings($meeting, $event);

        // Can we skip this event?
        if ($helper->isSkippable($meeting, $event, $timeArray, $this->syncedList)) {
            return "skip";
        }

        // Event was modified since last sync
        return $helper->getNewestMeetingResponse($meeting, $event, $timeArray);
    }

    /**
     * Setup array of users to sync
     *
     * Fills the $users array with users that are configured to sync
     *
     * @return int added users
     * @throws E_RecordRetrievalFail if unable to get user bean
     */
    protected function setSyncUsers()
    {
        $query = "SELECT id FROM users WHERE deleted = '0'";
        $result = $this->db->query($query);

        $counter = 0;
        while ($row = $this->db->fetchByAssoc($result)) {
            $user = BeanFactory::getBean('Users', $row['id']);
            if (!$user) {
                throw new E_RecordRetrievalFail('Unable to get User bean.');
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
            // TODO: handle the exception instead just loggin it, it will be logged if unhandled by suitecrm core.
            $this->logger->error(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . '- setSyncUsers() Exception: ' . $e->getMessage());
        }

        if (!$ret) {
            // TODO: Inform the caller about this problem (exception?)
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
                    // TODO: handle the exception instead just loggin it, it will be logged if unhandled by suitecrm core.
                    $this->logger->error(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - doSync() Exception: ' . $e->getMessage());
                }
                if (!$return) {
                    // TODO: Inform the caller about this problem (return value could be an integer?)
                    $this->logger->error(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - Something went wrong syncing for user id: ' . $key);
                    $failures++;
                }
            }
        }
        if ($failures == 0) {
            return true;
        }
        $this->logger->warn(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . $failures . ' failure(s) found at syncAllUsers method.');
        return false;
    }

}