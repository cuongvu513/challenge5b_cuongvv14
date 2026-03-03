<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Challenge extends Model
{
    protected $fillable = [
        'teacher_id',
        'hint',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the answer (filename) from the stored file on disk.
     * The answer is NOT stored in the database.
     */
    public function getAnswer(): ?string
    {
        $directory = 'challenges/' . $this->id;

        if (!Storage::disk('local')->exists($directory)) {
            return null;
        }

        $files = Storage::disk('local')->files($directory);

        if (empty($files)) {
            return null;
        }
        $filename = basename($files[0]);
        $nameOnly = pathinfo($filename, PATHINFO_FILENAME);
        return $nameOnly;
    }

    /**
     * Get the file content for this challenge.
     */
    public function getFileContent(): ?string
    {
        $directory = 'challenges/' . $this->id;

        if (!Storage::disk('local')->exists($directory)) {
            return null;
        }

        $files = Storage::disk('local')->files($directory);

        if (empty($files)) {
            return null;
        }

        return Storage::disk('local')->get($files[0]);
    }
}
