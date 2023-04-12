<section>
    @push('app_forms_scripts')
        <script src="{{ asset('/scripts/app-forms.js') }}"></script>
    @endpush
    
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Fill in an application form') }}
        </h2>      
        <p class="mt-1 text-sm text-gray-600">
            {{ __('You have 2 minutes to fill in and send the application form. You can also extend the time if needed. You will be automatically redirected to the main page in the end of the time.') }}
        </p>
    </header>

    <form method="post" action="{{ route('app-form.store') }}" class="mt-6 space-y-6">
        @csrf

        <div  class="flex items-center justify-start mt-4">
            <h2 id="sessionTimer" class="text-lg font-medium text-gray-900 w-14">
                    {{ __('0:00') }}
            </h2>
           
            <x-primary-button name="action" value="extendTime" onclick="saveScrollPos()">
                    {{ __('Extend') }}
            </x-primary-button>
        </div>

        <div>
            <x-input-label for="app_name" :value="__('Name')" />
            <x-text-input name="app_name" type="text"  class="mt-1 block w-full" :value="old('app_name')"/>
            <x-input-error :messages="$errors->appform->first('app_name')" class="mt-2" />        
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea name="description" type="text" placeholder="Describe the situation"   maxlength="200" class=" border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1 -mb-1">{{ old('description') }}</textarea>  
            <x-input-error :messages="$errors->appform->first('description')" class="mt-2" /> 
        </div>

        <div>
            <x-input-label for="type" :value="__('Type')" />     
            <select  id="type" name="type" required focus onchange="showHideTextarea()" class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                <option value="1">Usterka</option>        
                <option value="2">Informacja</option>    
                <option value="3">Zapytanie</option>
            </select>
            <x-input-error :messages="$errors->appform->first('type')" class="mt-2" /> 
        </div>
        
        <div style="display: none;" class="" id="placeTxtAreaDiv">
            <x-input-label for="place" :value="__('Place')" />
            <textarea name="place" type="text" maxlength="50" placeholder="Describe the place where it happened"  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1 -mb-1">{{ old('place') }}</textarea>
            <x-input-error :messages="$errors->appform->first('place')" class="mt-2" /> 
        </div>
        <input type="text" name="author_name" value="user_name">
        <input type="text" name="author_id" value="user_id">
        <x-primary-button name="action" value="sendData">
            {{ __('Send') }}
        </x-primary-button>     
    </form>
    
    <form method="post" id="terminateSessionForm" action="{{ route('app-form.terminate') }}">
        @csrf  
        @method('delete') 
    </form>  

    <script type="text/javascript">
        var oldValue = "{{ old('type') }}";
        var seconds = "{{ session('sessionSeconds') }}";
      
        restoreSelectedOption(oldValue);
        startTimer("sessionTimer", seconds);   
    </script>

    <script type="text/javascript" defer>
        setCurrentScrollPos(getSavedScrollPos());
    </script>
</section>