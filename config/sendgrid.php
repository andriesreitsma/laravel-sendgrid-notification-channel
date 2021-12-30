<?php

return [
    'api_key' => env('SENDGRID_API_KEY',null),
    'bcc_settings' => env('SENDGRID_BCC_SETTINGS',false),
    'bypass_list_management' => env('SENDGRID_BYPASS_LIST_MANAGEMENT',null),
    'bypass_bounce_management' => env('SENDGRID_BYPASS_BOUNCE_MANAGEMENT',false),
    'bypass_spam_management' => env('SENDGRID_BYPASS_SPAM_MANAGEMENT',false),
    'bypass_unsubscribe_management' => env('SENDGRID_BYPASS_UNSUBSCRIBE_MANAGEMENT',false),
    'footer' => env('SENDGRID_FOOTER',false),
    'sandbox_mode' => env('SENDGRID_SANDBOX_MODE',true),
    'spam_check' => env('SENDGRID_SPAMCHECK',false)
];
