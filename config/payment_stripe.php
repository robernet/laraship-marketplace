<?php

// Merged over the Stripe package's own config (vendor/corals/payment-stripe), which keeps every other key.
return [
    // Stripe creates the subscription before the card is charged; a declined card leaves it `incomplete`.
    // Start every local subscription `pending`: the paid-invoice webhook (invoice.payment_succeeded)
    // activates it, and whatever a product attaches to a payment follows, so access never depends on a
    // payment that did not happen.
    'default_subscription_status' => 'pending',
];
