<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->required(),

                Select::make('role')
                    ->options(UserRole::class),

                Select::make('company_id')
                    ->relationship('company', 'name'),

                TextEntry::make('email_verified_at')
                    ->label('Email Verified')
                    ->dateTime(),

                TextInput::make('password')
                    ->password()
                    ->visibleOn('create')
                    ->required(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->dateTime(),
            ]);
    }
}
