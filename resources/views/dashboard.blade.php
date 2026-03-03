<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trang chủ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">
                        Xin chào, {{ Auth::user()->name }}! 
                    </h3>
                    <p class="text-gray-600">
                        Vai trò: <span class="font-semibold text-indigo-600">{{ Auth::user()->isTeacher() ? 'Giáo viên' : 'Sinh viên' }}</span>
                        &bull; Tên đăng nhập: <span class="font-semibold">{{ Auth::user()->username }}</span>
                    </p>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('users.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-2"></div>
                    <h4 class="font-semibold text-gray-800">Người dùng</h4>
                    <p class="text-sm text-gray-500 mt-1">Xem danh sách & thông tin người dùng</p>
                </a>

                @if(Auth::user()->isTeacher())
                    <a href="{{ route('students.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="text-3xl mb-2"></div>
                        <h4 class="font-semibold text-gray-800">Quản lý Sinh viên</h4>
                        <p class="text-sm text-gray-500 mt-1">Thêm, sửa, xóa thông tin sinh viên</p>
                    </a>
                @endif

                <a href="{{ route('assignments.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-2"></div>
                    <h4 class="font-semibold text-gray-800">Bài tập</h4>
                    <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->isTeacher() ? 'Giao & quản lý bài tập' : 'Xem & nộp bài tập' }}</p>
                </a>

                <a href="{{ route('challenges.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-2"></div>
                    <h4 class="font-semibold text-gray-800">Challenge</h4>
                    <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->isTeacher() ? 'Tạo challenge giải đố' : 'Tham gia giải đố' }}</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
