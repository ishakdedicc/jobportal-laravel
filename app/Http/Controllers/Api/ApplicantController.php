<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicantController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $alreadyApplied = Applicant::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return response()->json([
                'message' => 'You have already applied for this job.'
            ], 409);
        }

        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'contact_email'  => 'required|email',
            'contact_phone'  => 'nullable|string|max:50',
            'message'        => 'nullable|string',
            'resume'         => 'required|file|mimes:pdf|max:2048',
        ]);

        $extension = $request->file('resume')->getClientOriginalExtension();
        $slug = \Str::slug($validated['full_name']) ?: 'applicant';

        $tempName = $slug . '-' . time() . '.' . $extension;

        $resumePath = $request->file('resume')->storeAs(
            'resumes',
            $tempName,
            'public'
        );

        $applicant = Applicant::create([
            'user_id'       => Auth::id(),
            'job_id'        => $job->id,
            'full_name'     => $validated['full_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'] ?? null,
            'message'       => $validated['message'] ?? null,
            'resume_path'   => $resumePath,
        ]);

        return response()->json([
            'message' => 'Application submitted successfully',
            'data'    => $applicant
        ], 201);
    }


    public function destroy(Request $request, Applicant $applicant)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($applicant->job->user_id !== $user->id) {
            return response()->json([
                'message' => 'You are not allowed to delete this application.'
            ], 403);
        }

        if ($applicant->resume_path && Storage::disk('public')->exists($applicant->resume_path)) {
            Storage::disk('public')->delete($applicant->resume_path);
        }

        $applicant->delete();

        return response()->json(['message' => 'Applicant deleted'], 200);
    }
}
