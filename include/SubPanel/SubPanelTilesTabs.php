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

require_once('include/SubPanel/SubPanel.php');
require_once('include/SubPanel/SubPanelDefinitions.php');
require_once('include/SubPanel/SubPanelTiles.php');
/**
 * Tabbed subpanel tiles
 * @api
 */
class SubPanelTilesTabs extends SubPanelTiles
{

	function SubPanelTiles(&$focus, $layout_def_key='', $layout_def_override = '')
	{

		$this->focus = $focus;
		$this->id = $focus->id;
		$this->module = $focus->module_dir;
		$this->layout_def_key = $layout_def_key;
		$this->subpanel_definitions = new SubPanelDefinitions($focus, $layout_def_key, $layout_def_override);
	}

    function getSubpanelGroupLayout($selectedGroup)
    {
        global $current_user;

        $layoutParams = $this->module;
        //WDong Bug: 12258 "All" tab in the middle of a record's detail view is not localized.
        if($selectedGroup != translate('LBL_TABGROUP_ALL'))
        {
            $layoutParams .= ':'.$selectedGroup;
        }

        // see if user current user has custom subpanel layout
        return $current_user->getPreference('subpanelLayout', $layoutParams);
    }

    function applyUserCustomLayoutToTabs($tabs, $key='All')
    {
        //WDong Bug: 12258 "All" tab in the middle of a record's detail view is not localized.
        if($key=='All')
    	{
    		$key=translate('LBL_TABGROUP_ALL');
    	}
        $usersCustomLayout = SubPanelTilesTabs::getSubpanelGroupLayout($key);
        if(!empty($usersCustomLayout))
        {
            /* Return elements of the custom layout
             * which occur in $tabs in unchanged order.
             * Then append elements of $tabs which are
             * not included in the layout. */
            $diff = array_diff($tabs, $usersCustomLayout);
            $tabs = array_intersect($usersCustomLayout, $tabs);
            foreach($diff as $subpanel)
            {
            	$tabs []= $subpanel;
            }
        }

        return $tabs;
    }

