<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
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


require_once('service/core/REST/SugarRest.php');

/**
 * This class is a JSON implementation of REST protocol
 * @api
 */
class SugarRestJSON extends SugarRest
{

    /**
     * It will json encode the input object and echo's it
     *
     * @param array $input - assoc array of input values: key = param name, value = param type
     * @return String - echos json encoded string of $input
     */
    public function generateResponse($input)
    {
        $json = getJSONObj();
        ob_clean();
        header('Content-Type: application/json; charset=UTF-8');
        if (isset($this->faultObject)) {
            $this->generateFaultResponse($this->faultObject);
        } else {
            // JSONP support
            if (isset($_GET["jsoncallback"])) {
                echo $_GET["jsoncallback"] . "(";
            }
            echo $json->encode($input);
            if (isset($_GET["jsoncallback"])) {
                echo ")";
            }
        }
    } // fn

    /**
     * This method calls functions on the implementation class and returns the output or Fault object in case of error to client
     *
     * @return unknown
     */
    public function serve()
    {
        $GLOBALS['log']->info('Begin: SugarRestJSON->serve');
        $json_data = !empty($_REQUEST['rest_data'])? $GLOBALS['RAW_REQUEST']['rest_data']: '';
        if (empty($_REQUEST['method']) || !method_exists($this->implementation, $_REQUEST['method'])) {
            $er = new SoapError();
            $er->set_error('invalid_call');
            $this->fault($er);
        } else {
            $method = $_REQUEST['method'];
            $json = getJSONObj();
            $data = $json->decode($json_data);
            if (!is_array($data)) {
                $data = array($data);
            }
            $data = $this->correctParameterArray($this->implementation, $method, $data); // Conform to spec, accept any parameter order.
            $res = call_user_func_array(array( $this->implementation, $method), $data);
            $GLOBALS['log']->info('End: SugarRestJSON->serve');
            return $res;
        } // else
    } // fn

    /**
	* When data comes from clients other than PHP, ie Java, Python, or even from PHP SimpleJSON,
	* it can be impossible for the client to arrange the array of arguments in any order,
	* and by definition a JSON array is unsorted.
    * Further, the REST spec requires the server to accept args/parameters in any order.
	* This method takes the array of arguments in any order,
    * and returns the arguments in the expected "correct" order,
	* ie the same order as declared in the particular method,
    * for spec-compatible processing of the data by the CRM's REST server.
	*
	* @param String $className Name of the class
	* @param String $methodName Name of the method
	* @param array $data arguments to pass [name => value]
	* @return array arguments arranged for chosen method
	*/
	private function correctParameterArray($className, $methodName, array $data) {
		$r = new ReflectionMethod($className, $methodName);
		$params = $r->getParameters();
		$result = array();
		if (empty($params)) {
			return $data;
		}
		foreach ($params as $param) {
			$name = $param->getName();
			if (!isset($data[$name])) {
				$result[$name] = $param->getDefaultValue();
			} else {
				$result[$name] = $data[$name];
			}
		}
		return $result;
	}
    
    /**
     * This function sends response to client containing error object
     *
     * @param SoapError $errorObject - This is an object of type SoapError
     * @access public
     */
    public function fault($errorObject)
    {
        $this->faultServer->faultObject = $errorObject;
    } // fn

    public function generateFaultResponse($errorObject)
    {
        $error = $errorObject->number . ': ' . $errorObject->name . '<br>' . $errorObject->description;
        $GLOBALS['log']->error($error);
        $json = getJSONObj();
        ob_clean();
        // JSONP support
        if (isset($_GET["jsoncallback"])) {
            echo $_GET["jsoncallback"] . "(";
        }
        echo $json->encode($errorObject);
        if (isset($_GET["jsoncallback"])) {
            echo ")";
        }
    } // fn
} // class
