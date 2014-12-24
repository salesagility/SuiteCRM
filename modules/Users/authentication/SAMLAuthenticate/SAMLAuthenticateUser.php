<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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





/**
 * This file is where the user authentication occurs. No redirection should happen in this file.
 *
 */
require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticateUser.php');


class SAMLAuthenticateUser extends SugarAuthenticateUser{
	/**
	 * Does the actual authentication of the user and returns an id that will be used
	 * to load the current user (loadUserOnSession)
	 *
	 * @param STRING $name
	 * @param STRING $password
	 * @return STRING id - used for loading the user
	 *
	 * Contributions by Erik Mitchell erikm@logicpd.com
	 */
	function authenticateUser($name, $password) {
		$GLOBALS['log']->debug('authenticating user.'); // JMH
//        uncomment the line below to test on the server. this is a temporary solution - John H. (task 9069)
//		$_POST['SAMLResponse'] = "PHNhbWxwOlJlc3BvbnNlIHhtbG5zOnNhbWw9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDphc3NlcnRpb24iIHhtbG5zOnNhbWxwPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6cHJvdG9jb2wiIHhtbG5zOnhzPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxL1hNTFNjaGVtYSIgeG1sbnM6eHNpPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxL1hNTFNjaGVtYS1pbnN0YW5jZSIgRGVzdGluYXRpb249Imh0dHA6Ly9kZXZzdWdhci5ydHAucmFsZWlnaC5pYm0uY29tL3N1Z2FyLXNhbWwvaW5kZXgucGhwP21vZHVsZT1Vc2VycyZhbXA7YWN0aW9uPUF1dGhlbnRpY2F0ZSIgSUQ9IkZJTVJTUF8xZjUxNjc4Ni0wMTM0LTFmMGQtYWRiZS1iZWE4M2JhM2EyNTEiIEluUmVzcG9uc2VUbz0iXzhmMmFmY2UyNTJiNDVhZGVkNWE4IiBJc3N1ZUluc3RhbnQ9IjIwMTEtMTItMDhUMjA6MTU6NTVaIiBWZXJzaW9uPSIyLjAiPg0KICAgIDxzYW1sOklzc3VlciBGb3JtYXQ9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpuYW1laWQtZm9ybWF0OmVudGl0eSI+aHR0cHM6Ly9sb25kby5ydHAucmFsZWlnaC5pYm0uY29tOjk0NDMvc3BzL1NBTUxJZHAvc2FtbDIwPC9zYW1sOklzc3Vlcj4NCiAgICA8c2FtbHA6U3RhdHVzPg0KICAgICAgICA8c2FtbHA6U3RhdHVzQ29kZSBWYWx1ZT0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOnN0YXR1czpTdWNjZXNzIj48L3NhbWxwOlN0YXR1c0NvZGU+DQogICAgPC9zYW1scDpTdGF0dXM+DQogICAgPHNhbWw6QXNzZXJ0aW9uIElEPSJBc3NlcnRpb24tdXVpZDFmNTE2NzdkLTAxMzQtMWE2NC05MTA4LWJlYTgzYmEzYTI1MSIgSXNzdWVJbnN0YW50PSIyMDExLTEyLTA4VDIwOjE1OjU1WiIgVmVyc2lvbj0iMi4wIj4NCiAgICAgICAgPHNhbWw6SXNzdWVyIEZvcm1hdD0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOm5hbWVpZC1mb3JtYXQ6ZW50aXR5Ij5odHRwczovL2xvbmRvLnJ0cC5yYWxlaWdoLmlibS5jb206OTQ0My9zcHMvU0FNTElkcC9zYW1sMjA8L3NhbWw6SXNzdWVyPg0KICAgICAgICA8ZHM6U2lnbmF0dXJlIHhtbG5zOmRzPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjIiBJZD0idXVpZDFmNTE2NzgxLTAxMzQtMWRmYS04ZDAwLWJlYTgzYmEzYTI1MSI+DQogICAgICAgICAgICA8ZHM6U2lnbmVkSW5mbz4NCiAgICAgICAgICAgICAgICA8ZHM6Q2Fub25pY2FsaXphdGlvbk1ldGhvZCBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvMTAveG1sLWV4Yy1jMTRuIyI+PC9kczpDYW5vbmljYWxpemF0aW9uTWV0aG9kPg0KICAgICAgICAgICAgICAgIDxkczpTaWduYXR1cmVNZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjcnNhLXNoYTEiPjwvZHM6U2lnbmF0dXJlTWV0aG9kPg0KICAgICAgICAgICAgICAgIDxkczpSZWZlcmVuY2UgVVJJPSIjQXNzZXJ0aW9uLXV1aWQxZjUxNjc3ZC0wMTM0LTFhNjQtOTEwOC1iZWE4M2JhM2EyNTEiPg0KICAgICAgICAgICAgICAgICAgICA8ZHM6VHJhbnNmb3Jtcz4NCiAgICAgICAgICAgICAgICAgICAgICAgIDxkczpUcmFuc2Zvcm0gQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjZW52ZWxvcGVkLXNpZ25hdHVyZSI+PC9kczpUcmFuc2Zvcm0+DQogICAgICAgICAgICAgICAgICAgICAgICA8ZHM6VHJhbnNmb3JtIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8xMC94bWwtZXhjLWMxNG4jIj4NCiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8eGMxNG46SW5jbHVzaXZlTmFtZXNwYWNlcyB4bWxuczp4YzE0bj0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8xMC94bWwtZXhjLWMxNG4jIiBQcmVmaXhMaXN0PSJ4cyBzYW1sIHhzaSI+PC94YzE0bjpJbmNsdXNpdmVOYW1lc3BhY2VzPg0KICAgICAgICAgICAgICAgICAgICAgICAgPC9kczpUcmFuc2Zvcm0+DQogICAgICAgICAgICAgICAgICAgIDwvZHM6VHJhbnNmb3Jtcz4NCiAgICAgICAgICAgICAgICAgICAgPGRzOkRpZ2VzdE1ldGhvZCBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvMDkveG1sZHNpZyNzaGExIj48L2RzOkRpZ2VzdE1ldGhvZD4NCiAgICAgICAgICAgICAgICAgICAgPGRzOkRpZ2VzdFZhbHVlPkdMV3BGdkYwYkx3UUVMWFpNZ1ozczFKL3pSUT08L2RzOkRpZ2VzdFZhbHVlPg0KICAgICAgICAgICAgICAgIDwvZHM6UmVmZXJlbmNlPg0KICAgICAgICAgICAgPC9kczpTaWduZWRJbmZvPg0KICAgICAgICAgICAgPGRzOlNpZ25hdHVyZVZhbHVlPkRVaEJueU1UUmFYNlUvT2hDZ2lrN08yZ2hDaXl5akNNOWpHTmk5UE1MMXdidWkyMjNyNCtaRW9tOGdodjVpL3pCOU0yVUhCZTNpdVNEYUUyVGxWVm96Y1h3bHJSUUFaTS9lMVZDck9hRFdhWWJURjZKZ05aM1RWekpDVy9helBNa21aenROV2laY2Z4Q3hjODRkYmlCSzlCQzNOdEdVZGlwWlpQb3h4WUlZYz08L2RzOlNpZ25hdHVyZVZhbHVlPg0KICAgICAgICAgICAgPGRzOktleUluZm8+DQogICAgICAgICAgICAgICAgPGRzOlg1MDlEYXRhPg0KICAgICAgICAgICAgICAgICAgICA8ZHM6WDUwOUNlcnRpZmljYXRlPk1JSUMxekNDQWtDZ0F3SUJBZ0lJRWtvd1hvZlF0eWd3RFFZSktvWklodmNOQVFFRkJRQXdnWW94Q3pBSkJnTlZCQVlUQWxWVE1Rd3dDZ1lEVlFRS0V3TkpRazB4RkRBU0JnTlZCQXNUQzJ4dmJtUnZUbTlrWlRBeE1SZ3dGZ1lEVlFRTEV3OXNiMjVrYjA1dlpHVXdNVU5sYkd3eEdUQVhCZ05WQkFzVEVGSnZiM1FnUTJWeWRHbG1hV05oZEdVeElqQWdCZ05WQkFNVEdXeHZibVJ2TG5KMGNDNXlZV3hsYVdkb0xtbGliUzVqYjIwd0hoY05NVEV4TURBMU1UWXpOekF6V2hjTk1USXhNREEwTVRZek56QXpXakJ2TVFzd0NRWURWUVFHRXdKVlV6RU1NQW9HQTFVRUNoTURTVUpOTVJRd0VnWURWUVFMRXd0c2IyNWtiMDV2WkdVd01URVlNQllHQTFVRUN4TVBiRzl1Wkc5T2IyUmxNREZEWld4c01TSXdJQVlEVlFRREV4bHNiMjVrYnk1eWRIQXVjbUZzWldsbmFDNXBZbTB1WTI5dE1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ1BkcHBnRnRMWXJJdUdwSE1uNXYzZzdRNXRPdHZRZzh4WW9nVjkzdnJBTWhtcUlGWkFqUkFzWXdGc3lyaFQ3UnVxckttaEhtbnEvSUlQcHVWbGhZRjZvZisyTEExZ0VkSGMyb1lBRk5WNUl5cFdRS1JjUWF6RlNHc2FqQktLUExjclNaY20zQVNHYlYySHVNKytNMFZmMWs4Q3hqM1hOb1NIRjJRZnZVUHZmUUlEQVFBQm8yQXdYakJKQmdOVkhSRUVRakJBZ1Q1UWNtOW1hV3hsVlZWSlJEcEJjSEJUY25Zd01TMUNRVk5GTFRJM1ltRmhOMlEzTFRoallUTXROR1F6T1MxaU1qYzNMVEprWm1VNE1tSXpaamxtWXpBUkJnTlZIUTRFQ2dRSVFxUWFNYVlyYmE4d0RRWUpLb1pJaHZjTkFRRUZCUUFEZ1lFQWxJd0FlZnpnRXRLeXBBazJndkhFQnk1Njc1UGtBcU5MT3ZrN2JDRVRsQnVXdTAya0N2bGtSQ09FdFJCanIrbVBHYkRaaHRTZEt3SkFibDhiSXYvYkgzVnpSVHd3ODdYaUZzVzFPbDViL3o0SVBWcmhDVFFPMWVMQ2w2N3kycHd4SmROYWxOQUFXelpERytRSjNFQlp6K3hxUVdKbktRTkVjQjY3K0xBVXNHRT08L2RzOlg1MDlDZXJ0aWZpY2F0ZT4NCiAgICAgICAgICAgICAgICA8L2RzOlg1MDlEYXRhPg0KICAgICAgICAgICAgPC9kczpLZXlJbmZvPg0KICAgICAgICA8L2RzOlNpZ25hdHVyZT4NCiAgICAgICAgPHNhbWw6U3ViamVjdD4NCiAgICAgICAgICAgIDxzYW1sOk5hbWVJRCBGb3JtYXQ9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjEuMTpuYW1laWQtZm9ybWF0OnVuc3BlY2lmaWVkIj5DLUNCVEs4OTc8L3NhbWw6TmFtZUlEPg0KICAgICAgICAgICAgPHNhbWw6U3ViamVjdENvbmZpcm1hdGlvbiBNZXRob2Q9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpjbTpiZWFyZXIiPg0KICAgICAgICAgICAgICAgIDxzYW1sOlN1YmplY3RDb25maXJtYXRpb25EYXRhIEluUmVzcG9uc2VUbz0iXzhmMmFmY2UyNTJiNDVhZGVkNWE4IiBOb3RPbk9yQWZ0ZXI9IjIwMTEtMTItMDhUMjA6MTY6NTVaIiBSZWNpcGllbnQ9Imh0dHA6Ly9kZXZzdWdhci5ydHAucmFsZWlnaC5pYm0uY29tL3N1Z2FyLXNhbWwvaW5kZXgucGhwP21vZHVsZT1Vc2VycyZhbXA7YWN0aW9uPUF1dGhlbnRpY2F0ZSI+PC9zYW1sOlN1YmplY3RDb25maXJtYXRpb25EYXRhPg0KICAgICAgICAgICAgPC9zYW1sOlN1YmplY3RDb25maXJtYXRpb24+DQogICAgICAgIDwvc2FtbDpTdWJqZWN0Pg0KICAgICAgICA8c2FtbDpDb25kaXRpb25zIE5vdEJlZm9yZT0iMjAxMC0xMi0wOFQyMDoxNDo1NVoiIE5vdE9uT3JBZnRlcj0iMjAxMy0xMi0wOFQyMDoxNjo1NVoiPg0KICAgICAgICAgICAgPHNhbWw6QXVkaWVuY2VSZXN0cmljdGlvbj4NCiAgICAgICAgICAgICAgICA8c2FtbDpBdWRpZW5jZT5waHAtc2FtbDwvc2FtbDpBdWRpZW5jZT4NCiAgICAgICAgICAgIDwvc2FtbDpBdWRpZW5jZVJlc3RyaWN0aW9uPg0KICAgICAgICA8L3NhbWw6Q29uZGl0aW9ucz4NCiAgICAgICAgPHNhbWw6QXV0aG5TdGF0ZW1lbnQgQXV0aG5JbnN0YW50PSIyMDExLTEyLTA4VDIwOjE1OjU1WiIgU2Vzc2lvbkluZGV4PSJ1dWlkMWY0ZTU2MzItMDEzNC0xNjRlLTk1MWItYmVhODNiYTNhMjUxIiBTZXNzaW9uTm90T25PckFmdGVyPSIyMDExLTEyLTA4VDIxOjE1OjU1WiI+DQogICAgICAgICAgICA8c2FtbDpBdXRobkNvbnRleHQ+DQogICAgICAgICAgICAgICAgPHNhbWw6QXV0aG5Db250ZXh0Q2xhc3NSZWY+dXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOmFjOmNsYXNzZXM6UGFzc3dvcmRQcm90ZWN0ZWRUcmFuc3BvcnQ8L3NhbWw6QXV0aG5Db250ZXh0Q2xhc3NSZWY+DQogICAgICAgICAgICA8L3NhbWw6QXV0aG5Db250ZXh0Pg0KICAgICAgICA8L3NhbWw6QXV0aG5TdGF0ZW1lbnQ+DQogICAgICAgIDxzYW1sOkF0dHJpYnV0ZVN0YXRlbWVudD4NCiAgICAgICAgICAgIDxzYW1sOkF0dHJpYnV0ZSBOYW1lPSJETl9WYWx1ZSIgTmFtZUZvcm1hdD0idXJuOmlibTpuYW1lczpJVEZJTTo1LjE6YWNjZXNzbWFuYWdlciI+DQogICAgICAgICAgICAgICAgPHNhbWw6QXR0cmlidXRlVmFsdWUgeHNpOnR5cGU9InhzOnN0cmluZyI+dWlkPUMtQ0JUSzg5NyxjPXVzLG91PWJsdWVwYWdlcyxvPWlibS5jb208L3NhbWw6QXR0cmlidXRlVmFsdWU+DQogICAgICAgICAgICA8L3NhbWw6QXR0cmlidXRlPg0KICAgICAgICA8L3NhbWw6QXR0cmlidXRlU3RhdGVtZW50Pg0KICAgIDwvc2FtbDpBc3NlcnRpb24+DQo8L3NhbWxwOlJlc3BvbnNlPg==";



		if(empty($_POST['SAMLResponse']))return parent::authenticateUser($name, $password);
		
		$GLOBALS['log']->debug('have saml data.'); // JMH
		// Look for custom versions of settings.php if it exists

		require_once('modules/Users/authentication/SAMLAuthenticate/lib/onelogin/saml.php');
        require(get_custom_file_if_exists('modules/Users/authentication/SAMLAuthenticate/settings.php'));

        try {
            $samlresponse = new SamlResponse($settings, $_POST['SAMLResponse']);
        } catch (Exception $e) {
            $GLOBALS['log']->error("Unexpected exception: " . $e->getMessage());
            return '';
        }

		if ($samlresponse->is_valid()){
			$GLOBALS['log']->debug('response is valid');
			$customFields = $this->getAdditionalFieldsToSelect($samlresponse, $settings);
			$GLOBALS['log']->debug('got this many custom fields:' . count($customFields));

            $id = $this->get_user_id($samlresponse, $settings);
            $user = $this->fetch_user($id, $settings->id);

			//user already exists use this one
			if ($user->id){
				$GLOBALS['log']->debug('have db results'); // JMH
				if($user->status != 'Inactive')
				{
					$GLOBALS['log']->debug('have current user'); // JMH
					$this->updateCustomFields($user, $samlresponse, $settings);
					return $user->id;
				}
				else
				{
					$GLOBALS['log']->debug('have inactive user'); // JMH
					return '';
				}
			}
			else
			{
                $xmlDoc = $samlresponse->xml;
                $xpath = new DOMXpath($xmlDoc);
                if (isset($settings->customCreateFunction))
                {
                    return call_user_func($settings->customCreateFunction, $this, $samlresponse->get_nameid(), $xpath, $settings);
                } else {
                    return $this->createUser($samlresponse->get_nameid(), $xpath, $settings);
                }
			}
//      comment out the following two lines for testing - John H. (task 9069)
		}
		return '';
	}
	
	
	/**
	* Updates the custom fields listed in settings->saml_settings['update'] in our
	* db records with the data from the xml in the saml assertion. Every field
	* listed in the ['update'] array is a key whose value is a (hopefully) valid
	* xpath, which in turn can be used to retrive the value of the node specified
	* by that xpath. If the value of the node does not equal the value in our
	* records, update our records to match the value from the xml.
	*
	* @param User $user - user fetched from our db.
	* @param SamlResponse $samlresponse - saml provider response.
	* @param SamlSettings $settings - our settings object.
	* @return int - 0 = no action taken, 1 = user record saved, -1 = no update.
	*
	* Contributed by Mike Andersen, SugarCRM.
	**/
	function updateCustomFields($user, $samlresponse, $settings)
	{
		$customFields = $this->getCustomFields($settings, 'update');

		if (count($customFields) == 0)
		{
			$GLOBALS['log']->debug("No custom fields! So returning 0."); // JMH
			return 0;
		}
		
		$GLOBALS['log']->debug("updateCF()... userid={$user->id}"); // JMH
		
		$xmlDoc = $samlresponse->xml;
		$xpath = new DOMXpath($xmlDoc);
		$GLOBALS['log']->debug("Created xpath object."); // JMH
		
		$customFieldUpdated = false;
		
		foreach ($customFields as $field)
		{
			$GLOBALS['log']->debug("Top of fields loop with $field."); // JMH
			if (!property_exists($user, $field))
			{
				$GLOBALS['log']->debug("$field is not a user field. \nThe fields are: " . var_export(array_keys(get_object_vars($user)), TRUE)); // JMH
				// custom field not listed in db query results!
				continue;
			}
			$customFieldValue = $user->$field;
			
			$xmlNodes = $xpath->query($settings->saml_settings['update'][$field]);
			if ($xmlNodes === false)
			{
				// malformed xpath!
				$GLOBALS['log']->debug("$field contains bad xpath: " . $settings->saml_settings['update'][$field]); // JMH
				continue;
			}
			$GLOBALS['log']->debug("updateCF(): 3"); // JMH
			if ($xmlNodes->length == 0)
			{
				// no nodes match xpath!
				$GLOBALS['log']->debug("$field no nodes match this xpath: " . $settings->saml_settings['update'][$field]); // JMH
				continue;
			}
			
			$xmlValue = $xmlNodes->item(0)->nodeValue;
			$GLOBALS['log']->debug("$field xpath returned $xmlValue"); // JMH
			
			if ($customFieldValue != $xmlValue)
			{
				// need to update our user record.
				$customFieldUpdated = true;
				$user->$field = $xmlValue;
				$GLOBALS['log']->debug("db is out of date. setting {$field} to {$xmlValue}"); // JMH
			}
		}
		
		if ($customFieldUpdated)
		{
			$GLOBALS['log']->debug("updateCustomFields calling user->save() and returning 0"); // JMH
			$user->save();
			return 1;
		}
		
		$GLOBALS['log']->debug("updateCustomFields found no fields to update. Returning -1"); // JMH
		return -1;
	}
	
	
	/**
	* Determines if there are custom fields to add to our select statement, and
	* returns a comma prepended, comma-delimited list of those custom fields.
	*
	* @param SamlResponse $samlresponse
	* @param SamlSettings $settings
	* @return String $additionalFields = either empty, or ", field1[, field2, fieldn]"
	* 
	* Contributed by Mike Andersen, SugarCRM.
	**/
	function getAdditionalFieldsToSelect($samlresponse, $settings)
	{
		if (isset($settings->saml_settings) && isset($settings->saml_settings['update']) && count($settings->saml_settings['update']) > 0)
        {
			return ',' . implode(',', $this->getCustomFields($settings, 'update'));
		}
		return '';
	}
	
	
	/**
	* Returns an array of custom field names. These names are the keys in the
	* 'update' hash in $settings->saml_settings hash. 
	* See modules/Users/authentication/SAMLAuthenticate/settings.php for details.
	*
	* @param SamlSettings $settings
	* @param String $which - which custom fields: 'check', 'create' or 'update'
	* @return Array - list of custom field names.
	*
	* Contributed by Mike Andersen, SugarCRM.
	**/
	function getCustomFields($settings, $which)
	{
		if (IsSet($settings->saml_settings[$which]))
		{
			return array_keys($settings->saml_settings[$which]);
		}
		else
		{
			$empty = array();
			return $empty;
		}
	}
		
	

