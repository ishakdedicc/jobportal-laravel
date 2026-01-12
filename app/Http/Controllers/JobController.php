<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Applicant;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $jobs = Job::with(['company', 'location'])
            ->latest()
            ->paginate(6);

        return view('jobs.index', compact('jobs'));
    }

    public function create(): View | RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('jobs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Job
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'nullable|integer',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',

            // Company
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'company_website' => 'nullable|url',
            'company_logo' => 'nullable|image|max:2048',

            // Location
            'address' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
        ]);

        $company = Company::create([
            'name' => $validated['company_name'],
            'description' => $validated['company_description'] ?? null,
            'website' => $validated['company_website'] ?? null,
            'logo' => null,
        ]);

        if ($request->hasFile('company_logo')) {

            $extension = $request->file('company_logo')->getClientOriginalExtension();
            $slug = Str::slug($validated['company_name']) ?: 'company';

            $fileName = $slug . '-' . $company->id . '.' . $extension;

            $logoPath = $request->file('company_logo')->storeAs(
                'company-logos',
                $fileName,
                'public'
            );

            $company->update([
                'logo' => $logoPath,
            ]);
        }

        $location = Location::create([
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zipcode' => $validated['zipcode'],
        ]);

        $job = Job::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'salary' => $validated['salary'] ?? null,
            'job_type' => $validated['job_type'],
            'remote' => $validated['remote'],
            'requirements' => $validated['requirements'] ?? null,
            'benefits' => $validated['benefits'] ?? null,
            'company_id' => $company->id,
            'location_id' => $location->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('jobs.show', $job)
            ->with('success', 'Job listing created successfully.');
    }

    public function show(Job $job): View
    {
        $job->load(['company', 'location']);

        $isBookmarked = false;
        $isApplied = false;

        if (Auth::check()) {
            $isBookmarked = Auth::user()
                ->bookmarkedJobs()
                ->where('job_id', $job->id)
                ->exists();

            $isApplied = \App\Models\Applicant::where('user_id', Auth::id())
                ->where('job_id', $job->id)
                ->exists();
        }

        return view('jobs.show', compact('job', 'isBookmarked', 'isApplied'));
    }

    public function edit(Job $job): View
    {
        $this->authorize('update', $job);

        $job->load(['company', 'location']);

        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            // Job
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'nullable|integer',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',

            // Company
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'company_website' => 'nullable|url',
            'company_logo' => 'nullable|image|max:2048',

            // Location
            'address' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
        ]);

        $company = $job->company;
        $logoPath = $company->logo;

        if ($request->hasFile('company_logo')) {

            if ($logoPath && \Storage::disk('public')->exists($logoPath)) {
                \Storage::disk('public')->delete($logoPath);
            }

            $extension = $request->file('company_logo')->getClientOriginalExtension();
            $slug = Str::slug($validated['company_name']) ?: 'company';

            $fileName = $slug . '-' . $company->id . '.' . $extension;

            $logoPath = $request->file('company_logo')->storeAs(
                'company-logos',
                $fileName,
                'public'
            );
        }

        $company->update([
            'name' => $validated['company_name'],
            'description' => $validated['company_description'] ?? null,
            'website' => $validated['company_website'] ?? null,
            'logo' => $logoPath,
        ]);

        $job->location->update([
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zipcode' => $validated['zipcode'],
        ]);

        $job->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'salary' => $validated['salary'] ?? null,
            'job_type' => $validated['job_type'],
            'remote' => $validated['remote'],
            'requirements' => $validated['requirements'] ?? null,
            'benefits' => $validated['benefits'] ?? null,
        ]);

        return redirect()
            ->route('jobs.show', $job)
            ->with('success', 'Job listing updated successfully.');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $this->authorize('delete', $job);

        $job->delete();

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job listing deleted successfully.');
    }

    public function search(Request $request)
    {
        $keywords = strtolower(trim($request->input('keywords', '')));
        $location = strtolower(trim($request->input('location', '')));

        $jobs = Job::query()
            ->when($keywords, function ($query) use ($keywords) {
                $query->where(function ($q) use ($keywords) {
                    $q->whereRaw('LOWER(title) LIKE ?', ["%{$keywords}%"])
                        ->orWhereRaw('LOWER(description) LIKE ?', ["%{$keywords}%"]);
                });
            })
            ->when($location, function ($query) use ($location) {
                $query->whereHas('location', function ($q) use ($location) {
                    $q->whereRaw('LOWER(city) LIKE ?', ["%{$location}%"])
                        ->orWhereRaw('LOWER(state) LIKE ?', ["%{$location}%"])
                        ->orWhereRaw('LOWER(address) LIKE ?', ["%{$location}%"])
                        ->orWhereRaw('LOWER(zipcode) LIKE ?', ["%{$location}%"]);
                });
            })
            ->paginate(12)
            ->withQueryString();

        return view('jobs.index', compact('jobs'));
    }
}
