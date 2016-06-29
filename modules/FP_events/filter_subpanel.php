<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
$GLOBALS['log']->debug('delegates filter subpanel');
include_once('include/SubPanel/SubPanel.php');

//$GLOBALS['sugar_config']['enable_action_menu']=false;
global $db;
if(empty($_REQUEST['module'])) {
    die("'module' was not defined");
}

if(empty($_REQUEST['record'])) {
    die("'record' was not defined");
}

$subpanel = $_REQUEST['subpanel'];
$record = $_REQUEST['record'];
$module = $_REQUEST['module'];
$layout_def_key = $_REQUEST['layout_def_key'];

if(empty($_REQUEST['inline'])) {
    insert_popup_header($theme);
}

// need to load the subpanel definition here and manipulate the 'where clause'
if ( ( $result = BeanFactory::getBean($module,$record) ) === FALSE ) {
    die("'$module' is not a valid module");
}

if (!class_exists('MyClass')) {
    require_once 'include/SubPanel/SubPanelDefinitions.php' ;
}

$panelsdef = new SubPanelDefinitions($result,$layout_def_key);
$subpanelDef = $panelsdef->load_subpanel($subpanel);

// create or append subpanel definition where clause for the filter

if (!isset($subpanelDef->panel_definition['where']) || $subpanelDef->panel_definition['where'] == '') {
    $subpanelDef->panel_definition['where'] = '';
} else {
    $subpanelDef->panel_definition['where'] .= ' AND ';
}

if (($_REQUEST['first_name'] && $_REQUEST['first_name'] != '') || ($_REQUEST['last_name'] && $_REQUEST['last_name'] != '')) {
    foreach ($subpanelDef->sub_subpanels as $key=>$value){
        $module_name = $subpanelDef->sub_subpanels[$key]->_instance_properties['module'];
        global $beanList, $beanFiles;
        $class_name = $beanList[$module_name];
        //require_once($beanFiles[$class_name]);
        $class_name = new $class_name();
        $table=$class_name->table_name;
        //run through every sub_subpanel
        
        $first_name = $db->quote($_REQUEST['first_name']);
        $last_name = $db->quote($_REQUEST['last_name']);
        
        $where = "(" . $table . ".first_name like '%" . $first_name . "%' OR " . $table . ".last_name like '%" . $last_name . "%')";
        if(!empty($subpanelDef->sub_subpanels[$key]->panel_definition['where'])){
            //some of the sub_subpanels already have a where clause, so the filter has to be added to it
            $subpanelDef->sub_subpanels[$key]->panel_definition['where'] .= " AND ";
        }
        $subpanelDef->sub_subpanels[$key]->panel_definition['where'] .= $where;

    }
}
//$GLOBALS['log']->fatal($subpanelDef->panel_definition['where']);

$subpanel_object = new SubPanel($module, $record, $subpanel,$subpanelDef, $layout_def_key);
$subpanel_object->setTemplateFile('include/SubPanel/SubPanelDynamic.html');

echo (empty($_REQUEST['inline'])) ? $subpanel_object->get_buttons() : '' ;

echo " <input type='hidden' id='data_first_name' value='{$first_name}'>";
echo " <input type='hidden' id='data_last_name' value='{$last_name}'>";
/*
        ?>
            <input type="hidden" id="data_last_name" value="<?php echo $last_name; ?>">
        <?php
*/
$subpanel_object->display();

if(empty($_REQUEST['inline'])) {
    insert_popup_footer($theme);
}