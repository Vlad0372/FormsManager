@if (session('status') === 'app-form-type-deletion-failed')
<x-modal name="app-form-type-deletion-failed" show="true" focusable>
    <form method="post" action="" class="p-6  bg-red-300">
    @csrf
    @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Failure') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('The application form type can`t be deleted. There are applications with this type in the database. Remove or edit the records before the type deletion.') }}
        </p>
                          
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Close') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>
@endif