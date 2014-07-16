<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
    die ( 'Not A Valid Entry Point' ) ;

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


function get_body (&$ss , $vardef)
{
    
    $modules = array ( ) ;
    
    require_once 'modules/ModuleBuilder/parsers/relationships/DeployedRelationships.php' ;
    $relatableModules = array_keys ( DeployedRelationships::findRelatableModules () ) ;
    
    foreach ( $relatableModules as $module )
    {
        $modules [ $module ] = translate ( 'LBL_MODULE_NAME', $module ) ;
    }
    
    foreach ( ACLController::disabledModuleList ( $modules, false, 'list' ) as $disabled_parent_type )
    {
        unset ( $modules [ $disabled_parent_type ] ) ;
    }
    unset ( $modules [ "" ] ) ;
    unset ( $modules [ 'Activities' ] ) ; // cannot relate to Activities as only Activities' submodules have records; use a Flex Relate instead!
    
    // tyoung bug 18631 - reduce potential confusion when creating a relate custom field for Products - actually points to the Product Catalog, so label it that way in the drop down list
    if (isset ( $modules [ 'ProductTemplates' ] ) && $modules [ 'ProductTemplates' ] == 'Product')
    {
        $modules [ 'ProductTemplates' ] = translate ( 'LBL_MODULE_NAME', 'ProductTemplates' ) ;
    }
    
    // C.L. - Merge from studio_rel_user branch
    $modules['Users'] = translate('LBL_MODULE_NAME', 'Users');    
    asort($modules);

    $ss->assign ( 'modules', $modules ) ;
    
    return $ss->fetch ( 'modules/DynamicFields/templates/Fields/Forms/relate.tpl' ) ;
}
?>
