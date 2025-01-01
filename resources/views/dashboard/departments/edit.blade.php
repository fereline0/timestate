<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <h1 class="text-lg font-bold">Редактировать отдел</h1>

            <form method="POST" action="{{ route('dashboard.departments.update', $department->id) }}">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" :value="__('Название отдела')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        value="{{ old('name', $department->name) }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="mt-4">
                    <x-primary-button>{{ __('Сохранить изменения') }}</x-primary-button>
                </div>
            </form>
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
