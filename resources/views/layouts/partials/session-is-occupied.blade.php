@if (session('status') === 'form-filling-occupied')
<x-modal name="formfill-session-is-occupied" show="true" focusable>
    <form method="post" action="" class="p-6">
    @csrf
    @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Session is occupied') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Someone is already filling the application form. Wait ~2 minutes and try again.') }}
        </p>
                          
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Close') }}
            </x-secondary-button>
        </div>               
    </form>
</x-modal>
@endif
            