<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- ================= STUDENTS ================= --}}
                    <h3 class="text-xl font-semibold mt-8 mb-2">Students</h3>
                    <div class="mb-2 flex items-center gap-2">
                        <a href="{{ route('students.create') }}">
                            <x-primary-button>Add Student</x-primary-button>
                        </a>
                        <form method="GET" action="{{ route('dashboard.admin') }}" class="ml-auto flex gap-2">
                            <input type="text" name="student_search" value="{{ $studentSearch }}" placeholder="Search students..." class="rounded px-2 py-1 border bg-white text-black focus:ring focus:ring-blue-300" />
                            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Search</button>
                        </form>
                    </div>

                    <div style="min-height: 320px">
                        <table class="w-full mb-2 border-collapse border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-900">
                                <tr>
                                    @php
                                        $studentOrderNext = $studentOrder === 'asc' ? 'desc' : 'asc';
                                    @endphp
                                    <th class="border px-2 py-1">
                                        <a href="{{ route('dashboard.admin', array_merge(request()->except('students'), ['student_sort' => 'username', 'student_order' => $studentSort === 'username' ? $studentOrderNext : 'asc'])) }}">
                                            Username {!! $studentSort === 'username' ? ($studentOrder === 'asc' ? '▲' : '▼') : '' !!}
                                        </a>
                                    </th>
                                    <th class="border px-2 py-1">
                                        <a href="{{ route('dashboard.admin', array_merge(request()->except('students'), ['student_sort' => 'full_name', 'student_order' => $studentSort === 'full_name' ? $studentOrderNext : 'asc'])) }}">
                                            Full Name {!! $studentSort === 'full_name' ? ($studentOrder === 'asc' ? '▲' : '▼') : '' !!}
                                        </a>
                                    </th>
                                    <th class="border px-2 py-1">Email</th>
                                    <th class="border px-2 py-1">
                                        <a href="{{ route('dashboard.admin', array_merge(request()->except('students'), ['student_sort' => 'entry_year', 'student_order' => $studentSort === 'entry_year' ? $studentOrderNext : 'asc'])) }}">
                                            Entry Year {!! $studentSort === 'entry_year' ? ($studentOrder === 'asc' ? '▲' : '▼') : '' !!}
                                        </a>
                                    </th>
                                    <th class="border px-2 py-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td class="border px-2 py-1">{{ $student->user->username }}</td>
                                    <td class="border px-2 py-1">{{ $student->user->full_name }}</td>
                                    <td class="border px-2 py-1">{{ $student->user->email }}</td>
                                    <td class="border px-2 py-1 text-center">{{ $student->entry_year }}</td>
                                    <td class="border px-2 py-1 flex justify-center gap-2">
                                        <a href="{{ route('students.edit', $student) }}">
                                            <x-secondary-button>Edit</x-secondary-button>
                                        </a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button>Delete</x-danger-button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $students->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
