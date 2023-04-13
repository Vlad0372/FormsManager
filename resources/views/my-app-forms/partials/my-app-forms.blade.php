<section>
    @push('app_forms_scripts')
        <script src="{{ asset('/scripts/app-forms.js') }}"></script>
    @endpush
    
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('My application forms') }}
        </h2>      
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Here you can find all your application forms you`ve ever filled in.') }}
        </p>
    </header>


   
</section>