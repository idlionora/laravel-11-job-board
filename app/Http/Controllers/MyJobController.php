<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlacementRequest;
use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAnyEmployer', Placement::class);
        return view('my_job.index', 
        [
            'placements' => $request->user()->employer
                ->placements()
                ->with(['employer', 'jobApplications', 'jobApplications.user'])
                ->withTrashed()
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Placement::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlacementRequest $request)
    {
        Gate::authorize('create', Placement::class);
        $request->user()->employer->placements()->create($request->validated());
        // we call this create() on employer model. it would be auto associated with the model
        // $request->validated is basically validated data of Request $request
        // by PlacementRequest (created by php artisan make:request PlacementRequest)

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Placement $myJob)
    {
        Gate::authorize('update', $myJob);
        return view('my_job.edit', ['placement' => $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlacementRequest $request, Placement $myJob)
    {
        Gate::authorize('update', $myJob);
        $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')
        ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Placement $myJob)
    {
        $myJob->delete();
        // without implementing soft delete, this will permanently delete the job

        return redirect()->route('my-jobs.index')
        ->with('success', 'Job deleted.');
    }
}
