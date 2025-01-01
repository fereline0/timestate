<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <form class="flex justify-end" action="{{ route('dashboard.vacations.create') }}" method="GET">
                <x-primary-button type="submit">Создать</x-primary-button>
            </form>

            <h1 class="text-lg font-bold">Отпуска сотрудников</h1>

            @if ($vacations->isEmpty())
                <p>Нет записей о отпусках</p>
            @else
                <div class="overflow-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Сотрудник</th>
                                <th class="py-2 px-4 border-b">Дата начала</th>
                                <th class="py-2 px-4 border-b">Дата окончания</th>
                                <th class="py-2 px-4 border-b">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vacations as $vacation)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $vacation->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $vacation->user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $vacation->start_date }}</td>
                                    <td class="py-2 px-4 border-b">{{ $vacation->end_date ?? 'Не завершен' }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <form action="{{ route('dashboard.vacations.edit', $vacation->id) }}"
                                            method="GET" class="inline">
                                            <x-primary-button type="submit">Изменить</x-primary-button>
                                        </form>
                                        <x-danger-button x-data=""
                                            x-on:click="$dispatch('open-modal', 'confirm-deletion-{{ $vacation->id }}')">Удалить</x-danger-button>

                                        <x-modal name="confirm-deletion-{{ $vacation->id }}" focusable>
                                            <form method="POST"
                                                action="{{ route('dashboard.vacations.destroy', $vacation->id) }}"
                                                class="p-6">
                                                @csrf
                                                @method('DELETE')

                                                <h2 class="text-lg font-medium text-gray-900">
                                                    {{ __('Вы уверены, что хотите удалить этот отпуск?') }}
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
                {{ $vacations->links() }}
            @endif
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
