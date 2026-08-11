<?php

namespace App\Filament\Resources\Solutions;

use App\Filament\Resources\Solutions\Pages\CreateSolution;
use App\Filament\Resources\Solutions\Pages\EditSolution;
use App\Filament\Resources\Solutions\Pages\ListSolutions;
use App\Filament\Resources\Solutions\Pages\ViewSolution;
use App\Filament\Resources\Solutions\RelationManagers\ProjectsRelationManager;
use App\Filament\Resources\Solutions\Schemas\SolutionForm;
use App\Filament\Resources\Solutions\Schemas\SolutionInfolist;
use App\Filament\Resources\Solutions\Tables\SolutionsTable;
use App\Models\Solution;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|\UnitEnum|null $navigationGroup = 'Tartalom';

    protected static ?string $modelLabel = 'Iparági megoldás';

    protected static ?string $pluralModelLabel = 'Megoldások';

    public static function form(Schema $schema): Schema
    {
        return SolutionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SolutionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SolutionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProjectsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSolutions::route('/'),
            'create' => CreateSolution::route('/create'),
            'view' => ViewSolution::route('/{record}'),
            'edit' => EditSolution::route('/{record}/edit'),
        ];
    }
}
