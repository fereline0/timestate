<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <h1 class="text-lg font-bold">Редактирование рабочего времени</h1>

            @if (session('status'))
                @php
                    $statusMessages = [
                        'working-hours-successfully-updated' => 'Рабочее время успешно обновлено',
                        'time-overlaps-with-existing-working-hours' =>
                            'Время пересекается с уже существующими рабочими часами',
                        'working-time-cannot-be-updated-during-sick-leave' =>
                            'Невозможно обновить рабочее время, так как оно пересекается с открытым больничным',
                        'working-time-cannot-be-created-during-vacation' =>
                            'Невозможно создать рабочее время, так как вы в отпуске',
                    ];

                    $status = session('status');
                    $message = $statusMessages[$status] ?? 'Неизвестный статус.';
                    $isSuccess = str_contains($status, 'successfully');
                @endphp

                <div class="{{ $isSuccess ? 'bg-green-500' : 'bg-red-500' }} p-4 rounded-lg mb-4">
                    {{ $message }}
                </div>
            @endif

            <form class="space-y-4" action="{{ route('dashboard.working-times.update', $workingTime->id) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="user_id" :value="__('Выберите пользователя')" />
                    <x-select id="user_id" name="user_id" class="mt-1 block w-full" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $user->id == $workingTime->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>
                <div>
                    <x-input-label for="date" :value="__('Дата')" />
                    <x-text-input id="date" name="date" type="date" class="mt-1 block w-full"
                        value="{{ $workingTime->date }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('date')" />
                </div>
                <div>
                    <x-input-label for="begin" :value="__('Время начала')" />
                    <x-text-input id="begin" name="begin" type="time" class="mt-1 block w-full"
                        value="{{ $workingTime->begin }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('begin')" />
                </div>
                <div>
                    <x-input-label for="end" :value="__('Время окончания')" />
                    <x-text-input id="end" name="end" type="time" class="mt-1 block w-full"
                        value="{{ $workingTime->end }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('end')" />
                </div>
                <div>
                    <x-primary-button type="submit">Сохранить</x-primary-button>
                </div>
            </form>
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
