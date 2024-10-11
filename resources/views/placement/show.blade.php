<x-layout>
    <x-breadcrumbs class="mb-4" 
        :links="['Jobs' => route('placements.index'), $placement->title =>'#']" />
    <x-placement-card :$placement>
        <p class="text-sm text-slate-500 mb-4">
            {!! nl2br(e($placement->description)) !!}
            <!--syntax to show html elements on blade-->
        </p>
    </x-placement-card>

    <x-card class="mb-4">
        <h2 class="mb-4 text-lg font-medium">
            More {{ $placement->employer->company_name }} Jobs
        </h2>

        <div class="text-sm text-slate-500">
            @foreach ($placement->employer->placements as $otherPlacement)
            <div class="mb-4 flex justify-between">
                <div>
                    <div class="text-slate-700">
                        <a href="{{ route('placements.show', $otherPlacement) }}">
                            {{ $otherPlacement->title }}
                        </a>
                    </div>
                    <div class="text-xs">
                        {{ $otherPlacement->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="text-xs">
                    ${{ number_format($otherPlacement->salary) }}
                </div>
            </div>
            @endforeach
        </div>
    </x-card>
</x-layout>
