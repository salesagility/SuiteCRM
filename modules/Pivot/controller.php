<?php
/**
 *
 *
 * @package
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
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class PivotController extends SugarController {
    protected $nullSqlPlaceholder = 'undefined';
    protected $action_remap = array('index'=>'pivotdata');

    function action_pivotdata() {
        $this->view = 'pivotdata';
    }

    public function getKeyForLabel($type, $label)
    {
        global $mod_strings;
        $labelPrefix = "";
        switch($type){
            case "getAccountsPivotData":
                $labelPrefix = "LBL_AN_ACCOUNTS_";
                break;
            case "getLeadsPivotData":
                $labelPrefix = "LBL_AN_LEADS_";
                break;
            case "getSalesPivotData":
                $labelPrefix = "LBL_AN_SALES_";
                break;
            case "getServicePivotData":
                $labelPrefix = "LBL_AN_SERVICE_";
                break;
            case "getActivitiesPivotData":
                $labelPrefix = "LBL_AN_ACTIVITIES_";
                break;
            case "getMarketingPivotData":
                $labelPrefix = "LBL_AN_MARKETING_";
                break;
            case "getMarketingActivityPivotData":
                $labelPrefix = "LBL_AN_MARKETINGACTIVITY";
                break;
            case "getQuotesPivotData":
                $labelPrefix = "LBL_AN_QUOTES_";
                break;
        }
        $allMatchingLabels = array_keys($mod_strings,$label);

        $matches = array_filter($allMatchingLabels,function($e)use($labelPrefix){
            return(strpos($e,$labelPrefix)!==false);
        });

        return $matches;
    }

    public function getKeysForLabels($type,$items)
    {
        $keys = array();
        foreach($items as $i)
        {
            $key = $this->getKeyForLabel($type,$i);
            //Check that the returned array has only 1 element, else there is a potential error
            //Log error and return empty keys
            //Error if 0 || >1
            $countOfMatches = count($key);
            if($countOfMatches !== 1)
            {
                $this->logPivotErrorWithKeyMatching($type);
                return array();
            }
            else
            {
                $keys[] = reset($key);
            }

        }
        return $keys;
    }

    public function logPivotErrorWithKeyMatching($type)
    {
        global $mod_strings;
        $GLOBALS['log']->error($mod_strings['LBL_AN_DUPLICATE_LABEL_FOR_SUBAREA'].' '.$type);

    }

    public function action_savePivot()
    {

        $type = $_REQUEST['type'];
        $name = $_REQUEST['name'];
        $config = htmlspecialchars_decode($_REQUEST['config']);
        $jsonConfig = json_decode($config,true);

        $colsLabels = array();
        $rowsLabels = array();
        if(isset($jsonConfig['cols']) && count($jsonConfig['cols'])>0)
        {
            $colsLabels= $this->getKeysForLabels($type,$jsonConfig['cols']);
            $jsonConfig['cols'] = $colsLabels;
        }
        if(isset($jsonConfig['rows']) && count($jsonConfig['rows'])>0)
        {
            $rowsLabels= $this->getKeysForLabels($type,$jsonConfig['rows']);
            $jsonConfig['rows'] = $rowsLabels;
        }

        //Set the key value for the inclusions / exclusions
        if(isset($jsonConfig['exclusions']) && count($jsonConfig['exclusions'])>0)
        {
            foreach($jsonConfig['exclusions'] as $key=>$value)
            {
                $newKey = $this->getKeyForLabel($type, $key);

                $jsonConfig['exclusions'][reset($newKey)] = $jsonConfig['exclusions'][$key];
                unset($jsonConfig['exclusions'][$key]);
                //Check that this is an array with 1 element
                if(count($newKey) !== 1)
                    $this->logPivotErrorWithKeyMatching($type);
            }
        }

        if(isset($jsonConfig['inclusions']) && count($jsonConfig['inclusions'])>0)
        {
            foreach($jsonConfig['inclusions'] as $key=>$value)
            {
                $newKey = $this->getKeyForLabel($type, $key);

                $jsonConfig['inclusions'][reset($newKey)] = $jsonConfig['inclusions'][$key];
                unset($jsonConfig['inclusions'][$key]);
                //Check that this is an array with 1 element
                if(count($newKey) !== 1)
                    $this->logPivotErrorWithKeyMatching($type);
            }
        }

        if(isset($jsonConfig['inclusionsInfo']) && count($jsonConfig['inclusionsInfo'])>0)
        {
            foreach($jsonConfig['inclusionsInfo'] as $key=>$value)
            {
                $newKey = $this->getKeyForLabel($type, $key);

                $jsonConfig['inclusionsInfo'][reset($newKey)] = $jsonConfig['inclusionsInfo'][$key];
                unset($jsonConfig['inclusionsInfo'][$key]);
                //Check that this is an array with 1 element
                if(count($newKey) !== 1)
                    $this->logPivotErrorWithKeyMatching($type);
            }
        }

        $pivotBean = BeanFactory::getBean('Pivot');
        $pivotBean->name = $name;
        $pivotBean->type = $type;
        $pivotBean->config = json_encode($jsonConfig);
        $pivotBean->save();

    }

    public function action_deletePivot()
    {
        $id = $_REQUEST['id'];
        $pivotBean = BeanFactory::getBean('Pivot',$id);
        $pivotBean->deleted = true;
        $pivotBean->save();
    }

    public function replaceKeyValueWithLabel($config)
    {
        global $mod_strings;
        $jsonConfig = json_decode($config,true);
        if(isset($jsonConfig['cols']) && count($jsonConfig['cols'])>0) {
            foreach($jsonConfig['cols'] as $k=>$v)
            {
                $jsonConfig['cols'][$k] = $mod_strings[$v];
            }
        }

        if(isset($jsonConfig['rows']) && count($jsonConfig['rows'])>0) {
            foreach($jsonConfig['rows'] as $k=>$v)
            {
                $jsonConfig['rows'][$k] = $mod_strings[$v];
            }
        }

        if(isset($jsonConfig['exclusions']) && count($jsonConfig['exclusions'])>0)
        {
            foreach($jsonConfig['exclusions'] as $key=>$value)
            {
                $newKey = $mod_strings[$key];

                $jsonConfig['exclusions'][$newKey] = $jsonConfig['exclusions'][$key];
                unset($jsonConfig['exclusions'][$key]);
            }
        }

        if(isset($jsonConfig['inclusions']) && count($jsonConfig['inclusions'])>0)
        {
            foreach($jsonConfig['inclusions'] as $key=>$value)
            {
                $newKey = $mod_strings[$key];
                $jsonConfig['inclusions'][$newKey] = $jsonConfig['inclusions'][$key];
                unset($jsonConfig['inclusions'][$key]);
            }
        }

        if(isset($jsonConfig['inclusionsInfo']) && count($jsonConfig['inclusionsInfo'])>0)
        {
            foreach($jsonConfig['inclusionsInfo'] as $key=>$value)
            {
                $newKey = $mod_strings[$key];
                $jsonConfig['inclusionsInfo'][$newKey] = $jsonConfig['inclusionsInfo'][$key];
                unset($jsonConfig['inclusionsInfo'][$key]);
            }
        }

        return json_encode($jsonConfig);
    }

    public function action_getSavedPivotList()
    {
        $pivotBean = BeanFactory::getBean('Pivot');
        $beanList = $pivotBean->get_full_list('name');
        $returnArray = [];
        if(!is_null($beanList))
        {
            foreach ($beanList as $b) {
                $bean = new stdClass();
                $bean->type = $b->type;
                $bean->config = $this->replaceKeyValueWithLabel(htmlspecialchars_decode($b->config));
                $bean->name = $b->name;
                $bean->id = $b->id;
                $returnArray[] = $bean;
            }
        }

        echo json_encode($returnArray);
    }

    function build_report_access_query(SugarBean $module, $alias){

        $module->table_name = $alias;
        $where = '';
        if($module->bean_implements('ACL') && ACLController::requireOwner($module->module_dir, 'list') )
        {
            global $current_user;
            $owner_where = $module->getOwnerWhere($current_user->id);
            $where = ' AND '.$owner_where;

        }

        if(file_exists('modules/SecurityGroups/SecurityGroup.php')){
            /* BEGIN - SECURITY GROUPS */
            if($module->bean_implements('ACL') && ACLController::requireSecurityGroup($module->module_dir, 'list') )
            {
                require_once('modules/SecurityGroups/SecurityGroup.php');
                global $current_user;
                $owner_where = $module->getOwnerWhere($current_user->id);
                $group_where = SecurityGroup::getGroupWhere($alias,$module->module_dir,$current_user->id);
                if(!empty($owner_where)){
                    $where .= " AND (".  $owner_where." or ".$group_where.") ";
                } else {
                    $where .= ' AND '.  $group_where;
                }
            }
        }

        return $where;
    }


    public function action_getAccountsPivotData()
    {
        global $mod_strings;
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
            COALESCE(name,'$this->nullSqlPlaceholder') as accountName,
            COALESCE(account_type,'$this->nullSqlPlaceholder') as account_type,
            COALESCE(industry,'$this->nullSqlPlaceholder') as industry,
            COALESCE(billing_address_country,'$this->nullSqlPlaceholder') as billing_address_country
        FROM accounts
        WHERE accounts.deleted = false
EOF;

        $accounts = BeanFactory::getBean('Accounts');
        $aclWhere = $this->build_report_access_query($accounts,$accounts->table_name);

        $queryString = $query.$aclWhere;

        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->$mod_strings['LBL_AN_ACCOUNTS_ACCOUNT_NAME'] = $row['accountName'];
            $x->$mod_strings['LBL_AN_ACCOUNTS_ACCOUNT_TYPE'] = $row['account_type'];
            $x->$mod_strings['LBL_AN_ACCOUNTS_ACCOUNT_INDUSTRY'] = $row['industry'];
            $x->$mod_strings['LBL_AN_ACCOUNTS_ACCOUNT_BILLING_COUNTRY'] = $row['billing_address_country'];
            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }

    public function action_getLeadsPivotData()
    {
        global $mod_strings;
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
            RTRIM(LTRIM(CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.last_name,'')))) as assignedUser,
            leads.status,
            COALESCE(lead_source, '$this->nullSqlPlaceholder') as leadSource,
			COALESCE(campaigns.name, '$this->nullSqlPlaceholder') as campaignName,
			CAST(YEAR(leads.date_entered) as CHAR(10)) as year,
            COALESCE(QUARTER(leads.date_entered),'$this->nullSqlPlaceholder') as quarter,
			concat('(',MONTH(leads.date_entered),') ',MONTHNAME(leads.date_entered)) as month,
			CAST(WEEK(leads.date_entered) as CHAR(5)) as week,
			DAYNAME(leads.date_entered) as day
        FROM leads
        INNER JOIN users
            ON leads.assigned_user_id = users.id
		LEFT JOIN campaigns
			ON leads.campaign_id = campaigns.id
			AND campaigns.deleted = false
        WHERE leads.deleted = false
        AND users.deleted = false

