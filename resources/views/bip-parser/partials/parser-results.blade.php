<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Results:') }}
        </h2>
    </header>

    @if(isset($status) && $status === 'showLinks')
        <h2 class="text-lg font-medium text-green-500">
            {{ __('Success! Founds:') }} {{count($data['links'])}}
        </h2>
        
        @if (count($data['links']) > 0)
            @for ($i = 0; $i < count($data['links']); $i++)
            <div class="border-solid border-2 border-gray-200 rounded-lg bg-gray-100 p-6">
                <p class="mt-4 font-bold">Unit name:</p>
                    @if (count($data['subdomainNames']) == count($data['links']))                   
                        <p class="ml-6 text-gray-600">{{ strtoupper($data['subdomainNames'][$i]) }}</p>                                           
                    @else
                        <p class="text-red-500 pl-6">Unknowwn name</p>
                    @endif
                    
                <p class="mt-4 font-bold">Link:</p>
                    <p><a class="underline text-sky-500 font-normal pl-6" target="_blank" href="{{ $data['links'][$i] }}">{{ $data['links'][$i] }}</a></p>
                
                <p class="mt-4 font-bold">Parsed emails:</p>
                    @if (count($data['pageEmails'][$i]) > 0)
                        @foreach($data['pageEmails'][$i] as $email)  
                            <p class="ml-6 text-gray-600">{{ $email }}</p>
                        @endforeach                   
                    @else
                        <p class="text-red-500 pl-6">No emails found</p>
                    @endif
            </div>
            @endfor             
        @endif   
        
    @else 
        <h2 class="text-lg font-medium text-red-500">
            {{ __('No results found') }}
        </h2>
    @endif


</section>
