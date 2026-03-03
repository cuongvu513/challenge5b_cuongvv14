<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo bài tập mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('assignments.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="title" :value="__('Tiêu đề bài tập')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                    :value="old('title')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Mô tả (tùy chọn)')" />
                                <textarea id="description" name="description" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div>
                                <x-input-label for="file" :value="__('File bài tập')" />
                                <input type="file" id="file" name="file" required
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <x-input-error class="mt-2" :messages="$errors->get('file')" />
                                <p class="mt-1 text-xs text-gray-500">Tối đa 10MB</p>
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <a href="{{ route('assignments.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                    ← Quay lại
                                </a>
                                <x-primary-button>{{ __('Tạo bài tập') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