EOF;

        $leads = BeanFactory::getBean('Leads');
        $aclWhereLeads = $this->build_report_access_query($leads,$leads->table_name);

        $queryString = $query.$aclWhereLeads;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->$mod_strings['LBL_AN_LEADS_ASSIGNED_USER'] = $row['assignedUser'];
            $x->$mod_strings['LBL_AN_LEADS_STATUS'] = $row['status'];
            $x->$mod_strings['LBL_AN_LEADS_LEAD_SOURCE'] = $row['leadSource'];
            $x->$mod_strings['LBL_AN_LEADS_CAMPAIGN_NAME'] = $row['campaignName'];
            $x->$mod_strings['LBL_AN_LEADS_YEAR'] = $row['year'];
            $x->$mod_strings['LBL_AN_LEADS_QUARTER'] = $row['quarter'];
            $x->$mod_strings['LBL_AN_LEADS_MONTH'] = $row['month'];
            $x->$mod_strings['LBL_AN_LEADS_WEEK'] = $row['week'];
            $x->$mod_strings['LBL_AN_LEADS_DAY'] = $row['day'];

            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }


    public function action_getSalesPivotData()
    {
        global $mod_strings;
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
			accounts.name as accountName,
            opportunities.name as opportunityName,
            RTRIM(LTRIM(CONCAT(COALESCE(first_name,''),' ',COALESCE(last_name,'')))) as assignedUser,
            COALESCE(opportunity_type,'$this->nullSqlPlaceholder') as opportunity_type,
            lead_source,
            amount,
            sales_stage,
            probability,
            date_closed as expectedCloseDate,
			COALESCE(QUARTER(date_closed),'$this->nullSqlPlaceholder') as salesQuarter,
			concat('(',MONTH(date_closed),') ',MONTHNAME(date_closed)) as salesMonth,
			CAST(WEEK(date_closed) as CHAR(5)) as salesWeek,
			DAYNAME(date_closed) as salesDay,
			CAST(YEAR(date_closed) as CHAR(10)) as salesYear,
            COALESCE(campaigns.name,'$this->nullSqlPlaceholder') as campaign
        FROM opportunities
		INNER JOIN accounts_opportunities
			ON accounts_opportunities.opportunity_id = opportunities.id
		INNER JOIN accounts
			ON accounts_opportunities.account_id = accounts.id
        INNER JOIN users
            ON opportunities.assigned_user_id = users.id
        LEFT JOIN campaigns
            ON opportunities.campaign_id = campaigns.id
            AND campaigns.deleted = false
        WHERE opportunities.deleted = false
        AND accounts_opportunities.deleted = false
        AND accounts.deleted = false
        AND users.deleted = false

EOF;

        $opps = BeanFactory::getBean('Opportunities');
        $aclWhereOpps = $this->build_report_access_query($opps,$opps->table_name);

        $queryString = $query.$aclWhereOpps;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->$mod_strings['LBL_AN_SALES_ACCOUNT_NAME'] = $row['accountName'];
            $x->$mod_strings['LBL_AN_SALES_OPPORTUNITY_NAME'] = $row['opportunityName'];
            $x->$mod_strings['LBL_AN_SALES_ASSIGNED_USER'] = $row['assignedUser'];
            $x->$mod_strings['LBL_AN_SALES_OPPORTUNITY_TYPE'] = $row['opportunity_type'];
            $x->$mod_strings['LBL_AN_SALES_LEAD_SOURCE'] = $row['lead_source'];
            $x->$mod_strings['LBL_AN_SALES_AMOUNT'] = $row['amount'];
            $x->$mod_strings['LBL_AN_SALES_STAGE'] = $row['sales_stage'];
            $x->$mod_strings['LBL_AN_SALES_PROBABILITY'] = $row['probability'];
            $x->$mod_strings['LBL_AN_SALES_DATE'] = $row['date_closed'];

            $x->$mod_strings['LBL_AN_SALES_QUARTER'] = $row['salesQuarter'];
            $x->$mod_strings['LBL_AN_SALES_MONTH'] = $row['salesMonth'];
            $x->$mod_strings['LBL_AN_SALES_WEEK'] = $row['salesWeek'];
            $x->$mod_strings['LBL_AN_SALES_DAY'] = $row['salesDay'];
            $x->$mod_strings['LBL_AN_SALES_YEAR'] = $row['salesYear'];
            $x->$mod_strings['LBL_AN_SALES_CAMPAIGN'] = $row['campaign'];



            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }

    public function action_getServicePivotData()
    {
        global $mod_strings;
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
            accounts.name,
            cases.state,
            cases.status,
            cases.priority,
            DAYNAME(cases.date_entered) as day,
            CAST(WEEK(cases.date_entered) as CHAR(5)) as week,
            concat('(',MONTH(cases.date_entered),') ',MONTHNAME(cases.date_entered)) as month,
            COALESCE(QUARTER(cases.date_entered),'$this->nullSqlPlaceholder') as quarter,
            CAST(YEAR(cases.date_entered) as CHAR(10)) as year,
            COALESCE(NULLIF(RTRIM(LTRIM(CONCAT(COALESCE(u2.first_name,''),' ',COALESCE(u2.last_name,'')))),''),'$this->nullSqlPlaceholder') as contactName,
            RTRIM(LTRIM(CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.last_name,'')))) as assignedUser
        FROM cases
        INNER JOIN users
            ON cases.assigned_user_id = users.id
        INNER JOIN accounts
            ON cases.account_id = accounts.id
        LEFT JOIN users u2
            ON cases.contact_created_by_id = u2.id
            AND u2.deleted = false
        WHERE cases.deleted = false
        AND users.deleted = false
        AND accounts.deleted = false

