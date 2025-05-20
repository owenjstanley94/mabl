<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Official extends Model
{
    protected $fillable = ['name', 'email', 'licence_number', 'role', 'level', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($official) {
            if (empty($official->slug)) {
                $official->slug = Str::slug($official->name);
            }
        });

        static::updating(function ($official) {
            if ($official->isDirty('name') && !$official->isDirty('slug')) {
                $official->slug = Str::slug($official->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function crewChiefGames()
    {
        return $this->hasMany(\App\Models\Fixture::class, 'crew_chief_id');
    }

    public function referee1Games()
    {
        return $this->hasMany(\App\Models\Fixture::class, 'referee_1_id');
    }

    public function referee2Games()
    {
        return $this->hasMany(\App\Models\Fixture::class, 'referee_2_id');
    }
}
