<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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

require_once 'include/SugarQueue/SugarCronJobs.php';
require_once 'include/SugarHttpClient.php';

/**
 * CRON driver for job queue that ships jobs outside
 * @api
 */
class SugarCronRemoteJobs extends SugarCronJobs
{
    /**
     * URL for remote job server
     * @var string
     */
    protected $jobserver;

    /**
     * Just in case we'd ever need to override...
     * @var string
     */
    protected $submitURL = "submitJob";

    /**
     * REST client
     * @var string
     */
    protected $client;

    public function __construct()
    {
        parent::__construct();
        if(!empty($GLOBALS['sugar_config']['job_server'])) {
            $this->jobserver = $GLOBALS['sugar_config']['job_server'];
        }
        $this->setClient(new SugarHttpClient());
    }

    /**
    * Set client to talk to SNIP
    * @param SugarHttpClient $client
    */
    public function setClient(SugarHttpClient $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Return ID for this client
     * @return string
     */
    public function getMyId()
    {
        return 'CRON'.$GLOBALS['sugar_config']['unique_key'].':'.md5($this->jobserver);
    }

    /**
     * Execute given job
     * @param SchedulersJob $job
     */
    public function executeJob($job)
    {
        $data = http_build_query(array("data" => json_encode(array("job" => $job->id, "client" => $this->getMyId(), "instance" => $GLOBALS['sugar_config']['site_url']))));
        $response = $this->client->callRest($this->jobserver.$this->submitURL, $data);
        if(!empty($response)) {
            $result = json_decode($response, true);
            if(empty($result) || empty($result['ok']) || $result['ok'] != $job->id) {
                $GLOBALS['log']->debug("CRON Remote: Job {$job->id} not accepted by server: $response");
                $this->jobFailed($job);
                $job->failJob("Job not accepted by server: $response");
            }
        } else {
            $GLOBALS['log']->debug("CRON Remote: REST request failed for job {$job->id}");
            $this->jobFailed($job);
            $job->failJob("Could not connect to job server");
        }
    }

}

