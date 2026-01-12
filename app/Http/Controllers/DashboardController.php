<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $jobs = Job::with(['location', 'applicants'])
            ->where('user_id', $user->id)
            ->get();

        return view('dashboard.index', compact('user', 'jobs'));
    }

    public function destroy(Job $job): RedirectResponse
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $job->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Job deleted successfully.');
    }
}
