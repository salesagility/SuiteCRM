<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2015 Salesagility Ltd.
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

include_once("include/InlineEditing/InlineEditing.php");

class HomeController extends SugarController
{


    public function action_getAccountsPivotData()
    {
        /*
        $accountBean = BeanFactory::getBean('Accounts');
        $beanList = $accountBean->get_full_list(
            'name'
        );

        $returnArray = [];
        foreach ($beanList as $b) {
            $returnArray[] = $b->toArray();
        }
        echo json_encode($returnArray);
        */


        $returnArray = [];
        $db = DBManagerFactory::getInstance();

        $query = <<<EOF
        SELECT
            name,
            COALESCE(account_type,'undefined') as account_type,
            COALESCE(industry,'undefined') as industry,
            COALESCE(billing_address_country,'undefined') as billing_address_country
        FROM accounts ac
        WHERE ac.deleted = false
EOF;

        $result = $db->query($query);

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
            RTRIM(LTRIM(CONCAT(COALESCE(u.first_name,''),' ',COALESCE(u.last_name,'')))) as assignedUser,
            COALESCE(le.title,'undefined') as leadTitle,
            primary_address_country,
            primary_address_city,
            lead_source,
            le.status,
            account_name
        FROM leads le
        INNER JOIN users u
            ON le.assigned_user_id = u.id
        WHERE le.deleted = false
EOF;

        $result = $db->query($query);

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
            op.name as name,
            RTRIM(LTRIM(CONCAT(COALESCE(first_name,''),' ',COALESCE(last_name,'')))) as userName,
            COALESCE(opportunity_type,'undefined') as opportunity_type,
            lead_source,
            amount,
            date_closed,
            sales_stage,
            probability
        FROM opportunities op
        INNER JOIN users u
            ON op.assigned_user_id = u.id
        WHERE op.deleted = false
EOF;

        $result = $db->query($query);

        while ($row = $db->fetchByAssoc($result)) {
            $x = new stdClass();
            $x->name = $row['name'];
            $x->userName = $row['userName'];
            $x->type = $row['opportunity_type'];
            $x->leadSource = $row['lead_source'];
            $x->amount = $row['amount'];
            $x->closedDate = $row['date_closed'];
            $x->salesStage = $row['sales_stage'];
            $x->probability = $row['probability'];
            $returnArray[] = $x;
        }
        echo json_encode($returnArray);
    }

    public function action_getEditFieldHTML()
    {

        if ($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module']) {

            $html = getEditFieldHTML($_REQUEST['current_module'], $_REQUEST['field'], $_REQUEST['field'], 'EditView',
                $_REQUEST['id']);
            echo $html;
        }

    }

    public function action_saveHTMLField()
    {

        if ($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module']) {

            echo saveField($_REQUEST['field'], $_REQUEST['id'], $_REQUEST['current_module'], $_REQUEST['value'],
                $_REQUEST['view']);

        }

    }

    public function action_getDisplayValue()
    {

        if ($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module']) {

            $bean = BeanFactory::getBean($_REQUEST['current_module'], $_REQUEST['id']);

            if (is_object($bean) && $bean->id != "") {
                echo getDisplayValue($bean, $_REQUEST['field'], "close");
            } else {
                echo "Could not find value.";
            }

        }

    }

    public function action_getValidationRules()
    {
        global $app_strings, $mod_strings;

        if ($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module']) {

            $bean = BeanFactory::getBean($_REQUEST['current_module'], $_REQUEST['id']);

            if (is_object($bean) && $bean->id != "") {

                $fielddef = $bean->field_defs[$_REQUEST['field']];

                if (!$fielddef['required']) {
                    $fielddef['required'] = false;
                }

                if ($fielddef['name'] == "email1" || $fielddef['email2']) {
                    $fielddef['type'] = "email";
                    $fielddef['vname'] = "LBL_EMAIL_ADDRESSES";
                }

                if ($app_strings[$fielddef['vname']]) {
                    $fielddef['label'] = $app_strings[$fielddef['vname']];
                } else {
                    $fielddef['label'] = $mod_strings[$fielddef['vname']];
                }

                $validate_array = array(
                    'type' => $fielddef['type'],
                    'required' => $fielddef['required'],
                    'label' => $fielddef['label']
                );

                echo json_encode($validate_array);
            }

        }

    }

    public function action_getRelateFieldJS()
    {

        global $beanFiles, $beanList;

        $fieldlist = array();
        $view = "EditView";

        if (!isset($focus) || !($focus instanceof SugarBean)) {
            require_once($beanFiles[$beanList[$_REQUEST['current_module']]]);
            $focus = new $beanList[$_REQUEST['current_module']];
        }

        // create the dropdowns for the parent type fields
        $vardefFields[$_REQUEST['field']] = $focus->field_defs[$_REQUEST['field']];

        require_once("include/TemplateHandler/TemplateHandler.php");
        $template_handler = new TemplateHandler();
        $quicksearch_js = $template_handler->createQuickSearchCode($vardefFields, $vardefFields, $view);
        $quicksearch_js = str_replace($_REQUEST['field'], $_REQUEST['field'] . '_display', $quicksearch_js);

        if ($_REQUEST['field'] != "parent_name") {
            $quicksearch_js = str_replace($vardefFields[$_REQUEST['field']]['id_name'], $_REQUEST['field'],
                $quicksearch_js);
        }

        echo $quicksearch_js;

    }

}