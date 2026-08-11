<?php

namespace App\Filament\Resources\PurchaseOrders;

use App\Filament\Resources\PurchaseOrders\Pages\ListPurchaseOrders;
use App\Filament\Resources\PurchaseOrders\Pages\ViewPurchaseOrder;
use App\Filament\Resources\PurchaseOrders\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\PurchaseOrders\Schemas\PurchaseOrderInfolist;
use App\Filament\Resources\PurchaseOrders\Tables\PurchaseOrdersTable;
use App\Mail\PurchaseOrderMail;
use App\Models\PurchaseOrder;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static string|\UnitEnum|null $navigationGroup = 'Beszerzés';

    protected static ?string $modelLabel = 'Megrendelés';

    protected static ?string $pluralModelLabel = 'Beszerzés';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'draft')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function infolist(Schema $schema): Schema
    {
        return PurchaseOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseOrdersTable::configure($table);
    }

    public static function sendAction(): Action
    {
        return Action::make('send')
            ->label(fn (PurchaseOrder $record): string => $record->status === 'sent' ? 'Újraküldés a beszállítónak' : 'Küldés a beszállítónak')
            ->icon('heroicon-o-paper-airplane')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Megrendelés küldése')
            ->modalDescription(fn (PurchaseOrder $record): string => filled($record->supplier->email)
                ? "A megrendelés PDF-ként kimegy erre a címre: {$record->supplier->email}"
                : 'A beszállítónak nincs email címe megadva — előbb add meg a Beszállítók menüpontban.')
            ->disabled(fn (PurchaseOrder $record): bool => blank($record->supplier->email))
            ->action(function (PurchaseOrder $record): void {
                Mail::to($record->supplier->email)->send(new PurchaseOrderMail($record));

                $record->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);

                Notification::make()
                    ->title('Megrendelés elküldve')
                    ->success()
                    ->send();
            });
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPurchaseOrders::route('/'),
            'view' => ViewPurchaseOrder::route('/{record}'),
        ];
    }
}
