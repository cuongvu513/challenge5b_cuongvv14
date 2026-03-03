<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assignments.
     */
    public function index()
    {
        $assignments = Assignment::with('teacher')->latest()->get();

        return view('assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create()
    {
        return view('assignments.create');
    }

    /**
     * Store a newly created assignment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:10240'],
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filePath = $file->store('assignments', 'local');

        Assignment::create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'original_name' => $originalName,
        ]);

        return redirect()->route('assignments.index')->with('success', 'Tạo bài tập thành công!');
    }

    /**
     * Display the specified assignment with submissions (for teacher).
     */
    public function show(Assignment $assignment)
    {
        $submissions = null;
        $mySubmission = null;

        if (Auth::user()->isTeacher()) {
            // Only the teacher who created this assignment can see submissions
            if ($assignment->teacher_id === Auth::id()) {
                $submissions = $assignment->submissions()->with('student')->latest()->get();
            }
        } else {
            $mySubmission = Submission::where('student_id', Auth::id())
                ->where('assignment_id', $assignment->id)
                ->first();
        }

        return view('assignments.show', compact('assignment', 'submissions', 'mySubmission'));
    }

    /**
     * Download the assignment file.
     */
    public function download(Assignment $assignment)
    {
        return Storage::disk('local')->download($assignment->file_path, $assignment->original_name);
    }
}