EOF;

        $opps = BeanFactory::getBean('Opportunities');
        $aclWhereOpps = $this->build_report_access_query($opps,$opps->table_name);

        $queryString = $query.$aclWhereOpps;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->$mod_strings['LBL_AN_SERVICE_ACCOUNT_NAME'] = $row['name'];
            $x->$mod_strings['LBL_AN_SERVICE_STATE'] = $row['state'];
            $x->$mod_strings['LBL_AN_SERVICE_STATUS'] = $row['status'];
            $x->$mod_strings['LBL_AN_SERVICE_PRIORITY'] = $row['priority'];
            $x->$mod_strings['LBL_AN_SERVICE_CREATED_DAY'] = $row['day'];
            $x->$mod_strings['LBL_AN_SERVICE_CREATED_WEEK'] = $row['week'];
            $x->$mod_strings['LBL_AN_SERVICE_CREATED_MONTH'] = $row['month'];
            $x->$mod_strings['LBL_AN_SERVICE_CREATED_QUARTER'] = $row['quarter'];
            $x->$mod_strings['LBL_AN_SERVICE_CREATED_YEAR'] = $row['year'];
            $x->$mod_strings['LBL_AN_SERVICE_CONTACT_NAME'] = $row['contactName'];
            $x->$mod_strings['LBL_AN_SERVICE_ASSIGNED_TO'] = $row['assignedUser'];

            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }

    public function action_getActivitiesPivotData()
    {
        global $mod_strings;
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
            'call' as type
            , calls.name
            , calls.status
            , RTRIM(LTRIM(CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.last_name,'')))) as assignedUser
        FROM calls
        LEFT JOIN users
            ON calls.assigned_user_id = users.id
            AND users.deleted = false
        WHERE calls.deleted = false
        UNION
        SELECT
            'meeting' as type
            , meetings.name
            , meetings.status
            , RTRIM(LTRIM(CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.last_name,'')))) as assignedUser
        FROM meetings
        LEFT JOIN users
            ON meetings.assigned_user_id = users.id
            AND users.deleted = false
        WHERE meetings.deleted = false
        UNION
        SELECT
            'task' as type
            , tasks.name
            , tasks.status
            , RTRIM(LTRIM(CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.last_name,'')))) as assignedUser
        FROM tasks
        LEFT JOIN users
            ON tasks.assigned_user_id = users.id
            AND users.deleted = false
        WHERE tasks.deleted = false
