<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

 




class SugarWidgetTabs extends SugarWidget
{
 var $tabs;
 var $current_key;

 function SugarWidgetTabs(&$tabs,$current_key,$jscallback)
 {
   $this->tabs = $tabs;
   $this->current_key = $current_key;
   $this->jscallback = $jscallback;
 }

 function display()
 {
	ob_start();
?>
<script>
var keys = [ <?php 
$tabs_count = count($this->tabs);
for($i=0; $i < $tabs_count;$i++) 
{
 $tab = $this->tabs[$i];
 echo "\"".$tab['key']."\""; 
 if ($tabs_count > ($i + 1))
 {
   echo ",";
 }
}
?>]; 
tabPreviousKey = '';

function selectTabCSS(key)
{


  for( var i=0; i<keys.length;i++)
  {
   var liclass = '';
   var linkclass = '';

 if ( key == keys[i])
 {
   var liclass = 'active';
   var linkclass = 'current';
 }
  	document.getElementById('tab_li_'+keys[i]).className = liclass;

  	document.getElementById('tab_link_'+keys[i]).className = linkclass;
  }
    <?php echo $this->jscallback;?>(key, tabPreviousKey);
    tabPreviousKey = key;
}
</script>

<ul id="searchTabs" class="tablist">
<?php 
	foreach ($this->tabs as $tab)
	{
		$TITLE = $tab['title'];
		$LI_ID = "";
		$A_ID = "";

	  if ( ! empty($tab['hidden']) && $tab['hidden'] == true)
		{
			  $LI_ID = "style=\"display: none\"";
			  $A_ID = "style=\"display: none\"";

		} else if ( $this->current_key == $tab['key'])
		{
			  $LI_ID = "class=\"active\"";
			  $A_ID = "class=\"current\"";
		}

		$LINK = "<li $LI_ID id=\"tab_li_".$tab['link']."\"><a $A_ID id=\"tab_link_".$tab['link']."\" href=\"javascript:selectTabCSS('{$tab['link']}');\">$TITLE</a></li>";

?>
<?php echo $LINK; ?>	
<?php
	}
?>
</ul>
<?php 
	$ob_contents = ob_get_contents();
        ob_end_clean();
        return $ob_contents;
	}
}
?>
