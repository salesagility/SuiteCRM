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


class DynamicField {

    var $use_existing_labels = false; // this value is set to true by install_custom_fields() in ModuleInstaller.php; everything else expects it to be false
    var $base_path = "";

    function DynamicField($module = '') {
        $this->module = (! empty ( $module )) ? $module :( (isset($_REQUEST['module']) && ! empty($_REQUEST['module'])) ? $_REQUEST ['module'] : '');
        $this->base_path = "custom/Extension/modules/{$this->module}/Ext/Vardefs";
    }

   function getModuleName()
    {
        return $this->module ;
    }

    /*
     * As DynamicField has a counterpart in MBModule, provide the MBModule function getPackagename() here also
     */
    function getPackageName()
    {
        return null ;
    }

    function deleteCache(){
    }


    /**
    * This will add the bean as a reference in this object as well as building the custom field cache if it has not been built
    * LOADS THE BEAN IF THE BEAN IS NOT BEING PASSED ALONG IN SETUP IT SHOULD BE SET PRIOR TO SETUP
    *
    * @param SUGARBEAN $bean
    */
    function setup($bean = null) {
        if ($bean) {
            $this->bean = $bean;
        }
        if (isset ( $this->bean->module_dir )) {
            $this->module = $this->bean->module_dir;
        }
        if(!isset($GLOBALS['dictionary'][$this->bean->object_name]['custom_fields'])){
            $this->buildCache ( $this->module );
        }
    }

    function setLabel( $language='en_us' , $key , $value )
    {
        $params [ "label_" . $key ] = $value;
        require_once 'modules/ModuleBuilder/parsers/parser.label.php' ;
        $parser = new ParserLabel ( $this->module ) ;
        $parser->handleSave( $params , $language);
    }

    /**
    * Builds the cache for custom fields based on the vardefs
    *
    * @param STRING $module
    * @param boolean saveCache Boolean value indicating whether or not to pass saveCache value to saveToVardef, defaults to true
    * @return unknown
    */
    function buildCache($module = false, $saveCache=true) {
        //We can't build the cache while installing as the required database tables may not exist.
        if (!empty($GLOBALS['installing']) && $GLOBALS['installing'] == true|| empty($GLOBALS['db']))
            return false;
        if($module == '../data')return false;

        static $results = array ( ) ;

        $where = '';
        if (! empty ( $module )) {
            $where .= " custom_module='$module' AND ";
            unset( $results[ $module ] ) ; // clear out any old results for the module as $results is declared static
        }
        else
        {
            $results = array ( ) ; // clear out results - if we remove a module we don't want to have its old vardefs hanging around
        }

        $GLOBALS['log']->debug('rebuilding cache for ' . $module);
        $query = "SELECT * FROM fields_meta_data WHERE $where deleted = 0";

        $result = $GLOBALS['db']->query ( $query );
        require_once ('modules/DynamicFields/FieldCases.php');

        // retrieve the field definition from the fields_meta_data table
        // using 'encode'=false to fetchByAssoc to prevent any pre-formatting of the base metadata
        // for immediate use in HTML. This metadata will be further massaged by get_field_def() and so should not be pre-formatted
        while ( $row = $GLOBALS['db']->fetchByAssoc ( $result, false ) ) {
            $field = get_widget ( $row ['type'] );

            foreach ( $row as $key => $value ) {
                $field->$key = $value;
            }
            $field->default = $field->default_value;
            $vardef = $field->get_field_def ();
            $vardef ['id'] = $row ['id'];
            $vardef ['custom_module'] = $row ['custom_module'];
            if (empty ( $vardef ['source'] ))
                $vardef ['source'] = 'custom_fields';
            if (empty ( $results [$row ['custom_module']] ))
                $results [$row ['custom_module']] = array ( );
            $results [$row ['custom_module']] [$row ['name']] = $vardef;
        }
        if (empty ( $module )) {
            foreach ( $results as $module => $result ) {
                $this->saveToVardef ( $module, $result, $saveCache);
            }
        } else {
            if (! empty ( $results [$module] )) {
                $this->saveToVardef ( $module, $results [$module], $saveCache);
            }else{
                $this->saveToVardef ( $module, false, $saveCache);
            }
        }

        return true;

    }

