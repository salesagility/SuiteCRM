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

class AjaxCompose{
	var $sections = array();
	var $crumbs = array('Home'=>'ModuleBuilder.main("Home")',/* 'Assistant'=>'Assistant.mbAssistant.xy=Array("650, 40"); Assistant.mbAssistant.show();'*/);
	function addSection($name, $title, $content, $action='activate'){
		$crumb = '';
		if($name == 'center'){
			$crumb = $this->getBreadCrumb();
		}
		$this->sections[$name] = array('title'=>$title,'crumb'=>$crumb, 'content'=>$content, 'action'=>$action);
	}
	
	function getJavascript(){
		if(!empty($this->sections['center'])){
			 if(empty($this->sections['east']))$this->addSection('east', '', '', 'deactivate');
			 if(empty($this->sections['east2']))$this->addSection('east2', '', '', 'deactivate');
		}
		
		$json = getJSONobj();
		return $json->encode($this->sections);
	}
	
	function addCrumb($name, $action){
		$this->crumbs[$name] = $action;
	}
	
	function getBreadCrumb(){
		$crumbs = '';
		$actions = array();
		$count = 0;
		foreach($this->crumbs as $name=>$action){
			if($name == 'Home'){
				$crumbs .= "<a onclick='$action' href='javascript:void(0)'>". getStudioIcon('home', 'home', 16, 16) . '</a>';
			}else if($name=='Assistant'){
				$crumbs .= "<a id='showassist' onclick='$action' href='javascript:void(0)'>". getStudioIcon('assistant', 'assistant', 16, 16) . '</a>';
			}else{
				if($count > 0){
					$crumbs .= '&nbsp;>&nbsp;';
				}else{
					$crumbs .= '&nbsp;|&nbsp;';
				}
				if(empty($action)){
					$crumbs .="<span class='crumbLink'>$name</span>";
					$actions[] = "";
				}else {
					$crumbs .="<a href='javascript:void(0);' onclick='$action' class='crumbLink'>$name</a>";
				    $actions[] = $action;
				}
				$count++;
			}
			
		}
		if($count > 1 && $actions[$count-2] != ""){
			$crumbs = "<a onclick='{$actions[$count-2]}' href='javascript:void(0)'>". getStudioIcon('back', 'back', 16, 16) . '</a>&nbsp;'. $crumbs;	
		}
		return $crumbs . '<br><br>';
		
		
	}
	
	function echoErrorStatus($labelName=''){
		$sections = array('failure'=>true,'failMsg'=>$labelName);
		$json = getJSONobj();
		echo $json->encode($sections);
	}
	
}
?>