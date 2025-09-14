<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
       


        <title>{{ config('app.name', 'Akademik') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="font-sans antialiased">
      
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <!-- COURSE NOTIFICATION -->
                @if(session('status') === 'course-created')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Course created successfully.') }}
                    </p>
                @endif
                @if(session('status') === 'course-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Course updated successfully.') }}
                    </p>
                @endif
                @if(session('status') === 'course-deleted')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Course deleted successfully.') }}
                    </p>
                @endif

                <!-- STUDENT NOTIFICATION -->
                @if(session('status') === 'student-created')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Student added successfully.') }}
                    </p>
                @endif
                @if(session('status') === 'student-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Student updated successfully.') }}
                    </p>
                @endif
                @if(session('status') === 'student-deleted')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Student deleted successfully.') }}
                    </p>
                @endif

                <!-- ENROLL NOTIFICATION -->
                @if(session('status') === 'enrolled')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Course enrolled successfully.') }}
                    </p>
                @endif

                <!-- PROFILE NOTIFICATION -->
                @if(session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Profile updated successfully.') }}
                    </p>
                @endif
                @if(session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 px-4 py-2 rounded text-center mx-auto"
                        style="width: fit-content;"
                    >
                        {{ __('Password updated successfully.') }}
                    </p>
                @endif
                
                <!-- SLOT -->
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
