<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'league_id',
        'court',
        'tip_day',
        'tip_time',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            if (empty($team->slug)) {
                $team->slug = Str::slug($team->name);
            }
        });

        static::updating(function ($team) {
            if ($team->isDirty('name') && !$team->isDirty('slug')) {
                $team->slug = Str::slug($team->name);
            }
        });
    }

    public function setTipTimeAttribute($value)
    {
        if (!$value) {
            $this->attributes['tip_time'] = null;
            return;
        }

        // Convert time to 24-hour format
        $time = str_replace(['am', 'pm'], '', strtolower($value));
        $time = trim($time);
        
        // If it's a PM time and not 12, add 12 hours
        if (str_contains(strtolower($value), 'pm') && !str_starts_with($time, '12')) {
            $time = date('H:i', strtotime($time . ' +12 hours'));
        } else {
            // If it's AM and 12, make it 00
            if (str_contains(strtolower($value), 'am') && str_starts_with($time, '12')) {
                $time = '00:' . substr($time, 3);
            }
            // Otherwise just format it
            $time = date('H:i', strtotime($time));
        }
        
        $this->attributes['tip_time'] = $time;
    }

    public function getTipTimeAttribute($value)
    {
        if (!$value) return null;
        return date('H:i', strtotime($value));
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function homeFixtures()
    {
        return $this->hasMany(Fixture::class, 'home_team_id');
    }

    public function awayFixtures()
    {
        return $this->hasMany(Fixture::class, 'away_team_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getLeagueStats()
    {
        $homeGames = $this->homeFixtures()
            ->whereNotNull('home_team_score')
            ->whereNotNull('away_team_score')
            ->get();
        
        $awayGames = $this->awayFixtures()
            ->whereNotNull('home_team_score')
            ->whereNotNull('away_team_score')
            ->get();

        $stats = [
            'played' => 0,
            'won' => 0,
            'lost' => 0,
            'home_won' => 0,
            'home_lost' => 0,
            'away_won' => 0,
            'away_lost' => 0,
            'points' => 0
        ];

        // Process home games
        foreach ($homeGames as $game) {
            $stats['played']++;
            if ($game->home_team_score > $game->away_team_score) {
                $stats['won']++;
                $stats['home_won']++;
                $stats['points'] += 2; // 1 for playing + 1 for winning
            } else {
                $stats['lost']++;
                $stats['home_lost']++;
                $stats['points'] += 1; // 1 for playing
            }
        }

        // Process away games
        foreach ($awayGames as $game) {
            $stats['played']++;
            if ($game->away_team_score > $game->home_team_score) {
                $stats['won']++;
                $stats['away_won']++;
                $stats['points'] += 2; // 1 for playing + 1 for winning
            } else {
                $stats['lost']++;
                $stats['away_lost']++;
                $stats['points'] += 1; // 1 for playing
            }
        }

        return $stats;
    }
}
