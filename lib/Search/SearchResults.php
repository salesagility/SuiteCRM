<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

namespace SuiteCRM\Search;

use BeanFactory;
use RuntimeException;
use SugarBean;
use SuiteCRM\Exception\Exception;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Class SearchResults holds results and metadata of a search.
 *
 * @author Vittorio Iocolano
 */
class SearchResults
{
    /** @var array Contains the results ids */
    private $hits;
    /** @var array Contains the scores of each hit. This should match in structure with $hits */
    private $scores;
    /** @var array Similar to scores, but customisable by the search engine */
    private $options;
    /** @var float The number of seconds it took to perform the search */
    private $searchTime;
    /** @var int The total number of hits (without pagination) */
    private $total;
    /** @var bool Flag specifying if the (nested) hits are grouped by the modules */
    private $groupedByModule;

    /**
     * SearchResults constructor.
     *
     * @param array $hits            Contains the results ids
     * @param bool  $groupedByModule Flag specifying if the (nested) hits are grouped by the modules
     * @param float $searchTime      The number of seconds it took to perform the search
     * @param int   $total           The number of total hits (without pagination)
     * @param array $scores          Contains the scores of each hit. This should match in structure with $hits
     * @param array $options         Similar to scores, but customisable by the search engine
     */
    public function __construct(array $hits, $groupedByModule = true, $searchTime = null, $total = null, array $scores = null, array $options = null)
    {
        $this->hits = $hits;
        $this->scores = $scores;
        $this->options = $options;
        $this->groupedByModule = $groupedByModule;
        $this->searchTime = $searchTime;
        $this->total = $total;

        if ($this->scores != null && count($hits) != count($scores)) {
            throw new RuntimeException('The sizes of $hits and $scores must match.');
        }
    }

    /**
     * Returns the results.
     *
     * Note that the structure of the results depends whether of not they have been nested by module or not.
     *
     * @return array
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * Fetches the results (originally just module->id) as Beans.
     *
     * @see getHits()
     * @return array
     */
    public function getHitsAsBeans()
    {
        $hits = $this->hits;
        $parsed = [];

        foreach ($hits as $module => $beans) {
            foreach ((array)$beans as $bean) {
                $obj = BeanFactory::getBean($module, $bean);
                
                // if a search found a bean but suitecrm does not, it could happens
                // maybe the bean is deleted but elsasticsearch is not re-indexing yet.
                // so at this point we trying to rebuild the index and try again to get bean:
                if (!$obj) {
                    ElasticSearch\ElasticSearchIndexer::repairElasticsearchIndex();
                    $obj = BeanFactory::getBean($module, $bean);
                }
                
                if (!$obj) {
                    throw new Exception('Error retrieveing bean: ' . $module . ' [' . $bean . ']');
                }
                $obj->load_relationships();
                $fieldDefs = $obj->getFieldDefinitions();
                $objUpdatedLinks = $this->updateFieldDefLinks($obj, $fieldDefs);
                $parsed[$module][] = $objUpdatedLinks;
            }
        }

        return $parsed;
    }
    
    /**
     *
     * @param SugarBean $obj
     * @param array $fieldDefs
     * @return SugarBean
     */
    protected function updateFieldDefLinks(SugarBean $obj, $fieldDefs)
    {
        foreach ($fieldDefs as &$fieldDef) {
            if (isset($obj->{$fieldDef['name']})) {
                $obj = $this->updateObjLinks($obj, $fieldDef);
            }
        }
        return $obj;
    }
    
    /**
     * Update related links in a bean to show it on results page
     *
     * @param SugarBean $obj
     * @param array $fieldDef
     * @return SugarBean
     */
    protected function updateObjLinks(SugarBean $obj, &$fieldDef)
    {
        if ($fieldDef['type'] == 'relate' && isset($fieldDef['link']) && isset($fieldDef['id_name']) && $fieldDef['id_name']) {
            $relId = $this->getRelatedId($obj, $fieldDef['id_name'], $fieldDef['link']);
            $obj->{$fieldDef['name']} = $this->getLink($obj->{$fieldDef['name']}, $fieldDef['module'], $relId, 'DetailView');
        } elseif ($fieldDef['name'] == 'name') {
            $obj->{$fieldDef['name']} = $this->getLink($obj->{$fieldDef['name']}, $obj->module_name, $obj->id, 'DetailView');
        }
        return $obj;
    }
    
    /**
     * resolve related record ID
     *
     * @param string $idName
     * @param string $link
     * @return null|string
     */
    protected function getRelatedId(SugarBean $obj, $idName, $link)
    {
        $relId = $obj->id;
        $relField = $idName;
        if (isset($obj->$link)) {
            $link2 = $obj->$link;
            $link2Focus = $link2->getFocus();
            $relId = $link2Focus->$relField;
        } elseif (isset($obj->$relField)) {
            $relId = $obj->$relField;
        } else {
            LoggerManager::getLogger()->warn('Unresolved related ID for field: '. $relField);
        }
        return $relId;
    }
    
    /**
     *
     * @global array $sugar_config
     * @param string $label
     * @param string $module
     * @param string $record
     * @param string $action
     * @return string
     */
    protected function getLink($label, $module, $record, $action)
    {
        global $sugar_config;
        $link = "<a href=\"{$sugar_config['site_url']}/index.php?action={$action}&module={$module}&record={$record}&offset=1\"><span>{$label}</span></a>";
        return $link;
    }

    /**
     * Returns an arbitrary scores defining how much related a hit is to the query.
     *
     * @return array
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * Returns the total number of hits (without pagination).
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getOption($key)
    {
        return $this->options[$key];
    }

    /**
     * Time in seconds it took to perform the search.
     *
     * @return float
     */
    public function getSearchTime()
    {
        return $this->searchTime;
    }

    /**
     * @return bool
     */
    public function isGroupedByModule()
    {
        return $this->groupedByModule;
    }
}
