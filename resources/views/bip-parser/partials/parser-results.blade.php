<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Results:') }}
        </h2>
    </header>

    @if (session('status') === 'showLinks' && count($links) > 0)
        <h2 class="text-lg font-medium text-green-500">
            {{ __('Success') }}
        </h2>
        
        @foreach($links as $link)                        
            <p>{{ $link }}</p>                                     
        @endforeach 
    @else
        <h2 class="text-lg font-medium text-red-500">
            {{ __('No results found') }}
        </h2>
    @endif

</section>