EOF;

        $opps = BeanFactory::getBean('Opportunities');
        $aclWhereOpps = $this->build_report_access_query($opps,$opps->table_name);

        $queryString = $query.$aclWhereOpps;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->$mod_strings['LBL_AN_ACTIVITIES_TYPE'] = $row['type'];
            $x->$mod_strings['LBL_AN_ACTIVITIES_NAME'] = $row['name'];
            $x->$mod_strings['LBL_AN_ACTIVITIES_STATUS'] = $row['status'];
            $x->$mod_strings['LBL_AN_ACTIVITIES_ASSIGNED_TO'] = $row['assignedUser'];

            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }

    public function action_getMarketingPivotData()
    {
        global $mod_strings;
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
              COALESCE(campaigns.status,'$this->nullSqlPlaceholder') as campaignStatus
            , COALESCE(campaigns.campaign_type,'$this->nullSqlPlaceholder') as campaignType
            , COALESCE(campaigns.budget,'$this->nullSqlPlaceholder') as campaignBudget
            , COALESCE(campaigns.expected_cost,'$this->nullSqlPlaceholder') as campaignExpectedCost
            , COALESCE(campaigns.expected_revenue,'$this->nullSqlPlaceholder') as campaignExpectedRevenue
            , opportunities.name as opportunityName
            , opportunities.amount as opportunityAmount
            , opportunities.sales_stage as opportunitySalesStage
            , RTRIM(LTRIM(CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.last_name,'')))) as assignedUser
            , accounts.name as accountsName
        FROM opportunities
        LEFT JOIN users
            ON opportunities.assigned_user_id = users.id
            AND users.deleted = false
        LEFT JOIN accounts_opportunities
            ON opportunities.id =  accounts_opportunities.opportunity_id
            AND accounts_opportunities.deleted = false
        LEFT JOIN accounts
            ON accounts_opportunities.account_id = accounts.id
            AND accounts.deleted = false
        LEFT JOIN campaigns
            ON opportunities.campaign_id = campaigns.id
            AND campaigns.deleted = false
        WHERE opportunities.deleted = false
