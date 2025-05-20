<?php

namespace App\Console\Commands;

use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateTeamSlugs extends Command
{
    protected $signature = 'teams:generate-slugs';
    protected $description = 'Generate slugs for all teams';

    public function handle()
    {
        $teams = Team::all();
        $count = 0;

        foreach ($teams as $team) {
            if (empty($team->slug)) {
                $team->slug = Str::slug($team->name);
                $team->save();
                $count++;
            }
        }

        $this->info("Generated slugs for {$count} teams.");
    }
} 