	/**
	 * Creates a user with the given User Name and returns the id of that new user
	 * populates the user with what was set in the SAML Response
	 *
	 * @param STRING $name
	 * @param DOMXpath $xpath
	 * @param SamlSettings $settings - our settings object.
	 * @return STRING $id
	 */
	function createUser($name, $xpath, $settings)
  {
  	$GLOBALS['log']->debug("Called createUser");
	  $user = new User();
		$user->user_name = $name;
		$user->email1 = $name;
		$user->last_name = $name;
		$user->employee_status = 'Active';
		$user->status = 'Active';
		$user->is_admin = 0;
		$user->external_auth_only = 1;
		$user->system_generated_password = 0;
		
		// Loop through the create custom fields and update their values in the 
		// user object from the xml SAML response.
		$customFields = $this->getCustomFields($settings, 'create');
  	$GLOBALS['log']->debug("number of custom fields: " . count($customFields));
		foreach ($customFields as $field) 
		{
			$GLOBALS['log']->debug("xpath for $field is " . $settings->saml_settings['create'][$field]);
			$xmlNodes = $xpath->query($settings->saml_settings['create'][$field]);
			if ($xmlNodes === false)
			{
				// malformed xpath!
				$GLOBALS['log']->debug("Bad xpath: " . $settings->saml_settings['create'][$field]);
				continue;
			}
			if ($xmlNodes->length == 0)
			{
				// no nodes match xpath!
				$GLOBALS['log']->debug("No nodes match this xpath: " . $settings->saml_settings['create'][$field]);
				continue;
			}
			
			if ($field == 'id')
			{
				$user->new_with_id = true;
			}
			
			$xmlValue = $xmlNodes->item(0)->nodeValue;
			$GLOBALS['log']->debug("Setting $field to $xmlValue");
			$user->$field = $xmlValue;
		}
		
  	$GLOBALS['log']->debug("finished loop - saving.");
		$user->save();
  	$GLOBALS['log']->debug("New user id is " . $user->id);
		return $user->id;
	}

