<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

if(!is_admin($GLOBALS['current_user']) ) sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);

?>
<p>
<table class="other view">
<tr>
	<td scope="row"><?php echo SugarThemeRegistry::current()->getImage('Repair','align="absmiddle" border="0"',null,null,'.gif',$mod_strings['LBL_RESCHEDULE_REBUILD']); ?>&nbsp;<a href="./index.php?module=Administration&action=Reschedule_repair"><?php echo $mod_strings['LBL_RESCHEDULE_REBUILD']; ?></a></td>
	<td> <?php echo $mod_strings['LBL_RESCHEDULE_REBUILD_DESC'] ; ?> </td>
</tr>
</table></p>
