<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewGeocoding_Test extends SugarView {

 	function __construct() {
 		parent::__construct();
 	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function Jjwg_MapsViewGeocoding_Test(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


	function display() {

        if (!isset($_REQUEST['geocoding_address'])) $_REQUEST['geocoding_address'] = '';
?>

<div class="moduleTitle"><h2><?php echo $GLOBALS['mod_strings']['LBL_MAP_ADDRESS_TEST']; ?></h2><div class="clear"></div></div>
<div class="clear"></div>

<form name=geocodingtest action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<input type="hidden" name="module" value="<?php echo $GLOBALS['currentModule']; ?>">
<input type="hidden" name="action" value="geocoding_test" />
<strong><?php echo $GLOBALS['mod_strings']['LBL_MAP_ADDRESS'].': '; ?> </strong>
<input autocomplete="off" type="text" name="geocoding_address" id="geocoding_address"
value="<?php echo htmlspecialchars($_REQUEST['geocoding_address']); ?>" title='' tabindex='1' size="40" maxlength="255">
<br /><br />
<input class="button" type="submit" name="submit" value="<?php echo $GLOBALS['mod_strings']['LBL_MAP_PROCESS']; ?>" align="bottom">
<input type="hidden" name="process_trigger" value="yes">
</form>

<?php
    if (!empty($_REQUEST['process_trigger'])) {

      echo '<br /><br /><pre>';
      print_r($this->bean->geocoding_results);
      echo '</pre><br /><br />';

    }

  }
}

?>