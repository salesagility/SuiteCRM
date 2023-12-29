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

require_once __DIR__ . "/../Include/Payment/PaymentBO.php";

class EventInscriptionPaymentBO extends PaymentBO
{

    /**
     * Overload the payment generation method to carry out subsequent actions of the registration payments only
     * @see PaymentBO::newPayment()
     * @return Objetc A payment or Null
     */
    public function newPayment($namePrefix = '')
    {
        if (empty($this->inscription) || empty($this->inscription->id)) {
            $GLOBALS['log']->error('Line ' . __LINE__ . ': ' . __METHOD__ . ":  There is no registration data to link to the payment. Payment will not be generated.");
            return null;
        } else {
            $payment = parent::newPayment($this->inscription->name);
            if ($payment != null) {
                $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ":  Linking the payment [{$payment->id}] to registration [{$this->inscription->id}]");
                $this->inscription->stic_payments_stic_registrations->add($payment->id);
            }
            return $payment;
        }
    }
}
