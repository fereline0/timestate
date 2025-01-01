<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <form class="flex justify-end" action="{{ route('dashboard.working-times.create') }}" method="GET">
                <x-primary-button type="submit">Создать</x-primary-button>
            </form>

            <h1 class="text-lg font-bold">Рабочие часы сотрудников</h1>

            <form method="GET" class="space-y-2" action="{{ route('dashboard.working-times.index') }}">
                <div>
                    <x-input-label for="date" :value="__('Выберите дату')" />
                    <x-text-input id="date" name="date" type="date" class="mt-1 block w-full"
                        :value="request('date', now()->format('Y-m-d'))" />
                    <x-input-error class="mt-2" :messages="$errors->get('date')" />
                </div>
                <div>
                    <x-primary-button type="submit">Показать</x-primary-button>
                </div>
            </form>

            @if ($workingTimes->isEmpty())
                <p>Нет записей о рабочих часах</p>
            @else
                <div class="overflow-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Сотрудник</th>
                                <th class="py-2 px-4 border-b">Дата</th>
                                <th class="py-2 px-4 border-b">Начало</th>
                                <th class="py-2 px-4 border-b">Конец</th>
                                <th class="py-2 px-4 border-b">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workingTimes as $workingTime)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $workingTime->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $workingTime->user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $workingTime->date }}</td>
                                    <td class="py-2 px-4 border-b">{{ $workingTime->begin }}</td>
                                    <td class="py-2 px-4 border-b">{{ $workingTime->end ?? 'Не завершен' }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <x-danger-button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $workingTime->id }}')">Удалить</x-danger-button>
                                        <form action="{{ route('dashboard.working-times.edit', $workingTime->id) }}"
                                            method="GET" class="inline">
                                            <x-primary-button type="submit">Изменить</x-primary-button>
                                        </form>

                                        <x-modal name="confirm-deletion-{{ $workingTime->id }}" focusable>
                                            <form method="POST"
                                                action="{{ route('dashboard.working-times.destroy', $workingTime->id) }}"
                                                class="p-6">
                                                @csrf
                                                @method('DELETE')

                                                <h2 class="text-lg font-medium text-gray-900">
                                                    {{ __('Вы уверены, что хотите удалить это рабочее время?') }}
                                                </h2>

                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ __('После удаления эта запись не может быть восстановлена.') }}
                                                </p>

                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        {{ __('Отмена') }}
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3">
                                                        {{ __('Удалить') }}
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $workingTimes->links() }}
            @endif
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
