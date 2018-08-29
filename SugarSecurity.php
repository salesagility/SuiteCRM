<?PHP
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/





class SugarSecure{
	var $results = array();
	function display(){
		echo '<table>';
		foreach($this->results as $result){
			echo '<tr><td>' . nl2br($result) . '</td></tr>';
		}
		echo '</table>';
	}
	
	function save($file=''){
		$fp = fopen($file, 'a');
		foreach($this->results as $result){
			fwrite($fp , $result);
		}
		fclose($fp);
	}
	
	function scan($path= '.', $ext = '.php'){
		$dir = dir($path);
		while($entry = $dir->read()){
			if(is_dir($path . '/' . $entry) && $entry != '.' && $entry != '..'){
				$this->scan($path .'/' . $entry);	
			}
			if(is_file($path . '/'. $entry) && substr($entry, strlen($entry) - strlen($ext), strlen($ext)) == $ext){
				$contents = file_get_contents($path .'/'. $entry);	
				$this->scanContents($contents, $path .'/'. $entry);
			}
		}
	}
	
	function scanContents($contents){
		return;	
	}
	
	
}

class ScanFileIncludes extends SugarSecure{
	function scanContents($contents, $file){
		$results = array();
		$found = '';
		/*preg_match_all("'(require_once\([^\)]*\\$[^\)]*\))'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			
			$found .= "\n" . $result[0];	
		}
		$results = array();
		preg_match_all("'include_once\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];	
		}
		*/
		$results = array();
		preg_match_all("'require\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];	
		}
		$results = array();
		preg_match_all("'include\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];	
		}
		$results = array();
		preg_match_all("'require_once\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];	
		}
		$results = array();
		preg_match_all("'fopen\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];	
		}
		$results = array();
		preg_match_all("'file_get_contents\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];	
		}
		if(!empty($found)){
			$this->results[] = $file . $found."\n\n";	
		}
		
	}
	
	
}
	


class SugarSecureManager{
	var $scanners = array();
	function registerScan($class){
		$this->scanners[] = new $class();
	}
	
	function scan(){
		
		while($scanner = current($this->scanners)){
			$scanner->scan();
			$scanner = next($this->scanners);
		}
		reset($this->scanners);	
	}
	
	function display(){
		
		while($scanner = current($this->scanners)){
			echo 'Scan Results: ';
			$scanner->display();
			$scanner = next($this->scanners);
		}
		reset($this->scanners);	
	}
	
	function save(){
		//reset($this->scanners);	
		$name = 'SugarSecure'. time() . '.txt';
		while($this->scanners  = next($this->scanners)){
			$scanner->save($name);
		}
	}
	
}
$secure = new SugarSecureManager();
$secure->registerScan('ScanFileIncludes');
$secure->scan();
$secure->display();