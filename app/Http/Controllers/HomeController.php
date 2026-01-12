<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $jobs = Job::latest()->take(6)->get();

        return view('pages.index', [
            'jobs' => $jobs,
        ]);
    }
}
