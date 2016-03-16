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

    protected $action_remap = array('index'=>'pivotdata');

    function action_pivotdata() {
        $this->view = 'pivotdata';
    }

    public function action_savePivot()
    {
        $config = htmlspecialchars_decode($_REQUEST['config']);

        $type = $_REQUEST['type'];
        $name = $_REQUEST['name'];

        $pivotBean = BeanFactory::getBean('Pivot');
        $pivotBean->name = $name;
        $pivotBean->type = $type;
        $pivotBean->config = $config;
        $pivotBean->save();
    }

    public function action_deletePivot()
    {
        $id = $_REQUEST['id'];
        $pivotBean = BeanFactory::getBean('Pivot',$id);
        $pivotBean->deleted = true;
        $pivotBean->save();
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
                $bean->config = htmlspecialchars_decode($b->config);
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
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
            name,
            COALESCE(account_type,'undefined') as account_type,
            COALESCE(industry,'undefined') as industry,
            COALESCE(billing_address_country,'undefined') as billing_address_country
        FROM accounts
        WHERE accounts.deleted = false
EOF;

        $accounts = BeanFactory::getBean('Accounts');
        $aclWhere = $this->build_report_access_query($accounts,$accounts->table_name);

        $queryString = $query.$aclWhere;

        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->name = $row['name'];
            $x->accountType = $row['account_type'];
            $x->industry = $row['industry'];
            $x->billingCountry = $row['billing_address_country'];
            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }

    public function action_getLeadsPivotData()
    {
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
            RTRIM(LTRIM(CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.last_name,'')))) as assignedUser,
            COALESCE(leads.title,'undefined') as leadTitle,
            primary_address_country,
            primary_address_city,
            lead_source,
            leads.status,
            account_name
        FROM leads
        INNER JOIN users
            ON leads.assigned_user_id = users.id
        WHERE leads.deleted = false
EOF;

        $leads = BeanFactory::getBean('Leads');
        $aclWhereLeads = $this->build_report_access_query($leads,$leads->table_name);

        $queryString = $query.$aclWhereLeads;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->assignedUser = $row['assignedUser'];
            $x->leadTitle = $row['leadTitle'];
            $x->leadCountry = $row['primary_address_country'];
            $x->leadCity = $row['primary_address_city'];
            $x->source = $row['lead_source'];
            $x->status = $row['status'];
            $x->accountName = $row['account_name'];
            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }


    public function action_getSalesPivotData()
    {
        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
			accounts.name as accountName,
            opportunities.name as name,
            RTRIM(LTRIM(CONCAT(COALESCE(first_name,''),' ',COALESCE(last_name,'')))) as userName,
            COALESCE(opportunity_type,'undefined') as opportunity_type,
            lead_source,
            amount,
            date_closed,
			COALESCE(QUARTER(date_closed),'undefined') as quarter,
			concat('(',MONTH(date_closed),') ',MONTHNAME(date_closed)) as month,
			CAST(WEEK(date_closed) as CHAR(5)) as week,
			DAYNAME(date_closed) as day,
			CAST(YEAR(date_closed) as CHAR(10)) as year,
            sales_stage,
            probability
        FROM opportunities
		INNER JOIN accounts_opportunities
			ON accounts_opportunities.opportunity_id = opportunities.id
		INNER JOIN accounts
			ON accounts_opportunities.account_id = accounts.id
        INNER JOIN users
            ON opportunities.assigned_user_id = users.id
        WHERE opportunities.deleted = false
EOF;

        $opps = BeanFactory::getBean('Opportunities');
        $aclWhereOpps = $this->build_report_access_query($opps,$opps->table_name);

        $queryString = $query.$aclWhereOpps;
        $result = $db->query($queryString);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->accoutName = $row['accountName'];
            $x->name = $row['name'];
            $x->userName = $row['userName'];
            $x->type = $row['opportunity_type'];
            $x->leadSource = $row['lead_source'];
            $x->amount = $row['amount'];
            $x->salesDate = $row['date_closed'];

            $x->salesQuarter = $row['quarter'];
            $x->salesMonth = $row['month'];
            $x->salesWeek = $row['week'];
            $x->salesDay = $row['day'];
            $x->salesYear = $row['year'];

            $x->salesStage = $row['sales_stage'];
            $x->probability = $row['probability'];
            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }
}