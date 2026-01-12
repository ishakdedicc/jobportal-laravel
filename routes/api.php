<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/jobs/{job}/apply', [ApplicantController::class, 'store'])
        ->name('api.jobs.apply');

    Route::delete('/applicants/{applicant}', [ApplicantController::class, 'destroy'])
        ->name('api.applicants.destroy');
});
