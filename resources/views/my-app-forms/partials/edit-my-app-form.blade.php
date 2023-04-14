<section>
    <div class="max-w-xl">
        @push('app_forms_scripts')
            <script src="{{ asset('/scripts/app-forms.js') }}"></script>
        @endpush
        
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Application form editing') }}
            </h2>      
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Here you can edit your old application form and then save it.') }}
            </p>
        </header>

        <form method="post" action="{{ route('my-app-forms.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            @include('app-form.partials.app-form-body')
           
            <input type="hidden" value="{{ $appFormId }}" name="appFormId">
            <x-primary-button name="action" value="updateData">
                {{ __('Save') }}
            </x-primary-button>     
        </form>
    </div>
    <script type="text/javascript">
        var oldValue = "{{ old('type') }}";
        
        restoreSelectedOption(oldValue);  
    </script>
</section>