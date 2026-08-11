<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Beállítások';

    protected static ?string $title = 'Beállítások';

    protected static ?int $navigationSort = 100;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'references_enabled' => Setting::getBool('references_enabled', false),
            'notification_emails' => Setting::getEmailList('notification_email'),
            'email_signature' => Setting::get('email_signature', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('references_enabled')
                    ->label('Referenciák menüpont látható a weboldalon')
                    ->helperText('Amíg nincs feltöltve valódi referencia, hagyd kikapcsolva — a "Referenciák" menüpont, a főoldali gomb és a lábjegyzék-link is eltűnik a nyilvános oldalról.'),
                TagsInput::make('notification_emails')
                    ->label('Értesítési email címek')
                    ->placeholder('pelda@gmail.com')
                    ->helperText('Ide (akár több, pl. a saját Gmail-címedre is) kapsz értesítést minden új ajánlatkérésről és bejövő levélről, hogy ne kelljen feleslegesen bejelentkezned az adminba. Ha üresen hagyod, nem megy ki külső email — az ajánlatkérés és a levél attól még megjelenik az adminban.'),
                RichEditor::make('email_signature')
                    ->label('Email aláírás')
                    ->helperText('Ez töltődik be automatikusan az új levél és a válasz szövegébe a Postafiókban — onnan még szabadon szerkesztheted vagy törölheted küldés előtt.'),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Mentés')
                                ->submit('save'),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('references_enabled', $data['references_enabled'] ? '1' : '0');
        Setting::set('notification_email', implode(',', array_filter(array_map('trim', $data['notification_emails'] ?? []))));
        Setting::set('email_signature', (string) ($data['email_signature'] ?? ''));

        Notification::make()
            ->title('Beállítások elmentve')
            ->success()
            ->send();
    }
}