    /*
     * Place subpanels into tabs for display on a DetailView
     * @param array $tabs	Array containing the ids of all subpanels to be placed into tabs
     * @param boolean $showTabs	Call the view code to display the generated tabs
     * @param string $selectedGroup	(Optional) Name of any selected tab (defaults to 'All')
     */
	function getTabs($tabs, $showTabs = true, $selectedGroup='All')
    {
        //WDong Bug: 12258 "All" tab in the middle of a record's detail view is not localized.
        if($selectedGroup=='All')
        	$selectedGroup=translate('LBL_TABGROUP_ALL');

    	// Set up a mapping from subpanelID, found in the $tabs list, to the source module name
    	// As the $GLOBALS['tabStructure'] array holds the Group Tabs by module name we need to efficiently convert between the two
    	// when constructing the subpanel tabs
    	// Note that we can't use the very similar GroupedTabStructure class as it lacks this mapping, and logically, it is designed
    	// for use when constructing the module by module tabs, not the subpanel tabs, as we move away from using module names to represent
    	// subpanels, and use unique subpanel IDs instead.

    	$moduleNames = array () ;
    	foreach ( $tabs as $subpanelID )
    	{
            // Bug #44344 : Custom relationships under same module only show once in subpanel tabs
            // use object property instead new object to have ability run unit test (can override subpanel_definitions)
            $subpanel =  $this->subpanel_definitions->load_subpanel( $subpanelID );
    		if ($subpanel !== false)
    		  $moduleNames [ $subpanelID ] = $subpanel->get_module_name() ;
    	}

    	$groups =  array () ;
    	$found = array () ;

        foreach( $GLOBALS['tabStructure'] as $mainTab => $subModules)
        {
            foreach( $subModules['modules'] as $key => $subModule )
            {
    			foreach ( $tabs as $subpanelID )
                    if (isset($moduleNames[ $subpanelID ] ) && strcasecmp( $subModule , $moduleNames[ $subpanelID ] ) === 0)
                    {
                        // Bug #44344 : Custom relationships under same module only show once in subpanel tabs
                        $groups [ translate ( $mainTab ) ] [ 'modules' ] [] = $subpanelID ;
                    	$found [ $subpanelID ] = true ;
                	}
            }
        }

        // Put all the remaining subpanels into the 'Other' tab.

        foreach( $tabs as $subpanelID )
        {
        	if ( ! isset ( $found [ $subpanelID ] ) )
	        	$groups [ translate ('LBL_TABGROUP_OTHER') ]['modules'] [] = $subpanelID ;
        }

        /* Move history to same tab as activities */
        if(in_array('history', $tabs) && in_array('activities', $tabs))
        {
            foreach($groups as $mainTab => $group)
            {
            	if(in_array('activities', array_map('strtolower', $group['modules'])))
                {
                	if(!in_array('history', array_map('strtolower', $group['modules'])))
                    {
                    	/* Move hist from there to here */
                        $groups[$mainTab]['modules'] []= 'history';
                    }
                }
                else if(false !== ($i = array_search('history', array_map('strtolower', $group['modules']))))
                {
                    unset($groups[$mainTab]['modules'][$i]);
                    if(empty($groups[$mainTab]['modules']))
                    {
                    	unset($groups[$mainTab]);
                    }
                }
            }
        }

        /* Add the 'All' group.
         * Note that if a tab group already exists with the name 'All',
         * it will be overwritten in this union operation.
         */
        if(count($groups) <= 1)
        	$groups = array(translate('LBL_TABGROUP_ALL') => array('label' => translate('LBL_TABGROUP_ALL'), 'modules' => $tabs));
        else
            $groups = array(translate('LBL_TABGROUP_ALL') => array('label' => translate('LBL_TABGROUP_ALL'), 'modules' => $tabs)) + $groups;
        /* Note - all $display checking and array_intersects with $tabs
         * are now redundant (thanks to GroupedTabStructure), and could
         * be removed for performance, but for now can stay to help ensure
         * that the tabs get renedered correctly.
         */

        $retTabs = array();
        if($showTabs)
        {
        	require_once('include/SubPanel/SugarTab.php');
        	$sugarTab = new SugarTab();

            $displayTabs = array();
            $otherTabs = array();

    	    foreach ($groups as $key=>$tab)
    		{
                $display = false;
                foreach($tab['modules'] as $subkey=>$subtab)
                {
                    if(in_array(strtolower($subtab), $tabs))
                    {
                        $display = true;
                        break;
                    }
                }

                $selected = '';

                if($selectedGroup == $key)
                {
                    $selected = 'current';
                }

                if($display)
                {
                    $relevantTabs = SubPanelTilesTabs::applyUserCustomLayoutToTabs($tabs, $key);

                    $sugarTabs[$key] = array(//'url'=>'index.php?module=' . $_REQUEST['module'] . '&record=' . $_REQUEST['record'] . '&action=' . $_REQUEST['action']. '&subpanel=' . $key.'#tabs',
                                         //'url'=>"javascript:SUGAR.util.retrieveAndFill('index.php?to_pdf=1&module=MySettings&action=LoadTabSubpanels&loadModule={$_REQUEST['module']}&record={$_REQUEST['record']}&subpanel=$key','subpanel_list',null,null,null);",
                                         'label'=>( !empty($tab['label']) ? $tab['label']: $key ),
                                         'type'=>$selected);

                    $otherTabs[$key] = array('key'=>$key, 'tabs'=>array());

                    $orderedTabs = array_intersect($relevantTabs, array_map('strtolower', $groups[$key]['modules']));

                    foreach($orderedTabs as $subkey => $subtab)
                    {
                        $otherTabs[$key]['tabs'][$subkey] = array('key'=>$subtab, 'label'=>translate($this->subpanel_definitions->layout_defs['subpanel_setup'][$subtab]['title_key']));
                    }

                    if($selectedGroup == $key)
                    {
                        $displayTabs = $otherTabs[$key]['tabs'];
                        $retTabs = $orderedTabs;
                    }
                }
    		}

            if(empty($displayTabs) && !empty($otherTabs))
            {
                //WDong Bug: 12258 "All" tab in the middle of a record's detail view is not localized.
                $selectedGroup = translate('LBL_TABGROUP_ALL');
                $displayTabs = $otherTabs[$selectedGroup]['tabs'];
                $sugarTabs[$selectedGroup]['type'] = 'current';
                $retTabs = array_intersect($tabs, array_map('strtolower', $groups[$selectedGroup]['modules']));
            }

            if (!empty($sugarTabs) || !empty($otherTabs) ) {
            	$sugarTab->setup($sugarTabs, $otherTabs, $displayTabs, $selectedGroup);
            	$sugarTab->display();
            }
        }
        else
        {
            $tabs = SubPanelTilesTabs::applyUserCustomLayoutToTabs($tabs, $selectedGroup);

            $retTabs = array_intersect($tabs, array_map('strtolower', $groups[$selectedGroup]['modules']));
        }

		return $retTabs;
	}
}
?>
