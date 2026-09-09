<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Adminisztrátorok
    |--------------------------------------------------------------------------
    |
    | A vesszővel elválasztott ADMIN_EMAILS környezeti változóban megadott
    | e-mail címek férhetnek hozzá a Filament admin felülethez. Az üres lista
    | szándékosan minden hozzáférést elutasít.
    |
    */
    'emails' => array_values(array_filter(array_map(
        static fn (string $email): string => mb_strtolower(trim($email)),
        explode(',', (string) env('ADMIN_EMAILS', '')),
    ))),
];
