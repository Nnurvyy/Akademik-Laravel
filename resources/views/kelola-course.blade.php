<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- ================= COURSES ================= --}}
                    <h3 class="text-xl font-semibold mt-8 mb-2 ">Courses</h3>
                    <div class="mb-2 flex items-center gap-2">
                        <a href="{{ route('courses.create') }}">
                            <x-primary-button>Add Course</x-primary-button>
                        </a>
                        <form method="GET" action="{{ route('dashboard.admin') }}" class="ml-auto flex gap-2">
                            <input type="text" name="course_search" value="{{ $courseSearch }}" placeholder="Search courses..." class="rounded px-2 py-1 border bg-white text-black focus:ring focus:ring-blue-300" />
                            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Search</button>
                        </form>
                    </div>

                    <table class="w-full mb-2 border-collapse border border-gray-600 dark:border-gray-900">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                @php
                                    $courseOrderNext = $courseOrder === 'asc' ? 'desc' : 'asc';
                                @endphp
                                <th class="border px-2 py-1">
                                    <a href="{{ route('dashboard.admin', array_merge(request()->except('courses'), ['course_sort' => 'course_name', 'course_order' => $courseSort === 'course_name' ? $courseOrderNext : 'asc'])) }}">
                                        Name {!! $courseSort === 'course_name' ? ($courseOrder === 'asc' ? '▲' : '▼') : '' !!}
                                    </a>
                                </th>
                                <th class="border px-2 py-1">
                                    <a href="{{ route('dashboard.admin', array_merge(request()->except('courses'), ['course_sort' => 'credits', 'course_order' => $courseSort === 'credits' ? $courseOrderNext : 'asc'])) }}">
                                        Credits {!! $courseSort === 'credits' ? ($courseOrder === 'asc' ? '▲' : '▼') : '' !!}
                                    </a>
                                </th>
                                <th class="border px-2 py-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                            <tr>
                                <td class="border px-2 py-1">{{ $course->course_name }}</td>
                                <td class="border px-2 py-1 text-center">{{ $course->credits }}</td>
                                <td class="border px-2 py-1 flex justify-center gap-2">
                                    <a href="{{ route('courses.edit', $course) }}">
                                        <x-secondary-button>Edit</x-secondary-button>
                                    </a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button>Delete</x-danger-button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $courses->links() }}
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
