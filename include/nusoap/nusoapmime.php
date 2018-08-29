<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r39619 - 2008-09-09 13:41:34 -0700 (Tue, 09 Sep 2008) - jmertic - Bug 24827 - Remove all instances where we return a new object and assign it by reference, since this is deprecated in PHP 5 and emits E_DEPRECATED errors in PHP 5.3.
Touched:
- data/SugarBean.php
- include/domit/php_http_client_generic.php
- include/domit/php_http_connector.php
- include/domit/testing_domit.php
- include/domit/xml_domit_getelementsbypath.php
- include/domit/xml_domit_lite_parser.php
- include/domit/xml_domit_nodemaps.php
- include/domit/xml_domit_parser.php
- include/domit/xml_domit_shared.php
- include/generic/SugarWidgets/SugarWidgetField.php
- include/generic/SugarWidgets/SugarWidgetReportField.php
- include/ListView/ProcessView.php
- include/nusoap/class.soapclient.php
- include/nusoap/nusoap.php
- include/nusoap/nusoapmime.php
- include/Pear/HTML_Safe/Safe.php
- include/Pear/XML_HTMLSax3/HTMLSax3.php
- modules/Administration/RebuildWorkFlow.php
- modules/Expressions/RelateSelector.php
- modules/Reports/templates/templates_reports.php
- modules/WorkFlow/Delete.php
- modules/WorkFlow/Save.php
- modules/WorkFlow/SaveSequence.php
- modules/WorkFlow/WorkFlow.php
- modules/WorkFlowActionShells/CreateStep1.php
- modules/WorkFlowActionShells/CreateStep2.php
- modules/WorkFlowActionShells/Save.php
- modules/WorkFlowActionShells/WorkFlowActionShell.php
- modules/WorkFlowAlerts/Save.php
- modules/WorkFlowAlerts/WorkFlowAlert.php
- modules/WorkFlowAlertShells/DetailView.php
- modules/WorkFlowAlertShells/WorkFlowAlertShell.php
- modules/WorkFlowTriggerShells/CreateStep1.php
- modules/WorkFlowTriggerShells/CreateStepFilter.php
- modules/WorkFlowTriggerShells/SaveFilter.php
- modules/WorkFlowTriggerShells/WorkFlowTriggerShell.php
- soap/SoapHelperFunctions.php
- test/modules/DynamicFields/DynamicFields_Bug24095_test.php
- test/simpletest/browser.php
- test/simpletest/default_reporter.php
- test/simpletest/detached.php
- test/simpletest/eclipse.php
- test/simpletest/expectation.php
- test/simpletest/extensions/pear_test_case.php
- test/simpletest/form.php
- test/simpletest/http.php
- test/simpletest/mock_objects.php
- test/simpletest/page.php
- test/simpletest/parser.php
- test/simpletest/remote.php
- test/simpletest/shell_tester.php
- test/simpletest/simple_test.php
- test/simpletest/simpletest.php
- test/simpletest/test/acceptance_test.php
- test/simpletest/test/adapter_test.php
- test/simpletest/test/authentication_test.php
- test/simpletest/test/browser_test.php
- test/simpletest/test/collector_test.php
- test/simpletest/test/compatibility_test.php
- test/simpletest/test/detached_test.php
- test/simpletest/test/eclipse_test.php
- test/simpletest/test/encoding_test.php
- test/simpletest/test/errors_test.php
- test/simpletest/test/expectation_test.php
- test/simpletest/test/form_test.php
- test/simpletest/test/frames_test.php
- test/simpletest/test/http_test.php
- test/simpletest/test/live_test.php
- test/simpletest/test/mock_objects_test.php
- test/simpletest/test/page_test.php
- test/simpletest/test/parse_error_test.php
- test/simpletest/test/parser_test.php
- test/simpletest/test/remote_test.php
- test/simpletest/test/shell_test.php
- test/simpletest/test/shell_tester_test.php
- test/simpletest/test/simpletest_test.php
- test/simpletest/test/site/page_request.php
- test/simpletest/test/tag_test.php
- test/simpletest/test/unit_tester_test.php
- test/simpletest/test/user_agent_test.php
- test/simpletest/test/visual_test.php
- test/simpletest/test/xml_test.php
- test/simpletest/test_case.php
- test/simpletest/ui/array_reporter/test.php
- test/simpletest/ui/recorder/test.php
- test/simpletest/unit_tester.php
- test/simpletest/url.php
- test/simpletest/user_agent.php
- test/simpletest/web_tester.php
- test/spikephpcoverage/src/PEAR.php
- test/spikephpcoverage/src/util/Utility.php
- test/spikephpcoverage/src/XML/Parser.php
- test/spikephpcoverage/src/XML/Parser/Simple.php
- test/test_utilities/SugarTest_SimpleBrowser.php

