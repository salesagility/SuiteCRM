<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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

$queryString = ! empty($_REQUEST['query_string']) ? $_REQUEST['query_string'] : '';

$luceneSearch = !empty($sugar_config['aod']['enable_aod']);

if(array_key_exists('showGSDiv',$_REQUEST) || !empty($_REQUEST['search_fallback'])){
    //Search from vanilla sugar search or request for the same
    $luceneSearch = false;
}

if(!$luceneSearch){
    if(!empty($sugar_config['aod']['enable_aod'])){
        echo "<a href='index.php?action=UnifiedSearch&module=Home&query_string=".urlencode($queryString)."'>".translate("LBL_USE_AOD_SEARCH","AOD_Index")."</a>";
    }
    require_once('modules/Home/UnifiedSearchAdvanced.php');
    global $mod_strings, $modListHeader, $app_strings, $beanList, $beanFiles;
    $usa = new UnifiedSearchAdvanced();
    $usa->search();
    return;
}
require_once('include/utils.php');
echo "<a href='index.php?action=UnifiedSearch&module=Home&search_fallback=1&query_string=".urlencode($queryString)."'>".translate("LBL_USE_VANILLA_SEARCH","AOD_Index")."</a>";

$index = BeanFactory::getBean("AOD_Index")->getIndex();
$hits = array();
$start = 0;
$amount = 20;
$total = 0;
if(!empty($_REQUEST['start'])){
    $start = $_REQUEST['start'];
}
if(!empty($_REQUEST['total'])){
    $total = $_REQUEST['total'];
}
if(array_key_exists('listViewStartButton',$_REQUEST)){
    $start = 0;
}elseif(array_key_exists('listViewPrevButton',$_REQUEST)){
    $start = max($start - $amount,0);
}elseif(array_key_exists('listViewNextButton',$_REQUEST)){
    $start = min($start + $amount,$total);
}elseif(array_key_exists('listViewEndButton',$_REQUEST)){
    $start = floor($total / $amount) * $amount;
}
if($queryString){
    $res = doSearch($index, $queryString, $start, $amount);
    $total = $res['total'];
    $hits = $res['hits'];
}


?>
<form name='UnifiedSearchAdvancedMain' action='index.php' method='POST' class="search_form">
    <input type='hidden' name='query_string' value='test'>
    <input type='hidden' name='action' value='UnifiedSearch'>
    <input id='searchFieldMain' class='searchField' type='text' size='80' name='query_string' placeholder='<?php echo translate("LBL_SEARCH_QUERY_PLACEHOLDER","AOD_Index");?>' value='<?php echo $queryString;?>'>
    <input type="submit" class="button primary" value="<?php echo translate("LBL_SEARCH_BUTTON","AOD_Index");?>">&nbsp;
