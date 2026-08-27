<?php

return [
    'content_consent_settings' => [
        'utility_content_consent_enabled' => [
            'label' => 'utility-content-consent::labels.content_consent.enabled',
            'type' => 'boolean',
            'validation' => '',
            'settings_type' => 'BOOLEAN',
        ],
        'utility_content_consent_popup_content' => [
            'label' => 'utility-content-consent::labels.content_consent.popup_content',
            'type' => 'textarea',
            'validation' => 'required',
            'settings_type' => 'TEXTAREA',
            'attributes' => [
                'class' => 'ckeditor-simple'
            ]
        ],
        'utility_content_consent_popup_title' => [
            'label' => 'utility-content-consent::labels.content_consent.popup_title',
            'type' => 'text',
            'validation' => 'required',
            'settings_type' => 'TEXT',
        ],
        'utility_content_consent_accept_button_text' => [
            'label' => 'utility-content-consent::labels.content_consent.accept_button_text',
            'type' => 'text',
            'validation' => 'required',
            'settings_type' => 'TEXT',
            'default' => 'I Agree',
        ],
        'utility_content_consent_reject_button_text' => [
            'label' => 'utility-content-consent::labels.content_consent.reject_button_text',
            'type' => 'text',
            'validation' => 'required',
            'settings_type' => 'TEXT',
            'default' => 'I Decline',
        ],
        'utility_content_consent_rejected_redirect_url' => [
            'label' => 'utility-content-consent::labels.content_consent.rejected_redirect_url',
            'type' => 'text',
            'validation' => 'required',
            'settings_type' => 'TEXT',
        ],
        'utility_content_consent_ask_every' => [
            'label' => 'utility-content-consent::labels.content_consent.ask_every',
            'type' => 'number',
            'default' => 30,
            'validation' => 'required',
            'settings_type' => 'NUMBER',
        ],
    ]
];
