<?php

namespace App\Filament\Resources\QuoteRequests;

use App\Filament\Resources\QuoteRequests\Pages\CreateQuoteRequest;
use App\Filament\Resources\QuoteRequests\Pages\EditQuoteRequest;
use App\Filament\Resources\QuoteRequests\Pages\ListQuoteRequests;
use App\Filament\Resources\QuoteRequests\Pages\ViewQuoteRequest;
use App\Filament\Resources\QuoteRequests\RelationManagers\FilesRelationManager;
use App\Filament\Resources\QuoteRequests\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\QuoteRequests\RelationManagers\PurchaseOrdersRelationManager;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestForm;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestInfolist;
use App\Filament\Resources\QuoteRequests\Tables\QuoteRequestsTable;
use App\Mail\QuoteOfferMail;
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
                $includeItems = (bool) ($data['include_items'] ?? false);

                $mailable = new QuoteOfferMail($record, $data['message'], $includeItems);

                Mail::to($record->email)->send($mailable);

                EmailMessage::create([
                    'folder_id' => EmailFolder::sent()->id,
                    'thread_id' => (string) Str::uuid(),
                    'direction' => 'outbound',
                    'status' => 'read',
                    'from_email' => config('mail.from.address'),
                    'from_name' => config('mail.from.name'),
                    'to' => [$record->email],
                    'subject' => $data['subject'],
                    'body_html' => $mailable->render(),
                    'sent_at' => now(),
                ]);

                if ($record->status === 'new') {
                    $record->update(['status' => 'quote_issued']);
                }

                Notification::make()
                    ->title('Ajánlat elküldve')
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
            'edit' => EditQuoteRequest::route('/{record}/edit'),
        ];
    }
}
