<x-layout>
    <x-breadcrumbs class="mb-4" :links="['My Job Applications' => '#']"/>

    @forelse ($applications as $application)
        <x-placement-card :placement="$application->placement">
            <div class="flex items-center justify-between text-xs text-slate-500">
                <div>
                    <div>
                        Applied {{ $application->created_at->diffForHumans() }}
                    </div>
                    <div>
                        Other {{ Str::plural('applicant', $application->placement->job_applications_count - 1) }}
                        {{ $application->placement->job_applications_count - 1 }}
                    </div>
                    <div>
                        Your asking salary ${{ number_format($application->expected_salary) }}
                    </div>
                    <div>
                        Average asking salary ${{ number_format($application->placement->job_applications_avg_expected_salary) }}
                    </div>
                </div>
                <div>
                    <form action="{{ route('my-job-applications.destroy', $application) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button>Cancel</x-button>
                    </form>
                </div>
            </div>        
        </x-placement-card>        
    @empty
        <div class="rounded-md border border-dashed border-slate-300 p-8">
            <div class="text-center font-medium">
                No job applications yet
            </div>
            <div class="text-center">
                Go find some jobs <a href="{{ route('placements.index') }}" class="text-indigo-500 hover:underline">here!</a>
            </div>
        </div>        
    @endforelse
</x-layout>
