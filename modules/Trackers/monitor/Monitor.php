<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
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


require_once('modules/Trackers/Metric.php');
require_once('modules/Trackers/Trackable.php');

define('MAX_SESSION_LENGTH', 36);

#[\AllowDynamicProperties]
class Monitor implements Trackable
{
    public $metricsFile;
    public $name;
    protected $metrics;
    protected $cachedStores;
    public $stores;
    public $monitor_id;
    public $table_name;
    protected $enabled = true;
    protected $dirty = false;

    public $date_start;
    public $date_end;
    public $active;
    public $round_trips;
    public $seconds;
    public $session_id;

    /**
     * Monitor constructor
     */
    public function __construct($name='', $monitorId='', $metadata='', $store='')
    {
        global $dictionary;
        $dictionary = $dictionary ?? [];
        if (empty($metadata) || !file_exists($metadata)) {
            $GLOBALS['log']->error($GLOBALS['app_strings']['ERR_MONITOR_FILE_MISSING'] . "($metadata)");
            throw new Exception($GLOBALS['app_strings']['ERR_MONITOR_FILE_MISSING'] . "($metadata)");
        }

        $this->name = $name;
        $this->metricsFile = $metadata;

        require($this->metricsFile);
        $fields = $dictionary[$this->name]['fields'];
        $this->table_name = !empty($dictionary[$this->name]['table']) ? $dictionary[$this->name]['table'] : $this->name;
        $this->metrics = array();
        foreach ($fields as $field) {

           //We need to skip auto_increment fields; they are not real metrics
            //since they are generated by the database.
            if (isset($field['auto_increment'])) {
                continue;
            }

            $type = isset($field['dbType']) ? $field['dbType'] : $field['type'];
            $name = $field['name'];
            $this->metrics[$name] = new Metric($type, $name);
        }

        $this->monitor_id = $monitorId;
        $this->stores = $store;

        if (isset($this->metrics['session_id'])) {
            //set the value of the session id for 2 reasons:
            //1) it is the same value no matter where it is set
            //2) ensure it follows some filter rules.
            $this->setValue('session_id', $this->getSessionId());
        }
    }

    /**
     * setValue
     * Sets the value defined in the monitor's metrics for the given name
     * @param $name String value of metric name
     * @param $value Mixed value
     * @throws Exception Thrown if metric name is not configured for monitor instance
     */
    public function setValue($name, $value)
    {
        if (!isset($this->metrics[$name])) {
            $GLOBALS['log']->error($GLOBALS['app_strings']['ERR_UNDEFINED_METRIC'] . "($name)");
            throw new Exception($GLOBALS['app_strings']['ERR_UNDEFINED_METRIC'] . "($name)");
        } else {
            if ($this->metrics[$name]->isMutable()) {
                $this->$name = is_object($value) ? get_class($value) : $value;
                $this->dirty = true;
            }
        }
    }

    public function getValue($name)
    {
        return $this->$name;
    }

    /**
     * getStores
     * Returns Array of store names defined for monitor instance
     * @return Array of store names defined for monitor instance
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * getMetrics
     * Returns Array of metric instances defined for monitor instance
     * @return Array of metric instances defined for monitor instance
     */
    public function getMetrics()
    {
        return $this->metrics;
    }

    /**
     * isDirty
     * Returns if the monitor has data that needs to be saved
     * @return $dirty boolean
     */
    public function isDirty()
    {
        return $this->dirty;
    }

    /**
     * save
     * This method retrieves the Store instances associated with monitor and calls
     * the flush method passing with the montior ($this) instance.
     * @param $flush boolean parameter indicating whether or not to flush the instance data to store or possibly cache
     */
    public function save($flush=true)
    {
        //If the monitor is not enabled, do not save
        if (!$this->isEnabled()&&$this->name!='tracker_sessions') {
            return false;
        }

        //if the monitor does not have values set no need to do the work saving.
        if (!$this->dirty) {
            return false;
        }

        if (empty($GLOBALS['tracker_' . $this->table_name])) {
            foreach ($this->stores as $s) {
                $store = $this->getStore($s);
                $store->flush($this);
            }
        }
        $this->clear();
    }

    /**
     * clear
     * This function clears the metrics data in the monitor instance
     */
    public function clear()
    {
        $metrics = $this->getMetrics();
        foreach ($metrics as $name=>$metric) {
            if ($metric->isMutable()) {
                $this->$name = '';
            }
        }
        $this->dirty = false;
    }

    /**
     * getStore
     * This method checks if the Store implementation has already been instantiated and
     * will return the one stored; otherwise it will create the Store implementation and
     * save it to the Array of Stores.
     * @param $store The name of the store as defined in the 'modules/Trackers/config.php' settings
     * @return An instance of a Store implementation
     * @throws Exception Thrown if $store class cannot be loaded
     */
    protected function getStore($store)
    {
        if (isset($this->cachedStores[$store])) {
            return $this->cachedStores[$store];
        }

        if (!file_exists("modules/Trackers/store/$store.php")) {
            $GLOBALS['log']->error($GLOBALS['app_strings']['ERR_STORE_FILE_MISSING'] . "($store)");
            throw new Exception($GLOBALS['app_strings']['ERR_STORE_FILE_MISSING'] . "($store)");
        }

        require_once("modules/Trackers/store/$store.php");
        $s = new $store();
        $this->cachedStores[$store] = $s;
        return $s;
    }

    public function getSessionId()
    {
        $sessionid = session_id();
        if (!empty($sessionid) && strlen($sessionid) > MAX_SESSION_LENGTH) {
            $sessionid = md5($sessionid);
        }
        return $sessionid;
    }

    /**
     * Returns the monitor's metrics/values as an Array
     * @return An Array of data for the monitor's corresponding metrics
     */
    public function toArray()
    {
        $to_arr = array();
        $metrics = $this->getMetrics();
        foreach ($metrics as $name=>$metric) {
            $to_arr[$name] = isset($this->$name) ? $this->$name : null;
        }
        return $to_arr;
    }

    public function setEnabled($enable=true)
    {
        $this->enabled = $enable;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }
}
