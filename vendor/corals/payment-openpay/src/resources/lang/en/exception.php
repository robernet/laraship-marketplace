<?php

return [
    'request_did_not_contain' => 'The request did not contain a header named `Openpay-Signature`.',
    'signature_found_header_named' => 'The signature :name found in the header named `Openpay-Signature is invalid. Make sure that the `services.openpay.webhook_signing_secret` 
                                        config key is set to the value you found on the Openpay dashboard. If you are caching your config try running `php artisan clear:cache` to resolve the problem.',
    'stripe_secret_not_set' => 'The Stripe Openpay signing secret is not set. Make sure that the `openpay.settings`  configured as required.',
    'invalid_two_checked_payload' => 'Invalid Openpay Payload. Please check WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'Invalid Openpay Invoice Code. Please check WebhookCall: :arg',
    'invalid_two_checked_subscription' => 'Invalid Openpay Subscription Reference. Please check WebhookCall: :arg',
    'invalid_two_checked_customer' => 'Invalid Openpay Customer. Please check WebhookCall: :arg',


];