EOF;

        $opps = BeanFactory::getBean('Opportunities');
        $aclWhereOpps = $this->build_report_access_query($opps,$opps->table_name);

        $queryString = $query.$aclWhereOpps;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->$mod_strings['LBL_AN_MARKETING_STATUS'] = $row['campaignStatus'];
            $x->$mod_strings['LBL_AN_MARKETING_TYPE'] = $row['campaignType'];
            $x->$mod_strings['LBL_AN_MARKETING_BUDGET'] = $row['campaignBudget'];
            $x->$mod_strings['LBL_AN_MARKETING_EXPECTED_COST'] = $row['campaignExpectedCost'];
            $x->$mod_strings['LBL_AN_MARKETING_EXPECTED_REVENUE'] = $row['campaignExpectedRevenue'];
            $x->$mod_strings['LBL_AN_MARKETING_OPPORTUNITY_NAME'] = $row['opportunityName'];
            $x->$mod_strings['LBL_AN_MARKETING_OPPORTUNITY_AMOUNT'] = $row['opportunityAmount'];
            $x->$mod_strings['LBL_AN_MARKETING_OPPORTUNITY_SALES_STAGE'] = $row['opportunitySalesStage'];
            $x->$mod_strings['LBL_AN_MARKETING_OPPORTUNITY_ASSIGNED_TO'] = $row['assignedUser'];
            $x->$mod_strings['LBL_AN_MARKETING_ACCOUNT_NAME'] = $row['accountsName'];

            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }

    public function action_getMarketingActivityPivotData()
    {
        global $mod_strings;
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
            campaigns.name,
            campaign_log.activity_date,
            campaign_log.activity_type,
            campaign_log.related_type,
            campaign_log.related_id
        FROM campaigns
        LEFT JOIN campaign_log
            ON campaigns.id = campaign_log.campaign_id
            and campaign_log.deleted = false
        where campaigns.deleted = false

EOF;

        $opps = BeanFactory::getBean('Opportunities');
        $aclWhereOpps = $this->build_report_access_query($opps,$opps->table_name);

        $queryString = $query.$aclWhereOpps;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->$mod_strings['LBL_AN_MARKETINGACTIVITY_CAMPAIGN_NAME'] = $row['name'];
            $x->$mod_strings['LBL_AN_MARKETINGACTIVITY_ACTIVITY_DATE'] = $row['activity_date'];
            $x->$mod_strings['LBL_AN_MARKETINGACTIVITY_ACTIVITY_TYPE'] = $row['activity_type'];
            $x->$mod_strings['LBL_AN_MARKETINGACTIVITY_RELATED_TYPE'] = $row['related_type'];
            $x->$mod_strings['LBL_AN_MARKETINGACTIVITY_RELATED_ID'] = $row['related_id'];


            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }

    public function action_getQuotesPivotData()
    {
        global $mod_strings;
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
    SELECT
	opportunities.name as opportunityName,
	opportunities.opportunity_type as opportunityType,
	opportunities.lead_source as opportunityLeadSource,
	opportunities.sales_stage as opportunitySalesStage,
	accounts.name as accountName,
	RTRIM(LTRIM(CONCAT(COALESCE(contacts.first_name,''),' ',COALESCE(contacts.last_name,'')))) as contactName,
	aos_products.name as productName,
	RTRIM(LTRIM(CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.last_name,'')))) as assignedUser,
	aos_products_quotes.product_qty as productQty,
	aos_products_quotes.product_list_price as productListPrice,
	aos_products_quotes.product_cost_price as productCostPrice,
	aos_products.price as productPrice,
	aos_products_quotes.product_discount as productDiscount,
	aos_quotes.discount_amount as discountAmount,
	aos_product_categories.name as categoryName,
	aos_products_quotes.product_total_price as productTotal,
	aos_quotes.total_amount as grandTotal,
	case
		when aos_products_quotes.product_id = 0 then 'Service'
		else 'Product'
	end itemType,
	aos_quotes.date_entered as dateCreated,
    DAYNAME(aos_quotes.date_entered) as dateCreatedDay,
    CAST(WEEK(aos_quotes.date_entered) as CHAR(5)) as dateCreatedWeek,
    concat('(',MONTH(aos_quotes.date_entered),') ',MONTHNAME(aos_quotes.date_entered)) as dateCreatedMonth,
    COALESCE(QUARTER(aos_quotes.date_entered),'$this->nullSqlPlaceholder') as dateCreatedQuarter,
    YEAR(aos_quotes.date_entered) as dateCreatedYear

    FROM aos_quotes
    LEFT JOIN accounts
        ON aos_quotes.billing_account_id = accounts.id
        AND accounts.deleted = false
    LEFT JOIN contacts
        ON aos_quotes.billing_contact_id = contacts.id
        AND contacts.deleted = false
    LEFT JOIN aos_products_quotes
        ON aos_quotes.id = aos_products_quotes.parent_id
        AND aos_products_quotes.deleted = false
    LEFT JOIN aos_products
        ON aos_products_quotes.product_id = aos_products.id
        AND aos_products.deleted = false
    LEFT JOIN opportunities
        ON aos_quotes.opportunity_id = opportunities.id
        AND opportunities.deleted = false
    LEFT JOIN users
        ON aos_quotes.assigned_user_id = users.id
        AND users.deleted = false
    LEFT JOIN aos_product_categories
        ON aos_products.aos_product_category_id = aos_product_categories.id
        AND aos_product_categories.deleted = false
    WHERE aos_quotes.deleted = false
