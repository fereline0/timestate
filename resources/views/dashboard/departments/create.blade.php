<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <h1 class="text-lg font-bold">Создать отдел</h1>

            <form method="POST" action="{{ route('dashboard.departments.store') }}">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Название отдела')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="mt-4">
                    <x-primary-button>{{ __('Создать') }}</x-primary-button>
                </div>
            </form>
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
