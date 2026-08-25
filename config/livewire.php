<?php

return [
    /*
    |---------------------------------------------------------------------------
    | Temporary File Upload Endpoint Configuration
    |---------------------------------------------------------------------------
    |
    | Livewire's default temporary-upload validation caps files at 12MB,
    | which silently rejected quote-request floor plans/photos before they
    | ever reached QuoteRequestWizard's own 20MB (20480 KB) validation rule.
    | Raising the max here keeps both limits in sync.
    |
    */

    'temporary_file_upload' => [
        'disk' => null,
        'rules' => ['required', 'file', 'max:20480'],
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5,
        'cleanup' => true,
    ],
];
