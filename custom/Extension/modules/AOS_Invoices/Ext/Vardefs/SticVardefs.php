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
$dictionary['AOS_Invoices']['fields']['description']['rows'] = '2'; // Make textarea fields shorter

// Mass update fields definition:
$dictionary['AOS_Invoices']['fields']['billing_account']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['billing_contact']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['billing_address_street']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['billing_address_city']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['billing_address_state']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['billing_address_postalcode']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['billing_address_country']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['shipping_address_street']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['shipping_address_city']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['shipping_address_state']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['shipping_address_postalcode']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['shipping_address_country']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['quote_number']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['quote_date']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['invoice_date']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['due_date']['massupdate'] = 1;
$dictionary['AOS_Invoices']['fields']['status']['massupdate'] = 1;

// Inline edition definition:
$dictionary['AOS_Invoices']['fields']['number']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['billing_address_street']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['shipping_address_street']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['currency_id']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['line_items']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['total_amt']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['discount_amount']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['subtotal_amount']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['shipping_amount']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['shipping_tax_amt']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['tax_amount']['inline_edit'] = 0;
$dictionary['AOS_Invoices']['fields']['total_amount']['inline_edit'] = 0;
