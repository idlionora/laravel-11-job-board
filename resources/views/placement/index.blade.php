<x-layout>
    <x-breadcrumbs class="mb-4" 
        :links="['Jobs' => route('placements.index')]" />

    <x-card class="mb-4 text-sm" x-data="">
        <form x-ref="filters" id="filtering-form" action="{{ route('placements.index') }}" method="GET">
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <div class="mb-1 font-semibold">Search</div>
                    <x-text-input name="search" value="{{ request('search') }}" placeholder="Search for any text" form-ref="filters"/>
                    <!-- you only use colon in front of the properties if you want the value to be read as php-->
                </div>
                <div>
                    <div class="mb-1 font-semibold">Salary</div>
                    <div class="flex space-x-2">
                        <x-text-input name="min_salary" value="{{ request('min_salary') }}" placeholder="From" form-id="filters"/>
                        <x-text-input name="max_salary" value="{{ request('max_salary') }}" placeholder="To" form-ref="filters"/>
                    </div>
                </div>
                <div>
                    <div class="mb-1 font-semibold">Experience</div>
                    <x-radio-group name="experience" :options="array_combine(
                        array_map('ucfirst', \App\Models\Placement::$experience), \App\Models\Placement::$experience)"/>
                </div>
                <div>
                    <div class="mb-1 font-semibold">Category</div>
                    <x-radio-group name="category" :options="\App\Models\Placement::$category"/>
                </div>
            </div>
            <x-button class="w-full">Filter</x-button>
        </form>
    </x-card>
    
    @foreach ($placements as $placement)
        <x-placement-card class="mb-4" :$placement> 
            <!-- shorthand for :placement="$placement" -->
           <div>
                <x-link-button :href="route('placements.show', $placement)">
                    Show
                </x-link-button>
            </div>
        </x-placement-card>        
    @endforeach
</x-layout>