</form>
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list View'>
    <?php getPaginateHTML($queryString, $start,$amount,$total); ?>
    <thead>
    <tr height='20'>
        <th scope='col' width='10%'data-hide="phone">
				<span sugar="sugar1">
                    <div style='white-space: nowrap; width:100%; text-align:left;'>
                        <?php echo translate("LBL_SEARCH_RESULT_MODULE","AOD_Index"); ?>
                    </div>
                </span sugar='sugar1'>
        </th>
        <th scope='col' width='30%' data-toggle="true">
				<span sugar="sugar1">
                    <div style='white-space: nowrap; width:100%; text-align:left;'>
                        <?php echo translate("LBL_SEARCH_RESULT_NAME","AOD_Index"); ?>
                    </div>
                </span sugar='sugar1'>
        </th>
        <th scope='col' width='30%' data-hide="phone">
				<span sugar="sugar1">
                    <div style='white-space: nowrap; width:100%; text-align:left;'>
                        <?php echo translate("LBL_SEARCH_RESULT_SUMMARY","AOD_Index"); ?>
                    </div>
                </span sugar='sugar1'>
        </th>
        <th scope='col' width='25%' data-hide="phone,phonelandscape">
            <div style='white-space: nowrap; width:100%; text-align:left;'>
                <?php echo translate("LBL_SEARCH_RESULT_DATE_CREATED","AOD_Index"); ?>
            </div>
        </th>
        <th scope='col' width='25%' data-hide="phone,phonelandscape">
            <div style='white-space: nowrap; width:100%; text-align:left;'>
                <?php echo translate("LBL_SEARCH_RESULT_DATE_MODIFIED","AOD_Index"); ?>
            </div>
        </th>
        <th scope='col' width='10%'>
            <div style='white-space: nowrap; width:100%; text-align:left;'>
                <?php echo translate("LBL_SEARCH_RESULT_SCORE","AOD_Index"); ?>
            </div>
        </th>
    </tr>
    </thead>
    <?php
    if($hits){
foreach($hits as $hit){
    echo "<tr>"
        ."<td>".$hit->label."</td>"
        ."<td><a href='index.php?module=".$hit->record_module."&action=DetailView&record=".$hit->record_id."'>".$hit->name."</a></td>"
        ."<td>".$hit->summary."</td>"
        ."<td>".$hit->date_entered."</td>"
        ."<td>".$hit->date_modified."</td>"
        ."<td>".getScoreDisplay($hit)."</td>"
        ."</tr>";
}
        }else{
        echo "<tr><td>".translate("LBL_SEARCH_RESULT_EMPTY","AOD_Index")."</td></td>";
    }
?>
</table>

<?php
function getRecordSummary(SugarBean $bean){
    global $listViewDefs;
    if (!isset($listViewDefs) || !isset($listViewDefs[$bean->module_dir]) ){
        if(file_exists('custom/modules/'.$bean->module_dir.'/metadata/listviewdefs.php')){
            require('custom/modules/'.$bean->module_dir.'/metadata/listviewdefs.php');
        }else if(file_exists('modules/'.$bean->module_dir.'/metadata/listviewdefs.php')){
            require('modules/'.$bean->module_dir.'/metadata/listviewdefs.php');
        }
    }
    if ( !isset($listViewDefs) || !isset($listViewDefs[$bean->module_dir]) ){
        return $bean->get_summary_text();
    }
    $summary = array();;
    foreach($listViewDefs[$bean->module_dir] as $key => $entry){
        if(!$entry['default']){
            continue;
        }
        $key = strtolower($key);

        if(in_array($key,array('date_entered','date_modified','name'))){
            continue;
        }
         $summary[] = $bean->$key;
    }
    $summary = array_filter($summary);
    return implode(' || ',$summary);
}
function getScoreDisplay($hit){
    return number_format(100*$hit->score,2);
}
function unCamelCase($input, $sep = " "){
    $output = preg_replace(array('/(?<=[^A-Z])([A-Z])/', '/(?<=[^0-9])([0-9])/'), $sep.'$0', $input);
    return ucwords($output);
}
function getModuleLabel($module){
    return translate('LBL_MODULE_NAME', $module);
}
function cacheQuery($queryString,$resArray){
    $file = create_cache_directory('modules/AOD_Index/QueryCache/' . md5($queryString));
    $out = serialize($resArray);
    sugar_file_put_contents_atomic($file, $out);
}

function getCorrectMTime($filePath){
    $time = filemtime($filePath);
    $isDST = (date('I', $time) == 1);
    $systemDST = (date('I') == 1);
    $adjustment = 0;
    if($isDST == false && $systemDST == true){
        $adjustment = 3600;
    }elseif($isDST == true && $systemDST == false){
        $adjustment = -3600;
    }else{
        $adjustment = 0;
    }
    return ($time + $adjustment);
}

