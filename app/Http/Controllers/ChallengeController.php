<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChallengeController extends Controller
{
    /**
     * Display a listing of challenges.
     */
    public function index()
    {
        $challenges = Challenge::with('teacher')->latest()->get();

        return view('challenges.index', compact('challenges'));
    }

    /**
     * Show the form for creating a new challenge.
     */
    public function create()
    {
        return view('challenges.create');
    }

    /**
     * Store a newly created challenge.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hint' => ['required', 'string'],
            'file' => ['required', 'file', 'mimes:txt', 'max:5120'],
        ]);

        $challenge = Challenge::create([
            'teacher_id' => Auth::id(),
            'hint' => $request->hint,
        ]);

        // Store file with its original name in challenges/{id}/ directory
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $file->storeAs('challenges/' . $challenge->id, $originalName, 'local');

        return redirect()->route('challenges.index')->with('success', 'Tạo challenge thành công!');
    }

    /**
     * Display the challenge (hint + guess form for students).
     */
    public function show(Challenge $challenge)
    {
        return view('challenges.show', compact('challenge'));
    }

    /**
     * Check student's answer for a challenge.
     */
    public function guess(Request $request, Challenge $challenge)
    {
        $request->validate([
            'answer' => ['required', 'string'],
        ]);

        $correctAnswer = $challenge->getAnswer();

        if ($correctAnswer === null) {
            return back()->with('error', 'Challenge này chưa có file đáp án.');
        }

        // Compare answer (case-insensitive)
        if (mb_strtolower(trim($request->answer)) === mb_strtolower(trim($correctAnswer))) {
            $content = $challenge->getFileContent();

            return back()->with('correct', true)->with('file_content', $content);
        }

        return back()->with('error', 'Đáp án sai! Hãy thử lại.')->withInput();
    }
}
