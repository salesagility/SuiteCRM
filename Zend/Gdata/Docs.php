<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Docs
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * Modifications by SugarCRM
 *
 * April 12, 2011 - asandberg: Changed mime-type for jpg files to image/jpeg
 * March 14, 2011 - asandberg: Added support for Google API v3: http://code.google.com/p/gdata-samples/source/browse/trunk/doclist/OCRDemo/DocsBeta.php
 * March 10, 2011 - asandberg: Added getSupportedMimeTypes function
 */


/**
 * @see Zend_Gdata
 */
require_once 'Zend/Gdata.php';

/**
 * @see Zend_Gdata_Docs_DocumentListFeed
 */
require_once 'Zend/Gdata/Docs/DocumentListFeed.php';

/**
 * @see Zend_Gdata_Docs_DocumentListEntry
 */
require_once 'Zend/Gdata/Docs/DocumentListEntry.php';

/**
 * Service class for interacting with the Google Document List data API
 * @link http://code.google.com/apis/documents/
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Docs
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_Docs extends Zend_Gdata
{
    const DOCUMENTS_LIST_FEED_URI = 'https://docs.google.com/feeds/default/private/full';
    const AUTH_SERVICE_NAME = 'writely';
    const DEFAULT_MAJOR_PROTOCOL_VERSION = 3;

    protected $_defaultPostUri = self::DOCUMENTS_LIST_FEED_URI;

    /**
         * Namespaces used for Zend_Gdata_Docs
         *
         * @var array
         */
    public static $namespaces = array(
       array('batch', 'http://schemas.google.com/gdata/batch', self::DEFAULT_MAJOR_PROTOCOL_VERSION, 0),
       array('docs', 'http://schemas.google.com/docs/2007', self::DEFAULT_MAJOR_PROTOCOL_VERSION, 0),
           array('gAcl', 'http://schemas.google.com/acl/2007', self::DEFAULT_MAJOR_PROTOCOL_VERSION, 0),
           array('gd', 'http://schemas.google.com/g/2005', self::DEFAULT_MAJOR_PROTOCOL_VERSION, 0)
    );

    private static $SUPPORTED_FILETYPES = array(
      'CSV' => 'text/csv',
      'DOC' => 'application/msword',
      'DOCX' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      'HTML' =>'text/html',
      'HTM' => 'text/html',
      'JPG' => 'image/jpeg',
      'ODS' => 'application/vnd.oasis.opendocument.spreadsheet',
      'ODT' => 'application/vnd.oasis.opendocument.text',
      'PDF' => 'application/pdf',
      'PNG' => 'image/png',
      'PPT' => 'application/vnd.ms-powerpoint',
      'PPS' => 'application/vnd.ms-powerpoint',
      'RTF' => 'application/rtf',
      'SXW' => 'application/vnd.sun.xml.writer',
      'TAB' => 'text/tab-separated-values',
      'TXT' => 'text/plain',
      'TEXT' => 'text/plain',
      'TSV' => 'text/tab-separated-values',
      'XLS' => 'application/vnd.ms-excel',
      'XLSX' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    /**
     * Create Gdata_Docs object
     *
     * @param Zend_Http_Client $client (optional) The HTTP client to use when
     *          when communicating with the Google servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationName)
    {
        $this->registerPackage('Zend_Gdata_Docs');
        $this->registerPackage('Zend_Gdata_Docs_Extension_WritersCanInvite');
        parent::__construct($client, $applicationName);
        $this->_httpClient->setParameterPost('service', self::AUTH_SERVICE_NAME);
        $this->setMajorProtocolVersion(self::DEFAULT_MAJOR_PROTOCOL_VERSION);
    }

    /**
     * Looks up the mime type based on the file name extension. For example,
     * calling this method with 'csv' would return
     * 'text/comma-separated-values'. The Mime type is sent as a header in
     * the upload HTTP POST request.
     *
     * @param string $fileExtension
     * @return string The mime type to be sent to the server to tell it how the
     *          multipart mime data should be interpreted.
     */
    public static function lookupMimeType($fileExtension)
    {
        return self::$SUPPORTED_FILETYPES[strtoupper($fileExtension)];
    }

    /**
     * Retrieve feed object containing entries for the user's documents.
     *
     * @param mixed $location The location for the feed, as a URL or Query
     * @return Zend_Gdata_Docs_DocumentListFeed
     */
    public function getDocumentListFeed($location = null)
    {
        if ($location === null) {
            $uri = self::DOCUMENTS_LIST_FEED_URI;
        } elseif ($location instanceof Zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'Zend_Gdata_Docs_DocumentListFeed');
    }

    /**
     * Retrieve entry object representing a single document.
     *
     * @param mixed $location The location for the entry, as a URL or Query
     * @return Zend_Gdata_Docs_DocumentListEntry
     */
    public function getDocumentListEntry($location = null)
    {
        if ($location === null) {
            require_once 'Zend/Gdata/App/InvalidArgumentException.php';
            throw new Zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null'
            );
        } elseif ($location instanceof Zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'Zend_Gdata_Docs_DocumentListEntry');
    }

    /**
         * Retrieve a document entry representing a single document.
         *
         * @param string $resourceId The document resource id. Examples:
         *     document:dcmg89gw_62hfjj8m, spreadsheet:pKq0CzjiF3YmGd0AIlHKqeg,
         *     pdf:asdf89hfjjddfg
         * @return Zend_Gdata_Docs_DocumentListEntry
         */
    public function getResource($resourceId)
    {
        $uri = 'https://docs.google.com/feeds/documents/private/full/' . $resourceId;
        return $this->getDocumentListEntry($uri);
    }

    /**
     * Retrieve entry object representing a single document.
     *
     * This method builds the URL where this item is stored using the type
     * and the id of the document.
     * @param string $docId The URL key for the document. Examples:
     *     dcmg89gw_62hfjj8m, pKq0CzjiF3YmGd0AIlHKqeg
     * @param string $docType The type of the document as used in the Google
     *     Document List URLs. Examples: document, spreadsheet, presentation
     * @return Zend_Gdata_Docs_DocumentListEntry
     * @deprecated Use getResource($resourceId) instead.
     */
    public function getDoc($docId, $docType)
    {
        $location = 'https://docs.google.com/feeds/documents/private/full/' .
            $docType . '%3A' . $docId;
        return $this->getDocumentListEntry($location);
    }

    /**
     * Retrieve entry object for the desired word processing document.
     *
     * @param string $id The URL id for the document. Example:
     *     dcmg89gw_62hfjj8m
     * @deprecated Use getResource($resourceId) instead.
     */
    public function getDocument($id)
    {
        return $this->getDoc('document%3A' . $id);
    }

    /**
     * Retrieve entry object for the desired spreadsheet.
     *
     * @param string $id The URL id for the spreadsheet. Example:
     *     pKq0CzjiF3YmGd0AIlHKqeg
     * @deprecated Use getResource($resourceId) instead.
     */
    public function getSpreadsheet($id)
    {
        return $this->getDoc('spreadsheet%3A' . $id);
    }

    /**
     * Retrieve entry object for the desired presentation.
     *
     * @param string $id The URL id for the presentation. Example:
     *     dcmg89gw_21gtrjcn
     * @deprecated Use getResource($resourceId) instead.
     */
    public function getPresentation($id)
    {
        return $this->getDoc('presentation%3A' . $id);
    }

    /**
     * Upload a local file to create a new Google Document entry.
     *
     * @param string $fileLocation The full or relative path of the file to
     *         be uploaded.
     * @param string $title The name that this document should have on the
     *         server. If set, the title is used as the slug header in the
     *         POST request. If no title is provided, the location of the
     *         file will be used as the slug header in the request. If no
     *         mimeType is provided, this method attempts to determine the
     *         mime type based on the slugHeader by looking for .doc,
     *         .csv, .txt, etc. at the end of the file name.
     *         Example value: 'test.doc'.
     * @param string $mimeType Describes the type of data which is being sent
     *         to the server. This must be one of the accepted mime types
     *         which are enumerated in SUPPORTED_FILETYPES.
     * @param string $uri (optional) The URL to which the upload should be
     *         made.
     *         Example: 'http://docs.google.com/feeds/default/private/full'.
     * @return Zend_Gdata_Docs_DocumentListEntry The entry for the newly
     *         created Google Document.
     */
    public function uploadFile(
        $fileLocation,
        $title=null,
        $mimeType=null,
                               $uri=null
    ) {
        // Set the URI to which the file will be uploaded.
        if ($uri === null) {
            $uri = $this->_defaultPostUri;
        }

        // Create the media source which describes the file.
        $fs = $this->newMediaFileSource($fileLocation);
        if ($title !== null) {
            $slugHeader = $title;
        } else {
            $slugHeader = $fileLocation;
        }

        // Set the slug header to tell the Google Documents server what the
        // title of the document should be and what the file extension was
        // for the original file.
        $fs->setSlug($slugHeader);

        // Set the mime type of the data.
        if ($mimeType === null) {
            $slugHeader =  $fs->getSlug();
            $filenameParts = explode('.', $slugHeader);
            $fileExtension = end($filenameParts);
            $mimeType = self::lookupMimeType($fileExtension);
        }

        // Set the mime type for the upload request.
        $fs->setContentType($mimeType);

        // Send the data to the server.
        return $this->insertDocument($fs, $uri);
    }

    /**
     * Inserts an entry to a given URI and returns the response as an Entry.
     *
     * @param mixed  $data The Zend_Gdata_Docs_DocumentListEntry or media
     *         source to post. If it is a DocumentListEntry, the mediaSource
     *         should already have been set. If $data is a mediaSource, it
     *         should have the correct slug header and mime type.
     * @param string $uri POST URI
     * @param string $className (optional) The class of entry to be returned.
     *         The default is a 'Zend_Gdata_Docs_DocumentListEntry'.
     * @return Zend_Gdata_Docs_DocumentListEntry The entry returned by the
     *     service after insertion.
     */
    public function insertDocument(
        $data,
        $uri,
        $className='Zend_Gdata_Docs_DocumentListEntry'
    ) {
        return $this->insertEntry($data, $uri, $className);
    }
    
    /**
     * Return the supported mime types and file extensions.
     *
     * @return array
     * @author Andreas Sandberg
     */
    public static function getSupportedMimeTypes()
    {
        return self::$SUPPORTED_FILETYPES;
    }
}
