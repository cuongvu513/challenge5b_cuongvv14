<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Store a new submission for an assignment.
     */
    public function store(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'],
        ]);

        // Check if student already submitted
        $existing = Submission::where('student_id', Auth::id())
            ->where('assignment_id', $assignment->id)
            ->first();

        if ($existing) {
            // Delete old file and update
            Storage::disk('local')->delete($existing->file_path);
            $file = $request->file('file');
            $existing->update([
                'file_path' => $file->store('submissions', 'local'),
                'original_name' => $file->getClientOriginalName(),
            ]);

            return back()->with('success', 'Cập nhật bài làm thành công!');
        }

        $file = $request->file('file');
        Submission::create([
            'student_id' => Auth::id(),
            'assignment_id' => $assignment->id,
            'file_path' => $file->store('submissions', 'local'),
            'original_name' => $file->getClientOriginalName(),
        ]);

        return back()->with('success', 'Nộp bài thành công!');
    }

    /**
     * Download a submission file (teacher only).
     */
    public function download(Submission $submission)
    {
        // Only the teacher who owns the assignment can download submissions
        if (!Auth::user()->isTeacher() || $submission->assignment->teacher_id !== Auth::id()) {
            abort(403);
        }

        return Storage::disk('local')->download($submission->file_path, $submission->original_name);
    }
}
