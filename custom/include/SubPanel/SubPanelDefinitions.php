<?php
/**
 * SubPanelDefinitions.php
 * @author SalesAgility <support@salesagility.com>
 * Date: 28/01/14
 */

require_once('include/SubPanel/SubPanelDefinitions.php');

class CustomaSubPanel extends aSubPanel
{
    var $search_query;
    var $base_collection_list = array();

    function CustomaSubPanel($name , $instance_properties , $parent_bean , $reload = false , $original_only = false, $search_query = '', $collections = array() ){

        $this->_instance_properties = $instance_properties ;

        if(isset($instance_properties['collection_list' ])) $this->base_collection_list = $instance_properties['collection_list' ];

        if(!empty($collections) && isset($instance_properties['collection_list' ])){
            foreach($instance_properties['collection_list' ] as $cname => $value){
                if(!in_array($value['module'], $collections)){
                    unset($instance_properties['collection_list'][$cname]);
                }
            }
        }
        if (!$this->isCollection()){
            $table = strtolower($instance_properties['module']);
            $search_query = str_replace('meetings',$table,$search_query);
        }
        $this->search_query = $search_query;

        parent::aSubPanel($name , $instance_properties , $parent_bean , $reload , $original_only);

    }

    //returns the where clause for the query.
    function get_where ()
    {
        if($this->get_def_prop_value ( 'where' ) != '' && $this->search_query != ''){
            return $this->get_def_prop_value ( 'where' ).' AND '.$this->search_query;
        } else if($this->search_query != ''){
            return $this->search_query;
        }
        return $this->get_def_prop_value ( 'where' ) ;
    }

    /**
     * Load the Sub-Panel objects if it can from the metadata files.
     *
     * call this function for sub-panels that have unions.
     *
     * @return bool         True by default if the subpanel was loaded.  Will return false if none in the collection are
     *                      allowed by the current user.
     */
    function load_sub_subpanels ()
    {

        global $modListHeader ;
        // added a check for security of tabs to see if an user has access to them
        // this prevents passing an "unseen" tab to the query string and pulling up its contents
        if (! isset ( $modListHeader ))
        {
            global $current_user ;
            if (isset ( $current_user ))
            {
                $modListHeader = query_module_access_list ( $current_user ) ;
            }
        }

        //by default all the activities modules are exempt, so hiding them won't affect their appearance unless the 'activity' subpanel itself is hidden.
        //add email to the list temporarily so it is not affected in activities subpanel
        global $modules_exempt_from_availability_check ;
        $modules_exempt_from_availability_check['Emails'] = 'Emails';

        $listFieldMap = array();

        if (empty ( $this->sub_subpanels ))
        {
            $panels = $this->get_inst_prop_value ( 'collection_list' ) ;
            foreach ( $panels as $panel => $properties )
            {
                if (array_key_exists ( $properties [ 'module' ], $modListHeader ) or array_key_exists ( $properties [ 'module' ], $modules_exempt_from_availability_check ))
                {
                    $this->sub_subpanels [ $panel ] = new CustomaSubPanel ( $panel, $properties, $this->parent_bean, false, false, $this->search_query ) ;
                }
            }
            // if it's empty just dump out as there is nothing to process.
            if(empty($this->sub_subpanels)) return false;
            //Sync displayed list fields across the subpanels
            $display_fields = $this->getDisplayFieldsFromCollection($this->sub_subpanels);
            $query_fields = array();
            foreach ( $this->sub_subpanels as $key => $subpanel )
            {
                $list_fields = $subpanel->get_list_fields();
                $listFieldMap[$key] = array();
                $index = 0;
                foreach($list_fields as $field => $def)
                {
                    if (isset($def['vname']) && isset($def['width']))
                    {
                        $index++;
                        if(!empty($def['alias']))
                            $listFieldMap[$key][$def['alias']] = $field;
                        else
                            $listFieldMap[$key][$field] = $field;
                        if (!isset($display_fields[$def['vname']]))
                        {
                            if(sizeof($display_fields) > $index)
                            {
                                //Try to insert the new field in an order that makes sense
                                $start = array_slice($display_fields, 0, $index);
                                $end = array_slice($display_fields, $index);
                                $display_fields = array_merge(
                                    $start,
                                    array($def['vname'] => array('name' => $field, 'vname' => $def['vname'], 'width' => $def['width'] )),
                                    $end
                                );
                            } else
                            {
                                $display_fields[$def['vname']] = array(
                                    'name' => empty($def['alias']) ? $field : $def['alias'],
                                    'vname' => $def['vname'],
                                    'width' => $def['width'],
                                );
                            }
                        }
                    } else {
                        $query_fields[$field] = $def;
                    }
                }
            }
            foreach ( $this->sub_subpanels as $key => $subpanel )
            {
                $list_fields = array();
                foreach($display_fields as $vname => $def)
                {
                    $field = $def['name'];
                    $list_key = isset($listFieldMap[$key][$field]) ? $listFieldMap[$key][$field] : $field;

                    if (isset($subpanel->panel_definition['list_fields'][$field]))
                    {
                        $list_fields[$field] = $subpanel->panel_definition['list_fields'][$field];
                    }
                    else if ($list_key != $field && isset($subpanel->panel_definition['list_fields'][$list_key]))
                    {
                        $list_fields[$list_key] = $subpanel->panel_definition['list_fields'][$list_key];

                    }
                    else {
                        $list_fields[$field] = $display_fields[$vname];
                    }
                }
                foreach($query_fields as $field => $def)
                {
                    if (isset($subpanel->panel_definition['list_fields'][$field]))
                    {
                        $list_fields[$field] = $subpanel->panel_definition['list_fields'][$field];
                    }
                    else {
                        $list_fields[$field] = $def;
                    }
                }
                $subpanel->panel_definition['list_fields'] = $list_fields;
            }
        }

        return true;
    }

}

class CustomSubPanelDefinitions extends SubPanelDefinitions
{

    /**
     * Enter description here...
     *
     * @param BEAN $focus - this is the bean you want to get the data from
     * @param STRING $layout_def_key - if you wish to use a layout_def defined in the default metadata/subpaneldefs.php that is not keyed off of $bean->module_dir pass in the key here
     * @param ARRAY $layout_def_override - if you wish to override the default loaded layout defs you pass them in here.
     * @return SubPanelDefinitions
     */
    function CustomSubPanelDefinitions ( $focus , $layout_def_key = '' , $layout_def_override = '' )
    {
        parent::SubPanelDefinitions($focus , $layout_def_key, $layout_def_override);
    }

    function load_subpanel ( $name , $reload = false , $original_only = false, $search_query = '', $collections = array() )
    {
        if (!is_dir('modules/' . $this->layout_defs [ 'subpanel_setup' ][ strtolower ( $name ) ] [ 'module' ]))
            return false;

        $subpanel = new CustomaSubPanel ( $name, $this->layout_defs [ 'subpanel_setup' ] [ strtolower ( $name ) ], $this->_focus, $reload, $original_only, $search_query, $collections ) ;

        // only return the subpanel object if we can display it.
        if($subpanel->canDisplay == true) {
            return $subpanel;
        }

        // by default return false so we don't show anything if it's not required.
        return false;
    }
}