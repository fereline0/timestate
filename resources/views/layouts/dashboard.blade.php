<div class="space-y-4 px-4 py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Панель управления') }}
        </h2>
    </x-slot>

    <div class="flex gap-4 overflow-y-auto">
        @foreach ($links as $link)
            <x-link class="whitespace-nowrap" :href="route($link['url'])" :active="request()->routeIs($link['url'])">
                <x-card>
                    {{ $link['name'] }}
                </x-card>
            </x-link>
        @endforeach
    </div>
    <div>
        {{ $slot }}
    </div>
</div>
