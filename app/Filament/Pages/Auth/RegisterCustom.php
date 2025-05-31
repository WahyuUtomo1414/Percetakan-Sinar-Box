<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register as AuthRegister;
use Filament\Pages\Page;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class RegisterCustom extends AuthRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneNumberFormComponent(),
                        $this->getAdreessFormComponent(),
                        $this->getRoleFormComponent(),
                        $this->getStatusFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getPhoneNumberFormComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label(__('Phone Number'))
            ->required()
            ->maxLength(16)
            ->tel()
            ->autofocus();
    }

    protected function getAdreessFormComponent(): Component
    {
        return Textarea::make('address')
            ->label(__('Address'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getRoleFormComponent(): Component
    {
        return Hidden::make('role_id')
            ->label(__('Role'))
            ->default(2)
            ->autofocus();
    }

    protected function getStatusFormComponent(): Component
    {
        return Hidden::make('status_id')
            ->label(__('STatus'))
            ->default(1)
            ->autofocus();
    }
}
