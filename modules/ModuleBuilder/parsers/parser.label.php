<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
    die ( 'Not A Valid Entry Point' ) ;
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


require_once ('modules/ModuleBuilder/parsers/ModuleBuilderParser.php') ;

class ParserLabel extends ModuleBuilderParser
{

    function ParserLabel ($moduleName, $packageName = '' )
    {
        $this->moduleName = $moduleName;
        if (!empty($packageName))
            $this->packageName = $packageName ;
    }

    /**
     * Takes in the request params from a save request and processes
     * them for the save.
     * @param REQUEST $params       Labels as "label_".System label => Display label pairs
     * @param string $language      Language key, for example 'en_us'
     */
    function handleSave ($params , $language)
    {
        $labels = array ( ) ;
        foreach ( $params as $key => $value )
        {
            if (preg_match ( '/^label_/', $key ) && strcmp ( $value, 'no_change' ) != 0)
            {
                $labels [ strtoupper(substr ( $key, 6 )) ] = SugarCleaner::cleanHtml(from_html($value),false);
            }
        }
        if (!empty($this->packageName)) //we are in Module builder
        {
            return self::addLabels ( $language, $labels, $this->moduleName, "custom/modulebuilder/packages/{$this->packageName}/modules/{$this->moduleName}/language" ) ;
        } else
        {
            return self::addLabels ( $language, $labels, $this->moduleName ) ;
        }
    }

    /*
     * Remove a label from the language pack for a module
     * @param string $language      Language key, for example 'en_us'
     * @param string $label         The label to remove
     * @param string $labelvalue    The value of the label to remove
     * @param string $moduleName    Name of the module to which to add these labels
     * @param string $basepath      base path of the language file
     * @param string $forRelationshipLabel      whether this is a relationship label
     */
    static function removeLabel($language, $label, $labelvalue, $moduleName, $basepath = null, $forRelationshipLabel = false) {
        $GLOBALS [ 'log' ]->debug ( "ParserLabel->removeLabels($language, \$label, \$labelvalue, $moduleName, $basepath );" ) ;
        if (is_null ( $basepath ))
        {
            $deployedModule = true ;
            $basepath = "custom/modules/$moduleName/language" ;
            if($forRelationshipLabel){
            	$basepath = "custom/modules/$moduleName/Ext/Language" ;
            }
            if (! is_dir ( $basepath ))
            {
                $GLOBALS ['log']->debug("$basepath is not a directory.");
                return false;
            }
        }

        $filename = "$basepath/$language.lang.php" ;
        if($forRelationshipLabel){
        	$filename = "$basepath/$language.lang.ext.php" ;
     	}

        $dir_exists = is_dir ( $basepath ) ;

        $mod_strings = array ( ) ;

        if ($dir_exists)
        {
            if (file_exists ($filename))
            {
                // obtain $mod_strings
                include ($filename) ;
            } else {
                $GLOBALS ['log']->debug("file $filename does not exist.");
                return false;
            }
        } else {
            $GLOBALS ['log']->debug("directory $basepath does not exist.");
            return false ;
        }

        $changed = false ;

        if (isset($mod_strings[$label]) && $mod_strings[$label]==$labelvalue) {
            unset($mod_strings[$label]);
            $changed = true;
        }

        if ($changed)
        {
            if (! write_array_to_file ( "mod_strings", $mod_strings, $filename )) {
                $GLOBALS [ 'log' ]->fatal ( "Could not write $filename" ) ;
            } else {
                // if we have a cache to worry about, then clear it now
                if ($deployedModule) {
                    $GLOBALS ['log']->debug ( "PaserLabel->addLabels: clearing language cache" ) ;
                    $cache_key = "module_language." . $language . $moduleName ;
                    sugar_cache_clear ( $cache_key ) ;
                    LanguageManager::clearLanguageCache ( $moduleName, $language ) ;
                }
            }
        }

        return true ;
    }

