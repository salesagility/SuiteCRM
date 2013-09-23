<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

if(!is_admin($GLOBALS['current_user']) ) sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);

	require_once('modules/Administration/Administration.php');
	require_once('include/utils/array_utils.php');
	require_once('include/utils/file_utils.php');
	require_once('include/utils/sugar_file_utils.php');

	$modules_array = array('Calls');
	
	foreach($modules_array as $module){
		
		if(isset($viewdefs)) unset($viewdefs);

		$file = "custom/modules/$module/metadata/detailviewdefs.php";
		
		if(file_exists($file)){
			include($file);
		
		}else{
			create_custom_directory("modules/$module/metadata/detailviewdefs.php");
			include("modules/$module/metadata/detailviewdefs.php");		
		}


		if(isset($viewdefs["$module"]['DetailView']['templateMeta']['form']['buttons']['SA_RESCHEDULE'])) unset($viewdefs["$module"]['DetailView']['templateMeta']['form']['buttons']['SA_RESCHEDULE']);
		
		$viewdefs["$module"]['DetailView']['templateMeta']['form']['buttons']['SA_RESCHEDULE'] =  array (
            'customCode' => '{if $fields.status.value != "Held"} <input title="Reschedule" class="button" onclick="get_form();" name="Reschedule" id="reschedule_button" value="Reschedule" type="button">{/if}');

		$viewdefs["$module"]['DetailView']['templateMeta']['includes']['SA_RESCHEDULE']['file'] = 'modules/Calls_Reschedule/reschedule_form.js';
		
		ksort($viewdefs);
		write_array_to_file('viewdefs', $viewdefs, $file);

	}
	

/** add following:
	$entry_point_registry['Reschedule'] = array('file' => 'modules/Calls_Reschedule/Reschedule_popup.php' , 'auth' => '1');
	$entry_point_registry['Reschedule2'] = array('file' => 'custom/modules/Calls/Reschedule.php' , 'auth' => '1');
	*/

    $add_entry_point = false;
    $new_contents = "";
    $entry_point_registry = null;
    if(file_exists("custom/include/MVC/Controller/entry_point_registry.php")){

        // This will load an array of the hooks to process
        include("custom/include/MVC/Controller/entry_point_registry.php");

        
        if(!isset($entry_point_registry['Reschedule'])) {
            $add_entry_point = true;
            $entry_point_registry['Reschedule'] = array('file' => 'modules/Calls_Reschedule/Reschedule_popup.php' , 'auth' => '1');
        }
        if(!isset($entry_point_registry['Reschedule2'])) {
            $add_entry_point = true;
            $entry_point_registry['Reschedule2'] = array('file' => 'custom/modules/Calls/Reschedule.php' , 'auth' => '1');
        }
    } else {
        $add_entry_point = true;    
        $entry_point_registry['Reschedule'] = array('file' => 'modules/Calls_Reschedule/Reschedule_popup.php' , 'auth' => '1');
		$entry_point_registry['Reschedule2'] = array('file' => 'custom/modules/Calls/Reschedule.php' , 'auth' => '1');
    }
    if($add_entry_point == true){

        foreach($entry_point_registry as $entryPoint => $epArray){
            $new_contents .= "\$entry_point_registry['".$entryPoint."'] = array('file' => '".$epArray['file']."' , 'auth' => '".$epArray['auth']."'); \n";
        }
        
        $new_contents = "<?php\n$new_contents\n?>";
        $file = 'custom/include/MVC/Controller/entry_point_registry.php';
        $paths = explode('/',$file);
        $dir = '';
        for($i = 0; $i < sizeof($paths) - 1; $i++)
        {
            if($i > 0) $dir .= '/';
            $dir .= $paths[$i];
            if(!file_exists($dir))
            {
                sugar_mkdir($dir, 0755);
            }
        }
        $fp = sugar_fopen($file, 'wb');
        fwrite($fp,$new_contents);
        fclose($fp);
    }


echo "<h3>{$mod_strings['LBL_REPAIR_RESCHEDULE_DONE']}</h3>";

?>

