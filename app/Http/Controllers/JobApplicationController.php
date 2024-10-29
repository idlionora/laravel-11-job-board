<?php

namespace App\Http\Controllers;

use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JobApplicationController extends Controller
{
    public function create(Placement $placement)
    {
        Gate::authorize('apply', $placement);
        return view('job_application.create', ['placement' => $placement]);
    }

    public function store(Placement $placement, Request $request)
    {
        Gate::authorize('apply', $placement);

        $validatedData = $request->validate([
                'expected_salary' => 'required|min:1|max:1000000',
                'cv' => 'required|file|mimes:pdf|max:2848'
        ]);

        $file = $request->file('cv');
        $path = $file->store('cvs', 'private');

        $placement->jobApplications()->create([
            'user_id' => $request->user()->id,
            'expected_salary' => $validatedData['expected_salary'],
            'cv_path' => $path
        ]);

        return redirect()->route('placements.show', $placement)
            ->with('success', 'Job application submitted.');
    }

    public function destroy(string $id)
    {
        //
    }
}
