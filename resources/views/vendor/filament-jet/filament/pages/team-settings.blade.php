<x-filament::page>
    <x-filament-jet-form-section submit="updateTeamName">
        <x-slot name="title">
            {{ __('filament-jet::teams/name.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('filament-jet::teams/name.description') }}
        </x-slot>

        <x-slot name="form">
            <!-- Team Owner Information -->
            @if($team->owner)  {{-- Temporarily solve the problem of team owner not found, after deleting a team, before the redirect --}}
                <div class="col-span-6">
                    <div class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        {{ __('filament-jet::teams/name.team_owner.label') }}
                    </div>

                    <div class="flex items-center mt-2">
                        <x-filament-jet-user-avatar :src="$team->owner->profile_photo_url" :size="'lg'" />

                        <div class="ml-4 leading-tight">
                            <div>{{ $team->owner->name }}</div>
                            <div class="text-gray-700 text-sm dark:text-gray-300">{{ $team->owner->email }}</div>
                        </div>
                    </div>
                </div>
            @endif

            {{ $this->updateTeamNameForm }}
        </x-slot>

        @if(\Illuminate\Support\Facades\Gate::check('update', $team))
            <x-slot name="actions">
                <x-filament::button type="submit">
                    {{ __('filament-jet::teams/name.buttons.save') }}
                </x-filament::button>
            </x-slot>
        @endif
    </x-filament-jet-form-section>

    @if (Gate::check('addTeamMember', $team))
        <x-filament-jet-section-border />

        <x-filament-jet-form-section submit="addTeamMember">
            <x-slot name="title">
                {{ __('filament-jet::teams/add-member.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-jet::teams/add-member.description') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    <div class="max-w-xl text-sm text-gray-600 dark:text-white">
                        {{ __('filament-jet::teams/add-member.note') }}
                    </div>
                </div>

                {{ $this->addTeamMemberForm }}
            </x-slot>

            <x-slot name="actions">
                <x-filament::button type="submit">
                    {{ __('filament-jet::teams/add-member.buttons.save') }}
                </x-filament::button>
            </x-slot>
        </x-filament-jet-form-section>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
        <x-filament-jet-section-border />

        <!-- Team Member Invitations -->
        <div class="mt-10 sm:mt-0">
            <x-filament-jet-action-section>
                <x-slot name="title">
                    {{ __('filament-jet::teams/invitations.title') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('filament-jet::teams/invitations.description') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->teamInvitations as $invitation)
                            <div class="flex items-center justify-between">
                                <div class="text-gray-600 dark:text-gray-300">{{ $invitation->email }}</div>

                                <div class="flex items-center">
                                    @if (Gate::check('removeTeamMember', $team))
                                        <!-- Cancel Team Invitation -->
                                        <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                            {{ __('filament-jet::teams/invitations.buttons.cancel') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-filament-jet-action-section>
        </div>
    @endif

    @if ($team->users->isNotEmpty())
        <x-filament-jet-section-border />

        <!-- Manage Team Members -->
        <div class="mt-10 sm:mt-0">
            <x-filament-jet-action-section>
                <x-slot name="title">
                    {{ __('filament-jet::teams/members.title') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('filament-jet::teams/members.description') }}
                </x-slot>

                <!-- Team Member List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->users->sortBy('name') as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                    <div class="ml-4">{{ $user->name }}</div>
                                </div>

                                <div class="flex items-center">
                                    <!-- Manage Team Member Role -->
                                    @if (Gate::check('addTeamMember', $team) && \Mstfkhazaal\FilamentJet\FilamentJet::hasRoles())
                                        <button class="ml-2 text-sm text-gray-400 underline" wire:click="manageRole('{{ $user->id }}')">
                                            {{ \Mstfkhazaal\FilamentJet\FilamentJet::findRole($user->membership->role)->name }}
                                        </button>
                                    @elseif (\Mstfkhazaal\FilamentJet\FilamentJet::hasRoles())
                                        <div class="ml-2 text-sm text-gray-400">
                                            {{ \Mstfkhazaal\FilamentJet\FilamentJet::findRole($user->membership->role)->name }}
                                        </div>
                                    @endif

                                    <!-- Leave Team -->
                                    @if ($this->user->id === $user->id)
                                        <button class="cursor-pointer ml-4 text-sm text-red-500" wire:click="leaveTeam">
                                            {{ __('Leave') }}
                                        </button>

                                        <!-- Remove Team Member -->
                                    @elseif (Gate::check('removeTeamMember', $team))
                                        <button class="cursor-pointer ml-4 text-sm text-red-500" wire:click="removeTeamMember('{{ $user->id }}')">
                                            {{ __('Remove') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-filament-jet-action-section>
        </div>
    @endif

    @if(\Illuminate\Support\Facades\Gate::check('delete', $team) && ! $team->personal_team)
        <x-filament-jet-section-border />

        <x-filament-jet-action-section>
            <x-slot name="title">
                {{ __('filament-jet::teams/delete.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-jet::teams/delete.description') }}
            </x-slot>

            <x-slot name="content">
                <div class="max-w-xl text-sm text-gray-600 dark:text-white">
                    {{ __('filament-jet::teams/delete.note') }}
                </div>

                <div class="mt-5 text-right">
                    {{ $this->getCachedAction('delete_team') }}
                </div>
            </x-slot>
        </x-filament-jet-action-section>
    @endif
</x-filament::page>