    /**
    * Returns the widget for a custom field from the fields_meta_data table.
    */
    function getFieldWidget($module, $fieldName) {
        if (empty($module) || empty($fieldName)){
            sugar_die("Unable to load widget for '$module' : '$fieldName'");
        }
        $query = "SELECT * FROM fields_meta_data WHERE custom_module='$module' AND name='$fieldName' AND deleted = 0";
        $result = $GLOBALS['db']->query ( $query );
        require_once ('modules/DynamicFields/FieldCases.php');
        if ( $row = $GLOBALS['db']->fetchByAssoc ( $result ) ) {
            $field = get_widget ( $row ['type'] );
            $field->populateFromRow($row);
            return $field;
        }
    }


    /**
    * Updates the cached vardefs with the custom field information stored in result
    *
    * @param string $module
    * @param array $result
    * @param boolean saveCache Boolean value indicating whether or not to call VardefManager::saveCache, defaults to true
    */
    function saveToVardef($module,$result,$saveCache=true) {


        global $beanList;
        if (! empty ( $beanList [$module] )) {
            $object = BeanFactory::getObjectName($module);

            if(empty($GLOBALS['dictionary'][$object]['fields'])){
                //if the vardef isn't loaded let's try loading it.
                VardefManager::refreshVardefs($module,$object, null, false);
                //if it's still not loaded we really don't have anything useful to cache
                if(empty($GLOBALS['dictionary'][$object]['fields']))return;
            }
            if (!isset($GLOBALS['dictionary'][$object]['custom_fields'])) {
                $GLOBALS['dictionary'][$object]['custom_fields'] = false;
            }
            if (! empty ( $GLOBALS ['dictionary'] [$object] )) {
                if (! empty ( $result )) {
                    // First loop to add

                foreach ( $result as $field ) {
                    foreach($field as $k=>$v){
                        //allows values for custom fields to be defined outside of the scope of studio
                        if(!isset($GLOBALS ['dictionary'] [$object] ['fields'] [$field ['name']][$k])){
                            $GLOBALS ['dictionary'] [$object] ['fields'] [$field ['name']][$k] = $v;
                        }
                    }
                }

                    // Second loop to remove
                    foreach ( $GLOBALS ['dictionary'] [$object] ['fields'] as $name => $fieldDef ) {

                        if (isset ( $fieldDef ['custom_module'] )) {
                            if (! isset ( $result [$name] )) {
                                unset ( $GLOBALS ['dictionary'] [$object] ['fields'] [$name] );
                            } else {
                                $GLOBALS ['dictionary'] [$object] ['custom_fields'] = true;
                            }
                        }

                    } //if
                }
            }

            $manager = new VardefManager();
            if($saveCache)
            {
                $manager->saveCache ($this->module, $object);
            }

            // Everything works off of vardefs, so let's have it save the users vardefs
            // to the employees module, because they both use the same table behind
            // the scenes
            if ($module == 'Users')
            {
                $manager->loadVardef('Employees', 'Employee', true);
                return;
            }

        }
    }

    /**
    * returns either false or an array containing the select and join parameter for a query using custom fields
    * @param $expandedList boolean	If true, return a list of all fields with source=custom_fields in the select instead of the standard _cstm.*
    *     This is required for any downstream construction of a SQL statement where we need to manipulate the select list,
    *     for example, listviews with custom relate fields where the value comes from join rather than from the custom table
    *
    * @return array select=>select columns, join=>prebuilt join statement
    */
  function getJOIN( $expandedList = false , $includeRelates = false, &$where = false){
        if(!$this->bean->hasCustomFields()){
            return array(
                'select' => '',
                'join' => ''
            );
        }

        if (empty($expandedList) )
        {
            $select = ",{$this->bean->table_name}_cstm.*" ;
        }
        else
        {
            $select = '';
            $isList = is_array($expandedList);
            foreach($this->bean->field_defs as $name=>$field)
            {
                if (!empty($field['source']) && $field['source'] == 'custom_fields' && (!$isList || !empty($expandedList[$name]))){
                    // assumption: that the column name in _cstm is the same as the field name. Currently true.
                    // however, two types of dynamic fields do not have columns in the custom table - html fields (they're readonly) and flex relates (parent_name doesn't exist)
                    if ( $field['type'] != 'html' && $name != 'parent_name')
                        $select .= ",{$this->bean->table_name}_cstm.{$name}" ;
                }
            }
        }
        $join = " LEFT JOIN " .$this->bean->table_name. "_cstm ON " .$this->bean->table_name. ".id = ". $this->bean->table_name. "_cstm.id_c ";

        if ($includeRelates) {
            $jtAlias = "relJoin";
            $jtCount = 1;
            foreach($this->bean->field_defs as $name=>$field)
            {
                if ($field['type'] == 'relate' && isset($field['custom_module'])) {
                    $relateJoinInfo = $this->getRelateJoin($field, $jtAlias.$jtCount);
                    $select .= $relateJoinInfo['select'];
                    $join .= $relateJoinInfo['from'];
                    //bug 27654 martin
                    if ($where)
                    {
                        $pattern = '/'.$field['name'].'\slike/i';
                        $replacement = $relateJoinInfo['name_field'].' like';
                        $where = preg_replace($pattern,$replacement,$where);
                    }
                    $jtCount++;
                }
            }
        }

        return array('select'=>$select, 'join'=>$join);

    }

