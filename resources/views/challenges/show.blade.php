<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Challenge #{{ $challenge->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Challenge Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm text-gray-500 mb-2">Tạo bởi: {{ $challenge->teacher->name }} &bull; {{ $challenge->created_at->format('d/m/Y H:i') }}</p>

                    <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                        <h3 class="font-semibold text-indigo-800 mb-2">Gợi ý</h3>
                        <p class="text-indigo-700 whitespace-pre-line">{{ $challenge->hint }}</p>
                    </div>

                    @if(Auth::user()->isTeacher())
                        <div class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <p class="text-sm text-gray-600"><strong>Đáp án:</strong> {{ $challenge->getAnswer() ?? 'Không tìm thấy file' }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Student Guess Form -->
            @if(Auth::user()->isStudent())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Nhập đáp án</h3>

                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('correct'))
                            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <p class="text-green-700 font-semibold mb-2">🎉 Chính xác! Đây là nội dung file:</p>
                                <div class="mt-2 p-4 bg-white border border-green-300 rounded-lg">
                                    <pre class="text-sm text-gray-700 whitespace-pre-wrap font-mono">{{ session('file_content') }}</pre>
                                </div>
                            </div>
                        @else
                            <form method="POST" action="{{ route('challenges.guess', $challenge) }}">
                                @csrf
                                <div class="flex gap-3 items-end">
                                    <div class="flex-grow">
                                        <x-input-label for="answer" :value="__('Đáp án (tên file)')" />
                                        <x-text-input id="answer" name="answer" type="text" class="mt-1 block w-full"
                                            :value="old('answer')" required autofocus
                                            placeholder="VD: bai tho mua xuan" />
                                        <x-input-error class="mt-2" :messages="$errors->get('answer')" />
                                    </div>
                                    <x-primary-button>Trả lời</x-primary-button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            <div class="flex">
                <a href="{{ route('challenges.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    ← Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
