@include('errors.layout', [
    'code' => '500',
    'heading' => 'Váratlan hiba történt.',
    'message' => 'A csapatunk automatikus értesítést kapott a hibáról, és már dolgozunk a megoldáson. Próbáld újra pár perc múlva.',
    'note' => 'A hiba naplózva lett',
])