r13782 - 2006-06-06 10:58:55 -0700 (Tue, 06 Jun 2006) - majed - changes entry point code

r11115 - 2006-01-17 14:54:45 -0800 (Tue, 17 Jan 2006) - majed - add entry point validation

r8991 - 2005-11-03 19:07:25 -0800 (Thu, 03 Nov 2005) - majed - fixes nusoap issue

r8846 - 2005-10-31 11:01:12 -0800 (Mon, 31 Oct 2005) - majed - new version of nusoap

r7905 - 2005-09-21 19:12:57 -0700 (Wed, 21 Sep 2005) - majed - restores old nusoap pre & with a few fixes

r7861 - 2005-09-20 15:40:25 -0700 (Tue, 20 Sep 2005) - majed - & fix for 3.5.1

r7452 - 2005-08-17 11:32:34 -0700 (Wed, 17 Aug 2005) - majed - changes soap to nusoap

r5462 - 2005-05-25 13:50:11 -0700 (Wed, 25 May 2005) - majed - upgraded nusoap to .6.9

r573 - 2004-09-04 13:03:32 -0700 (Sat, 04 Sep 2004) - sugarclint - undoing copyrights added in inadvertantly.  --clint

r546 - 2004-09-03 11:49:38 -0700 (Fri, 03 Sep 2004) - sugarmsi - removed echo count

r354 - 2004-08-02 23:00:37 -0700 (Mon, 02 Aug 2004) - sugarjacob - Adding Soap


*/


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
$Id: nusoapmime.php 39619 2008-09-09 20:41:34Z jmertic $

NuSOAP - Web Services Toolkit for PHP

Copyright (c) 2002 NuSphere Corporation

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

If you have any questions or comments, please email:

Dietrich Ayala
dietrich@ganx4.com
http://dietrich.ganx4.com/nusoap

NuSphere Corporation
http://www.nusphere.com

*/

/*require_once('nusoap.php');*/
/* PEAR Mail_MIME library */
require_once('Mail/mimeDecode.php');
require_once('Mail/mimePart.php');

/**
* nusoapclientmime client supporting MIME attachments defined at
* http://www.w3.org/TR/SOAP-attachments.  It depends on the PEAR Mail_MIME library.
*
* @author   Scott Nichol <snichol@sourceforge.net>
* @author	Thanks to Guillaume and Henning Reich for posting great attachment code to the mail list

* @access   public
*/
class nusoapclientmime extends nusoapclient {
	/**
	 * @var array Each array element in the return is an associative array with keys
	 * data, filename, contenttype, cid
	 * @access private
	 */
	var $requestAttachments = array();
	/**
	 * @var array Each array element in the return is an associative array with keys
	 * data, filename, contenttype, cid
	 * @access private
	 */
	var $responseAttachments;
	/**
	 * @var string
	 * @access private
	 */
	var $mimeContentType;

