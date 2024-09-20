<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

$dictionary['Document']['fields']['stic_shared_document_link_c'] = array(
    'inline_edit' => 1,
    'labelValue' => 'Shared document link',
    'required' => false,
    'source' => 'custom_fields',
    'name' => 'stic_shared_document_link_c',
    'vname' => 'LBL_STIC_SHARED_DOCUMENT_LINK',
    'type' => 'url',
    'massupdate' => 0,
    'default' => null,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => true,
    'duplicate_merge' => 'enabled',
    'merge_filter' => 'enabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'len' => '255',
    'size' => '20',
    'dbType' => 'varchar',
    'link_target' => '_blank',
    'id' => 'Documentsstic_shared_document_link_c',
    'custom_module' => 'Documents',
);

$dictionary["Document"]["fields"]["leads_documents_1"] = array(
    'name' => 'leads_documents_1',
    'type' => 'link',
    'relationship' => 'leads_documents_1',
    'source' => 'non-db',
    'module' => 'Leads',
    'bean_name' => 'Lead',
    'vname' => 'LBL_LEADS_DOCUMENTS_1_FROM_LEADS_TITLE',
);

$dictionary["Document"]["fields"]["stic_sessions_documents"] = array(
    'name' => 'stic_sessions_documents',
    'type' => 'link',
    'relationship' => 'stic_sessions_documents',
    'source' => 'non-db',
    'module' => 'stic_Sessions',
    'bean_name' => 'stic_Sessions',
    'vname' => 'LBL_STIC_SESSIONS_DOCUMENTS_FROM_STIC_SESSIONS_TITLE',
    'id_name' => 'stic_sessions_documentsstic_sessions_ida',
);
$dictionary["Document"]["fields"]["stic_sessions_documents_name"] = array(
    'name' => 'stic_sessions_documents_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_SESSIONS_DOCUMENTS_FROM_STIC_SESSIONS_TITLE',
    'save' => true,
    'id_name' => 'stic_sessions_documentsstic_sessions_ida',
    'link' => 'stic_sessions_documents',
    'table' => 'stic_sessions',
    'module' => 'stic_Sessions',
    'rname' => 'name',
    'inline_edit' => 1,
    'massupdate' => 1,
);
$dictionary["Document"]["fields"]["stic_sessions_documentsstic_sessions_ida"] = array(
    'name' => 'stic_sessions_documentsstic_sessions_ida',
    'type' => 'link',
    'relationship' => 'stic_sessions_documents',
    'source' => 'non-db',
    'reportable' => false,
    'side' => 'right',
    'vname' => 'LBL_STIC_SESSIONS_DOCUMENTS_FROM_DOCUMENTS_TITLE',
);
$dictionary["Document"]["fields"]["stic_job_applications_documents"] = array(
    'name' => 'stic_job_applications_documents',
    'type' => 'link',
    'relationship' => 'stic_job_applications_documents',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_APPLICATIONS_DOCUMENTS_FROM_STIC_JOB_APPLICATIONS_TITLE',
);
$dictionary["Document"]["fields"]["stic_job_offers_documents"] = array(
    'name' => 'stic_job_offers_documents',
    'type' => 'link',
    'relationship' => 'stic_job_offers_documents',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_OFFERS_DOCUMENTS_FROM_STIC_JOB_OFFERS_TITLE',
);

$dictionary["Document"]["fields"]["prospects_documents_1"] = array(
    'name' => 'prospects_documents_1',
    'type' => 'link',
    'relationship' => 'prospects_documents_1',
    'source' => 'non-db',
    'module' => 'Prospects',
    'bean_name' => 'Prospect',
    'vname' => 'LBL_PROSPECTS_DOCUMENTS_1_FROM_PROSPECTS_TITLE',
);

$dictionary["Document"]["fields"]["stic_families_documents"] = array(
    'name' => 'stic_families_documents',
    'type' => 'link',
    'relationship' => 'stic_families_documents',
    'source' => 'non-db',
    'module' => 'stic_Families',
    'bean_name' => false,
    'vname' => 'LBL_STIC_FAMILIES_DOCUMENTS_FROM_STIC_FAMILIES_TITLE',
    'id_name' => 'stic_families_documentsstic_families_ida',
);
$dictionary["Document"]["fields"]["stic_families_documents_name"] = array(
    'name' => 'stic_families_documents_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_FAMILIES_DOCUMENTS_FROM_STIC_FAMILIES_TITLE',
    'save' => true,
    'id_name' => 'stic_families_documentsstic_families_ida',
    'link' => 'stic_families_documents',
    'table' => 'stic_families',
    'module' => 'stic_Families',
    'rname' => 'name',
);
$dictionary["Document"]["fields"]["stic_families_documentsstic_families_ida"] = array(
    'name' => 'stic_families_documentsstic_families_ida',
    'type' => 'link',
    'relationship' => 'stic_families_documents',
    'source' => 'non-db',
    'reportable' => false,
    'side' => 'right',
    'vname' => 'LBL_STIC_FAMILIES_DOCUMENTS_FROM_DOCUMENTS_TITLE',
);
$dictionary["Document"]["fields"]["stic_group_opportunities_documents_1"] = array (
    'name' => 'stic_group_opportunities_documents_1',
    'type' => 'link',
    'relationship' => 'stic_group_opportunities_documents_1',
    'source' => 'non-db',
    'module' => 'stic_Group_Opportunities',
    'bean_name' => 'stic_Group_Opportunities',
    'vname' => 'LBL_STIC_GROUP_OPPORTUNITIES_DOCUMENTS_1_FROM_STIC_GROUP_OPPORTUNITIES_TITLE',
  );

