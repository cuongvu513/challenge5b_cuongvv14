<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        $students = User::where('role', 'student')->orderBy('name')->get();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'student',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('students.index')->with('success', 'Thêm sinh viên thành công!');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, User $student)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($student->id)],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($student->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $data = $request->only(['username', 'name', 'email', 'phone']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Cập nhật sinh viên thành công!');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(User $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Xóa sinh viên thành công!');
    }
}