	/**
	* adds a MIME attachment to the current request.
	*
	* If the $data parameter contains an empty string, this method will read
	* the contents of the file named by the $filename parameter.
	*
	* If the $cid parameter is false, this method will generate the cid.
	*
	* @param string $data The data of the attachment
	* @param string $filename The filename of the attachment (default is empty string)
	* @param string $contenttype The MIME Content-Type of the attachment (default is application/octet-stream)
	* @param string $cid The content-id (cid) of the attachment (default is false)
	* @return string The content-id (cid) of the attachment
	* @access public
	*/
	function addAttachment($data, $filename = '', $contenttype = 'application/octet-stream', $cid = false) {
		if (! $cid) {
			$cid = md5(uniqid(time()));
		}

		$info['data'] = $data;
		$info['filename'] = $filename;
		$info['contenttype'] = $contenttype;
		$info['cid'] = $cid;

		$this->requestAttachments[] = $info;

		return $cid;
	}

	/**
	* clears the MIME attachments for the current request.
	*
	* @access public
	*/
	function clearAttachments() {
		$this->requestAttachments = array();
	}

	/**
	* gets the MIME attachments from the current response.
	*
	* Each array element in the return is an associative array with keys
	* data, filename, contenttype, cid.  These keys correspond to the parameters
	* for addAttachment.
	*
	* @return array The attachments.
	* @access public
	*/
	function getAttachments() {
		return $this->responseAttachments;
	}

	/**
	* gets the HTTP body for the current request.
	*
	* @param string $soapmsg The SOAP payload
	* @return string The HTTP body, which includes the SOAP payload
	* @access private
	*/
	function getHTTPBody($soapmsg) {
		if (count($this->requestAttachments) > 0) {
			$params['content_type'] = 'multipart/related; type=text/xml';
			$mimeMessage = new Mail_mimePart('', $params);
			unset($params);

			$params['content_type'] = 'text/xml';
			$params['encoding']     = '8bit';
			$params['charset']      = $this->soap_defencoding;
			$mimeMessage->addSubpart($soapmsg, $params);

			foreach ($this->requestAttachments as $att) {
				unset($params);

				$params['content_type'] = $att['contenttype'];
				$params['encoding']     = 'base64';
				$params['disposition']  = 'attachment';
				$params['dfilename']    = $att['filename'];
				$params['cid']          = $att['cid'];

				if ($att['data'] == '' && $att['filename'] <> '') {
				    $data = file_get_contents($att['filename']);
					$mimeMessage->addSubpart($data, $params);
				} else {
					$mimeMessage->addSubpart($att['data'], $params);
				}
			}

			$output = $mimeMessage->encode();
			$mimeHeaders = $output['headers'];

			foreach ($mimeHeaders as $k => $v) {
				$this->debug("MIME header $k: $v");
				if (strtolower($k) == 'content-type') {
					// PHP header() seems to strip leading whitespace starting
					// the second line, so force everything to one line
					$this->mimeContentType = str_replace("\r\n", " ", $v);
				}
			}

			return $output['body'];
		}

		return parent::getHTTPBody($soapmsg);
	}

	/**
	* gets the HTTP content type for the current request.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type for the current request.
	* @access private
	*/
	function getHTTPContentType() {
		if (count($this->requestAttachments) > 0) {
			return $this->mimeContentType;
		}
		return parent::getHTTPContentType();
	}

	/**
	* gets the HTTP content type charset for the current request.
	* returns false for non-text content types.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type charset for the current request.
	* @access private
	*/
	function getHTTPContentTypeCharset() {
		if (count($this->requestAttachments) > 0) {
			return false;
		}
		return parent::getHTTPContentTypeCharset();
	}

