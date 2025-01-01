<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <h1 class="text-lg font-bold">Редактирование отпуска</h1>

            @if (session('status'))
                @php
                    $statusMessages = [
                        'vacation-updated' => 'Отпуск успешно обновлен',
                        'selected-date-is-beyond-the-allowed-limit' =>
                            'Невозможно создать отпуск, так как он превышает максимальный доступный срок для данного сотрудника',
                        'vacation-cannot-overlap-working-hours' =>
                            'Невозможно создать отпуск, так как он пересекается с рабочими часами',
                    ];

                    $status = session('status');
                    $message = $statusMessages[$status] ?? 'Неизвестный статус.';
                    $isSuccess = str_contains($status, 'updated');
                @endphp

                <div class="{{ $isSuccess ? 'bg-green-500' : 'bg-red-500' }} p-4 rounded-lg mb-4">
                    {{ $message }}
                </div>
            @endif

            <form class="space-y-4" action="{{ route('dashboard.vacations.update', $vacation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="user_id" :value="__('Выберите пользователя')" />
                    <x-select id="user_id" name="user_id" class="mt-1 block w-full" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $vacation->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>

                <div>
                    <x-input-label for="start_date" :value="__('Дата начала')" />
                    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                        value="{{ $vacation->start_date }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                </div>

                <div>
                    <x-input-label for="end_date" :value="__('Дата окончания')" />
                    <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                        value="{{ $vacation->end_date }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                </div>

                <div>
                    <x-primary-button type="submit">Сохранить</x-primary-button>
                </div>
            </form>
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
