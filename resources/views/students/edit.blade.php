<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sửa thông tin sinh viên') }}: {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('students.update', $student) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="username" :value="__('Tên đăng nhập')" />
                                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                                    :value="old('username', $student->username)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('username')" />
                            </div>

                            <div>
                                <x-input-label for="name" :value="__('Họ tên')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name', $student->name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email', $student->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Số điện thoại')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                    :value="old('phone', $student->phone)" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Mật khẩu mới (để trống nếu không đổi)')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <a href="{{ route('students.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                    ← Quay lại
                                </a>
                                <x-primary-button>{{ __('Cập nhật') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
