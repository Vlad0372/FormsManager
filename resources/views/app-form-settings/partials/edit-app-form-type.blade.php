<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit current application form type') }}
        </h2>      
    </header>

    <form method="post" action="{{ route('app-form-type.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex">
            <div class="w-2/4">
                <x-input-label for="app_type_name" :value="__('Application form type name')" />
                <x-text-input name="app_type_name" type="text"  class="mt-1 block w-full" :value="old('app_type_name')"/>
                <x-input-error :messages="$errors->appformtype->first('app_type_name')" class="mt-2" />        
            </div>

            <div class="flex items-center ml-4">
                <input type="checkbox" name="app-type-checkbox" value="" @if(old('has_description', false)) checked @endif class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="app-type-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Has place description</label>
            </div>
        </div>
       
        <input type="hidden" value="{{ $appFormTypeId }}" name="appFormTypeId">

        <x-primary-button name="action" value="updateData">
            {{ __('Save') }}
        </x-primary-button> 

        <x-secondary-button type="submit" name="action" value="goBack">
            {{ __('Cancel') }}
        </x-secondary-button>     
    </form>

    <script type="text/javascript">
       
    </script>
</section>