    /**
     * Retrieves user ID from SamlResponse according to SamlSettings
     *
     * @param SamlResponse $samlresponse
     * @param SamlSettings $settings
     * @return string
     */
    protected function get_user_id($samlresponse, $settings)
    {
        if (isset($settings->saml_settings['check']['user_name']))
        {
            $xmlDoc = $samlresponse->xml;
            $xpath = new DOMXpath($xmlDoc);
            $query = $settings->saml_settings['check']['user_name'];
            $entries = $xpath->query($query);
            $name_id = $entries->item(0)->nodeValue;
        }
        else
        {
            $name_id = $samlresponse->get_nameid();
        }

        return $name_id;
    }

    /**
     * Fetches user by provided ID and field name
     *
     * @param mixed $id
     * @param string $field
     * @return User
     */
    protected function fetch_user($id, $field = null)
    {
        $user = new User();

        if (null !== $field)
        {
            switch ($field)
            {
                case 'user_name':
                    // fetch user id by username
                    $sql = 'select id from users where user_name = '
                        . $user->db->quoted($id) . ' and deleted = 0';
                    $data = $user->db->fetchOne($sql);
                    if (is_array($data)) {
                        $id = reset($data);
                        $user->retrieve($id);
                    }
                    break;
                case 'id':
                    $user->retrieve($id);
                    break;
                default:
                    // nothing else is implemented
                    break;
            }
        }
        else
        {
            // use email as a default primary key (onelogin.com provides it)
            $user->retrieve_by_email_address($id);
        }

        return $user;
    }

    /**
     * This is called when a user logs in
     *
     * @param string $name
     * @param string $password
     * @param boolean $fallback - is this authentication a fallback from a failed authentication
     * @param array $PARAMS
     * @return boolean
     */
    public function loadUserOnLogin($name, $password, $fallback = false, $PARAMS = array())
    {
        // provide dummy login and password to parent class so that authentication
        // process could go on
        return parent::loadUserOnLogin('onelogin', 'onelogin', $fallback, $PARAMS);
    }
}

?>
