<section>
    <div class="max-w-2xl">
        @push('app_forms_scripts')
            <script src="{{ asset('/scripts/app-forms.js') }}"></script>
            <script src="https://kit.fontawesome.com/cde750a9b3.js" crossorigin="anonymous"></script>
        @endpush
        @push('table_css')
            <link rel="stylesheet" href="{{ asset('/css/table.css') }}">
        @endpush
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Application form types') }}
            </h2>      
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Here you can find all available application form types administrator has ever created.') }}
            </p>
        </header>
        
        @if (isset($appFormTypes) && count($appFormTypes) > 0)
            <div class="mt-4 -mb-3">
                <div class="not-prose relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
                    <div class="relative rounded-xl overflow-auto">
                        <div class="shadow-sm overflow-hidden my-8">
                            <table class="border-collapse table-fixed w-full text-sm">
                                <thead>
                                    <tr>
                                        <x-tables.th class="w-16">Id</x-tables.th>
                                        <x-tables.th class="">Type</x-tables.th>
                                        <x-tables.th>Has description</x-tables.th>
                                        <x-tables.th class="w-32"></x-tables.th> 
                                    </tr>
                                </thead>                     
                                <tbody class="bg-white dark:bg-slate-800">
                                @foreach($appFormTypes as $appType)
                                    <tr>
                                        <x-tables.td>{{ $appType->id }}</x-tables.td>
                                        <x-tables.td :wrap="true">{{ $appType->type }}</x-tables.td>
                                            @if($appType->has_description == 1)
                                                <x-tables.td>Yes</x-tables.td>
                                            @else
                                                <x-tables.td>No</x-tables.td>
                                            @endif             
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-0 text-slate-500 dark:text-slate-400 wrap">
                                            <div class="flex justify-around">
                                                <form method="post" action="{{ route('app-form-settings.edit', ['id'=>$appType->id]) }}">
                                                    @csrf
                                                    @method('get')    
                                                    <x-primary-button class="w-11 h-8" name="action" value="repopulateForm">
                                                        <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                    </x-primary-button>
                                                </form>
                                                
                                                <x-danger-button id="{{ $appType->id }}"
                                                                x-data=""
                                                                onclick="setModalHiddenInputId(this.id, 'deleteAppFormTypeHiddentInputId')"
                                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-app-form-type-deletion')"                                     
                                                                class="w-11 h-8 -mx-4">
                                                    <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                                               </x-danger-button>
                                            </div>                                                         
                                        </td>                                                               
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>
                            @include('layouts.partials.app-form-type.confirm-deletion')

                        </div>
                    </div>
                    <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5">
                    </div>
                </div>
            </div>   
        @else
            <h2 class="text-lg font-medium text-red-500 mt-6">
                {{ __('There are no application types') }}
            </h2>
        @endif
    </div>
</section>