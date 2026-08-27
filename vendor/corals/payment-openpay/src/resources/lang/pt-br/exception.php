<?php

return [

    'request_did_not_contain' => 'A solicitação não continha um cabeçalho chamado `Openpay-Signature`.',
    'signature_found_header_named' => 'A assinatura :name encontrada no cabeçalho chamado `Openpay-Signature é inválida. Certifique-se de que o `services.openpay.webhook_signing_secret`
                                        A chave de configuração é definida com o valor encontrado no painel do Openpay. Se você estiver armazenando em cache sua configuração, tente executar o `php artisan clear: cache` para resolver o problema.',
    'stripe_secret_not_set' => 'O segredo de assinatura do Stripe Openpay não está definido. Certifique-se de que o `openpay.settings` esteja configurado conforme necessário.',
    'invalid_two_checked_payload' => 'Carga útil do Openpay inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'Código de fatura Openpay inválido. Por favor, verifique WebhookCall: :arg',
    'invalid_two_checked_subscription' => 'Referência de assinatura Openpay inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_two_checked_customer' => 'Cliente do Openpay inválido. Por favor, verifique WebhookCall: :arg',


];
