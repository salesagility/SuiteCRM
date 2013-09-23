<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once('include/connectors/sources/ext/rest/rest.php');
class ext_rest_linkedin extends ext_rest {
	public function __construct(){
		parent::__construct();
		$this->_enable_in_wizard = false;
		$this->_enable_in_hover = true;
	}
	
	/*
	 * getItem
	 *
	 * As the linked in connector does not have a true API call, we simply
	 * override this abstract method
	 */
	public function getItem($args=array(), $module=null){}


    /*
	 * getList
	 *
	 * As the linked in connector does not have a true API call, we simply
	 * override this abstract method

	 */

    public function getList($args = array(), $module = null)
    {
        $params = array('count' => 10, 'start' => 0);

        if (!empty($args['maxResults']))
            $params['count'] = $args['maxResults'];

        if (!empty($args['startIndex']))
            $params['start'] = $args['startIndex'];


        $results = FALSE;

        try
        {
            $queryFields = "(id,first-name,last-name,industry,headline,summary,location:(name,country:(code)),positions:(title,summary,company:(name)))";
            $url = "http://api.linkedin.com/v1/people/~/connections:$queryFields";
            $response = $this->_eapm->makeRequest("GET", $url, $params);
            $results = $this->formatListResponse($response);
        }

        catch (Exception $e)
        {
            $GLOBALS['log']->fatal("Unable to retrieve item list for linkedin connector.");
        }

        return $results;
    }


    private function formatListResponse($resp)
    {
        $records = array();
        $xmlResp = simplexml_load_string($resp);
        if ($xmlResp === FALSE)
            throw new Exception('Unable to parse list response');

        foreach ($xmlResp->person as $person)
        {
            $tmp = array();
            $this->convertPersonListResponeToArray($person, $tmp);
            $records[] = $tmp;

        }

        return array('totalResults' => (int)$xmlResp->attributes()->total,
                     'startIndex' => (int)$xmlResp->attributes()->start,
                     'records' => $records);
    }


    private function convertPersonListResponeToArray(SimpleXMLElement $xmlResp, &$result, $suffix = '')
    {
        foreach ((array)$xmlResp as $k => $v)
        {
            $key = !empty($suffix) ? "{$suffix}-{$k}" : $k;
            if ($v instanceof SimpleXMLElement) {
                $this->convertPersonListResponeToArray($v, $result, $key);
            }

            else if (is_array($v)) //Skip over attributes
            {
                if ($k == 'position')
                {
                    $latestPosition = $v[0];
                    $result['company_name'] = (string)$latestPosition->company->name;
                    $result['title'] = (string)$latestPosition->title;
                    $result['position-summary'] = (string)$latestPosition->summary;

                }
            }
            else
            {
                $result[$key] = $v;
            }
        }
    }
}

?>