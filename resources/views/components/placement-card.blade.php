<x-card class="mb-4">
    <div class="mb-4 flex justify-between">
        <h2 class="text-lg font-medium">
            {{ $placement->title }}
        </h2>
        <div class="text-slate-500">
            ${{ number_format($placement->salary) }}
        </div>
    </div>

    <div class="mb-4 flex justify-between text-sm text-slate-500 items-center">
        <div class="flex space-x-4">
            <div>Company Name</div>
            <div>{{ $placement->location }}</div>
        </div>
        <div class="flex space-x-1 text-xs">
            <x-tag>{{ Str::ucfirst($placement->experience) }}</x-tag>
            <x-tag>{{ $placement->category }}</x-tag>
        </div>
    </div>

    <p class="text-sm text-slate-500 mb-4">
        {!! nl2br(e($placement->description)) !!}
        <!--syntax to show html elements on blade-->
    </p>
    
    {{ $slot }}
</x-card> 
