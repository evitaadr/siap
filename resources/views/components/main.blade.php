<x-app>
    <div class="min-h-screen flex h-screen w-full overflow-hidden bg-gray-100">

        <x-sidebar></x-sidebar>

        <main class="flex-1 p-6 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>
</x-app>
