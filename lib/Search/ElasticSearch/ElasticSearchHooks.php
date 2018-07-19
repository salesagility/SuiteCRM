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

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 27/06/18
 * Time: 14:10
 */

namespace SuiteCRM\Search\ElasticSearch;

use LoggerManager;
use SugarBean;

class ElasticSearchHooks
{
    public function beanSaved($bean, $event, $arguments)
    {
        if (ElasticSearchIndexer::isEnabled() === false) {
            return;
        }

        try {
            $indexer = $this->getIndexer($bean);
            if ($this->isBlacklisted($bean, $indexer)) {
                return;
            }
            $indexer->indexBean($bean);
        } catch (\Exception $e) {
            $message = 'Failed to add bean to index because: ' . $e->getMessage();
            if (isset($indexer)) {
                $indexer->getLogger()->error($message);
            } else {
                LoggerManager::getLogger()->error($message);
            }
        }
    }

    /**
     * @param $bean
     * @return ElasticSearchIndexer
     */
    private function getIndexer($bean)
    {
        $indexer = !isset($bean->indexer) ? new ElasticSearchIndexer() : $bean->indexer;
        return $indexer;
    }

    /**
     * @param $bean SugarBean
     * @param $indexer ElasticSearchIndexer
     * @return bool
     */
    private function isBlacklisted($bean, $indexer)
    {
        return !in_array($bean->module_name, $indexer->getModulesToIndex());
    }

    public function beanDeleted($bean, $event, $arguments)
    {
        if (ElasticSearchIndexer::isEnabled() === false) {
            return;
        }

        try {
            $indexer = $this->getIndexer($bean);
            if ($this->isBlacklisted($bean, $indexer)) {
                return;
            }
            $indexer->removeBean($bean);
        } catch (\Exception $e) {
            $message = 'Failed to remove bean from index because: ' . $e->getMessage();
            if (isset($indexer)) {
                $indexer->getLogger()->error($message);
            } else {
                LoggerManager::getLogger()->error($message);
            }
        }
    }
}