   function getRelateJoin($field_def, $joinTableAlias, $withIdName = true) {
        if (empty($field_def['type']) || $field_def['type'] != "relate") {
            return false;
        }
        global $beanFiles, $beanList, $module;
        $rel_module = $field_def['module'];
        if(empty($beanFiles[$beanList[$rel_module]])) {
            return false;
        }

        require_once($beanFiles[$beanList[$rel_module]]);
        $rel_mod = new $beanList[$rel_module]();
        $rel_table = $rel_mod->table_name;
        if (isset($rel_mod->field_defs['name']))
        {
            $name_field_def = $rel_mod->field_defs['name'];
            if(isset($name_field_def['db_concat_fields']))
            {
                $name_field = db_concat($joinTableAlias, $name_field_def['db_concat_fields']);
            }
            //If the name field is non-db, we need to find another field to display
            else if(!empty($rel_mod->field_defs['name']['source']) && $rel_mod->field_defs['name']['source'] == "non-db" && !empty($field_def['rname']))
            {
                $name_field = "$joinTableAlias." . $field_def['rname'];
            }
            else
            {
                $name_field = "$joinTableAlias.name";
            }
        }
        $tableName = isset($field_def['custom_module']) ? "{$this->bean->table_name}_cstm" : $this->bean->table_name ;
        $relID = $field_def['id_name'];
        $ret_array['rel_table'] = $rel_table;
        $ret_array['name_field'] = $name_field;
        $ret_array['select'] = ($withIdName ? ", {$tableName}.{$relID}" : "") . ", {$name_field} {$field_def['name']} ";
        $ret_array['from'] = " LEFT JOIN $rel_table $joinTableAlias ON $tableName.$relID = $joinTableAlias.id"
                            . " AND $joinTableAlias.deleted=0 ";
        return $ret_array;
   }

   /**
    * Fills in all the custom fields of type relate relationships for an object
    *
    */
   function fill_relationships(){
        global $beanList, $beanFiles;
        if(!empty($this->bean->relDepth)) {
            if($this->bean->relDepth > 1)return;
        }else{
            $this->bean->relDepth = 0;
        }
        foreach($this->bean->field_defs as $field){
            if(empty($field['source']) || $field['source'] != 'custom_fields')continue;
            if($field['type'] == 'relate'){
                $related_module =$field['ext2'];
                $name = $field['name'];
                if (empty($this->bean->$name)) { //Don't load the relationship twice
                    $id_name = $field['id_name'];
                    if(isset($beanList[ $related_module])){
                        $class = $beanList[$related_module];

                        if(file_exists($beanFiles[$class]) && isset($this->bean->$name)){
                            require_once($beanFiles[$class]);
                            $mod = new $class();
                            $mod->relDepth = $this->bean->relDepth + 1;
                            $mod->retrieve($this->bean->$id_name);
                            $this->bean->$name = $mod->name;
                        }
                    }
                }
            }
        }
    }