	/**
	* processes SOAP message returned from server
	*
	* @param	array	$headers	The HTTP headers
	* @param	string	$data		unprocessed response data from server
	* @return	mixed	value of the message, decoded into a PHP type
	* @access   private
	*/
    function parseResponse($headers, $data) {
		$this->debug('Entering parseResponse() for payload of length ' . strlen($data) . ' and type of ' . $headers['content-type']);
		$this->responseAttachments = array();
		if (strstr($headers['content-type'], 'multipart/related')) {
			$this->debug('Decode multipart/related');
			$input = '';
			foreach ($headers as $k => $v) {
				$input .= "$k: $v\r\n";
			}
			$params['input'] = $input . "\r\n" . $data;
			$params['include_bodies'] = true;
			$params['decode_bodies'] = true;
			$params['decode_headers'] = true;

			$structure = Mail_mimeDecode::decode($params);

			foreach ($structure->parts as $part) {
				if (!isset($part->disposition)) {
					$this->debug('Have root part of type ' . $part->headers['content-type']);
					$return = parent::parseResponse($part->headers, $part->body);
				} else {
					$this->debug('Have an attachment of type ' . $part->headers['content-type']);
					$info['data'] = $part->body;
					$info['filename'] = isset($part->d_parameters['filename']) ? $part->d_parameters['filename'] : '';
					$info['contenttype'] = $part->headers['content-type'];
					$info['cid'] = $part->headers['content-id'];
					$this->responseAttachments[] = $info;
				}
			}

			if (isset($return)) {
				return $return;
			}

			$this->setError('No root part found in multipart/related content');
			return;
		}
		$this->debug('Not multipart/related');
		return parent::parseResponse($headers, $data);
	}
}

/**
* nusoapservermime server supporting MIME attachments defined at
* http://www.w3.org/TR/SOAP-attachments.  It depends on the PEAR Mail_MIME library.
*
* @author   Scott Nichol <snichol@sourceforge.net>
* @author	Thanks to Guillaume and Henning Reich for posting great attachment code to the mail list

* @access   public
*/
class nusoapservermime extends soap_server {
	/**
	 * @var array Each array element in the return is an associative array with keys
	 * data, filename, contenttype, cid
	 * @access private
	 */
	var $requestAttachments = array();
	/**
	 * @var array Each array element in the return is an associative array with keys
	 * data, filename, contenttype, cid
	 * @access private
	 */
	var $responseAttachments;
	/**
	 * @var string
	 * @access private
	 */
	var $mimeContentType;

	/**
	* adds a MIME attachment to the current response.
	*
	* If the $data parameter contains an empty string, this method will read
	* the contents of the file named by the $filename parameter.
	*
	* If the $cid parameter is false, this method will generate the cid.
	*
	* @param string $data The data of the attachment
	* @param string $filename The filename of the attachment (default is empty string)
	* @param string $contenttype The MIME Content-Type of the attachment (default is application/octet-stream)
	* @param string $cid The content-id (cid) of the attachment (default is false)
	* @return string The content-id (cid) of the attachment
	* @access public
	*/
	function addAttachment($data, $filename = '', $contenttype = 'application/octet-stream', $cid = false) {
		if (! $cid) {
			$cid = md5(uniqid(time()));
		}

		$info['data'] = $data;
		$info['filename'] = $filename;
		$info['contenttype'] = $contenttype;
		$info['cid'] = $cid;

		$this->responseAttachments[] = $info;

		return $cid;
	}

	/**
	* clears the MIME attachments for the current response.
	*
	* @access public
	*/
	function clearAttachments() {
		$this->responseAttachments = array();
	}

	/**
	* gets the MIME attachments from the current request.
	*
	* Each array element in the return is an associative array with keys
	* data, filename, contenttype, cid.  These keys correspond to the parameters
	* for addAttachment.
	*
	* @return array The attachments.
	* @access public
	*/
	function getAttachments() {
		return $this->requestAttachments;
	}

