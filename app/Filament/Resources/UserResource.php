<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Degree;
use App\Models\Job;
use App\Models\Nationality;
use App\Models\Position;
use App\Models\Qualification;
use App\Models\Status;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(191)
                        ->label('البريد الالكتروني'),
                    Forms\Components\TextInput::make('gender')
                        ->required()
                        ->label('النوع'),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(15)->label('رقم الهاتف'),
                    Forms\Components\FileUpload::make('photo'),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->maxLength(191)
                        ->dehydrateStateUsing(fn(string $state): string => bcrypt($state))
                        ->default('123456'),//$2y$10$ymU.94CThqb.YlhVFRDBB.Z0xK0JX7cWBpPADkaKoC3Zpa7aBEv86
                    Forms\Components\DatePicker::make('join_date')
                        ->native(false)
                        ->displayFormat('d/m/Y'),
                    Forms\Components\DatePicker::make('birth_date')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->default(now()),
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
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('qualification.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nationality_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('branch.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('job.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('team.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('position.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('degree.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
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
                Tables\Filters\TrashedFilter::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            //'view' => Pages\ViewUser::route('/{record}'),
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
            TextEntry::make('name'),
            TextEntry::make('branch.name'),
            TextEntry::make('team.name'),
            TextEntry::make('job.name'),
            TextEntry::make('Category.name'),
            ImageEntry::make('photo')->square(),
        ])->columns(3);
    }
}