    /**
     * Process the save action for sugar bean custom fields
     *
     * @param boolean $isUpdate
     */
     function save($isUpdate){

        if($this->bean->hasCustomFields() && isset($this->bean->id)){

            if($isUpdate){
                $query = "UPDATE ". $this->bean->table_name. "_cstm SET ";
            }
            $queryInsert = "INSERT INTO ". $this->bean->table_name. "_cstm (id_c";
            $values = "('".$this->bean->id."'";
            $first = true;
            foreach($this->bean->field_defs as $name=>$field){

                if(empty($field['source']) || $field['source'] != 'custom_fields')continue;
                if($field['type'] == 'html' || $field['type'] == 'parent')continue;
                if(isset($this->bean->$name)){
                    $quote = "'";

                    if(in_array($field['type'], array('int', 'float', 'double', 'uint', 'ulong', 'long', 'short', 'tinyint', 'currency', 'decimal'))) {
                        $quote = '';
                        if(!isset($this->bean->$name) || !is_numeric($this->bean->$name) ){
                            if($field['required']){
                                $this->bean->$name = 0;
                            }else{
                                $this->bean->$name = 'NULL';
                            }
                        }
                    }
                    if ( $field['type'] == 'bool' ) {
                        if ( $this->bean->$name === FALSE )
                            $this->bean->$name = '0';
                        elseif ( $this->bean->$name === TRUE )
                            $this->bean->$name = '1';
                    }

                    $val = $this->bean->$name;
					if(($field['type'] == 'date' || $field['type'] == 'datetimecombo') && (empty($this->bean->$name )|| $this->bean->$name == '1900-01-01')){
                    	$quote = '';
                        $val = 'NULL';
                        $this->bean->$name = ''; // do not set it to string 'NULL'
                    }
                    if($isUpdate){
                        if($first){
                            $query .= " $name=$quote".$GLOBALS['db']->quote($val)."$quote";

                        }else{
                            $query .= " ,$name=$quote".$GLOBALS['db']->quote($val)."$quote";
                        }
                    }
                    $first = false;
                    $queryInsert .= " ,$name";
                    $values .= " ,$quote". $GLOBALS['db']->quote($val). "$quote";
                }
            }
            if($isUpdate){
                $query.= " WHERE id_c='" . $this->bean->id ."'";

            }

            $queryInsert .= " ) VALUES $values )";

            if(!$first){
                if(!$isUpdate){
                    $GLOBALS['db']->query($queryInsert);
                }else{
                    $checkquery = "SELECT id_c FROM {$this->bean->table_name}_cstm WHERE id_c = '{$this->bean->id}'";
                    if ( $GLOBALS['db']->getOne($checkquery) ) {
                        $result = $GLOBALS['db']->query($query);
                    } else {
                        $GLOBALS['db']->query($queryInsert);
                    }
                }
            }
        }

    }
    /**
     * Deletes the field from fields_meta_data and drops the database column then it rebuilds the cache
     * Use the widgets get_db_modify_alter_table() method to get the table sql - some widgets do not need any custom table modifications
     * @param STRING $name - field name
     */
    function deleteField($widget){
        require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
        global $beanList;
        if (!($widget instanceof TemplateField)) {
            $field_name = $widget;
            $widget = new TemplateField();
            $widget->name = $field_name;
        }
        $object_name = $beanList[$this->module];

        //Some modules like cases have a bean name that doesn't match the object name
        if (empty($GLOBALS['dictionary'][$object_name])) {
            $newName = BeanFactory::getObjectName($this->module);
            $object_name = $newName != false ? $newName : $object_name;
        }

        $GLOBALS['db']->query("DELETE FROM fields_meta_data WHERE id='" . $this->module . $widget->name . "'");
        $sql = $widget->get_db_delete_alter_table( $this->bean->table_name . "_cstm" ) ;
        if (! empty( $sql ) )
            $GLOBALS['db']->query( $sql );

        $this->removeVardefExtension($widget);
        VardefManager::clearVardef();
        VardefManager::refreshVardefs($this->module, $object_name);

    }

    /*
     * Method required by the TemplateRelatedTextField->save() method
     * Taken from MBModule's implementation
     */
    function fieldExists($name = '', $type = ''){
        // must get the vardefs from the GLOBAL array as $bean->field_defs does not contain the values from the cache at this point
        // TODO: fix this - saveToVardefs() updates GLOBAL['dictionary'] correctly, obtaining its information directly from the fields_meta_data table via buildCache()...
        $name = $this->getDBName($name);
        $vardefs = $GLOBALS['dictionary'][$this->bean->object_name]['fields'];
        if(!empty($vardefs)){
            if(empty($type) && empty($name))
                return false;
            else if(empty($type))
                return !empty($vardefs[$name]);
            else if(empty($name)){
                foreach($vardefs as $def){
                    if(!empty($def['type']) && $def['type'] == $type)
                        return true;
                }
                return false;
            }else
                return (!empty($vardefs[$name]) && ($vardefs[$name]['type'] == $type));
        }else{
            return false;
        }
    }


