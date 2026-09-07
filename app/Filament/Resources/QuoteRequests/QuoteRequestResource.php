<?php

namespace App\Filament\Resources\QuoteRequests;

use App\Filament\Resources\QuoteRequests\Pages\CreateQuoteRequest;
use App\Filament\Resources\QuoteRequests\Pages\ListQuoteRequests;
use App\Filament\Resources\QuoteRequests\Pages\ViewQuoteRequest;
use App\Filament\Resources\QuoteRequests\RelationManagers\FilesRelationManager;
use App\Filament\Resources\QuoteRequests\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\QuoteRequests\RelationManagers\PurchaseOrdersRelationManager;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestForm;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestInfolist;
use App\Filament\Resources\QuoteRequests\Tables\QuoteRequestsTable;
use App\Mail\QuoteOfferMail;
use App\Mail\QuoteRequestStatusMail;
use App\Models\EmailFolder;
use App\Models\EmailMessage;
use App\Models\QuoteRequest;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelopeOpen;

    protected static string|\UnitEnum|null $navigationGroup = 'Ajánlatkérések';

    protected static ?string $modelLabel = 'Ajánlatkérés';

    protected static ?string $pluralModelLabel = 'Ajánlatkérések';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return QuoteRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return QuoteRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuoteRequestsTable::configure($table);
    }

    public static function sendOfferAction(): Action
    {
        return Action::make('sendOffer')
            ->label('Ajánlat küldése emailben')
            ->icon('heroicon-o-paper-airplane')
            ->color('success')
            ->modalHeading('Ajánlat küldése emailben')
            ->modalSubmitActionLabel('Küldés')
            ->schema(fn (QuoteRequest $record): array => [
                TextInput::make('subject')
                    ->label('Tárgy')
                    ->default('Ajánlat — '.config('app.name'))
                    ->required(),
                Textarea::make('message')
                    ->label('Üzenet')
                    ->rows(8)
                    ->default("Kedves {$record->name}!\n\nKöszönjük megkeresésed! Az alábbiakban küldjük a részletes ajánlatot.\n\n")
                    ->required(),
                Toggle::make('include_items')
                    ->label('Tételek csatolása (termékek, szolgáltatások az ajánlatból)')
                    ->default($record->items()->exists())
                    ->visible($record->items()->exists()),
            ])
            ->action(function (array $data, QuoteRequest $record): void {
                $record->offerNumber();
                $includeItems = (bool) ($data['include_items'] ?? false);

                $mailable = new QuoteOfferMail($record, $data['message'], $includeItems);

                Mail::to($record->email)->send($mailable);

                self::logSentEmail($record, $data['subject'], $mailable->render());

                if ($record->status === 'new') {
                    $record->update(['status' => 'quote_issued']);
                }

                Notification::make()
                    ->title('Ajánlat elküldve')
                    ->success()
                    ->send();
            });
    }

    public static function sendProcessingNotificationAction(): Action
    {
        return Action::make('sendProcessingNotification')
            ->label('Feldolgozás alatt — email küldése')
            ->icon('heroicon-o-clock')
            ->color('gray')
            ->visible(fn (QuoteRequest $record): bool => ! $record->is_processing)
            ->modalHeading('Feldolgozás alatt — email küldése')
            ->modalDescription('Az email elküldése után a kérés "Feldolgozás alatt" jelölést kap.')
            ->modalSubmitActionLabel('Küldés')
            ->schema(fn (QuoteRequest $record): array => [
                TextInput::make('subject')
                    ->label('Tárgy')
                    ->default('Ajánlatkérésed feldolgozás alatt — '.config('app.name'))
                    ->required(),
                Textarea::make('message')
                    ->label('Üzenet')
                    ->rows(8)
                    ->default("Köszönjük megkeresésed! Értesítünk, hogy megkezdtük az ajánlatkérésed feldolgozását, hamarosan jelentkezünk a részletekkel.")
                    ->required(),
            ])
            ->action(function (array $data, QuoteRequest $record): void {
                $mailable = new QuoteRequestStatusMail($record, $data['subject'], $data['message']);

                Mail::to($record->email)->send($mailable);

                self::logSentEmail($record, $data['subject'], $mailable->render());

                $record->update(['is_processing' => true]);

                Notification::make()
                    ->title('Email elküldve')
                    ->success()
                    ->send();
            });
    }

    public static function sendClarificationNeededAction(): Action
    {
        return Action::make('sendClarificationNeeded')
            ->label('Egyeztetés szükséges — email küldése')
            ->icon('heroicon-o-chat-bubble-left-right')
            ->color('warning')
            ->visible(fn (QuoteRequest $record): bool => ! $record->needs_clarification)
            ->modalHeading('Egyeztetés szükséges — email küldése')
            ->modalDescription('Az email elküldése után a kérés "Egyeztetés szükséges" jelölést kap.')
            ->modalSubmitActionLabel('Küldés')
            ->schema(fn (QuoteRequest $record): array => [
                TextInput::make('subject')
                    ->label('Tárgy')
                    ->default('Pontosításra van szükségünk — '.config('app.name'))
                    ->required(),
                Textarea::make('message')
                    ->label('Üzenet')
                    ->rows(8)
                    ->default("Köszönjük megkeresésed! A pontos ajánlat elkészítéséhez az alábbi kérdés(ek)ben szeretnénk egyeztetni veled:\n\n")
                    ->required(),
            ])
            ->action(function (array $data, QuoteRequest $record): void {
                $mailable = new QuoteRequestStatusMail($record, $data['subject'], $data['message']);

                Mail::to($record->email)->send($mailable);

                self::logSentEmail($record, $data['subject'], $mailable->render());

                $record->update(['needs_clarification' => true]);

                Notification::make()
                    ->title('Email elküldve')
                    ->success()
                    ->send();
            });
    }

    public static function editInternalNotesAction(): Action
    {
        return Action::make('editInternalNotes')
            ->label('Belső jegyzet szerkesztése')
            ->icon('heroicon-o-pencil-square')
            ->color('gray')
            ->modalHeading('Belső jegyzet szerkesztése')
            ->modalSubmitActionLabel('Mentés')
            ->schema(fn (QuoteRequest $record): array => [
                Textarea::make('internal_notes')
                    ->label('Belső jegyzet')
                    ->helperText('Csak admin számára látható.')
                    ->rows(6)
                    ->default($record->internal_notes),
            ])
            ->action(function (array $data, QuoteRequest $record): void {
                $record->update(['internal_notes' => $data['internal_notes'] ?: null]);

                Notification::make()
                    ->title('Jegyzet mentve')
                    ->success()
                    ->send();
            });
    }

    protected static function logSentEmail(QuoteRequest $record, string $subject, string $bodyHtml): void
    {
        EmailMessage::create([
            'folder_id' => EmailFolder::sent()->id,
            'thread_id' => (string) Str::uuid(),
            'direction' => 'outbound',
            'status' => 'read',
            'from_email' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to' => [$record->email],
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'sent_at' => now(),
        ]);
    }

    public static function markAsOrderedAction(): Action
    {
        return Action::make('markAsOrdered')
            ->label('Megrendelés rögzítése')
            ->icon('heroicon-o-shopping-cart')
            ->color('success')
            ->visible(fn (QuoteRequest $record): bool => $record->status !== 'ordered')
            ->requiresConfirmation()
            ->modalHeading('Megrendelés rögzítése')
            ->modalDescription('Az ajánlat lezárásra kerül mint megrendelt, és automatikusan létrejönnek a szükséges beszerzési rendelések a beszállítók felé.')
            ->action(function (QuoteRequest $record): void {
                $record->update(['status' => 'ordered']);

                Notification::make()
                    ->title('Megrendelés rögzítve')
                    ->success()
                    ->send();
            });
    }

    public static function getRelations(): array
    {
        return [
            FilesRelationManager::class,
            ItemsRelationManager::class,
            PurchaseOrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuoteRequests::route('/'),
            'create' => CreateQuoteRequest::route('/create'),
            'view' => ViewQuoteRequest::route('/{record}'),
        ];
    }
}
