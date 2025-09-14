<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Edit Course') }}
                    </h2>

                    <form method="POST" action="{{ route('courses.update', $course) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Course name --}}
                        <div>
                            <x-input-label for="course_name" :value="__('Course Name')" />
                            <x-text-input id="course_name" name="course_name" type="text"
                                class="mt-1 block w-full"
                                :value="old('course_name', $course->course_name)" required autofocus autocomplete="course_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('course_name')" />
                        </div>

                        {{-- Credits --}}
                        <div>
                            <x-input-label for="credits" :value="__('Credits')" />
                            <x-text-input id="credits" name="credits" type="number"
                                class="mt-1 block w-full"
                                :value="old('credits', $course->credits)" required autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('credits')" />
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Course') }}</x-primary-button>
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
