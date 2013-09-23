<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewGeocoding_Test extends SugarView {

 	function Jjwg_MapsViewGeocoding_Test() {
 		parent::SugarView();
 	}

	function display() {
		
        global $sugar_config;
        global $currentModule;
        global $theme;
        global $mod_strings;
        global $geocoding_results;
        if (!isset($_REQUEST['geocoding_address'])) $_REQUEST['geocoding_address'] = '';
?>

<div class="moduleTitle"><h2><?php echo $mod_strings['LBL_MAP_ADDRESS_TEST']; ?></h2><div class="clear"></div></div>
<div class="clear"></div>

<form name=geocodingtest action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<input type="hidden" name="module" value="<?php echo $currentModule; ?>">
<input type="hidden" name="action" value="geocoding_test" />
<strong><?php echo $mod_strings['LBL_MAP_ADDRESS'].': '; ?> </strong>
<input autocomplete="off" type="text" name="geocoding_address" id="geocoding_address" 
value="<?php echo htmlspecialchars($_REQUEST['geocoding_address']); ?>" title='' tabindex='1' size="40" maxlength="255">
<br /><br />
<input class="button" type="submit" name="submit" value="<?php echo $mod_strings['LBL_MAP_PROCESS']; ?>" align="bottom">
<input type="hidden" name="process_trigger" value="yes">
</form>

<?php
    if (!empty($_REQUEST['process_trigger'])) { 
    
      echo '<br /><br /><pre>';
      print_r($geocoding_results);
      echo '</pre><br /><br />';
    
    }

  }
}

?>