	/**
	* gets the HTTP body for the current response.
	*
	* @param string $soapmsg The SOAP payload
	* @return string The HTTP body, which includes the SOAP payload
	* @access private
	*/
	function getHTTPBody($soapmsg) {
		if (count($this->responseAttachments) > 0) {
			$params['content_type'] = 'multipart/related; type=text/xml';
			$mimeMessage = new Mail_mimePart('', $params);
			unset($params);

			$params['content_type'] = 'text/xml';
			$params['encoding']     = '8bit';
			$params['charset']      = $this->soap_defencoding;
			$mimeMessage->addSubpart($soapmsg, $params);

			foreach ($this->responseAttachments as $att) {
				unset($params);

				$params['content_type'] = $att['contenttype'];
				$params['encoding']     = 'base64';
				$params['disposition']  = 'attachment';
				$params['dfilename']    = $att['filename'];
				$params['cid']          = $att['cid'];

				if ($att['data'] == '' && $att['filename'] <> '') {
				    $data = file_get_contents($att['filename']);
					$mimeMessage->addSubpart($data, $params);
				} else {
					$mimeMessage->addSubpart($att['data'], $params);
				}
			}

			$output = $mimeMessage->encode();
			$mimeHeaders = $output['headers'];

			foreach ($mimeHeaders as $k => $v) {
				$this->debug("MIME header $k: $v");
				if (strtolower($k) == 'content-type') {
					// PHP header() seems to strip leading whitespace starting
					// the second line, so force everything to one line
					$this->mimeContentType = str_replace("\r\n", " ", $v);
				}
			}

			return $output['body'];
		}

		return parent::getHTTPBody($soapmsg);
	}

	/**
	* gets the HTTP content type for the current response.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type for the current response.
	* @access private
	*/
	function getHTTPContentType() {
		if (count($this->responseAttachments) > 0) {
			return $this->mimeContentType;
		}
		return parent::getHTTPContentType();
	}

	/**
	* gets the HTTP content type charset for the current response.
	* returns false for non-text content types.
	*
	* Note: getHTTPBody must be called before this.
	*
	* @return string the HTTP content type charset for the current response.
	* @access private
	*/
	function getHTTPContentTypeCharset() {
		if (count($this->responseAttachments) > 0) {
			return false;
		}
		return parent::getHTTPContentTypeCharset();
	}

	/**
	* processes SOAP message received from client
	*
	* @param	array	$headers	The HTTP headers
	* @param	string	$data		unprocessed request data from client
	* @return	mixed	value of the message, decoded into a PHP type
	* @access   private
	*/
    function parseRequest($headers, $data) {
		$this->debug('Entering parseRequest() for payload of length ' . strlen($data) . ' and type of ' . $headers['content-type']);
		$this->requestAttachments = array();
		if (strstr($headers['content-type'], 'multipart/related')) {
			$this->debug('Decode multipart/related');
			$input = '';
			foreach ($headers as $k => $v) {
				$input .= "$k: $v\r\n";
			}
			$params['input'] = $input . "\r\n" . $data;
			$params['include_bodies'] = true;
			$params['decode_bodies'] = true;
			$params['decode_headers'] = true;

			$structure = Mail_mimeDecode::decode($params);

			foreach ($structure->parts as $part) {
				if (!isset($part->disposition)) {
					$this->debug('Have root part of type ' . $part->headers['content-type']);
					$return = parent::parseRequest($part->headers, $part->body);
				} else {
					$this->debug('Have an attachment of type ' . $part->headers['content-type']);
					$info['data'] = $part->body;
					$info['filename'] = isset($part->d_parameters['filename']) ? $part->d_parameters['filename'] : '';
					$info['contenttype'] = $part->headers['content-type'];
					$info['cid'] = $part->headers['content-id'];
					$this->requestAttachments[] = $info;
				}
			}

			if (isset($return)) {
				return $return;
			}

			$this->setError('No root part found in multipart/related content');
			return;
		}
		$this->debug('Not multipart/related');
		return parent::parseRequest($headers, $data);
	}
}
?>
