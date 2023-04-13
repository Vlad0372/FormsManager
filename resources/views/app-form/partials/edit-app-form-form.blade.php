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

        @include('app-form.partials.app-form-body')
        
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