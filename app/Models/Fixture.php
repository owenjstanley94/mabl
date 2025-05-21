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
        'home_team_score',
        'away_team_score',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fixture) {
            if (empty($fixture->tip_time) && $fixture->homeTeam) {
                $fixture->tip_time = $fixture->homeTeam->tip_time;
            }
        });
    }

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

    public function getTipTimeAttribute($value)
    {
        if (!$this->homeTeam) {
            return null;
        }
        return $this->homeTeam->tip_time;
    }

    public function setTipTimeAttribute($value)
    {
        if (!$value) {
            $this->attributes['tip_time'] = null;
            return;
        }
        $this->attributes['tip_time'] = date('H:i', strtotime($value));
    }

    public function getStatusAttribute($value)
    {
        // If scores are present, the game is completed
        if (!is_null($this->home_team_score) && !is_null($this->away_team_score)) {
            return 'completed';
        }
        
        return $value;
    }

    public function getHomeTeamTipTimeAttribute()
    {
        return $this->homeTeam ? $this->homeTeam->tip_time : null;
    }
}
