<?php
/**
 * Advanced OpenSales, Advanced, robust set of sales modules.
 * @package Advanced OpenSales for SugarCRM
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
 * @author SalesAgility <info@salesagility.com>
 */

    if(!(ACLController::checkAccess('Opportunities', 'edit', true))){
        ACLController::displayNoAccess();
        die;
    }

    global $app_list_strings;

	require_once('modules/AOS_Quotes/AOS_Quotes.php');
	require_once('modules/Opportunities/Opportunity.php');
	
	//Setting values in Quotes
	$quote = new AOS_Quotes();
	$quote->retrieve($_REQUEST['record']);

	//Setting Opportunity Values
	$opportunity = new Opportunity();
    $opportunity->name = $quote->name;
    $opportunity->assigned_user_id = $quote->assigned_user_id;
    $opportunity->amount = $quote->total_amount;
    $opportunity->account_id = $quote->billing_account_id;
    $opportunity->currency_id = $quote->currency_id;
    $opportunity->sales_stage = 'Proposal/Price Quote';
    $opportunity->probability = $app_list_strings['sales_probability_dom']['Proposal/Price Quote'];
    $opportunity->lead_source = 'Self Generated';
    $opportunity->date_closed = $quote->expiration;

    $opportunity->save();

	//Setting opportunity quote relationship
    $quote->load_relationship('opportunities');
    $quote->opportunities->add($opportunity->id);
	ob_clean();
	header('Location: index.php?module=Opportunities&action=EditView&record='.$opportunity->id);
?>