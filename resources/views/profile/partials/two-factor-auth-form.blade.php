<section class="space-y-6">
    <header>
               
        <div class="flex items-center justify-start mt-4">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Two-Factor Authentication (2FA)') }}
            </h2>
            @if ($user->name === 'vladislav_0372')
                <h2 class="text-lg font-medium text-red-600">
                    &nbsp;
                    {{ __('Disabled') }}
                </h2>
            @else
                <h2 class="text-lg font-medium text-green-600">
                    &nbsp;
                    {{ __('Enabled') }}
                </h2>
            @endif           
        </div>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Two-Factor Authentication (aka 2FA) is a specific type of Multi-Factor Authentication that requires the authenticating party to produce two separate identifying factors that are indicative to its identity, instead of the previously standard single identifier, usually a password, required in many systems.') }}
        </p>
        
    </header>
    
    @if ($user->name === 'vladislav_0372')
        <x-green-button x-data="">
            {{ __('Enable') }}
        </x-green-button> 
    @else
        <x-danger-button x-data="">
            {{ __('Disable') }}
        </x-danger-button>
    @endif

</section>
