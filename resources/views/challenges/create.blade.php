<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo Challenge mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h4 class="font-semibold text-yellow-800 text-sm">Hướng dẫn</h4>
                        <ul class="mt-2 text-sm text-yellow-700 space-y-1">
                            <li>• Upload file .txt chứa nội dung (bài thơ, văn,...)</li>
                            <li>• Tên file viết không dấu, các từ cách nhau bởi khoảng trắng</li>
                            <li>• Đáp án chính là tên file bạn upload</li>
                            <li>• Nhập gợi ý để sinh viên đoán tên file</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('challenges.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="file" :value="__('File đáp án (.txt)')" />
                                <input type="file" id="file" name="file" accept=".txt" required
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <x-input-error class="mt-2" :messages="$errors->get('file')" />
                                <p class="mt-1 text-xs text-gray-500">VD: "bai tho mua xuan.txt" - Tên file là đáp án</p>
                            </div>

                            <div>
                                <x-input-label for="hint" :value="__('Gợi ý cho Challenge')" />
                                <textarea id="hint" name="hint" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Nhập gợi ý để sinh viên đoán tên file..."
                                    required>{{ old('hint') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('hint')" />
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <a href="{{ route('challenges.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                    ← Quay lại
                                </a>
                                <x-primary-button>{{ __('Tạo Challenge') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
