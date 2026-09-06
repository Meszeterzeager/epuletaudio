<?php

return [
    /*
    |---------------------------------------------------------------------------
    | Temporary File Upload Endpoint Configuration
    |---------------------------------------------------------------------------
    |
    | Livewire's default temporary-upload validation caps files at 12MB,
    | which silently rejected quote-request floor plans/photos before they
    | ever reached QuoteRequestWizard's own per-field validation rules.
    | This is a single global ceiling shared by every upload field, so it's
    | set to the largest field's limit (the 100MB/102400KB video upload) —
    | QuoteRequestWizard's own rules still cap photos/floor plans at 20MB.
    |
    */

    'temporary_file_upload' => [
        'disk' => null,
        'rules' => ['required', 'file', 'max:102400'],
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 15,
        'cleanup' => true,
    ],
];
