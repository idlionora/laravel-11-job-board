<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyJobApplicationController extends Controller
{
    public function index(Request $request)
    {
        return view('my_job_application.index', [
            'applications' => $request->user()->jobApplications()
                ->with([
                    'placement' => fn($query) => $query->withCount('jobApplications')
                        ->withAvg('jobApplications', 'expected_salary'),
                    'placement.employer'
                ])
                ->latest()->get()
        ]);
    }

    public function destroy(JobApplication $myJobApplication) //typehinted by route but camelcase
    {
        $myJobApplication->delete();

        return redirect()->back()->with(
            'success',
            'Job application removed.'
        );
    }
}
