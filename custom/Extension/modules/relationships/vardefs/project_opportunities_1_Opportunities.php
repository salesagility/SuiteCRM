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
// created: 2019-10-23 10:06:51
$dictionary["Opportunity"]["fields"]["project_opportunities_1"] = array (
  'name' => 'project_opportunities_1',
  'type' => 'link',
  'relationship' => 'project_opportunities_1',
  'source' => 'non-db',
  'module' => 'Project',
  'bean_name' => 'Project',
  'vname' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_PROJECT_TITLE',
  'id_name' => 'project_opportunities_1project_ida',
);
$dictionary["Opportunity"]["fields"]["project_opportunities_1_name"] = array (
  'name' => 'project_opportunities_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_PROJECT_TITLE',
  'save' => true,
  'id_name' => 'project_opportunities_1project_ida',
  'link' => 'project_opportunities_1',
  'table' => 'project',
  'module' => 'Project',
  'rname' => 'name',
);
$dictionary["Opportunity"]["fields"]["project_opportunities_1project_ida"] = array (
  'name' => 'project_opportunities_1project_ida',
  'type' => 'link',
  'relationship' => 'project_opportunities_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
);
