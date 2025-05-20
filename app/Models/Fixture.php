<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $fillable = [
        'league_id',
        'home_team_id',
        'away_team_id',
        'crew_chief_id',
        'referee_1_id',
        'referee_2_id',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function league()
    {
        return $this->belongsTo(\App\Models\League::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(\App\Models\Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(\App\Models\Team::class, 'away_team_id');
    }

    public function crewChief()
    {
        return $this->belongsTo(\App\Models\Official::class, 'crew_chief_id');
    }

    public function referee1()
    {
        return $this->belongsTo(\App\Models\Official::class, 'referee_1_id');
    }

    public function referee2()
    {
        return $this->belongsTo(\App\Models\Official::class, 'referee_2_id');
    }

    public function getTipDayAttribute()
    {
        return $this->homeTeam ? $this->homeTeam->tip_day : null;
    }

    public function getTipTimeAttribute()
    {
        return $this->homeTeam ? $this->homeTeam->tip_time : null;
    }
}
