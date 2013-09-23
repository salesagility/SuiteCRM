<?php
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



/**
 * @see Zend_Gdata
 */
require_once 'Zend/Gdata.php';

/**
 * @see Zend_Gdata_Books_VolumeFeed
 */
require_once 'Zend/Gdata/Contacts/ListFeed.php';

/**
 * @see Zend_Gdata_Docs_DocumentListEntry
 */
require_once 'Zend/Gdata/Contacts/ListEntry.php';


/**
 * Service class for interacting with the Google Contacts data API
 */
class Zend_Gdata_Contacts extends Zend_Gdata
{

    const CONTACT_FEED_URI = 'https://www.google.com/m8/feeds/contacts/default/full';
    const AUTH_SERVICE_NAME = 'cp';
    const DEFAULT_MAJOR_PROTOCOL_VERSION = 3;

    protected $maxResults = 10;
    protected $startIndex = 1;
    /**
     * Namespaces used for Zend_Gdata_Calendar
     *
     * @var array
     */
    public static $namespaces = array(
        array('gContact', 'http://schemas.google.com/contact/2008', 1, 0),
    );

    /**
     * Create Gdata_Calendar object
     *
     * @param Zend_Http_Client $client (optional) The HTTP client to use when
     *          when communicating with the Google servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('Zend_Gdata_Contacts');
        $this->registerPackage('Zend_Gdata_Contacts_Extension');
        parent::__construct($client, $applicationId);
        $this->_httpClient->setParameterPost('service', self::AUTH_SERVICE_NAME);
        $this->setMajorProtocolVersion(self::DEFAULT_MAJOR_PROTOCOL_VERSION);
    }

    /**
     * Retrieve feed object
     *
     * @return Zend_Gdata_Calendar_ListFeed
     */
    public function getContactListFeed()
    {
        $query = new Zend_Gdata_Query(self::CONTACT_FEED_URI);
        $query->maxResults = $this->maxResults;
        $query->startIndex = $this->startIndex;
        return parent::getFeed($query,'Zend_Gdata_Contacts_ListFeed');
    }

    /**
     * Retrieve a single feed object by id
     *
     * @param string $entryID
     * @return string|Zend_Gdata_App_Feed
     */
    public function getContactEntry($entryID)
    {
        return parent::getEntry($entryID,'Zend_Gdata_Contacts_ListEntry');
    }

    /**
     * Set the max results that the feed should return.
     * 
     * @param  $maxResults
     * @return void
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }

    /**
     * Set the start index.
     *
     * @param  $value
     * @return void
     */
    public function setStartIndex($value)
    {
        $this->startIndex = $value;
    }

}
 
