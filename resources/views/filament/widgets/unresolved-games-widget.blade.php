<x-filament::widget>
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">Unresolved Games (Contested or Overdue)</h2>
        @if($games->isEmpty())
            <p class="text-gray-500">No unresolved games found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">League</th>
                            <th class="px-4 py-2 text-left">Home Team</th>
                            <th class="px-4 py-2 text-left">Away Team</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($games as $game)
                            <tr class="@if($game->status === 'contested') bg-orange-50 @elseif($game->date < now()->subDays(3) && $game->status !== 'completed') bg-red-50 @endif">
                                <td class="px-4 py-2">{{ $game->date->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">{{ $game->league->name }}</td>
                                <td class="px-4 py-2">{{ $game->homeTeam->name }}</td>
                                <td class="px-4 py-2">{{ $game->awayTeam->name }}</td>
                                <td class="px-4 py-2 font-semibold">{{ ucfirst($game->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::card>
</x-filament::widget> 