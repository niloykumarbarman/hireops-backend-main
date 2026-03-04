<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $path = $file->store('resumes', 'public'); // storage/app/public/resumes

        // অরিজিনাল নাম + mime + size
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();

        // CV থেকে বেসিক ডাটা পার্স করা (পরে AI/regex দিয়ে বাড়ানো যাবে)
        $candidateData = $this->parseCvBasic($path); // নিচে ফাংশন আছে

        // অটো candidate তৈরি (tenant_id অটো সেট হবে Global Scope থেকে)
        $candidate = Candidate::create($candidateData);

        // Resume সেভ
        Resume::create([
            'candidate_id' => $candidate->id,
            'file_path' => $path,
            'original_name' => $originalName,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
        ]);

        return response()->json([
            'message' => 'CV uploaded and candidate created successfully',
            'candidate' => $candidate,
            'file' => $path,
        ], 201);
    }

    private function parseCvBasic($path)
    {
        // সিম্পল উদাহরণ (পরে smalot/pdfparser বা AI দিয়ে বাড়ানো যাবে)
        return [
            'name' => 'Parsed Name',
            'email' => 'parsed@email.com',
            'phone' => '1234567890',
            'experience' => 5,
            'skills' => 'Laravel, PHP, React',
        ];
    }
}
