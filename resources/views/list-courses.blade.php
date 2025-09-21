<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- ================= ALL COURSES ================= --}}
                    <h3 class="text-xl font-semibold mt-8 mb-2">All Courses</h3>
                    <div class="mb-2 flex items-center gap-2">
                        <form method="GET" action="{{ route('dashboard.user') }}" class="ml-auto flex gap-2">
                            <input type="text" name="course_search" value="{{ $courseSearch ?? '' }}" placeholder="Search courses..." class="rounded px-2 py-1 border bg-white text-black focus:ring focus:ring-blue-300" />
                            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Search</button>
                        </form>
                    </div>
                    <table class="w-full mb-2 border-collapse border border-gray-900 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                @php
                                    $courseOrderNext = $courseOrder === 'asc' ? 'desc' : 'asc';
                                @endphp
                                <th class="border px-2 py-1">
                                    <a href="{{ route('dashboard.user', array_merge(request()->except('courses'), ['course_sort' => 'course_name', 'course_order' => $courseSort === 'course_name' ? $courseOrderNext : 'asc'])) }}">
                                        Name {!! $courseSort === 'course_name' ? ($courseOrder === 'asc' ? '▲' : '▼') : '' !!}
                                    </a>
                                </th>
                                <th class="border px-2 py-1">
                                    <a href="{{ route('dashboard.user', array_merge(request()->except('courses'), ['course_sort' => 'credits', 'course_order' => $courseSort === 'credits' ? $courseOrderNext : 'asc'])) }}">
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
                                    @if(in_array($course->course_id, $enrolledCourseIds))
                                        <x-secondary-button>Enrolled</x-secondary-button>
                                    @else
                                        <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                            @csrf
                                            <x-primary-button>Enroll</x-primary-button>
                                        </form>
                                    @endif
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