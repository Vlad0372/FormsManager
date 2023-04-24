<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Results:') }}
        </h2>
    </header>

    @if(isset($status) && $status === 'showLinks')
        <h2 class="text-lg font-medium text-green-500">
            {{ __('Success! Founds:') }} {{count($links)}}
        </h2>

        @if (count($links) > 0)
            @foreach($links as $link)                        
                <p>{{ $link }}</p>                                     
            @endforeach
        @endif     
    @else 
        <h2 class="text-lg font-medium text-red-500">
            {{ __('No results found') }}
        </h2>
    @endif


</section>
