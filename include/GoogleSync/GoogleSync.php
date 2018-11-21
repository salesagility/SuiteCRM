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

class GoogleSync
{

    /** @var array An array of user id's we are going to sync for */
    public $users = array();

    /** @var User The SuiteCRM User Bean we're currently working with */
    public $workingUser;

    /** @var \Google_Client The Google client object for the current sync job */
    public $gClient;

    /** @var \Google_Service_Calendar The Google Calendar Service Object */
    public $gService;

    /** @var array The Google AuthcConfig json */
    public $authJson = array();

    /** @var string The local timezone */
    public $timezone;

    /** @var string The Calendar ID */
    public $calendarId;

    /** @var array An array of SuiteCRM meeting id's that we've already synced this session */
    public $syncedList = array();

    /** @var object A Database Instance */
    private $db;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        // This sets the log level to a variable that can be set on the command line while running cron.php on the server. It's for debugging only.
        // EXAMPLE: $ GSYNC_LOGLEVEL=debug php cron.php
        if (isset($_SERVER['GSYNC_LOGLEVEL'])) {
            LoggerManager::getLogger()->setLevel($_SERVER['GSYNC_LOGLEVEL']);
            LoggerManager::getLogger()->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Log Level Set to: ' . $_SERVER['GSYNC_LOGLEVEL']);
        }
        $this->timezone = date_default_timezone_get(); // This defaults to the server timezone. Overridden later.
        $this->authJson = $this->getAuthJson();
        $this->db = DBManagerFactory::getInstance();
        LoggerManager::getLogger()->debug(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . '__construct');
    }

    /**
     * Gets the auth json string from the system
     *
     * @return array|false json on success, false on failure
     */
    public function getAuthJson()
    {
        global $sugar_config;
        $authJson_local = json_decode(base64_decode($sugar_config['google_auth_json']), true);
        if (!$authJson_local) {
        // The authconfig json string is invalid json
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'AuthConfig is not proper JSON string');
            return false;
        } elseif (!array_key_exists('web', $authJson_local)) {
            // The authconfig is valid json, but the 'web' key is missing. This is not a valid authconfig.
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'AuthConfig is missing required [web] key');
            return false;
        } else {
            return $authJson_local;
        }
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
    public function addUser($id, $name)
    {
        if (array_key_exists($id, $this->users)) {
            $GLOBALS['log']->warn(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . $id . ' already set');
            return false;
        } else {
            $this->users[$id] = $name;
            $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . $id . ' set to ' . $this->users[$id]);
            return true;
        }
    }

    /**
     * Remove a user from the list of users to sync
     *
     * @param string $id : the SuiteCRM user id
     *
     * @return bool Success/Failure
     */
    public function delUser($id)
    {
        if (!array_key_exists($id, $this->users)) {
            $GLOBALS['log']->warn(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . $id . ' missing');
            return false;
        } else {
            unset($this->users[$id]);
            return true;
        }
    }

    /**
     * Creates and Sets the Google client in the object
     *
     * @param string $id : the SuiteCRM user id
     *
     * @return bool Success/Failure
     */
    public function setClient($id)
    {
        if (!$gClient_local = $this->getClient($id)) {
            return false;
        } else {
            $this->gClient = $gClient_local;
            return true;
        }
    }

    /**
     * Set the Google client up for the user by id
     *
     * @param string $id : the SuiteCRM user id
     *
     * @return \Google_Client|false Google_Client on success. False on failure.
     */
    public function getClient($id)
    {
        // Retrieve user bean
        if (!isset($this->workingUser)) {
            $this->workingUser = new User();
        }

        $this->workingUser->retrieve($id);

        // Retrieve Access Token JSON from user preference
        $accessToken = json_decode(base64_decode($this->workingUser->getPreference('GoogleApiToken', 'GoogleSync')), true);
        if (!array_key_exists('access_token', $accessToken)) {
        // The Token is invalid JSON or missing
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Invalid or Missing AuthToken');
            return false;
        }
        // The refresh token is only provided once, on first authentication. It must be added afterwards.
        if (!array_key_exists('refresh_token', $accessToken)) {
            $accessToken['refresh_token'] = base64_decode($this->workingUser->getPreference('GoogleApiRefreshToken', 'GoogleSync'));
        }

        // New Google Client
        $client = new Google_Client();
        $client->setApplicationName('SuiteCRM');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setAuthConfig($this->authJson);
        $client->setAccessToken($accessToken);

        // Refresh the token if needed
        if ($client->isAccessTokenExpired()) {
            $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Refreshing Access Token');
            $refreshToken = $client->getRefreshToken();
            $client->fetchAccessTokenWithRefreshToken($refreshToken);
            // Save new token to user preference
            $this->workingUser->setPreference('GoogleApiToken', base64_encode(json_encode($client->getAccessToken())), 'GoogleSync');
            $this->workingUser->savePreferencesToDB();
        }
        return $client;
    }

    /**
     * Retrieve List of meetings owned by the Current Working User
     *
     *
     * @return array Array of SuiteCRM Meeting Beans
     */
    public function getUserMeetings()
    {

        // We do it this way so we also get deleted meetings
        $query = "SELECT id FROM meetings WHERE assigned_user_id = '" . $this->workingUser->id . "' AND date_start <= now() + interval 3 month";
        $result = $this->db->query($query);

        $meetings = array();
        require_once('modules/Meetings/Meeting.php');
        while ($row = $this->db->fetchByAssoc($result)) {
            $meeting = new Meeting();
            $meeting->retrieve($row['id'], true, false);
            $meetings[] = $meeting;
        }
        return $meetings;
    }

    /**
     * Set user's google calendar id
     *
     *
     * @return bool Success/Failure
     */
    public function setUsersGoogleCalendar()
    {

        // Make sure we have a Google Calendar Service instance
        if (!isset($this->gService)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'The Google Service is not set up. See setGService Method.');
            return false;
        }

        // get list of users calendars
        $calendarList = $this->gService->calendarList->listCalendarList();

        // find the id of the 'SuiteCRM' calendar ... this may stay or go
        foreach ($calendarList->getItems() as $calendarListEntry) {
            if ($calendarListEntry->getSummary() == 'SuiteCRM') {
                $this->calendarId = $calendarListEntry->getId();
                break;
            }
        }

        // if the SuiteCRM calendar doesn't exist... Create it!
        if (!isset($this->calendarId)) {
            $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to find the SuiteCRM Google Calendar, Creating it!');
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary('SuiteCRM');
            $calendar->setTimeZone($this->timezone);

            $createdCalendar = $this->gService->calendars->insert($calendar);
            $this->calendarId = $createdCalendar->getId();
        }

        // Final check to make sure we have an ID
        if (!isset($this->calendarId)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to find the SuiteCRM Google Calendar, and creation failed.');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get events in users google calendar
     *
     *
     * @return array Array of Google_Service_Calendar_Event Objects
     */
    public function getUserGoogleEvents()
    {

        // Make sure we have a Google Calendar Service instance
        if (!isset($this->gService)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'The Google Service is not set up. See setGService Method.');
            return false;
        }

        // Make sure we have a calendar id
        if (!isset($this->calendarId)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'The calendar ID is not set. See setUsersGoogleCalendar Method');
            return false;
        }

        // Set Options for what events we get from Google
        $optParams = array(
            'maxResults' => 500,
            'showDeleted' => true,
            'singleEvents' => true,
            'timeMin' => date('c', strtotime('-1 month')),
            'timeMax' => date('c', strtotime('+3 month')),
        );

        $results_g = $this->gService->events->listEvents($this->calendarId, $optParams);

        // We only want the events, not the leading cruft
        $results = $results_g->getItems();

        if (empty($results)) {
            $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'No events found.');
            return array();
        } else {
            $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Found ' . count($results) . ' Google Events');
            return $results;
        }
    }

    /**
     * Get a google event by the matching SuiteCRM meeting id
     *
     * @param string $meeting_id SuiteCRM Meeting ID
     *
     * @return \Google_Service_Calendar_Event A Google_Service_Calendar_Event Object
     */
    public function getGoogleEventByMeetingId($meeting_id)
    {

        // Make sure the calendar service is set up
        if (!isset($this->gService)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'The Google Service is not set up. See setGService Method.');
            return false;
        }

        // Set Options for what events we get from Google
        $optParams = array(
            'maxResults' => 2, // We ask for a max of 2 because we should *NEVER* get more than 1. If we get 2, something is horribly wrong.
            'showDeleted' => true,
            'singleEvents' => false,
            'timeMin' => date('c', strtotime('-6 month')),
            'privateExtendedProperty' => 'suitecrm_id=' . $meeting_id
        );

        $results_g = $this->gService->events->listEvents($this->calendarId, $optParams);
        $results = $results_g->getItems();

        if (count($results) > 1) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'We received more than one Google event with the same SuiteCRM meeting ID. Something is horribly wrong!');
            return false;
        } elseif (count($results) == 0) { // No events match. Return emtpy array.
            return array();
        } else {
            $gEvent = $results[0];
            return $gEvent;
        }
    }

    /**
     * Get a google event by the event id
     *
     * @param string $event_id Google Event ID
     *
     * @return \Google_Service_Calendar_Event|null Google_Service_Calendar_Event if found, null if not found
     */
    public function getGoogleEventById($event_id)
    {

        // Make sure the calendar service is set up
        if (!isset($this->gService)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'The Google Service is not set up. See setGService Method.');
            return false;
        }

        if (empty($event_id)) {
         // If we didn't get passed an event, return null
            return;
        }

        $gEvent = $this->gService->events->get($this->calendarId, $event_id);

        if (!empty($gEvent->getId())) {
            return $gEvent;
        } else {
            return null;
        }
    }

    /**
     * Find a missing event on users calendars
     *
     * This is an expensive method. It searches *all* the users calendars for a missing event,
     * moves it back to the SuiteCRM calendar, and returns the moved event.
     *
     * @param string $event_id The Google Event Id
     *
     * @return \Google_Service_Calendar_Event|null Google_Service_Calendar_Event if found, null if not found
     */
    public function getMissingMeeting($event_id)
    {
        // get list of users calendars
        $calendarList = $this->gService->calendarList->listCalendarList();

        // Search all calendars looking for event
        foreach ($calendarList->getItems() as $calendarListEntry) {
            if ($gEvent = $this->gService->events->get($calendarListEntry->getId(), $event_id)) {
                $foundOnCalendar = $calendarListEntry->getId();
                break;
            }
        }
        if (isset($foundOnCalendar)) {
            $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Found Event on Calendar ID: ' . $foundOnCalendar);
            $result = $this->gService->events->move($foundOnCalendar, $event_id, $this->calendarId);
            return $result;
        } else {
            $GLOBALS['log']->warn(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to find missing Calendar Event');
            return null;
        }
    }

    /**
     * Get a SuiteCRM meeting by Google Event ID
     *
     * @param string $event_id The Google Event ID
     *
     * @return \Meeting SuiteCRM Meeting Bean if found, false on error, null if not found
     */
    public function getMeetingByEventId($event_id)
    {

        // We do it this way so we also get deleted meetings
        $query = "SELECT id FROM meetings WHERE gsync_id = '{$event_id}'";
        $result = $this->db->query($query);

        // This checks to make sure we only get one result. If we get more than one, something is inconsistant in the DB
        if ($result->num_rows > 1) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'More than one meeting matches Google Id: ' . $event_id);
            return false;
        } elseif ($result->num_rows == 0) {
            return; // No matches Found
        }

        $meeting = new Meeting;
        $row = $this->db->fetchByAssoc($result);
        $meeting->retrieve($row['id'], true, false);

        return $meeting;
    }

    /**
     * Creates and Sets $this->gService to a valid Google Calendar Service
     *
     * @return bool Success/Failure
     */
    public function setGService()
    {
        // make sure we have a client set
        if (!isset($this->gClient)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'The Google Client is not set up. See setClient Method');
            return false;
        }

        // create new calendar service
        $this->gService = new Google_Service_Calendar($this->gClient);
        if (isset($this->gService)) {
            return true;
        } else {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Setting $this->gService Failed');
            return false;
        }
    }

    /**
     * Figure out if we need to push/pull an update, or do nothing.
     *
     * Used when an event w/ a matching ID is on both ends of the sync.
     *
     * @param Meeting|\Google_Service_Calendar_Event $event_1 Either the Meeting Bean or Google_Service_Calendar_Event Object
     * @param \Google_Service_Calendar_Event $event_2 (optional) Google Event
     *
     * @return string push(_delete), pull(_delete), skip
     */
    public function pushPullSkip($event_1, $event_2 = null)
    {
        if ((!isset($event_1) || empty($event_1)) && (!isset($event_2) || empty($event_2))) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'You must pass at least one event');
            return false;
        }

        // If we only got one event, figure out which kind it is
        if (!isset($event_2) || empty($event_2)) {
            switch (get_class($event_1)) {
                case "Google_Service_Calendar_Event":
                    if ($event_1->status !== 'cancelled') {
                     // We only pull if the Google Event is not deleted/cancelled
                        $return = "pull";
                    } else {
                        $return = "skip";
                    }
                    break;
                case "Meeting":
                    if ($event_1->deleted == '0') {
                     // We only push if the meeting is not deleted
                        $return = "push";
                    } else {
                        $return = "skip";
                    }
                    break;
                default:
                    $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'I don\'t understand the event type you used.');
                    $return = false;
            }
            // Only one event, we're done here
            return $return;
        } else {

            // We have two events... figure out which is which and set the internal objects
            $obj_class1 = get_class($event_1);
            if ($obj_class1 == 'Meeting') {
                $event_local = $event_1;
            } elseif ($obj_class1 == 'Google_Service_Calendar_Event') {
                $event_remote = $event_1;
            } else {
                $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Events must be of type \'Meeting\' or \'Google_Service_Calendar_Event\'');
                return false;
            }

            $obj_class2 = get_class($event_2);
            if ($obj_class2 == 'Meeting') {
                $event_local = $event_2;
            } elseif ($obj_class2 == 'Google_Service_Calendar_Event') {
                $event_remote = $event_2;
            } else {
                $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Events must be of type \'Meeting\' or \'Google_Service_Calendar_Event\'');
                return false;
            }

            if (in_array($event_local->id, $this->syncedList, true)) {
                $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'We already synced this meeting. Marking to skip.');
                return "skip";
            }

            // We don't need the original vars now
            unset($event_1);
            unset($event_2);

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

        return "unknown"; // we should never get here
    }

    /**
     * Push event from SuiteCRM to Google Calendar
     *
     * If the google event is not provided, a new one will be created
     * and inserted. If one is provided, the existing Google Event will
     * be updated.
     *
     * @param Meeting $event_local : SuiteCRM Meeting Bean
     * @param \Google_Service_Calendar_Event $event_remote (optional) \Google_Service_Calendar_Event Object
     *
     * @return bool Success/Failure
     */
    public function pushEvent($event_local, $event_remote = null)
    {

        if (!isset($event_remote) || empty($event_remote)) {
            $event = $this->createGoogleCalendarEvent($event_local);
            $return = $this->gService->events->insert($this->calendarId, $event);
        } else {
            $event = $this->updateGoogleCalendarEvent($event_local, $event_remote);
            $return = $this->gService->events->update($this->calendarId, $event->getId(), $event);
        }

        // Set the SuiteCRM Meeting's last sync timestamp, and google id
        $this->setLastSync($event_local, $return->getId());

        /* We don't get a status code back showing success. Instead, the return of the
         * create or update is the Google_Service_Calendar_Event object after saving. 
         * So we check to make sure it has an ID to determine Success/Failure.
         */
        if (isset($return->id)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Pull event from Google Calendar to SuiteCRM
     *
     * If the SuiteCRM Meeting is not provided, a new one will be created
     * and inserted. If one is provided, the existing meeting will be updated.
     *
     * @param \Google_Service_Calendar_Event $event_remote \Google_Service_Calendar_Event Object
     * @param Meeting $event_local Meeting (optional) \Meeting Bean
     *
     * @return bool Success/Failure of setLastSync, since that's what saves the record
     */
    public function pullEvent($event_remote, $event_local = null)
    {

        if (!isset($event_local) || empty($event_local)) {
            $event = $this->createSuitecrmMeetingEvent($event_remote);
        } else {
            $event = $this->updateSuitecrmMeetingEvent($event_local, $event_remote);
        }

        // We need to set the suitecrm_ private properties in the Google event here,
        // Otherwise it's seen as a new event next time we sync

        // We pull the existing extendedProperties, and change our values
        // That way we don't mess with anything else that's using other values.
        $extendedProperties = $event_remote->getExtendedProperties();

        if (!empty($extendedProperties)) {
            $private = $extendedProperties->getPrivate();
        } else {
            $extendedProperties = new Google_Service_Calendar_EventExtendedProperties;
            $private = array();
        }

        $private['suitecrm_id'] = $event->id;
        $private['suitecrm_type'] = $event->module_name;

        $extendedProperties->setPrivate($private);

        $event_remote->setExtendedProperties($extendedProperties);

        $greturn = $this->gService->events->update($this->calendarId, $event_remote->getId(), $event_remote);

        /* We don't get a status code back showing success. Instead, the return of the
         * create or update is the Google_Service_Calendar_Event object after saving.
         * So we check to make sure it has an ID to determine Success/Failure.
         */
        if (isset($greturn->id)) {
            return $this->setLastSync($event, $event_remote->getId());
        } else {
            return false;
        }
    }

    /**
     * Delete SuiteCRM Meeting
     *
     * @param Meeting $meeting SuiteCRM Meeting Bean
     *
     * @return bool Success/Failure of setLastSync, since that's what saves the record
     */
    public function delMeeting($meeting)
    {
        $meeting->deleted = '1';
        $meeting->gsync_id = '';
        return $this->setLastSync($meeting);
    }

    /**
     * Delete Google Event
     *
     * @param \Google_Service_Calendar_Event $event \Google_Service_Calendar_Event Object
     * @param String $meeting_id SuiteCRM Meeting Id
     *
     * @return bool Success/Failure
     */
    public function delEvent($event, $meeting_id)
    {
        // Make sure the calendar service is set up
        if (!isset($this->gService)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'The Google Service is not set up. See setGService Method.');
            return false;
        }

        // Make sure we got a meeting_id
        if (!isset($meeting_id)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'This function requires a meeting id as the 2nd parameter');
            return false;
        }

        $return = $this->gService->events->delete($this->calendarId, $event->getId());

        // Pull the status code returned to determine Success/Failure
        $statusCode = $return->getStatusCode();

        if ($statusCode >= 200 && $statusCode <= 299) {
         // 2xx statusCode = success
            $GLOBALS['log']->debug(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Received Success Status Code: ' . $statusCode . ' on delete.');

            // This removes the gsync_id reference from the table.
            $sql = "UPDATE Meetings SET gsync_id = '' WHERE id = '" . $meeting_id . "'";
            $res = $this->db->query($sql);

            $this->syncedList[] = $meeting_id;
            return true;
        } else {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Received Failure Status Code: ' . $statusCode . ' on delete!');
            return false;
        }
    }

    /**
     * Update SuiteCRM Meeting from Google Calendar Event
     *
     * @param Meeting $event_local SuiteCRM Meeting Bean
     * @param \Google_Service_Calendar_Event $event_remote Google_Service_Calendar_Event Object
     *
     * @return Meeting SuiteCRM Meeting Bean
     */
    public function updateSuitecrmMeetingEvent($event_local, $event_remote)
    {

        if ((!isset($event_local) || empty($event_local)) || (!isset($event_remote) || empty($event_remote))) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'ERROR:Missing Variables');
            return false;
        }

        $event_local->name = $event_remote->getSummary();
        $event_local->description = $event_remote->getDescription();
        $event_local->location = $event_remote->getLocation();

        // Get Start/End/Duration from Google Event
        $starttime = strtotime($event_remote->getStart()['dateTime']);
        $endtime = strtotime($event_remote->getEnd()['dateTime']);
        $diff = abs($starttime - $endtime);
        $tmins = $diff/60;
        $hours = floor($tmins/60);
        $mins = $tmins%60;

        // Set Start/End/Duration in SuiteCRM Meeting and Assigned User
        $event_local->date_start = date("m/d/Y h:i:sa", $starttime);
        $event_local->date_end = date("m/d/Y h:i:sa", $endtime);
        $event_local->duration_hours = $hours;
        $event_local->duration_minutes = $mins;
        $event_local->assigned_user_id = $this->workingUser->id;

        // Disable all popup reminders for the SuiteCRM meeting
        $sql = "UPDATE reminders SET popup = '0' WHERE related_event_module_id = '" .
            $event_local->id .
            "' AND deleted = '0'";
        $res = $this->db->query($sql);

        // Mark all reminders where both popup and email are disabled as deleted.
        $sql = "UPDATE reminders SET deleted = '1' " .
            "WHERE popup = '0' AND email = '0' AND related_event_module_id = '" .
            $event_local->id .
            "' AND deleted = '0'";
        $res = $this->db->query($sql);

        // Get Google Event Popup Reminders
        $gReminders = $event_remote->getReminders();
        $overrides = $gReminders->getOverrides();

        // Create a new popup reminder for each google reminder
        foreach ($overrides as $override) {
            if ($override->getMethod() == 'popup') {
                $sReminder = new Reminder;
                $sReminder->popup = '1';
                $sReminder->timer_popup = $override->getMinutes() * 60;
                $sReminder->related_event_module = $event_local->module_name;
                $sReminder->related_event_module_id = $event_local->id;
                $reminderId = $sReminder->save(false);

                $reminderInvitee = new Reminder_Invitee;
                $reminderInvitee->reminder_id = $reminderId;
                $reminderInvitee->related_invitee_module = 'Users';
                $reminderInvitee->related_invitee_module_id = $this->workingUser->id;
                $reminderInvitee->save(false);
            }
        }
        return  $event_local;
    }

    /**
     * Create SuiteCRM Meeting event
     *
     * @param \Google_Service_Calendar_Event $event_remote The Google_Service_Calendar_Event we're creating a SuiteCRM Meeting for
     *
     * @return Meeting SuiteCRM Meeting Bean
     */
    public function createSuitecrmMeetingEvent($event_remote)
    {
        $GLOBALS['log']->debug(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Creating New SuiteCRM Meeting');
        $meeting = new Meeting;
        $meeting->id = create_guid();
        $meeting->new_with_id = true;
        $event_local = $this->updateSuitecrmMeetingEvent($meeting, $event_remote);
        return $event_local;
    }

    /**
     * Update Google Calendar Event from SuiteCRM Meeting
     *
     * @param Meeting $event_local SuiteCRM Meeting Bean
     * @param \Google_Service_Calendar_Event $event_remote Google Event Object
     *
     * @return \Google_Service_Calendar_Event
     */
    public function updateGoogleCalendarEvent($event_local, $event_remote)
    {

        if ((!isset($event_local) || empty($event_local)) || (!isset($event_remote) || empty($event_remote))) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'ERROR:Missing Variables');
            return false;
        }

        $event_remote->setSummary($event_local->name);
        $event_remote->setDescription($event_local->description);
        $event_remote->setLocation($event_local->location);

        $startDateTime = new Google_Service_Calendar_EventDateTime;
        $startDateTime->setDateTime(date(DATE_ATOM, strtotime($event_local->date_start)));
        $startDateTime->setTimeZone($this->timezone);
        $event_remote->setStart($startDateTime);

        $endDateTime = new Google_Service_Calendar_EventDateTime;
        $endDateTime->setDateTime(date(DATE_ATOM, strtotime($event_local->date_end)));
        $endDateTime->setTimeZone($this->timezone);
        $event_remote->setEnd($endDateTime);

        // We pull the existing extendedProperties, and change our values
        // That way we don't mess with anything else that's using other values.
        $extendedProperties = $event_remote->getExtendedProperties();

        if (!empty($extendedProperties)) {
            $private = $extendedProperties->getPrivate();
        } else {
            $extendedProperties = new Google_Service_Calendar_EventExtendedProperties;
            $private = array();
        }

        $private['suitecrm_id'] = $event_local->id;
        $private['suitecrm_type'] = $event_local->module_name;

        $extendedProperties->setPrivate($private);
        $event_remote->setExtendedProperties($extendedProperties);

        // Copy over popup reminders
        $event_local_id = $event_local->id;
        $reminders_local = BeanFactory::getBean('Reminders')->get_full_list(
            "",
            "reminders.related_event_module = 'Meetings'" .
            " AND reminders.related_event_module_id = '$event_local_id'" .
            " AND popup = '1'"
        );

        if ($reminders_local) {
            $reminders_remote = new Google_Service_Calendar_EventReminders;
            $reminders_remote->setUseDefault(false);
            $reminders_array = array();
            foreach ($reminders_local as $reminder_local) {
                $reminder_remote = new Google_Service_Calendar_EventReminder;
                $reminder_remote->setMethod('popup');
                $reminder_remote->setMinutes($reminder_local->timer_popup / 60);
                $reminders_array[] = $reminder_remote;
            }
            $reminders_remote->setOverrides($reminders_array);
            $event_remote->setReminders($reminders_remote);
        }
        return $event_remote;
    }

    /**
     * Create New Google Event object for SuiteCRM Meeting
     *
     * @param Meeting $event_local SuiteCRM Meeting Bean
     *
     * @return \Google_Service_Calendar_Event Google_Service_Calendar_Event Object
     */
    public function createGoogleCalendarEvent($event_local)
    {

        //We're creating a new event
        $event_remote_empty = new Google_Service_Calendar_Event;

        $extendedProperties = new Google_Service_Calendar_EventExtendedProperties;
        $extendedProperties->setPrivate(array());

        $event_remote_empty->setExtendedProperties($extendedProperties);

        //Set the Google Event up to match the SuiteCRM one
        $event_remote = $this->updateGoogleCalendarEvent($event_local, $event_remote_empty);
        unset($event_remote_empty); // We're done with this

        return $event_remote;
    }

    /**
     * Set the timezone
     *
     * @param string $timezone : timezone_identifier (ie. America/New_York)
     *
     * @return bool Success/Failure
     */
    public function setTimezone($timezone)
    {
        if (!date_default_timezone_set($timezone)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Failed to set timezone to \'' . $timezone . '\'');
            return false;
        } else {
            $this->timezone = date_default_timezone_get();
            $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Timezone set to \'' . $this->timezone . '\'');
            return true;
        }
    }

    /**
     * Set the last sync time for the record
     *
     * This *must* be called *after* the sync is done
     * This also saves the event, so you don't need to do it twice. Just call this.
     * Also adds the id of the event so it doesn't get synced again this session.
     *
     * @param Meeting $event_local SuiteCRM Meeting bean
     * @param string $gEventId (optional) The ID that Google has for the event.
     *
     * @return bool Success/Failure
     */
    protected function setLastSync($event_local, $gEventId = null)
    {

        if (isset($gEventId)) {
            $event_local->gsync_id = $gEventId;
        }

        $event_local->gsync_lastsync = time() + 3; // we add three seconds to this, so that the modified time is always older than the gsync_lastsync time
        $return = $event_local->save(false);

        // Set the meeting as accepted by the user, otherwise it doesn't show up on the calendar. We do it here because it must be saved first.
        $event_local->set_accept_status($this->workingUser, 'accept');

        if (isset($return)) {
            $this->syncedList[] = $event_local->id;
            return true;
        } else {
            return false;
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
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to setup Google Client');
            return false;
        }

        if ($this->workingUser->id == $id) {
            $tz = $this->workingUser->getPreference('timezone', 'global');
            $this->setTimezone($tz);
        } else {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Failed to set the working user and timezone');
            return false;
        }

        if (!$this->setGService()) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to setup Google Service');
            return false;
        }

        if (!$this->setUsersGoogleCalendar()) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to setup Google Calendar Id');
            return false;
        }

        $meetings = $this->getUserMeetings();
        if (!isset($meetings)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to get Users Meetings');
            return false;
        }

        // First, we look for SuiteCRM meetings that are not on Google
        foreach ($meetings as $meeting) {
            $gevent = null; // Sanity Check. At the begining of each loop, $gevent is NULL.
            $gevent = $this->getGoogleEventById($meeting->gsync_id);
            $dowhat = $this->pushPullSkip($meeting, $gevent);

            switch ($dowhat) {
                case "push":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pushing Meeting: ' . $meeting->name);
                    $this->pushEvent($meeting, $gevent);
                    break;
                case "pull":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pulling Meeting: ' . $meeting->name);
                    $this->pullEvent($gevent, $meeting);
                    break;
                case "skip":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Skipping Meeting: ' . $meeting->name);
                    break;
                case "push_delete":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Deleting Event: ' . $meeting->name);
                    $this->delEvent($gevent, $meeting->id);
                    break;
                case "pull_delete":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Deleting Meeting: ' . $meeting->name);
                    $this->delMeeting($meeting);
                    break;
                default:
                    $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'pushPullSkip() returned unknown value: ' . $dowhat . ' for event: ' . $meeting->name);
            }
        }

        // Now, we look at the Google Calendar
        $googleEvents = $this->getUserGoogleEvents();
        if (!isset($googleEvents)) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Unable to get Google Events');
            return false;
        }

        foreach ($googleEvents as $gevent) {
            if (!$meeting = $this->getMeetingByEventId($gevent->getId())) {
                $meeting = null;
            }

            $dowhat = $this->pushPullSkip($gevent, $meeting);

            switch ($dowhat) {
                case "push":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pushing Event: ' . $gevent->getSummary());
                    $this->pushEvent($meeting, $gevent);
                    break;
                case "pull":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Pulling Event: ' . $gevent->getSummary());
                    $this->pullEvent($gevent, $meeting);
                    break;
                case "skip":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Skipping Event: ' . $gevent->getSummary());
                    break;
                case "push_delete":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Deleting Event: ' . $meeting->name);
                    $this->delEvent($gevent, $meeting->id);
                    break;
                case "pull_delete":
                    $GLOBALS['log']->info(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'Deleting Meeting: ' . $meeting->name);
                    $this->delMeeting($meeting);
                    break;
                default:
                    $GLOBALS['log']->fatal(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' - ' . 'pushPullSkip() returned unknown value: ' . $dowhat . ' for event: ' . $gevent->getSummary());
            }
        }
        return true;
    }

    /**
     * Setup array of users to sync
     *
     * Fills the $users array with users that are configured to sync
     *
     * @return null
     */
    public function setSyncUsers()
    {

        $query = "SELECT id FROM users WHERE deleted = '0'";
        $result = $this->db->query($query);

        require_once('modules/Users/User.php');
        while ($row = $this->db->fetchByAssoc($result)) {
            $user = new User();
            $user->retrieve($row['id']);

            if (!empty($user->getPreference('GoogleApiToken', 'GoogleSync')) &&
            $accessToken = json_decode(base64_decode($user->getPreference('GoogleApiToken', 'GoogleSync'))) &&
            $user->getPreference('syncGCal', 'GoogleSync') == '1') {
                $this->addUser($user->id, $user->full_name);
            }
        }
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
        $this->setSyncUsers();

        // We count failures here
        $failures = 0;

        // Then we go though the array and sync the users with doSync()
        if (isset($this->users) && !empty($this->users)) {
            foreach ($this->users as $key => $value) {
                $return = $this->doSync($key);
                if (!$return) {
                    $GLOBALS['log']->error('Something went wrong syncing for user id: ' . $key);
                    $failures++;
                }
            }
        }
        if ($failures > 0) {
            return false;
        } else {
            return true;
        }
    }
}
