<?php

namespace App\Filament\Resources\Quotes;

use App\Filament\Resources\QuoteRequests\RelationManagers\FilesRelationManager;
use App\Filament\Resources\QuoteRequests\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\QuoteRequests\RelationManagers\PurchaseOrdersRelationManager;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestForm;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestInfolist;
use App\Filament\Resources\QuoteRequests\Tables\QuoteRequestsTable;
use App\Filament\Resources\Quotes\Pages\EditQuote;
use App\Filament\Resources\Quotes\Pages\ListQuotes;
use App\Filament\Resources\Quotes\Pages\ViewQuote;
use App\Models\QuoteRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuoteResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Ajánlatkérések';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Ajánlat';

    protected static ?string $pluralModelLabel = 'Ajánlatok';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', ['quote_issued', 'ordered', 'postponed']);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'quote_issued')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
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
            'index' => ListQuotes::route('/'),
            'view' => ViewQuote::route('/{record}'),
            'edit' => EditQuote::route('/{record}/edit'),
        ];
    }
}
