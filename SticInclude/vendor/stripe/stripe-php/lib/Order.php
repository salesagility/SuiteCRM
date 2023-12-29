<?php

// File generated from our OpenAPI spec

namespace Stripe;

/**
 * An Order describes a purchase being made by a customer, including the products
 * &amp; quantities being purchased, the order status, the payment information, and
 * the billing/shipping details.
 *
 * Related guide: <a href="https://stripe.com/docs/orders">Orders overview</a>
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property int $amount_subtotal Order cost before any discounts or taxes are applied. A positive integer representing the subtotal of the order in the <a href="https://stripe.com/docs/currencies#zero-decimal">smallest currency unit</a> (e.g., 100 cents to charge $1.00 or 100 to charge ¥100, a zero-decimal currency).
 * @property int $amount_total Total order cost after discounts and taxes are applied. A positive integer representing the cost of the order in the <a href="https://stripe.com/docs/currencies#zero-decimal">smallest currency unit</a> (e.g., 100 cents to charge $1.00 or 100 to charge ¥100, a zero-decimal currency). To submit an order, the total must be either 0 or at least $0.50 USD or <a href="https://stripe.com/docs/currencies#minimum-and-maximum-charge-amounts">equivalent in charge currency</a>.
 * @property null|string|\Stripe\StripeObject $application ID of the Connect application that created the Order, if any.
 * @property \Stripe\StripeObject $automatic_tax
 * @property null|\Stripe\StripeObject $billing_details Customer billing details associated with the order.
 * @property null|string $client_secret <p>The client secret of this Order. Used for client-side retrieval using a publishable key.</p><p>The client secret can be used to complete a payment for an Order from your frontend. It should not be stored, logged, embedded in URLs, or exposed to anyone other than the customer. Make sure that you have TLS enabled on any page that includes the client secret.</p><p>Refer to our docs for <a href="https://stripe.com/docs/orders-beta/create-and-process">creating and processing an order</a> to learn about how client_secret should be handled.</p>
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property string $currency Three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html">ISO currency code</a>, in lowercase. Must be a <a href="https://stripe.com/docs/currencies">supported currency</a>.
 * @property null|string|\Stripe\Customer $customer The customer which this orders belongs to.
 * @property null|string $description An arbitrary string attached to the object. Often useful for displaying to users.
 * @property null|(string|\Stripe\Discount)[] $discounts The discounts applied to the order. Use <code>expand[]=discounts</code> to expand each discount.
 * @property null|string $ip_address A recent IP address of the purchaser used for tax reporting and tax location inference.
 * @property \Stripe\Collection<\Stripe\LineItem> $line_items A list of line items the customer is ordering. Each line item includes information about the product, the quantity, and the resulting cost. There is a maximum of 100 line items.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property null|\Stripe\StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property \Stripe\StripeObject $payment
 * @property null|\Stripe\StripeObject $shipping_cost The details of the customer cost of shipping, including the customer chosen ShippingRate.
 * @property null|\Stripe\StripeObject $shipping_details Customer shipping information associated with the order.
 * @property string $status The overall status of the order.
 * @property \Stripe\StripeObject $tax_details
 * @property \Stripe\StripeObject $total_details
 */
class Order extends ApiResource
{
    const OBJECT_NAME = 'order';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    const STATUS_CANCELED = 'canceled';
    const STATUS_COMPLETE = 'complete';
    const STATUS_OPEN = 'open';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SUBMITTED = 'submitted';

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Order the canceled order
     */
    public function cancel($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/cancel';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }

    /**
     * @param string $id
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\LineItem> list of LineItems
     */
    public static function allLineItems($id, $params = null, $opts = null)
    {
        $url = static::resourceUrl($id) . '/line_items';
        list($response, $opts) = static::_staticRequest('get', $url, $params, $opts);
        $obj = \Stripe\Util\Util::convertToStripeObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Order the reopened order
     */
    public function reopen($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/reopen';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Order the submited order
     */
    public function submit($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/submit';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }
}
