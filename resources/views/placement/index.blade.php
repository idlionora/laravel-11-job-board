<x-layout>
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
