<x-filament::page>
    <x-slot name="header">
        {{ __('filament-jet::account/account.title') }}
    </x-slot>
    <x-slot name="subtitle">
       ss
    </x-slot>
    @if(\Mstfkhazaal\FilamentJet\Features::canUpdateProfileInformation())
        <x-filament-jet-form-section submit="updateProfileInformation">
            <x-slot name="title">
                {{ __('filament-jet::account/update-information.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-jet::account/update-information.description') }}
            </x-slot>

            <x-slot name="form">
                {{ $this->updateProfileInformationForm }}
            </x-slot>

            <x-slot name="actions">
                <x-filament::button type="submit" icon="heroicon-o-identification">
                    {{ __('filament-jet::account/update-information.buttons.save') }}
                </x-filament::button>
            </x-slot>
        </x-filament-jet-form-section>
    @endif

    @if(\Mstfkhazaal\FilamentJet\Features::enabled(\Mstfkhazaal\FilamentJet\Features::updatePasswords()))
        <x-filament::hr />

        <x-filament-jet-form-section submit="updatePassword">
            <x-slot name="title">
                {{ __('filament-jet::account/update-password.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-jet::account/update-password.description') }}
            </x-slot>

            <x-slot name="form">
                {{ $this->updatePasswordForm }}
            </x-slot>

            <x-slot name="actions">
                <x-filament::button type="submit" icon="heroicon-o-lock-closed">
                    {{ __('filament-jet::account/update-password.buttons.save') }}
                </x-filament::button>
            </x-slot>
        </x-filament-jet-form-section>
    @endif

    @if(\Mstfkhazaal\FilamentJet\Features::canManageTwoFactorAuthentication())
        @php
            $user = $this->user;
            $hasEnabledTwoFactorAuthentication = $user->hasEnabledTwoFactorAuthentication();
            $hasConfirmedTwoFactorAuthentication = $user->hasConfirmedTwoFactorAuthentication();
            $showingQrCode = $this->showingQrCode;
        @endphp

        <x-filament::hr />

        <x-filament-jet-action-section>
            <x-slot name="title">
                {{ __('filament-jet::account/two-factor.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-jet::account/two-factor.description') }}
            </x-slot>

            <x-slot name="content">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    @if ($this->enabled)
                        @if ($showingConfirmation)
                            {{ __('filament-jet::account/two-factor.finish_enabling.title') }}
                        @else
                            {{ __('filament-jet::account/two-factor.enabled.title') }}
                        @endif
                    @else
                        {{ __('filament-jet::account/two-factor.disabled.title') }}
                    @endif
                </h3>

                <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-300">
                    <p>
                        {{ __('filament-jet::account/two-factor.note') }}
                    </p>
                </div>

                @if($this->enabled)
                    @if ($showingQrCode)
                        <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-300">
                            <p class="font-semibold">
                                @if($showingConfirmation)
                                    {{ __('filament-jet::account/two-factor.finish_enabling.description') }}
                                @else
                                    {{ __('filament-jet::account/two-factor.enabled.description') }}
                                @endif
                            </p>
                        </div>

                        <div class="mt-2">
                            {!! $this->user->twoFactorQrCodeSvg() !!}

                            <x-filament-jet-two-factor-security-code :code="decrypt($this->user->two_factor_secret)" />
                        </div>
                    @endif

                    @if($showingRecoveryCodes)
                        <hr class="my-3"/>
                        <p class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-300">{{ __('filament-jet::account/two-factor.enabled.store_codes') }}</p>

                        <div class="space-y-2">
                            @foreach (json_decode(decrypt($user->two_factor_recovery_codes), true) as $code)
                                <span class="inline-flex items-center p-2 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $code }}</span>
                            @endforeach
                        </div>

                        {{ $this->getCachedAction('regenerate_recovery_codes') }}
                    @endif
                @endif

                <x-slot name="actions">
                    @if($hasConfirmedTwoFactorAuthentication)
                        <div class="flex items-center justify-between">
                            @if(! $showingRecoveryCodes)
                                {{ $this->getCachedAction('showing_recovery_codes') }}
                            @else
                                {{ $this->getCachedAction('hide_recovery_codes') }}
                            @endif

                            {{ $this->getCachedAction('disable2fa') }}
                        </div>
                    @elseif($showingConfirmation)
                        <form wire:submit.prevent="confirmTwoFactorAuthentication">
                            <div class="flex items-center justify-between">

                                <div>{{ $this->confirmTwoFactorForm }}</div>

                                <div class="mt-5">
                                    <x-filament::button type="submit">
                                        {{ __('filament-jet::account/two-factor.buttons.confirm_finish') }}
                                    </x-filament::button>

                                    <x-filament::button color="secondary" wire:click="disableTwoFactorAuthentication">
                                        {{ __('filament-jet::account/two-factor.buttons.cancel_setup') }}
                                    </x-filament::button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="text-right">
                            {{ $this->getCachedAction('enable2fa') }}
                        </div>
                    @endif
                </x-slot>
            </x-slot>
        </x-filament-jet-action-section>
    @endif

    @if(\Mstfkhazaal\FilamentJet\Features::canLogoutOtherBrowserSessions())
        <x-filament::hr />

        <x-filament-jet-action-section>
            <x-slot name="title">
                {{ __('filament-jet::account/browser-sessions.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-jet::account/browser-sessions.description') }}
            </x-slot>

            <x-slot name="content">
                <div class="max-w-xl text-sm text-gray-600 dark:text-white">
                    {{ __('filament-jet::account/browser-sessions.heading') }}
                </div>

                @livewire(\Mstfkhazaal\FilamentJet\Http\Livewire\LogoutOtherBrowserSessions::class)

                <x-slot name="actions">
                    <div class="text-right">
                        {{ $this->getCachedAction('logout_other_browser_sessions') }}
                    </div>
                </x-slot>
            </x-slot>
        </x-filament-jet-action-section>
    @endif

    @if(\Mstfkhazaal\FilamentJet\Features::hasAccountDeletionFeatures())
        <x-filament::hr />

        <x-filament-jet-action-section>
            <x-slot name="title">
                {{ __('filament-jet::account/delete-account.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-jet::account/delete-account.description') }}
            </x-slot>

            <x-slot name="content">
                <div class="max-w-xl text-sm text-gray-600 dark:text-white">
                    {{ __('filament-jet::account/delete-account.warning') }}
                </div>

                <x-slot name="actions">
                    <div class="text-right">
                        {{ $this->getCachedAction('delete_account') }}
                    </div>
                </x-slot>
            </x-slot>
        </x-filament-jet-action-section>
    @endif

    @if(\Mstfkhazaal\FilamentJet\Features::canExportPersonalData())
        <x-filament::hr />

        <x-filament-jet-action-section>
            <x-slot name="title">
                {{ __('filament-jet::account/export-personal-data.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-jet::account/export-personal-data.description') }}
            </x-slot>

            <x-slot name="content">
                <div class="max-w-xl text-sm text-gray-600 dark:text-white">
                    {{ __('filament-jet::account/export-personal-data.warning') }}
                </div>

                <x-slot name="actions">
                    <div class="text-right">
                        @if($this->exportBatch)
                            <div wire:poll="updateExportProgress">
                                <x-filament-jet-progress-bar :percentage="$this->exportProgress" />

                                @if($this->exportProgress == 100)
                                    <div class="mt-4">
                                        {{ $this->getCachedAction('download_personal_data') }}
                                    </div>
                                @endif
                            </div>
                        @else
                            {{ $this->getCachedAction('export_personal_data') }}
                        @endif
                    </div>
                </x-slot>
            </x-slot>
        </x-filament-jet-action-section>
    @endif
</x-filament::page>