function doSearch($index, $queryString, $start = 0, $amount = 20){
    global $current_user;
    $cachePath = 'cache/modules/AOD_Index/QueryCache/' . md5($queryString);
    if(is_file($cachePath)){
        $mTime = getCorrectMTime($cachePath);
        if($mTime > (time() - 5*60)){
            $hits = unserialize(sugar_file_get_contents($cachePath));
        }
    }
    if(!isset($hits)){
        $tmphits = $index->find($queryString);
        $hits = array();
        foreach($tmphits as $hit){
            $bean = BeanFactory::getBean($hit->record_module,$hit->record_id);
            if(empty($bean)){
                continue;
            }
            if($bean->bean_implements('ACL') && !is_admin($current_user)){
                //Annoyingly can't use the following as it always passes true for is_owner checks on list
                //$bean->ACLAccess('list');
                $in_group = SecurityGroup::groupHasAccess($bean->module_dir,$bean->id, 'list');
                $is_owner = $bean->isOwner($current_user->id);
                $access = ACLController::checkAccess($bean->module_dir,'list', $is_owner, 'module', $in_group);
                if(!$access){
                    continue;
                }
            }
            $newHit = new stdClass;
            $newHit->record_module = $hit->record_module;
            $newHit->record_id = $hit->record_id;
            $newHit->score = $hit->score;
            $newHit->label = getModuleLabel($bean->module_name);
            $newHit->name = $bean->get_summary_text();
            $newHit->summary = getRecordSummary($bean);
            $newHit->date_entered = $bean->date_entered;
            $newHit->date_modified = $bean->date_modified;
            $hits[] = $newHit;
        }
        //Cache results so pagination is nice and snappy.
        cacheQuery($queryString,$hits);
    }

    $total = count($hits);
    $hits = array_slice($hits,$start,$amount);
    $res = array('total'=>$total,'hits' => $hits);
    return $res;
}

function getPaginateHTML($queryString, $start, $amount, $total){
    $first = !$start;
    $last = ($start + $amount) > $total;
    if($first){
        $startImage = SugarThemeRegistry::current()->getImageURL('start_off.gif');
        $prevImage = SugarThemeRegistry::current()->getImageURL('previous_off.gif');
    }else{
        $startImage = SugarThemeRegistry::current()->getImageURL('start.gif');
        $prevImage = SugarThemeRegistry::current()->getImageURL('previous.gif');
    }
    if($last){
        $endImage = SugarThemeRegistry::current()->getImageURL('end_off.gif');
        $nextImage = SugarThemeRegistry::current()->getImageURL('next_off.gif');
    }else{
        $endImage = SugarThemeRegistry::current()->getImageURL('end.gif');
        $nextImage = SugarThemeRegistry::current()->getImageURL('next.gif');
    }
    ?>
    <td class="paginationChangeButtons" align="right" nowrap="nowrap" width="1%">
        <form action='index.php'>
            <input type="hidden" name="action" value="UnifiedSearch">
            <input type="hidden" name="module" value="Home">
            <input type="hidden" name="start" value="<?php echo $start;?>">
            <input type="hidden" name="total" value="<?php echo $total;?>">
            <input type="hidden" name="query_string" value="<?php echo $queryString;?>">
            <button type="submit" id="listViewStartButton_top" name="listViewStartButton" title="Start" class="button" <?php echo $first ? 'disabled="disabled"' : ''?>>
                <span class='suitepicon suitepicon-action-first'></span>
            </button>
            <button type="submit" id="listViewPrevButton_top" name="listViewPrevButton" class="button" title="Previous" <?php echo $first ? 'disabled="disabled"' : ''?>>
                <span class='suitepicon suitepicon-action-left'></span>
            </button>
            <span class="pageNumbers">(<?php echo $total ? $start+1 : 0;?> - <?php echo min($start + $amount,$total);?> of <?php echo $total;?>)</span>
            <button type="submit" id="listViewNextButton_top" name="listViewNextButton" title="Next" class="button" <?php echo $last ? 'disabled="disabled"' : ''?>>
                <span class='suitepicon suitepicon-action-right'></span>
            </button>
            <button type="submit" id="listViewEndButton_top" name="listViewEndButton" title="End" class="button" <?php echo $last ? 'disabled="disabled"' : ''?>>
                <span class='suitepicon suitepicon-action-last'></span>
            </button>
        </form>
    </td>
<?php
}
