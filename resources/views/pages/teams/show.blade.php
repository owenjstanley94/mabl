<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <flux:heading level="1">{{ $team->name }}</flux:heading>
                    
                    <div class="mt-4">
                        <flux:heading level="2">Team Details</flux:heading>
                        <div class="mt-2">
                            <p><strong>League:</strong> {{ $team->league->name }}</p>
                            <p><strong>Court:</strong> {{ $team->court }}</p>
                            <p><strong>Game Night:</strong> {{ $team->tip_day }}</p>
                            <p><strong>Tip Time:</strong> {{ $team->tip_time }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <flux:heading level="2">Fixtures</flux:heading>
                        <p class="mb-2 text-sm text-gray-500">Use the filters and "This Week Only" button to view specific fixtures. The table now includes a status column.</p>
                        <livewire:fixtures-table :model="$team" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 