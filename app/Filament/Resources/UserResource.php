<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\BranchRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\TeamRelationManager;
use App\Models\Branch;
use App\Models\Job;
use App\Models\Nationality;
use App\Models\Position;
use App\Models\Qualification;
use App\Models\Team;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'متطوع';
    protected static ?string $pluralLabel = 'المتطوعين';
    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->name;
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['branch', 'category']);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'الفرع' => $record->branch?->name,
            'التصنيف' => $record->category?->name,
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return UserResource::getUrl('view', ['record' => $record]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الشخصية')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->numeric()->required()->label('كود'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(191)
                            ->label('الاسم'),
                        Forms\Components\TextInput::make('address')
                            ->maxLength(191)
                            ->required()
                            ->label('العنوان'),
                        Forms\Components\FileUpload::make('photo')->label('الصورة'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(191)
                            ->label('البريد الالكتروني'),
                        Forms\Components\Select::make('gender')
                            ->options(['male' => 'ذكر', 'female' => 'انثي'])
                            ->required()
                            ->label('النوع'),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(15)
                            ->label('رقم الهاتف'),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->maxLength(191)
                            ->dehydrateStateUsing(fn(string $state): string => bcrypt($state))
                            ->default('123456')//$2y$10$ymU.94CThqb.YlhVFRDBB.Z0xK0JX7cWBpPADkaKoC3Zpa7aBEv86
                            ->label('الرقم السري'),
                        Forms\Components\DatePicker::make('join_date')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->label('تاريخ الانضمام'),
                        Forms\Components\DatePicker::make('birth_date')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->label('تاريخ الميلاد'),
                    ])->columns(4),


                Forms\Components\RichEditor::make('comment')
                    ->columnSpanFull()->label('ملاحظات'),
                Forms\Components\TextInput::make('national_id')->required()->label('الرقم القومي'),
                Forms\Components\Select::make('nationality_id')->label('الجنسية')->options(Nationality::pluck('name', 'id'))->required(),
                Forms\Components\Select::make('marital_status_id')->label('الحالة الاجتماعية')->options(Nationality::pluck('name', 'id'))->required(),
                Forms\Components\Select::make('qualification_id')->label('المؤهل')->options(Qualification::pluck('name', 'id'))->required(),
                Forms\Components\Select::make('branch_id')->label('الفرع')->options(Branch::pluck('name', 'id'))->required(),
                Forms\Components\Select::make('job_id')->label('النشاط')->options(Job::pluck('name', 'id'))->required(),
                Forms\Components\Select::make('team_id')->label('اللجنة')->options(Team::pluck('name', 'id'))->required(),
                Forms\Components\Select::make('position_id')->label('الوظيفة')->options(Position::pluck('name', 'id'))->required(),
                Forms\Components\Select::make('status_id')->label('الحالة')->relationship(name: 'status', titleAttribute: 'name')->required()->createOptionForm([
                    TextInput::make('name')->required()->label('name')
                ]),
                Forms\Components\Select::make('category_id')
                    ->relationship(name: 'category', titleAttribute: 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required()
                    ])->label('التصنيف'),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('gender')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone'),
                ImageColumn::make('photo')->disk('public')->circular(),
                Tables\Columns\TextColumn::make('join_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('national.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('marital_status.name')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('qualification.name')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nationality_id')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('branch.name')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('job.name')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('team.name')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('position.name')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('degree.name')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status_id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.name')
                    ->default('')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('role')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('branch')
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload()
                    ->label('الفرع'),
                Tables\Filters\SelectFilter::make('team')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload()
                    ->label('اللجنة'),
                Tables\Filters\SelectFilter::make('job')
                    ->relationship('job', 'name')
                    ->searchable()
                    ->preload()
                    ->label('النشاط'),
                Tables\Filters\Filter::make('تاريخ الانضمام')->form([
                    Forms\Components\DatePicker::make('from'),
                    Forms\Components\DatePicker::make('to'),
                ])->query(function (Builder $query, array   $data): Builder {
                    return $query->when(
                        $data['from'],
                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    )->when(
                        $data['to'],
                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    );
                }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BranchRelationManager::class,
            TeamRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            ImageEntry::make('photo')->square()->label('الصورة'),
            TextEntry::make('name')->label('الاسم'),
            TextEntry::make('branch.name')->label('اسم الفرع'),
            TextEntry::make('team.name')->label('اسم اللجنة'),
            TextEntry::make('job.name')->label('اسم النشاط'),
            TextEntry::make('Category.name')->label('التصنيف'),
            TextEntry::make('comment')->label('ملاحظات')->columnSpanFull()->Html(),
        ])->columns(3);
    }
}