    /**
     * Adds a custom field using a field object
     *
     * @param Field Object $field
     * @return boolean
     */
    function addFieldObject(&$field){
        $GLOBALS['log']->debug('adding field');
        $object_name = $this->module;
        $db_name = $field->name;

        $fmd = new FieldsMetaData();
        $id =  $fmd->retrieve($object_name.$db_name,true, false);
        $is_update = false;
        $label = strtoupper( $field->label );
        if(!empty($id)){
            $is_update = true;
        }else{
            $db_name = $this->getDBName($field->name);
            $field->name = $db_name;
        }
        $this->createCustomTable();
        $fmd->id = $object_name.$db_name;
        $fmd->custom_module= $object_name;
        $fmd->name = $db_name;
        $fmd->vname = $label;
        $fmd->type = $field->type;
        $fmd->help = $field->help;
        if (!empty($field->len))
            $fmd->len = $field->len; // tyoung bug 15407 - was being set to $field->size so changes weren't being saved
        $fmd->required = ($field->required ? 1 : 0);
        $fmd->default_value = $field->default;
        $fmd->ext1 = $field->ext1;
        $fmd->ext2 = $field->ext2;
        $fmd->ext3 = $field->ext3;
        $fmd->ext4 = (isset($field->ext4) ? $field->ext4 : '');
        $fmd->comments = $field->comment;
        $fmd->massupdate = $field->massupdate;
        $fmd->importable = ( isset ( $field->importable ) ) ? $field->importable : null ;
        $fmd->duplicate_merge = $field->duplicate_merge;
        $fmd->audited =$field->audited;
        $fmd->inline_edit = $field->inline_edit;
        $fmd->reportable = ($field->reportable ? 1 : 0);
        if(!$is_update){
            $fmd->new_with_id=true;
        }
        if($field){
            if(!$is_update){
                //Do two SQL calls here in this case
            	//The first is to create the column in the custom table without the default value
            	//The second is to modify the column created in the custom table to set the default value
            	//We do this so that the existing entries in the custom table don't have the default value set
            	$field->default = '';
            	$field->default_value = '';
                // resetting default and default_value does not work for multienum and causes trouble for mssql
                // so using a temporary variable here to indicate that we don't want default for this query
                $field->no_default = 1;
                $query = $field->get_db_add_alter_table($this->bean->table_name . '_cstm');
                // unsetting temporary member variable
                unset($field->no_default);
                if(!empty($query)){
                	$GLOBALS['db']->query($query, true, "Cannot create column");
	                $field->default = $fmd->default_value;
	                $field->default_value = $fmd->default_value;
	                $query = $field->get_db_modify_alter_table($this->bean->table_name . '_cstm');
	                if(!empty($query)){
	                	$GLOBALS['db']->query($query, true, "Cannot set default");
	            	}
                }
            }else{
                $query = $field->get_db_modify_alter_table($this->bean->table_name . '_cstm');
                if(!empty($query)){
                	$GLOBALS['db']->query($query, true, "Cannot modify field");
            	}
            }
            $fmd->save();
            $this->buildCache($this->module);
            $this->saveExtendedAttributes($field, array_keys($fmd->field_defs));
        }

        return true;
    }

    function saveExtendedAttributes($field, $column_fields)
    {
            require_once ('modules/ModuleBuilder/parsers/StandardField.php') ;
            require_once ('modules/DynamicFields/FieldCases.php') ;
            global $beanList;

            $to_save = array();
            $base_field = get_widget ( $field->type) ;
        foreach ($field->vardef_map as $property => $fmd_col){
            //Skip over attribes that are either the default or part of the normal attributes stored in the DB
            if (!isset($field->$property) || in_array($fmd_col, $column_fields) || in_array($property, $column_fields)
                || $this->isDefaultValue($property, $field->$property, $base_field)
                || $property == "action" || $property == "label_value" || $property == "label"
                || (substr($property, 0,3) == 'ext' && strlen($property) == 4))
            {
                continue;
            }
            $to_save[$property] =
                is_string($field->$property) ? htmlspecialchars_decode($field->$property, ENT_QUOTES) : $field->$property;
        }
        $bean_name = $beanList[$this->module];

        $this->writeVardefExtension($bean_name, $field, $to_save);
    }

