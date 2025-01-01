<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <h1 class="text-lg font-bold">Создание рабочего времени</h1>

            @if (session('status'))
                @php
                    $statusMessages = [
                        'working-hours-successfully-created' => 'Рабочее время успешно создано',
                        'time-overlaps-with-existing-working-hours' =>
                            'Время пересекается с уже существующими рабочими часами',
                        'working-time-cannot-be-created-during-sick-leave' =>
                            'Невозможно создать рабочее время, так как вы на больничном',
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

            <form class="space-y-4" action="{{ route('dashboard.working-times.store') }}" method="POST">
                @csrf
                <div>
                    <x-input-label for="user_id" :value="__('Выберите пользователя')" />
                    <x-select id="user_id" name="user_id" class="mt-1 block w-full" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>
                <div>
                    <x-input-label for="date" :value="__('Дата')" />
                    <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('date')" />
                </div>
                <div>
                    <x-input-label for="begin" :value="__('Время начала')" />
                    <x-text-input id="begin" name="begin" type="time" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('begin')" />
                </div>
                <div>
                    <x-input-label for="end" :value="__('Время окончания')" />
                    <x-text-input id="end" name="end" type="time" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('end')" />
                </div>
                <div>
                    <x-primary-button type="submit">Создать</x-primary-button>
                </div>
            </form>
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
