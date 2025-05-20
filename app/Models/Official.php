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
            $baseSlug = \Illuminate\Support\Str::slug($official->name);
            $slug = $baseSlug;
            $i = 2;
            while (\App\Models\Official::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }
            $official->slug = $slug;
        });

        static::updating(function ($official) {
            if ($official->isDirty('name') && !$official->isDirty('slug')) {
                $baseSlug = \Illuminate\Support\Str::slug($official->name);
                $slug = $baseSlug;
                $i = 2;
                while (\App\Models\Official::where('slug', $slug)->where('id', '!=', $official->id)->exists()) {
                    $slug = $baseSlug . '-' . $i++;
                }
                $official->slug = $slug;
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
