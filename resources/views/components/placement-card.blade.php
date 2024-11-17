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
        <div class="flex items-center space-x-4">
            <div>{{ $placement->employer->company_name }}</div>
            <div>{{ $placement->location }}</div>
            @if ($placement->deleted_at)
                <span class="text-xs text-red-500">Deleted</span>                
            @endif
        </div>
        <div class="flex space-x-1 text-xs">
            <x-tag>
                <a href="{{ route('placements.index', ['experience' => $placement->experience]) }}">
                    {{ Str::ucfirst($placement->experience) }}
                </a>
            </x-tag>
            <x-tag>
                <a href="{{ route('placements.index', ['category' => $placement->category]) }}">
                    {{ $placement->category }}
                </a>
            </x-tag>
        </div>
    </div>    
    
    {{ $slot }}
</x-card> 
