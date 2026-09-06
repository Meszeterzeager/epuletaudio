<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Filament\Resources\QuoteRequests\RelationManagers\FilesRelationManager;
use App\Filament\Resources\QuoteRequests\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\QuoteRequests\RelationManagers\PurchaseOrdersRelationManager;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestForm;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestInfolist;
use App\Filament\Resources\QuoteRequests\Tables\QuoteRequestsTable;
use App\Mail\PaymentRequestMail;
use App\Models\EmailFolder;
use App\Models\EmailMessage;
use App\Models\QuoteRequest;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static string|\UnitEnum|null $navigationGroup = 'Ajánlatkérések';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Megrendelés';

    protected static ?string $pluralModelLabel = 'Megrendelések';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'ordered');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'ordered')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
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

    public static function sendPaymentRequestAction(): Action
    {
        return Action::make('sendPaymentRequest')
            ->label('Díjbekérő küldése')
            ->icon('heroicon-o-banknotes')
            ->color('success')
            ->visible(fn (QuoteRequest $record): bool => $record->items()->exists())
            ->modalHeading('Díjbekérő küldése')
            ->modalSubmitActionLabel('Küldés')
            ->schema(fn (QuoteRequest $record): array => [
                Textarea::make('message')
                    ->label('Üzenet')
                    ->rows(6)
                    ->default("Kedves {$record->name}!\n\nKöszönjük a megrendelést! Az alábbiakban küldjük a díjbekérőt.")
                    ->required(),
                DatePicker::make('due_date')
                    ->label('Fizetési határidő')
                    ->default(now()->addDays(8))
                    ->required(),
            ])
            ->action(function (array $data, QuoteRequest $record): void {
                $dueDate = Carbon::parse($data['due_date'])->format('Y. m. d.');

                $mailable = new PaymentRequestMail($record, $data['message'], $dueDate);

                Mail::to($record->email)->send($mailable);

                EmailMessage::create([
                    'folder_id' => EmailFolder::sent()->id,
                    'thread_id' => (string) Str::uuid(),
                    'direction' => 'outbound',
                    'status' => 'read',
                    'from_email' => config('mail.from.address'),
                    'from_name' => config('mail.from.name'),
                    'to' => [$record->email],
                    'subject' => 'Díjbekérő — '.$mailable->paymentRequestNumber(),
                    'body_html' => $mailable->render(),
                    'sent_at' => now(),
                ]);

                Notification::make()
                    ->title('Díjbekérő elküldve')
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
            'index' => ListOrders::route('/'),
            'view' => ViewOrder::route('/{record}'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
