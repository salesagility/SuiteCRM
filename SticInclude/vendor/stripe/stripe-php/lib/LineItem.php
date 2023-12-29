<?php

// File generated from our OpenAPI spec

namespace Stripe;

/**
 * A line item.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property int $amount_discount Total discount amount applied. If no discounts were applied, defaults to 0.
 * @property int $amount_subtotal Total before any discounts or taxes are applied.
 * @property int $amount_tax Total tax amount applied. If no tax was applied, defaults to 0.
 * @property int $amount_total Total after discounts and taxes.
 * @property string $currency Three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html">ISO currency code</a>, in lowercase. Must be a <a href="https://stripe.com/docs/currencies">supported currency</a>.
 * @property string $description An arbitrary string attached to the object. Often useful for displaying to users. Defaults to product name.
 * @property \Stripe\StripeObject[] $discounts The discounts applied to the line item.
 * @property null|\Stripe\Price $price The price used to generate the line item.
 * @property string|\Stripe\Product $product <p>The ID of the product for this line item.</p><p>This will always be the same as <code>price.product</code>.</p>
 * @property null|int $quantity The quantity of products being purchased.
 * @property \Stripe\StripeObject[] $taxes The taxes applied to the line item.
 */
class LineItem extends ApiResource
{
    const OBJECT_NAME = 'item';

    use ApiOperations\All;
}
