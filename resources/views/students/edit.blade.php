<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Edit Student') }}
                    </h2>

                    <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Username --}}
                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" name="username" type="text"
                                class="mt-1 block w-full"
                                :value="old('username', $student->user->username)" required autofocus autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('username')" />
                        </div>

                        {{-- Full Name --}}
                        <div>
                            <x-input-label for="full_name" :value="__('Full Name')" />
                            <x-text-input id="full_name" name="full_name" type="text"
                                class="mt-1 block w-full"
                                :value="old('full_name', $student->user->full_name)" required autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email"
                                class="mt-1 block w-full"
                                :value="old('email', $student->user->email)" required autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-password-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        {{-- Entry Year --}}
                        <div>
                            <x-input-label for="entry_year" :value="__('Entry Year')" />
                            <x-text-input id="entry_year" name="entry_year" type="number"
                                class="mt-1 block w-full"
                                :value="old('entry_year', $student->entry_year)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('entry_year')" />
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Student') }}</x-primary-button>
                            <a href="{{ route('dashboard') }}">
                                <x-secondary-button type="button">{{ __('Cancel') }}</x-secondary-button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
