<x-app-layout>
    <x-dashboard-layout>
        <x-card class="space-y-4">
            <h1 class="text-lg font-bold">Редактирование больничного дня</h1>

            @if (session('status'))
                @php
                    $statusMessages = [
                        'sick-leave-updated' => 'Больничный день успешно обновлен',
                        'time-overlaps-with-existing-sick-leave' =>
                            'Указанные даты пересекаются с уже существующим больничным днем',
                        'time-overlaps-with-existing-working-time' =>
                            'Указанные даты пересекаются с существующим рабочим временем',
                    ];

                    $status = session('status');
                    $message = $statusMessages[$status] ?? 'Неизвестный статус';
                    $isSuccess = str_contains($status, 'updated') || str_contains($status, 'created');
                @endphp

                <div class="{{ $isSuccess ? 'bg-green-500' : 'bg-red-500' }} p-4 rounded mb-4">
                    {{ $message }}
                </div>
            @endif

            <form class="space-y-4" action="{{ route('dashboard.sick-leaves.update', $sickLeave->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <x-input-label for="user_id" :value="__('Выберите сотрудника')" />
                    <x-select id="user_id" name="user_id" class="mt-1 block w-full" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $user->id == $sickLeave->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>

                <div>
                    <x-input-label for="start_date" :value="__('Дата начала')" />
                    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                        value="{{ $sickLeave->start_date }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                </div>

                <div>
                    <x-input-label for="end_date" :value="__('Дата окончания')" />
                    <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                        value="{{ $sickLeave->end_date }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                </div>

                <div>
                    <x-primary-button type="submit">Сохранить изменения</x-primary-button>
                </div>
            </form>
        </x-card>
    </x-dashboard-layout>
</x-app-layout>
