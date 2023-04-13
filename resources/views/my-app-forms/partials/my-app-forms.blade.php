<section>
    @push('app_forms_scripts')
        <script src="{{ asset('/scripts/app-forms.js') }}"></script>
    @endpush
    @push('table_css')
        <link rel="stylesheet" href="{{ asset('/css/table.css') }}">
    @endpush
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('My application forms') }}
        </h2>      
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Here you can find all your application forms you`ve ever filled in.') }}
        </p>
    </header>
    
    @if (count($myAppForms) > 0)
        <div class="mt-4 -mb-3">
            <div class="not-prose relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
                <div class="relative rounded-xl overflow-auto">
                    <div class="shadow-sm overflow-hidden my-8">
                        <table class="border-collapse table-fixed w-full text-sm">
                            <thead>
                                <tr>
                                    <x-tables.th>Name</x-tables.th>
                                    <x-tables.th>Type</x-tables.th>
                                    <x-tables.th>Description</x-tables.th>
                                    <x-tables.th>Place</x-tables.th>
                                    <x-tables.th></x-tables.th>
                                </tr>
                            </thead>                     
                            <tbody class="bg-white dark:bg-slate-800">
                            @foreach($myAppForms as $appForm)
                                <tr>
                                    <x-tables.td :wrap="true">{{ $appForm->app_name }}</x-tables.td>
                                    <x-tables.td>{{ $appForm->type }}</x-tables.td>
                                    <x-tables.td :wrap="true">{{ $appForm->description }}</x-tables.td>
                                    <x-tables.td :wrap="true">{{ $appForm->place }}</x-tables.td>
                                    <x-tables.td>
                                        <x-primary-button>
                                            {{ __('Edit') }}
                                        </x-primary-button>
                                    </x-tables.td>                          
                                </tr>
                            @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5">
                </div>
            </div>
        </div>   
    @else
        <h2 class="text-lg font-medium text-red-500 mt-6">
            {{ __('You have no applications') }}
        </h2>
    @endif
    
        
      
    

</section>