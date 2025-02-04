<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <x-card class="space-y-4">
            <h1 class="text-lg font-bold">Ваше рабочее время</h1>

            @if (session('status'))
            @php
            $statusMessages = [
            'working-time-successfully-started' => 'Рабочее время успешно начато',
            'working-time-successfully-ended' => 'Рабочее время успешно завершено',
            'working-time-not-started' => 'Рабочее время не было начато',
            'working-time-cannot-be-started-during-sick-leave' =>
            'Невозможно начать рабочее время, так как вы на больничном',
            'working-time-cannot-be-started-during-vacation' =>
            'Невозможно начать рабочее время, так как вы в отпуске',
            ];

            $status = session('status');
            $message = $statusMessages[$status] ?? 'Неизвестный статус.';
            $isSuccess = str_contains($status, 'successfully');
            @endphp

            <div class="{{ $isSuccess ? 'bg-green-500' : 'bg-red-500' }} p-4 rounded-lg mb-4">
                {{ $message }}
            </div>
            @endif

            @if ($workingTimes->isEmpty())
            <p>У вас нет записей о рабочем времени</p>
            @else
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Дата</th>
                        <th class="py-2 px-4 border-b">Начало</th>
                        <th class="py-2 px-4 border-b">Конец</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workingTimes as $workingTime)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $workingTime->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $workingTime->date }}</td>
                        <td class="py-2 px-4 border-b">{{ $workingTime->begin }}</td>
                        <td class="py-2 px-4 border-b">{{ $workingTime->end ?? 'Не завершен' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $workingTimes->links() }}
            @endif

            @if ($unfinishedWorkingTime)
            <x-danger-button x-data=""
                x-on:click="$dispatch('open-modal', 'confirm-end-working-time')">Завершить рабочее
                время</x-danger-button>

            <x-modal name="confirm-end-working-time" focusable>
                <form method="POST" action="{{ route('working-times.end') }}" class="p-6">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Вы уверены, что хотите завершить рабочее время?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('После завершения рабочее время будет зафиксировано.') }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Отмена') }}
                        </x-secondary-button>

                        <x-danger-button class="ms-3">
                            {{ __('Завершить') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
            @else
            <form method="POST" action="{{ route('working-times.start') }}">
                @csrf
                <x-primary-button type="submit">Отметить приход</x-primary-button>
            </form>
            @endif
        </x-card>
    </div>
</x-app-layout>