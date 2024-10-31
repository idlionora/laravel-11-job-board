<?php

namespace App\Policies;

use App\Models\Placement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlacementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function viewAnyEmployer(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Placement $placement): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->employer !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Placement $placement): bool|Response
    {
        if ($placement->employer->user_id !== $user->id) {
            return false;
        }

        if ($placement->jobApplications()->count() > 0) {
            return Response::deny('Cannot change this job with applications');
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Placement $placement): bool
    {
        return $placement->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Placement $placement): bool
    {
        return $placement->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Placement $placement): bool
    {
        return $placement->employer->user_id === $user->id;
    }

    public function apply(User $user, Placement $placement): bool {
        // we're applying for a specific job, we don't create a job application in isolation
        // job application can't exist without a job
        // we have to run a query that would involve the job (placement) model

        return !$placement->hasUserApplied($user);        
    }
}
