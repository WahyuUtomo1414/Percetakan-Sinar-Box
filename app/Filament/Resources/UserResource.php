<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Role;
use App\Models\User;
use Filament\Tables;
use App\Models\Status;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Users Management';
    protected static ?string $navigationLabel = 'Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->tel()
                    ->label('Phone Number')
                    ->required()
                    ->maxLength(16),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('address')
                    ->maxLength(255)
                    ->label('Address')
                    ->columnSpanFull(),
                Select::make('role_id')
                    ->required()
                    ->label('Role')
                    ->columnSpanFull()
                    ->default(2)
                    ->disabled(fn () => auth()->user()?->role_id === 2)
                    ->options(Role::all()->pluck('name', 'id')),
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->searchable()
                    ->default(1)
                    ->disabled(fn () => auth()->user()?->role_id === 2)
                    ->columnSpanFull()
                    ->options(Status::where('status_type_id', 1)->pluck('name', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('WhatsApp / Phone Number')
                    ->formatStateUsing(function ($state) {
                        // Ubah 08xxxx menjadi 628xxxx
                        return preg_replace('/^0/', '62', $state);
                    })
                    ->url(fn ($state) => 'https://wa.me/' . preg_replace('/^0/', '62', $state), true)
                    ->color('info')
                    ->openUrlInNewTab()
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('role.name')
                    ->sortable(),
                TextColumn::make('status.name')
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Created By'),
                TextColumn::make('updatedBy.name')
                    ->label("Updated by"),
                TextColumn::make('deletedBy.name')
                    ->label("Deleted by"),
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
                Tables\Actions\DeleteAction::make()
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
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // method untuk memfilter data berdasarkan user yang sedang login
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);

        if (Auth::check() && Auth::user()->role_id == 2) {
            // Jika role_id = 2, hanya tampilkan data user yang sedang login
            $query->where('id', Auth::id());
        }
        // Jika role_id = 1, tampilkan semua data

        return $query;
    }
}
