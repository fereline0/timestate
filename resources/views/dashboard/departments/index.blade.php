<!-- resources/views/departments/index.blade.php -->

<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <form class="flex justify-end" action="{{ route('dashboard.departments.create') }}" method="GET">
                <x-primary-button type="submit">Создать</x-primary-button>
            </form>

            <h1 class="text-lg font-bold">Список отделов</h1>

            @if ($departments->isEmpty())
                <p>Нет отделов для отображения.</p>
            @else
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Название</th>
                            <th class="py-2 px-4 border-b">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $department->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $department->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('dashboard.departments.edit', $department->id) }}"
                                        method="GET" class="inline">
                                        <x-primary-button type="submit">Изменить</x-primary-button>
                                    </form>
                                    <x-danger-button x-data=""
                                        x-on:click="$dispatch('open-modal', 'confirm-deletion-{{ $department->id }}')">Удалить</x-danger-button>

                                    <x-modal name="confirm-deletion-{{ $department->id }}" focusable>
                                        <form method="POST"
                                            action="{{ route('dashboard.departments.destroy', $department->id) }}"
                                            class="p-6">
                                            @csrf
                                            @method('DELETE')

                                            <h2 class="text-lg font-medium text-gray-900">
                                                {{ __('Вы уверены, что хотите удалить данный отдел?') }}
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
                {{ $departments->links() }}
            @endif
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
