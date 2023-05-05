@if (session('status') === 'app-form-session-deleted')
<x-modal name="app-form-session-deleted" show="true" focusable>
    <form method="post" action="" class="p-6">
    @csrf
    @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Session is terminated') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('You have reached your time limit.') }}
        </p>
                          
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Close') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>
@endif
           