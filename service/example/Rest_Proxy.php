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


ob_start();
$fp =  fopen('proxy.log', 'a');
define('PROXY_SERVER',  'http://localhost/service/v2/rest.php');
$headers = (function_exists('getallheaders'))?getallheaders(): array();
$_headers  = array();
foreach($headers as $k=>$v){
	$_headers[strtolower($k)] = $v;
}
$url = parse_url(PROXY_SERVER);
if(!empty($_headers['referer']))$curl_headers['referer'] = 'Referer: '  . $_headers['referer'];
if(!empty($_headers['user-agent']))$curl_headers['user-agent'] = 'User-Agent: ' . $_headers['user-agent'];
if(!empty($_headers['accept']))$curl_headers['accept'] = 'Accept: ' . $_headers['accept'];
if(!empty($_headers['accept-language']))$curl_headers['accept-Language'] = 'Accept-Language: ' . $_headers['accept-language'];
if(!empty($_headers['accept-encoding']))$curl_headers['accept-encoding:'] = 'Accept-Encoding: ' .$_headers['accept-encoding'];
if(!empty($_headers['accept-charset']))$curl_headers['accept-charset:'] = 'Accept-Charset: ' .$_headers['accept-charset'];

// create a new cURL resource
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, PROXY_SERVER);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0  );
$post_data = '';
if(!empty($_POST)){
	foreach($_POST as $k=>$v){
		if(get_magic_quotes_gpc())$v = stripslashes($v);
		if(!empty($post_data))$post_data .= '&';
		$post_data .= "$k=" . $v;
	}
}
curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
// grab URL and pass it to the browser
fwrite($fp, 'client headers:' . var_export($headers, true) . "\n");
fwrite($fp, 'starting curl request' . "\n");
fwrite($fp, $post_data . "\n");
$result = curl_exec($ch);
curl_close($ch);
fwrite($fp, 'finished curl request' . "\n");
fwrite($fp, 'response:' . var_export($result, true) . "\n");
//we only handle 1 response no redirects
$result = explode("\r\n\r\n", $result, 2);
//we neeed to split up the ehaders
$result_headers = explode("\r\n", $result[0]);
//now echo out the same headers the server passed to us
fwrite($fp, "setting headers\n");
foreach($result_headers as &$header){
	if(substr_count($header, 'Set-Cookie:') ==0)
	header($header);
}
header('Content-Length: ' . strlen($result[1]));
header('Connection: close');
// now echo out the body
fwrite($fp, "sending body\n");
echo $result[1];
ob_end_flush();
fwrite($fp, "done\n");
die();
// close cURL resource, and free up system resources
