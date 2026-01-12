<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    public function index(): View
    {
        $bookmarks = Auth::user()
            ->bookmarkedJobs()
            ->with(['company', 'location'])
            ->paginate(10);

        return view('jobs.bookmarked', compact('bookmarks'));
    }

    public function store(Job $job): RedirectResponse
    {
        $user = Auth::user();

        if ($user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('status', 'Job already bookmarked.');
        }

        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('status', 'Job bookmarked successfully.');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'Job is not bookmarked.');
        }

        $user->bookmarkedJobs()->detach($job->id);

        return back()->with('status', 'Job removed from bookmarks successfully.');
    }
}
