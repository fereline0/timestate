<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <h1 class="text-lg font-bold">Список пользователей</h1>

            @if ($users->isEmpty())
                <p>Нет пользователей для отображения.</p>
            @else
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Имя</th>
                            <th class="py-2 px-4 border-b">Электронная почта</th>
                            <th class="py-2 px-4 border-b">Отдел</th>
                            <th class="py-2 px-4 border-b">Роль</th>
                            <th class="py-2 px-4 border-b">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-b">{{ $user->department->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $user->roles[0]->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    <x-danger-button x-data=""
                                        x-on:click="$dispatch('open-modal', 'confirm-deletion-{{ $user->id }}')">Удалить</x-danger-button>

                                    <x-modal name="confirm-deletion-{{ $user->id }}" focusable>
                                        <form method="POST" action="{{ route('dashboard.users.destroy', $user->id) }}"
                                            class="p-6">
                                            @csrf
                                            @method('DELETE')

                                            <h2 class="text-lg font-medium text-gray-900">
                                                {{ __('Вы уверены, что хотите удалить данного сотрудника?') }}
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
                {{ $users->links() }}
            @endif
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