    protected function isDefaultValue($property, $value, $baseField)
    {
        switch ($property) {
            case "importable":
                return ( $value === 'true' || $value === '1' || $value === true || $value === 1 ); break;
            case "required":
            case "audited":
            case "inline_edit":
            case "massupdate":
                return ( $value === 'false' || $value === '0' || $value === false || $value === 0); break;
            case "default_value":
            case "default":
            case "help":
            case "comments":
                return ($value == "");
            case "duplicate_merge":
                return ( $value === 'false' || $value === '0' || $value === false || $value === 0 || $value === "disabled"); break;
        }

        if (isset($baseField->$property))
        {
            return $baseField->$property == $value;
        }

        return false;
    }

    protected function writeVardefExtension($bean_name, $field, $def_override)
    {
        //Hack for the broken cases module
        $vBean = $bean_name == "aCase" ? "Case" : $bean_name;
        $file_loc = "$this->base_path/sugarfield_{$field->name}.php";

        $out =  "<?php\n // created: " . date('Y-m-d H:i:s') . "\n";
        foreach ($def_override as $property => $val)
        {
            $out .= override_value_to_string_recursive(array($vBean, "fields", $field->name, $property), "dictionary", $val) . "\n";
        }

        $out .= "\n ?>";

        if (!file_exists($this->base_path))
            mkdir_recursive($this->base_path);

        if( $fh = @sugar_fopen( $file_loc, 'w' ) )
        {
            fputs( $fh, $out);
            fclose( $fh );
            return true ;
        }
        else
        {
            return false ;
        }
    }

    protected function removeVardefExtension($field)
    {
        $file_loc = "$this->base_path/sugarfield_{$field->name}.php";

        if (is_file($file_loc))
        {
            unlink($file_loc);
        }
    }


    /**
     * DEPRECIATED: Use addFieldObject instead.
     * Adds a Custom Field using parameters
     *
     * @param unknown_type $name
     * @param unknown_type $label
     * @param unknown_type $type
     * @param unknown_type $max_size
     * @param unknown_type $required_option
     * @param unknown_type $default_value
     * @param unknown_type $ext1
     * @param unknown_type $ext2
     * @param unknown_type $ext3
     * @param unknown_type $audited
     * @param unknown_type $inline_edit
     * @param unknown_type $mass_update
     * @param unknown_type $ext4
     * @param unknown_type $help
     * @param unknown_type $duplicate_merge
     * @param unknown_type $comment
     * @return boolean
     */
    function addField($name,$label='', $type='Text',$max_size='255',$required_option='optional', $default_value='', $ext1='', $ext2='', $ext3='',$audited=0, $inline_edit = 1, $mass_update = 0 , $ext4='', $help='',$duplicate_merge=0, $comment=''){
        require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
        $field = new TemplateField();
        $field->label = $label;
        if(empty($field->label)){
            $field->label = $name;
        }
        $field->name = $name;
        $field->type = $type;
        $field->len = $max_size;
        $field->required = (!empty($required_option) && $required_option != 'optional');
        $field->default = $default_value;
        $field->ext1 = $ext1;
        $field->ext2 = $ext2;
        $field->ext3 = $ext3;
        $field->ext4 = $ext4;
        $field->help = $help;
        $field->comments = $comment;
        $field->massupdate = $mass_update;
        $field->duplicate_merge = $duplicate_merge;
        $field->audited = $audited;
        $field->inline_edit = $inline_edit;
        $field->reportable = 1;
        return $this->addFieldObject($field);
    }