    /*
     * Add a set of labels to the language pack for a module, deployed or undeployed
     * @param string $language      Language key, for example 'en_us'
     * @param array $labels         The labels to add in the form of an array of System label => Display label pairs
     * @param string $moduleName    Name of the module to which to add these labels
     * @param string $packageName   If module is undeployed, name of the package to which it belongs
     */
    static function addLabels ($language , $labels , $moduleName , $basepath = null, $forRelationshipLabel = false)
    {

        $GLOBALS [ 'log' ]->debug ( "ParserLabel->addLabels($language, \$labels, $moduleName, $basepath );" ) ;
        $GLOBALS [ 'log' ]->debug ( "\$labels:" . print_r ( $labels, true ) ) ;

        $deployedModule = false ;
        if (is_null ( $basepath ))
        {
            $deployedModule = true ;
            $basepath = "custom/modules/$moduleName/language" ;
            if($forRelationshipLabel){
            	$basepath = "custom/modules/$moduleName/Ext/Language" ;
            }
            if (! is_dir ( $basepath ))
            {
                mkdir_recursive($basepath);
            }
        }

        $filename = "$basepath/$language.lang.php" ;
        if($forRelationshipLabel){
        	$filename = "$basepath/$language.lang.ext.php" ;
     	}
        $dir_exists = is_dir ( $basepath ) ;

        $mod_strings = array ( ) ;

        if ($dir_exists)
        {
            if (file_exists ( $filename ))
            {
                // obtain $mod_strings
                include ($filename) ;
            }else if($forRelationshipLabel){
            	$fh = fopen ($filename, 'a');
            	fclose($fh);
            }
        } else
        {
            return false ;
        }

        	$changed = false ;

        //$charset = (isset($app_strings['LBL_CHARSET'])) ? $app_strings['LBL_CHARSET'] : $GLOBALS['sugar_config']['default_charset'] ;

	        foreach ( $labels as $key => $value )
	        {
            if (! isset ( $mod_strings [ $key ] ) || strcmp ( $value, $mod_strings [ $key ] ) != 0)
	            {
                    $mod_strings [$key] = to_html(strip_tags(from_html($value))); // must match encoding used in view.labels.php
	                $changed = true ;
	            }
	        }

	        if ($changed)
	        {
            $GLOBALS [ 'log' ]->debug ( "ParserLabel->addLabels: writing new mod_strings to $filename" ) ;
	            $GLOBALS [ 'log' ]->debug ( "ParserLabel->addLabels: mod_strings=".print_r($mod_strings,true) ) ;
            if (! write_array_to_file ( "mod_strings", $mod_strings, $filename ))
	            {
                $GLOBALS [ 'log' ]->fatal ( "Could not write $filename" ) ;
	            } else
	            {
	                // if we have a cache to worry about, then clear it now
                if ($deployedModule)
	                {
                            SugarCache::cleanOpcodes();
	                    $GLOBALS [ 'log' ]->debug ( "PaserLabel->addLabels: clearing language cache" ) ;
	                    $cache_key = "module_language." . $language . $moduleName ;
	                    sugar_cache_clear ( $cache_key ) ;
	                    LanguageManager::clearLanguageCache ( $moduleName, $language ) ;
	                }
	            }
	        }

        return true ;
    }

    /**
     * Takes in the request params from a save request and processes
     * them for the save.
     * @param $metadata
     * @param string $language      Language key, for example 'en_us'
     */
    function handleSaveRelationshipLabels ($metadata , $language)
        {
        foreach ( $metadata as $definition )
            {
        	$labels = array();
        	$labels[$definition [ 'system_label' ]] = $definition [ 'display_label' ];
        	self::addLabels ( $language, $labels, $definition [ 'module' ],null,true );
            }
        }

    function addLabelsToAllLanguages($labels)
            {
    	$langs = get_languages();
    	foreach($langs as $lang_key => $lang_display)
        {
    		$this->addLabels($lang_key, $labels, $this->moduleName);
        }
    }
}

?>
