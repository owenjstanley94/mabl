<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <flux:heading level="1">{{ $official->name }}</flux:heading>
                    
                    <div class="mt-4">
                        <flux:heading level="2">Official Details</flux:heading>
                        <div class="mt-2">
                            <p><strong>Role:</strong> {{ $official->role }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <flux:heading level="2">Assigned Games</flux:heading>
                        <livewire:fixtures-table :model="$official" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 