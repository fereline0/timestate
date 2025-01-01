<x-app-layout>
    <div class="py-12">
        <div class="px-4 grid md:grid-cols-[repeat(auto-fill,minmax(480px,1fr))] gap-2">
            <x-card>
                @include('profile.partials.update-profile-information-form')
            </x-card>

            <x-card>
                @include('profile.partials.update-password-form')
            </x-card>
        </div>
    </div>
</x-app-layout>
