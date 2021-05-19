<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

/**
 * Class UnlinkService
 * Port of include/generic/DeleteRelationship.php
 * Accessing the above file directly is not possible
 */
class UnlinkService
{
    /**
     * Unlink related records for link field
     * @param string $module
     * @param string $record
     * @param string $linkField
     * @param string $linkedId
     * @return array with feedback
     */
    public function run(string $module, string $record, string $linkField, string $linkedId): array
    {
        global $beanList;

        if (empty($record) || empty($linkField) || empty($linkedId)) {
            return [
                'success' => false,
                'message' => 'LBL_RECORD_NOT_FOUND'
            ];
        }

        if (empty($module) || empty($beanList[$module])) {
            return [
                'success' => false,
                'message' => 'LBL_MODULE_NOT_FOUND'
            ];
        }

        $beanName = $beanList[$module];
        $bean = BeanFactory::newBean($module);

        if (!$bean) {
            return [
                'success' => false,
                'message' => 'LBL_RECORD_NOT_FOUND'
            ];
        }

        $bean = $bean->retrieve($record);

        if (!$bean) {
            return [
                'success' => false,
                'message' => 'LBL_RELATIONSHIP_LOAD_ERROR'
            ];
        }

        if (!$this->handleAclRoles($linkField, $beanName)) {
            return [
                'success' => false,
                'message' => 'LBL_ACCESS_DENIED'
            ];
        }

        if (!$bean->load_relationship($linkField)) {
            return [
                'success' => false,
                'message' => 'LBL_RELATIONSHIP_LOAD_ERROR'
            ];
        }

        $ids = $bean->$linkField->get();
        if (!in_array($linkedId, $ids, true)) {
            return [
                'success' => false,
                'message' => 'LBL_NOT_LINKED'
            ];
        }

        $result = $this->unlink($bean, $linkField, $record, $linkedId);

        if ($result === false) {
            return [
                'success' => false,
                'message' => 'LBL_UNLINK_RELATIONSHIP_FAILED'
            ];
        }

        $this->handleCampaignProspectLists($bean, $beanName, $linkField, $record, $linkedId);
        $this->handleAccountsLeads($bean, $beanName, $record, $linkField, $linkedId);

        $this->handleMeetings($bean, $beanName, $record, $linkedId);
        $this->handleUsersEapm($beanName, $linkField, $linkedId);

        return [
            'success' => true,
            'message' => 'LBL_UNLINK_RELATIONSHIP_SUCCESS'
        ];
    }

    /**
     * Unlink records for relationship link
     * @param SugarBean|null $bean
     * @param string $linkField
     * @param $record
     * @param $linkedId
     * @return bool
     */
    protected function unlink(SugarBean $bean, string $linkField, string $record, string $linkedId): bool
    {
        if ($bean->$linkField->_relationship->relationship_name === 'quotes_contacts_shipto') {
            unset($bean->$linkField->_relationship->relationship_role_column);
        }

        return $bean->$linkField->delete($record, $linkedId);
    }

    /**
     * Handle campaigns prospects special scenario
     * @param SugarBean $bean
     * @param $beanName
     * @param string $linkField
     * @param $record
     * @param $linkedId
     */
    protected function handleCampaignProspectLists(
        SugarBean $bean,
        $beanName,
        string $linkField,
        $record,
        $linkedId
    ): void {
        if ($beanName !== 'Campaign' || $linkField !== 'prospectlists') {
            return;
        }

        $query = "SELECT email_marketing_prospect_lists.id from email_marketing_prospect_lists ";
        $query .= " left join email_marketing on email_marketing.id=email_marketing_prospect_lists.email_marketing_id";
        $query .= " where email_marketing.campaign_id='$record'";
        $query .= " and email_marketing_prospect_lists.prospect_list_id='$linkedId'";

        $result = $bean->db->query($query);
        while (($row = $bean->db->fetchByAssoc($result)) != null) {
            $del_query = " update email_marketing_prospect_lists set email_marketing_prospect_lists.deleted=1, email_marketing_prospect_lists.date_modified=" . $bean->db->convert(
                    "'" . TimeDate::getInstance()->nowDb() . "'",
                    'datetime'
                );
            $del_query .= " WHERE  email_marketing_prospect_lists.id='{$row['id']}'";
            $bean->db->query($del_query);
        }
        $bean->db->query($query);
    }

    /**
     * Handle Accounts Leads special scenario
     * @param SugarBean $bean
     * @param string $beanName
     * @param string $record
     * @param string $linkField
     * @param string $linkedId
     */
    protected function handleAccountsLeads(
        SugarBean $bean,
        string $beanName,
        string $record,
        string $linkField,
        string $linkedId
    ): void {
        if ($beanName !== "Account" || $linkField !== 'leads') {
            return;
        }

        // for Accounts-Leads non-standard relationship, after clearing account_id form Lead's bean, clear also account_name
        $bean->retrieve($record);

        $lead = BeanFactory::newBean('Leads');
        $lead->retrieve($linkedId);

        if ($bean->name === $lead->account_name) {
            $lead->account_name = '';
        }
        $lead->save();

        unset($lead);
    }

    /**
     * HandleMeetings special scenario
     * @param SugarBean $bean
     * @param string $beanName
     * @param string $record
     * @param string $linkedId
     */
    protected function handleMeetings(SugarBean $bean, string $beanName, string $record, string $linkedId): void
    {
        if ($beanName !== "Meeting") {
            return;
        }

        $bean->retrieve($record);
        $user = BeanFactory::newBean('Users');
        $user->retrieve($linkedId);
        //make sure that record exists. we may have a contact on our hands.
        if (!empty($user->id) && $bean->update_vcal) {
            vCal::cache_sugar_vcal($user);
        }
    }

    /**
     * Handle Users / EAPM relationship special scenario
     * @param string $beanName
     * @param string $linkField
     * @param string $linkedId
     */
    protected function handleUsersEapm(string $beanName, string $linkField, string $linkedId): void
    {
        if ($beanName !== "User" || $linkField !== 'eapm') {
            return;
        }

        $eapm = BeanFactory::newBean('EAPM');
        $eapm->mark_deleted($linkedId);
    }

    /**
     * Handle Acl roles special scenario
     * @param string $linkedField
     * @param string $beanName
     * @return bool
     */
    protected function handleAclRoles(string $linkedField, string $beanName): bool
    {
        if ($linkedField !== 'aclroles') {
            return true;
        }

        if (!ACLController::checkAccess($beanName, 'edit', true)) {
            return false;
        }

        return true;
    }
}
