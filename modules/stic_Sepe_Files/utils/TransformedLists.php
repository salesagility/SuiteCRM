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

/**
 * This file includes those fields that need changes in order to include its information into a SEPE file.
 * 
 * On the Left side are listed the values that will come from the CRM database, on the right side side appears 
 * those values that are needed by SEPE.
 * 
 * It is used mainly by the class SEPEgestter.
 */

$TIPO_CONTRATO = array (
    '' => '',
    '001' => '001',
    '003' => '002',
    '401' => '003',
    '501' => '004',
    '005' => '005',
);

$SEXO_TRABAJADOR = array (
    '' => '',
    'male' => 1,
    'female' => 2,
);