// Modified properties in native fields
$dictionary['Document']['fields']['filename']['required'] = 0;
$dictionary['Document']['fields']['filename']['inline_edit'] = 0;

$dictionary['Document']['fields']['description']['rows'] = 2;

$dictionary['Document']['fields']['assigned_user_id']['massupdate'] = 1;
$dictionary['Document']['fields']['status_id']['massupdate'] = 1;
$dictionary['Document']['fields']['active_date']['massupdate'] = 1;
$dictionary['Document']['fields']['exp_date']['massupdate'] = 1;
$dictionary['Document']['fields']['category_id']['massupdate'] = 1;
$dictionary['Document']['fields']['subcategory_id']['massupdate'] = 1;

$dictionary['Document']['fields']['name']['massupdate'] = 0;
$dictionary['Document']['fields']['document_name']['massupdate'] = 0;
$dictionary['Document']['fields']['doc_id']['massupdate'] = 0;
$dictionary['Document']['fields']['doc_type']['massupdate'] = 0;
$dictionary['Document']['fields']['doc_url']['massupdate'] = 0;
$dictionary['Document']['fields']['filename']['massupdate'] = 0;
$dictionary['Document']['fields']['status']['massupdate'] = 0;
$dictionary['Document']['fields']['document_revision_id']['massupdate'] = 0;
$dictionary['Document']['fields']['revisions']['massupdate'] = 0;
$dictionary['Document']['fields']['revision']['massupdate'] = 0;
$dictionary['Document']['fields']['last_rev_created_name']['massupdate'] = 0;
$dictionary['Document']['fields']['last_rev_mime_type']['massupdate'] = 0;
$dictionary['Document']['fields']['latest_revision']['massupdate'] = 0;
$dictionary['Document']['fields']['last_rev_create_date']['massupdate'] = 0;
$dictionary['Document']['fields']['contracts']['massupdate'] = 0;
$dictionary['Document']['fields']['leads']['massupdate'] = 0;
$dictionary['Document']['fields']['accounts']['massupdate'] = 0;
$dictionary['Document']['fields']['contacts']['massupdate'] = 0;
$dictionary['Document']['fields']['opportunities']['massupdate'] = 0;
$dictionary['Document']['fields']['cases']['massupdate'] = 0;
$dictionary['Document']['fields']['bugs']['massupdate'] = 0;
$dictionary['Document']['fields']['related_doc_id']['massupdate'] = 0;
$dictionary['Document']['fields']['related_doc_name']['massupdate'] = 0;
$dictionary['Document']['fields']['related_doc_rev_id']['massupdate'] = 0;
$dictionary['Document']['fields']['related_doc_rev_number']['massupdate'] = 0;
$dictionary['Document']['fields']['is_template']['massupdate'] = 0;
$dictionary['Document']['fields']['template_type']['massupdate'] = 0;
$dictionary['Document']['fields']['latest_revision_name']['massupdate'] = 0;
$dictionary['Document']['fields']['selected_revision_name']['massupdate'] = 0;
$dictionary['Document']['fields']['contract_status']['massupdate'] = 0;
$dictionary['Document']['fields']['contract_name']['massupdate'] = 0;
$dictionary['Document']['fields']['linked_id']['massupdate'] = 0;
$dictionary['Document']['fields']['selected_revision_id']['massupdate'] = 0;
$dictionary['Document']['fields']['latest_revision_id']['massupdate'] = 0;
$dictionary['Document']['fields']['selected_revision_filename']['massupdate'] = 0;
$dictionary['Document']['fields']['aos_contracts']['massupdate'] = 0;
$dictionary['Document']['fields']['stic_shared_document_link_c']['massupdate'] = 0;
$dictionary['Document']['fields']['stic_sessions_documents_name']['massupdate'] = 0;
