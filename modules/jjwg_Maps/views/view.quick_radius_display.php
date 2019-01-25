<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class Jjwg_MapsViewQuick_Radius_Display extends SugarView
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function Jjwg_MapsViewQuick_Radius_Display()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    public function display()
    {
        $url = 'index.php?module='.$GLOBALS['currentModule'].'&action=map_markers';
        foreach (array_keys($_REQUEST) as $key) {
            // Exclude certain request parameters
            if (!in_array($key, array('action', 'module', 'entryPoint', 'record', 'relate_id'))) {
                $url .= '&'.$key.'='.urlencode($_REQUEST[$key]);
            }
        } ?>
<h2><?php echo htmlspecialchars($_REQUEST['quick_address']); ?><div class="clear"></div></h2>
<div class="clear"></div>

<iframe src="<?php echo $url; ?>"
	width="100%" height="900" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"><p>Sorry,
    your browser does not support iframes.</p></iframe>

<p>IFrame: <a href="<?php echo htmlspecialchars($url); ?>"><?php echo $mod_strings['LBL_MAP']; ?> URL</a></p>

<?php
    }
}
