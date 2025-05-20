<flux:container>
    <flux:card>
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <flux:heading size="xl">{{ $official->name }}</flux:heading>
                </div>
                <div class="flex items-center gap-4">
                    <flux:badge size="lg" inset="top bottom">{{ $official->role }}</flux:badge>
                    <flux:badge size="sm" color="gray" inset="top bottom">License: {{ $official->licence_number ?? 'N/A' }}</flux:badge>
                </div>
            </div>

            <flux:card>
                <flux:heading size="lg" class="mb-4">Assigned Games</flux:heading>
                @if($games->isEmpty())
                    <flux:text size="sm">No games assigned</flux:text>
                @else
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Date</flux:table.column>
                            <flux:table.column>Home Team</flux:table.column>
                            <flux:table.column>Away Team</flux:table.column>
                            <flux:table.column>League</flux:table.column>
                            <flux:table.column>Role</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach($games as $fixture)
                                <flux:table.row :key="$fixture->id">
                                    <flux:table.cell>
                                        <flux:text size="sm">
                                            {{ $fixture->date ? $fixture->date->format('d-m-y') : 'No date set' }}
                                        </flux:text>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:text size="sm">{{ $fixture->homeTeam->name }}</flux:text>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:text size="sm">{{ $fixture->awayTeam->name }}</flux:text>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:badge size="sm" inset="top bottom">{{ $fixture->league->name }}</flux:badge>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:badge size="sm" color="blue" inset="top bottom">{{ $fixture->official_role }}</flux:badge>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                @endif
            </flux:card>
        </div>
    </flux:card>
</flux:container>
