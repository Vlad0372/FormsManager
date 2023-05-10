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
                {{ __('My application forms') }}
            </h2>      
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Here you can find all your application forms you`ve ever filled in.') }}
            </p>
        </header>
        
        @if (isset($myAppForms) && count($myAppForms) > 0)
                <div class="mt-8 relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Type</th>
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="px-6 py-3">Place</th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myAppForms as $appForm)
                                <tr>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $appForm->app_name }}</th>
                                    <td class="px-6 py-4">{{ $appForm->type }}</td>
                                    <td class="px-6 py-4">{{ $appForm->description }}</td>
                                    <td class="px-6 py-4">{{ $appForm->place }}</td>
                                    
                                    <td>
                                        <div class="flex justify-around">
                                            <form method="post" action="{{ route('my-app-forms.edit', ['id'=>$appForm->id]) }}">
                                                @csrf
                                                @method('get')    
                                                <x-primary-button class="w-11 h-8" name="action" value="repopulateForm">
                                                    <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                </x-primary-button>
                                            </form>
                                            
                                            <x-danger-button id="{{ $appForm->id }}"
                                                            x-data=""
                                                            onclick="setModalHiddenInputId(this.id, 'deleteAppFormHiddentInputId')"
                                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-app-form-deletion')"                                     
                                                            class="w-11 h-8 -mx-4">
                                                <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                                            </x-danger-button>

                                            <form method="post" action="{{ route('my-app-forms.pdfStream') }}" target="_blank">
                                                @csrf
                                                @method('get')    
                                                <x-secondary-button class="w-11 h-8" type="submit" name="appFormId" value="{{ $appForm->id }}">
                                                    <i class="fa-solid fa-print"></i>
                                                </x-secondary-button>
                                            </form> 
                                        </div>
                                                        
                                    </td>                                                               
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    @include('layouts.partials.app-form.confirm-deletion')
                </div>
        @endif

        @if (isset($myAppForms) && count($myAppForms) > 0)

        <div class="mt-8 relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Type</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3">Place</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">
                            Silver
                        </td>
                        <td class="px-6 py-4">
                            Laptop
                        </td>
                        <td class="px-6 py-4">
                            $2999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Microsoft Surface Pro
                        </th>
                        <td class="px-6 py-4">
                            White
                        </td>
                        <td class="px-6 py-4">
                            Laptop PC
                        </td>
                        <td class="px-6 py-4">
                            $1999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Magic Mouse 2
                        </th>
                        <td class="px-6 py-4">
                            Black
                        </td>
                        <td class="px-6 py-4">
                            Accessories
                        </td>
                        <td class="px-6 py-4">
                            $99
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Google Pixel Phone
                        </th>
                        <td class="px-6 py-4">
                            Gray
                        </td>
                        <td class="px-6 py-4">
                            Phone
                        </td>
                        <td class="px-6 py-4">
                            $799
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Apple Watch 5
                        </th>
                        <td class="px-6 py-4">
                            Red
                        </td>
                        <td class="px-6 py-4">
                            Wearables
                        </td>
                        <td class="px-6 py-4">
                            $999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        @if (isset($myAppForms) && count($myAppForms) < 0)
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
                                        <x-tables.th class="w-48"></x-tables.th>
        
                                    </tr>
                                </thead>                     
                                <tbody class="bg-white dark:bg-slate-800">
                                @foreach($myAppForms as $appForm)
                                    <tr>
                                        <x-tables.td :wrap="true">{{ $appForm->app_name }}</x-tables.td>
                                        <x-tables.td :wrap="true">{{ $appForm->type }}</x-tables.td>
                                        <x-tables.td :wrap="true">{{ $appForm->description }}</x-tables.td>
                                        <x-tables.td :wrap="true">{{ $appForm->place }}</x-tables.td>
                                        <x-tables.td class="pl-0 pr-0">
                                            <div class="flex justify-around">
                                                <form method="post" action="{{ route('my-app-forms.edit', ['id'=>$appForm->id]) }}">
                                                    @csrf
                                                    @method('get')    
                                                    <x-primary-button class="w-11 h-8" name="action" value="repopulateForm">
                                                        <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                    </x-primary-button>
                                                </form>
                                                
                                                <x-danger-button id="{{ $appForm->id }}"
                                                                x-data=""
                                                                onclick="setModalHiddenInputId(this.id, 'deleteAppFormHiddentInputId')"
                                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-app-form-deletion')"                                     
                                                                class="w-11 h-8 -mx-4">
                                                    <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                                                </x-danger-button>

                                                <form method="post" action="{{ route('my-app-forms.pdfStream') }}" target="_blank">
                                                    @csrf
                                                    @method('get')    
                                                    <x-secondary-button class="w-11 h-8" type="submit" name="appFormId" value="{{ $appForm->id }}">
                                                        <i class="fa-solid fa-print"></i>
                                                    </x-secondary-button>
                                                </form> 
                                            </div>
                                                           
                                        </x-tables.td>                                                               
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>
                            @include('layouts.partials.app-form.confirm-deletion')

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
        
    </div>
</section>