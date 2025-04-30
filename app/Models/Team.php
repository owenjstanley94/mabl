<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'short_name', 'slug', 'image', 'image_alt', 'image_caption', 'image_credit', 'league_id', 'court', 'tip_day', 'tip_time'];

    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
