<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết bài tập') }}: {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Assignment Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $assignment->title }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Giáo viên: {{ $assignment->teacher->name }} &bull; {{ $assignment->created_at->format('d/m/Y H:i') }}</p>

                    @if($assignment->description)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-line">{{ $assignment->description }}</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('assignments.download', $assignment) }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition">
                            Tải file: {{ $assignment->original_name }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Student: Submit work -->
            @if(Auth::user()->isStudent())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Nộp bài làm</h3>

                        @if($mySubmission)
                            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-700">
                                    Bạn đã nộp bài: <strong>{{ $mySubmission->original_name }}</strong>
                                    <span class="text-blue-500">({{ $mySubmission->updated_at->format('d/m/Y H:i') }})</span>
                                </p>
                                <p class="text-xs text-blue-500 mt-1">Upload lại để cập nhật bài làm.</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('submissions.store', $assignment) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="flex gap-3 items-end">
                                <div class="flex-grow">
                                    <x-input-label for="file" :value="__('Chọn file bài làm')" />
                                    <input type="file" id="file" name="file" required
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <x-input-error class="mt-2" :messages="$errors->get('file')" />
                                </div>
                                <x-primary-button>{{ $mySubmission ? 'Cập nhật' : 'Nộp bài' }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Teacher: View Submissions -->
            @if(Auth::user()->isTeacher() && $submissions && $submissions->count() >= 0 && $assignment->teacher_id === Auth::id())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Danh sách bài nộp ({{ $submissions->count() }})</h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sinh viên</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thời gian</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tải về</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($submissions as $index => $submission)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $submission->student->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $submission->original_name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $submission->updated_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                <a href="{{ route('submissions.download', $submission) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium">Tải về</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Chưa có bài nộp.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex">
                <a href="{{ route('assignments.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    ← Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
