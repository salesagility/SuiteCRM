<?php
 /**
 * 
 * 
 * @package AdvancedOpenDiscovery
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

$job_strings[] = 'aodIndexUnindexed';
$job_strings[] = 'aodOptimiseIndex';


/**
 * Scheduled job function to index any unindexed beans.
 * @return bool
 */
function aodIndexUnindexed(){
    $total = 1;
    while($total > 0){
        $total = performLuceneIndexing();
    }
    return true;
}

function aodOptimiseIndex(){
    $index = BeanFactory::getBean("AOD_Index")->getIndex();
    $index->optimise();
    return true;
}


function performLuceneIndexing(){
    global $db, $sugar_config;
    if(empty($sugar_config['aod']['enable_aod'])){
        return;
    }
    $index = BeanFactory::getBean("AOD_Index")->getIndex();

    $beanList = $index->getIndexableModules();
    $total = 0;
    foreach($beanList as $beanModule => $beanName){
        $bean = BeanFactory::getBean($beanModule);
        if(!$bean || !method_exists($bean,"getTableName") || !$bean->getTableName()){
            continue;
        }
        $query = "SELECT b.id FROM ".$bean->getTableName()." b LEFT JOIN aod_indexevent ie ON (ie.record_id = b.id AND ie.record_module = '".$beanModule."') WHERE b.deleted = 0 AND (ie.id IS NULL OR ie.date_modified < b.date_modified)";
        $res = $db->limitQuery($query,0,500);
        $c = 0;
        while($row = $db->fetchByAssoc($res)){
            $c++;
            $total++;
            $index->index($beanModule, $row['id']);
        }
        if($c){
            $index->commit();
            $index->optimise();
        }

    }
    $index->optimise();
    return $total;
}