<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thông tin người dùng') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- User Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-indigo-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->isTeacher() ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->isTeacher() ? 'Giáo viên' : 'Sinh viên' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Tên đăng nhập</p>
                            <p class="text-sm font-medium text-gray-900">{{ $user->username }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Số điện thoại</p>
                            <p class="text-sm font-medium text-gray-900">{{ $user->phone ?: 'Chưa cập nhật' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Ngày tham gia</p>
                            <p class="text-sm font-medium text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($isOwnProfile)
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📥 Tin nhắn đã nhận</h3>
                    @else
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">💬 Tin nhắn giữa bạn và {{ $user->name }}</h3>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Send Message Form (only when viewing another user) -->
                    @if(!$isOwnProfile)
                    <form method="POST" action="{{ route('messages.store', $user) }}" class="mb-6">
                        @csrf
                        <div class="flex gap-3">
                            <div class="flex-grow">
                                <textarea name="content" rows="2" placeholder="Nhập tin nhắn..."
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    required>{{ old('content') }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-1" />
                            </div>
                            <div class="flex items-end">
                                <x-primary-button>Gửi</x-primary-button>
                            </div>
                        </div>
                    </form>
                    @endif

                    <!-- Messages List -->
                    <div class="space-y-4">
                        @forelse($messages as $message)
                            <div class="border border-gray-200 rounded-lg p-4 {{ $message->sender_id === Auth::id() ? 'bg-indigo-50 border-indigo-200' : 'bg-gray-50' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="font-semibold text-sm text-gray-900">{{ $message->sender->name }}</span>
                                        <span class="text-xs text-gray-500 ml-2">{{ $message->created_at->diffForHumans() }}</span>
                                        @if($message->created_at != $message->updated_at)
                                            <span class="text-xs text-gray-400 ml-1">(đã sửa)</span>
                                        @endif
                                    </div>
                                    @if($message->sender_id === Auth::id())
                                        <div class="flex gap-2">
                                            <button onclick="document.getElementById('edit-msg-{{ $message->id }}').classList.toggle('hidden')"
                                                class="text-xs text-indigo-600 hover:text-indigo-900">Sửa</button>
                                            <form method="POST" action="{{ route('messages.destroy', $message) }}"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa tin nhắn này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:text-red-900">Xóa</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <p class="mt-2 text-sm text-gray-700">{{ $message->content }}</p>

                                <!-- Edit Form (hidden by default) -->
                                @if($message->sender_id === Auth::id())
                                    <div id="edit-msg-{{ $message->id }}" class="hidden mt-3">
                                        <form method="POST" action="{{ route('messages.update', $message) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex gap-2">
                                                <textarea name="content" rows="2"
                                                    class="flex-grow rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ $message->content }}</textarea>
                                                <div class="flex items-end">
                                                    <x-primary-button>Lưu</x-primary-button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4">
                                @if($isOwnProfile)
                                    Bạn chưa nhận được tin nhắn nào.
                                @else
                                    Chưa có tin nhắn nào giữa bạn và {{ $user->name }}.
                                @endif
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="flex">
                <a href="{{ route('users.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    ← Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
