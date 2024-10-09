<x-layout>
    <x-breadcrumbs class="mb-4" 
        :links="['Jobs' => route('placements.index'), $placement->title =>'#']" />
    <x-placement-card :$placement>
        <p class="text-sm text-slate-500 mb-4">
            {!! nl2br(e($placement->description)) !!}
            <!--syntax to show html elements on blade-->
        </p>
    </x-placement-card>
</x-layout>