EOF;

        $opps = BeanFactory::getBean('Opportunities');
        $aclWhereOpps = $this->build_report_access_query($opps,$opps->table_name);

        $queryString = $query.$aclWhereOpps;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->$mod_strings['LBL_AN_QUOTES_OPPORTUNITY_NAME'] = $row['opportunityName'];
            $x->$mod_strings['LBL_AN_QUOTES_OPPORTUNITY_TYPE'] = $row['opportunityType'];
            $x->$mod_strings['LBL_AN_QUOTES_OPPORTUNITY_LEAD_SOURCE'] = $row['opportunityLeadSource'];
            $x->$mod_strings['LBL_AN_QUOTES_OPPORTUNITY_SALES_STAGE'] = $row['opportunitySalesStage'];
            $x->$mod_strings['LBL_AN_QUOTES_ACCOUNT_NAME'] = $row['accountName'];
            $x->$mod_strings['LBL_AN_QUOTES_CONTACT_NAME'] = $row['contactName'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_NAME'] = $row['productName'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_TYPE'] = $row['itemType'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_CATEGORY'] = $row['categoryName'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_QTY'] = $row['productQty'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_LIST_PRICE'] = $row['productListPrice'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_SALE_PRICE'] = $row['productPrice'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_COST_PRICE'] = $row['productCostPrice'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_DISCOUNT_PRICE'] = $row['productDiscount'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_DISCOUNT_AMOUNT'] = $row['discountAmount'];
            $x->$mod_strings['LBL_AN_QUOTES_ITEM_TOTAL'] = $row['productTotal'];
            $x->$mod_strings['LBL_AN_QUOTES_GRAND_TOTAL'] = $row['grandTotal'];
            $x->$mod_strings['LBL_AN_QUOTES_ASSIGNED_TO'] = $row['assignedUser'];

            $x->$mod_strings['LBL_AN_QUOTES_DATE_CREATED'] = $row['dateCreated'];
            $x->$mod_strings['LBL_AN_QUOTES_DAY_CREATED'] = $row['dateCreatedDay'];
            $x->$mod_strings['LBL_AN_QUOTES_WEEK_CREATED'] = $row['dateCreatedWeek'];
            $x->$mod_strings['LBL_AN_QUOTES_MONTH_CREATED'] = $row['dateCreatedMonth'];
            $x->$mod_strings['LBL_AN_QUOTES_QUARTER_CREATED'] = $row['dateCreatedQuarter'];
            $x->$mod_strings['LBL_AN_QUOTES_YEAR_CREATED'] = $row['dateCreatedYear'];


            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }
}