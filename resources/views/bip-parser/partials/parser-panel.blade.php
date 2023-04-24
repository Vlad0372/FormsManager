<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Parsing panel') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Click Parse to parse bip.ires.pl pages for emails and names of enities.') }}
        </p>
    </header>

    <form method="post" action="{{ route('bip-parser.parse') }}" class="">
        @csrf
        @method('get')

        <x-primary-button name="action" value="defaultParse">
            {{ __('Parse') }}
        </x-primary-button>

        <x-primary-button name="action" value="dirtyParse">
            {{ __('Dirty parse') }}
        </x-primary-button>
    </form>

</section>