    /**
     * Creates the custom table with an id of id_c
     *
     */
    function createCustomTable($execute = true){
        $out = "";
        if (!$GLOBALS['db']->tableExists($this->bean->table_name."_cstm")) {
            $GLOBALS['log']->debug('creating custom table for '. $this->bean->table_name);
            $iddef = array(
                "id_c" => array(
                    "name" => "id_c",
                    "type" => "id",
                    "required" => 1,
                )
            );
            $ididx = array(
       			'id'=>array(
       				'name' =>$this->bean->table_name."_cstm_pk",
       				'type' =>'primary',
       				'fields'=>array('id_c')
                ),
           );

            $query = $GLOBALS['db']->createTableSQLParams($this->bean->table_name."_cstm", $iddef, $ididx);
            if(!$GLOBALS['db']->supports("inline_keys")) {
                $indicesArr = $GLOBALS['db']->getConstraintSql($ididx, $this->bean->table_name."_cstm");
            } else {
                $indicesArr = array();
            }
            if($execute) {
                $GLOBALS['db']->query($query);
                if(!empty($indicesArr)) {
                    foreach($indicesArr as $idxq) {
                        $GLOBALS['db']->query($idxq);
                    }
                }
            }
            $out = $query . "\n";
            if(!empty($indicesArr)) {
                $out .= join("\n", $indicesArr)."\n";
            }

            $out .= $this->add_existing_custom_fields($execute);
        }

        return $out;
    }

    /**
     * Updates the db schema and adds any custom fields we have used if the custom table was dropped
     *
     */
    function add_existing_custom_fields($execute = true){
    	$out = "";
        if($this->bean->hasCustomFields()){
	        foreach($this->bean->field_defs as $name=>$data){
	        	if(empty($data['source']) || $data['source'] != 'custom_fields')
                    continue;
	            $out .= $this->add_existing_custom_field($data, $execute);
	        }
    	}
        return $out;
    }

    function add_existing_custom_field($data, $execute = true)
    {

        $field = get_widget ( $data ['type'] );
        $field->populateFromRow($data);
        $query = "/*MISSING IN DATABASE - {$data['name']} -  ROW*/\n"
                . $field->get_db_add_alter_table($this->bean->table_name . '_cstm');
        $out = $query . "\n";
        if ($execute)
            $GLOBALS['db']->query($query);

        return $out;
    }

    public function repairCustomFields($execute = true)
    {
        $out = $this->createCustomTable($execute);
        //If the table didn't exist, createCustomTable will have returned all the SQL to create and populate it
        if (!empty($out))
            return "/*Checking Custom Fields for module : {$this->module} */\n$out";
        //Otherwise make sure all the custom fields defined in the vardefs exist in the custom table.
        //We aren't checking for data types, just that the column exists.
        $db = $GLOBALS['db'];
        $tablename = $this->bean->table_name."_cstm";
        $compareFieldDefs = $db->get_columns($tablename);
        foreach($this->bean->field_defs as $name=>$data){
            if(empty($data['source']) || $data['source'] != 'custom_fields')
                continue;
            /**
             * @bug 43471
             * @issue 43471
             * @itr 23441
             *
             * force the name to be lower as it needs to be lower since that is how it's put into the key
             * in the get_columns() call above.
             */
            if(!empty($compareFieldDefs[strtolower($name)])) {
                continue;
            }
            $out .= $this->add_existing_custom_field($data, $execute);
        }
        if (!empty($out))
            $out = "/*Checking Custom Fields for module : {$this->module} */\n$out";

        return $out;
    }

    /**
     * Adds a label to the module's mod_strings for the current language
     * Note that the system label name
     *
     * @param string $displayLabel The label value to be displayed
     * @return string The core of the system label name - returns currency_id5 for example, when the full label would then be LBL_CURRENCY_ID5
     * TODO: Only the core is returned for historical reasons - switch to return the real system label
     */
    function addLabel ( $displayLabel )
    {
        $mod_strings = return_module_language($GLOBALS[ 'current_language' ], $this->module);
        $limit = 10;
        $count = 0;
        $field_key = $this->getDBName($displayLabel, false);
        $systemLabel = $field_key;
        if(!$this->use_existing_labels){ // use_existing_labels defaults to false in this module; as of today, only set to true by ModuleInstaller.php
            while( isset( $mod_strings [ $systemLabel ] ) && $count <= $limit )
            {
                $systemLabel = $field_key. "_$count";
                $count++;
            }
        }
        $selMod = (!empty($_REQUEST['view_module'])) ? $_REQUEST['view_module'] : $this->module;
        require_once 'modules/ModuleBuilder/parsers/parser.label.php' ;
        $parser = new ParserLabel ( $selMod , isset ( $_REQUEST [ 'view_package' ] ) ? $_REQUEST [ 'view_package' ] : null ) ;
        $parser->handleSave ( array('label_'. $systemLabel => $displayLabel ) , $GLOBALS [ 'current_language' ] ) ;

        return $systemLabel;
    }

