<?php

namespace App\Http\Controllers;

use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        Gate::authorize('viewAny', Placement::class);
        $filters = request()->only('search', 'min_salary', 'max_salary', 'experience', 'category');        

        return view('placement.index', 
        ['placements' => Placement::with('employer')->latest()->filter($filters)->get()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Placement $placement)
    {
        Gate::authorize('view', $placement);
        return view('placement.show', 
        ['placement' => $placement->load('employer.placements')]);
        // load all placements by the employer as well
    }
}
