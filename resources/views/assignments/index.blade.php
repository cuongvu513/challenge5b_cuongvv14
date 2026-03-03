<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Danh sách bài tập') }}
            </h2>
            @if(Auth::user()->isTeacher())
                <a href="{{ route('assignments.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    + Tạo bài tập
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($assignments as $assignment)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $assignment->title }}</h3>
                                <span class="text-xs text-gray-400">{{ $assignment->created_at->format('d/m/Y') }}</span>
                            </div>
                            @if($assignment->description)
                                <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $assignment->description }}</p>
                            @endif
                            <p class="mt-2 text-xs text-gray-400">Giáo viên: {{ $assignment->teacher->name }}</p>
                            <p class="mt-1 text-xs text-gray-400">File: {{ $assignment->original_name }}</p>

                            <div class="mt-4 flex gap-3">
                                <a href="{{ route('assignments.download', $assignment) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition">
                                    Tải file
                                </a>
                                <a href="{{ route('assignments.show', $assignment) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-md hover:bg-indigo-700 transition">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Chưa có bài tập nào.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
