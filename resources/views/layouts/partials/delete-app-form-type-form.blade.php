<x-modal name="confirm-app-form-type-deletion" focusable>
        <form method="post" action="{{ route('my-app-forms.destroy')}}" class="p-6">
            @csrf
            @method('delete')

            <input id="deleteAppFormTypeHiddentInputId" name="id" hidden value="56">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this application form type?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your application type is deleted, all of its data will be permanently deleted.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
</x-modal>