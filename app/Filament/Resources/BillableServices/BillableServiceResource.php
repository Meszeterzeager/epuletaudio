<?php

namespace App\Filament\Resources\BillableServices;

use App\Filament\Resources\BillableServices\Pages\CreateBillableService;
use App\Filament\Resources\BillableServices\Pages\EditBillableService;
use App\Filament\Resources\BillableServices\Pages\ListBillableServices;
use App\Filament\Resources\BillableServices\Schemas\BillableServiceForm;
use App\Filament\Resources\BillableServices\Tables\BillableServicesTable;
use App\Models\BillableService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BillableServiceResource extends Resource
{
    protected static ?string $model = BillableService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|\UnitEnum|null $navigationGroup = 'Beszállítók';

    protected static ?string $modelLabel = 'Szolgáltatás díjtétel';

    protected static ?string $pluralModelLabel = 'Szolgáltatások';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return BillableServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BillableServicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBillableServices::route('/'),
            'create' => CreateBillableService::route('/create'),
            'edit' => EditBillableService::route('/{record}/edit'),
        ];
    }
}