    /**
     * Returns a Database Safe Name
     *
     * @param STRING $name
     * @param BOOLEAN $_C do we append _c to the name
     * @return STRING
     */
    function getDBName($name, $_C= true){
        static $cached_results = array();
        if(!empty($cached_results[$name]))
        {
            return $cached_results[$name];
        }
        $exclusions = array('parent_type', 'parent_id', 'currency_id', 'parent_name');
        // Remove any non-db friendly characters
        $return_value = preg_replace("/[^\w]+/","_",$name);
        if($_C == true && !in_array($return_value, $exclusions) && substr($return_value, -2) != '_c'){
            $return_value .= '_c';
        }
        $cached_results[$name] = $return_value;
        return $return_value;
    }

    function setWhereClauses(&$where_clauses){
        if (isset($this->avail_fields)) {
            foreach($this->avail_fields as $name=>$value){
                if(!empty($_REQUEST[$name])){
                    $where_clauses[] = $this->bean->table_name . "_cstm.$name LIKE '". $GLOBALS['db']->quote($_REQUEST[$name]). "%'";
                }
            }
        }

    }

    /////////////////////////BACKWARDS COMPATABILITY MODE FOR PRE 5.0 MODULES\\\\\\\\\\\\\\\\\\\\\\\\\\\
    ////////////////////////////END BACKWARDS COMPATABILITY MODE FOR PRE 5.0 MODULES\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    /**
     *
     * DEPRECATED
     loads fields into the bean
     This used to be called during the retrieve process now it is done through a join
     Restored from pre-r30895 to maintain support for custom code that may have called retrieve() directly
     */

    function retrieve()
    {
        if(!isset($this->bean)){
            $GLOBALS['log']->fatal("DynamicField retrieve, bean not instantiated: ".var_export(debug_print_backtrace(), true));
            return false;
        }

        if(!$this->bean->hasCustomFields()){
            return false;
        }

        $query = "SELECT * FROM ".$this->bean->table_name."_cstm WHERE id_c='".$this->bean->id."'";
        $result = $GLOBALS['db']->query($query);
        $row = $GLOBALS['db']->fetchByAssoc($result);

        if($row)
        {
            foreach($row as $name=>$value)
            {
                // originally in pre-r30895 we checked if this field was in avail_fields i.e., in fields_meta_data and not deleted
                // with the removal of avail_fields post-r30895 we have simplified this - we now retrieve every custom field even if previously deleted
                // this is considered harmless as the value although set in the bean will not otherwise be used (nothing else works off the list of fields in the bean)
                $this->bean->$name = $value;
            }
        }

    }

   function populateXTPL($xtpl, $view) {

        if($this->bean->hasCustomFields()){
            $results = $this->getAllFieldsView($view, 'xtpl');
            foreach($results as $name=>$value){
                if(is_array($value['xtpl']))
                {
                    foreach($value['xtpl'] as $xName=>$xValue)
                    {
                        $xtpl->assign(strtoupper($xName), $xValue);
                    }
                } else {
                    $xtpl->assign(strtoupper($name), $value['xtpl']);
                }
            }
        }

    }

    function populateAllXTPL($xtpl, $view){
        $this->populateXTPL($xtpl, $view);

    }

    function getAllFieldsView($view, $type){
         require_once ('modules/DynamicFields/FieldCases.php');
         $results = array();
         foreach($this->bean->field_defs as $name=>$data){
            if(empty($data['source']) || $data['source'] != 'custom_fields')
            {
            	continue;
            }
            $field = get_widget ( $data ['type'] );
            $field->populateFromRow($data);
            $field->view = $view;
            $field->bean = $this->bean;
            switch(strtolower($type))
            {
                case 'xtpl':
                    $results[$name] = array('xtpl'=>$field->get_xtpl());
                    break;
                case 'html':
                    $results[$name] = array('html'=> $field->get_html(), 'label'=> $field->get_html_label(), 'fieldType'=>$field->data_type, 'isCustom' =>true);
                    break;
            }

        }
        return $results;
    }

    ////////////////////////////END BACKWARDS COMPATABILITY MODE FOR PRE 5.0 MODULES\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
}

?>
