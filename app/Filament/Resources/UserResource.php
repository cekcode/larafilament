<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\PermissionsRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->label('Email Address')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
                        ->minLength(8)
                        ->same('passwordConfirmation')
                        ->dehydrated(fn ($state) => filled($state))
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    TextInput::make('passwordConfirmation')
                        ->label('Password Confirmation')
                        ->password()
                        ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
                        ->minLength(8)
                        ->dehydrated(false),
                    Select::make('roles')
                        ->multiple()
                        ->relationship('roles', 'name')->preload()->hidden(!auth()->user()->hasRole('admin')),
                    Select::make('permission')
                        ->multiple()
                        ->relationship('permissions', 'name')->preload()->hidden(!auth()->user()->hasRole('admin'))
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->getStateUsing(
                    static function (stdClass $rowLoop, HasTable $livewire): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->tableRecordsPerPage * ($livewire->page - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('name')->limit(50)->sortable()->searchable(),
                TextColumn::make('email')->limit(50)->searchable(),
                TextColumn::make('roles.name'),
                TextColumn::make('updated_at')->limit(50)->sortable()->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
